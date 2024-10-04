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
        Schema::create('m_superadmin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('level_id')->index();
            $table->unsignedBigInteger('user_id')->index(); 
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('level_id')->references('level_id')->on('m_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_superadmin');
    }
};
