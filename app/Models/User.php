<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Billable, HasApiTokens,HasFactory,Notifiable;

    const CUSTOMER_ROLE = 'CUSTOMER';

    const ADMIN_ROLE = 'ADMIN';

    const ADMIN_EMAIL = 'bienfait201@gmail.com';

    public static function logoutUser($userId)
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', $userId)
            ->delete();
    }

    /*
     * @param  is an object $googleUser
     */
    public static function createUser($googleUser)
    {

        $role = $googleUser->email === User::ADMIN_EMAIL ?
        User::ADMIN_ROLE :
         User::CUSTOMER_ROLE;

        $user = User::updateOrCreate([
            'google_id' => $googleUser->id,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'role' => $role,

        ]);

        return $user;

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'google_id', 'role', 'password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function generateRandomCode()
    {

        $code = Str::random(10).time();

        return $code;
    }
}
