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
        Schema::create('advertisment', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('type', ["Apartment", "Land", "Shop", "Office"])->default("Apartment");  // Type Realty [ ]
            $table->integer('salary');
            $table->integer('rooms');
            $table->integer('bath_room');
            $table->string('area');
            $table->enum('evaluation', [1, 2, 3, 4, 5])->default(1);
            $table->enum('state', [1, 0])->default(1);
            $table->string('duration');
            $table->string('location');
            $table->enum('advertisment_type', [1, 0])->default(0);
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisment');
    }
};
