$(function () {
    $(document).ready(function () {
        const search = $('input[type="search"]').val();
        loadData(search);
    });

    $("body").on('keydown', '#account_number', function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (
            $.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39) ||
            (e.keyCode == 45) 
        ) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if (
            (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) &&
            (e.keyCode < 96 || e.keyCode > 105)
        ) {
            e.preventDefault();
        }
    });

    $('input[type="search"]').keypress(function(event){
        if(event.keyCode == 13) {
            const search = $(this).val();
            loadData(search);
        }
    });

    $('body').on('click', '#btn-add-account', function(event){
        event.preventDefault();
        const me = $(this);
        showModal(me);
    });

    $("body").on("click", ".modal-edit", function (event) {
        event.preventDefault();
        const me = $(this);
        showModal(me);
    });

    $("body").on("click", ".btn-delete", function (event) {
        event.preventDefault();
        const me = $(this),
            url = me.attr('href'),
            title = me.attr('title'),
            token = $('meta[name="csrf-token"]').attr('content');
        if(confirm('Yakin ' + title +'?')){
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': token, 
                },
                success: function(response){
                    const search = $('input[type="search"]').val();
                    loadData(search);
                    showSuccessToast('Data akun berhasil dihapus');
                },
                error: function(xhr){
                    showErrorToast();
                }
            });
        }
    });

    $('body').on('change', '#account_type_id', function(){
        const id = $(this).children(':selected').attr('value');
        $('#account_type_number').text(`${id} -`);
    });

    $(".modal-save").on("click", function (event) {
        event.preventDefault();

        var form = $("#form-account"),
            url = form.attr("action"),
            method =
                $("input[name=_method").val() == undefined ? "POST" : "PUT",
            message =
                $("input[name=_method").val() == undefined
                    ? "Data akun berhasil ditambahkan"
                    : "Data akun berhasil diubah";

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
                const search = $('input[type="search"]').val();
                loadData(search);
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

showModal = (me) => {
    const url = me.attr('href'),
            title = me.attr('title');

    $('#modal').modal('show');
    $('.modal-title').text(title);
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'html',
        success: function(response){
            $('.modal-body').html(response);
            $('select').select2({ theme:'bootstrap4' });
        },
        error: function(xhr){
            $('#modal').modal('hide');
            alert('Terjadi Kesalahan');
        }
    });
}