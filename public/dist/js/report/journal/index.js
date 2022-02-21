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

    $('#btn-search').click(function(){
        const search = $('#dateFilter').val();
        loadData(search);
    });
});

loadData = (search) => {
    $.ajax({
        url: '/report/journals/get-lists?search=' + search,
        type: "GET",
        dataType: "html",
        beforeSend: function(){
            $('#preloader').fadeIn();
        },
        complete: function(){
            $('#preloader').fadeOut();
        },
        success: function (response) {
            const btnAction = `<button class="btn btn-danger mr-2">
                                    <i class="fas fa-download mr-1"></i>
                                    Download PDF
                                </button>
                                <button class="btn btn-secondary">
                                    <div class="fas fa-print mr-1"></div>
                                    Cetak
                                </button>`;

            $('#btn-action').html(btnAction);
            $("#journal-report tbody").html(response);
        },
        error: function (xhr, status) {
            alert("Terjadi kesalahan");
        },
    });
}
