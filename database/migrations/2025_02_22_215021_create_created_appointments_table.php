<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('created_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained();
            $table->date('date');
            $table->string('time');
            $table->string('patient_name')->nullable();
            $table->string('patient_email')->nullable();
            $table->string('patient_phone')->nullable();
            $table->boolean('is_available')->default(true);
            $table->string('status')->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('created_appointments');
    }
};
