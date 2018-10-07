<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

            'name' => 'Atsushi Koga',
            'username' => str_slug('Atsushi Koga'),
            'email' => 'stbe51@gmail.com',
            'password' => Hash::make('secret'),

        ]);
    }
}
