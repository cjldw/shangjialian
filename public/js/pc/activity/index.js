/**
 * Created by luowen on 2017/3/8.
 */

(function () {
    "use strict";

    var E_recommend = $(".js-recommend");
    var E_offshelf = $(".js-offshelf");

    E_recommend.on("click", function () {
        var that = $(this);
        var allow = window.confirm("确认推荐?");
        if(allow) {
            var id = that.data("id");

            httpUtils.put("/activity/"+id).then(function (response) {
                alert(response.msg);
                if(response.code === 0) {
                    window.location.reload();
                }
            })
        }
    });

    E_offshelf.on("click", function () {
        var that = $(this);
        var allow = window.confirm("确认下架");
        if(allow) {
            var id = that.data("id");
            httpUtils.delete("/activity/"+id).then(function (response) {
                alert(response.msg);
                if(response.code === 0) {
                    window.location.reload();
                }
            })
        }
    });

})();
