<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Customer;
use App\Models\Issue;
use App\Models\User;
use App\Models\Session;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index()
    {
        $sevenDaysAgo = now()->subDays(7);

        $Sessions = Session::where('created_at', '>=', $sevenDaysAgo)->count();
        $unApprovedCustomers = Customer::whereNotNull('user_id')
            ->whereHas('user', function ($query) use ($sevenDaysAgo) {
                $query->where('approved', false)
                    ->where('created_at', '>=', $sevenDaysAgo);
            })->count();

        $approvedCustomers = Customer::whereNotNull('user_id')
            ->whereHas('user', function ($query) use ($sevenDaysAgo) {
                $query->where('approved', true)
                    ->where('created_at', '>=', $sevenDaysAgo);
            })->count();
        $customers = Customer::where('created_at', '>=', $sevenDaysAgo)->count();
        $cases = Issue::where('created_at', '>=', $sevenDaysAgo)->count();
        $expenses = Expense::where('created_at', '>=', $sevenDaysAgo)->count();
        $attachments = Attachment::where('created_at', '>=', $sevenDaysAgo)->count();



        $dailyUsers = User::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $last7DaysUsers = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $last7DaysUsers[$date] = $dailyUsers[$date] ?? 0;
        }

        return response()->json([
            'customers' => $customers,
            'approvedUsers' => $approvedCustomers,
            'unApprovedUsers' => $unApprovedCustomers,
            'Sessions' => $Sessions,
            'cases' => $cases,
            'expenses' => $expenses,
            'attachments' => $attachments,
            'last7DaysUsers' => $last7DaysUsers,
        ]);
    }
    public function loadOffices(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $users = $query->orderBy('approved', 'asc')->paginate(10);
        return response()->json($users);
    }

    public function loadOffice($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

public function deleteOffice($id)
{
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'المكتب غير موجود'], 404);
    }

    // Delete expenses related to this user's categories
    foreach ($user->expenseCategories as $category) {
        $category->expenses()->delete();
    }

    // Delete the user's expense categories
    $user->expenseCategories()->delete();

    // Delete the user
    $user->delete();

    return response()->json(['message' => 'تم حذف المكتب بنجاح']);
}


    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->approved = true;
        $user->save();


        Mail::raw("تم تأكيد الحساب بنجاح يمكنك الأن تسجيل الدخول", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('تأكيد الحساب');
        });
        return response()->json(['message' => 'تمت الموافقة على المستخدم بنجاح']);
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'تم رفض المستخدم وحذفه بنجاح']);
    }



//_______________________________________________________________________________________________________




}
