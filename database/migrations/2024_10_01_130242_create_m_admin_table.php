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
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); 
            $table->unsignedBigInteger('level_id')->index();
            $table->unsignedBigInteger('opco_id')->index();

            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
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
