$(function () {
    "use strict";
    $(document).ready(function () {
        const dTable = $("#payment-table").DataTable({
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
                url: "payment/get-list",
                data: function (d) {
                    d.dateFilter = $("#daterange").val();
                    d.search = $('input[type="search"]').val();
                },
            },
            columns: [
                { data: "sale_number", name: "sale_number" },
                { data: "date", name: "date" },
                { data: "sender_account_name", name: "sender_account_name" },
                {
                    data: "transfer_proof",
                    name: "transfer_proof",
                    orderable: false,
                },
                { data: "payment_status", name: "payment_status" },
                { data: "action", name: "action", orderable: false },
            ],
            dom: "<'row'<'col-sm-3 mb-1 filter'><'col'f>>tipr",
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
    });

    $(".modal-save").on("click", function (event) {
        event.preventDefault();

        var form = $("#form-payment"),
            url = form.attr("action"),
            method = "PUT",
            message = "Data pembayaran berhasil diubah";

        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();

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
            success: function (response) {
                $("#modal").modal("hide");
                $("#payment-table").DataTable().ajax.reload();
                showSuccessToast(message);
            },
            error: function (xhr) {
                var res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function (key, value) {
                        $("#" + key)
                            .addClass("is-invalid")
                            .after(
                                `<small class="invalid-feedback">${value}</small>`
                            );
                    });
                }
            },
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

    $("body").on("click", ".modal-edit", function (event) {
        event.preventDefault();
        $("#modal").modal("show");

        var me = $(this),
            url = me.attr("href"),
            title = me.attr("title");

        $(".modal-title").text(title);

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
                    message = "Konfirmasi pembayaran berhasil.";

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
                        $("#payment-table").DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        showErrorToast();
                    },
                });
            }
        });
    });
});

showSuccessToast = (message) => {
    Swal.fire("Berhasil.", message, "success");
};

showErrorToast = () => {
    Swal.fire("Opps..", "Terjadi kesalahan", "error");
};
