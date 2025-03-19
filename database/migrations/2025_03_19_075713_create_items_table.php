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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->unique();
            $table->string('description')->nullable();
            $table->string('type'); // например: 'weapon', 'armor'
            $table->unsignedBigInteger('tier_id')->nullable();
            $table->timestamps();

            $table->foreign('tier_id')->references('id')->on('tiers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
