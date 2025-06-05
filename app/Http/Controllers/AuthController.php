<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\LokasiKos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Get the authenticated user
            $user = Auth::user();

            // Redirect based on role
            if ($user->role === 'admin') {

                // Set Session after login
                session(['current_location_id' => 1]);
                $lokasi = LokasiKos::where('id_lokasi', 1)->first();
                session(['current_location_name' => $lokasi->nama_kos]);

                Alert::success('Success', 'Login success! Redirecting to Admin Dashboard.');
                return redirect()->intended('/dashboard');
            } elseif ($user->role === 'user') {
                Alert::success('Success', 'Login success! Redirecting to User Dashboard.');
                return redirect()->intended('/user/dashboard');
            }

            // Default redirect if no role matches
            Alert::success('Success', 'Login success!');
            return redirect()->intended('/dashboard');
        } else {
            Alert::error('Error', 'Login failed!');
            return redirect('/login');
        }
    }

    public function register()
    {
        return view('auth.register', [
            'title' => 'Register',
        ]);
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'passwordConfirm' => 'required|same:password',
        ]);

        $validated['role'] = 'user';

        $validated['password'] = Hash::make($request['password']);

        // Create the user
        $user = User::create($validated);

        Alert::success('Success', 'Register user has been successfully!');
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::success('Success', 'Log out success!');
        return redirect('/login');
    }
}