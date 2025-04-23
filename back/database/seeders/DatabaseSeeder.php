<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void{
        User::insert([
            [
                'name' => 'Administrador',
                'username' => 'admin',
                'agencia' => 'Challgua',
                'role' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123Admin'),
                'active' => '1',
                'avatar' => 'default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Adimer Paul Chambi Ajata',
                'username' => 'adimer',
                'agencia' => 'Challgua',
                'role' => 'Usuario',
                'email' => 'adimer@example.com',
                'password' => Hash::make('adimer123Adimer'),
                'active' => '1',
                'avatar' => 'default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jhenny Condori Mamani',
                'username' => 'jhenny',
                'agencia' => 'Challgua',
                'role' => 'Usuario',
                'email' => 'jhenny@example.com',
                'password' => Hash::make('jhenny123'),
                'active' => '1',
                'avatar' => 'default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vianca Maman Batallanes',
                'username' => 'vianca',
                'agencia' => 'Challgua',
                'role' => 'Usuario',
                'email' => 'vianca@example.com',
                'password' => Hash::make('vianca123'),
                'active' => '1',
                'avatar' => 'default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Olivia Challgua Chugar',
                'username' => 'olivia',
                'agencia' => 'Challgua',
                'role' => 'Usuario',
                'email' => 'olivia@example.com',
                'password' => Hash::make('olivia123'),
                'active' => '1',
                'avatar' => 'default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Juany Condoy Mamani',
                'username' => 'juany',
                'agencia' => 'Challgua',
                'role' => 'Usuario',
                'email' => 'juany@example.com',
                'password' => Hash::make('juany123'),
                'active' => '1',
                'avatar' => 'default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vitai Flores Quispe',
                'username' => 'vitai',
                'agencia' => 'Challgua',
                'role' => 'Usuario',
                'email' => 'vitai@example.com',
                'password' => Hash::make('vitai123'),
                'active' => '1',
                'avatar' => 'default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
