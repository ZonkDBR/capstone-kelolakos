<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\LokasiKos;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KamarController extends Controller
{
    public function index()
    {
        $currentLocationId = session('current_location_id');
        $kamar = Kamar::where('id_lokasi', $currentLocationId)->get();

        return view('kamar.kamar', compact('kamar'));
    }

    public function create()
    {
        return view('kamar.create');
    }

    public function store(Request $request)
    {
        $currentLocationId = session('current_location_id');
        $maxKamar = LokasiKos::where('id_lokasi', $currentLocationId)->value('kapasitas_total');
        $currentKamar = Kamar::where('id_lokasi', $currentLocationId)->count();

        if ($maxKamar == $currentKamar) {
            Alert::error('Error', 'Room capacity reached. Cannot add more rooms!');
            return redirect('/kamar');
        }

        $request->validate([
            'nomor_kamar' => 'required|string|unique:kamar',
            'tipe_kamar' => 'required|string',
            'fasilitas' => 'nullable|string',
            'harga' => 'required|numeric',
            'status' => 'required|string|in:Kosong,Terisi',
        ]);

        Kamar::create([
            'id_lokasi' => $currentLocationId,
            'nomor_kamar' => $request->nomor_kamar,
            'tipe_kamar' => $request->tipe_kamar,
            'fasilitas' => $request->fasilitas,
            'harga' => $request->harga,
            'status' => $request->status
        ]);

        Alert::success('Success', 'Room added successfully!');
        return redirect('/kamar');
    }

    public function edit($id_kamar)
    {
        $kamar = Kamar::findOrFail($id_kamar);
        return view('kamar.edit', compact('kamar'));
    }

    public function update(Request $request, $id_kamar)
    {
        $request->validate([
            'nomor_kamar' => 'required|string',
            'tipe_kamar' => 'required|string',
            'fasilitas' => 'nullable|string',
            'harga' => 'required|numeric',
            'status' => 'required|string|in:Kosong,Terisi',
        ]);

        $kamar = Kamar::findOrFail($id_kamar);
        $kamar->update([
            'nomor_kamar' => $request->nomor_kamar,
            'tipe_kamar' => $request->tipe_kamar,
            'fasilitas' => $request->fasilitas,
            'harga' => $request->harga,
            'status' => $request->status
        ]);

        Alert::success('Success', 'Room updated successfully!');
        return redirect('/kamar');
    }

    public function destroy($id_kamar)
    {
        try {
            $hapusKamar = Kamar::findOrFail($id_kamar);
            $hapusKamar->delete();

            Alert::success('Success', 'Room deleted successfully!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete room. This room has related data!');
        }

        return redirect('/kamar');
    }
}
