$(function () {
    $(document).ready(function () {
        var provinceTable = $("#provinces-table").DataTable({
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
                url: "region/provinces",
                data: function (d) {
                    d.search = $("#province-filter").val();
                },
            },
            columns: [
                { data: "name", name: "name" },
                { data: "action", name: "action", orderable: false },
            ],
            dom: "<'row'<'col'B><'col search-province'>>tipr",
            buttons: [
                {
                    text: "Tambah Provinsi",
                    className: "btn btn-info",
                    action: function (e, dt, node, config) {
                        showModal("province-save");
                        modalProvince($(this));
                    },
                },
            ],
        });
        $("div.search-province").html(
            '<div class="dataTables_filter"><label>Cari: <input type="search" class="form-control form-control-sm" id="province-filter"></label></div>'
        );
        $("#province-filter").on("keyup", function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                provinceTable.draw();
            }
        });

        var cityTable = $("#cities-table").DataTable({
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
                url: "region/cities",
                data: function (d) {
                    d.search = $("#city-filter").val();
                },
            },
            columns: [
                { data: "name", name: "name" },
                { data: "province", name: "province" },
                { data: "action", name: "action", orderable: false },
            ],
            dom: "<'row'<'col'B><'col search-city'>>tipr",
            buttons: [
                {
                    text: "Tambah Kota",
                    className: "btn btn-info",
                    action: function (e, dt, node, config) {
                        showModal("city-save");
                        modalCity($(this));
                    },
                },
            ],
        });
        $("div.search-city").html(
            '<div class="dataTables_filter"><label>Cari: <input type="search" class="form-control form-control-sm" id="city-filter"></label></div>'
        );
        $("#city-filter").on("keyup", function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                cityTable.draw();
            }
        });
    });

    $("body").on("click", ".province-edit", function (event) {
        event.preventDefault();
        var me = $(this);

        showModal("province-save");
        modalProvince(me);
    });

    $("body").on("click", ".city-edit", function (event) {
        event.preventDefault();
        var me = $(this);

        showModal("city-save");
        modalProvince(me);
    });

    $("body").on("click", ".province-delete", function (event) {
        event.preventDefault();
        var me = $(this);
        showDeleteAlert(
            me,
            "Data provinsi berhasil dihapus",
            "#provinces-table"
        );
    });

    $("body").on("click", ".city-delete", function (event) {
        event.preventDefault();
        var me = $(this);
        showDeleteAlert(me, "Data kota berhasil dihapus", "#cities-table");
    });

    $("body").on("click", "#province-save", function (event) {
        event.preventDefault();

        var form = $("#form-province"),
            url = form.attr("action"),
            method =
                $("input[name=_method").val() == undefined ? "POST" : "PUT",
            message =
                $("input[name=_method").val() == undefined
                    ? "Data provinsi berhasil ditambahkan"
                    : "Data provinsi berhasil diubah";

        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();

        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            beforeSend: function () {
                $(".modal-save").attr("disabled", true);
            },
            complete: function () {
                $(".modal-save").removeAttr("disabled");
            },
            success: function (response) {
                showSuccessToast(message);
                $("#modal").modal("hide");
                $("#provinces-table").DataTable().ajax.reload();
            },
            error: function (xhr) {
                showErrorToast();
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

    $("body").on("click", "#city-save", function (event) {
        event.preventDefault();

        var form = $("#form-city"),
            url = form.attr("action"),
            method =
                $("input[name=_method").val() == undefined ? "POST" : "PUT",
            message =
                $("input[name=_method").val() == undefined
                    ? "Data kota berhasil ditambahkan"
                    : "Data kota berhasil diubah";

        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();

        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            beforeSend: function () {
                $(".modal-save").attr("disabled", true);
            },
            complete: function () {
                $(".modal-save").removeAttr("disabled");
            },
            success: function (response) {
                showSuccessToast(message);
                $("#modal").modal("hide");
                $("#cities-table").DataTable().ajax.reload();
            },
            error: function (xhr) {
                showErrorToast();
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
});

showModal = (id) => {
    $("#modal").modal("show");
    $(".modal-save").attr("id", `${id}`);
};

modalProvince = (me) => {
    var url = me.attr("href"),
        title = me.attr("title");

    url === undefined ? (url = "/region/provinces/create") : "";
    title === undefined ? (title = "Tambah Provinsi") : "";

    $(".modal-title").text(title);

    $.ajax({
        url: url,
        type: "GET",
        dataType: "html",
        success: function (response) {
            $(".modal-body").html(response);
        },
        error: function (xhr, status) {
            $("#modal").modal("hide");
            alert("Terjadi kesalahan");
        },
    });
};

modalCity = (me) => {
    var url = me.attr("href"),
        title = me.attr("title");

    url === undefined ? (url = "/region/cities/create") : "";
    title === undefined ? (title = "Tambah Kota") : "";

    $(".modal-title").text(title);

    $.ajax({
        url: url,
        type: "GET",
        dataType: "html",
        success: function (response) {
            $(".modal-body").html(response);
        },
        error: function (xhr, status) {
            $("#modal").modal("hide");
            alert("Terjadi kesalahan");
        },
    });
};

showSuccessToast = (message) => {
    Swal.fire("Berhasil!", message, "success");
};

showErrorToast = () => {
    Swal.fire("Opps!", "Terjadi kesalahan!", "error");
};

showDeleteAlert = function (me, message, table_id) {
    var url = me.attr("href"),
        title = me.attr("title"),
        token = $('meta[name="csrf-token"]').attr("content");

    Swal.fire({
        title: "Perhatian!",
        text: "Hapus data " + title + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: token,
                },
                success: function (response) {
                    $(table_id).DataTable().ajax.reload();
                    showSuccessToast(message);
                },
                error: function (xhr) {
                    showErrorToast();
                },
            });
        }
    });
};
