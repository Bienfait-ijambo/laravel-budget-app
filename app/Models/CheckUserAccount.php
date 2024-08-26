<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckUserAccount extends Model
{
    use HasFactory;

    const ACTIVE_USER_ACCOUNT = 'Active';

    const IN_ACTIVE_USER_ACCOUNT = 'Inactive';

    public static function getUserAccountInfo($userId)
    {

        $checkUser = DB::table('check_user_account')
            ->where('user_id', $userId)
            ->first();

        if (! is_null($checkUser)) {

            return [
                'leftDays' => $checkUser->leftDays,
                'account_status' => $checkUser->account_status,
            ];
        } else {

            return CheckUserAccount::addTrialDays($userId);

        }
    }

    public static function addTrialDays($userId)
    {
        return DB::transaction(function () use ($userId) {
            //add trial days
            //basic price
            $stripePriceId = 'price_1PZbOVHpqk1Ix2np7tbxqlP2';

            $paymentTerms = Pricing::getPricingTerms($stripePriceId, date('Y-m-d'));

            DB::table('check_user_accounts')
                ->insert([
                    'user_id' => $userId,
                    'stripe_price_id' => $stripePriceId,
                    'account_status' => 'Active',
                    'start_date' => $paymentTerms['startDate'],
                    'end_date' => $paymentTerms['endDate'],
                ]);

            $checkUser = DB::table('check_user_account')
                ->where('user_id', $userId)
                ->first();

            return [
                'leftDays' => $checkUser->leftDays,
                'account_status' => $checkUser->account_status,
            ];
        });

    }
}
