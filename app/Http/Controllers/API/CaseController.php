<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\issue\storeCaseRequest;
use App\Http\Requests\issue\updateCaseRequest;
use App\Models\CaseCategory;
use App\Models\Customer;
use App\Models\Issue;

class CaseController extends Controller
{
    // ده القضايا
    public function index($customer_id)
    {
        $customer = Customer::find($customer_id);
    
        if (!$customer || $customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }
        $categoryName = request()->query('case_category');  
        $casesQuery = $customer->cases()->with('category', 'payments');
    
        if ($categoryName) {
            $casesQuery->whereHas('category', function ($query) use ($categoryName) {
                $query->where('name', 'LIKE', '%' . $categoryName . '%');
            });
        }
    
        $cases = $casesQuery->get()->map(function ($case) {
            $paidAmount = $case->payments->sum('amount');
            $remainingAmount = $case->contract_price - $paidAmount;
    
            return [
                'case id'           => $case->id,
                'case number'       => $case->case_number,
                'customer name'     => $case->customer->name,
                'customer phone'    => $case->customer->phone,
                'customer category' => $case->customer->category->name,
                'case category'     => $case->category->name,
                'contract price'    => $case->contract_price,
                'paid amount'       => $paidAmount,
                'remaining amount'  => $remainingAmount,
            ];
        });
    
        return response()->json($cases, 200);
    }
    
    

    public function store(storeCaseRequest $request, $customer_id)
    {
        $validatedData = $request->validated();
        $customer = Customer::find($customer_id);

        if (!$customer || $customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $category = CaseCategory::find($validatedData['case_category_id']);
        if (!$category || $category->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $validatedData['customer_id'] = $customer_id;
        $case = Issue::create($validatedData);

        return response()->json('تم إنشاء القضية بنجاح', 201);
    }

    public function show($customer_id, $case_id)
    {
        $case = Issue::find($case_id);
        if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }
       $caseDetails = $case->only([
        'id', 'customer_id', 'opponent_name','opponent_type', 'opponent_phone', 'opponent_nation', 
        'opponent_address', 'opponent_lawyer', 'lawyer_phone', 'court_name', 
        'judge_name', 'case_number', 'case_title', 'contract_price', 'notes', 
        'case_category_id'
    ]);
       
    
        $paidAmount = $case->payments->sum('amount');
        $remainingAmount = $case->contract_price - $paidAmount;
    
        return response()->json([
            'case'             =>  $caseDetails,
            'customer'         => $case->customer,
            'case_category'    => $case->category,
            'case_expenses'    => $case->expenses,
            'paid_amount'      => $paidAmount,
            'remaining_amount' => $remainingAmount,
        ], 200);
    }
    
    public function update(updateCaseRequest $request, $customer_id, $case_id)
    {
        $validatedData = $request->validated();
        $case = Issue::find($case_id);

        if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        if (isset($validatedData['case_category_id'])) {
            $category = CaseCategory::find($validatedData['case_category_id']);
            if (!$category || $category->user_id !== auth()->id()) {
                return response()->json('غير مصرح', 403);
            }
        }

        $case->update($validatedData);

        return response()->json('تم تحديث القضية بنجاح', 200);
    }

    public function destroy($customer_id, $case_id)
    {
        $case = Issue::find($case_id);

        if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $case->delete();

        return response()->json('تم حذف القضية بنجاح', 200);
    }
}
