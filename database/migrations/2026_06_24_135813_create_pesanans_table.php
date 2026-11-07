<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id('id_pesanan');

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY : USER (KASIR)
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_user')
                  ->nullable()
                  ->constrained(
                      table: 'users',
                      column: 'id_user'
                  )
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | KODE PESANAN
            |--------------------------------------------------------------------------
            */

            $table->string('kode_pesanan')->unique();

            /*
            |--------------------------------------------------------------------------
            | DATA PELANGGAN
            |--------------------------------------------------------------------------
            */

            $table->string('nama_pelanggan');

            $table->string('no_wa', 20);

            /*
            |--------------------------------------------------------------------------
            | METODE PEMBAYARAN
            |--------------------------------------------------------------------------
            */

            $table->enum('metode_pembayaran', [
                'Cash',
                'QRIS'
            ]);

            /*
            |--------------------------------------------------------------------------
            | TOTAL HARGA
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('total_harga');

            /*
            |--------------------------------------------------------------------------
            | STATUS PESANAN
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'Menunggu Pembayaran',
                'Menunggu Pengambilan',
                'Selesai',
                'Batal'
            ])->default('Menunggu Pembayaran');

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('id_user');
            $table->index('kode_pesanan');
            $table->index('nama_pelanggan');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};