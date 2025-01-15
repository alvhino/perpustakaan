@extends('template.index')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Buku</h3>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a class="btn btn-primary mb-3" href="{{ url('/buku/tambah') }}">Tambah Data Buku</a>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Sinopsis</th>
                        <th>Sampul</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bukus as $buku)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->kategori->nama_kategori }}</td>
                            <td>{{ $buku->selengkapnya->penulis ?? 'Tidak tersedia' }}</td>
                            <td>{{ $buku->selengkapnya->penerbit ?? 'Tidak tersedia' }}</td>
                            <td>{{ $buku->selengkapnya->sinopsis ?? 'Tidak tersedia' }}</td>
                            <td>
                                @if ($buku->sampul)
                                <img src="{{ asset('assets/sampul/' . $buku->sampul) }}" alt="Sampul Buku" class="img-fluid" style="width:200px;">

                                @else
                                    <span class="text-muted">Tidak ada sampul</span>
                                @endif
                            </td>
                            <td>{{ $buku->selengkapnya->tahun ?? 'Tidak tersedia' }}</td>
                            <td>
                                <a href="{{ url('buku/edit', $buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ url('buku/hapus', $buku->id) }}" 
                                class="btn btn-danger btn-sm" 
                                onclick="return confirm('Yakin ingin menghapus buku ini?');">
                                Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data buku</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
