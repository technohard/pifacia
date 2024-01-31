<?php

// database/seeders/UsersTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    public function run()
    {

        User::create([
            'username' => 'buyer',
            'name' => 'buyer',
            'email' => 'buyer@email.com',
            'role' => 'buyer',
            'password' => Hash::make('buyer'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'username' => 'staf',
            'name' => 'staf',
            'email' => 'staf@email.com',
            'role' => 'staf',
            'password' => Hash::make('staf'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        User::create([
            'username' => 'admin',
            'name' => 'admin',
            'email' => 'admin@email.com',
            'role' => 'admin',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);



        // You can add more users or customize the data as needed
    }
}
