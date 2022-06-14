@extends('backend.layouts.index')

@section('title') Laporan Pesanan @endsection

@section('content')
<h4>LAPORAN PESANAN</h4>
<hr>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                               <label for="">Dari Tanggal</label>
                               <input type="date" name="dari" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                               <label for="">Sampai Tanggal</label>
                               <input type="date" name="sampai" class="form-control" required>
                            </div>
                        </div>
                     
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary d-inline">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h4 id="tgl-penjualan">
                @if(empty($dari))
                    {{ $bulan }} {{ $tahun }} ({{ number_format($jumlah, 0, ".", ".") }} Pesanan)
                @else
                    {{ $dari }} - {{ $sampai }} ({{ number_format($jumlah, 0, ".", ".") }} Pesanan)
                @endif
            </h4>
            </div>
            <div class="card-body">
                <div class="recent-report__chart">
                    <div id="report"></div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script src="{{ asset('backend/assets/jsPDF/dist/jspdf.debug.js') }}" type='text/javascript'></script>
<script>
    // chart
    var total = <?= json_encode($total); ?>;
    var nama_paket = <?= json_encode($nama_paket); ?>;
    var options = {
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
            text: 'Pesanan',
            floating: true,
            offsetY: 320,
            align: 'center',
            style: {
                color: '#9aa0ac'
            }
        },
    }

    var report = new ApexCharts(
        document.querySelector("#report"),
        options
    );

    report.render();

    $("div.apexcharts-menu").append("<div class='apexcharts-menu-item exportPDF' title='Download PDF' onclick='downloadPDF()' >Download PDF</div>");

    function downloadPDF() {
        report.dataURI().then((uri) => {
            // let pdf = new jsPDF();
            let pdf = new jsPDF('l', 'mm', [450, 120], false);

            pdf.text(10, 10, $("#tgl-penjualan").html());
            pdf.addImage(uri, 'JPEG', 10, 20);
            pdf.save("laporan-penjualan.pdf");
        });
    }
    // end chart
</script>
@endsection