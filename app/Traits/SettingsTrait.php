<?php

namespace App\Traits;

use App\Models\Setting;
use App\Models\SystemSetting;
use Cache;
use Illuminate\Http\Request;
use Str;

trait SettingsTrait
{
    public function updateSettings(Request $request)
    {
        $input = $request->all();

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

    public function overWriteEnvFile($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
                file_put_contents($path, str_replace(
                    $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                ));
            } else {
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }
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
