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
            var form_id = $(this).attr("data-id");

            $(`.${form_id}`).submit();
        }
    });
});
