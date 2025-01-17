@extends('template.index')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Buku</h3>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a class="btn btn-primary mb-3" href="{{ url('/pinjam/tambah') }}">Tambah Data Buku</a>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pinjams as $pinjam)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pinjam->buku->judul }}</td>
                            <td>{{ $pinjam->user->username }}</td>
                            <td>{{ $pinjam->created_at->format('d M Y') }}</td>
                            <td>{{ $pinjam->status}}</td>
                            <td>
                            <form action="{{ url('pinjam/update-status', $pinjam->id) }}" method="POST" style="display: inline;">
    @csrf
    @if ($pinjam->status === 'kembali')
        <!-- Tombol Pinjam Buku -->
        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Yakin ingin meminjam buku ini lagi?');">
            Pinjam Buku
        </button>
    @else
        <!-- Tombol Tandai Dikembalikan -->
        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin dikembalikan?');">
            Tandai Dikembalikan
        </button>
    @endif
</form>

    <a href="{{ url('pinjam/hapus', $pinjam->id) }}" 
        class="btn btn-danger btn-sm" 
        onclick="return confirm('Yakin ingin menghapus pinjam ini?');">
        Hapus
    </a>
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
