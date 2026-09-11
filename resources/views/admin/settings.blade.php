@extends('layout.admin')
@section('title', 'Admin Settings')
@section('content')
<div class="container my-5">
    <div class="mb-4">
        <h2 class="mb-1">Admin Settings</h2>
        <p class="text-muted mb-0">Update your administrator profile and login details.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                @if($admin->profile_image)
                    <img src="{{ asset('storage/' . $admin->profile_image) }}" alt="{{ $admin->name }} profile photo" class="admin-settings-photo">
                @else
                    <i class="fa-solid fa-circle-user admin-settings-icon"></i>
                @endif
                <div>
                    <h4 class="mb-1">{{ $admin->name }}</h4>
                    <p class="text-muted mb-0">{{ $admin->email }}</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="admin-password">Password</label>
                        <div class="input-group">
                            <input type="password" id="admin-password" name="password" class="form-control" minlength="4" placeholder="Leave blank to keep current password">
                            <button type="button" class="btn btn-outline-secondary password-toggle" data-target="admin-password" aria-label="Show password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Enter a new password only if you want to change it.</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Profile photo</label>
                        <input type="file" name="profile_image" class="form-control" accept="image/jpeg,image/png,image/webp">
                        <div class="form-text">JPG, PNG, or WebP up to 2 MB.</div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4"><i class="fa-solid fa-floppy-disk me-2"></i>Save changes</button>
            </form>

            @if($admin->profile_image)
                <form action="{{ route('admin.settings.profile-image.delete') }}" method="POST" class="admin-delete-form d-inline-block mt-3" data-confirm-message="Your admin profile photo will be permanently removed.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash me-2"></i>Remove profile photo</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
@section('styles')
<style>
    .admin-settings-photo, .admin-settings-icon { width: 78px; height: 78px; border-radius: 50%; }
    .admin-settings-photo { object-fit: cover; }
    .admin-settings-icon { color: #00796b; font-size: 78px; }
</style>
@endsection
@section('scripts')
<script>
document.querySelectorAll('.password-toggle').forEach(function (button) {
    button.addEventListener('click', function () {
        const input = document.getElementById(button.dataset.target);
        const visible = input.type === 'text';
        input.type = visible ? 'password' : 'text';
        button.setAttribute('aria-label', visible ? 'Show password' : 'Hide password');
        button.innerHTML = visible
            ? '<i class="fa-solid fa-eye"></i>'
            : '<i class="fa-solid fa-eye-slash"></i>';
    });
});
</script>
@endsection
