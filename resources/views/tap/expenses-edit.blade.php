@extends('layout')

@section('main')
<div class="container mt-5">
    <h2 class="mb-4">تعديل المصروف</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('offices.expenses.update', $expense->id) }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="category_id" class="form-label">الفئة</label>
            <select name="category_id" id="category_id" class="form-select" required>
                @foreach (\App\Models\ExpenseCategory::all() as $category)
                    <option value="{{ $category->id }}" {{ $expense->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">اسم المصروف</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $expense->name }}" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">المبلغ</label>
            <input type="number" class="form-control" id="amount" name="amount" value="{{ $expense->amount }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="paid_fees" class="form-label">المدفوع</label>
            <input type="number" class="form-control" id="paid_fees" name="paid_fees" value="{{ $expense->paid_fees }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">التاريخ</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $expense->date }}" required>
        </div>

        <div class="mb-3">
            <label for="method" class="form-label">طريقة الدفع</label>
            <input type="text" class="form-control" id="method" name="method" value="{{ $expense->method }}">
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">ملاحظات</label>
            <textarea class="form-control" id="notes" name="notes" rows="3">{{ $expense->notes }}</textarea>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">وصف إضافي</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $expense->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('offices.expenses') }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>

{{-- تحقق Bootstrap --}}
<script>
    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })()
</script>
@endsection
