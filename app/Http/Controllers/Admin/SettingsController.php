<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\SettingsTrait;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use SettingsTrait;

    public function update(Request $request)
    {
        $this->updateSettings($request);

        if ($request->wantsJson()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Settings Updated Successfully',
            ], 200);
        }

        return redirect()->back()->with('success', __('Settings Updated Successfully.'));
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
                'status'  => 'success',
                'message' => 'Settings Updated Successfully',
            ], 200);
        }

        return redirect()->back()->withSuccess(__('Settings Updated Successfully.'));
    }

    public function envkeyUpdate(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Settings Updated Successfully',
            ], 200);
        }

        return back()->withSuccess('Settings updated successfully');
    }
}
