<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         \App\Models\User::factory()->create([
             'name' => 'Chandler Bing',
             'email' => 'bing@mail.com',
             'password' => Hash::make('bing@123')
         ]);

        \App\Models\User::factory()->create([
            'name' => 'Joe Goldberg',
            'email' => 'joe@mail.com',
            'password' => Hash::make('joe@123')
        ]);
    }
}
