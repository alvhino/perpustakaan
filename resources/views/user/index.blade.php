@extends('template.index')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Pengguna</h3>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a class="btn btn-primary mb-3" href="{{ url('/user/create') }}">Tambah Data User</a>
    <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                    <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                    <a href="{{ route('user.destroy', $user->id) }}" 
   class="btn btn-danger btn-sm" 
   onclick="return confirm('Yakin ingin menghapus pengguna ini?');">
   Hapus
</a>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data pengguna</td>
                </tr>
            @endforelse
        </tbody>
                    </table>
                  </div>
                </div>
</div>
@endsection
