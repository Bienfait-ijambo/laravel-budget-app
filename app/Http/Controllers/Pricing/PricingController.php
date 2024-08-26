<?php

namespace App\Http\Controllers\Pricing;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function getPricings(Request $request)
    {

        // $data = Pricing::select('name', 'stripe_price_id', 'stripe_prod_id', 'price')->get();
        $data = Pricing::with('pricingFeatures')->get();

        return response(['data' => $data], 200);
    }
}
