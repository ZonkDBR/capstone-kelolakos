<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sewa;
use App\Models\Pembayaran;
use App\Models\Transaksi;

class TagihanController extends Controller
{
    /**
     * Display a listing of the tagihan.
     */
    public function index()
    {
        // Get current month and year
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Get current location ID from session
        $currentLocationId = session('current_location_id');

        // Get all active sewa contracts with relationships for the current location
        $sewas = Sewa::where('status', 'Aktif')
            ->whereHas('kamar', function ($query) use ($currentLocationId) {
                $query->where('id_lokasi', $currentLocationId);
            })
            ->with(['penghuni', 'kamar'])
            ->get();

        // Add payment status to each sewa model
        $sewas = $sewas->map(function ($sewa) use ($currentMonth, $currentYear) {
            $sewa->dibayar = Pembayaran::where('id_sewa', $sewa->id_sewa)
                ->whereMonth('tanggal_bayar', $currentMonth)
                ->whereYear('tanggal_bayar', $currentYear)
                ->exists() ? 'Sudah' : 'Belum';
            return $sewa;
        });

        return view('tagihan.index', [
            'tagihans' => $sewas
        ]);
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create($id_sewa)
    {
        $sewa = Sewa::with('kamar', 'penghuni')->find($id_sewa);

        if (!$sewa) {
            return redirect()->route('tagihan.index')->with('error', 'Sewa tidak ditemukan');
        }

        // Check if payment already exists for current month
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $hasPaid = Pembayaran::where('id_sewa', $sewa->id_sewa)
            ->whereMonth('tanggal_bayar', $currentMonth)
            ->whereYear('tanggal_bayar', $currentYear)
            ->exists();

        if ($hasPaid) {
            return redirect()->route('tagihan.index')->with('error', 'Pembayaran sudah ada untuk bulan ini');
        }

        return view('tagihan.create', [
            'sewa' => $sewa
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_sewa' => 'required|exists:sewa,id_sewa',
            'nominal' => 'required|numeric|min:1',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|string',
            'periode_bayar' => 'required|string', // Add this line
        ]);

        try {
            $sewa = Sewa::find($validated['id_sewa']);
            $kamar = $sewa->kamar;

            $transaksi = Transaksi::create([
                'id_lokasi' => $kamar->id_lokasi,
                'jenis' => 'Pemasukan',
                'sumber' => 'Pembayaran Sewa',
                'nominal' => $validated['nominal'],
                'tanggal' => $validated['tanggal_bayar'],
                'keterangan' => $request->keterangan ?? 'Pembayaran sewa kamar'
            ]);

            $pembayaran = Pembayaran::create([
                'id_sewa' => $validated['id_sewa'],
                'nominal' => $validated['nominal'],
                'tanggal_bayar' => $validated['tanggal_bayar'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'keterangan' => $request->keterangan,
                'periode_bayar' => $validated['periode_bayar'], // Add this line
            ]);

            $sewa->update(['status_pembayaran' => 'Sudah']);

            return redirect()->route('tagihan.index')->with('success', 'Pembayaran berhasil direkam');
        } catch (\Exception $e) {
            return back()->withErrors('Error processing payment: ' . $e->getMessage())->withInput();
        }
    }
}
