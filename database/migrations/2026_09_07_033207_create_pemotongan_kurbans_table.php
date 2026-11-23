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
        Schema::create('pemotongan_kurbans', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->foreignId('kabupaten_id')->constrained('kabupatens')->cascadeOnDelete();
            $table->enum('jenis_ternak', ['Sapi', 'Kambing', 'Domba', 'Kerbau']);
            $table->unsignedInteger('jumlah_pemotongan');
            $table->timestamps();
            $table->unique(['tahun', 'kabupaten_id', 'jenis_ternak']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemotongan_kurbans');
    }
};
