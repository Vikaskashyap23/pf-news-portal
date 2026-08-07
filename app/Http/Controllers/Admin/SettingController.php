<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();

        return view('Admin.settings.edit', compact('setting'));
    }

    public function index()
    {

       $setting = Setting::first();

       return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'twitter' => 'nullable|url',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        $setting->fill([
            'site_name' => $request->site_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,

            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'twitter' => $request->twitter,

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        $setting->save();

        return redirect()
            ->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}