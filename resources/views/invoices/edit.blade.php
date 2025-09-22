@extends('layouts.niceadmin')

@section('title', 'Edit Invoice')

@section('content')
<div class="pagetitle">
  <h1>Edit Invoice</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoices</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Invoice #{{ $invoice->invoice_id }}</h5>
      <form method="POST" action="{{ route('invoices.update', $invoice) }}">
        @csrf
        @method('PUT')
        @include('invoices._form')
        <div class="mt-3">
          <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection