var row;
$(function () {
    "use strict";
    $(document).ready(function () {
        const dTable = $("#purchase-table").DataTable({
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
                url: "purchase/get-list",
                data: function (d) {
                    d.dateFilter = $("#daterange").val();
                    d.search = $('input[type="search"]').val();
                },
            },
            columns: [
                { data: "purchase_number", name: "purchase_number" },
                { data: "date", name: "date" },
                { data: "total_qty", name: "total_qty" },
                { data: "action", name: "action", orderable: false },
            ],
            dom: "<'row'<'col'B><'col-sm-3 mb-1 filter'><'col'f>>tipr",
            buttons: [
                {
                    text: "Tambah",
                    className: "btn btn-info btn-add",
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

        $(".modal-save").remove();
    });

    $("body").on("click", ".btn-removes", function (event) {
        event.preventDefault();
        var first_td = $(this).closest("tr").children("td:first");
        if (
            first_td.find(".product-select").attr("data-last-select") == "true"
        ) {
            $(this)
                .closest("tr")
                .prev("tr")
                .children("td:first")
                .find(".product-select")
                .attr("data-last-select", "true");
        }
        $(this).parents("tr").remove();
    });

    $("body").on("change", ".product-select", function () {
        const me = $(this);
        if (me.attr("data-last-select") == "true") {
            showCreateForm(row++, 0, 0);
            me.removeAttr("data-last-select");
        }
    });

    inputQtyMask();

    $("body").on("change", ".input-number", function () {
        var price = $("#price").val();
        var qty = $(this).val();
        countGrandTotal(qty, price);
    });

    $("body").on("click", ".btn-show", function (event) {
        event.preventDefault();
        showModal();

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
                $("#modal").modal("hide");
                alert("Terjadi kesalahan");
            },
        });
    });

    $("body").on("click", ".modal-edit", function (event) {
        event.preventDefault();
        showModal();

        var me = $(this),
            url = me.attr("href"),
            title = me.attr("title"),
            id = me.attr("data-id");

        $(".modal-title").text(title);
        $(".modal-footer").append(
            '<button type="button" class="btn btn-primary modal-save">Simpan</button>'
        );

        $.ajax({
            url: url,
            type: "GET",
            dataType: "html",
            success: function (response) {
                $(".modal-body").html(response);
                row = $("#row").val();
                showCreateForm(row++, 1, id);
                searchProduct();
            },
            error: function (xhr, status) {
                $("#modal").modal("hide");
                alert("Terjadi kesalahan");
            },
        });
    });

    $("body").on("click", ".modal-save", function (event) {
        event.preventDefault();

        var form = $("#form-purchase"),
            url = form.attr("action"),
            method =
                $("input[name=_method").val() == undefined ? "POST" : "PUT",
            message =
                $("input[name=_method").val() == undefined
                    ? "Data barang masuk berhasil ditambahkan"
                    : "Data barang masuk berhasil diubah";

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
                $("#purchase-table").DataTable().ajax.reload();
            },
            error: function (xhr) {
                showErrorToast();
                var res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    showErrorToast();
                }
            },
        });
    });

    $("#modal").on("hidden.bs.modal", function () {
        $(".modal-save").remove();
    });
});

showSuccessToast = (message) => {
    Swal.fire("Berhasil.", message, "success");
};

showErrorToast = () => {
    Swal.fire("Opps..", "Terjadi kesalahan", "error");
};

inputQtyMask = () => {
    $("body").on("click", ".btn-number", function (event) {
        event.preventDefault();
        const fieldName = $(this).attr("data-field"),
            type = $(this).attr("data-type"),
            input = $('input[name="qty"]');

        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == "minus") {
                if (currentVal > input.attr("min")) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr("min")) {
                    $(this).attr("disabled", true);
                }
            } else if (type == "plus") {
                if (currentVal < input.attr("max")) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val) == input.attr("max")) {
                    $(this).attr("disabled", true);
                }
            } else {
                input.val(0);
            }
        }
    });

    $("body").on("focusin", ".input-number", function () {
        $(this).data("oldValue", $(this).val());
    });

    $("body").on("change", ".input-number", function () {
        minValue = parseInt($(this).attr("min"));
        maxValue = parseInt($(this).attr("max"));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr("name");
        if (valueCurrent >= minValue) {
            $(
                ".btn-number[data-type='minus'][data-field='" + name + "']"
            ).removeAttr("disabled");
        } else {
            $(this).val($(this).data("oldValue"));
        }
        if (valueCurrent <= maxValue) {
            $(
                ".btn-number[data-type='plus'][data-field='" + name + "']"
            ).removeAttr("disabled");
        } else {
            $(this).val($(this).data("oldValue"));
        }
    });
    $("body").on("keydown", ".input-number", function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (
            $.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)
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
};

searchProduct = () => {
    $(".product-select")
        .select2({
            theme: "bootstrap4",
            ajax: {
                url: "/product-search",
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
                                text: item.product_name,
                                id: item.id,
                                production_price: item.production_price,
                            };
                        }),
                    };
                },
            },
            placeholder: "Cari produk",
            cache: true,
            allowClear: true,
        })
        .on("select2:select", function (event) {
            var data = event.params.data;
            var id = $(this).attr("id");
            var id_number = id.slice(-1);

            $(`#production_price_${id_number}`).val(
                Math.round(data.production_price)
            );
        })
        .on("change", function (event) {
            var id = $(this).attr("id");
            var id_number = id.slice(-1);
            var this_value = $(this).val();
            $(`#hidden_${id_number}`).val(this_value);
        });
};

rupiah = (bilangan) => {
    var number_string = bilangan.toString(),
        sisa = number_string.length % 3,
        rupiah = number_string.substr(0, sisa),
        ribuan = number_string.substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    // Cetak hasil
    return rupiah;
};

countGrandTotal = (qty, price) => {
    var grand_total = parseInt(price) * parseInt(qty);
    $("#grand_total").text(rupiah(grand_total));
};

showModal = () => {
    $("#modal").modal("show");
};

fillModal = (me) => {
    var url = me.attr("href"),
        title = me.attr("title");

    url === undefined ? (url = "/purchases/create") : "";
    title === undefined ? (title = "Tambah Barang Masuk") : "";

    $(".modal-title").text(title);
    $(".modal-footer").append(
        '<button type="button" class="btn btn-primary modal-save">Simpan</button>'
    );

    $.ajax({
        url: url,
        type: "GET",
        dataType: "html",
        success: function (response) {
            $(".modal-body").html(response);
            row = $("#row").val();
            showCreateForm(row++);
        },
        error: function (xhr, status) {
            alert("Terjadi kesalahan");
        },
    });
};

showCreateForm = (row, is_edit, id) => {
    $.ajax({
        url: "/purchase/show-input-product",
        type: "GET",
        data: {
            row: row,
            is_edit: is_edit,
            id: id,
        },
        dataType: "html",
        success: function (response) {
            $("#purchase-create-table tbody").append(response);
            searchProduct();
        },
        error: function (xhr, status) {
            alert("Terjadi kesalahan");
        },
    });
};
