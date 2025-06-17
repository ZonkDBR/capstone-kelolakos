<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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
        $now = Carbon::now();
        $currentMonth = $now->format('Y-m');
        $transaksi = Transaksi::where('id_lokasi', $currentLocationId);
        $from = $request->input('from', $currentMonth);
        $to = $request->input('to', $currentMonth);

        if ($from != '') {
            $startDate = Carbon::createFromFormat('Y-m', $from)->startOfMonth()->toDateString();
            $transaksi->whereDate('tanggal', '>=', $startDate);
        }
        if ($to != '') {
            $endDate = Carbon::createFromFormat('Y-m', $to)->endOfMonth()->toDateString();
            $transaksi->whereDate('tanggal', '<=', $endDate);
        }
        $transaksi = $transaksi->with('lokasiKos')->get();

        $totalPemasukan = $transaksi->where('jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksi->where('jenis', 'Pengeluaran')->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        return view('transaksi.laporan', compact('transaksi', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo', 'from', 'to'));
    }

    public function pemasukan(Request $request)
    {
        $currentLocationId = session('current_location_id');
        $pemasukan = Transaksi::where('jenis', 'Pemasukan')->where('id_lokasi', $currentLocationId)->with('lokasiKos');
        $now = Carbon::now();
        $currentMonth = $now->format('Y-m');
        $from = $request->input('from', $currentMonth);
        $to = $request->input('to', $currentMonth);

        if ($from != '') {
            $startDate = Carbon::createFromFormat('Y-m', $from)->startOfMonth()->toDateString();
            $pemasukan->whereDate('tanggal', '>=', $startDate);
        }
        if ($to != '') {
            $endDate = Carbon::createFromFormat('Y-m', $to)->endOfMonth()->toDateString();
            $pemasukan->whereDate('tanggal', '<=', $endDate);
        }
        $pemasukan = $pemasukan->get();
        $totalPemasukan = $pemasukan->sum('nominal');
        return view('transaksi.pemasukan', compact('pemasukan', 'totalPemasukan', 'from', 'to'));
    }

    public function pengeluaran(Request $request)
    {
        $currentLocationId = session('current_location_id');
        $pengeluaran = Transaksi::where('jenis', 'Pengeluaran')->where('id_lokasi', $currentLocationId)->with('lokasiKos');
        $now = Carbon::now();
        $currentMonth = $now->format('Y-m');
        $from = $request->input('from', $currentMonth);
        $to = $request->input('to', $currentMonth);

        if ($from != '') {
            $startDate = Carbon::createFromFormat('Y-m', $from)->startOfMonth()->toDateString();
            $pengeluaran->whereDate('tanggal', '>=', $startDate);
        }
        if ($to != '') {
            $endDate = Carbon::createFromFormat('Y-m', $to)->endOfMonth()->toDateString();
            $pengeluaran->whereDate('tanggal', '<=', $endDate);
        }
        $pengeluaran = $pengeluaran->get();
        $totalPengeluaran = $pengeluaran->sum('nominal');
        return view('transaksi.pengeluaran', compact('pengeluaran', 'totalPengeluaran', 'from', 'to'));
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
        $now = Carbon::now();
        $currentMonth = $now->format('Y-m');
        $from = $request->input('from', $currentMonth);
        $to = $request->input('to', $currentMonth);

        if ($from != '') {
            $startDate = Carbon::createFromFormat('Y-m', $from)->startOfMonth()->toDateString();
            $transaksi->whereDate('tanggal', '>=', $startDate);
        }
        if ($to != '') {
            $endDate = Carbon::createFromFormat('Y-m', $to)->endOfMonth()->toDateString();
            $transaksi->whereDate('tanggal', '<=', $endDate);
        }
        $transaksi = $transaksi->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'No',
            'Lokasi Kos',
            'Jenis',
            'Sumber',
            'Nominal',
            'Tanggal',
            'Keterangan'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($transaksi as $item) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, optional($item->lokasiKos)->nama_kos ?? 'N/A');
            $sheet->setCellValue('C' . $row, $item->jenis);
            $sheet->setCellValue('D' . $row, $item->sumber);
            $sheet->setCellValue('E' . $row, 'Rp ' . number_format($item->nominal, 2, ',', '.'));
            $sheet->setCellValue('F' . $row, $item->tanggal);
            $sheet->setCellValue('G' . $row, $item->keterangan);
            $row++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(30);

        $sheet->getStyle('A1:G' . ($row - 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:G' . ($row - 1))->applyFromArray($styleArray);

        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF4472C4');
        $sheet->getStyle('A1:G1')->getFont()->getColor()->setARGB('FFFFFFFF');

        $writer = new Xlsx($spreadsheet);
        $response = new StreamedResponse(function () use ($writer) {
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
        $now = Carbon::now();
        $currentMonth = $now->format('Y-m');
        $from = $request->input('from', $currentMonth);
        $to = $request->input('to', $currentMonth);

        if ($from != '') {
            $startDate = Carbon::createFromFormat('Y-m', $from)->startOfMonth()->toDateString();
            $transaksi->whereDate('tanggal', '>=', $startDate);
        }
        if ($to != '') {
            $endDate = Carbon::createFromFormat('Y-m', $to)->endOfMonth()->toDateString();
            $transaksi->whereDate('tanggal', '<=', $endDate);
        }
        $transaksi = $transaksi->with('lokasiKos')->get();
        $totalPemasukan = $transaksi->where('jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksi->where('jenis', 'Pengeluaran')->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;
        $pdf = Pdf::loadView('transaksi.export_pdf', compact('transaksi', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo'));
        return $pdf->download('laporan-transaksi.pdf');
    }
}
