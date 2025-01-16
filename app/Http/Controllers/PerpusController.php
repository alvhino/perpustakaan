<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Kategori;
use App\Models\Pinjam;
use Illuminate\Support\Facades\DB;

class PerpusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->session()->has('username')) {
            return redirect('/');
        }
        $username = $request->session()->get('username');
        $sort = $request->input('sort', 'newest');
        $selectedCategory = $request->input('category', 'all');
        $searchQuery = $request->input('searchQuery', ''); 
    
        $selectedCategory = $selectedCategory === 'all' ? null : (int) $selectedCategory;
    
        $perPage = 6;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
    
        $bukus = DB::select('
            SELECT * FROM get_buku_with_kategori(:selectedCategory, :sortOrder, :limit, :offset, :searchQuery)
        ', [
            'selectedCategory' => $selectedCategory,
            'sortOrder' => $sort,
            'limit' => $perPage,
            'offset' => $offset,
            'searchQuery' => "%$searchQuery%",
        ]);
    
        $totalBuku = DB::select('
            SELECT COUNT(*) AS total FROM get_buku_with_kategori(:selectedCategory, :sortOrder, NULL, NULL, :searchQuery)
        ', [
            'selectedCategory' => $selectedCategory,
            'sortOrder' => $sort,
            'searchQuery' => "%$searchQuery%",  
        ])[0]->total;
    
        $categories = DB::select('SELECT * FROM kategori');
    
        $jumlahPembaca = DB::select('SELECT count_unique_readers() AS jumlah_pembaca')[0]->jumlah_pembaca;
    
        $bukus = new \Illuminate\Pagination\LengthAwarePaginator(
            $bukus,
            $totalBuku,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    
        $rekomendasiBuku = DB::select('
            SELECT b.*
            FROM buku b
            JOIN pinjam p ON b.id = p.id_buku
            GROUP BY b.id
            ORDER BY COUNT(p.id) DESC
            LIMIT 6
        ');
    
        return view('perpus.index', [
            'bukus' => $bukus,
            'sort' => $sort,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'totalBuku' => $totalBuku,
            'jumlahPembaca' => $jumlahPembaca,
            'rekomendasiBuku' => $rekomendasiBuku,
            'username' => $username,
        ]);
    }
    
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function pinjamBuku(Request $request, $id)
    {
        // Periksa apakah session 'username' ada
        if (!$request->session()->has('username')) {
            return redirect('/')->with('error', 'Anda harus login terlebih dahulu.');
        }
    
        // Ambil username dari session
        $username = $request->session()->get('username');
    
        // Cari user berdasarkan username
        $user = User::where('username', $username)->first();
    
        // Periksa apakah user ditemukan
        if (!$user) {
            return redirect('/')->with('error', 'Pengguna tidak ditemukan.');
        }
    
        // Ambil data buku berdasarkan ID
        $buku = Buku::findOrFail($id);
    
        // Periksa apakah buku sudah dipinjam
        if (Pinjam::where('id_buku', $buku->id)->where('status', 'pinjam')->exists()) {
            return redirect()->back()->with('error', 'Buku ini sudah dipinjam.');
        }
    
        // Buat data peminjaman
        Pinjam::create([
            'id_user' => $user->id, // ID pengguna yang ditemukan berdasarkan username
            'id_buku' => $buku->id, // ID buku yang ingin dipinjam
            'status' => 'pinjam',   // Status peminjaman
        ]);
    
        return redirect()->back()->with('success', 'Buku berhasil dipinjam.');
    }
    

}
