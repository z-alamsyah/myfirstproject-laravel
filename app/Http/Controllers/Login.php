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
     * Process login with JWT authentication
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
        $loginResult = $this->userService->attemptLogin($username, $password);

        // Cek hasil login
        if ($loginResult) {
            // Login berhasil - simpan user info di session
            $request->session()->put('user_id', $loginResult['user']->id);
            $request->session()->put('username', $loginResult['user']->user);
            $request->session()->put('jwt_token', $loginResult['token']);

            return redirect('/dashboard')->with('success', 'Login berhasil! JWT token generated.');
        } else {
            // Login gagal
            return redirect()->back()->with('error', 'Username atau password salah!');
        }
    }
    
    /**
     * Logout with JWT token invalidation
     */
    public function logout(Request $request)
    {
        // Invalidate JWT token if exists
        if ($request->session()->has('jwt_token')) {
            $this->userService->logout();
        }

        // Hapus session
        $request->session()->forget('user_id');
        $request->session()->forget('username');
        $request->session()->forget('jwt_token');

        return redirect('/login')->with('success', 'Logout berhasil! JWT token invalidated.');
    }
}