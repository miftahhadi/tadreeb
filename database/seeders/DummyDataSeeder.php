<?php

namespace Database\Seeders;

use App\Exam;
use App\Lesson;
use App\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);

        // Lessons
        $user->lessons()
                ->createMany(factory(Lesson::class, 100)->make()->toArray());

        // Exams
        $user->exams()
                ->createMany(factory(Exam::class, 100)->make()->toArray());
    }
}
