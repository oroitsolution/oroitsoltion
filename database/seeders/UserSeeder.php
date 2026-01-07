<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraint issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        User::create([
            'name'     => 'Superadmin',
            'email'    => 'superadmin@gmail.com',
            'password' => Hash::make('123456789'),
            'role_id'  => 1,
        ]);

        User::create([
            'name'     => 'Oro It',
            'email'    => 'oro@gmail.com',
            'address'  => 'Rani chock jaipur',
            'state'    => 'Rajasthan',
            'city'     => 'Kota',
            'company_name'  => 'ORO IT',
            'password' => Hash::make('123456789'),
            'role_id'  => 2,
        ]);
    

    }
}
