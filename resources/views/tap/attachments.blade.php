{{-- resources/views/tap/attachments.blade.php --}}
@extends('layout')

@section('main')
<div class="container mt-4">
    <a href="{{ route('offices.attachments.create') }}" class="btn btn-success mb-3">إضافة مرفق جديد</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>النوع</th>
                <th>الملف</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attachments as $attachment)
            <tr>
                <td>{{ $attachment->title }}</td>
                <td>{{ $attachment->file_type }}</td>
                <td><a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">عرض الملف</a></td>
                <td>
                    <a href="{{ route('offices.attachments.edit', $attachment->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                    <a href="{{ route('offices.attachments.show', $attachment->id) }}" class="btn btn-sm btn-info">عرض</a>
                    <form action="{{ route('offices.attachments.destroy', $attachment->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل أنت متأكد؟')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
