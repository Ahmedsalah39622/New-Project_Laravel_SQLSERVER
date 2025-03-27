<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('appointment_id'); // Foreign key to appointments table
            $table->text('drugs'); // Drugs column
            $table->text('dosage'); // Dosage column
            $table->text('notes')->nullable(); // Notes column, nullable
            $table->timestamps(); // Created at and updated at timestamps

            // Add foreign key constraint
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prescriptions'); // Drop the table if rolled back
    }
}
