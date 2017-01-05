$(document).ready(function() {


    //render : function (data, type, row) {
    //return "<a href="+'"'+ "'<?php echo $this->url(array("+"'controller'=>'prijmy','action'=>'preview', 'id'=>$prijem->doklad_cislo, 'fromAction' => 'list'));?>"+'" '+"<i class='fa fa-eye'></i></a>";
    //return "<a href='preview/id/"+data_doklad_cislo+"/fromAction/list'><i class='fa fa-eye'></i></a>";
    //}

    //jQuery.fn.dataTable.render.ellipsis = function ( data ) {
    //
    //
    //    return 'deved';
    //
    //};

        $('#fancy_table').DataTable( {
            "order": [[ 1, "desc" ]],
            columnDefs: [{ "sType": "string", "aTargets": [ 12 ]  }],

            "ajax": "../profil/ajax",
            "type": "POST",
            "columns": [
                { "data": "id",
                    render:
                        function ( data, type, row ) {
                            return "<a href='preview/id/"+data+"/fromAction/list'><i class='fa fa-eye'></i></a>";
                        }

                    //render: $.fn.dataTable.render.ellipsis( data )
                },
                { "data": "datum"
                , render: function ( data, type, row ) {
                    var dateSplit = data.split('-');
                    return type === "display" || type === "filter" ?
                    dateSplit[0] +'.'+ dateSplit[1] +'.'+ dateSplit[2] :
                        data;
                }
                },
                { "data": "sklad" },
                { "data": "podsklad" },
                { "data": "dodavatel" },
                { "data": "prepravca" },
                { "data": "tony" },
                { "data": "m3" },
                { "data": "vlhkost"
                    //,
                    //render: function ( data, type, row ) {
                    //    return  data + ' %';
                    //}
                },
                { "data": "nadrozmer" },
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
                            buttons = "<a href='edit/id/" +row.id+ "/fromAction/list'> <i class='fa fa-pencil-square-o'></i>   </a>";                   buttons += "<a href='delete/id/" +row.id+ "/fromAction/list'> <i class='fa fa-trash-o'></i> </a>";


                            if (data == 1 ) {
                            buttons +=  ' <a href="printton/id/' +row.id+ '/fromAction/errors" target="_blank"><i class="fa fa-print"></i> </a>';
                            }
                            else if (data == 2 ) {
                            buttons += ' <a href="printprm/id/'+row.id+'/fromAction/errors" target="_blank"><i class="fa fa-print"></i> </a>';
                            }
                            else if (data == 3 ) {
                                buttons +=  '<a href="printm3/id/'+row.id+'/fromAction/errors" target="_blank"><i class="fa fa-print"></i> </a>';
                            }
                            return String(buttons);
                        }
                }

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

