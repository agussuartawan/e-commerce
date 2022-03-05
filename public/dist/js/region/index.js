$(function () {
    $(document).ready(function () {
        $("table").DataTable();
    });

    $("body").on("click", ".city-edit", function (event) {
        event.preventDefault();
        var me = $(this);

        showModal();
        modalCity(me);
    });

    $("body").on("click", ".province-edit", function (event) {
        event.preventDefault();
        var me = $(this);

        showModal();
        modalProvince(me);
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

showModal = () => {
    $("#modal").modal("show");
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
