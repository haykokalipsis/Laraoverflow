<?php

use Illuminate\Database\Seeder;

class PredefinedUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Predefined users
        DB::table('users')->insert(array(
            [
                'name' => 'Hayk Karapetyan',
                'email' => 'haykokalipsis@gmail.com',
                'password' => bcrypt('chelsea4ever')
            ],
        ));
    }
}
