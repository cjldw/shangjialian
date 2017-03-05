/**
 * Created by luowen on 2017/3/5.
 */

(function () {
    "use strict";

    var E_submit = $(".js-submit");
    var E_form = $(".js-form");

    E_submit.on("click", function () {
        var that = $(this);
        var V_data = E_form.serialize();
        httpUtils.post("/login", V_data).then(function (response) {
            if(response.code === 0) {
                window.location.href = app.endpoint + "/";
            }
            alert(response.msg);
        });
    });


})();

