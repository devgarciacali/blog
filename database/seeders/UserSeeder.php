<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::create([
           'full_name' => 'Manuel Calixto',
           'email' => 'admin@admin.com',
           'password' => Hash::make('12345678'),
       ]);

       User::create([
           'full_name' => 'maria',
           'email' => 'jose@gmail.com',
           'password' => Hash::make('12345678'),
       ]);

       User::factory(10)->create();
    }
}
