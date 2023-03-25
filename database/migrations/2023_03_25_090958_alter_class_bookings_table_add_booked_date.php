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
        Schema::table('class_bookings', function (Blueprint $table) {
            $table->dateTime('booked_at')->nullable()->after('status');
            $table->integer('booked_by')->nullable()->after('booked_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_bookings', function (Blueprint $table) {
            $table->dropColumn(['booked_at', 'booked_by']);
        });
    }
};
