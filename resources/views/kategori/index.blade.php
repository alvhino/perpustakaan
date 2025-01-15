@extends('template.index')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Kategori</h3>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a class="btn btn-primary mb-3" href="{{ url('/kategori/create') }}">Tambah Data kategori</a>
    <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                    <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategoris as $kategori)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>{{ $kategori->created_at->format('d M Y') }}</td>
                    <td>
                    <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('kategori.destroy', $kategori->id) }}" 
                    class="btn btn-danger btn-sm" 
                    onclick="return confirm('Yakin ingin menghapus pengguna ini?');">
                    Hapus</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data kategori</td>
                </tr>
            @endforelse
        </tbody>
                    </table>
                  </div>
                </div>
</div>
@endsection
