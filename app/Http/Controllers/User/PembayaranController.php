<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get user loged in
        $user = Auth::user();

        // Get data from the database by user id
        $pembayaran = Pembayaran::whereHas('sewa.penghuni', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })->get();

        // Modify date to formated date e.g 1 Januari 2025
        $pembayaran->map(function ($item) {
            $item->tanggal_bayar = Carbon::parse($item->tanggal_bayar)->translatedFormat('j F Y');
            // Format nominal
            $item->nominal = 'Rp' . number_format($item->nominal, 0, ',', '.');
            return $item;
        });

        // Prepare data for the view
        $data = [
            'pembayaran' => $pembayaran,
        ];

        return view('user.pembayaran', $data);
    }
}