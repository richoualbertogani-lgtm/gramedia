<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // Request $request -> mengambil value data : bisa dari input atau url
    // Membuat akun baru setelah memvalidasi input dan mengenkripsi kata sandi.
    public function register(Request $request)
    {
        // Validasi
        $validatedData = $request->validate([
            // 'nama_input => ['jenis_validasi']
            'name' => ['required', 'min:3'],
            // unique:table,field : data email tidak boleh duplikat
            'email' => ['required', 'email', 'email:rfc,dns', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:10', 'confirmed', Password::min(8)->max(10)->uncompromised()]
        ], [
            //teks err yang bakal muncul kalau validasi gagal
            // 'nama_input.jenis_validasi' => 'teks err'
            'name.required' => 'Nama lengkap harus diisi',
            'name.min' => 'Nama lengkap harus diisi minimal 3 karakter',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password harus diisi minimal 8 karakter',
            'password.max' => 'Password harus diisi maksimal 10 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai dengan password yang diberikan'
        ]);

        // Simpan data ke database melalui model
        $createAccount = User::create([
            // nama_field => isi data
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            // hash::make => mengubah pw plain text menjadi hash agar lebih aman
            'password' => Hash::make($validatedData['password'])
        ]);
        // menentukan jika berhasil disimpan akan diarahkan ke halaman mana : return redirect()->route()
        // mengirimkan session untuk notifikasi/info berhasil : with('nama', 'pesan')
        return redirect()->route('login')->with('success', 'Berhasil membuat akun! Silahkan login.');
    }

    // Memeriksa kredensial lalu mengarahkan pengguna sesuai peran akunnya.
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);
        // untuk proses auth diambil data selain _token csrf (email & password aja)
        $auth = $request->except('_token');
        // Auth::attempt() -> mengecek apakah data login sesuai dengan data di database
        // kalau benar, simpan data di session/cookies web
        // kalau salah, tentukan aksi yang akan dilakukan
        // $checkAuth = Auth::attempt($auth);
        // if ($checkAuth) {
        //     // bikin ulang ID session
        //     $request->session()->regenerate();
        //     return redirect()->route('home')->with('success', 'Berhasil login!');
        // } else {
        //     return redirect()->route('login')->with('error', 'Email atau password salah. Coba Lagi!')->withInput();
        // }

        if (Auth::attempt($validatedData)) {
            $request->session()->regenerate();

            if (Auth::user()->role == "admin") {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil Login!');
            } else {
                return redirect()->route('home')->with('success', 'Berhasil Login!');
            }
        } else {
            return redirect()->route('login')->with('error', 'Email dan password salah. Coba Lagi!')->withInput();
        }
    }

    // Mengakhiri autentikasi dan membatalkan sesi aktif sebelum kembali ke beranda.
    public function logout(Request $request)
    {
        // Auth::logout() -> menghapus data login di session/cookies web
        Auth::logout();
        // memastikan semua session yg ada dibuat invalid / expired
        // bikin ulang token baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Berhasil logout!');
    }
}
