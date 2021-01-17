<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unsigned()->nullable();
            $table->string('month');
            $table->string('year');
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->tinyInteger('is_late')->nullable();
            $table->tinyInteger('is_early')->nullable();
            $table->tinyInteger('is_holiday')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('attendances');
    }

}
