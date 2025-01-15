@extends('template.index')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-light">Edit Data Buku</h3>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card bg-dark text-light shadow">
        <div class="card-header bg-primary">
            <h4 class="card-title mb-0">Form Edit Buku</h4>
        </div>
        
        <div class="card-body">
            <form action="{{ url('buku/update/' . $buku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Judul Buku -->
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Buku</label>
                    <input type="text" 
                           class="form-control bg-dark text-light @error('judul') is-invalid @enderror" 
                           id="judul" 
                           name="judul" 
                           value="{{ old('judul', $buku->judul) }}" 
                           required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label for="id_kategori" class="form-label">Kategori</label><br>
                    <select class="form-select bg-dark text-light @error('id_kategori') is-invalid @enderror" 
                            id="id_kategori" 
                            name="id_kategori" 
                            required>
                        <option value="" disabled>Pilih kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" 
                                    {{ old('id_kategori', $buku->id_kategori) == $kategori->id ? 'selected' : '' }}>
                                📚 {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sampul -->
                <div class="mb-3">
                    <label for="sampul" class="form-label">Sampul Buku</label>
                    <input type="file" 
                           class="form-control bg-dark text-light @error('sampul') is-invalid @enderror" 
                           id="sampul" 
                           name="sampul" 
                           accept="image/jpeg,image/png,image/jpg" 
                           onchange="previewImage()" value="">
                    <div class="form-text text-light">Format file: JPG, PNG, JPEG (Maksimum 2MB)</div>
                  
                    <div class="mt-2">
                        @if($buku->sampul)
                            <img src="{{ asset('assets/sampul/' . $buku->sampul) }}" 
                                 id="preview" 
                                 class="img-fluid rounded" 
                                 style="max-width: 200px;" 
                                 alt="Sampul {{ $buku->judul }}">
                        @else
                            <img id="preview" 
                                 class="img-fluid rounded" 
                                 style="display: none; max-width: 200px;" 
                                 alt="Preview Sampul">
                        @endif
                    </div>
                    
                    @error('sampul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Penulis -->
                    <div class="col-md-6 mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" 
                               class="form-control bg-dark text-light @error('penulis') is-invalid @enderror" 
                               id="penulis" 
                               name="penulis" 
                               value="{{ old('penulis', $selengkapnya['penulis']) }}" 
                               required>
                        @error('penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Penerbit -->
                    <div class="col-md-6 mb-3">
                        <label for="penerbit" class="form-label">Penerbit</label>
                        <input type="text" 
                               class="form-control bg-dark text-light @error('penerbit') is-invalid @enderror" 
                               id="penerbit" 
                               name="penerbit" 
                               value="{{ old('penerbit', $selengkapnya['penerbit']) }}" 
                               required>
                        @error('penerbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Tahun Terbit -->
                <div class="mb-3">
                    <label for="tahun" class="form-label">Tahun Terbit</label>
                    <input type="number" 
                           class="form-control bg-dark text-light @error('tahun') is-invalid @enderror" 
                           id="tahun" 
                           name="tahun" 
                           value="{{ old('tahun', $selengkapnya['tahun']) }}" 
                           required>
                    @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sinopsis -->
                <div class="mb-4">
                    <label for="sinopsis" class="form-label">Sinopsis Buku</label>
                    <textarea class="form-control bg-dark text-light @error('sinopsis') is-invalid @enderror" 
                              id="sinopsis" 
                              name="sinopsis" 
                              rows="5" 
                              required>{{ old('sinopsis', $selengkapnya['sinopsis']) }}</textarea>
                    @error('sinopsis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-between">
                    <a href="{{ url('/buku') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage() {
        const sampul = document.querySelector('#sampul');
        const preview = document.querySelector('#preview');
        const file = sampul.files[0];

        if (file) {
            preview.style.display = 'block';
            preview.src = URL.createObjectURL(file);
        }
    }
</script>
@endsection