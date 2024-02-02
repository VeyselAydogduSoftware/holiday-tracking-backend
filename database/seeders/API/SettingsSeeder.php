<?php

namespace Database\Seeders\API;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('settings_api')->insert([
            [
                '_key' => 'api_security_key',
                '_value' => '1234567890',
                'description' => 'Required to accept requests',
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
