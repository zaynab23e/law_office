<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\session\store;
use App\Http\Requests\session\update;
use App\Models\Session;
use App\Models\Issue;


class SessionController extends Controller
{
    // ده الجلسات

    public function index($customer_id, $case_id)
    {
        $case = Issue::find($case_id);

        if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        // $this->sendReminders();

        $sessions = $case->sessions;

        return response()->json($sessions, 200);
    }



    public function store(store $request, $customer_id, $case_id)
    {
        $case = Issue::find($case_id);

        if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $validatedData = $request->validated();
        $case->sessions()->create($validatedData);
        return response()->json('تم إضافة الجلسة بنجاح', 201);
    }

    public function show($customer_id, $case_id, $session_id)
    {
        $session = Session::find($session_id);

        if (
            !$session ||
            $session->case_id != $case_id ||
            $session->case->customer_id != $customer_id ||
            $session->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }

        return response()->json($session, 200);
    }

    public function update(update $request, $customer_id, $case_id, $session_id)
    {
        $session = Session::find($session_id);

        if (
            !$session ||
            $session->case_id != $case_id ||
            $session->case->customer_id != $customer_id ||
            $session->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }

        $validatedData = $request->validated();
        $session->update($validatedData);

        return response()->json('تم تحديث الجلسة بنجاح', 200);
    }

    public function destroy($customer_id, $case_id, $session_id)
    {
        $session = Session::find($session_id);

        if (
            !$session ||
            $session->case_id != $case_id ||
            $session->case->customer_id != $customer_id ||
            $session->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }

        $session->delete();

        return response()->json('تم حذف الجلسة بنجاح', 200);
    }
}
