@extends('layout')

@section('main')
<div class="container">
    <h2 class="text-center mb-4">تعديل الجلسة</h2>

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

    <form action="{{ route('offices.session.update', $session->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('POST')
        <div class="mb-3">
            <label for="title" class="form-label">عنوان الجلسة</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $session->title) }}" required>
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">تاريخ الجلسة</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $session->date) }}" required>
            @error('date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">الوصف (اختياري)</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $session->description) }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="case_id" class="form-label">رقم القضية</label>
            <select name="case_id" id="case_id" class="form-control" required>
                <option value="">اختر القضية</option>
                @foreach (\App\Models\Issue::all() as $issue)
                    <option value="{{ $issue->id }}" {{ old('case_id', $session->case_id) == $issue->id ? 'selected' : '' }}>
                        {{ $issue->title ?? 'قضية رقم ' . $issue->id }}
                    </option>
                @endforeach
            </select>
            @error('case_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">تحديث الجلسة</button>
            <a href="{{ route('offices.session') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
</div>
@endsection