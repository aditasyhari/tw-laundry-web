@extends('backend.layouts.index')

@section('title') List User Customer @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>Data Customer</h4>
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus-circle"></i> Tambah Customer</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. WA</th>
                                <th>Alamat</th>
                                <th>Role</th>
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

<!-- modal tambah -->
<div class="modal fade" id="tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahLabel">Tambah Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label for="frist_name">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="nama" value="{{ old('nama') }}" autofocus required>
                    @error('nama')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="form-group col-6">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                      <div class="invalid-feedback"></div>
                      @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="last_name">No. Whatsapp</label>
                      <input type="number" class="form-control @error('no_wa') is-invalid @enderror" value="{{ old('no_wa') }}" name="no_wa" required>
                      @error('no_wa')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name">Alamat</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
             </form>
      </div>
    </div>
  </div>
</div>

<!-- modal edit -->
<div class="modal fade" id="edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Edit Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="form_edit" action="" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="frist_name">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nama" name="nama" value="" autofocus required>
                    @error('nama')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="form-group col-6">
                      <label for="email">Email</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" id="email_edit" name="email" required>
                      <div class="invalid-feedback"></div>
                      @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="last_name">No. Whatsapp</label>
                      <input type="number" class="form-control @error('no_wa') is-invalid @enderror" value="" id="no_wa" name="no_wa" required>
                      @error('no_wa')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name">Alamat</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" required></textarea>
                    @error('alamat')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Perbarui</button>
             </form>
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
            url: "customer/list",
        },
        columns: [
            { data: 'nama', name: 'nama' },
            { data: 'email', name: 'email' },
            { data: 'no_wa', name: 'no_wa' },
            { data: 'alamat', name: 'alamat' },
            { data: 'role', name: 'role' },
            { data: '', orderable: false },
        ],
        order: [[0, 'desc']],
        columnDefs: [
        {
          targets: -1,
          orderable: false,
          render: function (data, type, full, meta) {
            var id_user = full['id'];
            return (
              '<div class="btn-group">' +
                '<a class="btn dropdown-toggle hide-arrow" data-toggle="dropdown">Aksi</a>' +
                '<div class="dropdown-menu dropdown-menu-right">' +
                '<a href="javascript:;" class="dropdown-item" data-toggle="modal" data-target="#edit" onclick="edit(this, '+ id_user +')"><i class="fas fa-pen"></i> Edit</a>' +
                '<a href="javascript:;" class="dropdown-item delete-record" onclick="hapus('+ id_user +')"><i class="fas fa-trash"></i> Hapus</a>' +
                '</div>' +
              '</div>'
            );
          }
        }
      ],
    });

    function edit(this_el, id_user) {
        var url = '/user/customer/update/'+id_user;
        var tr_el = this_el.closest('tr');
        var row = $("#table-1").DataTable().row(tr_el);
        var row_data = row.data();
        console.log(row_data.email);
        $('#nama').val(row_data.nama);
        $('#email_edit').val(row_data.email);
        $('#no_wa').val(row_data.no_wa);
        $('#alamat').val(row_data.alamat);
        $('#form_edit').attr('action', url);
    }

    function hapus(e) {
        var url = 'customer/delete/'+e;

        swal({
            title             : "Apakah Anda Yakin ?",
            text              : "Data Yang Sudah Dihapus Tidak Bisa Dikembalikan!",
            icon              : "warning",
            showCancelButton  : true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor : "#d33",
            confirmButtonText : "Ya, Tetap Hapus!"
        }).then((result) => {
            $.ajax({
                url    : url,
                type   : "delete",
                success: function(data) {
                    $('#table-1').DataTable().ajax.reload();
                    swal({
                        icon: 'success',
                        title: 'Data Pelanggan berhasil dihapus.',
                        showConfirmButton: false,
                        timer: 2200,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                }
            })
            // if(result.value) {
            // }
        })
    }

</script>
@endsection