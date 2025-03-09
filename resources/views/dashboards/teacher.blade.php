@extends('layouts.app')

@section('content')
@section('title', 'لوحة تحكم المدرس')

<div class="container content flex-grow-1">
    <h2 class="mb-4 text-center">إضافة ملاحظة جديدة</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm p-4">
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf
            <input type="hidden" name="teacher_id" value="{{ auth()->user()->id }}">

            <div class="mb-3">
                <label for="student_id" style="margin: 2% 0" class="form-label fw-bold">اختر الطالب:</label>
                <select name="student_id" class="form-control form-select" required>
                    <option value="" disabled selected>اختر الطالب</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label fw-bold" style="margin: 2% 0">الملاحظة:</label>
                <textarea name="note" class="form-control" rows="4" placeholder="اكتب الملاحظة هنا..." required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="margin: 2% 0">إضافة الملاحظة</button>
        </form>
    </div>
</div>

{{-- <div class="container mt-5">
    <div class="row">
        @php
            $sections = [
                'الصفوف الدراسية' => $grades,
                'الفصول الدراسية' => $classes,
                'الطلاب' => $students,
                'الملاحظات' => $notes
            ];
        @endphp

        @foreach($sections as $title => $items)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">
                            <button class="btn btn-link text-white w-100 text-decoration-none" style="color: white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false">
                                {{ $title }}
                            </button>
                        </h5>
                    </div>
                    <div id="collapse{{ $loop->index }}" class="collapse">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @forelse($items as $item)
                                    <li class="list-group-item">
                                        @if($title == 'الملاحظات')
                                        @else
                                            {{ is_object($item) ? $item->name : $item }}
                                        @endif
                                    </li>
                                @empty
                                    <li class="list-group-item text-center">لا توجد بيانات</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div> --}}

@endsection
