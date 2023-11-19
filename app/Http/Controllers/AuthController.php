<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.index');
    }

    public function proses(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                Auth::attempt(['email' => $email, 'password' => $password]);
                if (Auth::check() == true) {
                    return $this->redirectToDashboard();
                }
            } else {
                session()->flash('error', 'Password salah!');
                return redirect()->route('login');
            }
        } else {
            session()->flash('warning', 'Email tidak ditemukan!');
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('info', 'Berhasil logout!');
        return redirect()->route('login');
    }

    private function redirectToDashboard()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('prodi')) {
            return redirect()->route('prodi.dashboard');
        }

        if ($user->hasRole('auditor')) {
            return redirect()->route('auditor.dashboard');
        }

        abort(403, 'Unauthorized action.');
    }
}
