@extends('layout')

@section('main')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">📂 القضايا في فئة: {{ $category }}</h4>
        <div>
            <a href="{{ route('offices.issue') }}" class="btn btn-secondary btn-sm me-2">⬅️ رجوع</a>
            <a href="{{ route('offices.issue.create') }}" class="btn btn-primary btn-sm">➕ إضافة قضية</a>
        </div>
    </div>

    @if($issues->isEmpty())
        <div class="alert alert-info">لا توجد قضايا في هذه الفئة حالياً</div>
    @else
        <div class="list-group">
            @foreach($issues as $issue)
                <div class="list-group-item mb-3 border rounded-3 shadow-sm">
                    <h5>{{ $issue->case_title ?? 'بدون عنوان' }}</h5>
                    <p><strong>رقم القضية:</strong> {{ $issue->case_number ?? '-' }}</p>
                    <p><strong>العميل:</strong> {{ $issue->customer->name ?? 'غير معروف' }}</p>
                    <p><strong>قيمة العقد:</strong> {{ number_format($issue->contract_price, 0, '.', ',') }} ج.م</p>
                    <p><strong>المدفوع:</strong> {{ number_format($issue->paid_fees, 0, '.', ',') }} ج.م</p>
                    <p>
                        <strong>المتبقي:</strong>
                        <span class="{{ $issue->remaining_fees > 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($issue->remaining_fees, 0, '.', ',') }} ج.م
                        </span>
                    </p>
                    <a href="{{ route('offices.issue.edit', $issue->id) }}" class="btn btn-sm btn-outline-warning me-1">✏️ تعديل</a>
                    <form method="POST" action="{{ route('offices.issue.delete', $issue->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف القضية؟')">🗑️ حذف</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
