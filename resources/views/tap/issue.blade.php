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

    <div class="row">
        @forelse ($groupedIssues as $categoryName => $categoryIssues)
            <div class="col-md-6 mb-4">
                <div class="card shadow rounded-4 h-100">
                    <div class="card-header bg-dark text-white rounded-top-4">
                        <h5 class="mb-0">🗂️ {{ $categoryName }}</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($categoryIssues as $issue)
                            <div class="mb-3 border-bottom pb-3">
                                <h6 class="text-primary">{{ $issue->case_title ?? 'بدون عنوان' }}</h6>
                                <p class="mb-1"><strong>رقم القضية:</strong> {{ $issue->case_number ?? '-' }}</p>
                                <p class="mb-1"><strong>العميل:</strong> {{ $issue->customer->name ?? 'غير معروف' }}</p>
                                <p class="mb-1"><strong>قيمة العقد:</strong> {{ number_format($issue->contract_price, 0, '.', ',') }} ج.م</p>
                                <p class="mb-1"><strong>المدفوع:</strong> {{ number_format($issue->paid_fees, 0, '.', ',') }} ج.م</p>
                                <p class="mb-1">
                                    <strong>المتبقي:</strong>
                                    <span class="{{ $issue->remaining_fees > 0 ? 'text-danger' : 'text-success' }}">
                                        {{ number_format($issue->remaining_fees, 0, '.', ',') }} ج.م
                                    </span>
                                </p>
                                <div class="mt-2">
                                    <a href="{{ route('offices.issue.edit', $issue->id) }}" class="btn btn-sm btn-outline-warning me-1">✏️ تعديل</a>
                                    <form method="POST" action="{{ route('offices.issue.delete', $issue->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف القضية؟')">🗑️ حذف</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">لا توجد قضايا حالياً</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
