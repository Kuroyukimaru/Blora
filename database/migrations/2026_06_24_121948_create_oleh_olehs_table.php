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
    Schema::create('oleh_olehs', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->enum('jenis', [
            'totebag',
            'baju',
            'celana',
            'topi',
            'gantungan kunci',
            'ikat rambut',
            'kacamata',
            'daster',
            'sandal',
            'pajangan tumbuhan',
            'barongan'
        ]);
        $table->integer('stock')->default(0);
        $table->text('deskripsi');
        $table->string('gambar')->nullable(); // foto oleh-oleh
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oleh_olehs');
    }
};
