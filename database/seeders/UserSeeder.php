<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Pedro Reis',
            'email' => 'pedropcr.42@gmail.com',
            'password' => Hash::make('123456'),
            'cpf' => '256.589.471-99',
            'birth_date' => '2000-02-21 00:00:00',
            'address' => 'Rua Acre',
            'address_number' => '2748',
            'neighborhood' => 'Custódio Pereira',
            'city' => 'Uberlândia',
            'state' => 'MG',
            'user_type' => 'A'
        ]);
        DB::table('users')->insert([
            'name' => 'José Silva',
            'email' => 'josesilva@gmail.com',
            'password' => Hash::make('123456'),
            'cpf' => '256.589.471-99',
            'birth_date' => '2000-02-21 00:00:00',
            'address' => 'Rua Acre',
            'address_number' => '2748',
            'neighborhood' => 'Custódio Pereira',
            'city' => 'Uberlândia',
            'state' => 'MG',
            'user_type' => 'F'
        ]);
        DB::table('users')->insert([
            'name' => 'Ana Julia',
            'email' => 'anaju01@gmail.com',
            'password' => Hash::make('123456'),
            'cpf' => '256.589.471-99',
            'birth_date' => '2000-02-21 00:00:00',
            'address' => 'Av. Floriano Peixoto',
            'address_number' => '4022',
            'neighborhood' => 'Umuarama',
            'city' => 'Uberlândia',
            'state' => 'MG',
            'user_type' => 'F'
        ]);
        DB::table('users')->insert([
            'name' => 'Laura Reis',
            'email' => 'laurareis22@gmail.com',
            'password' => Hash::make('123456'),
            'cpf' => '256.589.471-99',
            'birth_date' => '2000-02-21 00:00:00',
            'address' => 'Rua Ituiutaba',
            'address_number' => '377',
            'neighborhood' => 'Aparecida',
            'city' => 'Uberlândia',
            'state' => 'MG',
            'user_type' => 'F'
        ]);
    }
}
