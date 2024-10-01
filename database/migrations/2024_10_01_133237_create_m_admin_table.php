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
        Schema::create('m_admin', function (Blueprint $table) {
            $table->id('admin_id');
            $table->unsignedBigInteger('level_id')->index();
            $table->unsignedBigInteger('opco_id')->index();
            $table->string('nama');
            $table->string('email');
            $table->string('password')->nullable();
            $table->timestamps();

            $table->foreign('level_id')->references('level_id')->on('m_level');
            $table->foreign('opco_id')->references('opco_id')->on('m_opco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_admin');
    }
};
