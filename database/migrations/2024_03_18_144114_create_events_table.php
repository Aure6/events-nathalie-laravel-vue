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
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('body')->nullable();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->string('registrations_limit')->nullable();
            $table->string('img_path')->nullable();

            // $table->foreignId('organizer_id')->constrained()->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('organizer_id');
            $table->foreign('organizer_id')->references('id')->on('contacts');

            // $table->foreignId('place_id')->constrained()->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')->references('id')->on('contacts');

            // $table->string('place')->nullable();
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
