@extends('layout')

@section('main')
<div class="container mt-5">
    <h2 class="mb-4">إضافة مصروف جديد</h2>


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('offices.expenses.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="category_id" class="form-label">الفئة</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="" selected>-- اختر الفئة --</option>
                @foreach (\App\Models\ExpenseCategory::all() as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">يرجى اختيار فئة المصروف.</div>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">اسم المصروف</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            <div class="invalid-feedback">يرجى إدخال اسم المصروف.</div>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">المبلغ</label>
            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" min="0" required>
            <div class="invalid-feedback">يرجى إدخال مبلغ صالح.</div>
        </div>

        <div class="mb-3">
            <label for="paid_fees" class="form-label">المبلغ المدفوع</label>
            <input type="number" class="form-control" id="paid_fees" name="paid_fees" value="{{ old('paid_fees', 0) }}" min="0" required>
            <div class="invalid-feedback">يرجى إدخال مبلغ مدفوع صالح وأقل من أو يساوي المبلغ.</div>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">التاريخ</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
            <div class="invalid-feedback">يرجى اختيار التاريخ.</div>
        </div>

        <div class="mb-3">
            <label for="method" class="form-label">طريقة الدفع</label>
            <input type="text" class="form-control" id="method" name="method" value="{{ old('method', 'كاش') }}">
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">ملاحظات</label>
            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">وصف إضافي</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">حفظ المصروف</button>
    </form>
</div>

{{-- تفعيل تحقق bootstrap للحقول --}}
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
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
