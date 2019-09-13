<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Setting;
use App\Http\Controllers\BaseController;

class SettingsController extends BaseController
{
    public function getSettings(Request $request){

        $user = $request->user();
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
}
