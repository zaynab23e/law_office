<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpensesController extends Controller
{
    
    public function index()
    {
        $expenses = Expense::all();
        return view('tap.expenses', compact('expenses'));
    }


    public function create()
    {
        return view('tap.expenses-create'); // لازم تعملي الصفحة دي
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
        $expense->user_id = auth()->id() ?? 1; // قيمة افتراضية لو ما في auth
        $expense->save();

        return redirect()->route('offices.expenses')->with('success', 'تمت إضافة المصروف بنجاح.');
    }


    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('tap.expenses-edit', compact('expense')); // لازم تعملي الصفحة دي
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

        return redirect()->route('offices.expenses')->with('success', 'تم تحديث المصروف بنجاح.');
    }

   
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->back()->with('success', 'تم حذف المصروف.');
    }

    
    public function show($id)
    {
        $expense = Expense::findOrFail($id);
        return view('tap.expenses-show', compact('expense')); // لازم تعملي الصفحة دي
    }
}
