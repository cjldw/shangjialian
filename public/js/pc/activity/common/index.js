/**
 * Created by luowen on 2017/3/8.
 */
(function () {
    "use strict";
    var E_form = $("#js-activity-form");
    var E_submit = $(".js-submit");

    E_submit.on("click", function() {
        var V_data = E_form.serialize();
        httpUtils.post("/activity/common", V_data).then(function (response) {
            alert(response.msg);
        });
    });

})();