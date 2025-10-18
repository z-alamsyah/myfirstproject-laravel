<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class Login extends Controller
{
    // Property untuk menyimpan UserService
    protected $userService;
    
    /**
     * Constructor - Dependency Injection UserService
     * Laravel otomatis inject UserService yang sudah diregister di ServiceProvider
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('login');
    }
    
    /**
     * Process login
     */
    public function login(Request $request)
    {
        // Ambil input dari form
        $username = $request->input('username');
        $password = $request->input('password');
        
        // Validasi input
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan password harus diisi!');
        }
        
        // Panggil UserService untuk attempt login
        $user = $this->userService->attemptLogin($username, $password);
        
        // Cek hasil login
        if ($user) {
            // Login berhasil - simpan user ID di session
            $request->session()->put('user_id', $user->id);
            $request->session()->put('username', $user->user);
            
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        } else {
            // Login gagal
            return redirect()->back()->with('error', 'Username atau password salah!');
        }
    }
    
    /**
     * Logout
     */
    public function logout(Request $request)
    {
        // Hapus session
        $request->session()->forget('user_id');
        $request->session()->forget('username');
        
        return redirect('/login')->with('success', 'Logout berhasil!');
    }
}
