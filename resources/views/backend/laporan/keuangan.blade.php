@extends('backend.layouts.index')

@section('title') Laporan Pesanan @endsection

@section('content')
<h4>LAPORAN KEUANGAN</h4>
<hr>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <select name="bulan" id="bulan" class="form-control" required>
                                <option disabled selected>Pilih Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col">
                            <select name="tahun" id="tahun" class="form-control" required>
                                <option disabled selected>Pilih Tahun</option>
                            </select>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
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
            <h4>{{ $bulan }} {{ $tahun }}</h4>
            </div>
            <div class="card-body">
                <div class="recent-report__chart">
                    <div id="report-keuangan"></div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script>
    // get previous year
    const date = new Date();
    var year = date.getFullYear();

    for(var i = 0; i < 3; i++) {
        var old_year = year-i;
        $('#tahun').append(`<option value="${old_year}">${old_year}</option>`);
    }
    // end year

    // format rupiah
    var formatRupiah = function(num){
      var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
      if(str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
      }
      str = str.split("").reverse();
      for(var j = 0, len = str.length; j < len; j++) {
        if(str[j] != ".") {
          output.push(str[j]);
          if(i%3 == 0 && j < (len - 1)) {
            output.push(".");
          }
          i++;
        }
      }
      formatted = output.reverse().join("");
      return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
    };
    // end format rupiah
    
    // chart
    var total = <?= json_encode($total); ?>;
    var nama_paket = <?= json_encode($nama_paket); ?>;
    console.log(total);
    var options2 = {
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
                console.log(val);
                return "Rp " + formatRupiah(val);
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#9aa0ac"]
            }
        },
        series: [{
            name: 'Total',
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
                    return "Rp " + formatRupiah(val);
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

    var report2 = new ApexCharts(
        document.querySelector("#report-keuangan"),
        options2
    );

    report2.render();
    // end chart
</script>
@endsection