@extends('template.index')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Data Pengguna</h1>

    <!-- Tampilkan error validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Tambah Data -->
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input 
                type="text" 
                name="username" 
                id="username" 
                class="form-control @error('username') is-invalid @enderror" 
                placeholder="Masukkan nama pengguna" 
                value="{{ old('username') }}" 
                required>
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select 
                name="role" 
                id="role" 
                class="form-control @error('role') is-invalid @enderror" 
                required>
                <option value="" disabled selected>Pilih role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control @error('password') is-invalid @enderror" 
                placeholder="Masukkan password" 
                required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/user" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
