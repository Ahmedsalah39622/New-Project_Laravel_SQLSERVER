<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientTable extends Migration
{
    public function up()
    {
        Schema::create('patient', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name');
            $table->integer('age');
            $table->string('gender');
            $table->string('blood_type');
            $table->string('insurance_provider')->nullable();
            $table->timestamps(); // This will add created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient');
    }
}
