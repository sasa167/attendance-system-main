@extends('layouts.app')
@section('title', 'الطلاب')
@section('content')
<div class="container">
    <h2 class="mb-4">قائمة الطلاب</h2>

    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'نجاح!',
                    text: '{{ session("success") }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
    @endif

    <button class="btn btn-primary" style="margin: 1% 0" data-toggle="modal" data-target="#addStudentModal">إضافة طالب جديد</button>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Id</th>
                <th>اسم الطالب</th>
                <th>المدرسة</th>
                <th>الفصل</th>
                <th>ولي الأمر</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->school ? $student->school->name : 'غير متوفر' }}</td>
                <td>{{ $student->schoolClass ? $student->schoolClass->name : 'غير متوفر' }}</td>
                <td>{{ $student->parent ? $student->parent->name : 'غير متوفر' }}</td>
                <td style="display: flex; gap: 5px;">
                    <button class="btn btn-warning btn-sm editStudentBtn"
                        data-id="{{ $student->id }}"
                        data-name="{{ $student->name }}"
                        data-school="{{ $student->school_id }}"
                        data-class="{{ $student->class_id }}"
                        data-parent="{{ $student->parent_id }}"
                        data-toggle="modal" data-target="#editStudentModal">تعديل</button>

                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<!-- Modal لإضافة طالب -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة طالب جديد</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('students.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>اسم الطالب</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>المدرسة</label>
                        <select name="school_id" class="form-control" required>
                            <option value="">اختر المدرسة</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>ولي الأمر</label>
                        <select name="parent_id" class="form-control" required>
                            <option value="">اختر ولي الأمر</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>الفصل</label>
                        <select name="class_id" id="classSelect" class="form-control" required>
                            <option value="">اختر الفصل</option>
                            @foreach($schoolClasses as $class)
                                <option value="{{ $class->id }}" data-school="{{ $class->school_id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal لتعديل الطالب -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل بيانات الطالب</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editStudentId">

                    <div class="form-group">
                        <label>اسم الطالب</label>
                        <input type="text" name="name" id="editStudentName" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>المدرسة</label>
                        <select name="school_id" id="editStudentSchool" class="form-control" required>
                            <option value="">اختر المدرسة</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>ولي الأمر</label>
                        <select name="parent_id" id="editStudentParent" class="form-control" required>
                            <option value="">اختر ولي الأمر</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>الفصل</label>
                        <select name="class_id" id="editStudentClass" class="form-control" required>
                            <option value="">اختر الفصل</option>
                            @foreach($schoolClasses as $class)
                                <option value="{{ $class->id }}" data-school="{{ $class->school_id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">تحديث</button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".editStudentBtn").forEach(button => {
        button.addEventListener("click", function () {
            let studentId = this.getAttribute("data-id");
            let studentName = this.getAttribute("data-name");
            let studentSchool = this.getAttribute("data-school");
            let studentClass = this.getAttribute("data-class");
            let studentParent = this.getAttribute("data-parent");

            document.getElementById("editStudentId").value = studentId;
            document.getElementById("editStudentName").value = studentName;
            document.getElementById("editStudentSchool").value = studentSchool;
            document.getElementById("editStudentClass").value = studentClass;
            document.getElementById("editStudentParent").value = studentParent;

            document.getElementById("editStudentForm").setAttribute("action", `/students/${studentId}`);
        });
    });
});

</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
