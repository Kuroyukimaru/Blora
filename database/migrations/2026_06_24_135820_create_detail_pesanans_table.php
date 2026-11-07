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
        Schema::create('detail_pesanans', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id('id_detail_pesanan');

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY : PESANAN
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_pesanan')
                  ->constrained(
                      table: 'pesanans',
                      column: 'id_pesanan'
                  )
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY : MENU
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_menu')
                  ->nullable()
                  ->constrained(
                      table: 'menus',
                      column: 'id_menu'
                  )
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY : TIKET WAHANA
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_tiket_wahana')
                  ->nullable()
                  ->constrained(
                      table: 'tiket_wahanas',
                      column: 'id_tiket_wahana'
                  )
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY : OLEH-OLEH
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_oleh_oleh')
                  ->nullable()
                  ->constrained(
                      table: 'oleh_olehs',
                      column: 'id_oleh_oleh'
                  )
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY : PAKET BUNDLING
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_paket_bundling')
                  ->nullable()
                  ->constrained(
                      table: 'paket_bundlings',
                      column: 'id_paket_bundling'
                  )
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | JUMLAH
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('qty')->default(1);

            /*
            |--------------------------------------------------------------------------
            | HARGA SATUAN
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('harga');

            /*
            |--------------------------------------------------------------------------
            | SUBTOTAL
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('subtotal');

            /*
            |--------------------------------------------------------------------------
            | STATUS ITEM
            |--------------------------------------------------------------------------
            */

            $table->enum('status_item', [
                'Menunggu',
                'Diproses',
                'Selesai'
            ])->default('Menunggu');

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

            $table->index('id_pesanan');
            $table->index('id_menu');
            $table->index('id_tiket_wahana');
            $table->index('id_oleh_oleh');
            $table->index('id_paket_bundling');
            $table->index('status_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};