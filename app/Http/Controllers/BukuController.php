<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Str;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
class BukuController extends Controller
{
   
    public function index(Request $request)
{ 
    if (!$request->session()->has('username')) {
        return redirect('/');
    }
    $bukus = Buku::with('kategori')->get()->map(function ($buku) {
        $buku->selengkapnya = json_decode($buku->selengkapnya);
        return $buku;
    });

    return view('buku.index', compact('bukus'));
}


    public function create(Request $request)
    {
        if (!$request->session()->has('username')) {
            return redirect('/');
        }
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
    public function edit(Request $request, $id)
    {
        if (!$request->session()->has('username')) {
            return redirect('/');
        }
        $buku = Buku::find($id);
    
        if (!$buku) {
            return redirect('buku')->with('error', 'Data buku tidak ditemukan.');
        }
    
        // Decode JSON dari kolom selengkapnya
        $selengkapnya = json_decode($buku->selengkapnya, true);
    
        $kategoris = Kategori::all();
        return view('buku.edit', compact('buku', 'selengkapnya', 'kategoris'));
    }
    
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun' => 'required|numeric|digits:4',
            'sinopsis' => 'required|string|max:5000',
        ]);
    
        // Cari data buku berdasarkan ID
        $buku = DB::table('buku')->where('id', $id)->first();
    
        if (!$buku) {
            return redirect('/buku')->withErrors(['error' => 'Data buku tidak ditemukan.']);
        }
    
        $sampulPath = $buku->sampul; // Path sampul lama
        if ($request->hasFile('sampul')) {
            // Hapus file lama jika ada
            if ($sampulPath && file_exists(public_path('assets/sampul/' . $sampulPath))) {
                unlink(public_path('assets/sampul/' . $sampulPath));
            }
    
            // Mengambil file baru yang diunggah
            $file = $request->file('sampul');
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $allowedExtensions = ['jpeg', 'png', 'jpg'];
    
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                return back()->withErrors(['sampul' => 'File harus berupa gambar JPEG, PNG, atau JPG.']);
            }
    
            // Membuat nama file acak untuk gambar
            $filename = Str::random(20) . '.' . $extension;
    
            // Memindahkan file ke folder public/assets/sampul
            $file->move(public_path('assets/sampul'), $filename);
    
            // Update path sampul
            $sampulPath = $filename;
        }
    
        // Update data di database
        DB::table('buku')
            ->where('id', $id)
            ->update([
                'id_kategori' => $request->id_kategori,
                'judul' => $request->judul,
                'sampul' => $sampulPath,
                'selengkapnya' => json_encode([
                    'penulis' => $request->penulis,
                    'tahun' => $request->tahun,
                    'penerbit' => $request->penerbit,
                    'sinopsis' => $request->sinopsis,
                ]),
                'updated_at' => now(),
            ]);
    
        return redirect('/buku')->with('success', 'Data buku berhasil diperbarui!');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$request->session()->has('username')) {
            return redirect('/');
        }
        // Cari data buku berdasarkan ID
        $buku = DB::table('buku')->where('id', $id)->first();
    
        if (!$buku) {
            return redirect('/buku')->withErrors(['error' => 'Data buku tidak ditemukan.']);
        }
    
        // Hapus file sampul jika ada
        if ($buku->sampul && file_exists(public_path('assets/sampul/' . $buku->sampul))) {
            unlink(public_path('assets/sampul/' . $buku->sampul));
        }
    
        // Hapus data buku dari database
        DB::table('buku')->where('id', $id)->delete();
    
        return redirect('/buku')->with('success', 'Data buku berhasil dihapus!');
    }
    
}
