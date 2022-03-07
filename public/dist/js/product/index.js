$(function () {
    $(document).ready(function () {
        const dTable = $("#product-table").DataTable({
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
                url: "products/get-list",
                data: function (d) {
                    d.search = $('input[type="search"]').val();
                    d.category_id = $("select").val();
                },
            },
            columns: [
                { data: "code", name: "code" },
                { data: "product_name", name: "product_name" },
                { data: "selling_price", name: "selling_price" },
                { data: "stock", name: "stock" },
                { data: "category", name: "product.category" },
                { data: "action", name: "action", orderable: false },
            ],
            dom: "<'row'<'col'B><'col select'><'col'f>>tipr",
            buttons: [
                {
                    text: "Tambah",
                    className: "btn btn-info",
                    action: function (e, dt, node, config) {
                        window.location.href = "/products/create";
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

        $("div.select").html('<select class="form-control"></select>');

        $("select")
            .select2({
                theme: "bootstrap4",
                ajax: {
                    url: "/categories-search",
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
                placeholder: "Cari kategori",
                cache: true,
                allowClear: true,
            })
            .on("change", function () {
                dTable.draw();
            });
    });

    $("body").on("click", ".btn-delete", function (event) {
        event.preventDefault();
        var me = $(this);
        showDeleteAlert(me);
    });

    $("body").on("click", ".btn-show", function (event) {
        event.preventDefault();
        $("#modal").modal("show");

        var me = $(this),
            url = me.attr("href"),
            title = me.attr("title");

        $(".modal-title").text(title);
        $(".modal-save").remove();

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
    });
});

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
});

showErrorToast = () => {
    Toast.fire({
        icon: "error",
        title: "&nbsp;Terjadi Kesalahan!",
    });
};

showSuccessToast = (message) => {
    Toast.fire({
        icon: "success",
        title: message,
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
                    $("#product-table").DataTable().ajax.reload();
                    showSuccessToast("Data produk berhasil dihapus");
                },
                error: function (xhr) {
                    showErrorToast();
                },
            });
        }
    });
};
