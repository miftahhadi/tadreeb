<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomLessonPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_lesson', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->foreignId('lesson_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->tinyInteger('tampil')->default(0);
            $table->tinyInteger('buka')->default(0);
            $table->dateTime('tampil_otomatis')->nullable();
            $table->dateTime('buka_otomatis')->nullable();
            $table->dateTime('batas_buka')->nullable();
            $table->timestamps();

            $table->index(['classroom_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_lesson');
    }
}
