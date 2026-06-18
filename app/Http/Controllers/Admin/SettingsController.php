<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use App\Models\Contact;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', ['profile' => BusinessProfile::firstOrFail(), 'contact' => Contact::firstOrFail()]);
    }

    public function update(Request $request, ImageUploadService $images)
    {
        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:180'], 'description' => ['required', 'string', 'max:3000'], 'history' => ['nullable', 'string', 'max:3000'],
            'address' => ['required', 'string', 'max:1000'], 'operational_hours' => ['required', 'string', 'max:180'], 'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'whatsapp' => ['required', 'string', 'max:30'], 'instagram' => ['nullable', 'url', 'max:1000'], 'email' => ['nullable', 'email', 'max:180'], 'maps_link' => ['nullable', 'url', 'max:2000'], 'shopee_link' => ['nullable', 'url', 'max:2000'],
        ]);
        $profile = BusinessProfile::firstOrFail();
        if ($request->hasFile('logo')) {
            $images->delete($profile->logo);
            $data['logo'] = $images->store($request->file('logo'), 'profile');
        }
        $profile->update(collect($data)->only(['business_name', 'description', 'history', 'address', 'operational_hours', 'logo'])->all());
        Contact::firstOrFail()->update(collect($data)->only(['whatsapp', 'instagram', 'email', 'maps_link', 'shopee_link'])->all());

        return back()->with('success', 'Profil, kontak, dan pengaturan Shopee berhasil disimpan.');
    }
}
