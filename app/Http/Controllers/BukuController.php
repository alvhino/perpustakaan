<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Str;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
class BukuController extends Controller
{
   
    public function index()
{ 
    $bukus = Buku::with('kategori')->get()->map(function ($buku) {
        $buku->selengkapnya = json_decode($buku->selengkapnya);
        return $buku;
    });

    return view('buku.index', compact('bukus'));
}


    public function create()
    {
        $kategoris = Kategori::all(); 
        return view('buku.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    
    $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'id_kategori' => 'required|exists:kategori,id',
        'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'penulis' => 'required|string|max:255',
        'penerbit' => 'required|string|max:255',
        'tahun' => 'required|numeric|digits:4',
        'sinopsis' => 'required|string|max:5000',
    ]);

    $sampulPath = null;
    if ($request->hasFile('sampul')) {
        // Mengambil file yang di-upload
        $file = $request->file('sampul');
        
        // Memastikan ekstensi file yang di-upload
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $allowedExtensions = ['jpeg', 'png', 'jpg'];

        if (!in_array(strtolower($extension), $allowedExtensions)) {
            return back()->withErrors(['sampul' => 'File harus berupa gambar JPEG, PNG, atau JPG.']);
        }

        // Membuat nama file acak untuk gambar
        $filename = Str::random(20) . '.' . $extension;

        // Memindahkan file ke folder public/assets/sampul
        $file->move(public_path('assets/sampul'), $filename);

        // Menyimpan nama file untuk dimasukkan ke database
        $sampulPath = $filename;
    }

    DB::table('buku')->insert([
        'id_kategori' => $request->id_kategori,
        'judul' => $request->judul,
        'sampul' => $sampulPath, 
        'selengkapnya' => json_encode([
            'penulis' => $request->penulis,
            'tahun' => $request->tahun,
            'penerbit' => $request->penerbit,
            'sinopsis' => $request->sinopsis,
        ]),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect('/buku');
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
