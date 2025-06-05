<?php

namespace App\Http\Controllers\User;

use App\Models\Penghuni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    /**
     * Display the resource.
     */
    public function show()
    {
        // Get user loged in
        $user = Auth::user();

        $penghuni = Penghuni::where('id_user', $user->id_user)->with('user')->first();


        $data = [
            'penghuni' => $penghuni,
        ];

        return view('user.profile', $data);
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        // Get user loged in
        $user = Auth::user();

        $penghuni = Penghuni::where('id_user', $user->id_user)->with('user')->first();

        $data = [
            'penghuni' => $penghuni,
        ];

        return view('user.profile-edit', $data);
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request)
    {
        try {
            // Validasi data request
            $request->validate([
                'nama_penghuni' => 'required|string|max:100',
                'no_ktp' => 'required|string|max:20',
                'no_hp' => 'required|string|max:15',
                'alamat_asal' => 'required|string',
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            // Mendapatkan user yang sedang login
            $user = Auth::user();

            // Update data Penghuni dan User menggunakan Eloquent ORM
            $penghuni = Penghuni::where('id_user', $user->id_user)->firstOrFail();

            // Update tabel Penghuni
            $penghuni->update([
                'nama_penghuni' => $request->nama_penghuni,
                'no_ktp' => $request->no_ktp,
                'no_hp' => $request->no_hp,
                'alamat_asal' => $request->alamat_asal,
            ]);

            // Menyiapkan data user untuk update
            $userData = [
                'name' => $request->username,
                'email' => $request->email,
            ];

            // Update password jika ada
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            // Update tabel User
            $user->update($userData);

            Alert::success('Success', 'Your profile has been updated successfully!');
            return redirect()->route('profile.show');
        } catch (\Exception $e) {
            Alert::error('Error', 'There was an error updating your profile' . $e->getMessage());
            return redirect()->back();
        }
    }
}
