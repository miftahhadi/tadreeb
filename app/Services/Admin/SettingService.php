<?php 

namespace App\Services\Admin;

use App\Settings;

class SettingService
{

    public function allSettings(Settings $settings)
    {
        return $settings->all();
    }
}