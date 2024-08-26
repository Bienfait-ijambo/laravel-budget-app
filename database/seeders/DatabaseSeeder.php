<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $checkSeed = DB::table('check_seeds');

        if ($checkSeed->count() === 0) {

            $this->call([
                PricingSeed::class,
                OAuthClientSeed::class,
                OauthAccessTokenSeed::class,
                PricingFeatureSeed::class,
                CreateCheckUserAccountViewSeeder::class,

            ]);

            $checkSeed->insert(['name' => 'seed']);
        }
    }

    // User::factory(10)->create();

    // User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

}
