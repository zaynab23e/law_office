@extends('layout')

@section('main')
<div class="container mt-4">
    <h2>عرض المرفق</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $attachment->title }}</h4>
            <p><strong>نوع الملف:</strong> {{ $attachment->file_type }}</p>
            <p><strong>رقم القضية:</strong> {{ $attachment->case_id }}</p>
            <p><strong>تاريخ الإنشاء:</strong> {{ $attachment->created_at->format('Y-m-d H:i') }}</p>
            <a href="{{ asset('storage/' . $attachment->file_path) }}" class="btn btn-primary mb-3" target="_blank">عرض الملف</a>
            <br>
            <a href="{{ route('offices.attachments') }}" class="btn btn-secondary">رجوع</a>
        </div>
    </div>
</div>
@endsection
