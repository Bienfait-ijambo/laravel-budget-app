<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    const PAYMENT_TERM_MONTH = 'Month';

    const PAYMENT_TERM_YEAR = 'Year';

    const PAYMENT_TERM_LIFTIME = 'LifeTime';

    const LIFE_TIME_DATE = '2050-10-10';

    protected $fillable = ['name', 'stripe_price_id', 'stripe_prod_id', 'price', 'payment_term'];

    public static function getPricingTerms($stripePriceId, $startDate)
    {

        $pricing = Pricing::where('stripe_price_id', $stripePriceId)->first();

        if ($pricing->payment_term === Pricing::PAYMENT_TERM_MONTH) {

            $days = 31;
            // $startDate=date('Y-m-d');
            $endDate = date('Y-m-d', strtotime($startDate.'+'.$days.' days'));

            return [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'payment_term' => Pricing::PAYMENT_TERM_MONTH,
            ];

        } elseif ($pricing->payment_term === Pricing::PAYMENT_TERM_YEAR) {

            $days = 365;
            // $startDate=date('Y-m-d');
            $endDate = date('Y-m-d', strtotime($startDate.'+'.$days.' days'));

            return [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'payment_term' => Pricing::PAYMENT_TERM_YEAR,
            ];

        } elseif ($pricing->payment_term === Pricing::PAYMENT_TERM_LIFTIME) {
            return [
                'startDate' => $startDate,
                'endDate' => Pricing::LIFE_TIME_DATE,
                'payment_term' => Pricing::PAYMENT_TERM_LIFTIME,
            ];

        }

    }

    public function pricingFeatures()
    {
        return $this->hasMany(PricingFeature::class, 'priceId');
    }
}
