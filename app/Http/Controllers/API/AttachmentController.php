<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\attachment\store;
use App\Http\Requests\attachment\update;
use App\Models\Attachment;
use App\Models\Issue;

class AttachmentController extends Controller
{
    // ده المرفقات
    public function index($customer_id, $case_id)
    {
        $case = Issue::find($case_id);

        if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $attachments = $case->attachments;
        return response()->json($attachments, 200);
    }

    public function store(store $request, $customer_id, $case_id)
    {
        $case = Issue::find($case_id);

        if (!$case || $case->customer_id != $customer_id || $case->customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $file = $request->file('file');
        $filePath = $file->store('attachments');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('attachments'), $fileName);
            $filePath = env('APP_URL') . '/public/attachments/' . $fileName;
        }
        $attachment = $case->attachments()->create([
            'title' => $request->title,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
        ]);

        return response()->json('تم إضافة الملف بنجاح', 201);
    }

    public function show($customer_id, $case_id, $attachment_id)
    {
        $attachment = Attachment::find($attachment_id);

        if (
            !$attachment ||
            $attachment->case_id != $case_id ||
            $attachment->case->customer_id != $customer_id ||
            $attachment->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }

        return response()->json($attachment, 200);
    }

    public function update(update $request, $customer_id, $case_id, $attachment_id)
    {
        $attachment = Attachment::find($attachment_id);

        if (
            !$attachment ||
            $attachment->case_id != $case_id ||
            $attachment->case->customer_id != $customer_id ||
            $attachment->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }

        $validatedData = $request->validated();
        $attachment->update($validatedData);

        return response()->json('تم تحديث الملف بنجاح', 200);
    }

    public function destroy($customer_id, $case_id, $attachment_id)
    {
        $attachment = Attachment::find($attachment_id);

        if (
            !$attachment ||
            $attachment->case_id != $case_id ||
            $attachment->case->customer_id != $customer_id ||
            $attachment->case->customer->user_id !== auth()->id()
        ) {
            return response()->json('غير مصرح', 403);
        }

        $attachment->delete();

        return response()->json('تم حذف الملف بنجاح', 200);
    }
}
