<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
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
        $users = User::count();
        $Sessions = Session::count();
        $unApprovedUsers = User::where('approved', false)->count();
        $approvedUsers = User::where('approved', true)->count();
        $currentMonthUsers = User::whereMonth('created_at', now()->month)->count();
        $customers = Customer::count();
        $cases = Issue::count();


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
            'users' => $users,
            'approvedUsers' => $approvedUsers,
            'unApprovedUsers' => $unApprovedUsers,
            'currentMonthUsers' => $currentMonthUsers,
            'customers' => $customers,
            'cases' => $cases,
            'last7DaysUsers' => $last7DaysUsers,
            'Sessions' => $Sessions
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
