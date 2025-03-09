@extends('layouts.app')

@section('title', 'لوحة تحكم ولي الأمر')  <!-- تحديد عنوان الصفحة هنا -->

@section('content')
<!-- Header with background image -->
<header style="background-color: #007bff; padding: 30px 0; text-align: center; color: white; background-image: url('https://via.placeholder.com/1200x400'); background-size: cover; background-position: center; position: relative;">
    <!-- زر تسجيل الخروج فوق على الشمال -->
    <form action="{{ route('logout') }}" method="POST" style="position: absolute; top: 20px; left: 20px;">
        @csrf
        <button type="submit" class="btn btn-light" style="font-size: 16px; font-weight: bold; border-radius: 5px; padding: 8px 15px;">
            تسجيل الخروج 🚪
        </button>
    </form>

    <h1 style="font-size: 28px; font-family: 'Arial', sans-serif; font-weight: bold; margin-bottom: 10px;">لوحة تحكم ولي الأمر</h1>
    <p style="font-size: 18px; font-family: 'Arial', sans-serif; font-weight: normal;">أفضل تجربة تعليمية لأولياء الأمور</p>
</header>


<div class="container">
    <h2 class="mb-4">ملاحظات المعلمين</h2>

    {{-- @if($notes->isEmpty())
        <p>لا توجد ملاحظات بعد.</p>
    @else
        <ul class="list-group">
            @foreach($notes as $note)
                <li class="list-group-item">
                    <strong>{{ $note->date }}:</strong> {{ $note->note }}
                </li>
            @endforeach
        </ul>
    @endif --}}
</div>

<div class="container my-5">
    <h2 class="text-center" style="font-family: 'Roboto', sans-serif; color: #007bff; margin-bottom: 20px; font-size: 28px;">مرحبًا بك في لوحة التحكم</h2>

    <!-- عرض رسالة إذا كانت موجودة -->
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
                <div class="card my-3" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); border-radius: 10px;">
                    <div class="card-header" style="background-color: #f8f9fa;">
                        <h4>الطالب: {{ $student->name }}</h4>
                    </div>
                    <div class="card-body">
                        <h5>📌 الحضور والغياب</h5>
                        <!-- فحص إذا كان يوجد بيانات للحضور -->
                        @if(isset($attendanceData[$student->id]) && $attendanceData[$student->id]->count() > 0)
                            <ul>
                                @foreach($attendanceData[$student->id] as $attendance)
                                    <li>{{ $attendance->date }} -
                                        <strong class="{{ $attendance->status == 'Present' ? 'text-success' : 'text-danger' }}">
                                            {{ $attendance->status == 'Present' ? 'حاضر' : 'غائب' }}
                                        </strong>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>لا توجد بيانات عن الحضور لهذا الطالب.</p>
                        @endif

                        <h5>📝 ملاحظات المدرسين</h5>
                        <!-- فحص إذا كانت توجد ملاحظات -->
                        @if(isset($notesData[$student->id]) && $notesData[$student->id]->count() > 0)
                            <ul>
                                @foreach($notesData[$student->id] as $note)
                                    <li>{{ $note->content }} <small class="text-muted">({{ $note->created_at->format('Y-m-d') }})</small></li>
                                @endforeach
                            </ul>
                        @else
                            <p>لا توجد ملاحظات عن هذا الطالب.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    @else
        <p class="text-center" style="font-size: 18px;">لا يوجد أبناء مسجلين.</p>
    @endisset
</div>

<!-- تذييل الصفحة -->
<footer style="background-color: #333; color: white; text-align: center; padding: 20px 0; font-family: 'Arial', sans-serif; margin-top: 40px;">
    <p style="font-size: 18px; font-weight: bold;"> لاين سوفت لخدمات البرمجة وتصميم المواقع</p>
    <p style="font-size: 14px;">جميع الحقوق محفوظة &copy; {{ date('Y') }}</p>
</footer>
@endsection
