<?php

namespace Database\Seeders;

use App\Models\Pricing;
use DB;
use Illuminate\Database\Seeder;

class PricingSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = DB::table('pricings');

        $table->insert([
            'name' => 'Basic',
            'stripe_price_id' => 'price_1PZbOVHpqk1Ix2np7tbxqlP2',
            'stripe_prod_id' => 'prod_QQSJdJwwJxMCOW',
            'price' => 15,
            'payment_term' => Pricing::PAYMENT_TERM_MONTH,
        ]);

        $table->insert([
            'name' => 'Pro',
            'stripe_price_id' => 'price_1PZbOyHpqk1Ix2npwRkr2DaW',
            'stripe_prod_id' => 'prod_QQSJdJwwJxMCOW',
            'price' => 100,
            'payment_term' => Pricing::PAYMENT_TERM_YEAR,

        ]);

        $table->insert([
            'name' => 'LifeTime',
            'stripe_price_id' => 'price_1PZbPRHpqk1Ix2npUcsxjwvi',
            'stripe_prod_id' => 'prod_QQSJdJwwJxMCOW',
            'price' => 300,
            'payment_term' => Pricing::PAYMENT_TERM_LIFTIME,
        ]);

    }
}
