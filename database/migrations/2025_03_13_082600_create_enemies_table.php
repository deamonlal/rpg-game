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
        Schema::create('enemies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('health');
            $table->integer('level');
            $table->integer('damage');
            $table->integer('exp_gain');
            $table->json('items')->nullable();
            $table->json('skills')->nullable();
            $table->integer('tier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enemies');
    }
};
