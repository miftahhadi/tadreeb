<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessonables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->morphs('lessonable');
            $table->tinyInteger('tampil')->default(0);
            $table->tinyInteger('buka')->default(0);
            $table->timestamp('tampil_otomatis')->nullable();
            $table->timestamp('buka_otomatis')->nullable();
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
        Schema::dropIfExists('lessonables');
    }
}
