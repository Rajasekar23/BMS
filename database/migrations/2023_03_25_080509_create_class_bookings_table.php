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
        Schema::create('class_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('class_day_id');
            $table->bigInteger('student_id')->nullable();
            $table->enum('status', ['BOOKED', 'CANCELED'])->default('BOOKED');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('class_bookings');
    }
};
