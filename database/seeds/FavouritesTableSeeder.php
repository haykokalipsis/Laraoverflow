<?php

use App\Question;
use App\User;
use Illuminate\Database\Seeder;

class FavouritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('favourites')->delete();
        $users = User::pluck('id')->all();
        $numberOfUsers = count($users);

        // Randomly attach every single question to at least 1 user
        foreach (Question::all() as $question) {
            for ($i = 0; $i < rand(0, $numberOfUsers); $i++){
                $user = $users[$i];
                $question->favourites()->attach($user);
            }
        }
    }
}
