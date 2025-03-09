@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">تسجيل الحضور</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('attendance.store') }}">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>حالة الحضور</th>
                    <th>ملاحظات</th> <!-- إضافة عنوان للملاحظات -->
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>
                        <select name="attendance[{{ $student->id }}]" class="form-control">
                            <option value="حاضر">حاضر</option>
                            <option value="غائب">غائب</option>
                            <option value="متأخر">متأخر</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="notes[{{ $student->id }}]" class="form-control" placeholder="أدخل ملاحظة">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">حفظ الحضور</button>
    </form>
</div>
@endsection
