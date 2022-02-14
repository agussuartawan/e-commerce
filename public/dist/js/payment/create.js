$(function (){
    $(document).ready(function () {
        //get current date
        var today = new Date().toISOString().slice(0, 10);
        $('#date').val(today);
    });

    //submit form product
    $("#form-payment").on("submit", function (event) {
        event.preventDefault();
        Swal.fire({
            title: "Yakin melanjutkan pembayaran?",
            text: "Pastikan semua data telah di isi dengan benar!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, kirim pembayaran",
        }).then((result) => {
            const me = $(this),
                url = me.attr("action"),
                method = "POST",
                formData = new FormData(this),
                message = 'Bukti pembayaran berhasil dikirim!';

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
                    showSuccessToast(message);
                    window.location.href = `/order/${response.sale_id}/show`;
                },
                error: function (xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function (key, value) {
                            if (key === "transfer_proof") {
                                $("#" + key).addClass("is-invalid");
                                $("#photos").after(
                                    `<small class='text-danger' id='invalid-feedback'>${value}</small>`
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
});


showSuccessToast = (message) => {
    Swal.fire("Berhasil!", message, "success");
};

const previewImage = () => {
    const image = document.querySelector("#transfer_proof");
    const imagePreview = document.querySelector("#preview");

    imagePreview.style.display = "block";

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function (oFREvent) {
        imagePreview.src = oFREvent.target.result;
    };
};