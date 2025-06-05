<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use App\Models\Penghuni;
use App\Models\Kamar;
use Illuminate\Http\Request;

class SewaController extends Controller
{
    public function index()
    {
        $currentLocationId = session('current_location_id', 1);
        $kamar = Kamar::where('id_lokasi', $currentLocationId)->get();
        $sewa = Sewa::whereHas('kamar', function ($query) use ($currentLocationId) {
            $query->where('id_lokasi', $currentLocationId);
        })->with(['penghuni'])->get();
        return view('sewa.sewa', compact('sewa'));
    }

    public function create()
    {
        $currentLocationId = session('current_location_id', 1);
        $penghuni = Penghuni::where('id_lokasi', $currentLocationId)
            ->whereNotIn('id_penghuni', function ($query) {
                $query->select('id_penghuni')->from('sewa')->where('status', 'Aktif');})->get();
        $kamar = Kamar::where('id_lokasi', $currentLocationId)->where('status', 'Kosong')->get();
        return view('sewa.create', compact('penghuni', 'kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penghuni' => 'required|exists:penghuni,id_penghuni',
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'tanggal_sewa' => 'required|date',
            'status' => 'required|string|in:Aktif,Berakhir',
        ]);

        Kamar::where('id_kamar', $request->id_kamar)->update(['status' => 'Terisi']);

        Sewa::create($request->all());

        return redirect()->route('sewa.index')->with('success', 'Sewa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sewa = Sewa::findOrFail($id);
        $currentLocationId = session('current_location_id', 1);
        $penghuni = Penghuni::where('id_lokasi', $currentLocationId)
        ->where(function ($query) use ($sewa) {
            $query->whereNotIn('id_penghuni', function ($subquery) {
                $subquery->select('id_penghuni')->from('sewa')->where('status', 'Aktif');})->orWhere('id_penghuni', $sewa->id_penghuni);})->get();
        $kamar = Kamar::where('id_lokasi', $currentLocationId)->where('status', 'Kosong')->orWhere('id_kamar', $sewa->id_kamar)->get();
        return view('sewa.edit', compact('sewa', 'penghuni', 'kamar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_penghuni' => 'required|exists:penghuni,id_penghuni',
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'tanggal_sewa' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|string|in:Aktif,Berakhir',
        ]);

        $sewa = Sewa::findOrFail($id);
        $sewa->update([
            'id_penghuni' => $request->id_penghuni,
            'id_kamar' => $request->id_kamar,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status,
        ]);

        if ($request->status == 'Berakhir') {
            Kamar::where('id_kamar', $request->id_kamar)->update(['status' => 'Kosong']);
        } else {
            Kamar::where('id_kamar', $request->id_kamar)->update(['status' => 'Terisi']);
        }

        return redirect()->route('sewa.index')->with('success', 'Sewa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sewa = Sewa::findOrFail($id);
        $sewa->delete();

        Kamar::where('id_kamar', $sewa->id_kamar)->update(['status' => 'Kosong']);

        return redirect()->route('sewa.index')->with('success', 'Sewa berhasil dihapus.');
    }
}
