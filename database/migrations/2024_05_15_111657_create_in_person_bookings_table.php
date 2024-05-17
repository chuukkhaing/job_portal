<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInPersonBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_person_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('company_name')->nullable();
            $table->longtext('address')->nullable();
            $table->string('phone')->nullable();
            $table->date('date');
            $table->foreignId('in_person_booking_time_id')->nullable()->constrained('in_person_booking_times');
            $table->longtext('remark')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('in_person_bookings');
    }
}
