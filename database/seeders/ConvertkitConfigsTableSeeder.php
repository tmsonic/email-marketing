<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConvertkitConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('convertkit_configs')->insert([
            'api_key' => 'placeholder',
            'sequence_id' => 'placeholder',
        ]);
    }
}
