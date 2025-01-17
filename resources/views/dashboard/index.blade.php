@extends('template.index')

@section('content')
<div class="row">

    <!-- Username Pengguna -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">person</i>
                </div>
                <p class="card-category">Halo Selamat Datang</p>
                <h3 class="card-title">{{ $username }}</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">person_outline</i>
                    Saat ini Anda login sebagai {{ $username }}.
                </div>
            </div>
        </div>
    </div>


    <!-- Jumlah Buku -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">book</i>
                </div>
                <p class="card-category">Jumlah Buku</p>
                <h3 class="card-title">{{ $jumlahBuku }}</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons text-warning">library_books</i>
                    Total koleksi buku di perpustakaan.
                </div>
            </div>
        </div>
    </div>



    <!-- Jumlah User -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">people</i>
                </div>
                <p class="card-category">Jumlah User</p>
                <h3 class="card-title">{{ $jumlahUser }}</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">people</i>
                    Total pengguna yang terdaftar.
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Pinjam -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">shopping_cart</i>
                </div>
                <p class="card-category">Jumlah Pinjaman</p>
                <h3 class="card-title">{{ $jumlahPinjam }}</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">update</i>
                    Total buku yang sedang dipinjam.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
