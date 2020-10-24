<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Services\Admin\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    protected $service;
    
    public function __construct(SettingService $settingService)
    {
        $this->service = $settingService;
    }

    public function index()
    {
        return view('admin.setting.index', [
            'settings' => $this->service->allSettings()
        ]);
    }

    public function store(StoreSettingRequest $request)
    {
        $this->service->store($request);

        return redirect(route('admin.setting.index'))->with('status', 'Pengaturan berhasil disimpan');
    }
}
