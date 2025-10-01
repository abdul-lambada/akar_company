<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input type="text" name="service_name" class="form-control @error('service_name') is-invalid @enderror" value="{{ old('service_name', isset($service) ? $service->service_name : '') }}" required>
    @error('service_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Slug (optional)</label>
    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', isset($service) ? $service->slug : '') }}">
    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Price</label>
    <div class="input-group">
      <span class="input-group-text">Rp</span>
      <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', isset($service) ? $service->price : '') }}" required>
    </div>
    @error('price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  </div>
</div>