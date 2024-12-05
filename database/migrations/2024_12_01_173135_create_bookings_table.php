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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_event')->constrained('events')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending'); // Status booking
            $table->integer('quantity'); 
            $table->decimal('total_price', 15, 2)->nullable();  // Kolom total_price, bisa dihitung di aplikasi
            $table->string('payment_method')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
