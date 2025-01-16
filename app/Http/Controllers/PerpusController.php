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
        $sort = $request->input('sort', 'newest');
        $selectedCategory = $request->input('category', 'all');
        $searchQuery = $request->input('searchQuery', ''); // Ambil query pencarian
    
        $selectedCategory = $selectedCategory === 'all' ? null : (int) $selectedCategory;
    
        $perPage = 6;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
    
        // Modifikasi query untuk memfilter berdasarkan pencarian
        $bukus = DB::select('
            SELECT * FROM get_buku_with_kategori(:selectedCategory, :sortOrder, :limit, :offset, :searchQuery)
        ', [
            'selectedCategory' => $selectedCategory,
            'sortOrder' => $sort,
            'limit' => $perPage,
            'offset' => $offset,
            'searchQuery' => "%$searchQuery%",  // Menambahkan parameter pencarian
        ]);
    
        $totalBuku = DB::select('
            SELECT COUNT(*) AS total FROM get_buku_with_kategori(:selectedCategory, :sortOrder, NULL, NULL, :searchQuery)
        ', [
            'selectedCategory' => $selectedCategory,
            'sortOrder' => $sort,
            'searchQuery' => "%$searchQuery%",  // Menambahkan parameter pencarian
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
}
