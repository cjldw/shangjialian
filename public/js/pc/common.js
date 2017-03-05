/**
 * Created by luowen on 2017/3/5.
 */

(function () {
    "use strict";

    var $ = $ || jQuery;
    var apiEndpoint = app.endpoint || "";

    if(typeof $ == "undefined") {
        throw new Error("No Jquery Plugin Loaded");
    }

    window.httpUtils = {
        get: function (url, data) {
            return this._execute("get", url, data);
        },
        post: function (url, data) {
            return this._execute("post", url, data);
        },
        put: function (url, data) {
            return this._execute("put", url, data);
        },
        delete: function (url, data) {
            return this._execute("delete", url, data);
        },
        _execute: function (method, url, data) {
            url = apiEndpoint + url;
            return $.ajax({
                url: url,
                type: method,
                data: data,
                dataType: "json"
            });
        }
    };
})(window, $);
