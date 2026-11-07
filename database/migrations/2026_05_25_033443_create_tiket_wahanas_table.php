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
        Schema::create('tiket_wahanas', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id('id_tiket_wahana');

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY : USER
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_user')
                  ->constrained(
                      table: 'users',
                      column: 'id_user'
                  )
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | NAMA WAHANA
            |--------------------------------------------------------------------------
            */

            $table->string('nama_wahana', 255);

            /*
            |--------------------------------------------------------------------------
            | HARGA
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('harga');

            /*
            |--------------------------------------------------------------------------
            | KETENTUAN
            |--------------------------------------------------------------------------
            */

            $table->text('ketentuan')->nullable();

            /*
            |--------------------------------------------------------------------------
            | GAMBAR
            |--------------------------------------------------------------------------
            */

            $table->string('gambar')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'Tersedia',
                'Tidak Tersedia'
            ])->default('Tersedia');

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
            $table->index('nama_wahana');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_wahanas');
    }
};