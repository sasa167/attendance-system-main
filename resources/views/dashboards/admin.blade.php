@extends('layouts.app')

@section('content')
@section('title', 'لوحة تحكم الادمن')

<div class="row" style="display: flex; justify-content: space-around; gap: 20px; flex-wrap: wrap;">
    <!-- خانة عدد المعلمين -->
    <div class="col-md-3">
        <div class="card" style="min-height: 150px;">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link w-100 text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        عدد المعلمين
                    </button>
                </h2>
            </div>
                <div class="card-body">
                    <p class="text-xl text-center">{{ $teachersCount ?? 'لم يتم تحميل البيانات بعد' }}</p>
                </div>
        </div>
    </div>

    <!-- خانة عدد الطلاب -->
    <div class="col-md-3">
        <div class="card" style="min-height: 150px;">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link w-100 text-left" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        عدد الطلاب
                    </button>
                </h2>
            </div>
                <div class="card-body">
                    <p class="text-xl text-center">{{ $studentsCount ?? 'لم يتم تحميل البيانات بعد' }}</p>
                </div>
        </div>
    </div>

    <!-- خانة عدد أولياء الأمور -->
    <div class="col-md-3">
        <div class="card" style="min-height: 150px;">
            <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                    <button class="btn btn-link w-100 text-left" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        عدد أولياء الأمور
                    </button>
                </h2>
            </div>
                <div class="card-body">
                    <p class="text-xl text-center">{{ $parentsCount ?? 'لم يتم تحميل البيانات بعد' }}</p>
                </div>
        </div>
    </div>
</div>

<!-- محتوى الداشبورد -->
<!-- <h2 class="text-2xl font-bold mb-4">مرحبًا بك في لوحة تحكم المدرسة: {{ $school->name }}</h2> -->


@endsection
