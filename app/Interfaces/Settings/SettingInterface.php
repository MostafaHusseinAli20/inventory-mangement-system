<?php

namespace App\Interfaces\Settings;

use App\Http\Requests\Admin\Settings\SettingRequest;

interface SettingInterface
{
    public function index();
    public function get_setting_data();
    public function edit();
    public function update_setting_data(SettingRequest $request);
}
