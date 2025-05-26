@extends('layout')

@section('main')
<div class="container mt-5">
    <h2 class="mb-4">تفاصيل المصروف</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $expense->name }}</h5>

            <p><strong>الفئة:</strong> {{ $expense->category->name ?? 'غير محدد' }}</p>
            <p><strong>المبلغ:</strong> {{ $expense->amount }} جنيه</p>
            <p><strong>المدفوع:</strong> {{ $expense->paid_fees }} جنيه</p>
            <p><strong>المتبقي:</strong> {{ $expense->remaining_fees }} جنيه</p>
            <p><strong>التاريخ:</strong> {{ $expense->date }}</p>
            <p><strong>طريقة الدفع:</strong> {{ $expense->method }}</p>
            <p><strong>ملاحظات:</strong> {{ $expense->notes ?? 'لا يوجد' }}</p>
            <p><strong>الوصف:</strong> {{ $expense->description ?? 'لا يوجد' }}</p>
            <p><strong>المستخدم:</strong> {{ $expense->user->name ?? 'غير معروف' }}</p>

            <a href="{{ route('offices.expenses.edit', $expense->id) }}" class="btn btn-warning mt-3">تعديل</a>
            <a href="{{ route('offices.expenses') }}" class="btn btn-secondary mt-3">العودة</a>
        </div>
    </div>
</div>
@endsection
