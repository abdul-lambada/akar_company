@extends('layouts.niceadmin')

@section('title', 'Invoices')

@section('content')
<div class="pagetitle">
  <h1>Invoices</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Invoices</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3">
        <h5 class="card-title m-0">List Invoices</h5>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Invoice</a>
      </div>
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Invoice Code</th>
              <th>Client</th>
              <th>Issue Date</th>
              <th>Due Date</th>
              <th>Status</th>
              <th class="text-end">Total</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($invoices as $inv)
            <tr>
              <td>{{ $inv->invoice_id }}</td>
              <td><span class="badge bg-secondary">{{ $inv->invoice_code }}</span></td>
              <td>{{ $inv->client->client_name ?? '-' }}</td>
              <td>{{ optional($inv->issue_date)->format('Y-m-d') }}</td>
              <td>{{ optional($inv->due_date)->format('Y-m-d') }}</td>
              <td>
                <span class="badge bg-{{ match($inv->status){'paid'=>'success','overdue'=>'danger','cancelled'=>'secondary','draft'=>'warning', default=>'info'} }}">{{ ucfirst($inv->status) }}</span>
              </td>
              <td class="text-end">{{ number_format($inv->total_amount,2,',','.') }}</td>
              <td class="text-end">
                @include('components.action-buttons', [
                  'viewUrl' => route('invoices.show', $inv),
                  'editUrl' => route('invoices.edit', $inv),
                  'deleteUrl' => route('invoices.destroy', $inv),
                  'confirm' => 'Yakin hapus invoice ini?',
                  'size' => 'sm'
                ])
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center">No invoices found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div>
        {{ $invoices->links() }}
      </div>
    </div>
  </div>
</section>
@endsection