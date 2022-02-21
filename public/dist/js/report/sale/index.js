$(function () {
    "use strict";
    $(document).ready(function () {
        $("#dateFilter").daterangepicker({
            locale: {
                format: "DD-MM-YYYY",
                separator: " / ",
            },
        });
    });
});
