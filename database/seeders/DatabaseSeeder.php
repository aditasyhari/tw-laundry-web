<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JenisPaket;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'Novita',
            'alamat' => 'Rogojampi',
            'email' => 'novitamubin1999@gmail.com',
            'email_verified_at' => date("Y-m-d H:i:s"),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_wa' => '088996943204',
            'wa_verified_at' => date("Y-m-d H:i:s"),
        ]);

        JenisPaket::create([
            'nama_paket' => 'Cuci Kering',
            'harga_paket' => 2500,
            'jenis_paket' => 'kiloan'
        ]);

        JenisPaket::create([
            'nama_paket' => 'Cuci Kering + Setrika',
            'harga_paket' => 5000,
            'jenis_paket' => 'kiloan'
        ]);

        JenisPaket::create([
            'nama_paket' => 'Setrika',
            'harga_paket' => 3500,
            'jenis_paket' => 'kiloan'
        ]);

        JenisPaket::create([
            'nama_paket' => 'Cuci Kering + Setrika Bedcover',
            'harga_paket' => 16000,
            'jenis_paket' => 'item'
        ]);

        JenisPaket::create([
            'nama_paket' => 'Cuci Kering + Setrika Seprei',
            'harga_paket' => 7000,
            'jenis_paket' => 'item'
        ]);

        JenisPaket::create([
            'nama_paket' => 'Cuci Kering + Setrika Selimut',
            'harga_paket' => 10000,
            'jenis_paket' => 'item'
        ]);

        JenisPaket::create([
            'nama_paket' => 'Cuci Kering Boneka',
            'harga_paket' => 10000,
            'jenis_paket' => 'item'
        ]);
    }
}
