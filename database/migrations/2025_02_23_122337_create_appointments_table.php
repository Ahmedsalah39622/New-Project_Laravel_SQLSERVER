<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // CreateAppointmentsTable.php migration example
   public function up()
   {
       Schema::create('appointments', function (Blueprint $table) {
           $table->id();
           $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
           $table->string('patient_name');
           $table->string('patient_email');
           $table->string('patient_phone')->nullable();
           $table->date('appointment_date');
           $table->time('start_time');
           $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
           $table->timestamps();
           $table->json('selected_symptoms')->nullable();

       });
   }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
