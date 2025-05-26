<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerCategory;

class CustomerCategryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->CustomerCategories;
        return response()->json($categories, 200);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);
        $validatedData['user_id'] = auth()->id();
        $category = CustomerCategory::create($validatedData);
        return response()->json('تم إنشاء الفئة بنجاح', 201);
    }
    
    public function destroy(CustomerCategory $category)
    {
        if ($category->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }
        $category->delete();
        return response()->json('تم حذف الفئة بنجاح', 200);
    }
}
