<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\LokasiKos;
use App\Models\Penghuni;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get the current location ID from the session
        $currentLocationId = session('current_location_id', 1);

        // Query rooms based on the current location
        $kamarFilled = Kamar::where('id_lokasi', $currentLocationId)
            ->where('status', 'Terisi')
            ->count();

        $kamarEmpty = Kamar::where('id_lokasi', $currentLocationId)
            ->where('status', 'Kosong')
            ->count();

        // Count residents who have a room assigned (id_kamar is not null)
        $penghuniCount = Penghuni::where('id_lokasi', $currentLocationId)
            ->whereNotNull('id_kamar')
            ->count();

        // Get the current month and year
        $currentMonth = date('m');
        $currentYear  = date('Y');

        // Calculate total income for the current month
        $totalPemasukanBulanIni = Transaksi::where('id_lokasi', $currentLocationId)
            ->where('jenis', 'Pemasukan')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('nominal');

        // Calculate total expenses for the current month
        $totalPengeluaranBulanIni = Transaksi::where('id_lokasi', $currentLocationId)
            ->where('jenis', 'Pengeluaran')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('nominal');

        // Calculate total income for the current year
        $totalPemasukanTahunIni = Transaksi::where('id_lokasi', $currentLocationId)
            ->where('jenis', 'Pemasukan')
            ->whereYear('tanggal', $currentYear)
            ->sum('nominal');

        // Calculate total expenses for the current year
        $totalPengeluaranTahunIni = Transaksi::where('id_lokasi', $currentLocationId)
            ->where('jenis', 'Pengeluaran')
            ->whereYear('tanggal', $currentYear)
            ->sum('nominal');

        // Format the totals to Indonesian Rupiah format (e.g., Rp 5.000.000)
        $totalPemasukanBulanIniFormatted   = 'Rp ' . number_format($totalPemasukanBulanIni, 0, ',', '.');
        $totalPengeluaranBulanIniFormatted = 'Rp ' . number_format($totalPengeluaranBulanIni, 0, ',', '.');
        $totalPemasukanTahunIniFormatted   = 'Rp ' . number_format($totalPemasukanTahunIni, 0, ',', '.');
        $totalPengeluaranTahunIniFormatted = 'Rp ' . number_format($totalPengeluaranTahunIni, 0, ',', '.');

        // Prepare data array to pass to the view
        $data = [
            'kamarTerisi'                 => $kamarFilled,
            'kamarKosong'                 => $kamarEmpty,
            'penghuniCount'               => $penghuniCount,
            'totalPemasukanBulanIni'      => $totalPemasukanBulanIniFormatted,
            'totalPengeluaranBulanIni'    => $totalPengeluaranBulanIniFormatted,
            'totalPemasukanTahunIni'      => $totalPemasukanTahunIniFormatted,
            'totalPengeluaranTahunIni'    => $totalPengeluaranTahunIniFormatted,
            'chartTotalPemasukanBulanIni' => $totalPemasukanBulanIni,
            'chartTotalPengeluaranBulanIni' => $totalPengeluaranBulanIni
        ];

        // Return the dashboard view with the data
        return view('dashboard.dashboard', $data);
    }
}
