@extends('layouts.app')
@section('title', 'فصول المدرسة')
@section('content')
<div class="container">
    <h2>الفصول الدراسية</h2>

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

    @if(session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ!',
                    text: '{{ session("error") }}',
                    showConfirmButton: true
                });
            });
        </script>
    @endif

    <!-- زر إضافة فصل جديد -->
    <button style="margin: 1% 0;"class="btn btn-primary" data-toggle="modal" data-target="#addClassModal" >إضافة فصل جديد</button>

    <!-- جدول الفصول -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>id</th>
                <th>اسم الفصل</th>
                <th>الصف</th>
                <th>المدرسة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $class)
            <tr>
                <td>{{ $class->id }}</td>
                <td>{{ $class->name }}</td>
                <td>{{ $class->grade }}</td>
                <td>{{ $class->school->name }}</td>
                <td>
                    <button class="btn btn-warning btn-sm editClassBtn"
                        data-id="{{ $class->id }}"
                        data-name="{{ $class->name }}"
                        data-grade="{{ $class->grade }}"
                        data-school-id="{{ $class->school_id }}"
                        data-toggle="modal" data-target="#editClassModal">تعديل</button>

                    <form action="{{ route('classes.destroy', $class->id) }}" method="POST" style="display:inline;">
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

<!-- نافذة إضافة فصل جديد -->
<div class="modal fade" id="addClassModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة فصل جديد</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('classes.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>اسم الفصل</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>الصف</label>
                        <select name="grade" class="form-control" required>
                            <option value="">اختر الصف</option>

                            <optgroup label="👶 المرحلة الابتدائية">
                                <option value="الصف الأول">الصف الأول</option>
                                <option value="الصف الثاني">الصف الثاني</option>
                                <option value="الصف الثالث">الصف الثالث</option>
                                <option value="الصف الرابع">الصف الرابع</option>
                                <option value="الصف الخامس">الصف الخامس</option>
                                <option value="الصف السادس">الصف السادس</option>
                            </optgroup>

                            <optgroup label="🧑‍🎓 المرحلة الإعدادية">
                                <option value="الصف السابع">الصف السابع</option>
                                <option value="الصف الثامن">الصف الثامن</option>
                                <option value="الصف التاسع">الصف التاسع</option>
                            </optgroup>

                            <optgroup label="🎓 المرحلة الثانوية">
                                <option value="الصف العاشر">الصف العاشر</option>
                                <option value="الصف الحادي عشر">الصف الحادي عشر</option>
                                <option value="الصف الثاني عشر">الصف الثاني عشر</option>
                            </optgroup>

                        </select>
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
                    <button type="submit" class="btn btn-success">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- نافذة تعديل الفصل -->
<div class="modal fade" id="editClassModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل الفصل</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editClassForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editClassId">
                    <div class="form-group">
                        <label>اسم الفصل</label>
                        <input type="text" name="name" id="editClassName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>الصف</label>
                        <select name="grade" class="form-control" required>
                            <option value="">اختر الصف</option>

                            <optgroup label="👶 المرحلة الابتدائية">
                                <option value="الصف الأول">الصف الأول</option>
                                <option value="الصف الثاني">الصف الثاني</option>
                                <option value="الصف الثالث">الصف الثالث</option>
                                <option value="الصف الرابع">الصف الرابع</option>
                                <option value="الصف الخامس">الصف الخامس</option>
                                <option value="الصف السادس">الصف السادس</option>
                            </optgroup>

                            <optgroup label="🧑‍🎓 المرحلة الإعدادية">
                                <option value="الصف السابع">الصف السابع</option>
                                <option value="الصف الثامن">الصف الثامن</option>
                                <option value="الصف التاسع">الصف التاسع</option>
                            </optgroup>

                            <optgroup label="🎓 المرحلة الثانوية">
                                <option value="الصف العاشر">الصف العاشر</option>
                                <option value="الصف الحادي عشر">الصف الحادي عشر</option>
                                <option value="الصف الثاني عشر">الصف الثاني عشر</option>
                            </optgroup>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>المدرسة</label>
                        <select name="school_id" id="editClassSchool" class="form-control" required>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">تحديث</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript لمعالجة بيانات التعديل -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".editClassBtn").forEach(button => {
            button.addEventListener("click", function () {
                let id = this.getAttribute("data-id");
                let name = this.getAttribute("data-name");
                let grade = this.getAttribute("data-grade");
                let schoolId = this.getAttribute("data-school-id");

                document.getElementById("editClassId").value = id;
                document.getElementById("editClassName").value = name;
                document.getElementById("editClassGrade").value = grade;
                document.getElementById("editClassSchool").value = schoolId;

                let form = document.getElementById("editClassForm");
                form.setAttribute("action", "/classes/" + id);
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
