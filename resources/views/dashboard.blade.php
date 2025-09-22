@extends('layouts.niceadmin')

@section('title', 'Dashboard')

@section('content')
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
  <div class="row">
    <div class="col-xxl-4 col-md-6">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Sales <span>| Today</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-cart"></i>
            </div>
            <div class="ps-3">
              <h6>{{ number_format($todaySalesCount ?? 0) }}</h6>
              <span class="text-muted small pt-2 ps-1">orders created today</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xxl-4 col-md-6">
      <div class="card info-card revenue-card">
        <div class="card-body">
          <h5 class="card-title">Revenue <span>| This Month</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="ps-3">
              <h6>Rp {{ number_format($monthRevenue ?? 0, 0, ',', '.') }}</h6>
              <span class="text-muted small pt-2 ps-1">total order amount this month</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xxl-4 col-xl-12">
      <div class="card info-card customers-card">
        <div class="card-body">
          <h5 class="card-title">Customers <span>| This Year</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-people"></i>
            </div>
            <div class="ps-3">
              <h6>{{ number_format($yearCustomers ?? 0) }}</h6>
              <span class="text-muted small pt-2 ps-1">new clients registered this year</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection