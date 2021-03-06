<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('matkul');
            $table->string('waktu');
            $table->unsignedBigInteger('day_id');
            $table->foreign('day_id')->references('id')->on('schedule_days')->onDelete('cascade');
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
        Schema::dropIfExists('schedule_subjects');
    }
}
