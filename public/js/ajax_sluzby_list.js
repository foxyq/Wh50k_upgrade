$(document).ready(function() {

    var table =  $('#fancy_table').DataTable( {
            "order": [[ 1, "desc" ]],
            columnDefs: [{ "sType": "string", "aTargets": [ 8 ]  }],
            "ajax": "listajax",
            "type": "POST",

            "columns": [
                { "data": "id",
                    render:
                        function ( data, type, row ) {
                            return "<a href='preview/id/"+data+"/fromAction/list'><i class='fa fa-eye'></i></a>";
                        }
                },
                { "data": "datum_od"
                //render: function ( data, type, row ) {
                //    var dateSplit = data.split('-');
                //    return type === "display" || type === "filter" ?
                //    dateSplit[0] +'.'+ dateSplit[1] +'.'+ dateSplit[2] :
                //        data;
                //}
                },
                { "data": "datum_do" },
                { "data": "tony",
                    "className": "tonaz",
                    render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
                { "data": "prm",
                    "className": "prm",
                    render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
                { "data": "motohodiny",
                    render: $.fn.dataTable.render.number( '.', ',', 2, '', ' hod' )},
                { "data": "doklad_cislo" },
                { "data": "stav",

                    render: function ( data, type, row ) {

                        if ( data  == '2' ) {
                            return '<i class="fa fa-check-circle-o" alt="schválené"></i>';
                        }
                        else if (data == '1') {
                            return '<i class="fa fa-clock-o" alt="čakajúce"></i>';
                        }

                        else return '<i class="fa fa-times-circle-o" alt="zrušené"></i>';

                    }



                },
                {
                    "data": "stav",

                    render:
                        function (  data, type, row ) {
                            buttons = "<a href='edit/id/" +row.id+ "/fromAction/list'><i class='fa fa-pencil-square-o'></i></a>";                   buttons += "<a href='delete/id/" +row.id+ "/fromAction/list'> <i class='fa fa-trash-o'></i> </a>";

                            return String(buttons);
                        }
                }

            ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            var sDirectionClass;
            if ( aData['chyba'] == "1" )
                sDirectionClass = "danger";

            $(nRow).addClass( sDirectionClass );
            return nRow;
        },

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
