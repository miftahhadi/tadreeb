<?php 

namespace App\Services\Admin;

use App\Settings;

class SettingService
{

    protected $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function allSettings()
    {
        return $this->settings->all();
    }

    public function setAppName($name)
    {
        return $this->settings->put('app_name', $name);
    }
}