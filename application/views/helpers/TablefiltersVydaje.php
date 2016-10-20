<?php

class Zend_View_Helper_TablefiltersVydaje extends Zend_View_Helper_Abstract
{
    public function tablefiltersVydaje($diss)
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
                    {column_number : 4, filter_type: "multi_select", select_type:'chosen', filter_container_id: "external_dodavatel"},
                    {column_number : 5, filter_type: "multi_select", select_type:'chosen', filter_container_id: "external_prepravca"},
                    {column_number: 1,  filter_type: "range_date", date_format: "yyyy.mm.dd", filter_container_id: "external_datum"}
                ]);
            });
        </script>

        <?php
    }
}