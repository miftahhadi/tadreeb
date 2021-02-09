<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->morphs('examable');
            $table->tinyInteger('tampil')->default(0);
            $table->tinyInteger('buka')->default(0);
            $table->tinyInteger('buka_hasil')->default(0);
            $table->timestamp('tampil_otomatis')->nullable();
            $table->timestamp('buka_otomatis')->nullable();
            $table->timestamp('batas_buka')->nullable();
            $table->integer('durasi')->default(0);
            $table->integer('attempt')->default(0);
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
        Schema::dropIfExists('examables');
    }
}
