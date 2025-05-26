@extends('layout')

@section('main')
<div class="container mt-4">
    <h2>تعديل المرفق</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('offices.attachments.update', $attachment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>العنوان</label>
            <input type="text" name="title" class="form-control" value="{{ $attachment->title }}" required>
        </div>

        <div class="form-group">
            <label>القضية</label>
            <input type="number" name="case_id" class="form-control" value="{{ $attachment->case_id }}" required>
        </div>

        <div class="form-group">
            <label>الملف الحالي:</label>
            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">عرض</a>
        </div>

        <div class="form-group">
            <label>تغيير الملف (اختياري)</label>
            <input type="file" name="file" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection
