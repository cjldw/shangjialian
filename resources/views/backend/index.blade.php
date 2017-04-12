@extends("backend.layouts.main")
@section("title", "首页")
@section("content")
    <!-- page content -->
    <div class="right_col" role="main">
        <!-- top tiles -->
        <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> 总用户 </span>
                <div class="count">{{$total_user_cnt}}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>{{$total_user_delta_cnt}}</i> 本周新增长数</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> 商家数</span>
                <div class="count">{{$merchant_cnt}}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>{{$merchant_delta_cnt}}</i> 本周新增长数</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-clock-o"></i> 活动总数</span>
                <div class="count">{{$activity_cnt}}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>{{$activity_delta_cnt}}</i> 本周新增长数</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> 商家副本数</span>
                <div class="count green">{{$merchant_copy_cnt}}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>{{$merchant_copy_delta_cnt}}</i> 本周新增长数</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> 网名副本数</span>
                <div class="count">{{$net_people_copy_cnt}}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>{{$net_people_copy_cnt}}</i> 本周新增长数</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> 总浏览数 </span>
                <div class="count">{{$total_visit_cnt}}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>{{$total_visit_delta_cnt}}</i> 本周新增长数</span>
            </div>
        </div>
        <!-- /top tiles -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="dashboard_graph">

                    <div class="row x_title">
                        <div class="col-md-6">
                            <h3>网站流量数据    <small>统计延时2小时</small></h3>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            </div>
                        </div> -->
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="chart_plot_01" class="demo-placeholder"></div>
                    </div>
                    <!--<div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                        <div class="x_title">
                            <h2>Top Campaign Performance</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-6">
                            <div>
                                <p>Facebook Campaign</p>
                                <div class="">
                                    <div class="progress progress_sm" style="width: 76%;">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80"></div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p>Twitter Campaign</p>
                                <div class="">
                                    <div class="progress progress_sm" style="width: 76%;">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-6">
                            <div>
                                <p>Conventional Media</p>
                                <div class="">
                                    <div class="progress progress_sm" style="width: 76%;">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p>Bill boards</p>
                                <div class="">
                                    <div class="progress progress_sm" style="width: 76%;">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
        <br />
    </div>
    <!-- /page content -->
@endsection