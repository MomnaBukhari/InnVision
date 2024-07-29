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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->string('room_number')->unique();
            $table->enum('status', ['available', 'booked'])->default('available');
            $table->string('booked_by')->nullable(); // Could be a user ID or name
            $table->integer('floor');
            $table->integer('max_occupancy');
            $table->integer('single_beds')->default(0);
            $table->text('description')->nullable(); // Additional details about the room
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
