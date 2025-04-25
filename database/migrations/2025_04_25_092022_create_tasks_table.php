<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('task_name');
        $table->text('task_description')->nullable();
        $table->foreignId('folder_id')->constrained()->onDelete('cascade');
        $table->enum('status', ['Очікує', 'У процесі', 'Завершено']);
        $table->enum('priority', ['Низький', 'Середній', 'Високий']);
        $table->date('deadline')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
