<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Str;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class PerpusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter `sort` (default: 'newest') dan `category` (default: 'all') dari query string
        $sort = $request->input('sort', 'newest');
        $selectedCategory = $request->input('category', 'all');
    
        // Query buku dengan relasi kategori
        $bukus = Buku::with('kategori');
    
        // Terapkan filter kategori jika dipilih
        if ($selectedCategory !== 'all') {
            $bukus = $bukus->whereHas('kategori', function ($query) use ($selectedCategory) {
                $query->where('id', $selectedCategory);
            });
        }
    
        // Terapkan sorting berdasarkan parameter `sort`
        if ($sort === 'newest') {
            $bukus = $bukus->orderBy('created_at', 'desc'); // Terbaru
        } elseif ($sort === 'oldest') {
            $bukus = $bukus->orderBy('created_at', 'asc'); // Terlama
        }
    
        // Map data untuk decoding kolom JSON `selengkapnya`
        $bukus = $bukus->get()->map(function ($buku) {
            $buku->selengkapnya = json_decode($buku->selengkapnya);
            return $buku;
        });

        $totalBuku = Buku::count();
    
        // Ambil semua kategori
        $categories = Kategori::all();
    
        // Kirim data ke view
        return view('perpus.index', compact('bukus', 'sort', 'categories', 'selectedCategory', 'totalBuku'));
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
}
