<?php

use App\Lesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Lesson::truncate();
        Model::unguard();
        $this->call(LessonsTableSeeder::class);
    }
}
