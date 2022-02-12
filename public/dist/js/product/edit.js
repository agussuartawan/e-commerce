$(function () {
    $(document).ready(function () {
        searchCategories();
        searchColor();
        searchFragrance();
        searchUnit();
    });

    //category
    $("body").on("click", "#add-category", function () {
        $("#modal").modal("show");
        $(".modal-title").text("Tambah Kategori");
        $(".modal-save").attr("id", "save-category");

        $.ajax({
            url: "/categories/create",
            type: "GET",
            dataType: "html",
            success: function (response) {
                $(".modal-body").html(response);
            },
            error: function (xhr, status) {
                $(".modal").modal("hide");
                alert("Terjadi kesalahan");
            },
        });
    });

    $("body").on("click", "#save-category", function () {
        event.preventDefault();

        var form = $("#form-category"),
            url = form.attr("action"),
            method = "POST",
            message = "Data kategori berhasil ditambahkan";

        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();

        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            beforeSend: function () {
                $("#save-category").attr("disabled", true);
            },
            complete: function () {
                $("#save-category").removeAttr("disabled");
            },
            success: function (response) {
                showSuccessToast(message);
                $("#modal").modal("hide");
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

    //color
    $("body").on("click", "#add-color", function () {
        $("#modal").modal("show");
        $(".modal-title").text("Tambah Warna Produk");
        $(".modal-save").attr("id", "save-color");

        $.ajax({
            url: "/color-create",
            type: "GET",
            dataType: "html",
            success: function (response) {
                $(".modal-body").html(response);
                $(".color-picker").minicolors({ theme: "bootstrap" });
            },
            error: function (xhr, status) {
                $(".modal").modal("hide");
                alert("Terjadi kesalahan");
            },
        });
    });

    $("body").on("click", "#save-color", function () {
        event.preventDefault();

        var form = $("#form-product-color"),
            url = form.attr("action"),
            method = "POST",
            message = "Data warna berhasil ditambahkan";

        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();

        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            beforeSend: function () {
                $("#save-color").attr("disabled", true);
            },
            complete: function () {
                $("#save-color").removeAttr("disabled");
            },
            success: function (response) {
                showSuccessToast(message);
                $("#modal").modal("hide");
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

    //fragrance
    $("body").on("click", "#add-fragrance", function () {
        $("#modal").modal("show");
        $(".modal-title").text("Tambah Aroma Produk");
        $(".modal-save").attr("id", "save-fragrance");

        $.ajax({
            url: "/fragrance-create",
            type: "GET",
            dataType: "html",
            success: function (response) {
                $(".modal-body").html(response);
            },
            error: function (xhr, status) {
                $(".modal").modal("hide");
                alert("Terjadi kesalahan");
            },
        });
    });

    $("body").on("click", "#save-fragrance", function () {
        event.preventDefault();

        var form = $("#form-product-fragrance"),
            url = form.attr("action"),
            method = "POST",
            message = "Data aroma berhasil ditambahkan";

        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();

        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            beforeSend: function () {
                $("#save-fragrance").attr("disabled", true);
            },
            complete: function () {
                $("#save-fragrance").removeAttr("disabled");
            },
            success: function (response) {
                showSuccessToast(message);
                $("#modal").modal("hide");
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

    //unit
    $("body").on("click", "#add-unit", function () {
        $("#modal").modal("show");
        $(".modal-title").text("Tambah Unit Produk");
        $(".modal-save").attr("id", "save-unit");

        $.ajax({
            url: "/unit-create",
            type: "GET",
            dataType: "html",
            success: function (response) {
                $(".modal-body").html(response);
            },
            error: function (xhr, status) {
                $(".modal").modal("hide");
                alert("Terjadi kesalahan");
            },
        });
    });

    $("body").on("click", "#save-unit", function () {
        event.preventDefault();

        var form = $("#form-product-unit"),
            url = form.attr("action"),
            method = "POST",
            message = "Data aroma berhasil ditambahkan";

        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();

        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            beforeSend: function () {
                $("#save-unit").attr("disabled", true);
            },
            complete: function () {
                $("#save-unit").removeAttr("disabled");
            },
            success: function (response) {
                showSuccessToast(message);
                $("#modal").modal("hide");
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

    $("#modal").on("hidden.bs.modal", function () {
        $(".modal-save").removeAttr("id");
    });

    //submit form product
    $("#form-product").on("submit", function (event) {
        event.preventDefault();
        const me = $(this),
            url = me.attr("action"),
            method = "POST",
            formData = new FormData(this);

        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();
        $("#invalid-feedback").remove();

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".btn").attr("disabled", true);
            },
            complete: function () {
                $(".btn").removeAttr("disabled");
            },
            success: function (response) {
                showSuccessToast();
                window.location.href = "/products";
            },
            error: function (xhr) {
                showErrorToast();
                var res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function (key, value) {
                        if (key === "photo") {
                            $("#" + key).addClass("is-invalid");
                            $("#photos").after(
                                "<p class='text-red' id='invalid-feedback'>Foto tidak valid!</p>"
                            );
                        } else {
                            $("#" + key)
                                .addClass("is-invalid")
                                .after(
                                    `<small class="invalid-feedback">${value}</small>`
                                );
                        }
                    });
                }
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

showSuccessToast = () => {
    Toast.fire({
        icon: "success",
        title: "Data produk berhasil disimpan.",
    });
};

showErrorToast = () => {
    Toast.fire({
        icon: "error",
        title: "&nbsp;Terjadi Kesalahan!",
    });
};

const previewImage = () => {
    const image = document.querySelector("#photo");
    const imagePreview = document.querySelector("#preview");

    imagePreview.style.display = "block";

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function (oFREvent) {
        imagePreview.src = oFREvent.target.result;
    };
};

searchCategories = () => {
    $("#category_id").select2({
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
    });
};

searchColor = () => {
    $("#product_color_id").select2({
        theme: "bootstrap4",
        ajax: {
            url: "/color-search",
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
        placeholder: "Cari warna",
        cache: true,
    });
};

searchFragrance = () => {
    $("#product_fragrance_id").select2({
        theme: "bootstrap4",
        ajax: {
            url: "/fragrance-search",
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
        placeholder: "Cari aroma",
        cache: true,
    });
};

searchUnit = () => {
    $("#product_unit_id").select2({
        theme: "bootstrap4",
        ajax: {
            url: "/unit-search",
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
        placeholder: "Cari unit",
        cache: true,
    });
};
