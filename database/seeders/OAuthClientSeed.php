<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class OAuthClientSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('oauth_clients')->insert(
            [
                'id' => '9c9ec222-d354-4fd4-9138-9f3c989d85f9',
                'user_id' => null,
                'name' => 'laravel-testcase',
                'secret' => '$2y$10$e93afZ5ITnnJkhYaWbXpaOWt5krctprid7OsNv39RVvuLrwlluBMq',
                'provider' => null,
                'redirect' => 'http://localhost',
                'personal_access_client' => true,
                'password_client' => false,
                'revoked' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        );

        //vue app
        DB::table('oauth_clients')->insert(
            [
                'id' => '9ca9a351-601f-41da-90d8-d2c86f80dc6c',
                'user_id' => null,
                'name' => 'vue app',
                'secret' => '',
                'provider' => null,
                'redirect' => 'https://vue-budget-app.onrender.com/callback',
                'personal_access_client' => false,
                'password_client' => false,
                'revoked' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        );

    }
}
