@extends('layout')

@section('main')
<div class="container mt-4">
    <h1 class="mb-4">إدارة المستخدمين</h1>
    <form action="{{ route('offices.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="البحث عن طريق اسم المستخدم" value="{{ request('search') }}">
                <div class="input-group-append" style="margin-left: 10px;">
                    <button class="btn btn-dark" type="submit">
                        <i class="fas fa-search"></i> بحث
                    </button>
            </div>
        </div>
    </form>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>رقم الكارنيه</th>
                <th>رقم الهاتف</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->card_number }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        @if($user->approved)
                            <span class="badge bg-success">تمت الموافقة</span>
                        @else
                            <span class="badge bg-warning">في انتظار الموافقة</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('offices.show', $user->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <form action="{{ route('offices.delete', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        
                        @if(!$user->approved)
                            <form action="{{ route('offices.approve', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i> موافقة
                                </button>
                            </form>
                            <form action="{{ route('offices.reject', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i> رفض
                                </button>
                            </form>
                        @else
                            <span></span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">لا يوجد مستخدمون.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
       <!-- Pagination Buttons -->
    <div class="d-flex justify-content-between">
     <!-- Previous Page Button -->
     @if($users->onFirstPage())
         <span class="btn btn-secondary disabled">السابق</span>
     @else
         <a href="{{ $users->previousPageUrl() }}" class="btn btn-primary">السابق</a>
     @endif

     <!-- Next Page Button -->
     @if($users->hasMorePages())
         <a href="{{ $users->nextPageUrl() }}" class="btn btn-primary">التالي</a>
     @else
         <span class="btn btn-secondary disabled">التالي</span>
     @endif
    </div>
</div>

<script>
    // Confirmation dialog in Arabic
    function confirmDelete() {
        return confirm('هل أنت متأكد أنك تريد حذف هذا المستخدم؟ هذا الإجراء لا يمكن التراجع عنه.');
    }
</script>
@endsection
