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
        Schema::create('m_vendor', function (Blueprint $table) {
            $table->id('vendor_id');
            $table->unsignedBigInteger('opco_id')->index();
            $table->decimal('jarak', 10, 1)->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('vendor');
            $table->string('komoditi');
            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->integer('kap_ton_thn'); 
            $table->string('konsumsi_ton_thn'); 
            $table->timestamps();

            $table->foreign('opco_id')->references('opco_id')->on('m_opco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_vendor');
    }
};
