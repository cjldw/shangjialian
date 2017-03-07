@extends("backend.layouts.main")
@section("title", "通用活动")
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
                                <label for="password" class="control-label col-md-3">  设置背景音乐 </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="url" id="website" name="backgroundMusic"
                                           required="required" placeholder="http://www.51lianying.com/test.mp3" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12"> 适应行业 </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    @forelse($industries as $industry)
                                        <input type="radio" name="industryId" value="{{$industry['id']}}" class="checkbox checkbox-inline icheckbox_flat" /> {{$industry['name']}}
                                    @empty
                                        <p>暂时没有</p>
                                    @endforelse
                                </div>
                            </div>


                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone"> 活动区间 <span class="required">*</span>
                                </label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="datetime" name="act_start_time"  class="form-control col-md-2 col-xs-12" placeholder="开始时间" />
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="datetime" name="act_end_time" class="form-control col-md-2 col-xs-12" placeholder="结束时间"/>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> 活动主题(标题)介绍 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="number" type="text" name="title"
                                           class="optional form-control col-md-7 col-xs-12" placeholder="活动标题">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">活动内容介绍 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="textarea" required="required"
                                              name="description" class="form-control col-md-7 col-xs-12" placeholder="内容介绍"></textarea>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 参与规则 <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <input type="text" name="act_rule_decorate"
                                           class="optional form-control col-md-7 col-xs-12" placeholder="修饰. '分享', '收集', '派送'">
                                </div>
                                <div class="col-md-1 col-sm-6 col-xs-12">
                                    <input type="number" name="act_join_cnt"
                                           class="optional form-control col-md-7 col-xs-12" placeholder="数量">
                                </div>

                                <div class="col-md-1 col-sm-6 col-xs-12">
                                    <input type="text" name="act_join_cnt"
                                           class="optional form-control col-md-7 col-xs-12" placeholder="元宝,星星">
                                </div>

                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <p>奖品(下面填写的奖品名称)</p>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone"> 奖品信息(数量) <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="text" name="act_decorate"  class="form-control col-md-2 col-xs-12" placeholder="修饰. 如'最后','限量', '绝版" />
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="number" name="act_prize_cnt" class="form-control col-md-2 col-xs-12" placeholder="数量"/>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="text" name="act_prize_unit" class="form-control col-md-2 col-xs-12" placeholder="单位. 如'份', '个'"/>
                                </div>
                            </div>


                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 奖品名称 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="act_prize_unit" class="form-control col-md-2 col-xs-12" placeholder="奖品名称"/>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 奖品描述 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="textarea" required="required"
                                              name="act_prize_desc" class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>


                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 奖品图片(最多6张) <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="occupation" type="file" name="act_images"
                                           class="optional form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 主办方姓名 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="occupation" type="text" name="organizer_name"
                                           class="optional form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 主办方地址 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="occupation" type="text" name="organizer_address"
                                           class="optional form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 主办方电话 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="occupation" type="text" name="organizer_phone"
                                           class="optional form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">关于我们 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea required="required"
                                              name="about_us" class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">视频地址 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="occupation" type="text" name="video_url"
                                           class="optional form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">外链名称 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="occupation" type="text" name="link_name"
                                           class="optional form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">外链地址 <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="occupation" type="text" name="link_url"
                                           class="optional form-control col-md-7 col-xs-12">
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
