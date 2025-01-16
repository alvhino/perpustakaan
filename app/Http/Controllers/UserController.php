<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }
    public function login()
    {
        return view('index');
    }
    
    public function dashboard(Request $request)
    {
        if (!$request->session()->has('username')) {
            return redirect('/');
        }
        return view('template.index');
    }
    public function loginpost(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
    
        // Ambil data user berdasarkan username
        $user = User::where('username', $request->username)->first();
    
        if ($user) {
            // Cek password
            if (Hash::check($request->password, $user->password)) {
                // Simpan username ke session
                $request->session()->put('username', $user->username);
    
                // Arahkan berdasarkan role
                if ($user->role === 'admin') {
                    return redirect('/dashboard')->with('success', 'Login berhasil sebagai Admin!');
                } elseif ($user->role === 'user') {
                    return redirect('/perpus')->with('success', 'Login berhasil sebagai User!');
                } else {
                    // Jika role tidak dikenali
                    return redirect('/login')->with('error', 'Role tidak dikenali.');
                }
            } else {
                // Jika password salah
                return redirect()->back()->with('error', 'Username atau password salah.');
            }
        } else {
            // Jika user tidak ditemukan
            return redirect()->back()->with('error', 'Username atau password salah.');
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'username' => 'required|string|max:255',
            'role' => 'required',
            'password' => 'required|min:3',
        ]);

        // Simpan data ke database
        User::create([
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // Redirect dengan pesan sukses
        return redirect('/user')->with('success', 'Pengguna berhasil ditambahkan.');
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
    public function destroy($id)
    {
        try {
            // Cari pengguna berdasarkan ID
            $user = User::findOrFail($id);

            // Hapus pengguna
            $user->delete();

            // Redirect dengan pesan sukses
            return redirect('/user')->with('success', 'Data pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika terjadi kesalahan
            return redirect('/user')->with('error', 'Terjadi kesalahan saat menghapus data pengguna.');
        }
    }
}
