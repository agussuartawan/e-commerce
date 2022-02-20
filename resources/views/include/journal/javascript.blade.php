<script>
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
            dom: "<'row'<'col'B><'col select'><'col'f>>tipr",
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

        const custom_filter = '<div class"form-inline">'
        custom_filter += '{!! Form::select("months", $months, null, ["class" => "form-control custom-select", "id" => "months"]) !!}';
        custom_filter += '{!! Form::select("yeary", $years, null, ["class" => "form-control custom-select", "id" => "years"]) !!}';
        custom_filter += '</div>';

        $("div.select").html(custom_filter);
    });
});

</script>