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
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="搜索 ...">
                        <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                    </div>
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
                                    <tr class="{activityRo?item_cycle("even", "odd")} pointer">
                                    <td class=" ">{activityRo.title}</td>
                                    <td class=" ">{activityRo.title}</td>
                                    <td class=" ">{activityRo.bizmanCopyCnt}</td>
                                    <td class=" ">{activityRo.netizenCopyCnt}</td>
                                    <td class=" ">{activityRo.industryRO.name}</td>
                                    <td class="a-center ">
                                        <a href="/activity/general/{activityRo.id}" class="btn btn-info btn-xs">修改</a>
                                        <button class="btn btn-danger btn-xs js-putdown" data-id="{activityRo.id}">下架</button>
                                        <button class="btn btn-primary btn-xs js-recommend" data-id="{activityRo.id}">推荐</button>
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
