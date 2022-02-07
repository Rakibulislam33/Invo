<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Task;
use App\Models\User;
use App\Models\Invoice;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'  => 'Rakibul Islam',
            'email' => 'r@r.com',
            'password' => bcrypt('123'),
            'thumbnail' => 'https://picsum.photos/300'
        ]);


        User::create([
            'name'  => 'Demo user',
            'email' => 'd@d.com',
            'password' => bcrypt('123'),
            'thumbnail' => 'https://picsum.photos/300'
        ]);


        Client::factory(10)->create();
        Task::factory(50)->create();
        Invoice::factory(20)->create();
    }
}
