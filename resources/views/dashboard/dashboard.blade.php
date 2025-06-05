@extends('template.main')
@section('title', 'Dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title')</h1>
                </div><!-- /.col -->
                <!--  -->
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3></h3>
                            <p>Kamar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-house-user"></i>
                        </div>
                        <a href="/kamar" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                {{--
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>
                            <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                --}}
                <!-- ./col -->
                {{--
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>
                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                --}}
                <!-- ./col -->
                {{--
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                --}}
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <!-- Property Information Section -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-3">Informasi Properti</h4>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $kamarTerisi }}</h3>
                            <p>Jumlah Kamar Disewa</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-house-user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $kamarKosong }}</h3>
                            <p>Jumlah Kamar Tersedia</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-home"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner text-white">
                            <h3>{{ $penghuniCount }}</h3>
                            <p>Jumlah Penghuni</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Information Section -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-3">Informasi Keuangan</h4>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalPemasukanBulanIni }}</h3>
                            <p>Pemasukan Bulan Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalPengeluaranBulanIni }}</h3>
                            <p>Pengeluaran Bulan Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalPemasukanTahunIni }}</h3>
                            <p>Pemasukan Tahun Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalPengeluaranTahunIni }}</h3>
                            <p>Pengeluaran Tahun Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pemasukan dan Pengeluaran Bulan Ini</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="incomeExpenseChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Chart.js -->
<script src="/assets/plugins/chart/chart.umd.min.js"></script>
<script>
    $(document).ready(function () {
        // Pastikan elemen canvas tersedia
        if ($('#incomeExpenseChart').length) {
            // Ambil context dari canvas menggunakan jQuery
            var incomeExpenseChartCanvas = $('#incomeExpenseChart').get(0).getContext('2d');

            // Ambil data dari Blade (pastikan data berupa angka)
            var pemasukan = {!! json_encode($chartTotalPemasukanBulanIni) !!};
            var pengeluaran = {!! json_encode($chartTotalPengeluaranBulanIni) !!};

            var incomeExpenseData = {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    data: [pemasukan, pengeluaran],
                    backgroundColor: ['#00a65a', '#f56954'],
                    borderWidth: 1
                }]
            };

            // Opsi chart dengan properti tooltip sesuai Chart.js v4
            var incomeExpenseChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var label = context.label || '';
                                var value = context.parsed || 0;
                                return label + ': Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            };

            // Buat chart dengan tipe pie
            new Chart(incomeExpenseChartCanvas, {
                type: 'pie',
                data: incomeExpenseData,
                options: incomeExpenseChartOptions
            });
        } else {
            console.error("Canvas element #incomeExpenseChart tidak ditemukan.");
        }
    });
</script>



@endsection
