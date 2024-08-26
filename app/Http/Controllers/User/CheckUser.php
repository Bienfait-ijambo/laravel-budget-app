<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Validator;

class CheckUser
{
    public static function validate($fields)
    {

        $errors = Validator::make($fields, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:8',
            'role' => 'required',
        ]);

        if ($errors->fails()) {
            return response([
                'errors' => $errors->errors()->all(),
                'message' => 'invalid input',
            ], 422);
        }
    }
}
