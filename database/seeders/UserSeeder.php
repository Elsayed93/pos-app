<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456789'),
        ]);

        //super_admin
        $admin->attachRole('super_admin');
    }
}
