<div class="row g-3">
  <div class="col-12">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title ?? '') }}" required>
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">Slug (optional)</label>
    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug ?? '') }}">
    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">Content</label>
    <textarea name="content" rows="6" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $post->content ?? '') }}</textarea>
    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">Categories</label>
    <select name="categories[]" class="form-select @error('categories') is-invalid @enderror" multiple size="6">
      @foreach($categories as $cat)
        <option value="{{ $cat->category_id }}" @selected(collect(old('categories', $selectedCategories ?? []))->contains($cat->category_id))>{{ $cat->category_name }}</option>
      @endforeach
    </select>
    @error('categories')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>