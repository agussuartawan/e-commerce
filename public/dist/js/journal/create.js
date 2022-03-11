var row = 1;
$(function () {
    $(document).ready(function () {
        searchAccount();
    });
    $("body").on("click", "#btn-add", function (event) {
        event.preventDefault();
        row++;

        const now = new Date().toISOString().slice(0, 10);
        var html = "<tr>";
        html += `<td><input type="date" name="date[]" id="date-${row}" class="form-control" value="${now}" required></td>`;
        html += `<td><select name="account_id[]" id="account_id-${row}" class="form-control custom-select"></select>`;
        html += '<div class="input-group-append"></td>';
        html += `<td><input type="text" name="debit[]" id="debit-${row}" class="form-control" value="0"></td>`;
        html += `<td><input type="text" name="credit[]" id="credit-${row}" class="form-control" value="0"></td>`;
        html +=
            '<td><button class="btn btn-sm btn-outline-danger btn-remove">Hapus</button></td>';
        html += "</td>";
        html += "</tr>";

        $("#form").append(html);
        searchAccount();
    });

    $("body").on("click", ".btn-remove", function (event) {
        event.preventDefault();
        $(this).closest("tr").remove();
    });

    $("body").on("click", "#btn-save", function (event) {
        event.preventDefault();

        var form = $("#journal-form"),
            url = form.attr("action"),
            method = "POST",
            message = "Data jurnal umum berhasil disimpan";

        $("#errorAlert").remove();

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
                window.location.href = "/journals";
            },
            error: function (xhr) {
                var res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    const errorMessage = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                                            <strong>Error </strong><br>
                                            <span>Mohon isi form dengan benar!</span>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                    $("#errorMessage").prepend(errorMessage);
                }
            },
        });
    });
});

showSuccessToast = (message) => {
    Swal.fire("Berhasil.", message, "success");
};

searchAccount = () => {
    $("select").select2({
        theme: "bootstrap4",
        ajax: {
            url: "/account-search",
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
                            account_number: item.account_number,
                        };
                    }),
                };
            },
        },
        placeholder: "Pilih akun",
        templateResult: function (state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                `<span>${state.account_number} | ${state.text}</span>`
            );
            return $state;
        },
    });
};
