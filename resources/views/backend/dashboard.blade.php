@extends('backend.layouts.index')

@section('title') Dashboard @endsection

@section('content')
@switch(Auth::user()->role)
    @case('customer')
        <h4>Selamat Datang, {{ Auth::user()->nama }}</h4>
        <hr>
        <section class="mt-5">
            <div class="row ">
                <div class="col-md-2 col-sm-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-statistic-4">
                                    <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Total Bulan ini</h5>
                                            <h2 class="mb-3 font-18">{{ $data['total_bulan'] }}</h2>
                                            <p class="mb-0">Order Cucian</p>
                                        </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('backend/assets/img/banner/1.png') }}" alt="">
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-statistic-4">
                                    <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15"> Total Semua</h5>
                                            <h2 class="mb-3 font-18">{{ $data['total_semua'] }}</h2>
                                            <p class="mb-0">Order Cucian</p>
                                        </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('backend/assets/img/banner/2.png') }}" alt="">
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pesanan Bulan ini</h4>
                        </div>
                        <div class="card-body">
                            <div class="recent-report__chart">
                                <div id="report-bulan"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @break
    @case('admin')
        <section class="section">
            <div class="row ">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Total Semua</h5>
                                <h2 class="mb-3 font-18">{{ number_format($data['total_pesanan_semua'], 0, ".", ".") }}</h2>
                                <p class="mb-0">Cucian</p>
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="{{ asset('backend/assets/img/banner/1.png') }}" alt="">
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15"> Total Pelanggan</h5>
                                <h2 class="mb-3 font-18">{{ number_format($data['total_pelanggan'], 0, ".", ".") }}</h2>
                                <p class="mb-0">User</p>
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="{{ asset('backend/assets/img/banner/2.png') }}" alt="">
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Total Cucian</h5>
                                <h2 class="mb-3 font-18">{{ number_format($data['total_pesanan_bulan'], 0, ".", ".") }}</h2>
                                <p class="mb-0">Bulan ini</p>
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="{{ asset('backend/assets/img/banner/3.png') }}" alt="">
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Pendapatan</h5>
                                <h2 class="mb-3 font-18">Rp {{ number_format($data['total_pendapatan_bulan'], 0, ".", ".") }}</h2>
                                <p class="mb-0">Bulan ini</p>
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="{{ asset('backend/assets/img/banner/4.png') }}" alt="">
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card ">
                    <div class="card-header">
                        <h4>Pesanan Bulan ini</h4>
                        <div class="card-header-action">
                            <a href="{{ url('/laporan/pesanan') }}" class="btn btn-primary">Lainnya</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="recent-report__chart">
                            <div id="report-bulan"></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

        </section>
        @break
    @case('kurir')
        <h4 class="text-center">Selamat Datang Kurir TW - Laundry</h4>
        <hr>
        <center>
            <img src="{{ asset('images/kurir.png') }}" alt="" class="img-fluid">
        </center>
        @break
@endswitch

@endsection

@section('js')
<script src="{{ asset('backend/assets/jsPDF/dist/jspdf.debug.js') }}" type='text/javascript'></script>
@switch(Auth::user()->role)
    @case('customer')
        <script>
            // chart
            var total = <?= json_encode($data['total']); ?>;
            var nama_paket = <?= json_encode($data['nama_paket']); ?>;
            var optionsMonth = {
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val + " order";
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#9aa0ac"]
                    }
                },
                series: [{
                    name: 'Total: ',
                    data: total
                }],
                xaxis: {
                    categories: nama_paket,
                    position: 'top',
                    labels: {
                        offsetY: -18,
                        style: {
                            colors: '#9aa0ac',
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        offsetY: -35,
        
                    }
                },
                fill: {
                    gradient: {
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [50, 0, 100, 100]
                    },
                },
                yaxis: {
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true,
                    },
                    labels: {
                        show: true,
                        formatter: function (val) {
                            return val + " order";
                        }
                    }
        
                },
                title: {
                    text: 'Per Bulan',
                    floating: true,
                    offsetY: 320,
                    align: 'center',
                    style: {
                        color: '#9aa0ac'
                    }
                },
            }
        
            var reportMonth = new ApexCharts(
                document.querySelector("#report-bulan"),
                optionsMonth
            );
        
            reportMonth.render();
        </script>
        @break
    @case('admin')
        <script>
            // chart
            var total = <?= json_encode($data['total']); ?>;
            var nama_paket = <?= json_encode($data['nama_paket']); ?>;
            var optionsMonth = {
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val + " order";
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#9aa0ac"]
                    }
                },
                series: [{
                    name: 'Total: ',
                    data: total
                }],
                xaxis: {
                    categories: nama_paket,
                    position: 'top',
                    labels: {
                        offsetY: -18,
                        style: {
                            colors: '#9aa0ac',
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        offsetY: -35,
        
                    }
                },
                fill: {
                    gradient: {
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [50, 0, 100, 100]
                    },
                },
                yaxis: {
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true,
                    },
                    labels: {
                        show: true,
                        formatter: function (val) {
                            return val + " order";
                        }
                    }
        
                },
                title: {
                    text: 'Per Bulan',
                    floating: true,
                    offsetY: 320,
                    align: 'center',
                    style: {
                        color: '#9aa0ac'
                    }
                },
            }
        
            var reportMonth = new ApexCharts(
                document.querySelector("#report-bulan"),
                optionsMonth
            );
        
            reportMonth.render();
        </script>
        @break
    @case('kurir')
        @break
@endswitch
<script>
    const Xmas95 = new Date();
    const options = { month: 'long'};
    let bulan = new Intl.DateTimeFormat('id-ID', options).format(Xmas95);
    $("div.apexcharts-menu").append("<div class='apexcharts-menu-item exportPDF' title='Download PDF' onclick='downloadPDF()' >Download PDF</div>");

    function downloadPDF() {
        reportMonth.dataURI().then((uri) => {
            // let pdf = new jsPDF();
            let pdf = new jsPDF('l', 'mm', [450, 120], false);

            pdf.text(10, 10, 'Pesanan Bulan '+bulan);
            pdf.addImage(uri, 'JPEG', 10, 20);
            pdf.save("laporan-penjualan.pdf");
        });
    }
</script>
@endsection