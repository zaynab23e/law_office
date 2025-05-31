<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\Customer;
use App\Models\CaseCategory;
use Illuminate\Support\Facades\Auth;

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
        $issue['paid_fees'] = $issue->expenses->sum('amount');
        $issue['remaining_fees'] = ($issue->contract_price ?? 0) - $issue['paid_fees'];
    }

    return response()->json($issues);
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

        $issue = Issue::create($validated);

        return response()->json($issue, 201);
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

        return response()->json($issue, 200);   
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

        return response()->json(['message' => 'قضية تم حذفها بنجاح'], 200);
    }

    /**
     * عرض تفاصيل القضية
     */
    public function show($id)
    {
        $user = Auth::guard('admin')->user();

        // Find the issue or return 404 if not found
        $issue = Issue::with(['customer', 'category', 'expenses'])->findOrFail($id);

        // Check visibility
        $visibleRoles = $issue->visible_to_roles ?? [];

        // Ensure it's an array (in case null from DB)
        if (!is_array($visibleRoles)) {
            $visibleRoles = json_decode($visibleRoles, true) ?? [];
        }

        // Check if user is allowed
        if (!in_array($user->role, $visibleRoles)) {
            return response()->json([
                'message' => 'You are not authorized to view this issue.'
            ], 403);
        }

        return response()->json($issue);
    }

    public function updateVisibility(Request $request, string $issue)
    {
        $issue = Issue::findOrFail($issue);
        $request->validate([
            'visible_to_roles' => 'required|array',
            'visible_to_roles.*' => 'in:admin,Sub-admin,Assistant'
        ]);
        $issue->visible_to_roles = $request->visible_to_roles;
        $issue->save();

        return response()->json(['message' => 'Visibility updated.']);
    }

}