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
        Schema::create('m_cadangan_potensi', function (Blueprint $table) {
            $table->id('cadpot_id');
            $table->unsignedBigInteger('opco_id')->index();
            $table->decimal('jarak', 10, 1)->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->integer('no_id')->nullable();
            $table->string('komoditi');
            $table->string('lokasi_iup');
            $table->string('tipe_sd_cadangan');
            $table->integer('sd_cadangan_ton');
            $table->string('catatan')->nullable();
            $table->string('status_penyelidikan')->nullable();
            $table->string('acuan')->nullable();
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->double('luas_ha')->nullable();
            $table->date('masa_berlaku_iup')->nullable();
            $table->date('masa_berlaku_ppkh')->nullable();
            $table->timestamps();

            $table->foreign('opco_id')->references('opco_id')->on('m_opco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_cadangan_potensi');
    }
};
