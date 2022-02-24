$(function () {
    "use strict";
    $('#btn-search').click(function(){
        const month = $('#month').val();
        const year = $('#year').val();
        loadData(month, year);
    });

    $('body').on('click', '#btn-download', function(event){
        event.preventDefault();
        const url = $(this).attr('href');
        const month = $('#month').val();
        const year = $('#year').val();
        window.open(url + '?month=' + month + '&year=' + year, '_blanc');
    });

    $('body').on('click', '#btn-print', function(event){
        event.preventDefault();
        const url = $(this).attr('href');
        const month = $('#month').val();
        const year = $('#year').val();
        window.open(url + '?month=' + month + '&year=' + year, '_blanc');
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
            const btnAction = `<a href="/report/trial-balance-download" target="_blanc" class="btn btn-danger mr-2" id="btn-download">
                                    <i class="fas fa-download mr-1"></i>
                                    Download PDF
                                </a>
                                <a href="/report/trial-balance-print" target="_blanc" class="btn btn-secondary" id="btn-print">
                                    <div class="fas fa-print mr-1"></div>
                                    Cetak
                                </a>`;

            $('#btn-action').html(btnAction);
            $("#trial-balance-report tbody").html(response);
        },
        error: function (xhr, status) {
            alert("Terjadi kesalahan");
        },
    });
}
