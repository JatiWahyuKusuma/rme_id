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
        Schema::create('umurizin', function (Blueprint $table) {
            $table->id('umurizin_id');
            $table->unsignedBigInteger('cadanganbb_id')->index();
            $table->unsignedBigInteger('opco_id')->index();
            $table->string('tahun_habis');
            $table->enum('status',['Critical', 'Prioritas 1', 'Aman']);   
            $table->timestamps();

            $table->foreign('cadanganbb_id')->references('cadanganbb_id')->on('m_cadangan_bb');
            $table->foreign('opco_id')->references('opco_id')->on('m_opco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umurizin');
    }
};
