<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotesController extends Controller
{
    public function index()
    {
        $notes = Notes::with('admin')->get();
        return response()->json($notes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $note = Notes::create([
            'content' => $request->input('content'),
            'admin_id' => Auth::guard('admin')->id(),
        ]);

        return response()->json($note, 201);
    }

    public function show(Notes $note)
    {
        return response()->json($note);
    }

    public function update(Request $request, Notes $note)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $note->update($request->only('content'));

        return response()->json($note);
    }

    public function destroy(Notes $note)
    {
        $note->delete();
        return response()->json(null, 204);
    }
}
