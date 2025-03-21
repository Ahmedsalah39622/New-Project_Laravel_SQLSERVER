<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('confirmed_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->string('patient_name');
            $table->string('patient_email');
            $table->date('appointment_date');
            $table->time('start_time');
            $table->string('status')->default('confirmed');
            $table->timestamp('confirmed_at');
            $table->foreignId('confirmed_by')->constrained('users')->comment('Receptionist who confirmed');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('confirmed_appointments');
    }
};
