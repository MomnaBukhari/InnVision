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
            $table->string('room_number');
            $table->boolean('is_booked')->default(false); 
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('max_occupancy');
            $table->integer('single_beds')->default(0);
            $table->integer('floor');
            $table->decimal('fare', 8, 2);
            $table->text('description')->nullable();
            $table->timestamps();

            if (!Schema::hasColumn('rooms', 'branch_id')) {
                $table->unique(['branch_id', 'room_number']); // Composite unique constraint
            }
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
