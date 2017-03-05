@extends("backend.layouts.main");
@section("title", "行业管理")
@section("content")
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>活动行业管理</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <form action="{{$be['endpoint']}}/activity/industry/entity" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="name" value="{name!}" placeholder="搜索...">
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
                    <a href="{{$be['endpoint']}}/activity/industry/entity" class="btn btn-primary btn-sm">添加行业</a>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                            <tr class="headings">
                                <th class="column-title" width="10%">ID </th>
                                <th class="column-title" >名称 </th>
                                <th class="column-title">创建时间 </th>
                                <th class="column-title no-link last" width="20%"><span class="nobr">操作</span></th>
                            </tr>
                            </thead>

                            <tbody>
                                <tr class="{industry?item_cycle("even", "odd")} pointer">
                                <td class=" ">{industry.id}</td>
                                <td class=" ">{industry.name}</td>
                                <td class=" ">{industry.createdAt?datetime} </td>
                                <td class=" ">
                                    <a href="/activity/industry/update/{industry.id}" class="btn btn-default btn-xs">修改</a>
                                    <button class="btn btn-danger btn-xs js-industry-delete" data-id="{industry.id}">删除</button>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection
