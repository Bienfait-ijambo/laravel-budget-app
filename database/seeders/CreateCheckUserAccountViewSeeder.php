<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class CreateCheckUserAccountViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Drop the view if it already exists
        DB::statement('DROP VIEW IF EXISTS check_user_account');

        // Create the view
        DB::statement('
            CREATE VIEW check_user_account AS 
            SELECT users.id,users.name,users.email,
            pricings.name as pricing,pricings.price as amount,
            pricings.payment_term, 
            check_user_accounts.start_date,
            check_user_accounts.end_date,now() as curr_date, 
            datediff(check_user_accounts.end_date,now()) as leftDays,
            check_user_accounts.account_status,
            users.id as user_id
            FROM `check_user_accounts` 
            INNER JOIN users 
            ON users.id=check_user_accounts.user_id 
            INNER JOIN pricings 
            ON check_user_accounts.stripe_price_id=pricings.stripe_price_id'
        );
    }
}
