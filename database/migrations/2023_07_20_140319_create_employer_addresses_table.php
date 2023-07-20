<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('employer_id')->nullable();
            $table->string('country')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('township_id')->nullable();
            $table->longtext('address_detail')->nullable();
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
        Schema::dropIfExists('employer_addresses');
    }
}
