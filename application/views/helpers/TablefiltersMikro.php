<?php

class Zend_View_Helper_TablefiltersMikro extends Zend_View_Helper_Abstract
{
    public function tablefiltersMikro($diss)
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
                    {column_number : 1, filter_type: "multi_select", select_type:'chosen', filter_container_id: "external_zakaznik"},
                    {column_number: 3,  filter_type: "range_date", date_format: "dd.mm.yyyy", filter_container_id: "external_datum"}
                ]);
            });
        </script>

        <?php
    }
}