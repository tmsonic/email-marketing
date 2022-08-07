<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SendinblueConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sendinblue_configs')->insert([
            'api_key' => 'placeholder',
            'list_id' => 'placeholder',
        ]);
    }
}
