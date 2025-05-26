<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\Customer;
use App\Models\CaseCategory;

class IssueController extends Controller
{
    /**
     * عرض صفحة القضايا الرئيسية
     * تعرض جميع القضايا مع معلومات المدفوعات والمتبقي
     */
//   public function issue()
// {
//     $issues = Issue::with(['customer', 'category', 'expenses'])->get();
    
//     foreach ($issues as $issue) {
//         $issue->paid_amount = $issue->expenses->sum('amount');
//         $issue->remaining_amount = $issue->contract_price - $issue->paid_amount;
//     }
    
//     return view('tap.issue', compact('issues'));
// }
   


public function issue()
{
    $issues = Issue::with(['customer', 'category', 'expenses'])->get();

    foreach ($issues as $issue) {
        $issue->paid_amount = $issue->expenses->sum('amount');
        $issue->remaining_amount = ($issue->contract_price ?? 0) - $issue->paid_amount;
    }

    return view('tap.issue.issue', compact('issues'));
}

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $categories = CaseCategory::orderBy('name')->get();
        
        return view('tap.issue.createIssue', compact('customers', 'categories'));
    }

    /**
     * حفظ القضية الجديدة في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'opponent_name' => 'required|string|max:255',
            'opponent_type' => 'required|string|max:255',
            'opponent_phone' => 'nullable|string|max:20',
            'opponent_address' => 'nullable|string',
            'opponent_nation' => 'nullable|string|max:255',
            'opponent_lawyer' => 'nullable|string|max:255',
            'lawyer_phone' => 'nullable|string|max:20',
            'court_name' => 'required|string|max:255',
            'circle' => 'nullable|string|max:255',
            'case_number' => 'required|string|max:255',
            'case_title' => 'required|string|max:255',
            'attorney_number' => 'nullable|string|max:255',
            'register_date' => 'required|date',
            'judge_name' => 'nullable|string|max:255',
            'contract_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'case_category_id' => 'required|exists:case_categories,id',
        ]);

        // إضافة القيم الافتراضية
        $validated['register_date'] = now()->parse($validated['register_date'])->format('Y-m-d');

        Issue::create($validated);

        return redirect()
              ->route('offices.issue')
              ->with('success', 'تم إنشاء القضية بنجاح');
    }

    /**
     * عرض نموذج تعديل القضية
     */
    public function edit($id)
    {
        $issue = Issue::with(['customer', 'category'])->findOrFail($id);
        $customers = Customer::orderBy('name')->get();
        $categories = CaseCategory::orderBy('name')->get();
        
        return view('tap.editIssue', compact('issue', 'customers', 'categories'));
    }

    /**
     * تحديث بيانات القضية في قاعدة البيانات
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'opponent_name' => 'required|string|max:255',
            'opponent_type' => 'required|string|max:255',
            'opponent_phone' => 'nullable|string|max:20',
            'opponent_address' => 'nullable|string',
            'opponent_nation' => 'nullable|string|max:255',
            'opponent_lawyer' => 'nullable|string|max:255',
            'lawyer_phone' => 'nullable|string|max:20',
            'court_name' => 'required|string|max:255',
            'circle' => 'nullable|string|max:255',
            'case_number' => 'required|string|max:255',
            'case_title' => 'required|string|max:255',
            'attorney_number' => 'nullable|string|max:255',
            'register_date' => 'required|date',
            'judge_name' => 'nullable|string|max:255',
            'contract_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'case_category_id' => 'required|exists:case_categories,id',
        ]);

        $issue = Issue::findOrFail($id);
        $issue->update($validated);

        return redirect()
              ->route('offices.issue')
              ->with('success', 'تم تحديث القضية بنجاح');
    }

    /**
     * حذف القضية من قاعدة البيانات
     */
    public function delete($id)
    {
        $issue = Issue::findOrFail($id);
        
        // حذف جميع المصروفات المرتبطة أولاً
        $issue->expenses()->delete();
        
        // ثم حذف القضية
        $issue->delete();

        return redirect()
              ->route('offices.issue')
              ->with('success', 'تم حذف القضية بنجاح');
    }

    /**
     * عرض تفاصيل القضية
     */
    public function show($id)
    {
        $issue = Issue::with(['customer', 'category', 'expenses'])
                    ->findOrFail($id);
                    
        return view('tap.showIssue', compact('issue'));
    }


public function showByCategory($category)
{

    $category = urldecode($category);

    $issues = Issue::whereHas('category', function($q) use ($category) {
        $q->where('name', $category);
    })->get();

    if ($issues->isEmpty()) {

    }

    return view('tap.issue.byCategory', compact('issues', 'category'));
}


}