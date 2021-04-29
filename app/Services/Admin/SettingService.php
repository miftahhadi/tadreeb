<?php 

namespace App\Services\Admin;

use App\Http\Requests\StoreSettingRequest;
use App\Settings;
use Intervention\Image\ImageManagerStatic as Image;

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

    public function store(StoreSettingRequest $data)
    {
        // Save the appName
        $this->setAppName($data['app_name']);   

        // Save image logo
        if ($data->file('logo')) {
            $this->setAppLogo($data);
        }

        return $this;

    }

    public function setAppLogo(StoreSettingRequest $data, $disk = 'public')
    {
        $extension = $data->file('logo')->extension();

        $path = $data->file('logo')->storeAs('/images', 'logo.' . $extension, $disk);

        return $this->settings->put('app_logo', '/' . $path);
    }
}