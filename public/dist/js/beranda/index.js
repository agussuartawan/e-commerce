$(function () {
    "use strict";
    $("body").on("click", "#btn-search", function (event) {
        event.preventDefault();
        search();
    });

    $('input[type="search"').unbind();
    $('input[type="search"').bind("keyup", function (e) {
        if (e.keyCode == 13) {
            search();
        }
    });

    search = () => {
        const search = $("#search").val();
        const category_id = $("#category_id").val();
        window.location.href = `/beranda?search=${search}&category_id=${category_id}`;
    };
});
