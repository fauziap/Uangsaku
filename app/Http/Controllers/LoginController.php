<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class LoginController extends Controller
{
    public function index()
    {
        if ($user = Auth::User()) {
            if ($user->level == '1') {
                return redirect()->intended('admin');
            } elseif ($user->level == '2') {
                return redirect()->intended('kasir');
            } elseif ($user->level == '3') {
                return redirect()->intended('guru');
            } elseif ($user->level == '4') {
                return redirect()->intended('siswa');
            }
        }

        return view('login/login_view')->with('success', 'login berhasil');
    }

    public function proses(Request $request)
    {

        Session::flash('email', $request->email);
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Tolong masukkan email',
            'password.required' => 'Tolong masukkan password'
        ]);

        // cara yang berbeda
        $infologin = $request->only('email', 'password');

        if (Auth::attempt($infologin)) {
            $user = Auth::user();
            if ($user->level == '1') {
                return redirect()->intended('admin');
            } elseif ($user->level == '2') {
                return redirect()->intended('kasir');
            } elseif ($user->level == '3') {
                return redirect()->intended('guru');
            } elseif ($user->level == '4') {
                return redirect()->intended('siswa');
            }
        } else {
            return redirect()->intended('login')->withErrors('Maaf yang anda masukkan tidak terdaftar');
        }
    }

    public function create()
    {
        return view('login/register');
    }

    public function store(Request $request)
    {

        Session::flash('name', $request->name);
        Session::flash('email', $request->email);

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6'
        ], [
            'name.required' => 'Nama tolong di isi',
            'email.required' => 'email tolong di isi',
            'email.unique' => 'email sudah digunakan',
            'password.required' => 'password wajib di isi',
            'password.min' => 'password minimal 6 karakter',
        ]);

        $inforegister = [

            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'level' => ('4')
        ];

        User::create($inforegister);

        $infologin = $request->only('email', 'password');

        if (Auth::attempt($infologin)) {
            $user = Auth::user();
            if ($user->level == '1') {
                return redirect()->intended('admin');
            } elseif ($user->level == '2') {
                return redirect()->intended('kasir');
            } elseif ($user->level == '3') {
                return redirect()->intended('guru');
            } elseif ($user->level == '4') {
                return redirect()->intended('siswa');
            }
        } else {
            return redirect()->intended('login')->withErrors('Maaf yang anda masukkan tidak terdaftar');
        }
        // return redirect('login')->with('success', 'Berhasil membuat akun baru');

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended('login');
    }
}
