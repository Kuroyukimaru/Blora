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

        $table->id();

        $table->foreignId('paket_bundling_id')
              ->constrained('paket_bundlings')
              ->cascadeOnDelete();

        $table->foreignId('tiket_wahana_id')
              ->constrained('tiket_wahanas')
              ->cascadeOnDelete();

        $table->timestamps();
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
