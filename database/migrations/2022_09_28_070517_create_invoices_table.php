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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->text('invoice');
            $table->unsignedBigInteger('customer_id');
            $table->string('courier');
            $table->string('service');
            $table->bigInteger('cost_courier');
            $table->integer('weight');
            $table->string('name');
            $table->bigInteger('phone');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('city_id');
            $table->text('address');
            $table->enum('status', array(
                'pending', 'success', 'failed', 'expired'
            ));
            $table->string('snap_token')->nullable();
            $table->bigInteger('grand_total');
            $table->timestamps();

            //relationship customer
            $table->foreign('customer_id')->references('id')->on('customers');
            //relationship city
            $table->foreign('city_id')->references('id')->on('cities');
            //relationship province
            $table->foreign('province_id')->references('id')->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};