@csrf
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Full Name</label>
    <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $user->full_name ?? '') }}" required>
    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username ?? '') }}" required>
    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">Role</label>
    <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" value="{{ old('role', $user->role ?? '') }}">
    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
  <div class="col-md-6">
    <label class="form-label">Password {{ isset($user) ? '(leave blank to keep current)' : '' }}</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <hr class="my-4">
  <div class="col-12">
    <h6 class="mb-2">Team/Public Profile</h6>
  </div>
  <div class="col-md-6">
    <label class="form-label">Job Title</label>
    <input type="text" name="job_title" class="form-control @error('job_title') is-invalid @enderror" value="{{ old('job_title', $user->job_title ?? '') }}" maxlength="120">
    @error('job_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Display Order</label>
    <input type="number" name="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', $user->display_order ?? 0) }}" min="0">
    @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">Short Bio</label>
    <textarea name="short_bio" rows="3" class="form-control @error('short_bio') is-invalid @enderror" maxlength="1000" placeholder="Deskripsi singkat anggota tim...">{{ old('short_bio', $user->short_bio ?? '') }}</textarea>
    @error('short_bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">LinkedIn URL</label>
    <input type="url" name="linkedin_url" class="form-control @error('linkedin_url') is-invalid @enderror" value="{{ old('linkedin_url', $user->linkedin_url ?? '') }}">
    @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">GitHub URL</label>
    <input type="url" name="github_url" class="form-control @error('github_url') is-invalid @enderror" value="{{ old('github_url', $user->github_url ?? '') }}">
    @error('github_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Instagram URL</label>
    <input type="url" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror" value="{{ old('instagram_url', $user->instagram_url ?? '') }}">
    @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Website</label>
    <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $user->website ?? '') }}">
    @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">WhatsApp (Publik)</label>
    <input type="text" name="whatsapp_public" class="form-control @error('whatsapp_public') is-invalid @enderror" value="{{ old('whatsapp_public', $user->whatsapp_public ?? '') }}" placeholder="08xxxxxxxxxx">
    @error('whatsapp_public')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Pengalaman (tahun)</label>
    <input type="number" name="years_of_experience" class="form-control @error('years_of_experience') is-invalid @enderror" value="{{ old('years_of_experience', $user->years_of_experience ?? '') }}" min="0" max="60">
    @error('years_of_experience')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Expertise (koma-pisah)</label>
    <input type="text" name="expertise_text" class="form-control" value="{{ old('expertise_text', isset($user->expertise) ? implode(', ', (array)$user->expertise) : '') }}" placeholder="Laravel, React, DevOps">
    <div class="form-text">Diubah ke array otomatis saat simpan.</div>
  </div>
  <div class="col-md-4">
    <label class="form-label">Skills (koma-pisah)</label>
    <input type="text" name="skills_text" class="form-control" value="{{ old('skills_text', isset($user->skills) ? implode(', ', (array)$user->skills) : '') }}" placeholder="Teamwork, Communication">
  </div>
  <div class="col-md-6">
    <label class="form-label">Slug (opsional)</label>
    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $user->slug ?? '') }}" maxlength="160">
    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6 d-flex align-items-end">
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" role="switch" id="is_public" name="is_public" value="1" {{ old('is_public', ($user->is_public ?? true)) ? 'checked' : '' }}>
      <label class="form-check-label" for="is_public">Tampilkan di halaman Tim</label>
    </div>
  </div>
</div>