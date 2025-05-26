@extends('layout')

@section('main')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4">
                    <h4 class="mb-0">💰 المصروفات</h4>
                    <a href="{{ route('offices.expenses.create') }}" class="btn btn-light btn-sm">➕ إضافة مصروف</a>
                </div>
                <div class="card-body p-0">
                    @if($expenses->isEmpty())
                        <div class="p-4 text-center text-muted">لا توجد مصروفات مسجلة حالياً.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>المبلغ الإجمالي</th>
                                        <th>المسدّد من الأتعاب</th>
                                        <th>المتبقي من الأتعاب</th>
                                        <th>التاريخ</th>
                                        <th>طريقة الدفع</th>
                                        <th>الملاحظات</th>
                                        <th>الوصف</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $expense)
                                        <tr>
                                            <td>{{ $expense->id }}</td>
                                            <td class="text-primary fw-bold">{{ $expense->name }}</td>
                                            <td>{{ number_format($expense->amount) }} ج.م</td>
                                            <td class="text-success">{{ number_format($expense->paid_fees) }} ج.م</td>
                                            <td class="text-danger">{{ number_format($expense->remaining_fees) }} ج.م</td>
                                            <td>{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</td>
                                            <td><span class="badge bg-info text-dark">{{ $expense->method }}</span></td>
                                            <td>{{ $expense->notes ?? '—' }}</td>
                                            <td>{{ $expense->description ?? '—' }}</td>
                                            <td class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('offices.expenses.edit', $expense->id) }}" class="btn btn-sm btn-primary" title="تعديل">✏️</a>
                                                <a href="{{ route('offices.expenses.show', $expense->id) }}" class="btn btn-sm btn-info" title="عرض">👁️</a>
                                                <form action="{{ route('offices.expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="حذف">🗑️</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
