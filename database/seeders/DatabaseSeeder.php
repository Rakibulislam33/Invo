<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Task;
use App\Models\User;
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
        User::create([
            'name'  => 'Rakibul Islam',
            'email' => 'a@a.com',
            'company' => 'PixCafe Network',
            'phone' => '09696 123456',
            'country' => 'Bangladesh',
            'password' => bcrypt('123'),
            'thumbnail' => 'https://picsum.photos/300',
            'role' => 'admin'
        ]);
        User::create([
            'name'  => 'Demo User',
            'email' => 'd@d.com',
            'company' => 'Demo Company',
            'phone' => '09696 123456',
            'country' => 'Bangladesh',
            'password' => bcrypt('123'),
            'thumbnail' => 'https://picsum.photos/300',
            'role' => 'user'
        ]);


        Client::factory(5)->create();

        Task::factory(30)->create();

        // Invoice::factory(10)->create();

    }
}
