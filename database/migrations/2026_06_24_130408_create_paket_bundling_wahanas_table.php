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
        Schema::create('paket_bundling_wahanas', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id('id_paket_bundling_wahana');

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY : PAKET BUNDLING
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_paket_bundling')
                  ->constrained(
                      table: 'paket_bundlings',
                      column: 'id_paket_bundling'
                  )
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY : TIKET WAHANA
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_tiket_wahana')
                  ->constrained(
                      table: 'tiket_wahanas',
                      column: 'id_tiket_wahana'
                  )
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'id_paket_bundling',
                'id_tiket_wahana'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_bundling_wahanas');
    }
};