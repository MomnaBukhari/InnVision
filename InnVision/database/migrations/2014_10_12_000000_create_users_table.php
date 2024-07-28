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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'hotel_owner', 'customer'])->default('customer');
            $table->boolean('is_approved')->default(false);
            $table->boolean('request_send')->default(false);
            $table->string('admin_code')->nullable();
            $table->string('hotel_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->text('about')->nullable();
            $table->text('description')->nullable();
            $table->integer('hotel_stars')->nullable();
            $table->enum('service_class', ['elite', 'middle','lower', 'general', 'other'])->nullable();
            $table->string('profile_picture')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
