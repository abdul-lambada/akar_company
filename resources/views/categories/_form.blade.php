<div class="row g-3">
  <div class="col-12">
    <label class="form-label">Name</label>
    <input type="text" name="category_name" class="form-control @error('category_name') is-invalid @enderror" value="{{ old('category_name', $category->category_name ?? '') }}" required>
    @error('category_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">Slug (optional)</label>
    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $category->slug ?? '') }}">
    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>