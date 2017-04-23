/**
 * Created by luowen on 2017/3/8.
 */

(function () {
    "use strict";

    var E_recommend = $(".js-recommend");
    var E_offshelf = $(".js-offshelf");

    E_recommend.on("click", function () {
        var that = $(this);
        var mesg = that.data('recommend') ? '取消推荐' : '确认推荐';
        var allow = window.confirm(mesg + '?');
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
        var mesg = that.data("offshelf") ? '上架' : '下架';
        var allow = window.confirm("确认" + mesg + '?');
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
