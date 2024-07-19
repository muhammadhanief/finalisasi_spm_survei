<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;



class AdditionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = Faker::create();

        // foreach (range(1, 10) as $index) {
        //     $user  = User::create([
        //         'name' => $faker->name,
        //         'email' => $faker->email,
        //         'password' => bcrypt('password'),
        //         'remember_token' => Str::random(10),
        //     ]);
        //     $user->assignRole('User');
        // }
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('Admin');
    }
}
