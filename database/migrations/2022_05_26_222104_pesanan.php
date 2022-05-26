<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_transaksi');
            $table->foreignId('id_user')->references('id')->on('users');
            $table->foreignId('id_kurir')->references('id')->on('users')->nullable();
            $table->foreignId('id_paket')->references('id')->on('jenis_paket');
            $table->string('nama');
            $table->string('email');
            $table->string('no_wa');
            $table->text('alamat');
            $table->string('nama_paket');
            $table->integer('harga_paket');
            $table->enum('jenis_paket', ['kiloan', 'item'])->default('kiloan');
            $table->enum('antar', ['sendiri', 'kurir'])->default('sendiri');
            $table->enum('ambil', ['sendiri', 'kurir'])->default('sendiri');
            $table->enum('pembayaran', ['dana', 'cod'])->default('dana');
            $table->enum('status_cucian', ['menunggu', 'validasi', 'proses', 'selesai'])->default('menunggu');
            $table->enum('status_diambil', ['belum', 'sudah'])->default('belum');
            $table->double('total_kg')->nullable();
            $table->double('total_pembayaran')->nullable();
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
        Schema::dropIfExists('pesanan');
    }
}
