<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Setting;
use App\Http\Controllers\BaseController;
use App\SystemSetting;

class SettingsController extends BaseController
{
    public function getSettings(Request $request){

        $user = $request->user();
        $count = $user->settings()->count();
        if(!$count > 0){
            $user->settings()->create(['receive_login_notifications' => true]);
        }
        $settings = $user->settings;
        return $this->sendResponse($settings, 'User preferences' );

    }

    public function toggleSetting(Request $request){

        $user = $request->user();
        $field = $request->field;

        $oldValue = $user->settings()->value($field);

        $user->settings()->updateOrCreate(['user_id' => $user->id], [$field => !$oldValue]);

        return $this->sendResponse('success', 'success');

    }
    public function toggleSystemSetting(Request $request){

        $settings = SystemSetting::first();

        $field = $request->field;

        $oldValue = $settings->value($field);

        $settings->update([$field => !$oldValue]);

        return $this->sendResponse('success', 'success');

    }

    public function getSystemSettings(Request $request){

        $settings = SystemSetting::firstOrCreate(['id' => 1]);

        return $this->sendResponse($settings, 'system settings');

    }
}
