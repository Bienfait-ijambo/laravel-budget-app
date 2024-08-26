<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PricingFeatureSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $table = DB::table('pricing_features');

        //basic
        $table->insert([
            'priceId' => 1,
            'name' => 'Basic expense tracking',
        ]);
        $table->insert([
            'priceId' => 1,
            'name' => 'Basic reporting',
        ]);

        //pro

        $table->insert([
            'priceId' => 2,
            'name' => 'Automated transaction import',
        ]);
        $table->insert([
            'priceId' => 2,
            'name' => 'Advanced budgeting',
        ]);
        $table->insert([
            'priceId' => 2,
            'name' => 'Income and expense forecasting',
        ]);

        //lifetime

        $table->insert([
            'priceId' => 3,
            'name' => 'Lifetime access',
        ]);
        $table->insert([
            'priceId' => 3,
            'name' => 'Priority support',
        ]);
    }
}
