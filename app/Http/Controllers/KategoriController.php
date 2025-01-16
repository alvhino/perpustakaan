<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->session()->has('username')) {
            return redirect('/');
        }
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!$request->session()->has('username')) {
            return redirect('/');
        }
        return view('kategori.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);
    
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);
    
        return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        if (!$request->session()->has('username')) {
            return redirect('/');
        }
        $kategori = Kategori::findOrFail($id); // Ambil data kategori berdasarkan ID
        return view('kategori.edit', compact('kategori'));
    }

    // Memperbarui data kategori
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        // Temukan data kategori
        $kategori = Kategori::findOrFail($id);

        // Update data
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
