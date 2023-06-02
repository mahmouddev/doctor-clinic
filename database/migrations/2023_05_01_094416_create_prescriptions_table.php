<?php

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Patient::class)
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->foreignIdFor(Appointment::class)
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->longText('prescription')->nullable();

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
        Schema::dropIfExists('prescriptions');
    }
};
