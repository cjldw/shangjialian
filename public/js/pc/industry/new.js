/**
 * Created by luowen on 2017/3/6.
 */

(function () {
    "use strict";
    var E_form = $("#js-form");
    var E_submit = $(".js-submit")
    var E_name = $("#js-industry-name");

    E_submit.on("click", function () {
        var V_name = E_name.val() || "";
        if(V_name != "") {
            var V_data = {name: E_name.val()};
            httpUtils.post("/activity/industry/entity", V_data).then(function(resposne) {
                alert(resposne.msg);
            });
        }
    });

})();
