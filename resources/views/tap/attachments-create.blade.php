
{{-- resources/views/tap/attachments-create.blade.php --}}
@extends('layout')

@section('main')
<div class="container mt-4">
    <h2>إضافة مرفق جديد</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('offices.attachments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>العنوان</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>القضية</label>
            <input type="number" name="case_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label>الملف</label>
            <input type="file" name="file" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection

