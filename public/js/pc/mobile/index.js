(function () {
    "use strict";

    var E_bannerUrl = $("#js-banner");
    var E_bannerImg = $("#js-banner-preview");
    var V_uploadUrl = 'http://s.51lianying.com/upload/?c=image&m=process_for_form&type=biz&item=magazine&base64=1&field=base64&is_ajax=1';

    E_bannerUrl.on("change", function () {
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
                    httpUtils.post("/mobile", {banner_url: data.url}).then(function (resp) {
                        alert(resp.msg);
                    });
                    E_bannerImg.attr("src", data.url);
                }
            })
        });
    });
})();