@extends('layouts.niceadmin')

@section('title', 'Clients')

@section('content')
<div class="pagetitle">
  <h1>Clients</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Clients</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3">
        <h5 class="card-title m-0">List Clients</h5>
        <a href="{{ route('clients.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Client</a>
      </div>
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Client Name</th>
              <th>Email</th>
              <th>WhatsApp</th>
              <th>Address</th>
              <th class="text-center">Invoices</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($clients as $c)
            <tr>
              <td>{{ $c->client_id }}</td>
              <td>{{ $c->client_name }}</td>
              <td>{{ $c->email ?? '-' }}</td>
              <td>{{ $c->whatsapp ?? '-' }}</td>
              <td>{{ $c->address ?? '-' }}</td>
              <td class="text-center">{{ $c->invoices_count ?? '-' }}</td>
              <td class="text-end">
                @include('components.action-buttons', [
                  'viewUrl' => route('clients.show', $c),
                  'editUrl' => route('clients.edit', $c),
                  'deleteUrl' => route('clients.destroy', $c),
                  'confirm' => 'Delete this client?'
                ])
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">No clients found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div>
        {{ $clients->links() }}
      </div>
    </div>
  </div>
</section>
@endsection