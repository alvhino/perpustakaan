@extends('template.index')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Kategori</h1>

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

    <!-- Form Edit Data -->
    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_kategori">Nama Kategori</label>
            <input 
                type="text" 
                name="nama_kategori" 
                id="nama_kategori" 
                class="form-control @error('nama_kategori') is-invalid @enderror" 
                value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                required>
            @error('nama_kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/kategori" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
