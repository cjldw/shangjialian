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
                            <div class="item form-group">
                                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="name"> 首页广告图 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-2 col-xs-12">
                                    <input type="file"  class="" id="js-banner" accept="image/*" />
                                </div>
                            </div>

                            @if($bannerUrl != '')
                            <br/> <br/> <br/>
                            <div class="col-md-12 block">
                                <img id="js-banner-preview" src="{{$bannerUrl}}">
                            </div>
                            @endif
                            <!---
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
                            -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection


@section("js")
<script src="/assets/lrz/lrz.bundle.js"></script>
<script src="/assets/dropzone/dist/dropzone.js"></script>
<script src="/js/pc/mobile/index.js"></script>
@endsection
