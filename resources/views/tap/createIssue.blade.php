@extends('layout')

@section('main')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h4 class="mb-0">إنشاء قضية جديدة</h4>
                </div>
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('offices.issue.store') }}" method="POST" id="createIssueForm">
                        @csrf
                        <div class="row">
                            <!-- العميل -->
                            <div class="col-md-6 mb-3">
                                <label for="customer_id" class="form-label">العميل</label>
                                <select name="customer_id" id="customer_id" class="form-control" required>
                                    <option value="">اختر العميل</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- فئة القضية -->
                            <div class="col-md-6 mb-3">
                                <label for="case_category_id" class="form-label">فئة القضية</label>
                                <select name="case_category_id" id="case_category_id" class="form-control" required>
                                    <option value="">اختر الفئة</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('case_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('case_category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- اسم الخصم -->
                            <div class="col-md-6 mb-3">
                                <label for="opponent_name" class="form-label">اسم الخصم</label>
                                <input type="text" name="opponent_name" id="opponent_name" class="form-control" value="{{ old('opponent_name') }}" required>
                                @error('opponent_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- نوع الخصم -->
                            <div class="col-md-6 mb-3">
                                <label for="opponent_type" class="form-label">نوع الخصم</label>
                                <input type="text" name="opponent_type" id="opponent_type" class="form-control" value="{{ old('opponent_type') }}" required>
                                @error('opponent_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- هاتف الخصم -->
                            <div class="col-md-6 mb-3">
                                <label for="opponent_phone" class="form-label">هاتف الخصم</label>
                                <input type="text" name="opponent_phone" id="opponent_phone" class="form-control" value="{{ old('opponent_phone') }}">
                                @error('opponent_phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- عنوان الخصم -->
                            <div class="col-md-6 mb-3">
                                <label for="opponent_address" class="form-label">عنوان الخصم</label>
                                <input type="text" name="opponent_address" id="opponent_address" class="form-control" value="{{ old('opponent_address') }}">
                                @error('opponent_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- جنسية الخصم -->
                            <div class="col-md-6 mb-3">
                                <label for="opponent_nation" class="form-label">جنسية الخصم</label>
                                <input type="text" name="opponent_nation" id="opponent_nation" class="form-control" value="{{ old('opponent_nation') }}">
                                @error('opponent_nation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- محامي الخصم -->
                            <div class="col-md-6 mb-3">
                                <label for="opponent_lawyer" class="form-label">محامي الخصم</label>
                                <input type="text" name="opponent_lawyer" id="opponent_lawyer" class="form-control" value="{{ old('opponent_lawyer') }}">
                                @error('opponent_lawyer')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- هاتف المحامي -->
                            <div class="col-md-6 mb-3">
                                <label for="lawyer_phone" class="form-label">هاتف المحامي</label>
                                <input type="text" name="lawyer_phone" id="lawyer_phone" class="form-control" value="{{ old('lawyer_phone') }}">
                                @error('lawyer_phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- اسم المحكمة -->
                            <div class="col-md-6 mb-3">
                                <label for="court_name" class="form-label">اسم المحكمة</label>
                                <input type="text" name="court_name" id="court_name" class="form-control" value="{{ old('court_name') }}" required>
                                @error('court_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- الدائرة -->
                            <div class="col-md-6 mb-3">
                                <label for="circle" class="form-label">الدائرة</label>
                                <input type="text" name="circle" id="circle" class="form-control" value="{{ old('circle') }}">
                                @error('circle')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- رقم القضية -->
                            <div class="col-md-6 mb-3">
                                <label for="case_number" class="form-label">رقم القضية</label>
                                <input type="text" name="case_number" id="case_number" class="form-control" value="{{ old('case_number') }}" required>
                                @error('case_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- عنوان القضية -->
                            <div class="col-md-6 mb-3">
                                <label for="case_title" class="form-label">عنوان القضية</label>
                                <input type="text" name="case_title" id="case_title" class="form-control" value="{{ old('case_title') }}" required>
                                @error('case_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- رقم التوكيل -->
                            <div class="col-md-6 mb-3">
                                <label for="attorney_number" class="form-label">رقم التوكيل</label>
                                <input type="text" name="attorney_number" id="attorney_number" class="form-control" value="{{ old('attorney_number') }}">
                                @error('attorney_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- تاريخ التسجيل -->
                            <div class="col-md-6 mb-3">
                                <label for="register_date" class="form-label">تاريخ التسجيل</label>
                                <input type="date" name="register_date" id="register_date" class="form-control" value="{{ old('register_date') }}" required>
                                @error('register_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- اسم القاضي -->
                            <div class="col-md-6 mb-3">
                                <label for="judge_name" class="form-label">اسم القاضي</label>
                                <input type="text" name="judge_name" id="judge_name" class="form-control" value="{{ old('judge_name') }}">
                                @error('judge_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- قيمة العقد -->
                            <div class="col-md-4 mb-3">
                                <label for="contract_price" class="form-label">قيمة العقد (جنيه)</label>
                                <input type="number" name="contract_price" id="contract_price" class="form-control" value="{{ old('contract_price', 0) }}" required min="0" step="1">
                                @error('contract_price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- المدفوع -->
                            <div class="col-md-4 mb-3">
                                <label for="paid_fees" class="form-label">المدفوع (جنيه)</label>
                                <input type="number" name="paid_fees" id="paid_fees" class="form-control" value="{{ old('paid_fees', 0) }}" min="0" step="1">
                                @error('paid_fees')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <small id="paid_fees_error" class="text-danger"></small>
                            </div>
                            <!-- المتبقي -->
                            <div class="col-md-4 mb-3">
                                <label for="remaining_fees" class="form-label">المتبقي (جنيه)</label>
                                <input type="number" name="remaining_fees" id="remaining_fees" class="form-control" value="{{ old('remaining_fees', 0) }}" readonly>
                                @error('remaining_fees')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- الملاحظات -->
                            <div class="col-md-12 mb-3">
                                <label for="notes" class="form-label">الملاحظات</label>
                                <textarea name="notes" id="notes" class="form-control" rows="4">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">إنشاء القضية</button>
                            <a href="{{ route('offices.issue') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const contractPriceInput = document.querySelector('#contract_price');
    const paidFeesInput = document.querySelector('#paid_fees');
    const remainingFeesInput = document.querySelector('#remaining_fees');
    const paidFeesError = document.querySelector('#paid_fees_error');
    const form = document.querySelector('#createIssueForm');

    function updateRemainingFees() {
        const contractPrice = parseFloat(contractPriceInput.value) || 0;
        const paidFees = parseFloat(paidFeesInput.value) || 0;

        if (paidFees > contractPrice) {
            paidFeesInput.classList.add('is-invalid');
            paidFeesError.textContent = 'المدفوع لا يمكن أن يكون أكبر من قيمة العقد';
            remainingFeesInput.value = 0;
        } else {
            paidFeesInput.classList.remove('is-invalid');
            paidFeesError.textContent = '';
            remainingFeesInput.value = contractPrice - paidFees;
        }
    }

    // Add event listeners for input changes
    contractPriceInput.addEventListener('input', updateRemainingFees);
    paidFeesInput.addEventListener('input', updateRemainingFees);

    // Prevent form submission if paid_fees exceeds contract_price
    form.addEventListener('submit', function (event) {
        const contractPrice = parseFloat(contractPriceInput.value) || 0;
        const paidFees = parseFloat(paidFeesInput.value) || 0;

        if (paidFees > contractPrice) {
            event.preventDefault();
            alert('المدفوع لا يمكن أن يكون أكبر من قيمة العقد');
        }
    });

    // Initialize remaining fees on page load
    updateRemainingFees();
});
</script>
@endsection