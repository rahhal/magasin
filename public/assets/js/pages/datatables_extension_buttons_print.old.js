/* ------------------------------------------------------------------------------
*
*  # Buttons extension for Datatables. Print examples
*
*  Specific JS code additions for datatable_extension_buttons_print.html page
*
*  Version: 1.1
*  Latest update: Mar 6, 2016
*
* ---------------------------------------------------------------------------- */

$(function () {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: lang_fr.sFilter,
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
        }
    });


    // Basic initialization
    $('.datatable-button-print-basic').DataTable({
        buttons: [
            {
                extend: 'print',
                text: '<i class="icon-printer position-left"></i> ' + lang_fr.sPrintTable,
                className: 'btn bg-blue'
            }
        ]
    });


    // Disable auto print
    $('.datatable-button-print-disable').DataTable({
        buttons: [
            {
                extend: 'print',
                text: '<i class="icon-printer position-left"></i> ' + lang_fr.sPrintTable,
                className: 'btn bg-blue',
                autoPrint: false
            }
        ]
    });

    $('.datatable-search-button-print-columns tfoot td').not(':last-child').each(function () {
        var title = $('.datatable-search-button-print-columns thead th').eq($(this).index()).text();
        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" />');
        //$(this).html('<input type="text" class="form-control input-sm" placeholder="بحث" />');
    });
    $('.datatable-search-button-print-columns').DataTable({
        language: lang_fr,
        columnDefs: [{
            // targets: -1, // Hide actions column
            // visible: false
        }],
        buttons: [
            {
                extend: 'print',
                text: '<i class="icon-printer position-left"></i> ' + lang_fr.sPrintTable,
                className: 'btn btn-default',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                className: 'btn btn-default btn-icon'
            }
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    that.search(this.value).draw();
                });
            });
        }
    });

    $('.datatable-search-button-print-columns-select-checkbox tfoot td').not(':last-child').not(':first-child').each(function () {
        var title = $('.datatable-search-button-print-columns-select-checkbox thead th').eq($(this).index()).text();
        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" />');
    });
    $('.datatable-search-button-print-columns-select-checkbox').DataTable({
        language: lang_fr,
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        },
            {
                orderable: false,
                width: '100px',
                targets: 6
            }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        buttons: [
            {
                extend: 'print',
                className: 'btn btn-default',
                text: '<i class="icon-printer position-left"></i>',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                className: 'btn btn-default',
                text: '<i class="icon-checkmark3 position-left"></i>',
                exportOptions: {
                    columns: ':visible',
                    modifier: {
                        selected: true,

                    }
                }
            },
            // {
            //     extend: 'print',
            //     text: '<i class="icon-printer position-left"></i> ' + lang_fr.sPrintTable,
            //     className: 'btn btn-default',
            //     exportOptions: {
            //         columns: ':visible'
            //     }
            // },
            {
                extend: 'colvis',
                text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                className: 'btn btn-default btn-icon'
            }
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    that.search(this.value).draw();
                });
            });
        }
    });

    // Export options - column selector
    $('.datatable-button-print-columns').DataTable({
        columnDefs: [{
            targets: -1, // Hide actions column
            visible: false
        }],
        buttons: [
            {
                extend: 'print',
                text: '<i class="icon-printer position-left"></i> ' + lang_fr.sPrintTable,
                className: 'btn btn-default',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                className: 'btn btn-default btn-icon'
            }
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var select = $('<select class="filter-select"><option value=""></option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });


    // Export options - row selector
    $('.datatable-button-print-rows').DataTable({
        buttons: {
            buttons: [
                {
                    extend: 'print',
                    className: 'btn btn-default',
                    text: '<i class="icon-printer position-left"></i> Print all'
                },
                {
                    extend: 'print',
                    className: 'btn btn-default',
                    text: '<i class="icon-checkmark3 position-left"></i> Print selected',
                    exportOptions: {
                        modifier: {
                            selected: true
                        }
                    }
                }
            ],
        },
        select: true
    });


    // External table additions
    // ------------------------------

    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });

});
