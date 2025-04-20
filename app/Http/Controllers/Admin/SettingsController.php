
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\SettingsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    use SettingsTrait;

    /**
     * Allowed environment keys for updates via the admin interface
     *
     * @var string[]
     */
    protected $allowedEnvKeys = [
        'MAIL_FROM_NAME',
        'MAIL_FROM_ADDRESS',
        'MAIL_MAILER',
        'MAIL_HOST',
        'MAIL_PORT',
        'MAIL_USERNAME',
        'MAIL_PASSWORD',
        'MAIL_ENCRYPTION',
        'PAYSTACK_PUBLIC_KEY',
        'PAYSTACK_SECRET_KEY',
        'FLUTTERWAVE_PUBLIC_KEY',
        'FLUTTERWAVE_SECRET_KEY',
        'PAYPAL_CLIENT_ID',
        'PAYPAL_CLIENT_SECRET',
        'PAYPAL_MODE',
        'CRYPTOMUS_PUBLIC_KEY',
        'CRYPTOMUS_SECRET_KEY',
    ];

    public function update(Request $request)
    {
        $this->updateSettings($request);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Settings Updated Successfully',
            ], 200);
        }

        return back()->with('success', __('Settings Updated Successfully.'));
    }

    public function systemUpdate(Request $request)
    {
        $this->systemSetUpdate($request);

        return 1;
    }

    public function storeSettings(Request $request)
    {
        $this->updateSystemSettings($request);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Settings Updated Successfully',
            ], 200);
        }

        return back()->withSuccess(__('Settings Updated Successfully.'));
    }

    public function envkeyUpdate(Request $request)
    {
        // Validate request payload
        $validator = Validator::make($request->all(), [
            'types' => 'required|array',
            'types.*' => 'required|string',
            'values' => 'required|array',
            'values.*' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => $errors,
                ], 422);
            }

            return back()->withErrors($errors)->withInput();
        }

        foreach ($request->types as $key => $type) {
            // skip keys not in our whitelist
            if (! in_array($type, $this->allowedEnvKeys, true)) {
                continue;
            }
            $value = $request->values[$key] ?? null;
            $this->overWriteEnvFile($type, $value);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Settings Updated Successfully',
            ], 200);
        }

        return back()->withSuccess('Settings updated successfully');
    }
}
