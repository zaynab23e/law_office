<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\caseExpense\store;
use App\Http\Requests\caseExpense\update;
use App\Models\CaseExpense;
use App\Models\Issue;

class CaseExpenseController extends Controller
{
    // ده المدفوعات
public function index($customer_id, $case_id)
{
    $case = Issue::find($case_id);

    if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
        return response()->json('غير مصرح', 403);
    }

    $expenses = $case->expenses->map(function ($expense) use ($case) {
        $expense['customer_id'] = $case->customer->id;
        return $expense;
    });

    $total = $expenses->sum('amount');

    return response()->json([
        'expenses' => $expenses,
        'مصروفات القضية الكلية' => $total,
    ], 200);
}





    public function store(store $request, $customer_id, $case_id)
    {
        $case = Issue::find($case_id);

        if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $validatedData = $request->validated();
        $case->expenses()->create($validatedData);
        return response()->json('تم الإضافة بنجاح', 201);
    }

    public function show($customer_id, $case_id, $expense_id)
    {
        $expense = CaseExpense::find($expense_id);

        if (
            !$expense ||
            $expense->case_id != $case_id ||
            $expense->case->customer_id != $customer_id ||
            $expense->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }

        return response()->json($expense, 200);
    }

    public function update(update $request, $customer_id, $case_id, $expense_id)
    {
        $expense = CaseExpense::find($expense_id);

        if (
            !$expense ||
            $expense->case_id != $case_id ||
            $expense->case->customer_id != $customer_id ||
            $expense->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }

        $validatedData = $request->validated();
        $expense->update($validatedData);

        return response()->json('تم التحديث بنجاح', 200);
    }

    public function destroy($customer_id, $case_id, $expense_id)
    {
        $expense = CaseExpense::find($expense_id);

        if (
            !$expense ||
            $expense->case_id != $case_id ||
            $expense->case->customer_id != $customer_id ||
            $expense->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }

        $expense->delete();

        return response()->json('تم الحذف بنجاح', 200);
    }
}
