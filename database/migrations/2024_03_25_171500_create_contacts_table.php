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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->string('VAT')->nullable(); // VAT number

            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();

            $table->string('website')->nullable();

            // TODO étiquettes par ex. B2B, Vip, Conseil...

            // if the contact is an individual, it must have a name and could have a job title and a title such as Mr
            $table->morphs('contactable'); // This will add contactable_id and contactable_type

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
