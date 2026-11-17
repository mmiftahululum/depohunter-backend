<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateGlobalSettingRequest;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = GlobalSetting::all();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GlobalSetting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGlobalSettingRequest $request, GlobalSetting $setting)
    {
        $setting->update([
            'value' => $request->value,
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', "Pengaturan '{$setting->label}' berhasil diperbarui!");
    }
}
