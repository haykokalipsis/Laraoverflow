<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->delete();   // Хорошая практика, удаление прежних записей (id не сбросятся)
        factory(App\Question::class, 15)->create();
    }
}
