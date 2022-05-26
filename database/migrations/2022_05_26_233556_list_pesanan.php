<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ListPesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pesanan')->references('id')->on('pesanan');
            $table->string('nama_barang');
            $table->string('ciri_ciri');
            $table->string('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_pesanan');
    }
}
