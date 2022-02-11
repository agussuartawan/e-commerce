$(function () {
    $(document).ready(function () {
        searchCategories();
        searchColor();
        searchFragrance();
        searchUnit();
    });
});

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
