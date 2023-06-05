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
        Schema::create('quiz_banks', function (Blueprint $table) {
            $table->id();
            $table->string('quiz_title');
            $table->string('exam_id');
            $table->string('topic_id');
            $table->string('sub_topic_id');
            $table->string('quiz_type');
            $table->string('quiz_default_grade');
            $table->string('quiz_image');
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
        Schema::dropIfExists('quiz_banks');
    }
};
