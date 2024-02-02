<?php

namespace Database\Seeders\API;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FakeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'webmaster',
            'email' => 'webmaster@local.com',
            'password' => Hash::make('webmaster'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
