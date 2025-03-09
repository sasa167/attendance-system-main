@extends('layouts.app')

@section('content')
<div class="container">
    <h2>تسجيل حساب جديد</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">كلمة المرور</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <!-- <div class="form-group">
            <label for="role">الدور</label>
            <select name="role" id="role" class="form-control">
                <option value="super_admin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="teacher">Teacher</option>
                <option value="parent">Parent</option>
            </select>
        </div> -->

        <button type="submit" class="btn btn-primary">تسجيل</button>
    </form>
</div>
@endsection
