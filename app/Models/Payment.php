<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public static function createPayment($userId, $stripePriceId, $checkoutSession, $paymentTerms)
    {
        DB::table('payments')
            ->insert([
                'user_id' => $userId,
                'stripe_price_id' => $stripePriceId,
                'currency' => $checkoutSession['currency'],
                'start_date' => $paymentTerms['startDate'],
                'end_date' => $paymentTerms['endDate'],
                'payment_term' => $paymentTerms['payment_term'],
            ]);
    }
}
