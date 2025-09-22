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
  </div>
  <div class="col-md-6">
    <label class="form-label">Password {{ isset($user) ? '(leave blank to keep current)' : '' }}</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>