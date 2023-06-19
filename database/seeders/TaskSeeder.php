<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\Task::create([
            'title' => 'My first task',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi consectetur consequatur distinctio error, est expedita maiores optio praesentium quaerat quas reiciendis similique sunt tempora. Dignissimos distinctio hic placeat quasi voluptatum.',
//            'status' => '',
            'priority' => 5,
        ]);
    }
}
