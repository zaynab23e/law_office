<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function attachment()
    {
        $attachments = Attachment::all();
        return response()->json($attachments);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx,xls,txt|max:20480',
            'case_id' => 'required|exists:issues,id',
        ]);

        // حفظ الملف
        $path = $request->file('file')->store('attachments', 'public');

        $attachment = new Attachment();
        $attachment->title = $request->title;
        $attachment->file_path = $path;
        $attachment->file_type = $request->file('file')->getClientOriginalExtension();
        $attachment->case_id = $request->case_id;
        $attachment->save();

        return response()->json([
            'message' => 'تم رفع المرفق بنجاح',
            'attachment' => $attachment
        ], 201);
    }

    public function show($id)
    {
        $attachment = Attachment::findOrFail($id);
        return response()->json($attachment);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'case_id' => 'required|exists:issues,id',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx,xls,txt|max:20480',
        ]);

        $attachment = Attachment::findOrFail($id);
        $attachment->title = $request->title;
        $attachment->case_id = $request->case_id;

        if ($request->hasFile('file')) {
            // حذف الملف القديم
            if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }

            // رفع الملف الجديد
            $path = $request->file('file')->store('attachments', 'public');
            $attachment->file_path = $path;
            $attachment->file_type = $request->file('file')->getClientOriginalExtension();
        }

        $attachment->save();

        return response()->json([
            'message' => 'تم تحديث المرفق بنجاح',
            'attachment' => $attachment
        ], 200);
    }

    public function destroy($id)
    {
        $attachment = Attachment::findOrFail($id);

        if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $attachment->delete();

        return response()->json(['message' => 'تم حذف المرفق بنجاح.'], 200);
    }
}
