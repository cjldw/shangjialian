@extends("backend.layouts.main")
@section("title", "修改通用活动")
@section("css")
    <link href="/assets/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
@endsection
@section("content")
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>修改通用活动</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <form id="js-activity-form" onsubmit="return false;" class="form-horizontal form-label-left" novalidate >
                                <span class="section">活动信息</span>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> 活动封面图 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" id="js-coverimg" accept="image/*" />
                                        <input type="hidden" name="cover_img" id="js-coverimg-val" value="{{$actRepo['cover_img']}}">
                                        <div class="js-coverimg">
                                            <img src="{{$actRepo['cover_img']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"> 活动内页图片 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" id="js-actimg" accept="image/*" />
                                        <input type="hidden" name="banner_img" id="js-actimg-val" value="{{$actRepo['banner_img']}}">
                                        <div class="js-actimg">
                                            <img src="{{$actRepo['banner_img']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"> 活动详情配色 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="email2" type="color" name="color_plate" value="{{$actRepo['color_plate']}}"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label for="password" class="control-label col-md-3">  设置背景音乐 </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="url" id="website" name="background_music" value="{{$actRepo['background_music']}}"
                                               required="required" placeholder="http://www.51lianying.com/test.mp3" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12"> 适应行业 </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        @forelse($industries as $industry)
                                            @if($industry['id'] == $actRepo['industry_id'])
                                                <input type="radio" checked name="industry_id" value="{{$industry['id']}}" class="checkbox checkbox-inline icheckbox_flat" /> {{$industry['name']}}
                                            @else
                                                <input type="radio" name="industry_id" value="{{$industry['id']}}" class="checkbox checkbox-inline icheckbox_flat" /> {{$industry['name']}}
                                            @endif
                                        @empty
                                            <p>暂时没有</p>
                                        @endforelse
                                    </div>
                                </div>


                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone"> 活动区间 <span class="required">*</span> </label>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_2 xdisplay">
                                            <div class="calendar left single" style="display: block;">
                                                <div class="daterangepicker_input">
                                                    <input class="input-mini form-control active" type="text" id="js-start-time-val" name="act_start_time" style="display: none;">
                                                    <i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i>
                                                    <div class="calendar-time" style="display: none;">
                                                        <div></div>
                                                        <i class="fa fa-clock-o glyphicon glyphicon-time"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                                        <input type="text" class="form-control has-feedback-left" id="js-start-time" placeholder="First Name" aria-describedby="inputSuccess2Status2">
                                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                        <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <!-- <div class="col-md-3 col-sm-3 col-xs-12">
                                        <input type="datetime" name="act_start_time"  class="form-control col-md-2 col-xs-12" placeholder="开始时间" />
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <input type="datetime" name="act_end_time" class="form-control col-md-2 col-xs-12" placeholder="结束时间"/>
                                    </div> -->
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_2 xdisplay">
                                            <div class="calendar left single" style="display: block;">
                                                <div class="daterangepicker_input">
                                                    <input class="input-mini form-control active" type="text" id="js-end-time-val" name="act_end_time" value="" style="display: none;">
                                                    <i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i>
                                                    <div class="calendar-time" style="display: none;">
                                                        <div></div>
                                                        <i class="fa fa-clock-o glyphicon glyphicon-time"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                                        <input type="text" class="form-control has-feedback-left" id="js-end-time" placeholder="First Name" aria-describedby="inputSuccess2Status2">
                                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                        <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>


                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> 活动主题(标题)介绍 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="number" type="text" name="title" value="{{$actRepo['title']}}"
                                               class="optional form-control col-md-7 col-xs-12" placeholder="活动标题">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">活动内容介绍 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="textarea" required="required"
                                              name="description" class="form-control col-md-7 col-xs-12" placeholder="内容介绍">{{$actRepo['description']}}</textarea>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 参与规则 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                        <input type="text" name="act_rule_decorate" value="{{$actRepo['act_rule_decorate']}}"
                                               class="optional form-control col-md-7 col-xs-12" placeholder="修饰. '分享', '收集', '派送'">
                                    </div>
                                    <div class="col-md-1 col-sm-6 col-xs-12">
                                        <input type="number" name="act_rule_cnt" value="{{$actRepo['act_rule_cnt']}}"
                                               class="optional form-control col-md-7 col-xs-12" placeholder="数量">
                                    </div>

                                    <div class="col-md-1 col-sm-6 col-xs-12">
                                        <input type="text" name="act_rule_keywords" value="{{$actRepo['act_rule_keywords']}}"
                                               class="optional form-control col-md-7 col-xs-12" placeholder="元宝,星星">
                                    </div>

                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                        <p>奖品(下面填写的奖品名称)</p>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 规则描述 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea id="textarea" required="required" placeholder="" name="act_rule_desc" class="form-control col-md-7 col-xs-12">{{$actRepo['act_rule_desc']}}</textarea>
                                        <p>例如</p>
                                        <p> 1. 参与活动前，请详细阅读活动规则及相关条款。凡参与本次活动，则视为同意活动内容及免责声明条款。 </p>
                                        <p> 2. 如遇不可抗力因素，本次活动因故无法进行时，活动主办方在法律允许的范围内有权决定取消、终止、修改或暂停本活动。 </p>
                                        <p> 3. 请中奖用户按照活动提示提供正确的联系方式，若不正确导致无法收到奖品，活动主办方不予负责。 </p>
                                        <p> 4. 除质量问题外，本活动产品概不退货。 </p>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone"> 奖品信息(数量) <span class="required">*</span>
                                    </label>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input type="text" name="act_prize_decorate" value="{{$actRepo['act_prize_decrate']}}"  class="form-control col-md-2 col-xs-12" placeholder="修饰. 如'最后','限量', '绝版" />
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input type="number" name="act_prize_cnt" value="{{$actRepo['act_prize_cnt']}}" class="form-control col-md-2 col-xs-12" placeholder="数量"/>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input type="text" name="act_prize_unit" value="{{$actRepo['act_prize_unit']}}" class="form-control col-md-2 col-xs-12" placeholder="单位. 如'份', '个'"/>
                                    </div>
                                </div>


                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 奖品名称 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="act_prize_name" value="{{$actRepo['act_prize_name']}}" class="form-control col-md-2 col-xs-12" placeholder="奖品名称"/>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 奖品描述 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="textarea" required="required" name="act_prize_desc" class="form-control col-md-7 col-xs-12">{{$actRepo['act_prize_desc']}}</textarea>
                                    </div>
                                </div>
                                <!-- <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 奖品图片(最多6张) <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="occupation" type="file" name="act_images"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div> -->

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 主办方姓名 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="occupation" type="text" name="organizer_name" value="{{$actRepo['organizer_name']}}"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 主办方地址 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="occupation" type="text" name="organizer_address" value="{{$actRepo['organizer_address']}}"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"> 主办方电话 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="occupation" type="text" name="organizer_phone" value="{{$actRepo['organizer_phone']}}"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">关于我们 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea required="required" name="about_us" class="form-control col-md-7 col-xs-12">{{$actRepo['about_us']}}</textarea>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">视频地址 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="occupation" type="text" name="video_url" value="{{$actRepo['video_url']}}"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">外链名称 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="occupation" type="text" name="link_name" value="{{$actRepo['link_name']}}"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">外链地址 <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="occupation" type="text" name="link_url" value="{{$actRepo['link_url']}}"
                                               class="optional form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" id="js-act-id" value="{{$actRepo['id']}}">
                                        {{--<button type="button" class="btn btn-primary">取消</button>--}}
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

@section("js")
    {{--<script src="/assets/dropzone/dist/min/dropzone.min.js"></script>--}}
    <script src="/assets/lrz/lrz.bundle.js"></script>
    <script src="/assets/dropzone/dist/dropzone.js"></script>
    <script src="/assets/dateformat/date-format.min.js"></script>
    <script src="/js/pc/activity/common/modify.js"></script>
@endsection

