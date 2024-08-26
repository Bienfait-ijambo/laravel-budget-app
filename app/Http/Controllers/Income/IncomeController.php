<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function getChartData(Request $request)
    {

        $totalIncomes = Income::sum('amount');
        $totalExpenses = Expense::sum('amount');

        $total = $totalIncomes + $totalExpenses;

        if ($total > 1) {
            $incomePercent = floatval(number_format($totalIncomes * 100 / $total, 1));
            $expensePercent = floatval(number_format($totalExpenses * 100 / $total, 1));

            return response([$incomePercent, $expensePercent]);
        } else {
            return response([0, 0]);
        }

    }

    public function getIncomes(Request $request)
    {

        $data = Income::select('id', 'name', 'amount', 'userId')->get();

        return response(['data' => $data], 200);
    }

    public function store(Request $request)
    {

        $fields = $request->all();
        $errors = CheckInput::validate($fields);

        if ($errors) {
            return $errors;
        }

        $income = Income::create([
            'name' => $fields['name'],
            'amount' => $fields['amount'],
            'userId' => $fields['userId'],
        ]);

        return response(['message' => 'saved income successfully', 'income' => $income], 201);
    }

    public function update(Request $request)
    {

        $fields = $request->all();
        $errors = CheckInput::validateUpdate($fields);

        if ($errors) {
            return $errors;
        }

        Income::where('id', $fields['id'])
            ->update([
                'name' => $fields['name'],
                'amount' => $fields['amount'],
                'userId' => $fields['userId'],
            ]);

        return response(['message' => 'updated income successfully'], 200);
    }

    public function destroy(Request $request)
    {
        $fields = $request->all();
        $errors = CheckInput::validateDelete($fields);

        if ($errors) {
            return $errors;
        }

        Income::where('id', $fields['id'])->delete();

        return response(['message' => 'income deleted successfully'], 200);

    }
}
