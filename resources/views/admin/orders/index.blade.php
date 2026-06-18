@extends('layouts.admin')
@section('heading','Pesanan')
@section('content')
<div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"><form class="grid gap-2 sm:grid-cols-[1fr_220px_auto]"><input class="field" name="q" value="{{ request('q') }}" placeholder="No. pesanan / pelanggan"><select class="field" name="status"><option value="">Semua status</option>@foreach(\App\Models\Order::STATUSES as $value=>$label)<option value="{{ $value }}" @selected(request('status')===$value)>{{ $label }}</option>@endforeach</select><button class="btn-secondary">Filter</button></form><a href="{{ route('admin.reports.orders',request()->query()) }}" class="btn-primary">Unduh PDF</a></div>
<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr><th>No.</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td class="font-bold text-ube-700">{{ $order->order_number }}</td>
                    <td>{{ $order->customer_name }}<small class="block text-stone-500">{{ $order->whatsapp }}</small></td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-ube-100 text-ube-800">
                            {{ \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="flex flex-wrap gap-2">
                            <a class="rounded-lg bg-ube-100 px-3 py-2 text-xs font-bold text-ube-800" href="{{ route('admin.orders.show', $order) }}">Detail</a>
                            <a class="rounded-lg bg-stone-100 px-3 py-2 text-xs font-bold text-stone-700" href="{{ route('admin.orders.receipt', $order) }}" target="_blank">Print</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="py-10 text-center">Belum ada pesanan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $orders->links() }}</div>
@endsection
