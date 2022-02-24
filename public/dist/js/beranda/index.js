$(function () {
    "use strict";
    $("#btn-search").click(function (event) {
        event.preventDefault();
        const search = $("#search").val();
        const category_id = $("#category_id").val();
        window.location.href = `/beranda?search=${search}&category_id=${category_id}`;
    });
});
