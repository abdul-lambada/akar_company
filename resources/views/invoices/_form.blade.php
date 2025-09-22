@csrf
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Client</label>
    <select name="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
      <option value="">-- Select Client --</option>
      @foreach($clients as $cl)
        <option value="{{ $cl->client_id }}" @selected(old('client_id', $invoice->client_id ?? '')==$cl->client_id)>{{ $cl->client_name }}</option>
      @endforeach
    </select>
    @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">Issue Date</label>
    <input type="date" name="issue_date" class="form-control @error('issue_date') is-invalid @enderror" value="{{ old('issue_date', isset($invoice)?optional($invoice->issue_date)->format('Y-m-d'):date('Y-m-d')) }}" required>
    @error('issue_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">Due Date</label>
    <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date', isset($invoice)?optional($invoice->due_date)->format('Y-m-d'):date('Y-m-d')) }}" required>
    @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
      @php($statuses = ['draft','issued','sent','paid','overdue','cancelled'])
      @foreach($statuses as $st)
        <option value="{{ $st }}" {{ old('status', $invoice->status ?? 'draft')===$st? 'selected':'' }}>{{ ucfirst($st) }}</option>
      @endforeach
    </select>
    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Total Amount</label>
    <div class="input-group">
      <span class="input-group-text">Rp</span>
      <input type="number" step="0.01" min="0" name="total_amount" class="form-control @error('total_amount') is-invalid @enderror" value="{{ old('total_amount', $invoice->total_amount ?? 0) }}" required>
    </div>
    @error('total_amount')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  </div>
</div>