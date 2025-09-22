@extends('layouts.niceadmin')

@section('title', 'Order Detail')

@section('content')
<div class="pagetitle">
  <h1>Order Detail</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Order #{{ $order->order_code }}</h5>
          <dl class="row mb-0">
            <dt class="col-sm-4">Customer</dt>
            <dd class="col-sm-8">{{ $order->customer_name }}</dd>
            <dt class="col-sm-4">WhatsApp</dt>
            <dd class="col-sm-8">{{ $order->customer_whatsapp }}</dd>
            <dt class="col-sm-4">Total Amount</dt>
            <dd class="col-sm-8">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
            <dt class="col-sm-4">Status</dt>
            <dd class="col-sm-8"><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></dd>
          </dl>
          <div class="mt-3">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary">Edit</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Items</h5>
          <div class="table-responsive">
            <table class="table table-sm align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Service</th>
                  <th>Price at Order</th>
                </tr>
              </thead>
              <tbody>
                @forelse($order->items as $i => $item)
                <tr>
                  <td>{{ $i+1 }}</td>
                  <td>{{ $item->service->service_name ?? '-' }}</td>
                  <td>Rp {{ number_format($item->price_at_order, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="3" class="text-center">No items</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Invoices</h5>
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Invoice Code</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($order->invoices as $i => $inv)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $inv->invoice_code }}</td>
              <td><span class="badge bg-secondary">{{ ucfirst($inv->status) }}</span></td>
              <td class="text-end">
                <a href="{{ route('invoices.show', $inv) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('invoices.edit', $inv) }}" class="btn btn-sm btn-warning">Edit</a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center">No invoices</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection