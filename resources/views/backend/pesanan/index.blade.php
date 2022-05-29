@extends('backend.layouts.index')

@section('title') List Pesanan @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>List Pesanan</h4>
            </div>
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
                                <th></th>
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
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#table-1").dataTable({
        processing: true,
        serverSide: true,
        ajax: {
            type: 'POST',
            url: "list-pesanan/list",
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
            { data: '', orderable: false },
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
          targets: -1,
          orderable: false,
          render: function (data, type, full, meta) {
            var id_transaksi = full['id_transaksi'];
            return (
                '<a href="list-pesanan/detail/'+ id_transaksi +'" class="btn btn-primary btn-small">Detail</a>'
            );
          }
        }
      ],
    });

</script>
@endsection