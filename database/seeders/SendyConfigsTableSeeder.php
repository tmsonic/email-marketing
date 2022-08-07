<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SendyConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sendy_configs')->insert([
            'install_url' => 'placeholder',
            'api_key' => 'placeholder',
            'list_id' => 'placeholder',
        ]);
    }
}
