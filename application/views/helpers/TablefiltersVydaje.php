<?php

class Zend_View_Helper_TablefiltersVydaje extends Zend_View_Helper_Abstract
{
    public function tablefiltersVydaje($diss, $parameter)
    {
        ?>

        <link href='<?php echo $diss->baseUrl()."/css/jquery.dataTables.yadcf.css"?>' rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href='<?php echo $diss->baseUrl()."/css/chosen.min.css"?>' />

        <script src="<?php echo $diss->baseUrl().'/js/jquery.dataTables.yadcf.js'?>"></script>
        <script src="<?php echo $diss->baseUrl().'/js/chosen.jquery.min.js'?>"></script>
        <script src="<?php echo $diss->baseUrl().'/js/jquery-ui.js'?>"></script>

        <script>
            $(document).ready(function(){
                $('#fancy_table').dataTable().yadcf([
                    // {column_number : 1},
                    {column_number : 2, filter_type: "multi_select", select_type:'chosen', filter_container_id: "external_lokalita"},
                    {column_number : 3, filter_type: "multi_select", select_type:'chosen', filter_container_id: "external_sklad"},
                    {column_number : 4, filter_type: "multi_select", select_type:'chosen', filter_container_id: "external_<?php echo $parameter ?>"},
                    {column_number : 5, filter_type: "multi_select", select_type:'chosen', filter_container_id: "external_prepravca"},
                    {column_number: 1,  filter_type: "range_date", date_format: "yyyy.mm.dd", filter_container_id: "external_datum"}
                ]);
            });
        </script>

        <div class="row">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-arrow-down" aria-hidden="true"></i>
                            <a data-toggle="collapse" href="#collapse1">Rozšírené filtrovanie</a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <div class="panel-body">


                            <div class="col-md-3">
                                Rozsah dátumov:
                                <div id="external_datum" > </div>
                            </div>

                            <div class="col-md-2">
                                Lokalita:
                                <div id="external_lokalita" style="width: 120%" > </div>
                            </div>

                            <div class="col-md-2">
                                Sklad:
                                <div id="external_sklad" style="width: 120%" > </div>
                            </div>

                            <div class="col-md-2">
                                <?php echo $parameter ?>
                                <div id="external_<?php echo $parameter ?>" style="width: 120%" > </div>
                            </div>

                            <div class="col-md-2">
                                Prepravca:
                                <div id="external_prepravca" style="width: 120%" > </div>
                            </div>

                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </div>
            </div>
        </div>


        <?php
    }
}