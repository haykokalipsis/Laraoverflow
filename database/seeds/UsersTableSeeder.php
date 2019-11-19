<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();   // Хорошая практика, удаление прежних записей (id не сбросятся)
        factory(App\User::class, 15)
            ->create()
            ->each(function ($user) {
                $user->questions()->saveMany(factory(App\Question::class, rand(1, 5))->make());
            });
    }
}
