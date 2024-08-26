<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CheckUserAccount;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tests\Feature\FakeUser;

class AuthController extends Controller
{
    public function getUserData(Request $request)
    {

        $loginUser = DB::table('oauth_access_tokens')
            ->where('client_id', $request->client_id)
            ->first();

        if (! is_null($loginUser)) {

            $userId = $loginUser->user_id;

            $user = User::where('id', $userId)
                ->select('id', 'name', 'email', 'role')
                ->first();

            if ($user->email === User::ADMIN_EMAIL) {
                return response(['user' => $user, 'userAccount' => [
                    'leftDays' => 0,
                    'account_status' => CheckUserAccount::ACTIVE_USER_ACCOUNT,
                ]]);
            } else {

                $userAccount = CheckUserAccount::getUserAccountInfo($userId);

                return response(['user' => $user, 'userAccount' => $userAccount]);

            }

        }

    }

    public function logout(Request $request)
    {
        User::logoutUser($request->userId);

        return response(['message' => 'user logged out']);
    }

    public function redirectToGoogle()
    {

        return redirect('/auth/callback');
        // return Socialite::driver('google')->redirect();
    }

    public function createUserViaGoogle(Request $request)
    {

        // $googleUser = Socialite::driver('google')->user();

        $googleUser = new FakeUser('1', 'ben', 'ijamboizuba20@gmail.com', User::CUSTOMER_ROLE);

        $user = User::createUser($googleUser);

        Auth::login($user);

        $request->session()->put('state', $state = Str::random(40));

        $request->session()->put(
            'code_verifier', $code_verifier = Str::random(128)
        );

        $codeChallenge = strtr(rtrim(
            base64_encode(hash('sha256', $code_verifier, true)), '='), '+/', '-_');

        $query = http_build_query([
            'client_id' => '9ca9a351-601f-41da-90d8-d2c86f80dc6c',
            'redirect_uri' => 'https://vue-budget-app.onrender.com/callback',
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256',
            'prompt' => 'login', // "none", "consent", or "login"
        ]);

        return redirect('/oauth/authorize?'.$query);

    }
}
