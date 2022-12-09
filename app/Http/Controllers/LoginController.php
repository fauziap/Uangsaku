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

        Session::flash('username', $request->username);
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Tolong masukkan username',
            'password.required' => 'Tolong masukkan password'
        ]);

        // cara yang berbeda
        $infologin = $request->only('username', 'password');

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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended('login');
    }

    public function create()
    {
        return view('login/register');
    }

    public function store(Request $request)
    {

        Session::flash('name', $request->name);
        Session::flash('username', $request->username);

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6'
        ], [
            'name.required' => 'Nama tolong di isi',
            'username.required' => 'username tolong di isi',
            'username.unique' => 'username sudah digunakan',
            'password.required' => 'password wajib di isi',
            'password.min' => 'password minimal 6 karakter',
        ]);

        $inforegister = [

            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'level' => ('4')
        ];

        User::create($inforegister);

        $infologin = $request->only('username', 'password');

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
}
