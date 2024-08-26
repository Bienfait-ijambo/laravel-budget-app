<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function getExpenses(Request $request)
    {

        $data = Expense::select('id', 'name', 'amount', 'userId')->get();

        return response(['data' => $data], 200);
    }

    public function store(Request $request)
    {

        $fields = $request->all();
        $errors = CheckInput::validate($fields);

        if ($errors) {
            return $errors;
        }

        $expense = Expense::create([
            'name' => $fields['name'],
            'amount' => $fields['amount'],
            'userId' => $fields['userId'],
        ]);

        return response(['message' => 'saved expense successfully', 'expense' => $expense], 201);
    }

    public function update(Request $request)
    {

        $fields = $request->all();
        $errors = CheckInput::validateUpdate($fields);

        if ($errors) {
            return $errors;
        }

        Expense::where('id', $fields['id'])
            ->update([
                'name' => $fields['name'],
                'amount' => $fields['amount'],
                'userId' => $fields['userId'],
            ]);

        return response(['message' => 'updated expense successfully'], 200);
    }

    public function destroy(Request $request)
    {
        $fields = $request->all();
        $errors = CheckInput::validateDelete($fields);

        if ($errors) {
            return $errors;
        }

        Expense::where('id', $fields['id'])->delete();

        return response(['message' => 'Expense deleted successfully'], 200);

    }
}
