<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    // $this->call(UsersTableSeeder::class);

        // Predefined users
        DB::table('users')->insert(array(
            [
                'name' => 'Hayk Karapetyan',
                'email' => 'haykokalipsis@gmail.com',
                'password' => bcrypt('chelsea4ever')
            ],
        ));


        /*
         * ->make doesent insert data to database, instead it returns array of model instances
         * ->saveMany takes model instances array and creates in db.
         * 1. We create 15 users with create
         * 2. For each of those users create 1 - 5 question
         * 3. For each of those questions create 1 - 5 answers
         * */
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
