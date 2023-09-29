<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisionTable extends Migration
{
    public function up()
    {
        Schema::create('revision', function (Blueprint $table) {
            $table->id();
            $table->string('detail');
            $table->unsignedBigInteger('task_id');

            $table->foreign('task_id')->references('id')->on('tasks');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('revision');
    }
}
