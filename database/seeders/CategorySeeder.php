<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Camisetas',
        ]);
        DB::table('categories')->insert([
            'name' => 'Acessórios',
        ]);
        DB::table('categories')->insert([
            'name' => 'Calçados',
        ]);
    }
}
