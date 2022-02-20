$(function () {
    $(document).ready(function () {
        loadData();
    });

    $('body').on('change', '.input-debit', function(){
        countTotalDebit();
    });

    $('body').on('change', '.input-credit', function(){
        countTotalCredit();
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

    $('button[type="submit"]').click(function(event){
        event.preventDefault();
        Swal.fire({
            title: "Yakin menyimpan saldo awal?",
            text: "Data neraca saldo awal tidak dapat diubah!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, atur saldo awal",
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-trial-balance').submit();
            }
        });
    });

    $('body').on('click', '#btn-add-account', function(event){
        event.preventDefault();
        const me = $(this);
        showModal(me);
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
                $("#modal").modal("hide");
                loadData();
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
});

loadData = () => {
    $.ajax({
        url: '/trial-balance/get-form',
        type: "GET",
        dataType: "html",
        beforeSend: function(){
            $('#preloader').fadeIn();
        },
        complete: function(){
            $('#preloader').fadeOut();
        },
        success: function (response) {
            $("#trial-balance-table tbody").html(response);
        },
        error: function (xhr, status) {
            alert("Terjadi kesalahan");
        },
    });
}

countTotalDebit = () => {
    var last_debit_id = $('.input-debit').last().attr('id'), 
        debit_row = last_debit_id.split("-").pop(), 
        total = 0;

    for (let index = 1; index <= debit_row; index++) {
        var this_value = $(`#debit-${index}`).val();
        if (this_value && this_value != undefined) {
            var this_total = this_value.replaceAll('.', '');
            total = parseInt(total) + parseInt(this_total);
        }
    }
    $('#total-debit').text(rupiah(total));
}

countTotalCredit = () => {
    var last_credit_id = $('.input-credit').last().attr('id'), 
        credit_row = last_credit_id.split("-").pop(), 
        total = 0;

    for (let index = 1; index <= credit_row; index++) {
        var this_value = $(`#credit-${index}`).val();
        if (this_value && this_value != undefined) {
            var this_total = this_value.replaceAll('.', '');
            total = parseInt(total) + parseInt(this_total);
        }
    }
    $('#total-credit').text(rupiah(total));
}

rupiah = (bilangan) => {
    var number_string = bilangan.toString(), sisa = number_string.length % 3, rupiah = number_string.substr(0, sisa), ribuan = number_string.substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    // Cetak hasil
    return rupiah;
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