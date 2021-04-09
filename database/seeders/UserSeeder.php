<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use this to generate dummy admins
        // \App\Models\User::factory(5)->create();
        
        // Use this to generate default admins
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'Zero',
            'username' => 'admin.zero',
            'email' => 'admin_zero@mail.com',
            'password' => bcrypt('admin0'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'remember_token' => Str::random(10),
            'created_at' => NOW(),
        ]);
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'One',
            'username' => 'admin.one',
            'email' => 'admin_one@mail.com',
            'password' => bcrypt('admin1'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'remember_token' => Str::random(10),
            'created_at' => NOW(),
        ]);
    }
}
