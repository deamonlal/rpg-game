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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained('characters')->cascadeOnDelete();
            $table->foreignId('item_id')->nullable()->constrained('items')->onDelete('set null');
            $table->enum('slot', [
                'head',
                'body',
                'left_hand',
                'right_hand',
                'arms',
                'belt',
                'legs',
                'foots',
                'back',
                'finger_1',
                'finger_2',
                'finger_3',
                'finger_4',
                'finger_5',
                'finger_6',
                'finger_7',
                'finger_8',
                'finger_9',
                'finger_10',
                'neck'
                ]);
            $table->unique(['character_id', 'item_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_wearings');
    }
};
