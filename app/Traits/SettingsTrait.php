<?php

namespace App\Traits;

use App\Models\Setting;
use App\Models\SystemSetting;
use Cache;
use Illuminate\Http\Request;
use Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

trait SettingsTrait
{
    public function updateSettings(Request $request)
    {
        $input = $request->except('favicon', 'logo', '_token');

        if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $imageName = Str::random(5).'-favicon.png';
            $image->move(public_path('uploads'), $imageName);
            $input['favicon'] = $imageName;
        }
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = Str::random(5).'-logo.png';
            $image->move(public_path('uploads'), $imageName);
            $input['logo'] = $imageName;
        }

        $setting = Setting::first();
        $setting->update($input);
        Cache::put('Settings', $setting, 30);

        return $setting;
    }
    /**
     * Creates a backup of the .env file before modification
     *
     * @return bool
     */
    private function backupEnvFile()
    {
        $envFile = app()->environmentFilePath();
        $backupFile = $envFile . '.backup_' . date('Y-m-d_H-i-s');

        if (file_exists($envFile)) {
            return copy($envFile, $backupFile);
        }

        return false;
    }

    /**
     * Create a timestamped backup of the .env file before modifications
     *
     * @return bool
     */
    private function backupEnvFile(): bool
    {
        $path       = app()->environmentFilePath();
        $backupPath = "{$path}.backup_" . date('Y-m-d_H-i-s');
        if (file_exists($path)) {
            return copy($path, $backupPath);
        }
        return false;
    }

    public function overWriteEnvFile($key, $value): bool
    {
        // Enforce valid key format
        if (! preg_match('/^[A-Z][A-Z0-9_]*$/', $key)) {
            Log::warning("Attempt to write invalid env key: {$key}");
            return false;
        }

        // Backup before overwriting
        $this->backupEnvFile();

        $path   = app()->environmentFilePath();
        $handle = fopen($path, 'r+');
        if (! $handle || ! flock($handle, LOCK_EX)) {
            Log::error("Unable to lock .env for writing");
            return false;
        }

        // Read existing content
        $content = stream_get_contents($handle);
        $lines   = explode("\n", $content);
        $found   = false;
        $pattern = "/^{$key}=/";

        foreach ($lines as &$line) {
            if (preg_match($pattern, $line)) {
                $safe = addslashes($value);
                $line = "{$key}=\"{$safe}\"";
                $found = true;
                break;
            }
        }
        if (! $found) {
            $safe      = addslashes($value);
            $lines[]   = "{$key}=\"{$safe}\"";
        }

        // Write back and release lock
        ftruncate($handle, 0);
        rewind($handle);
        fwrite($handle, implode("\n", $lines));
        flock($handle, LOCK_UN);
        fclose($handle);

        // Clear opcode cache if present
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }

        return true;
    }
            Log::error("Could not open the .env file for writing");
            return false;
        }

        // Acquire exclusive lock
        if (!flock($handle, LOCK_EX)) {
            fclose($handle);
            Log::error("Could not acquire an exclusive lock on the .env file");
            return false;
        }

        // Read entire file under lock
        $content = '';
        rewind($handle);
        while (!feof($handle)) {
            $content .= fread($handle, 8192);
        }

        // Split lines and prepare update
        $lines = explode("\n", $content);
        $pattern = "/^{$key}=.*/";
        $found = false;

        foreach ($lines as &$line) {
            if (preg_match($pattern, $line)) {
                $sanitized = addslashes(trim($value));
                $line = "{$key}=\"{$sanitized}\"";
                $found = true;
                break;
            }
        }

        if (! $found) {
            $sanitized = addslashes(trim($value));
            $lines[] = "{$key}=\"{$sanitized}\"";
        }

        // Write back atomically
        ftruncate($handle, 0);
        rewind($handle);
        fwrite($handle, implode("\n", $lines));

        // Release lock and close
        flock($handle, LOCK_UN);
        fclose($handle);

        // Reset opcache if available
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }

        return true;
    }

    public function systemSetUpdate($request)
    {
        $setting = SystemSetting::where('name', $request->name)->first();
        if ($setting != null) {
            $setting->value = $request->value;
            $setting->save();
        } else {
            $setting = new SystemSetting;
            $setting->name = $request->name;
            $setting->value = $request->value;
            $setting->save();
        }
        $settings = SystemSetting::all();
        Cache::put('SystemSettings', $settings);

        return 1;
    }

    public function updateSystemSettings(Request $request)
    {
        foreach ($request->types as $key => $type) {
            if ($type == 'site_name') {
                $this->overWriteEnvFile('APP_NAME', $request[$type]);
            } else {
                $sys_settings = SystemSetting::where('name', $type)->first();

                if ($sys_settings != null) {
                    if (gettype($request[$type]) == 'array') {
                        $sys_settings->value = json_encode($request[$type]);
                    } else {
                        $sys_settings->value = $request[$type];
                    }
                    $sys_settings->save();
                } else {
                    $sys_settings = new SystemSetting;
                    $sys_settings->name = $type;
                    if (gettype($request[$type]) == 'array') {
                        $sys_settings->value = json_encode($request[$type]);
                    } else {
                        $sys_settings->value = $request[$type];
                    }
                    $sys_settings->save();
                }

                $settings = SystemSetting::all();
                Cache::put('SystemSettings', $settings);
            }
        }

    }
}
