<?php

namespace App\Http\Controllers;

use App\Models\LokasiKos;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class LokasiKosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentLocationId = session('current_location_id');   
        $lokasi = LokasiKos::orderBy('nama_kos', 'asc')->get();

        return view('lokasi.lokasi', [
            'lokasi' => $lokasi,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lokasi.lokasi-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kos' => 'required|max:100|unique:lokasi_kos',
            'alamat' => 'required',
            'kapasitas_total' => 'required',
            'kontak_pengelola' => 'required',
        ]);

        $lokasi = LokasiKos::create($request->all());

        Alert::success('Success', 'Lokasi has been saved !');
        return redirect('/lokasi');
    }

    /**
     * Display the specified resource.
     */
    public function show(LokasiKos $lokasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_lokasi)
    {
        $lokasi = LokasiKos::findOrFail($id_lokasi);

        return view('lokasi.lokasi-edit', [
            'lokasi' => $lokasi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_lokasi)
    {
        $validated = $request->validate([
            'nama_kos' => 'required|max:100|unique:lokasi_kos,nama_kos,' . $id_lokasi . ',id_lokasi',
            'alamat' => 'required',
            'kapasitas_total' => 'required',
            'kontak_pengelola' => 'required',
        ]);

        $lokasi = LokasiKos::findOrFail($id_lokasi);
        $lokasi->update($validated);

        Alert::info('Success', 'Lokasi has been updated !');
        return redirect('/lokasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_lokasi)
    {
        try {
            $deletedlokasi = LokasiKos::findOrFail($id_lokasi);

            $deletedlokasi->delete();

            Alert::error('Success', 'Lokasi has been deleted !');
            return redirect('/lokasi');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Lokasi already used !');
            return redirect('/lokasi');
        }
    }
}
