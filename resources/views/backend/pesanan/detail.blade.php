@extends('backend.layouts.index')

@section('title') Detail Pesanan @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <h4>DETAIL</h4>
        <hr>
    </div>
</div>
<div class="row mt-sm-4">
    <div class="col-12 col-md-12 col-lg-4">
        <div class="card">
            <div class="card-header">
            <h4>Detail Pelanggan</h4>
            </div>
            <div class="card-body">
                <div class="py-4">
                    <p class="clearfix">
                        <span class="float-left">
                            Nama
                        </span>
                        <span class="float-right">
                            {{ $pesanan->nama }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            No. WA
                        </span>
                        <span class="float-right">
                            {{ $pesanan->no_wa }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Email
                        </span>
                        <span class="float-right">
                            {{ $pesanan->email }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Alamat
                        </span>
                        <span class="float-right">
                            {{ $pesanan->alamat }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
            <h4>Detail Pesanan</h4>
            </div>
            <div class="card-body">
                <div class="py-4">
                    <p class="clearfix">
                        <span class="float-left">
                            ID Transaksi
                        </span>
                        <span class="float-right text-uppercase">
                            {{ $pesanan->id_transaksi }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Status Cucian
                        </span>
                        <span class="float-right text-uppercase">
                            {{ $pesanan->status_cucian }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Paket Cucian
                        </span>
                        <span class="float-right">
                            {{ $pesanan->nama_paket }} ({{ $pesanan->jenis_paket }})
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Antar Cucian
                        </span>
                        <span class="float-right text-uppercase">
                            {{ $pesanan->antar }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Ambil Cucian
                        </span>
                        <span class="float-right text-uppercase">
                            {{ $pesanan->ambil }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Harga / Kg
                        </span>
                        <span class="float-right">
                            Rp {{ number_format($pesanan->harga_paket, 0, ".", ".") }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Pembayaran
                        </span>
                        <span class="float-right text-uppercase">
                            {{ $pesanan->pembayaran }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>
                    List Item
                </h4>
                <h5 class="text-uppercase">{{ $pesanan->nama_paket }} (<span class="text-warning">{{ $pesanan->status_cucian }}</span>)</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <label for="">Nama Barang</label>
                    </div>
                    <div class="col-3">
                        <label for="">Ciri - ciri</label>
                    </div>
                    <div class="col-3">
                        <label for="">Jumlah</label>
                    </div>
                </div>
                <form action="{{ url('/list-pesanan/detail/validasi/'.$pesanan->id) }}" id="form1" method="post">
                @csrf
                <div class="field_wrapper">
                    @foreach($list_pesanan as $lp)
                    <div class="row mt-3">
                        <div class="col-3">
                            <input type="text" name="nama_barang[]" class="form-control" value="{{ $lp->nama_barang }}" required/>
                        </div>
                        <div class="col-3">
                            <input type="text" name="ciri_barang[]" class="form-control" value="{{ $lp->ciri_ciri }}" required/>
                        </div>
                        <div class="col-3">
                            <input type="number" name="jumlah_barang[]" class="form-control" min="1" value="{{ $lp->jumlah }}" required/>
                        </div>
                        @if(Auth::user()->role != 'customer')
                        <div class="col-3">
                            @if($loop->first)
                            <a href="javascript:void(0);" class="add_button" title="Tambah Barang"><i data-feather="plus-circle"></i></a>
                            @else
                            <a href="javascript:void(0);" class="remove_button">Hapus</a>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @if(Auth::user()->role == 'customer')
            <div class="card-footer">
                <div class="row mb-2">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="">Total KG</label>
                            <h3>
                                @if($pesanan->status_cucian == 'menunggu')
                                    -
                                @else
                                    {{ $pesanan->total_kg }} Kg
                                @endif
                            </h3>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label for="">Total Bayar</label>
                            <h3>
                                @if($pesanan->status_cucian == 'menunggu')
                                    Rp -
                                @else
                                    Rp {{ $pesanan->total_pembayaran }}
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            @else
            <div class="card-footer">
                @if($pesanan->status_cucian == 'menunggu')
                <div class="row mb-2">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="">Total KG</label>
                            <input type="text" id="total_kg" name="total_kg" class="form-control" placeholder="contoh: 1 atau 1.5" required>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label for="">Total Bayar</label>
                            <h3>
                                Rp <span id="show_pembayaran">0</span>
                            </h3>
                            <input type="hidden" id="total_pembayaran" name="total_pembayaran" value="0" class="form-control" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Validasi Pesanan</button>
                @else
                    <div class="row mb-2">
                        <div class="col-5">
                            <div class="form-group">
                                <label for="">Total KG</label>
                                <h3>
                                    {{ $pesanan->total_kg }} Kg
                                </h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="">Total Bayar</label>
                                <h3>
                                    Rp {{ number_format($pesanan->total_pembayaran, 0, ".", ".") }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    @if($pesanan->status_cucian == 'selesai')
                        @if($pesanan->status_diambil == 'belum')
                            <button onclick="sendnotif('{{ $pesanan->id }}')" class="btn btn-primary">Kirim Notif WA</button>
                        @endif
                    @else
                        <button onclick="orderdone('{{ $pesanan->id }}')" class="btn btn-primary">Selesai</button>
                    @endif
                @endif
                </form>
            </div>
            @endif
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Aksi</h4>
            </div>
            <div class="card-body">
                @switch(Auth::user()->role)
                    @case('customer')
                        @if($pesanan->status_bayar == 'belum')
                            @if($pesanan->status_cucian != 'menunggu')
                                @if($pesanan->pembayaran == 'dana')
                                    @if($pesanan->bukti_bayar != null)
                                        <h5><b>Sudah unggah bukti pembayaran. Tunggu validasi admin.</b></h5>
                                    @else
                                        <form action="{{ url('/list-pesanan/detail/upload-bukti/'.$pesanan->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Upload Bukti Pembayaran Dana</label>
                                                <input type="file" name="bukti_bayar" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </form>
                                    @endif
                                @else
                                    <h5><b>Pembayaran dilakukakan dengan COD</b></h5>
                                @endif
                            @else
                                <h5><b>Tunggu Validasi terlebih dahulu.</b></h5>
                            @endif
                        @else
                            <h5><b>Pembayaran sudah divalidasi. Transaksi Selesai.</b></h5>
                            <h6>
                                <a href="{{ url('/storage/images/bukti-tf/'.$pesanan->bukti_bayar) }}" class="mt-3" target="_blank">Lihat Bukti Pembayaran</a>
                            </h6>
                        @endif
                        @break
                    @case('admin')
                        @if($pesanan->status_bayar == 'belum')
                            @if($pesanan->pembayaran == 'dana')
                                @if($pesanan->bukti_bayar != null)
                                    <h4>Validasi Bukti Bayar</h4>
                                    <h6>
                                        <a href="{{ url('/storage/images/bukti-tf/'.$pesanan->bukti_bayar) }}" class="mt-3" target="_blank">Lihat Bukti Pembayaran</a>
                                    </h6>
                                    <div class="form-group d-flex flex-row mt-3">
                                        <form action="{{ url('/list-pesanan/detail/terima-bukti/'.$pesanan->id) }}" method="post" class="mr-2">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Validasi</button>
                                        </form>
                                        <form action="{{ url('/list-pesanan/detail/tolak-bukti/'.$pesanan->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <h5><b>- Validasi Cucian</b></h5>
                                    <h5><b>- Tunggu Pelanggan Upload Bukti Pembayaran</b></h5>
                                @endif
                            @else
                                <h5><b>Pembayaran dilakukan dengan COD</b></h5>
                                @if($pesanan->status_bayar == 'belum' && $pesanan->status_cucian != 'menunggu')
                                    <form action="{{ url('/list-pesanan/detail/bayar-cod/'.$pesanan->id) }}" method="post" class="mt-3">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Validasi Pembayaran</button>
                                    </form>
                                @endif
                            @endif
                        @else
                            <h5><b>Transaksi Selesai</b></h5>
                            @if($pesanan->pembayaran == 'dana')
                                <h6>
                                    <a href="{{ url('/storage/images/bukti-tf/'.$pesanan->bukti_bayar) }}" class="mt-3" target="_blank">Lihat Bukti Pembayaran</a>
                                </h6>
                            @endif
                        @endif
                        @break
                    @default
                        @break
                @endswitch
            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script>
    var form1 = $("#form1");

    function orderdone(id) {
        var url_action = '/list-pesanan/detail/order-selesai/'+id;
        form1.attr('action', url_action);
        form1.submit();
    }

    function sendnotif(id) {
        var url_action = '/list-pesanan/detail/send-notif/'+id;
        form1.attr('action', url_action);
        form1.submit();
    }

    var maxField = 20;
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper');
    var fieldHTML = `
    <div class="row mt-3">
        <div class="col-3">
            <input type="text" name="nama_barang[]" class="form-control" required aria-invalid="false" />
        </div>
        <div class="col-3">
            <input type="text" name="ciri_barang[]" class="form-control" required aria-invalid="false" />
        </div>
        <div class="col-3">
            <input type="number" name="jumlah_barang[]" class="form-control" min="1" required aria-invalid="false" />
        </div>
        <div class="col-3">
            <a href="javascript:void(0);" class="remove_button">Hapus</a>
        </div>
    </div>
    `;
    var x = 1;
    
    $(addButton).click(function(){
        if(x < maxField){ 
            x++;
            $(wrapper).append(fieldHTML);
        }
    });
    
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).closest('.row').remove();
        x--;
    });

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

    // hitung total pembayaran
    $("#total_kg").keyup(function() {
        var hargaPaket = '{{ $pesanan->harga_paket }}';
        var totalKg = $('#total_kg').val();
        var totalBayar = hargaPaket * totalKg;
        $('#total_pembayaran').val(totalBayar);
        $('#show_pembayaran').html(formatRupiah(totalBayar));
    });
</script>
@endsection