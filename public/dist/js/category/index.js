$(function () {
    $(document).ready(function() {
        $("#category-table").DataTable({
          lengthMenu: [[5, 10, 50, 100], [5, 10, 50, 100]],
          serverSide: true,
          processing: true,
          responsive: true,
          autoWidth: false,
          order: [[ 0, "desc" ]],
          language: {
              lengthMenu: 'Tampilkan _MENU_ data',
              zeroRecords: 'Data tidak ditemukan',
              info: 'Menampilkan _START_ ke _END_ dari _TOTAL_ data',
              infoEmpty: 'Menampilkan 0 ke 0 dari 0 data',
              emptyTable: 'Tidak ada data tersedia pada tabel',
              infoFiltered: '(Difilter dari _MAX_ total data)',
              search: 'Cari:',
              paginate: {
                  first: 'Awal',
                  last: 'Akhir',
                  next: 'Selanjutnya',
                  previous: 'Sebelumnya'
              }
          },
          scroller: {
              loadingIndicator: false
          },
          pagingType: "full_numbers",
            ajax: {
                url: "categories/get-list",
              data: function (d) {
                  d.search = $('input[type="search"]').val()
              }
            },
            columns: [
                {data:'name', name: 'name'},
                {data:'action', name: 'action', orderable: false}
            ],
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-sm btn-info',
                    title: 'Produk',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-sm btn-success',
                    title: 'Produk',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-sm btn-warning',
                    title: 'Produk',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible',
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm btn-primary',
                    title: 'Produk',
                    pageSize: 'A4',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-sm btn-default',
                    title: 'Produk',
                    // orientation:'landscape',
                    pageSize: 'A4',
                    header: true,
                    footer: false,
                    orientation: 'landscape',
                    exportOptions: {
                        // columns: ':visible',
                        stripHtml: false
                    }
                }
            ],
        })
        // .buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    });
});