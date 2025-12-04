<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Schema::disableForeignKeyConstraints();
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(Modelrole::class);
        $this->call(UserSeeder::class);
        Schema::enableForeignKeyConstraints();
        
    }
}
