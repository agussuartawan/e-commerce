$(function () {
    $(document).ready(function () {
        const search = $('input[type="search"]').val();
        loadData(search);
    });

    $('input[type="search"]').keypress(function(event){
        if(event.keyCode == 13) {
            const search = $(this).val();
            loadData(search);
        }
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

loadData = (search) => {
    $.ajax({
        url: '/account/get-list?search=' + search,
        type: "GET",
        dataType: "html",
        beforeSend: function(){
            $('#preloader').fadeIn();
        },
        complete: function(){
            $('#preloader').fadeOut();
        },
        success: function (response) {
            $("#account-table tbody").html(response);
        },
        error: function (xhr, status) {
            alert("Terjadi kesalahan");
        },
    });
}