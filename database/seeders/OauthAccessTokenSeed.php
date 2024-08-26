<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class OauthAccessTokenSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('oauth_access_tokens')->insert([
            'id' => '0b0fe094c134acf210894bc415083e8035cc',
            'client_id' => '0b0fe094c134acf',
            'user_id' => 1,
            'scopes' => '[]',
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
            'expires_at' => now(),
        ]);
    }
}
