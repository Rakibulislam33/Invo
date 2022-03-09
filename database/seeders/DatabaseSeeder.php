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
            'company' => 'PixCafe Network',
            'phone' => '09696 123456',
            'country' => 'Bangladesh',
            'password' => bcrypt('123'),
            'thumbnail' => 'https://picsum.photos/300'
        ]);


        // User::create([
        //     'name'  => 'Demo user',
        //     'email' => 'd@d.com',
        //     'company' => 'PixCafe Network',
        //     'phone' => '09696 123456',
        //     'country' => 'Bangladesh',
        //     'password' => bcrypt('123'),
        //     'thumbnail' => 'https://picsum.photos/300'
        // ]);


        Client::factory(10)->create();

        Task::factory(150)->create();

      //  Invoice::factory(20)->create();
    }
}
