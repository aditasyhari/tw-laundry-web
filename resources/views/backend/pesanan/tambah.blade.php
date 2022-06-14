@extends('backend.layouts.index')

@section('title') Pesanan @endsection

@section('css')
<style>
label {
  width: 100%;
  font-size: 1rem;
}

.card-input-element+.card {
  height: calc(36px + 2*1rem);
  -webkit-box-shadow: none;
  box-shadow: none;
  border: 2px solid transparent;
  border-radius: 4px;
}

.card-input-element+.card:hover {
  cursor: pointer;
}

.card-input-element:checked+.card {
  border: 2px solid #0be348;
  -webkit-transition: border .3s;
  -o-transition: border .3s;
  transition: border .3s;
}

.card-input-element:checked+.card::after {
  content: '\e5ca';
  color: #0be348;
  font-family: 'Material Icons';
  font-size: 24px;
  -webkit-animation-name: fadeInCheckbox;
  animation-name: fadeInCheckbox;
  -webkit-animation-duration: .5s;
  animation-duration: .5s;
  -webkit-animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.parent > .row {
    display: flex;
    align-items: center;
    height: 100%;
}

.c-body img {
    height: 400px;
    width: 100%;
    cursor: pointer;
    transition: transform 1s;
    object-fit: cover;
}
.c-body label {
    overflow: hidden;
    position: relative;
}

.imgbgchk:checked + label > .tick_container {
    opacity: 1;
}

.imgbgchk:checked + label > img {
    transform: scale(1.25);
    opacity: 0.3;
}

.tick_container {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    cursor: pointer;
    text-align: center;
}
.tick {
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    padding: 6px 12px;
    height: 40px;
    width: 40px;
    border-radius: 100%;
}

@-webkit-keyframes fadeInCheckbox {
  from {
    opacity: 0;
    -webkit-transform: rotateZ(-20deg);
  }
  to {
    opacity: 1;
    -webkit-transform: rotateZ(0deg);
  }
}

@keyframes fadeInCheckbox {
  from {
    opacity: 0;
    transform: rotateZ(-20deg);
  }
  to {
    opacity: 1;
    transform: rotateZ(0deg);
  }
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <h4>TAMBAH PESANAN</h4>
        <hr>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <form id="wizard_with_validation" action="" method="POST">
                    @csrf
                    <h3>Pilih Paket</h3>
                    <fieldset>
                        <h5>Paket Kiloan</h5>
                        <div class="row">
                            @foreach($kiloan as $k)
                            <div class="col-6">
                                <label>
                                    <input type="radio" name="paket" class="card-input-element d-none" value="{{ $k->id }}" {{ ($k->id == 1? 'checked' : '') }}>
                                    <div class="card card-body bg-light d-flex flex-row justify-content-between align-items-center">
                                        {{ $k->nama_paket }} <b>Rp {{ number_format($k->harga_paket, 0, ".", ".") }} / kg</b>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <h5 class="mt-3">Paket Per Item</h5>
                        <div class="row">
                            @foreach($item as $i)
                            <div class="col-6">
                                <label>
                                    <input type="radio" name="paket" class="card-input-element d-none" value="{{ $i->id }}">
                                    <div class="card card-body bg-light d-flex flex-row justify-content-between align-items-center">
                                        {{ $i->nama_paket }} <b>Rp {{ number_format($i->harga_paket, 0, ".", ".") }} / kg</b>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </fieldset>
                    <h3>List Item</h3>
                    <fieldset>
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
                        <div class="field_wrapper">
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" name="nama_barang[]" class="form-control" required/>
                                </div>
                                <div class="col-3">
                                    <input type="text" name="ciri_barang[]" class="form-control" required/>
                                </div>
                                <div class="col-3">
                                    <input type="number" name="jumlah_barang[]" class="form-control" min="1" required/>
                                </div>
                                <div class="col-3">
                                    <a href="javascript:void(0);" class="add_button" title="Tambah Barang"><i data-feather="plus-circle"></i></a>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <h3>Antar / Ambil</h3>
                    <fieldset>
                        <h5>Diambil Kurir/Diantar Sendiri Cucian yang akan di proses ke Laundry</h5>
                        <div class="row">
                            <div class="col-6">
                                <label>
                                    <input type="radio" name="antar" class="card-input-element d-none" value="sendiri" checked>
                                    <div class="card card-body bg-light d-flex flex-row justify-content-between align-items-center">
                                        Sendiri
                                    </div>
                                </label>
                            </div>
                            <div class="col-6">
                                <label>
                                    <input type="radio" name="antar" class="card-input-element d-none" value="kurir">
                                    <div class="card card-body bg-light d-flex flex-row justify-content-between align-items-center">
                                        Kurir TW Laundry
                                    </div>
                                </label>
                            </div>
                        </div>

                        <h5 class="mt-3">Antar Kurir/Jemput Sendiri Cucian Selesai Proses di Laundry</h5>
                        <div class="row">
                            <div class="col-6">
                                <label>
                                    <input type="radio" name="ambil" class="card-input-element d-none" value="sendiri" checked>
                                    <div class="card card-body bg-light d-flex flex-row justify-content-between align-items-center">
                                        Sendiri
                                    </div>
                                </label>
                            </div>
                            <div class="col-6">
                                <label>
                                    <input type="radio" name="ambil" class="card-input-element d-none" value="kurir">
                                    <div class="card card-body bg-light d-flex flex-row justify-content-between align-items-center">
                                        Kurir TW Laundry
                                    </div>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <h3>Metode Pembayaran</h3>
                    <fieldset>
                        <div class="container parent">
                            <h5>Pilih Pembayaran DANA atau COD</h5>
                            <span class="text-disabled">*pembayaran dapat dilakukan setelah pesanan divalidasi.</span>
                            <div class="row mt-3">
                                <div class='col-6 c-body text-center'>
                                    <input type="radio" name="pembayaran" id="img3" class="d-none imgbgchk" value="dana" required>
                                    <label for="img3">
                                        <img src="{{ asset('images/dana2.png') }}" alt="Logo Dana">
                                        <div class="tick_container">
                                            <div class="tick"><i class="fa fa-check"></i></div>
                                        </div>
                                    </label>
                                </div>
                                <div class='col-6 c-body text-center'>
                                    <input type="radio" name="pembayaran" id="img4" class="d-none imgbgchk" value="cod">
                                    <label for="img4">
                                        <img src="{{ asset('images/logo-cod.jpg') }}" alt="Logo COD">
                                        <div class="tick_container">
                                            <div class="tick"><i class="fa fa-check"></i></div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    //Advanced form with validation
    var form = $('#wizard_with_validation').show();
    form.steps({
        headerTag: 'h3',
        bodyTag: 'fieldset',
        transitionEffect: 'slideLeft',
        onInit: function (event, currentIndex) {

            //Set tab width
            var $tab = $(event.currentTarget).find('ul[role="tablist"] li');
            var tabCount = $tab.length;
            $tab.css('width', (100 / tabCount) + '%');

            //set button waves effect
            setButtonWavesEffect(event);
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            if (currentIndex > newIndex) { return true; }

            if (currentIndex < newIndex) {
                form.find('.body:eq(' + newIndex + ') label.error').remove();
                form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
            }

            form.validate().settings.ignore = ':disabled,:hidden';
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
            setButtonWavesEffect(event);
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ':disabled';
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            form.submit();
        }
    });

    form.validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });

    function setButtonWavesEffect(event) {
        $(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
        $(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
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
</script>
@endsection