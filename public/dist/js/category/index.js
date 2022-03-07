$(function () {
    $(document).ready(function () {
        var dTable = $("#category-table").DataTable({
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
                url: "categories/get-list",
                data: function (d) {
                    d.search = $('input[type="search"]').val();
                },
            },
            columns: [
                { data: "name", name: "name" },
                { data: "action", name: "action", orderable: false },
            ],
            dom: "<'row'<'col'B><'col'f>>tipr",
            buttons: [
                {
                    text: "Tambah",
                    className: "btn btn-info",
                    action: function (e, dt, node, config) {
                        showModal();
                        fillModal($(this));
                    },
                },
            ],
            initComplete: function (settings, json) {
                $('input[type="search"').unbind();
                $('input[type="search"').bind("keyup", function (e) {
                    if (e.keyCode == 13) {
                        dTable.draw();
                    }
                });
            },
        });
    });

    $("body").on("click", ".btn-delete", function (event) {
        event.preventDefault();
        var me = $(this);
        showDeleteAlert(me);
    });

    $("body").on("click", ".modal-edit", function (event) {
        event.preventDefault();
        var me = $(this);

        showModal();
        fillModal(me);
    });

    $(".modal-save").on("click", function (event) {
        event.preventDefault();

        var form = $("#form-category"),
            url = form.attr("action"),
            method =
                $("input[name=_method").val() == undefined ? "POST" : "PUT",
            message =
                $("input[name=_method").val() == undefined
                    ? "Data kategori berhasil ditambahkan"
                    : "Data kategori berhasil diubah";

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
                $("#category-table").DataTable().ajax.reload();
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

var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
});

showModal = () => {
    $("#modal").modal("show");
};

fillModal = (me) => {
    var url = me.attr("href"),
        title = me.attr("title");

    url === undefined ? (url = "/categories/create") : "";
    title === undefined ? (title = "Tambah Kategori") : "";

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
};

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

showDeleteAlert = function (me) {
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
                    $("#category-table").DataTable().ajax.reload();
                    showSuccessToast("Data kategori berhasil dihapus");
                },
                error: function (xhr) {
                    showErrorToast();
                },
            });
        }
    });
};
