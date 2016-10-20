$(document).ready(function() {
    $('#fancy_table').DataTable( {
        "order": [[ 1, "desc" ]],
        columnDefs: [
            { "sType": "title-string", "aTargets": [ 3 ],
                "targets": 3 },
            // columns.render property

            { "render": function ( data, type, row, meta ) {
                var jsDate = new Date(row[3] * 1000);
                return $.datepicker.formatDate("dd.mm.yy", jsDate);
            }
            }

//                    { "sType": "alt-string", "aTargets" : 11 }
        ],
        initComplete: function () {
            var api = this.api();
            var abc = 0;
            api.columns().indexes().flatten().each( function ( i ) {
                var column = api.column( i );
                if (i != abc) {
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.DataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                }
            } );
        }
    } );

} );