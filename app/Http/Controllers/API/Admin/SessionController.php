<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Session;
class SessionController extends Controller
{
    
    public function session(){
        $sessions =Session::all();
        return response()->json($sessions);
    } 



public function storeSession(Request $request) {
    $request->validate([
        'title' => 'required',
        'date' => 'required|date',
        'description' => 'nullable|string',
        'case_id' => 'required|exists:issues,id',
    ]);

    Session::create($request->all());

    return response()->json(['message' => 'تم إنشاء الجلسة بنجاح'], 201);
}


public function updateSession(Request $request, $id) {
    $request->validate([
        'title' => 'required',
        'date' => 'required|date',
        'description' => 'nullable|string',
        'case_id' => 'required|exists:issues,id',
    ]);

    $session = Session::findOrFail($id);
    $session->update($request->all());

    return response()->json(['message' => 'تم تحديث الجلسة بنجاح'], 200);
}

public function showSession($id) {
    $session = Session::findOrFail($id);
    return response()->json($session);
}

public function deleteSession($id) {
    $session = Session::findOrFail($id);
    $session->delete();
    return response()->json(['message' => 'تم حذف الجلسة بنجاح'], 200);
}

//___________________________________________________________________________________________________________________

}
