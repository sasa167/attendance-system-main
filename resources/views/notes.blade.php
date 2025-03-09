@extends('layouts.app')

@section('title', 'الملاحظات')

@section('content')
<div class="container my-5">

    @if(session('message'))
        <div class="alert alert-info" style="font-size: 18px; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('message') }}
        </div>
    @endif

    @isset($students)
        @if($students->isEmpty())
            <p class="text-center" style="font-size: 18px;">لا يوجد أبناء مسجلين.</p>
        @else
            @foreach($students as $student)
                <div class="card student-card" style="box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); border-radius: 12px;margin-bottom: 2%">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center"
                    onclick="toggleDetails('{{ $student->id }}')" style="cursor: pointer; padding: 15px; font-size: 20px;">
                        <span>{{ $student->name }}</span>
                        <i id="icon-{{ $student->id }}" class="fas fa-chevron-down"></i>
                    </div>
                    <div class="card-body student-details" id="details-{{ $student->id }}">
                    <h5>📌 الحضور والغياب</h5>
                    @if(isset($attendanceData[$student->id]) && $attendanceData[$student->id]->count() > 0)
                        <ul>
                            @foreach($attendanceData[$student->id] as $attendance)
                                <li>
                                    {{ $attendance->date }} -
                                    <strong class="{{ $attendance->status == 'present' ? 'text-success' : ($attendance->status == 'late' ? 'text-warning' : 'text-danger') }}">
                                        @if ($attendance->status == 'present')
                                            حاضر
                                        @elseif ($attendance->status == 'late')
                                            متأخر
                                        @else
                                            غائب
                                        @endif
                                    </strong>

                                    <!-- 📝 عرض الملاحظات الخاصة بهذا الحضور -->
                                    @if (!empty($attendance->notes))
                                    <p class="mt-1 note-text" style="font-size: 14px;">
                                        📝 ملاحظة المدرس:
                                        <span class="full-text d-none">{{ $attendance->notes }}</span>
                                    </p>
                                @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>لا توجد بيانات عن الحضور لهذا الطالب.</p>
                    @endif
                </div>
                </div>
            @endforeach
        @endif
    @else
        <p class="text-center" style="font-size: 18px;">لا يوجد أبناء مسجلين.</p>
    @endisset
</div>

<style>
    .student-details {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-in-out, padding 0.3s ease-in-out;
        padding: 0 15px;
    }

    .student-details.open {
        max-height: 500px;
        padding: 15px;
    }
</style>

<script>
    function toggleDetails(studentId) {
        let details = document.getElementById('details-' + studentId);
        let icon = document.getElementById('icon-' + studentId);

        if (details.classList.contains('open')) {
            details.classList.remove('open');
            icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
        } else {
            details.classList.add('open');
            icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
        }
    }
</script>

@endsection
