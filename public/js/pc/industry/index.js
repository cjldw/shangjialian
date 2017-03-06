/**
 * Created by luowen on 2017/3/6.
 */

(function () {
    "use strict";
    var E_delete = $(".js-industry-delete");
    E_delete.on("click", function () {
        var that = $(this);
        var id = that.data("id");
        httpUtils.delete("/activity/industry/entity/" + id).then(function (response) {
            alert(response.msg);
            if(response.code === 0)
                window.location.reload();
        });
    })

})();
