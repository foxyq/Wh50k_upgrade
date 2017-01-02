$(document).ready(function() {

        $('#fancy_table').DataTable( {
            "order": [[ 1, "desc" ]],
            columnDefs: [{ "sType": "string", "aTargets": [ 12 ]  }],

            "ajax": "../profil/ajax",
            "type": "POST",
            "columns": [
                { "data": "id" },
                { "data": "datum" },
                { "data": "sklad" },
                { "data": "podsklad" },
                { "data": "dodavatel" },
                { "data": "prepravca" },
                { "data": "tony" },
                { "data": "m3" },
                { "data": "vlhkost" },
                { "data": "nadrozmer" },
                { "data": "doklad_cislo" },
                { "data": "typ" },
                { "data": "stav" },
                { "data": "stav"}

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
                        if (i>2) {
                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        }
                        else {

                            column.data().unique().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        }
                    }
                } );
            }
        } );
    } );

