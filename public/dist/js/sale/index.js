$(function () {
    "use strict";
    $(document).ready(function () {
        const dTable = $("#sale-table").DataTable({
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
                url: "sale/get-list",
                data: function (d) {
                    d.dateFilter = $("#daterange").val();
                    d.search = $('input[type="search"]').val();
                },
            },
            columns: [
                { data: "sale_number", name: "sale_number" },
                { data: "customer", name: "customer" },
                { data: "product", name: "product" },
                { data: "date", name: "date" },
                { data: "grand_total", name: "grand_total" },
                { data: "delivery_status", name: "delivery_status" },
                { data: "action", name: "action", orderable: false },
            ],
            dom: "<'row'<'col'B><'col filter'><'col'f>>tipr",
            buttons: [
                {
                    text: "Tambah",
                    className: "btn btn-info",
                    action: function (e, dt, node, config) {
                        window.location.href = "/products/create";
                    },
                },
            ],
            initComplete: function (settings, json) {
                $('input[type="search"').unbind();
                $('input[type="search"').bind("keyup", function (e) {
                    if (e.keyCode == 13) {
                        dTable.search(this.value).draw();
                    }
                });
            },
        });

        $("#daterange").remove();

        $("div.filter").html(
            '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div><input type="text" class="form-control float-right" id="daterange"></div>'
        );

        $("#daterange").daterangepicker({
            locale: {
                format: "DD-MM-YYYY",
                separator: " / ",
            },
        });

        $("#daterange").change(function () {
            dTable.draw();
        });

        $("select")
            .select2({
                theme: "bootstrap4",
                ajax: {
                    url: "/categories-search",
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
                placeholder: "Cari kategori",
                cache: true,
                allowClear: true,
            })
            .on("change", function () {
                dTable.draw();
            });
    });

    $("body").on("click", ".btn-confirm", function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Yakin melanjutkan konfirmasi?",
            text: "Konfirmasi dapat dibatalkan lewat menu detail.",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, konfirmasi",
        }).then((result) => {
            if (result.isConfirmed) {
                var form_id = $(this).attr("data-id"),
                    form = $(`.${form_id}`),
                    url = form.attr("action"),
                    method = "POST",
                    message = "Konfirmasi pengiriman berhasil.";

                $.ajax({
                    url: url,
                    method: method,
                    data: form.serialize(),
                    beforeSend: function () {
                        $(".btn").attr("disabled", true);
                    },
                    complete: function () {
                        $(".btn").removeAttr("disabled");
                    },
                    success: function (data) {
                        showSuccessToast(message);
                        $("#sale-table").DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        showErrorToast();
                    },
                });
            }
        });
    });

    $("body").on("click", ".btn-show", function (event) {
        event.preventDefault();
        $("#modal").modal("show");

        var me = $(this),
            url = me.attr("href"),
            title = me.attr("title");

        $(".modal-title").text(title);
        $(".modal-save").remove();

        $.ajax({
            url: url,
            type: "GET",
            dataType: "html",
            success: function (response) {
                $(".modal-body").html(response);
            },
            error: function (xhr, status) {
                alert("Terjadi kesalahan");
            },
        });
    });
});

showSuccessToast = (message) => {
    Swal.fire("Berhasil.", message, "success");
};

showErrorToast = () => {
    Swal.fire("Opps..", "Terjadi kesalahan", "error");
};
