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
        Schema::create('pemotongan_tercatats', function (Blueprint $table) {
            $table->id();
            $table->date('bulan');
            $table->foreignId('tempat_pemotongan_id')->constrained('tempat_pemotongans')->cascadeOnDelete();
            $table->string('jenis_ternak');
            $table->unsignedInteger('jumlah_pemotongan')->default(0);
            $table->timestamps();
            $table->unique(['bulan', 'tempat_pemotongan_id', 'jenis_ternak'], 'pemotongan_tercatat_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemotongan_tercatats');
    }
};
