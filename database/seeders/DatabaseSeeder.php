<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            RolesTableSeeder::class,
            BacklistedDomainsTableSeeder::class,
            BacklistedEmailsTableSeeder::class,
            MarketingProvidersTableSeeder::class,
            SettingsTableSeeder::class,
            MailchimpConfigsTableSeeder::class,
            SendyConfigsTableSeeder::class,
            ConvertkitConfigsTableSeeder::class,
            SendinblueConfigsTableSeeder::class,
            GetresponseConfigsTableSeeder::class,
            SubscribeOptionsTableSeeder::class,
        ]);
    }
}
