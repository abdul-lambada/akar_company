<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Client Name</label>
    <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror" value="{{ old('client_name', $testimonial->client_name ?? '') }}" required>
    @error('client_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Project</label>
    <select name="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
      <option value="">-- Select Project --</option>
      @foreach($projects as $p)
        <option value="{{ $p->project_id }}" {{ (string) old('project_id', $testimonial->project_id ?? '') === (string) $p->project_id ? 'selected' : '' }}>{{ $p->project_title }}</option>
      @endforeach
    </select>
    @error('project_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">Testimonial</label>
    <textarea name="testimonial_text" rows="4" class="form-control @error('testimonial_text') is-invalid @enderror" required>{{ old('testimonial_text', $testimonial->testimonial_text ?? '') }}</textarea>
    @error('testimonial_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>