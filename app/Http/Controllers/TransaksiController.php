<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index()
    {
        return redirect()->route('/transaksi/laporan');
    }

    public function create()
    {
        return view('transaksi.create');
    }

    public function laporan(Request $request)
    {
        $currentLocationId = session('current_location_id');
        $transaksi = Transaksi::where('id_lokasi', $currentLocationId);

        if ($request->has('from') && $request->from != '') {
            $transaksi->whereDate('tanggal', '>=', $request->from . '-01');
        }
        if ($request->has('to') && $request->to != '') {
            $transaksi->whereDate('tanggal', '<=', $request->to . '-31');
        }
        $transaksi = $transaksi->with('lokasiKos')->get();

        $totalPemasukan = $transaksi->where('jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksi->where('jenis', 'Pengeluaran')->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        return view('transaksi.laporan', compact('transaksi', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo'));
    }

    public function pemasukan(Request $request)
    {
        $currentLocationId = session('current_location_id');
        $pemasukan = Transaksi::where('jenis', 'Pemasukan')->where('id_lokasi', $currentLocationId)->with('lokasiKos');
        if ($request->has('from') && $request->from != '') {
            $pemasukan->whereDate('tanggal', '>=', $request->from . '-01'); // Start of the month
        }
        if ($request->has('to') && $request->to != '') {
            $pemasukan->whereDate('tanggal', '<=', $request->to . '-31'); // End of the month
        }
        $pemasukan = $pemasukan->get();
        $totalPemasukan = $pemasukan->sum('nominal');
        return view('transaksi.pemasukan', compact('pemasukan', 'totalPemasukan'));
    }

    public function pengeluaran(Request $request)
    {
        $currentLocationId = session('current_location_id');
        $pengeluaran = Transaksi::where('jenis', 'Pengeluaran')->where('id_lokasi', $currentLocationId)->with('lokasiKos');
        if ($request->has('from') && $request->from != '') {
            $pengeluaran->whereDate('tanggal', '>=', $request->from . '-01'); // Start of the month
        }
        if ($request->has('to') && $request->to != '') {
            $pengeluaran->whereDate('tanggal', '<=', $request->to . '-31'); // End of the month
        }
        $pengeluaran = $pengeluaran->get();
        $totalPengeluaran = $pengeluaran->sum('nominal');
        return view('transaksi.pengeluaran', compact('pengeluaran', 'totalPengeluaran'));
    }

    public function store(Request $request)
    {
        $currentLocationId = session('current_location_id');

        $request->validate([
            'jenis' => 'required|string|in:Pemasukan,Pengeluaran',
            'sumber' => 'required|string',
            'nominal' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Transaksi::create([
            'id_lokasi' => $currentLocationId,
            'jenis' => $request->jenis,
            'sumber' => $request->sumber,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan
        ]);

        if ($request->jenis == 'Pemasukan') {
            return redirect()->route('transaksi.pemasukan')->with('success', 'Pemasukan added successfully!');
        } else {
            return redirect()->route('transaksi.pengeluaran')->with('success', 'Pengeluaran added successfully!');
        }
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string|in:Pemasukan,Pengeluaran',
            'sumber' => 'required|string',
            'nominal' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'jenis' => $request->jenis,
            'sumber' => $request->sumber,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan
        ]);

        if ($request->jenis == 'Pemasukan') {
            return redirect()->route('transaksi.pemasukan')->with('success', 'Pemasukan berhasil diperbarui!');
        } else {
            return redirect()->route('transaksi.pengeluaran')->with('success', 'Pengeluaran berhasil diperbarui!');
        }
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        if ($transaksi->jenis == 'Pemasukan') {
            return redirect()->route('transaksi.pemasukan')->with('success', 'Pemasukan berhasil dihapus!');
        } else {
            return redirect()->route('transaksi.pengeluaran')->with('success', 'Pengeluaran berhasil dihapus!');
        }
    }

    public function exportExcel(Request $request)
    {
        $currentLocationId = session('current_location_id');
        $transaksi = Transaksi::where('id_lokasi', $currentLocationId)->with('lokasiKos');

        if ($request->has('from') && $request->from != '') {
            $transaksi->whereDate('tanggal', '>=', $request->from . '-01');
        }
        if ($request->has('to') && $request->to != '') {
            $transaksi->whereDate('tanggal', '<=', $request->to . '-31');
        }
        $transaksi = $transaksi->with('lokasiKos')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Lokasi Kos');
        $sheet->setCellValue('C1', 'Jenis');
        $sheet->setCellValue('D1', 'Sumber');
        $sheet->setCellValue('E1', 'Nominal');
        $sheet->setCellValue('F1', 'Tanggal');
        $sheet->setCellValue('G1', 'Keterangan');

        $row = 2;
        foreach ($transaksi as $item) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, $item->lokasiKos->nama);
            $sheet->setCellValue('C' . $row, $item->jenis);
            $sheet->setCellValue('D' . $row, $item->sumber);
            $sheet->setCellValue('E' . $row, $item->nominal);
            $sheet->setCellValue('F' . $row, $item->tanggal);
            $sheet->setCellValue('G' . $row, $item->keterangan);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $response = new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="laporan-transaksi.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }

    public function exportPdf(Request $request)
    {
        $currentLocationId = session('current_location_id', 1);
        $transaksi = Transaksi::where('id_lokasi', $currentLocationId)->with('lokasiKos');
        if ($request->has('from') && $request->from != '') {
            $transaksi->whereDate('tanggal', '>=', $request->from . '-01');
        }
        if ($request->has('to') && $request->to != '') {
            $transaksi->whereDate('tanggal', '<=', $request->to . '-31');
        }
        $transaksi = $transaksi->with('lokasiKos')->get();
        $totalPemasukan = $transaksi->where('jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksi->where('jenis', 'Pengeluaran')->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;
        $pdf = Pdf::loadView('transaksi.export_pdf', compact('transaksi', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo'));
        return $pdf->download('laporan-transaksi.pdf');
    }
}
