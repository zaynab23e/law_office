@extends('layout')

@section('main')
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📋 القضايا حسب الفئة</h4>
            
                        <a href="{{ route('offices.issue.create') }}" class="btn btn-primary btn-sm">➕ إضافة قضية</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $groupedIssues = $issues->groupBy(fn($issue) => $issue->category->name ?? 'غير مصنفة');
    @endphp

    <div class="row g-4">
        @forelse ($groupedIssues as $categoryName => $categoryIssues)
            <div class="col-md-4">
                <a href="{{ route('offices.issue.byCategory', ['category' => urlencode($categoryName)]) }}" class="text-decoration-none">
                    <div class="card shadow-sm rounded-4 p-4 text-center hover-shadow" style="cursor:pointer;">
                        <h5 class="mb-0 text-primary">🗂️ {{ $categoryName }}</h5>
                        <p class="text-muted mt-2">عدد القضايا: {{ $categoryIssues->count() }}</p>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center mt-4">لا توجد قضايا حالياً</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
