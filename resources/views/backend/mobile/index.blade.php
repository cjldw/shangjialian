@extends("backend.layouts.main")
@section("title", "首页搭建")
@section("content")
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h3> 手机端首页搭建 </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form class="form-horizontal form-label-left" novalidate>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> 首页广告图 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="banner_img" class="form-control col-md-7 col-xs-12"  placeholder="http://www.51lianying.com/banner.jpg" required="required" type="file">
                                    </div>
                                </div>
                            </form>

                            <br/> <br/>
                            <div class="item form-group">
                                @forelse($acts as $act)
                                <div class="col-md-4">
                                    <div class="thumbnail">
                                        <div class="image view view-first">
                                            <img style="width: 100%; display: block;" src="images/media.jpg" alt="image">
                                            <div class="mask">
                                                <p>{{$act['title']}}</p>
                                                <div class="tools tools-bottom">
                                                    <a href=""></a>
                                                    <a href=""></a>
                                                    <a href=""></a>
                                                    <!--
                                                        <a href="#"><i class="fa fa-link"></i></a>
                                                        <a href="#"><i class="fa fa-pencil"></i></a>
                                                        <a href="#"><i class="fa fa-times"></i></a>
                                                        -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="caption">
                                            {{$act['description']}}</p>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                    <a href="{{$be['endpoint']}}/activity" class="btn btn-primary btn-sm">去推荐几个过来吧</a>
                                @endforelse
                            </div>

                            @if(count($acts) > 0)
                            <div class="item form-group">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-large">修改推荐</button>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
