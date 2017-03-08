@extends("backend.layouts.main")
@section("title", "活动管理")
@section("content")
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>活动模版管理 <small></small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <form action="{{$be['endpoint']}}/activity" method="get">
                        <div class="input-group">
                            <input type="text" name="title" class="form-control" placeholder="搜索 ..." value="{{$title}}">
                            <span class="input-group-btn">
                          <button class="btn btn-default" type="button">Go!</button>
                        </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>模版</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                <tr class="headings">
                                    <th class="column-title"> 活动名称 </th>
                                    <th class="column-title"> 创建时间 </th>
                                    <th class="column-title"> 商家使用数 </th>
                                    <th class="column-title"> 网民使用数 </th>
                                    <th class="column-title no-link last"><span class="nobr">适应行业</span></th>
                                    <th> 操作 </th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($data as $activity)
                                    <tr class=" {{$loop -> index / 2 ? 'even' : 'odd'}} pointer">
                                        <td class=" ">{{$activity['title']}}</td>
                                        <td class=" ">{{$activity['created_at']}}</td>
                                        <td class=" ">{{$activity['bizman_copy_cnt']}} </td>
                                        <td class=" ">{{$activity['netizen_copy_cnt']}} </td>
                                        <td class=" ">{{$activity['industry']['name']}} </td>
                                        <td class=" ">
                                            <a href="{{$be['endpoint']}}/activity/{{$activity['id']}}" class="btn btn-info btn-xs">修改</a>
                                            <button class="btn {{$activity['is_offshelf'] ? 'btn-default' : 'btn-danger'}} btn-xs js-offshelf" data-id="{{$activity['id']}}">
                                                {{$activity['is_offshelf'] ? '上架' : '下架'}}
                                            </button>
                                            <button class="btn {{$activity['is_recommend'] ? 'btn-danger' : 'btn-primary'}} btn-xs js-recommend" data-id="{{$activity['id']}}">
                                                {{$activity['is_recommend'] ? '取消推荐' : '推荐'}}
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">暂无数据!</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {!! $pageHtml  !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection

@section("js")
    <script src="/js/pc/activity/index.js"></script>
@endsection
