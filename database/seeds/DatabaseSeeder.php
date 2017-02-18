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

        $user = new \App\User;
        $user->name = 'john';
        $user->email = 'john@gmail.com';
        $user->password = Hash::make('password');
        $user->save();
    }
}
