@extends('layouts.app')

@section('content')
   
</header>

@if(session('welcomeMessage'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <!-- <strong class="font-bold">{{ session('welcomeMessage') }}</strong> -->
    </div>
@endif

<div class="container my-4">
    <div class="row justify-content-center">
        <!-- خانة عدد المدارس -->
        <div class="col-md-3">
            <div class="card" style="min-height: 150px;">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link w-100 text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            عدد المدارس
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <p class="text-xl text-center">{{ $schoolsCount ?? 'لم يتم تحميل البيانات بعد' }}</p>
                    </div>
                </div>
            </div>
        </div>

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
</div>

@endsection
