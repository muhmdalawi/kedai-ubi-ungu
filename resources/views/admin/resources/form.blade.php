@extends('layouts.admin')
@section('heading',($record->exists?'Edit ':'Tambah ').$definition['label'])
@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $record->exists ? route('admin.resources.update',[$resource,$record->id]) : route('admin.resources.store',$resource) }}" class="card mx-auto max-w-4xl p-6 sm:p-8">
@csrf @if($record->exists) @method('PUT') @endif
@if($errors->any())<div class="mb-6 rounded-2xl bg-rose-50 p-4 text-sm text-rose-700"><strong>Periksa kembali formulir:</strong><ul class="mt-2 list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="grid gap-6 sm:grid-cols-2">
@foreach($definition['fields'] as $name=>$field)
<div class="{{ in_array($field['type'],['textarea','multiselect'])?'sm:col-span-2':'' }}">
    @if($field['type']==='boolean')
        <label class="flex items-center gap-3 rounded-2xl border border-stone-200 p-4"><input type="checkbox" name="{{ $name }}" value="1" class="h-5 w-5 accent-ube-700" @checked(old($name,$record->{$name} ?? false))><span class="font-bold">{{ $field['label'] }}</span></label>
    @else
        <label class="label" for="{{ $name }}">{{ $field['label'] }}</label>
        @if($field['type']==='textarea')
            <textarea class="field" id="{{ $name }}" name="{{ $name }}" rows="5">{{ old($name,$record->{$name}) }}</textarea>
        @elseif($field['type']==='select')
            <select class="field" id="{{ $name }}" name="{{ $name }}"><option value="">Pilih...</option>@foreach($options[$name] as $option)<option value="{{ $option->id }}" @selected(old($name,$record->{$name})==$option->id)>{{ $option->{$field['option']} }}</option>@endforeach</select>
        @elseif($field['type']==='select_static')
            <select class="field" id="{{ $name }}" name="{{ $name }}">@foreach($field['options'] as $value=>$label)<option value="{{ $value }}" @selected(old($name,$record->{$name})==$value)>{{ $label }}</option>@endforeach</select>
        @elseif($field['type']==='multiselect')
            @php($selected=collect(old($name,$record->exists?$record->{$field['relation']}->pluck('id')->all():[])))
            <select class="field min-h-40" id="{{ $name }}" name="{{ $name }}[]" multiple>@foreach($options[$name] as $option)<option value="{{ $option->id }}" @selected($selected->contains($option->id))>{{ $option->{$field['option']} }}</option>@endforeach</select><p class="mt-2 text-xs text-stone-400">Gunakan Ctrl/Cmd untuk memilih beberapa opsi.</p>
        @elseif($field['type']==='image')
            @if($record->{$name})@php($url=method_exists($record,'imageUrl')?$record->imageUrl($record->{$name}):asset('storage/'.$record->{$name}))<img src="{{ $url }}" class="mb-3 h-28 rounded-2xl object-cover">@endif
            <input class="field" id="{{ $name }}" name="{{ $name }}" type="file" accept="image/jpeg,image/png,image/webp"><p class="mt-2 text-xs text-stone-400">Maks. 4 MB. Otomatis dikompresi ke WebP.</p>
        @else
            <input class="field" id="{{ $name }}" name="{{ $name }}" type="{{ $field['type'] }}" value="{{ old($name,($record->{$name} instanceof \DateTimeInterface)?$record->{$name}->format('Y-m-d'):$record->{$name}) }}" @if($field['type']==='number') min="0" @endif>
        @endif
    @endif
</div>
@endforeach
</div>
<div class="mt-8 flex justify-end gap-3"><a href="{{ route('admin.resources.index',$resource) }}" class="btn-secondary">Batal</a><button class="btn-primary">Simpan</button></div>
</form>
@endsection
