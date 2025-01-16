<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;

class PinjamController extends Controller
{
    // Tampilkan daftar data pinjam
    public function index()
    {
        $pinjams = Pinjam::with(['buku', 'user'])->get(); // Ambil data pinjam beserta relasinya
        return view('pinjam.index', compact('pinjams'));
    }

    // Tampilkan form tambah data pinjam
    public function create()
    {
        $bukus = Buku::all(); // Ambil semua data buku
        $users = User::all(); // Ambil semua data user
        return view('pinjam.create', compact('bukus', 'users'));
    }

    // Proses tambah data pinjam
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_user' => 'required',
            'id_buku' => 'required',
        ]);
    
        // Tambahkan status secara otomatis
        $data = $request->all();
        $data['status'] = 'pinjam';
    
        // Simpan data ke database
        Pinjam::create($data);
    
        // Redirect dengan pesan sukses
        return redirect('/pinjam')->with('success', 'Data pinjam berhasil ditambahkan.');
    }
    

    // Tampilkan form edit data pinjam
    public function edit($id)
    {
        $pinjam = Pinjam::findOrFail($id); // Cari data pinjam berdasarkan ID
        $bukus = Buku::all();
        $users = User::all();
        return view('pinjam.edit', compact('pinjam', 'bukus', 'users'));
    }

    // Proses update data pinjam
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_user' => 'required',
            'id_buku' => 'required',
        ]);
    
        // Temukan data pinjam berdasarkan ID
        $pinjam = Pinjam::findOrFail($id);
    
        // Perbarui data dengan nilai dari request
        $data = $request->all();
    
        // Tetapkan status menjadi 'dikembalikan' atau nilai lain secara otomatis
        $data['status'] = 'kembali';
    
        // Perbarui data di database
        $pinjam->update($data);
    
        // Redirect dengan pesan sukses
        return redirect('/pinjam')->with('success', 'Data pinjam berhasil diperbarui.');
    }
    

    // Hapus data pinjam
    public function destroy($id)
    {
        $pinjam = Pinjam::findOrFail($id);
        $pinjam->delete(); // Hapus data pinjam
        return redirect('/pinjam')->with('success', 'Data pinjam berhasil dihapus.');
    }

    public function updateStatus($id)
{
    $pinjam = Pinjam::findOrFail($id);

    // Ubah status menjadi "dikembalikan"
    $pinjam->status = 'kembali';
    $pinjam->save();

    return redirect('/pinjam')->with('success', 'Status berhasil diperbarui menjadi Dikembalikan.');
}

}
