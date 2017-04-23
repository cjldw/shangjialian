/**
 * Created by luowen on 2017/3/8.
 */
(function () {
    "use strict";
    var E_form = $("#js-activity-form");
    var E_submit = $(".js-submit");
    var V_actId = $("#js-act-id").val();

    var E_coverImg = $("#js-coverimg");
    var E_coverImgPreview = $(".js-coverimg");
    var E_coverImgVale = $("#js-coverimg-val");

    var E_actImg = $("#js-actimg");
    var E_actImgPreview = $(".js-actimg");
    var E_actImgValue = $("#js-actimg-val");

    var E_startTime = $("#js-start-time");
    var E_startTimeVal = $("#js-start-time-val")

    var E_endTime = $("#js-end-time");
    var E_endTimeVal = $("#js-end-time-val");


    var V_uploadUrl = 'http://s.51lianying.com/upload/?c=image&m=process_for_form&type=biz&item=magazine&base64=1&field=base64&is_ajax=1';

    E_startTime.daterangepicker({
        singleDatePicker: true,
        singleClasses: "picker_2"
    }, function(start, end, label) {
        E_startTimeVal.val($.format.date(start.toString(), "yyyy-MM-dd"));
    });

    E_endTime.daterangepicker({
        singleDatePicker: true,
        singleClasses: "picker_2"
    }, function(start, end, label) {
        E_endTimeVal.val($.format.date(end.toString(), "yyyy-MM-dd"));
    });

    E_coverImg.on("change", function () {
        lrz(this.files[0], { width: 640 }).then(function(rst) {
            var clearBase64 = rst.base64.substr(rst.base64.indexOf(',') + 1);
            $.ajax({
                url: V_uploadUrl,
                type: 'POST',
                data: {
                    image_data: clearBase64
                },
                success: function (resp) {
                    var data = JSON.parse(resp).data;
                    E_coverImgVale.val(data.url);
                    var preImg = new Image();
                    preImg.src = data.url;
                    E_coverImgPreview.append($(preImg));
                }
            })
        });
    });

    E_actImg.on("change", function () {

        lrz(this.files[0], { width: 640 }).then(function(rst) {
            var clearBase64 = rst.base64.substr(rst.base64.indexOf(',') + 1);
            $.ajax({
                url: V_uploadUrl,
                type: 'POST',
                data: {
                    image_data: clearBase64
                },
                success: function (resp) {
                    var data = JSON.parse(resp).data;
                    E_actImgValue.val(data.url);
                    var preImg = new Image();
                    preImg.src = data.url;

                    E_actImgPreview.append($(preImg));
                }
            })
        });
    });

    E_submit.on("click", function() {
        var V_data = E_form.serialize();
        httpUtils.put("/activity/common/"+V_actId, V_data).then(function (response) {
            alert(response.msg);
            window.location.href = "/admin/activity"
        });
    });


})();