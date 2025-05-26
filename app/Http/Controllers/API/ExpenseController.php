<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\expense\store;
use App\Http\Requests\expense\update;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = auth()->user()->expenses;
        return response()->json($expenses, 200);
    }


    public function store(store $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();
        $expense = Expense::create($validatedData);
        return response()->json('تم إنشاء المصروف بنجاح', 201);
        
    }

    public function update(update $request, string $id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json('المصروف غير موجود', 404);
        }
        if ($expense->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $validatedData = $request->validated();
        $expense->update($validatedData);
        return response()->json('تم تحديث المصروف بنجاح', 200);
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $expense->delete();
        return response()->json('تم حذف المصروف بنجاح', 200);
    }
}
