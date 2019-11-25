<?php

use Illuminate\Database\Seeder;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * ->make doesent insert data to database, instead it returns array of model instances
         * ->saveMany takes model instances array and creates in db.
         * 1. We create 15 users with create
         * 2. For each of those users create 1 - 5 question
         * 3. For each of those questions create 1 - 5 answers
         * */

        \DB::table('answers')->delete();
        \DB::table('questions')->delete();
        \DB::table('users')->delete();

        factory(App\User::class, 15)
            ->create()
            ->each(function ($user) {
                $user->questions()
                    ->saveMany(factory(App\Question::class, rand(1, 5))->make())
                    ->each(function ($question) {
                        $question->answers()
                            ->saveMany(factory(App\Answer::class, rand(1, 5))->make());
                    });
            });
    }
}
