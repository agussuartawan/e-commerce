$(function () {
    $(document).ready(function () {
        const dTable = $("#journal-table").DataTable({
            lengthChange: false,
            paging: true,
            serverSide: true,
            processing: true,
            responsive: true,
            autoWidth: false,
            order: [[0, "desc"]],
            language: {
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ ke _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 ke 0 dari 0 data",
                emptyTable: "Tidak ada data tersedia pada tabel",
                infoFiltered: "(Difilter dari _MAX_ total data)",
                search: "Cari:",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                },
            },
            scroller: {
                loadingIndicator: false,
            },
            pagingType: "first_last_numbers",
            ajax: {
                url: "journal/get-list",
                data: function (d) {
                    d.search = $('input[type="search"]').val();
                    // d.category_id = $('select').val();
                },
            },
            columns: [
                { data: "date", name: "date" },
                { data: "account_name", name: "account_name" },
                { data: "account_number", name: "account_number" },
                { data: "debit", name: "debit" },
                { data: "credit", name: "credit" },
                { data: "action", name: "action", orderable: false },
            ],
            dom: "<'row'<'col'B><'col month'><'col year'><'col'f>>tipr",
            buttons: [
                {
                    text: "Tambah",
                    className: "btn btn-info",
                    action: function (e, dt, node, config) {
                        window.location.href = "/journals/create";
                    },
                },
            ],
        });


        const month = '<select class="form-control" id="month"></select>';
        const year = '<select class="form-control" id="year"></select>';

        $("div.month").html(month);
        $("div.year").html(year);
        selectMonth();
        selectYear();
    });
});

selectMonth = () => {
    $('#month').select2({
        theme: "bootstrap4",
        ajax: {
            url: "/search-month",
            dataType: "json",
            data: function (params) {
                var query = {
                    search: params.term,
                };
    
                return query;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                        };
                    }),
                };
            },
        },
        placeholder: "Filter Bulan",
        cache: true,
        allowClear: true,
    })
    .on('change', function(){
        dTable.draw();
    });
}

selectYear = () => {
    $('#year').select2({
        theme: "bootstrap4",
        ajax: {
            url: "/search-year",
            dataType: "json",
            data: function (params) {
                var query = {
                    search: params.term,
                };
    
                return query;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                        };
                    }),
                };
            },
        },
        placeholder: "Filter Tahun",
        cache: true,
        allowClear: true,
    })
    .on('change', function(){
        dTable.draw();
    });
}