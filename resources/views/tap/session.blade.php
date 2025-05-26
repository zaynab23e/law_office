@extends('layout')

@section('main')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                    <h4 class="mb-0">📋 الجلسات</h4>
                    <a href="{{ route('offices.session.create') }}" class="btn btn-light btn-sm">➕ إضافة جلسة</a>
                </div>
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($sessions->isEmpty())
                        <div class="p-4 text-center text-muted">لا توجد جلسات مسجلة حاليًا.</div>
                    @else
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach ($sessions->groupBy('case_id') as $case_id => $caseSessions)
                                <div class="col">
                                    <div class="card h-100 shadow-sm hover-shadow" data-bs-toggle="modal" data-bs-target="#sessionsModal-{{ $case_id }}" style="cursor: pointer;">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-primary fw-bold">
                                                {{ $caseSessions->first()->issue->title ?? 'قضية رقم ' . $case_id }}
                                            </h5>
                                            <p class="card-text">
                                                <span class="badge bg-secondary">رقم القضية: {{ $case_id }}</span>
                                            </p>
                                            <p class="card-text text-muted">
                                                عدد الجلسات: {{ $caseSessions->count() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for displaying sessions -->
                                <div class="modal fade" id="sessionsModal-{{ $case_id }}" tabindex="-1" aria-labelledby="sessionsModalLabel-{{ $case_id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sessionsModalLabel-{{ $case_id }}">
                                                    جلسات القضية: {{ $caseSessions->first()->issue->title ?? 'قضية رقم ' . $case_id }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover align-middle text-center">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>العنوان</th>
                                                                <th>التاريخ</th>
                                                                <th>الوصف</th>
                                                                <th>إجراءات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($caseSessions as $session)
                                                                <tr>
                                                                    <td>{{ $session->id }}</td>
                                                                    <td class="text-primary fw-bold">{{ $session->title }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($session->date)->format('Y-m-d') }}</td>
                                                                    <td>{{ $session->description ?? '—' }}</td>
                                                                    <td>
                                                                        <a href="{{ route('offices.session.show', $session->id) }}" class="btn btn-sm btn-outline-info me-1" title="عرض">👁️</a>
                                                                        <a href="{{ route('offices.session.edit', $session->id) }}" class="btn btn-sm btn-outline-warning me-1" title="تعديل">✏️</a>
                                                                        <form method="POST" action="{{ route('offices.session.delete', $session->id) }}" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف الجلسة؟')" title="حذف">🗑️</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ route('offices.session.show', $caseSessions->first()->id) }}" class="btn btn-info">عرض جميع التفاصيل</a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: box-shadow 0.3s ease-in-out;
    }
</style>
@endsection