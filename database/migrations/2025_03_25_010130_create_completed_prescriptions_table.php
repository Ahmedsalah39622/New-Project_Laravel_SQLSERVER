<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletedPrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the table if it exists
        Schema::dropIfExists('completed_prescriptions');

        Schema::create('completed_prescriptions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->date('date_issued'); // Date issued
            $table->date('due_date'); // Due date
            $table->text('drugs'); // Drugs prescribed
            $table->text('dosage'); // Dosage instructions
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_prescriptions');
    }
}
