@extends('layouts.niceadmin')

@section('title', 'Create Invoice')

@section('content')
<div class="pagetitle">
  <h1>Create Invoice</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoices</a></li>
      <li class="breadcrumb-item active">Create</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">New Invoice</h5>
      <form method="POST" action="{{ route('invoices.store') }}">
        @include('invoices._form')
        <div class="mt-3">
          <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection