$(function () {
    "use strict";
    $('#btn-search').click(function(){
        const month = $('#month').val();
        const year = $('#year').val();
        loadData(month, year);
    });
});

loadData = (month, year) => {
    $.ajax({
        url: `/report/trial-balances/get-lists?month=${month}&year=${year}`,
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
            $("#trial-balance-report tbody").html(response);
        },
        error: function (xhr, status) {
            alert("Terjadi kesalahan");
        },
    });
}
