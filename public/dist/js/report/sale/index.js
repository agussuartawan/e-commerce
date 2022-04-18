$(function () {
    "use strict";
    $(document).ready(function () {
        $("#dateFilter").daterangepicker({
            locale: {
                format: "DD-MM-YYYY",
                separator: " s/d ",
            },
        });
    });

    $("#btn-search").click(function () {
        const search = $("#dateFilter").val();
        loadData(search);
    });

    $("body").on("click", "#btn-download", function (event) {
        event.preventDefault();
        const url = $(this).attr("href");
        const search = $("#dateFilter").val();
        window.open(url + "?search=" + search, "_blanc");
    });

    $("body").on("click", "#btn-print", function (event) {
        event.preventDefault();
        const url = $(this).attr("href");
        const search = $("#dateFilter").val();
        window.open(url + "?search=" + search, "_blanc");
    });
});

loadData = (search) => {
    $.ajax({
        url: "/report/sales/get-lists?search=" + search,
        type: "GET",
        dataType: "html",
        beforeSend: function () {
            $("#preloader").fadeIn();
        },
        complete: function () {
            $("#preloader").fadeOut();
        },
        success: function (response) {
            const btnAction = `<a href="/report/sales-download" target="_blanc" class="btn btn-danger mr-2" id="btn-download">
                                    <i class="fas fa-download mr-1"></i>
                                    Download PDF
                                </a>
                                <a href="/report/sales-print" target="_blanc" class="btn btn-secondary" id="btn-print">
                                    <div class="fas fa-print mr-1"></div>
                                    Cetak
                                </a>`;

            $("#btn-action").html(btnAction);
            $("#sale-report tbody").html(response);
        },
        error: function (xhr, status) {
            alert("Terjadi kesalahan");
        },
    });
};
