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
        Schema::create('paket_bundling_menus', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id('id_paket_bundling_menu');

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
            | FOREIGN KEY : MENU
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_menu')
                  ->constrained(
                      table: 'menus',
                      column: 'id_menu'
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
                'id_menu'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_bundling_menus');
    }
};