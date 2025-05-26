<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpensesController extends Controller
{
    
    public function index()
    {
        $expenses = Expense::all();
        return response()->json($expenses);
    }

    public function store(Request $request)
    {

        $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'name' => 'required|string',
            'amount' => 'required|integer|min:0',
            'paid_fees' => 'required|integer|min:0|lte:amount',  // paid_fees أقل أو يساوي amount
            'date' => 'required|date',
            'method' => 'nullable|string',
            'notes' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // استلام القيم
        $amount = $request->amount;
        $paid_fees = $request->paid_fees;

        // حساب المتبقي
        $remaining_fees = $amount - $paid_fees;

        // إنشاء المصروف
        $expense = new Expense();
        $expense->category_id = $request->category_id;
        $expense->name = $request->name;
        $expense->amount = $amount;
        $expense->paid_fees = $paid_fees;
        $expense->remaining_fees = $remaining_fees;
        $expense->date = $request->date;
        $expense->method = $request->method ?? 'كاش';
        $expense->notes = $request->notes;
        $expense->description = $request->description;
        $expense->user_id = $request->user_id; // قيمة افتراضية لو ما في auth
        $expense->save();

        return response()->json([
            'message' => 'تمت إضافة المصروف بنجاح.',
            'expense' => $expense
        ], 201);
    }



    
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'name' => 'required|string',
            'amount' => 'required|integer|min:0',
            'paid_fees' => 'required|integer|min:0|lte:amount',  // paid_fees أقل أو يساوي amount
            'date' => 'required|date',
            'method' => 'nullable|string',
            'notes' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // استلام القيم
        $amount = $request->amount;
        $paid_fees = $request->paid_fees;

        // حساب المتبقي
        $remaining_fees = $amount - $paid_fees;

        // تحديث المصروف
        $expense = Expense::findOrFail($id);
        $expense->category_id = $request->category_id;
        $expense->name = $request->name;
        $expense->amount = $amount;
        $expense->paid_fees = $paid_fees;
        $expense->remaining_fees = $remaining_fees;
        $expense->date = $request->date;
        $expense->method = $request->method ?? 'كاش';
        $expense->notes = $request->notes;
        $expense->description = $request->description;
        $expense->save();

        return response()->json([
            'message' => 'تم تحديث المصروف بنجاح.',
            'expense' => $expense
        ], 200);
    }

   
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return response()->json(['message' => 'تم حذف المصروف.'], 200);
    }

    
    public function show($id)
    {
        $expense = Expense::findOrFail($id);
        return response()->json($expense);
    }
}
