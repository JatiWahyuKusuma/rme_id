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
        Schema::create('m_cadangan_bb', function (Blueprint $table) {
            $table->id('cadanganbb_id');
            $table->unsignedBigInteger('opco_id')->index();
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->decimal('jarak', 10, 1);
            $table->double('luas_ha');
            $table->integer('kebutuhan_pertahun_ton');
            $table->string('komoditi');
            $table->string('lokasi_iup');
            $table->integer('sd_cadangan_ton');
            $table->string('status_penyelidikan');
            $table->string('status_pembebasan');
            $table->string('catatan');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->date('masa_berlaku_iup');
            $table->date('masa_berlaku_ppkh')->nullable();
            $table->integer('umur_cadangan_thn')->nullable();
            $table->string('umur_masa_berlaku_izin')->nullable();
            $table->timestamps();

            $table->foreign('opco_id')->references('opco_id')->on('m_opco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_cadangan_bb');
    }
};
