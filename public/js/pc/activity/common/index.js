/**
 * Created by luowen on 2017/3/8.
 */
(function () {
    "use strict";
    var E_form = $("#js-activity-form");
    var E_submit = $(".js-submit");
    var E_upload = $(".js-cover-img-upload");
    var V_upload = "http://s.51lianying.com/upload/?c=image&m=process_for_form&type=trade&item=product&field=f_image&nodomain=1"
    //var E_dropzone = new Dropzone("#js-cover-img", {url: V_upload});

    E_submit.on("click", function() {
        var V_data = E_form.serialize();
        httpUtils.post("/activity/common", V_data).then(function (response) {
            alert(response.msg);
        });
    });

    E_upload.dropzone({url: V_upload});

})();