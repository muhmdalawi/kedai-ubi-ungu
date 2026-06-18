@extends('layouts.admin')
@section('heading',$definition['label'])
@section('content')
<div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center"><form class="flex gap-2"><input class="field" name="q" value="{{ request('q') }}" placeholder="Cari {{ strtolower($definition['label']) }}..."><button class="btn-secondary">Cari</button></form><a href="{{ route('admin.resources.create',$resource) }}" class="btn-primary">+ Tambah {{ $definition['label'] }}</a></div>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>ID</th>@foreach(array_slice($definition['fields'],0,5,true) as $field)<th>{{ $field['label'] }}</th>@endforeach<th>Aksi</th></tr></thead><tbody>
@forelse($records as $record)<tr><td>{{ $record->id }}</td>
@foreach(array_slice($definition['fields'],0,5,true) as $name=>$field)<td>
    @if($field['type']==='image')
        @php($url=method_exists($record,'imageUrl')?$record->imageUrl($record->{$name}):asset('storage/'.$record->{$name}))
        @if($record->{$name})<img src="{{ $url }}" class="h-12 w-16 rounded-lg object-cover">@else — @endif
    @elseif($field['type']==='boolean')
        <span class="badge {{ $record->{$name}?'bg-emerald-100 text-emerald-700':'bg-stone-100 text-stone-500' }}">{{ $record->{$name}?'Ya':'Tidak' }}</span>
    @elseif($field['type']==='multiselect')
        {{ $record->{$field['relation']}->pluck($field['option'])->take(3)->join(', ') ?: '—' }}
    @elseif($field['type']==='select' && str_ends_with($name,'_id'))
        {{ optional($record->{str($name)->beforeLast('_id')->toString()})->{$field['option']} ?? '—' }}
    @elseif($field['type']==='number' && str_contains($name,'price'))
        Rp {{ number_format($record->{$name},0,',','.') }}
    @else
        <span class="line-clamp-2 max-w-xs">{{ $record->{$name} ?: '—' }}</span>
    @endif
</td>@endforeach
<td><div class="flex gap-2"><a class="rounded-lg bg-ube-100 px-3 py-2 text-xs font-bold text-ube-700" href="{{ route('admin.resources.edit',[$resource,$record->id]) }}">Edit</a><form method="POST" action="{{ route('admin.resources.destroy',[$resource,$record->id]) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="rounded-lg bg-rose-100 px-3 py-2 text-xs font-bold text-rose-700">Hapus</button></form></div></td></tr>
@empty<tr><td colspan="8" class="py-10 text-center text-stone-400">Belum ada data.</td></tr>@endforelse
</tbody></table></div><div class="mt-6">{{ $records->links() }}</div>
@endsection
