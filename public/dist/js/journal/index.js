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
                    d.dateFilter = $("#dateFilter").val();
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
            dom: "<'row'<'col'B><'col filter'><'col'f>>tipr",
            buttons: [
                {
                    text: "Tambah",
                    className: "btn btn-info",
                    action: function (e, dt, node, config) {
                        window.location.href = "/journals/create";
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

        const dateFilter =
            '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div><input class="form-control" type="text" id="dateFilter"></input></div>';

        $("div.filter").html(dateFilter);

        const start = $("#start").val(),
            end = $("#end").val();
        $("#dateFilter").daterangepicker({
            startDate: start,
            endDate: end,
            locale: {
                format: "DD-MM-YYYY",
                separator: " s/d ",
            },
        });
        $("#end").remove();
        $("#start").remove();

        $("#dateFilter").change(function () {
            dTable.draw();
        });
    });

    $("body").on("click", ".modal-edit", function () {
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
                $("select").select2({ theme: "bootstrap4" });
            },
            error: function (xhr, status) {
                $("#modal").modal("hide");
                alert("Terjadi kesalahan");
            },
        });
    });

    $("body").on("click", ".modal-save", function (event) {
        event.preventDefault();

        var form = $("#form-journal"),
            url = form.attr("action"),
            method = "PUT",
            message = "Data jurnal umum berhasil diubah";

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
                showSuccessToast(message);
                $("#modal").modal("hide");
                $("#journal-table").DataTable().ajax.reload();
            },
            error: function (xhr) {
                showErrorToast();
                var res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function (key, value) {
                        $("#" + key)
                            .addClass("is-invalid")
                            .after(
                                `<span class="invalid-feedback">${value}</span>`
                            );
                    });
                }
            },
        });
    });
});

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
});

showSuccessToast = (message) => {
    Toast.fire({
        icon: "success",
        title: message,
    });
};

showErrorToast = () => {
    Toast.fire({
        icon: "error",
        title: "&nbsp;Terjadi Kesalahan!",
    });
};
