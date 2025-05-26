<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\payment\store;
use App\Http\Requests\payment\update;
use App\Models\Payment;
use App\Models\Issue;

class PaymentController extends Controller
{
    public function index($customer_id, $case_id)
    {
        $case = Issue::find($case_id);

        if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $payments = $case->payments;

        $paidAmount = $payments->sum('amount');
        $remainingAmount = $case->contract_price - $paidAmount;

        return response()->json([
            'payments'         => $payments,
            'paid_amount'      => $paidAmount,
            'remaining_amount' => $remainingAmount,
        ], 200);
    }

    public function store(store $request, $customer_id, $case_id)
    {
        $case = Issue::find($case_id);

        if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $validatedData = $request->validated();

        $paidAmount = $case->payments->sum('amount');
        $remainingAmount = $case->contract_price - $paidAmount;

        if ($validatedData['amount'] > $remainingAmount) {
            return response()->json('المبلغ أكبر من السعر المتبقي', 400);
        }
        $paidAmount = $case->payments->sum('amount');
        $remainingAmount = $case->contract_price - $paidAmount;

        $case->payments()->create($validatedData);

       

        return response()->json([
            'message' => 'تم إضافة المبلغ بنجاح',
        ], 201);
    }
    
    public function show($customer_id, $case_id, $payment_id)
    {
        $payment = Payment::find($payment_id);

        if (
            !$payment ||
            $payment->case_id != $case_id ||
            $payment->case->customer_id != $customer_id ||
            $payment->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }
    

        return response()->json([
            'payment' => $payment,
        ], 200);
    }

    public function update(update $request, $customer_id, $case_id, $payment_id)
    {
        $payment = Payment::find($payment_id);
    
        if (
            !$payment ||
            $payment->case_id != $case_id ||
            $payment->case->customer_id != $customer_id ||
            $payment->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }
    
        $validatedData = $request->validated();
    
        if (isset($validatedData['amount'])) {
            $case = $payment->case;
            $paidAmount = $case->payments->where('id', '!=', $payment->id)->sum('amount');
            $remainingAmount = $case->contract_price - $paidAmount;
    
            if ($validatedData['amount'] > $remainingAmount) {
                return response()->json('المبلغ أكبر من السعر المتبقي', 400);
            }
    
            $difference = $validatedData['amount'] - $payment->amount;
            $paidAmount += $difference;
            $remainingAmount -= $difference;
        } else {
            $paidAmount = $payment->case->payments->sum('amount');
            $remainingAmount = $payment->case->contract_price - $paidAmount;
        }
    
        $payment->update($validatedData);
    
        return response()->json( 'تم تحديث البيانات بنجاح', 200);
    }
    

    public function destroy($customer_id, $case_id, $payment_id)
    {
        $payment = Payment::find($payment_id);

        if (
            !$payment ||
            $payment->case_id != $case_id ||
            $payment->case->customer_id != $customer_id ||
            $payment->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }

        $payment->delete();

        $case = $payment->case;
        $paidAmount = $case->payments->sum('amount');
        $remainingAmount = $case->contract_price - $paidAmount;

        return response()->json([
            'message' => 'تم حذف المبلغ بنجاح',
            'paid_amount' => $paidAmount,
            'remaining_amount' => $remainingAmount,
        ], 200);
    }
}
