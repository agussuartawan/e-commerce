$(function () {
    $(document).ready(function () {
        $("#bank-table").DataTable({
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
                url: "banks/get-list",
                data: function (d) {
                    d.search = $('input[type="search"]').val();
                },
            },
            columns: [
                { data: "name", name: "name" },
                { data: "account_number", account_number: "name" },
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
        });
    });

    $("body").on("click", ".modal-edit", function (event) {
        event.preventDefault();
        var me = $(this);

        showModal();
        fillModal(me);
    });

    $(".modal-save").on("click", function (event) {
        event.preventDefault();

        var form = $("#form-bank"),
            url = form.attr("action"),
            method =
                $("input[name=_method").val() == undefined ? "POST" : "PUT",
            message =
                $("input[name=_method").val() == undefined
                    ? "Data bank berhasil ditambahkan"
                    : "Data bank berhasil diubah";

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
                $("#bank-table").DataTable().ajax.reload();
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

    url === undefined ? (url = "/banks/create") : "";
    title === undefined ? (title = "Tambah Bank") : "";

    $(".modal-title").text(title);

    $.ajax({
        url: url,
        type: "GET",
        dataType: "html",
        success: function (response) {
            $(".modal-body").html(response);
        },
        error: function (xhr, status) {
            $('#modal').modal('hide');
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
