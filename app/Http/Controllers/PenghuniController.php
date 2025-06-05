<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PenghuniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentLocationId = session('current_location_id');
        $penghuni = Penghuni::where('id_lokasi', $currentLocationId)->get();

        return view('penghuni.penghuni', compact('penghuni'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penghuni.penghuni-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentLocationId = session('current_location_id');

        $request->validate([
            'nama_penghuni' => 'required|string|max:255',
            'no_ktp' => 'required|string|unique:penghuni,no_ktp|max:20',
            'no_hp' => 'required|string|max:15',
            'alamat_asal' => 'required|string',
        ]);

        Penghuni::create([
            'id_lokasi' => $currentLocationId,
            'nama_penghuni' => $request->nama_penghuni,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'alamat_asal' => $request->alamat_asal,
        ]);

        Alert::success('Success', 'Penghuni has been successfully saved!');
        return redirect('/penghuni');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penghuni $penghuni)
    {
        return view('penghuni.penghuni-edit', compact('penghuni'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penghuni $penghuni)
    {
        $request->validate([
            'nama_penghuni' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:20|unique:penghuni,no_ktp,' . $penghuni->id_penghuni . ',id_penghuni',
            'no_hp' => 'required|string|max:15',
            'alamat_asal' => 'required|string',
        ]);

        $penghuni->update([
            'nama_penghuni' => $request->nama_penghuni,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'alamat_asal' => $request->alamat_asal,
        ]);

        Alert::success('Success', 'Penghuni has been successfully updated!');
        return redirect('/penghuni');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penghuni $penghuni)
    {
        try {
            $penghuni->delete();
            Alert::success('Success', 'Penghuni has been successfully updated!');

            return redirect('/penghuni');
        } catch (\Exception $e) {
            Alert::error('Error', 'Cant deleted, Penghuni already used!');

            return redirect('/penghuni');
        }
    }
}
