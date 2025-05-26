@extends('layout')

@section('main')
<div class="container">
    <h1>تفاصيل المكتب</h1>
    <div class="mb-3">
        <h4>الاسم: {{ $user->name }}</h4>
    </div>
    <div class="mb-3">
        <h4>رقم الكارنيه: {{ $user->card_number }}</h4>
    </div>
    <div class="mb-3">
        <h4>الهاتف: {{ $user->phone }}</h4>
    </div>
    <div class="mb-3">
        <h4>الايميل: {{ $user->email }}</h4>
    </div>
    <div class="mb-3">
        @if($user->image)
           <h4>الصورة:</h4>
            <img src="{{ asset('/public/users/' . basename($user->image)) }}" alt="Image" style="width: 100px;">
        @endif
    </div>
</div>
  
<a href="{{ route('offices.index') }}" class="btn btn-secondary">العودة إلى القائمة</a>
@endsection
