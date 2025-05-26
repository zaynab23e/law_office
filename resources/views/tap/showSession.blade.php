@extends('layout')

@section('main')
<div class="container">
    <h2 class="text-center mb-4">تفاصيل الجلسة</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-4 shadow-sm">
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">عنوان الجلسة</div>
            <div class="col-md-9">{{ $session->title }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">تاريخ الجلسة</div>
            <div class="col-md-9">{{ \Carbon\Carbon::parse($session->date)->format('Y-m-d') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">الوصف</div>
            <div class="col-md-9">{{ $session->description ?? 'لا يوجد وصف' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">رقم القضية</div>
            <div class="col-md-9"><span class="badge bg-secondary">{{ $session->case_id }}</span></div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('offices.session') }}" class="btn btn-secondary">العودة إلى قائمة الجلسات</a>
            <a href="{{ route('offices.session.edit', $session->id) }}" class="btn btn-warning">تعديل الجلسة</a>
        </div>
    </div>
</div>
@endsection