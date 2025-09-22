@extends('layouts.niceadmin')

@section('title', 'Edit Order')

@section('content')
<div class="pagetitle">
  <h1>Edit Order</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Order #{{ $order->order_code }}</h5>
      <form method="POST" action="{{ route('orders.update', $order) }}">
        @csrf
        @method('PUT')
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name', $order->customer_name) }}" required>
            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">WhatsApp</label>
            <input type="text" name="customer_whatsapp" class="form-control @error('customer_whatsapp') is-invalid @enderror" value="{{ old('customer_whatsapp', $order->customer_whatsapp) }}" required>
            @error('customer_whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
              @php($statuses = ['pending','paid','processing','completed','cancelled'])
              @foreach($statuses as $st)
                <option value="{{ $st }}" {{ old('status', $order->status)===$st? 'selected':'' }}>{{ ucfirst($st) }}</option>
              @endforeach
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <h6 class="mt-4">Items</h6>
        <div class="table-responsive">
          <table class="table" id="items-table">
            <thead>
              <tr>
                <th style="width:50%">Service</th>
                <th style="width:30%" class="text-end">Price</th>
                <th style="width:20%" class="text-end"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->items as $i => $it)
                <tr>
                  <td>
                    <select name="items[{{ $i }}][service_id]" class="form-select service-select" required>
                      <option value="">-- Select Service --</option>
                      @foreach($services as $s)
                        <option value="{{ $s->service_id }}" data-price="{{ $s->price ?? 0 }}" {{ $s->service_id == $it->service_id ? 'selected' : '' }}>{{ $s->service_name }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td style="width: 200px;">
                    <div class="input-group">
                      <span class="input-group-text">Rp</span>
                      <input type="number" step="0.01" min="0" name="items[{{ $i }}][price_at_order]" class="form-control price-input" value="{{ number_format($it->price_at_order, 2, '.', '') }}" required>
                    </div>
                  </td>
                  <td class="text-end">
                    <button type="button" class="btn btn-sm btn-danger remove-row">Remove</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between">
          <button type="button" class="btn btn-sm btn-secondary" id="add-row">Add Item</button>
          <div class="h5">Total: Rp <span id="total-amount">0.00</span></div>
        </div>

        <div class="mt-3">
          <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</section>

@push('scripts')
<script>
(function(){
  let rowIndex = {{ count($order->items) }};
  const tableBody = document.querySelector('#items-table tbody');
  const addBtn = document.getElementById('add-row');
  const totalEl = document.getElementById('total-amount');

  function recalc(){
    let total = 0;
    tableBody.querySelectorAll('input.price-input').forEach(inp => {
      total += parseFloat(inp.value || 0);
    });
    totalEl.textContent = total.toFixed(2);
  }

  function bindRowEvents(tr){
    const select = tr.querySelector('select.service-select');
    const priceInput = tr.querySelector('input.price-input');
    const removeBtn = tr.querySelector('button.remove-row');

    select.addEventListener('change', function(){
      const selected = this.options[this.selectedIndex];
      const price = selected.getAttribute('data-price');
      if (price && !priceInput.value) {
        priceInput.value = parseFloat(price).toFixed(2);
        recalc();
      }
    });
    priceInput.addEventListener('input', recalc);
    removeBtn.addEventListener('click', function(){
      tr.remove();
      recalc();
    });
  }

  function addRow(){
    const template = `@include('orders._items_row')`;
    const html = template.replaceAll('__INDEX__', rowIndex++);
    const temp = document.createElement('tbody');
    temp.innerHTML = html.trim();
    const tr = temp.firstChild;
    tableBody.appendChild(tr);
    bindRowEvents(tr);
  }

  addBtn.addEventListener('click', addRow);
  recalc();
})();
</script>
@endpush
@endsection