/**
 * Created by luowen on 2017/3/9.
 */

(function () {
    "use strict";

    var E_change = $(".js-charge");
    var E_reset = $(".js-reset-passwd");

    E_change.on("click", function () {
        var that = $(this);
        var E_parent = that.parents(".js-change-box");
        var id = that.data("id");
        var V_change = $(".js-change-value", E_parent).val();

        httpUtils.put("/merchant/"+id, {days: V_change}).then(function (response) {
            alert(response.msg);
            if(response.code === 0) {
                window.location.reload();
            }
        });
    });

    E_reset.on("click", function () {
        var that = $(this);
        var id = that.data("id");

        httpUtils.put("/merchant/passwd/" + id).then(function(response) {
           alert(response.msg);
        });
    })


})();
