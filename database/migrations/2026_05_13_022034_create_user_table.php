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
        Schema::create('users', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id('id_user');

            /*
            |--------------------------------------------------------------------------
            | USER INFORMATION
            |--------------------------------------------------------------------------
            */

            $table->string('nama');

            $table->string('email')->unique();

            $table->string('password');

            /*
            |--------------------------------------------------------------------------
            | ROLE
            |--------------------------------------------------------------------------
            */

            $table->enum('role', [
                'admin',
                'kasir_menu',
                'kasir_wahana',
                'kasir_oleholeh'
            ]);

            /*
            |--------------------------------------------------------------------------
            | REMEMBER TOKEN & TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};