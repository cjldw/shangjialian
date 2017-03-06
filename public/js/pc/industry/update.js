/**
 * Created by luowen on 2017/3/6.
 */

(function () {
    "use strict";
    var E_newname = $("#js-industry-name");
    var E_submit = $(".js-submit");

    E_submit.on("click", function () {
        var that = $(this);
        var V_newname = E_newname.val() || "";
        var id = E_newname.data("id");

        if(V_newname != "") {
            httpUtils.put("/activity/industry/entity/" + id, {name: V_newname}).then(function (response) {
                alert(response.msg);
            });
        }

    });


})();
