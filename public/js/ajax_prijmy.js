$(document).ready(function() {

    var table =  $('#fancy_table').DataTable( {
            "order": [[ 1, "desc" ]],
            columnDefs: [{ "sType": "string", "aTargets": [ 12 ]  }],
            "ajax": "getprijmy",
            "type": "POST",

            "columns": [
                { "data": "id",
                    render:
                        function ( data, type, row ) {
                            return "<a href='preview/id/"+data+"/fromAction/list'><i class='fa fa-eye'></i></a>";
                        }
                },
                { "data": "datum"
                //render: function ( data, type, row ) {
                //    var dateSplit = data.split('-');
                //    return type === "display" || type === "filter" ?
                //    dateSplit[0] +'.'+ dateSplit[1] +'.'+ dateSplit[2] :
                //        data;
                //}
                },
                { "data": "sklad" },
                { "data": "podsklad" },
                { "data": "dodavatel" },
                { "data": "prepravca" },
                { "data": "tony",
                    "className": "tonaz",
                    render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
                { "data": "m3",
                    "className": "m3",
                    render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
                { "data": "vlhkost",
                    "className": "vlhkost",
                    render: $.fn.dataTable.render.number( '.', ',', 2, '', ' %' )},
                { "data": "nadrozmer" },
                { "data": "nakupna" ,
                    "className": "nakupna",
                    render: $.fn.dataTable.render.number( '.', ',', 2, '', ' €' )},
                { "data": "predajna" ,
                    "className": "predajna",
                    render: $.fn.dataTable.render.number( '.', ',', 2, '', ' €' )},
                { "data": "doklad_cislo" },
                { "data": "typ" },
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
                    "data": "merna_jednotka",

                    render:
                        function (  data, type, row ) {
                            buttons = "<a href='edit/id/" +row.id+ "/fromAction/list'><i class='fa fa-pencil-square-o'></i></a>";                   buttons += "<a href='delete/id/" +row.id+ "/fromAction/list'> <i class='fa fa-trash-o'></i> </a>";


                            if (data == 1 ) {
                            buttons +=  '<a href="printton/id/' +row.id+ '/fromAction/errors" target="_blank"><i class="fa fa-print"></i></a>';
                            }
                            else if (data == 2 ) {
                            buttons += '<a href="printprm/id/'+row.id+'/fromAction/errors" target="_blank"><i class="fa fa-print"></i></a>';
                            }
                            else if (data == 3 ) {
                                buttons +=  '<a href="printm3/id/'+row.id+'/fromAction/errors" target="_blank"><i class="fa fa-print"></i></a>';
                            }
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
