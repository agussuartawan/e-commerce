$(function () {
    "use strict";
    $(document).ready(function () {
        const dTable = $("#sale-table").DataTable({
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
                url: "sale/get-list",
                data: function (d) {
                    d.dateFilter = $("#daterange").val();
                    d.search = $('input[type="search"]').val();
                },
            },
            columns: [
                { data: "sale_number", name: "sale_number" },
                { data: "customer", name: "customer" },
                { data: "product", name: "product" },
                { data: "date", name: "date" },
                { data: "grand_total", name: "grand_total" },
                {
                    data: "delivery_status",
                    name: "delivery_status",
                    orderable: false,
                },
                { data: "action", name: "action", orderable: false },
            ],
            dom: "<'row'<'col-sm-3 mb-1 filter'><'col'f>>tipr",
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
        $(".print-sale").remove();
    });

    inputQtyMask();

    $("body").on("change", ".input-number", function () {
        var price = $("#price").val();
        var qty = $(this).val();
        countGrandTotal(qty, price);
    });

    $("body").on("click", ".btn-confirm", function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Yakin melanjutkan konfirmasi?",
            text: "Konfirmasi tidak dapat dibatalkan!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, konfirmasi",
        }).then((result) => {
            if (result.isConfirmed) {
                var form_id = $(this).attr("data-id"),
                    form = $(`.${form_id}`),
                    url = form.attr("action"),
                    method = "POST",
                    message = "Konfirmasi pengiriman berhasil.";

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
                    success: function (data) {
                        showSuccessToast(message);
                        $("#sale-table").DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        showErrorToast();
                    },
                });
            }
        });
    });

    $("body").on("click", ".btn-show", function (event) {
        event.preventDefault();
        $("#modal").modal("show");

        var me = $(this),
            url = me.attr("href"),
            title = me.attr("title");

        $(".modal-title").text(title);
        $(".modal-footer").append(
            '<a href="#" target="_blanc" class="btn btn-primary print-sale">Cetak Nota Penjualan</a>'
        );
        $(".modal-footer").append(
            '<a href="#" target="_blanc" class="btn btn-primary print-fo">Cetak Form Order</a>'
        );

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
        $("#modal").modal("show");
        $(".modal-footer").append(
            '<button type="button" class="btn btn-primary modal-save">Simpan</button>'
        );

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
                const product_id = $("#product_id").val();
                const sale_id = $("#sale_id").val();
                const province_id = $("#province_id").val();

                searchBank();
                searchProvince();
                searchCustomer();
                searchCity(province_id);
                searchProduct();
                showVariant(product_id, sale_id);

                const price = $("#price").val();
                const qty = $(".input-number").val();
                countGrandTotal(qty, price);
            },
            error: function (xhr, status) {
                $("#modal").modal("hide");
                alert("Terjadi kesalahan");
            },
        });
    });

    $("body").on("click", ".modal-save", function (event) {
        event.preventDefault();

        var form = $("#form-order"),
            url = form.attr("action"),
            method = "PUT",
            message = "Data penjualan berhasil diubah";

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
                $("#sale-table").DataTable().ajax.reload();
            },
            error: function (xhr) {
                showErrorToast();
                var res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function (key, value) {
                        if (key === "qty") {
                            $("#qty").addClass("is-invalid");
                            $("#input-qty").append(
                                `<span class="invalid-feedback">${value}</span>`
                            );
                        } else {
                            $("#" + key)
                                .addClass("is-invalid")
                                .after(
                                    `<span class="invalid-feedback">${value}</span>`
                                );
                            if (key === "product_fragrance_id") {
                                $(".fragrance-row").after(
                                    `<small class="text-danger">${value}</small>`
                                );
                            }
                            if (key === "product_color_id") {
                                $(".color-row").after(
                                    `<small class="text-danger">${value}</small>`
                                );
                            }
                        }
                    });
                }
            },
        });
    });

    $("#modal").on("hidden.bs.modal", function () {
        $(".modal-save").remove();
        $(".print-sale").remove();
        $(".print-fo").remove();
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

searchProvince = () => {
    $("#province_id")
        .select2({
            theme: "bootstrap4",
            ajax: {
                url: "/province-search",
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
                            };
                        }),
                    };
                },
            },
            placeholder: "Cari provinsi",
            cache: true,
        })
        .on("change", function () {
            const province_id = $(this).val();
            searchCity(province_id);
        });
};

searchCustomer = () => {
    $("#customer_id")
        .select2({
            theme: "bootstrap4",
            ajax: {
                url: "/customer-search",
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
                                text: item.fullname,
                                id: item.id,
                                address: item.address,
                            };
                        }),
                    };
                },
            },
            placeholder: "Cari pelanggan",
            cache: true,
        })
        .on("select2:select", function (event) {
            const customer_id = $(this).val();
            $("#address").val(event.params.data.address);
        });
};

searchBank = () => {
    $("#bank_id").select2({
        theme: "bootstrap4",
        ajax: {
            url: "/bank-search",
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
                        };
                    }),
                };
            },
        },
        placeholder: "Cari bank",
        cache: true,
    });
};

searchCity = (province_id) => {
    $("#city_id").select2({
        theme: "bootstrap4",
        ajax: {
            url: "/city-search/" + province_id,
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
                        };
                    }),
                };
            },
        },
        placeholder: "Cari kota",
        cache: true,
    });
};

searchProduct = () => {
    $("#product_id")
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
                                selling_price: item.selling_price,
                            };
                        }),
                    };
                },
            },
            placeholder: "Cari provinsi",
            cache: true,
        })
        .on("select2:select", function (event) {
            const product_id = $(this).val();
            const sale_id = $("#sale_id").val();
            const price = event.params.data.selling_price;
            $("#price").val(price);
            showVariant(product_id, sale_id);
            const qty = $(".input-number").val();
            countGrandTotal(qty, price);
        });
};

showVariant = (product_id, sale_id) => {
    $.ajax({
        url: `/sale/${product_id}/${sale_id}/get-variant-list`,
        type: "GET",
        dataType: "html",
        success: function (response) {
            $("#load-variant-here").html(response);
        },
        error: function (xhr, status) {
            $("#modal").modal("hide");
            alert("Terjadi kesalahan");
        },
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
