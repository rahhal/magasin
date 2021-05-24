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

$(function() {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: lang_fr.searchPlaceholder,
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&larr;', 'previous': '&rarr;' }
        }
    });


    // Basic initialization
    $('.datatable-button-print-basic').DataTable({
        buttons: [
            {
                extend: 'print',
                text: '<i class="icon-printer position-left"></i> Print table',
                className: 'btn bg-blue'
            }
        ]
    });


    // Disable auto print
    $('.datatable-button-print-disable').DataTable({
        buttons: [
            {
                extend: 'print',
                text: '<i class="icon-printer position-left"></i> Print table',
                className: 'btn bg-blue',
                autoPrint: false
            }
        ]
    });

    $('.datatable-search-button-print-columns tfoot td').not(':last-child').each(function () {
        var title = $('.datatable-search-button-print-columns thead th').eq($(this).index()).text();
        //$(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" />');
        var html='<div class="form-group has-feedback has-feedback-left">' +
            '<input type="text" class="form-control" placeholder="البحث حسب '+title+'">' +
            '<div class="form-control-feedback">' +
            '<i class="icon-search4 text-size-base"></i>' +
            '</div>' +
            '</div>';
        $(this).html('<input type="text" class="form-control input-sm" placeholder="البحث حسب '+title+'" />');
        $(this).html(html);
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

    // Export options - column selector
    $('.datatable-button-print-columns').DataTable({
        columnDefs: [{
            targets: -1, // Hide actions column
            visible: false
        }],
        buttons: [
            {
                extend: 'print',
                text: '<i class="icon-printer position-left"></i> Print table',
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
        ]
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
