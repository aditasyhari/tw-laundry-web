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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 id="tgl-penjualan">
                    @if(empty($dari))
                        {{ $bulan }} {{ $tahun }} ({{ $jumlah }} Pesanan)
                    @else
                        {{ $dari }} - {{ $sampai }} ({{ $jumlah }} Pesanan)
                    @endif
                </h4>
            </div>
            <div class="ml-3" id="export"></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th>ID transaksi</th>
                                <th>Nama</th>
                                <th>No. WA</th>
                                <th>Nama Paket</th>
                                <th>Harga Paket (Kg)</th>
                                <th>Antar</th>
                                <th>Ambil</th>
                                <th>Pembayaran</th>
                                <th>Total (Kg)</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
@if(isset($dari_date) && isset($sampai_date))
    <script>
        var dari = "<?= $dari_date; ?>"; 
        var sampai = "<?= $sampai_date; ?>"
        console.log(dari); 
        console.log(sampai); 
    </script>
@else
    <script>
        var dari = null; 
        var sampai = null;
    </script>
@endif
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let _token   = $('meta[name="csrf-token"]').attr('content');

    $("#table-1").dataTable({
        processing: true,
        serverSide: true,
        ajax: {
            type: 'POST',
            url: "pesanan/list",
            data: {
                dari: dari,
                sampai: sampai,
                _token: _token
            }
        },
        columns: [
            { data: 'id_transaksi', name: 'id_transaki' },
            { data: 'nama', name: 'nama' },
            { data: 'no_wa', name: 'no_wa' },
            { data: 'nama_paket', name: 'nama_paket' },
            { data: 'harga_paket', name: 'harga_paket' },
            { data: 'antar', name: 'antar' },
            { data: 'ambil', name: 'ambil' },
            { data: 'pembayaran', name: 'pembayaran' },
            { data: 'total_kg', name: 'total_kg' },
            { data: 'total_pembayaran', name: 'total_pembayaran' },
            { data: 'status_cucian', name: 'status_cucian' },
        ],
        order: [[0, 'desc']],
        columnDefs: [
        {
          targets: 8,
          orderable: false,
          render: function (data, type, full, meta) {
            var total_kg = full['total_kg'];
            if(total_kg == null) {
                return '-';
            } else {
                return total_kg;
            }
          }
        },
        {
          targets: 9,
          orderable: false,
          render: function (data, type, full, meta) {
            var total_pembayaran = full['total_pembayaran'];
            if(total_pembayaran == null) {
                return '-';
            } else {
                return total_pembayaran;
            }
          }
        },
        {
          targets: 10,
          orderable: false,
          render: function (data, type, full, meta) {
            var status_cucian = full['status_cucian'];
            return '<span class="text-uppercase">'+status_cucian+'</span>'
          }
        }
      ],
    });

    new $.fn.dataTable.Buttons($("#table-1").dataTable(), {
        buttons: [
            'excelHtml5',
            'pdfHtml5'
        ]
    }).container().appendTo($('#export'));
</script>
@endsection