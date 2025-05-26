<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Session;
class SessionController extends Controller
{
    
    public function session(){
        $sessions =Session::all();
        return view('tap.session', compact('sessions'));
    } 

public function createSession() {
    return view('tap.createSession');
}

public function storeSession(Request $request) {
    $request->validate([
        'title' => 'required',
        'date' => 'required|date',
        'description' => 'nullable|string',
        'case_id' => 'required|exists:issues,id',
    ]);

    Session::create($request->all());

    return redirect()->route('offices.session')->with('success', 'تم إنشاء الجلسة بنجاح');
}

public function editSession($id) {
    $session = Session::findOrFail($id);
    return view('tap.editSession', compact('session'));
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

    return redirect()->route('offices.session')->with('success', 'تم تحديث الجلسة بنجاح');
}

public function showSession($id) {
    $session = Session::findOrFail($id);
    return view('tap.showSession', compact('session'));
}

public function deleteSession($id) {
    $session = Session::findOrFail($id);
    $session->delete();
    return redirect()->route('offices.session')->with('success', 'تم حذف الجلسة بنجاح');
}

//___________________________________________________________________________________________________________________


}
