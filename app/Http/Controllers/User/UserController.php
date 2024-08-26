<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->all();

        $errors = CheckUser::validate($fields);

        if ($errors) {
            return $errors;
        }

        $user = User::create([
            'name' => '-',
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'remember_token' => User::generateRandomCode(),
            'role' => $fields['role'],
        ]);

        return response(['user' => $user, 'message' => 'user created'], 201);
    }
}
