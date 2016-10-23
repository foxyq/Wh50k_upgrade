<?php

class Zend_View_Helper_TablefiltersExterne extends Zend_View_Helper_Abstract
{
    public function tablefiltersExterne($diss, $parameter)
    {
        ?>

        <link href='<?php echo $diss->baseUrl()."/css/jquery.dataTables.yadcf.css"?>' rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href='<?php echo $diss->baseUrl()."/css/chosen.min.css"?>' />

        <script src="<?php echo $diss->baseUrl().'/js/jquery.dataTables.yadcf.js'?>"></script>
        <script src="<?php echo $diss->baseUrl().'/js/chosen.jquery.min.js'?>"></script>
        <script src="<?php echo $diss->baseUrl().'/js/jquery-ui.js'?>"></script>

        <script>

            var parameter = "<?php echo $parameter?>";

            $(document).ready(function(){
                $('#fancy_table').dataTable().yadcf([
                    // {column_number : 1},
                    {column_number : 2, filter_type: "multi_select", select_type:'chosen', filter_container_id: "external_zakaznik"},
                    {column_number : 3, filter_type: "multi_select", select_type:'chosen', filter_container_id: "external_dodavatel"},
                    {column_number: 1,  filter_type: "range_date", date_format: "yyyy.mm.dd", filter_container_id: "external_datum"},

//                    if ("dodavka".equals(parameter))
                    {column_number : 4, filter_type: "multi_select", select_type:"chosen", filter_container_id: "external_prepravca"},
                    {column_number : 5, filter_type: "multi_select", select_type:"chosen", filter_container_id: "external_stroj"},
                    {column_number : 6, filter_type: "multi_select", select_type:"chosen", filter_container_id: "external_miesto"}

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

                        <div class="row">
                            <div class="col-md-3">
                                Rozsah dátumov:
                                <div id="external_datum" > </div>
                            </div>

                            <div class="col-md-2">
                                Zakazník:
                                <div id="external_zakaznik" style="width: 120%" > </div>
                            </div>

                            <div class="col-md-2">
                                Dodávateľ:
                                <div id="external_dodavatel" style="width: 120%" > </div>
                            </div>

                            <div class="col-md-2">
                                Prepravca:
                                <div id="external_prepravca" style="width: 120%" > </div>
                            </div>
                        </div>

<!--                            ak ide o externu dodavku, skry(i?) stroj a miesto -->
                          <div class="row <?php   if (strcmp("dodavka",$parameter) == 0){ echo "hidden";}?>">
                                <div class="col-md-2">
                                    Stroj
                                    <div id="external_stroj" style="width: 120%" > </div>
                                </div>

                                <div class="col-md-2">
                                    Miesto štiepenia
                                    <div id="external_miesto" style="width: 120%" > </div>
                                </div>
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