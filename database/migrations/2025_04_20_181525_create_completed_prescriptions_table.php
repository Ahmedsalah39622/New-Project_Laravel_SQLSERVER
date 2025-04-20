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
        Schema::create('disease_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('ds'); // Date column
            $table->integer('heart_failure')->default(0);
            $table->integer('stemi')->default(0);
            $table->integer('acs')->default(0);
            $table->integer('anaemia')->default(0);
            $table->integer('chest_infection')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_statistics');
    }
};
