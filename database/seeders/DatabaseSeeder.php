<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $faker = Faker::create();
    	foreach (range(1,70) as $index) {
            sleep(5);
            DB::table('users')->insert([
                'name' => $faker->firstname,
                'email' => $faker->email,
                'password' => $faker->password,
                'type' => 'candidat',
                'created_at'=>now()
            ]);
        }
    }
}
