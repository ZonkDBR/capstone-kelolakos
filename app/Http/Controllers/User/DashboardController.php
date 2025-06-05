<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get penghuni and sewa details
        $penghuni = $user->penghuni()->firstOrFail();
        $sewa = $penghuni->sewa()->firstOrFail();

        // Calculate rental days
        $tanggalSewa = Carbon::parse($sewa->tanggal_sewa);
        $tanggalSekarang = $sewa->status === 'Aktif' ? Carbon::now() : Carbon::parse($sewa->tanggal_selesai);
        $jumlahHariMenyewa = $tanggalSewa->diffInDays($tanggalSekarang);

        // Get room and location
        $kamar = $penghuni->kamar->nomor_kamar ?? null;
        $lokasi = $penghuni->lokasiKos->nama_kos ?? null;

        // Pass data to view
        return view('user.dashboard', compact('jumlahHariMenyewa', 'kamar', 'lokasi'));
    }
}
