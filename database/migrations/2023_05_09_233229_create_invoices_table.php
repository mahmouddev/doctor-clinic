<?php

use App\Models\Appointment;
use App\Models\Patient;
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
		Schema::create('invoices', function(Blueprint $table) {
            $table->increments('id');
            $table->decimal('total_price')->default(0);
            $table->decimal('total_recieved')->default(0);
            $table->decimal('change')->default(0);
            $table->string('payment_type')->default("cash");
			$table->foreignIdFor(Appointment::class)
                ->nullable()
                ->constrained()
                ->onDelete('set null');

			$table->foreignIdFor(Patient::class)
				->nullable()
				->constrained()
				->onDelete('set null');

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
		Schema::drop('invoices');
	}
};
