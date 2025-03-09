
<!--
* Project Name: Admin Dashboard
* Version: 0.01
* By: Nasr Aldin
* E-mail: nasr@nasralin.com
-->
<!DOCTYPE html>
<html lang="ar-sa" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','المنصة')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">
    <script src="{{ asset('assets/js/modernizr-2.8.3.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.1.1.min.js') }}"></script>

</head>

<body>
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="left">
                <!-- Single button -->
                <div class="btn-group navbar-top-links">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="glyphicon glyphicon-user"></i>
                    الخروج
                    <span class="glyphicon glyphicon-list"></span>
                </button>
                    <ul class="dropdown-menu">
                        <li>
                        </li>
                        <!-- <li role="separator" class="divider"></li>
                        <li><a href="#"></a></li>
                        <li><a href="#"></a></li>
                        <li><a href="#"></a></li>
                        <li role="separator" class="divider"></li> -->
                        <li >
                            <form id="logout-form"  action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit"class="ms-3" style="margin-left:20px;background-color: black; border: none; cursor: pointer;">
                                    <i class="glyphicon glyphicon-log-out"></i> تسجيل الخروج
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            </div>
            <div class="navbar-collapse collapse">
                <div class="right">
                    <!-- <a href="" class="navbar-brand">اسم التطبيق</a> -->
                </div>
                <ul class="nav navbar-nav right">
                    <li><a href="{{route('classes')}}">فصول المدرسة</a></li>
                    <li><a href="{{route('students.index')}}">الطلاب</a></li>
                    <li><a href="{{route('note.index')}}">الملاحظات</a></li>
                    <li><a href="{{route('attendance.index')}}">الغياب</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container wrapper clearfix">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 clearfix">
                <div class="sidebar clearfix">
                    <aside>
                        <div class="sidebar-search">
                            <div class="input-group">
                                <span class="input-group-btn">
                    <!-- <button class="btn btn-success" type="button"> -->
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                                <!-- <input type="text" class="form-control" placeholder="البحث..."> -->
                            </div>
                            <!-- /input-group -->
                        </div>
                        <div class="list-group clearfix">
                            <span class="list-group-item active">
                                القائمة الرئيسية
                            </span>
                            <a href="{{route('classes')}}" class="list-group-item">
                                <i class=""></i> فصول المدرسة
                            </a>
                            <a href="{{route('students.index')}}" class="list-group-item">
                                <i class=""></i> الطلاب
                            </a>
                            <a href="{{route('note.index')}}" class="list-group-item">
                                <i class=""></i> الملاحظات
                            </a>
                            <a href="{{route('attendance.index')}}" class="list-group-item">
                                <i class=""></i> الغياب
                            </a>
                        </div>

                        <!-- تذييل الصفحة -->
                        <footer style="background-color: #337ab7; color: white; text-align: center; padding: 20px 0; font-family: 'Arial', sans-serif;">
                            <p style="font-size: 18px; font-weight: bold;"> لاين سوفت لخدمات البرمجة وتصميم المواقع</p>
                            <p style="font-size: 14px;">جميع الحقوق محفوظة &copy; {{ date('Y') }}</p>
                        </footer>
                    </aside>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="jumbotron clearfix">
                    <div class="container">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
<!--
Copyright 2017 Nasr Aldin. All Rights Reserved.
Use of this source code is governed by an MIT-style license that
can be found in the LICENSE file at http://nasraldin.com/license
-->
