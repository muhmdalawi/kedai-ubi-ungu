@extends('layouts.admin')
@section('heading','Profil, Kontak & Shopee')
@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}" class="grid gap-7 xl:grid-cols-2">@csrf @method('PUT')
    <section class="card p-6">
        <h2 class="text-xl font-black">Profil Usaha</h2>
        <div class="mt-6 space-y-5">
            <div><label class="label">Nama usaha</label><input class="field" name="business_name" value="{{ old('business_name',$profile->business_name) }}" required></div>
            <div>
                <span class="label">Logo</span>
                <label for="logo" class="group flex cursor-pointer items-center gap-4 rounded-2xl border-2 border-dashed border-ube-200 bg-ube-50/60 p-4 hover:border-ube-500 hover:bg-ube-50">
                    <span class="relative shrink-0">
                        <img data-logo-preview src="{{ $profile->logo_url }}" alt="Logo {{ $profile->business_name }}" class="h-24 w-24 rounded-2xl border border-ube-100 bg-white object-cover shadow-sm">
                        <span class="absolute inset-0 grid place-items-center rounded-2xl bg-ube-950/65 text-center text-xs font-extrabold text-white opacity-0 transition group-hover:opacity-100">Ganti<br>Logo</span>
                    </span>
                    <span>
                        <span class="inline-flex rounded-full bg-ube-700 px-5 py-2.5 text-sm font-extrabold text-white shadow-md group-hover:bg-ube-900">Pilih Logo Baru</span>
                        <span data-logo-filename class="mt-2 block text-xs font-semibold text-stone-500">Belum ada file baru dipilih</span>
                    </span>
                </label>
                <input data-logo-input id="logo" class="sr-only" type="file" name="logo" accept="image/png,image/jpeg,image/webp">
                <p class="mt-2 text-xs text-stone-500">PNG, JPG, atau WebP. Maksimal 4 MB. Logo akan langsung dipakai di website dan panel admin.</p>
                @error('logo')<p class="mt-2 text-sm font-bold text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div><label class="label">Deskripsi</label><textarea class="field" name="description" rows="4" required>{{ old('description',$profile->description) }}</textarea></div>
            <div><label class="label">Sejarah singkat</label><textarea class="field" name="history" rows="4">{{ old('history',$profile->history) }}</textarea></div>
            <div><label class="label">Alamat</label><textarea class="field" name="address" rows="3" required>{{ old('address',$profile->address) }}</textarea></div>
            <div><label class="label">Jam operasional</label><input class="field" name="operational_hours" value="{{ old('operational_hours',$profile->operational_hours) }}" required></div>
        </div>
    </section>
    <section class="space-y-7">
        <div class="card p-6">
            <h2 class="text-xl font-black">Kontak & Sosial Media</h2>
            <div class="mt-6 space-y-5">
                <div><label class="label">WhatsApp</label><input class="field" name="whatsapp" value="{{ old('whatsapp',$contact->whatsapp) }}" required></div>
                <div><label class="label">Instagram</label><input class="field" type="url" name="instagram" value="{{ old('instagram',$contact->instagram) }}"></div>
                <div><label class="label">Email</label><input class="field" type="email" name="email" value="{{ old('email',$contact->email) }}"></div>
                <div><label class="label">Google Maps</label><input class="field" type="url" name="maps_link" value="{{ old('maps_link',$contact->maps_link) }}"></div>
                <div><label class="label">Link Shopee utama</label><input class="field" type="url" name="shopee_link" value="{{ old('shopee_link',$contact->shopee_link) }}"></div>
            </div>
        </div>
        <div class="card p-6">
            <h2 class="font-black">QR Code Shopee</h2>
            <div class="mt-4 inline-block rounded-2xl bg-white p-3">{!! QrCode::size(160)->generate($contact->shopee_link ?: route('home')) !!}</div>
            <p class="mt-3 text-xs text-stone-400">QR diperbarui mengikuti link Shopee utama.</p>
        </div><button class="btn-primary w-full">Simpan Pengaturan</button>
    </section>
</form>
@endsection
