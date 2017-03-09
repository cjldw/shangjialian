@extends("backend.layouts.main")
@section("title", "商家管理")
@section("content")
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3> 商家管理 <small></small></h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <form action="{{$be['endpoint']}}/merchant" method="get">
                            <div class="input-group">
                                <input type="text" name="like" class="form-control" placeholder="搜索 ..." value="{{$like}}">
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
                            <h2>商家</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title"> 手机号 </th>
                                        <th class="column-title"> 姓名 </th>
                                        <th class="column-title"> 登录次数 </th>
                                        <th class="column-title"> 状态(剩余) </th>
                                        <th class="column-title no-link last"><span class="nobr">充值</span></th>
                                        <th> 操作 </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($data as $merchant)
                                        <tr class=" {{$loop -> index / 2 ? 'even' : 'odd'}} pointer">
                                            <td class=" ">{{$merchant['phone']}}</td>
                                            <td class=" ">{{$merchant['name']}}</td>
                                            <td class=" ">{{$merchant['login_cnt']}} </td>
                                            <td class=" ">{{$merchant['expired_days']}} </td>
                                            <td class="js-change-box">
                                                <div class="col-md-4">
                                                    <input type="number" class="form-control input-sm js-change-value" value="0" placeholder="输入天数">
                                                </div>
                                                <div class="col-md-4">
                                                    <button class="btn btn-primary btn-sm js-charge"  data-id="{{$merchant['id']}}">充值</button>
                                                </div>
                                            </td>
                                            <td class=" ">
                                                <button class="btn btn-danger btn-sm js-reset-passwd" data-id="{{$merchant['id']}}">
                                                    重置密码
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">暂无数据!</td>
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
    <script src="/js/pc/merchant/index.js"></script>
@endsection
