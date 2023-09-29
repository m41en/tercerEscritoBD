<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('tasks_category', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->unsignedBigInteger('task_id');

            $table->foreign('task_id')->references('id')->on('tasks');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tareas_categoria');
    }
}
