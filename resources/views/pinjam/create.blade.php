@extends('template.index')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Tambah Data Pinjam</h3>
    <form action="{{ url('/pinjam/tambah') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_user" class="form-label">Nama User</label>
            <select name="id_user" id="id_user" class="form-select">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="id_buku" class="form-label">Judul Buku</label>
            <select name="id_buku" id="id_buku" class="form-select">
                @foreach($bukus as $buku)
                    <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
