<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientTable extends Migration
{
  public function up()
  {
      Schema::create('patient', function (Blueprint $table) {  // Ensure the table name is "patient"
          $table->id();
          $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
          $table->string('name');
          $table->string('email')->unique();
          $table->integer('age');
          $table->string('gender');
          $table->string('blood_type');
          $table->string('insurance_provider')->nullable();
          $table->timestamps();
      });
  }


    public function down()
    {
        Schema::dropIfExists('patient');
    }
}
