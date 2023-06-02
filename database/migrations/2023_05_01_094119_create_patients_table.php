<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('dob');
            $table->string('phone');
            $table->enum('gendar', ['male', 'female']);
            $table->string('email')->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+' , 'B-', 'O+', 'O-', 'AB+', 'AB-', 'Unknown'])->nullable();
            $table->tinyInteger('diabetic')->nullable();
            $table->tinyInteger('hbp')->nullable(); //high blood Pressure
            $table->tinyInteger('heart_diseases')->nullable();
            $table->tinyInteger('accidents')->nullable();
            $table->tinyInteger('surgeries')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
