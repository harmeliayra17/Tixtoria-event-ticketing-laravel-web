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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->foreignId('id_category')->constrained('categories')->onDelete('cascade'); // foreignId untuk id_category
            $table->date('date');
            $table->time('time');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade'); // foreignId untuk location_id
            $table->decimal('price', 10, 2);
            $table->integer('quota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
