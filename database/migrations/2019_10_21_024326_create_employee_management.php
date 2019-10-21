<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_management', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('supervisor_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();

            $table->foreign('supervisor_id')->references('id')->on('employees');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_management');
    }
}
