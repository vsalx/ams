<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->integer('dentist_id')->unsigned();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->integer('cancelled_by')->unsigned()->default(null)->nullable();
            $table->timestamp('cancelled_on')->default(null)->nullable();
            $table->boolean('seen')->default(false);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('dentist_id')->references('id')->on('users');
            $table->foreign('cancelled_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
