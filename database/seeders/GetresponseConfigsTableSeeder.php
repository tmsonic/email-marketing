<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GetresponseConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('getresponse_configs')->insert([
            'api_key' => 'placeholder',
            'list_token' => 'placeholder',
        ]);
    }
}
