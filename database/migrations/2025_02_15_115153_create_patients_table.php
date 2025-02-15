<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
  public function up()
  {
    Schema::create('patients', function (Blueprint $table) {
      $table->id();
      $table->string('name'); // Use 'name' instead of 'username'
      $table->string('email')->unique();
      $table->integer('age')->nullable();
      $table->date('birthdate')->nullable();
      $table->string('gender')->nullable();
      $table->string('blood_type')->nullable();
      $table->string('phone')->nullable();
      $table->string('insurance_provider')->nullable();
      $table->string('password'); // Add password field
      $table->timestamps();
  });
  }


    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
