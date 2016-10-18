<?php
class Zend_View_Helper_tlacbuttons extends Zend_View_Helper_Abstract
{
    public function tlacbuttons($a,$merna_jednotka, $id, $controller)
    {
       echo '<a href="'.$a->url(array("controller"=>"$controller","action"=>"delete", "id"=>$id, "fromAction" => "list")).'"> <i class="fa fa-trash-o"></i></a> ';

        echo '<a href="'.$a->url(array("controller"=>"$controller", "action"=>"edit", "id"=>$id, "fromAction" => "list")).'"><i class="fa fa-pencil-square-o"></i></a> ';


        if ($merna_jednotka == 1 ) {
            echo '<a href="' . $a->url(array("controller" => "$controller", "action" => "printton", "id" => $id, "fromAction" => "errors",
                )) . '" target="_blank"><i class="fa fa-print"></i> </a>';
        }

        else if ($merna_jednotka == 2 ) {
            echo '<a href="' . $a->url(array("controller" => "$controller", "action" => "printprm", "id" => $id, "fromAction" => "errors",
                )) . '" target="_blank"><i class="fa fa-print"></i> </a>';
        }

        else if ($merna_jednotka == 3 ) {
            echo '<a href="' . $a->url(array("controller" => "$controller", "action" => "printm3", "id" => $id, "fromAction" => "errors",
                )) . '" target="_blank"><i class="fa fa-print"></i></a>';
        }

    }
}
?>