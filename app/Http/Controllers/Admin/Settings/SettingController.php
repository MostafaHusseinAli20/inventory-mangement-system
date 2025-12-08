<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\SettingRequest;
use App\Interfaces\Settings\SettingInterface;

class SettingController extends Controller
{
    private $settingInterface;

    public function __construct(SettingInterface $settingInterface)
    {
        $this->settingInterface = $settingInterface;
    }
    
    public function index()
    {
        return $this->settingInterface->index();
    }

    public function get_setting_data()
    {
        return $this->settingInterface->get_setting_data();
    }

    public function edit()
    {
        return $this->settingInterface->edit();
    }

    public function update_setting_data(SettingRequest $request)
    {
        return $this->settingInterface->update_setting_data($request);
    }
}
