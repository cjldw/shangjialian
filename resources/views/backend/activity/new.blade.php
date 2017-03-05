@extends("backend.layouts.main")
@section("title", "活动模版添加")
@section("content")
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>新建通用活动</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">

                            <form id="js-activity-form" class="form-horizontal form-label-left" novalidate method="post">

                                <span class="section">活动信息</span>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> 活动封面图 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                               data-validate-words="2" name="coverImg" placeholder="upload" required="required" type="file">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"> 活动内页图片 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="email" type="file" name="bannerImg" class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"> 活动详情配色 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="email2" type="color" name="colorPlate"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> 活动主题介绍 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="number" type="text" name="title"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">活动内容介绍 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="textarea" required="required"
                                              name="description" class="form-control col-md-7 col-xs-12"></textarea>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 收集关键字 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="occupation" type="text" name="keyword"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label for="password" class="control-label col-md-3">  设置背景音乐 </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="url" id="website" name="backgroundMusic"
                                               required="required" placeholder="http://www.51lianying.com/test.mp3" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12"> 适应行业 </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <#list industries as industry>
                                            <input type="radio" name="industryId" value="${industry.id}" class="checkbox checkbox-inline icheckbox_flat" /> ${industry.name}
                                            <#else>
                                                <p>暂时没有</p>
                                        </#list>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone"> 基本功能 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="checkbox" class="checkbox checkbox-inline icheckbox_flat" /> 时间
                                        <input type="checkbox" class="checkbox checkbox-inline icheckbox_flat" /> 规则
                                        <input type="checkbox" class="checkbox checkbox-inline icheckbox_flat" /> 简介
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="button" class="btn btn-primary">取消</button>
                                        <button type="submit" class="btn btn-success js-submit">保存</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
