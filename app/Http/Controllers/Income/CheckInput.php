<?php

namespace App\Http\Controllers\Income;

use Validator;

class CheckInput
{
    /**
     * create endpoint
     *
     * @var array
     */
    public static function validate($fields)
    {

        $errors = Validator::make($fields, [
            'name' => 'required|max:15',
            'amount' => 'required|numeric',
            'userId' => 'required',
        ]);

        if ($errors->fails()) {
            return response([
                'errors' => $errors->errors()->all(),
                'message' => 'invalid input',
            ], 422);
        }

    }

    public static function validateUpdate($fields)
    {

        $errors = Validator::make($fields, [
            'id' => 'required|numeric',
            'name' => 'required|max:15',
            'amount' => 'required|numeric',
            'userId' => 'required',
        ]);

        if ($errors->fails()) {
            return response([
                'errors' => $errors->errors()->all(),
                'message' => 'invalid input',
            ], 422);
        }

    }

    public static function validateDelete($fields)
    {

        $errors = Validator::make($fields, [
            'id' => 'required|numeric',

        ]);

        if ($errors->fails()) {
            return response([
                'errors' => $errors->errors()->all(),
                'message' => 'invalid input',
            ], 422);
        }

    }
}
