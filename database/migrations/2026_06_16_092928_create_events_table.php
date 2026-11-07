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
        Schema::create('events', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id('id_event');


            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY : USER / ADMIN
            |--------------------------------------------------------------------------
            |
            | Event dibuat oleh Admin yang sedang login.
            |
            | events.id_user
            |      ↓
            | users.id_user
            |
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
            | JUDUL EVENT
            |--------------------------------------------------------------------------
            */

            $table->string('judul', 255);


            /*
            |--------------------------------------------------------------------------
            | TANGGAL EVENT
            |--------------------------------------------------------------------------
            */

            $table->date('tanggal');


            /*
            |--------------------------------------------------------------------------
            | DESKRIPSI
            |--------------------------------------------------------------------------
            */

            $table->text('deskripsi')->nullable();


            /*
            |--------------------------------------------------------------------------
            | GAMBAR / POSTER EVENT
            |--------------------------------------------------------------------------
            */

            $table->string('gambar')->nullable();


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
            $table->index('judul');
            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};