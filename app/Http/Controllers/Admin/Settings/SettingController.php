<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\SettingRequest;
use App\Interfaces\Settings\SettingInterface;

class SettingController extends Controller
{
    private $settingRepoInterface;

    public function __construct(SettingInterface $settingRepoInterface)
    {
        $this->settingRepoInterface = $settingRepoInterface;
    }
    
    public function index()
    {
        return $this->settingRepoInterface->index();
    }

    public function get_setting_data()
    {
        return $this->settingRepoInterface->get_setting_data();
    }

    public function edit()
    {
        return $this->settingRepoInterface->edit();
    }

    public function update_setting_data(SettingRequest $request)
    {
        return $this->settingRepoInterface->update_setting_data($request);
    }
}
