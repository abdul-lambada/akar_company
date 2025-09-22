@csrf
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Project Title</label>
    <input type="text" class="form-control" name="project_title" value="{{ old('project_title', $portfolio->project_title ?? '') }}" required>
    @error('project_title')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Client Name</label>
    <input type="text" class="form-control" name="client_name" value="{{ old('client_name', $portfolio->client_name ?? '') }}" required>
    @error('client_name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  
  <div class="col-12">
    <label class="form-label">Services</label>
    <select class="form-select" name="service_ids[]" multiple size="6">
      @foreach($services as $service)
        <option value="{{ $service->service_id }}" @selected(in_array($service->service_id, old('service_ids', $selectedServices ?? [])))>
          {{ $service->service_name }}
        </option>
      @endforeach
    </select>
    @error('service_ids')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-12">
    <label class="form-label">Project Images (multiple)</label>
    <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" accept="image/*" multiple>
    @error('images')<div class="text-danger small">{{ $message }}</div>@enderror
    @error('images.*')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
</div>