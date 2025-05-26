<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    public function index()
    {

        $customers = Auth::user()->customers()->count();
        $cases = Auth::user()->customers()->withCount('cases')->get()->sum('cases_count');
        $sessions = Auth::user()->customers()->with('cases.sessions')->get()->pluck('cases')->flatten()->pluck('sessions')->flatten()->count();
        $contracts = Auth::user()->customers()->with('cases')->get()->pluck('cases')->flatten()->sum('contract_price');
        $payments = Auth::user()->customers()->with('cases.payments')->get()->pluck('cases')->flatten()->pluck('payments')->flatten()->sum('amount');
        $remaining = $contracts - $payments;
        $expenses = Auth::user()->expenses()->sum('amount');
        $expenses = (int) $expenses;
        $revnue = $payments - $expenses;
        return response()->json([
            'customers' => $customers,
            'cases'     => $cases,
            'sessions'  => $sessions,
            'contracts' => $contracts,
            'payments'  => $payments,
            'remaining' => $remaining,
            'expenses'  => $expenses,
            'revnue'    => $revnue,
        ]);
    }

    public function sessionDates(){

        $sessions = Auth::user()->customers()->with('cases.sessions')->get()->pluck('cases')->flatten()->pluck('sessions')->flatten()->pluck('date');
        return response()->json($sessions);
    }
}
