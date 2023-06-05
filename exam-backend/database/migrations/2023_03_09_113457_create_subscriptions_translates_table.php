<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Validation\Validator;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('subscriptions_translates', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_id');
            $table->string('locale');
            $table->string('sub_name');
            $table->string('sub_type');
            $table->integer('sub_limit');
            //  $table->unique(['subscription_id', 'locale']);
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
        Schema::dropIfExists('subscriptions_translates');
    }
};
