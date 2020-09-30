<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    protected $settingService;
    
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        return view('admin.setting.index', [
            'settings' => $this->settingService->allSettings()
        ]);
    }
}
