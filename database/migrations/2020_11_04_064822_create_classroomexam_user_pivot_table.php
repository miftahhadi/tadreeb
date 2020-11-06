<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomexamUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroomexam_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_exam_id')
                    ->constrained('classroom_exam')
                    ->onDelete('cascade');
            $table->foreignId('user_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->integer('attempt')->default(1);
            $table->longText('answers')->nullable();
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
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
        Schema::dropIfExists('classroomexam_user');
    }
}
