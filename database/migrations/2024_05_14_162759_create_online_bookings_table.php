<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_bookings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('online_booking_time_id')->nullable()->constrained('online_booking_times');
            $table->longtext('remark')->nullable();
            $table->boolean('is_available');
            $table->boolean('is_admin');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('online_bookings');
    }
}
