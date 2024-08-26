<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\CheckUserAccount;
use App\Models\Payment;
use App\Models\Pricing;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function blockOrUnblockerUser(Request $request)
    {

        $userId = $request->userId;
        $checkUserAccount = CheckUserAccount::where('user_id', $userId)
            ->first();

        if (! is_null($checkUserAccount)) {

            if ($checkUserAccount->account_status === CheckUserAccount::ACTIVE_USER_ACCOUNT) {
                //block
                CheckUserAccount::where('user_id', $userId)
                    ->update([
                        'account_status' => CheckUserAccount::IN_ACTIVE_USER_ACCOUNT,
                    ]);

                User::logoutUser($request->userId);

                return response(['message' => 'user blocked']);

            } else {
                // unblock
                CheckUserAccount::where('user_id', $userId)
                    ->update([
                        'account_status' => CheckUserAccount::ACTIVE_USER_ACCOUNT,
                    ]);

                return response(['message' => 'unblocked user blocked']);

            }

        }

    }

    public function getUserAccountInfo(Request $request)
    {

        $data = DB::table('check_user_account')
            ->select('*')
            ->get();

        return response(['data' => $data]);
    }

    public function getPayments(Request $request)
    {

        $data = DB::table('payments')
            ->join('pricings', 'payments.stripe_price_id', '=', 'pricings.stripe_price_id')
            ->join('users', 'payments.user_id', '=', 'users.id')
            ->select(
                'pricings.name as pricing',
                'pricings.price as amount',
                'pricings.payment_term',
                'payments.start_date',
                'payments.end_date',
                'payments.currency',
                'users.id as userId'
            )
            ->where('payments.user_id', $request->userId)
            ->get();

        return response(['data' => $data]);
    }

    public function successPayment(Request $request)
    {

        return DB::transaction(function () use ($request) {
            $checkoutSession = $request->user()
                ->stripe()->checkout->sessions
                ->retrieve($request->get('session_id'));

            $user = User::where('stripe_id', $checkoutSession['customer'])
                ->first();
            $stripePriceId = $request->session()->pull('stripePriceId');

            $checkUserAccount = DB::table('check_user_accounts')->where('user_id', $user->id)
                ->first();

            if (! is_null($checkUserAccount)) {

                $endDate = $checkUserAccount->end_date;
                $paymentTerms = Pricing::getPricingTerms($stripePriceId, $endDate);

                Payment::createPayment($user->id, $stripePriceId, $checkoutSession, $paymentTerms);

                DB::table('check_user_accounts')
                    ->where('user_id', $user->id)
                    ->update([
                        'user_id' => $user->id,
                        'stripe_price_id' => $stripePriceId,
                        'account_status' => CheckUserAccount::ACTIVE_USER_ACCOUNT,
                        'start_date' => $paymentTerms['startDate'],
                        'end_date' => $paymentTerms['endDate'],
                    ]);
            } else {

                $paymentTerms = Pricing::getPricingTerms($stripePriceId, date('Y-m-d'));

                Payment::createPayment($user->id, $stripePriceId, $checkoutSession, $paymentTerms);

                DB::table('check_user_accounts')
                    ->insert([
                        'user_id' => $user->id,
                        'stripe_price_id' => $stripePriceId,
                        'account_status' => 'Active',
                        'start_date' => $paymentTerms['startDate'],
                        'end_date' => $paymentTerms['endDate'],
                    ]);
            }

            return redirect(env('VUE_APP_BASE_URL').'/payment_succeed');
        });
    }

    public function checkOutForm(Request $request)
    {

        $stripeProdId = $request->stripe_prod_id;
        $stripePriceId = $request->stripe_price_id;
        $user = Auth::user();

        if (! is_null($user)) {

            $request->session()->put('stripePriceId', $stripePriceId);

            return $request->user()
                ->newSubscription($stripeProdId, $stripePriceId)
                // ->trialDays(5)
                // ->allowPromotionCodes()
                ->checkout([
                    'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('cancel'),
                ]);
        } else {

            return redirect(env('VUE_APP_BASE_URL'));
        }
    }
}
