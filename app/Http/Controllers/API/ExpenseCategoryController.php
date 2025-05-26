<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->ExpenseCategories;
        return response()->json($categories, 200);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);
        $validatedData['user_id'] = auth()->id();
        $category = ExpenseCategory::create($validatedData);
        return response()->json('تم إنشاء الفئة بنجاح', 201);
    }

    
    public function destroy(ExpenseCategory $category)
    {
        if ($category->user_id !== auth()->id()) 
        {
            return response()->json('غير مصرح', 403);
        }
        $category->delete();
        return response()->json('تم حذف الفئة بنجاح', 200);
    }
}
