<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function create(): never
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request): never
    {
        abort(404);
    }

    /**
     * Display the resource.
     */
    public function show()
    {
        $user = Auth::user();

        return view('profile.profile', compact('user'));
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        $user = Auth::user();

        return view('profile.profile-edit', compact('user'));
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|min:8|confirmed',
        ]);

        try {
            $user->name  = $validated['username'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            Alert::success('Success', 'Profile has been updated!');
            return redirect()->route('admin-profile.show');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update profile');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }
}
