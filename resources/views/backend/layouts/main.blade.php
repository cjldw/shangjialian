<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>商家恋 - @yield("title") | 我要联赢</title>

    @include("backend.layouts.commoncss");

    @yield('css')
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="/" class="site_title"><i class="fa fa-heart"></i> <span>商家恋平台</span></a>
                </div>


                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="/images/img.jpg" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>欢迎,</span>
                        <h2>{{Auth::user() -> name}}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->
                <br />
                @include("backend.layouts.sidebar")
            </div>
        </div>

        @include("backend.layouts.topNav")

        @yield("content")

        @include("backend.layouts.footer")
    </div>
</div>
<script> var app = {!!json_encode($be)!!}; </script>
@include("backend.layouts.commonjs");
@yield("js")

</body>
</html>
