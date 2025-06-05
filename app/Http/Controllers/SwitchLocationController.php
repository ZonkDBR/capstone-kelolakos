<?php

namespace App\Http\Controllers;

use App\Models\LokasiKos;
use Illuminate\Http\Request;

class SwitchLocationController extends Controller
{
    public function switchLocation(Request $request)
    {
        $locationId = $request->input('location_id');
        
        if ($locationId == 0) {
            session(['current_location_id' => 1]);
            $lokasi = LokasiKos::where('id_lokasi', $locationId)->first();
            session(['current_location_name' => $lokasi->nama_kos]);
            return redirect()->route('dashboard')->with('success', 'Viewing data for first locations');
        }

        $location = LokasiKos::find($locationId);

        if ($location) {
            session(['current_location_id' => $locationId]);
            $lokasi = LokasiKos::where('id_lokasi', $locationId)->first();
            session(['current_location_name' => $lokasi->nama_kos]);
            return redirect()->back()->with('success', 'Location changed successfully.');
        
        }

        return redirect()->back()->with('error', 'Location not found.');
    }
}
