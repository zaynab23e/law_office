<?php

namespace App\Http\Controllers\Admin;

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

        return view('dashboard', compact('users', 'approvedUsers', 'unApprovedUsers', 'currentMonthUsers', 'customers', 'cases', 'last7DaysUsers','Sessions'));
    }
    public function loadOffices(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $users = $query->orderBy('approved', 'asc')->paginate(10);
        return view('offices.index', compact('users'));
    }

    public function loadOffice($id)
    {
        $user = User::find($id);
        return view('offices.show', compact('user'));
    }

    public function deleteOffice($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('offices.index')->with('success', 'تم حذف المكتب بنجاح');
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
        return redirect()->route('offices.index')->with('success', 'تمت الموافقة على المستخدم بنجاح');
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('offices.index')->with('success', 'تم رفض المستخدم وحذفه بنجاح');
    }
    
//_______________________________________________________________________________________________________



//_______________________________________________________________________________________________________




}
