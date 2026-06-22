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
        Schema::create('paket_items', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELASI KE PAKET
            |--------------------------------------------------------------------------
            */

            $table->foreignId(
                'paket_id'
            )
            ->constrained(
                'pakets'
            )
            ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | TIPE ITEM
            |--------------------------------------------------------------------------
            | menu = ambil dari tabel menus
            | wahana = ambil dari tabel tiket_wahanas
            |--------------------------------------------------------------------------
            */

            $table->enum(
                'tipe',
                [
                    'menu',
                    'wahana'
                ]
            )->index();

            /*
            |--------------------------------------------------------------------------
            | ID ITEM
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger(
                'item_id'
            );

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

            $table->index(
                'item_id'
            );

            $table->index(
                [
                    'paket_id',
                    'tipe'
                ]
            );

            $table->index(
                'created_at'
            );

        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists(
            'paket_items'
        );
    }
};