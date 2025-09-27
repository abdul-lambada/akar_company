@extends('layouts.niceadmin')

@section('title', 'Orders')

@section('content')
<div class="pagetitle">
  <h1>Orders</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Orders</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3">
        <h5 class="card-title mb-0">Orders</h5>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Add Order</a>
      </div>

      @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
      @endif

      <div class="table-responsive mt-3">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Order Code</th>
              <th>Customer</th>
              <th>WhatsApp</th>
              <th class="text-end">Items</th>
              <th class="text-end">Total</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $o)
              <tr>
                <td>{{ $o->order_id }}</td>
                <td>{{ $o->order_code }}</td>
                <td>{{ $o->customer_name }}</td>
                <td>{{ $o->customer_whatsapp }}</td>
                <td class="text-end">{{ $o->items_count }}</td>
                <td class="text-end">Rp {{ number_format($o->total_amount ?? 0, 2) }}</td>
                <td><span class="badge bg-secondary">{{ ucfirst($o->status) }}</span></td>
                <td class="text-end">
                  @include('components.action-buttons', [
                    'viewUrl' => route('orders.show', $o),
                    'editUrl' => route('orders.edit', $o),
                    'deleteUrl' => route('orders.destroy', $o),
                    'confirm' => 'Yakin hapus order ini?',
                    'size' => 'sm'
                  ])
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">No orders yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $orders->links() }}
      </div>
    </div>
  </div>
</section>
@endsection