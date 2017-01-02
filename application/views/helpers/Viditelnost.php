<?php
class Zend_View_Helper_viditelnost extends Zend_View_Helper_Abstract
{
public function viditelnost($parameter)
{
    if  ($parameter == 1 ) {
        echo '<i class="fa fa-check-circle-o" alt="viditeľné" style="color:green"></i>';
        //echo "OK";
    }
    else if ( $parameter == 0) {
        echo '<i class="fa fa-times-circle-o" alt="zrušené" style="color:red"></i>';
        //echo '<i class="fa fa-clock-o" alt="čakajúce"></i>';
        //echo "NEOK";

    }
    else {
        echo '<i class="fa fa-times-circle-o" alt="neznámy stav" style="color:orange"></i>';
        //echo "XOK";

    }
}
} 
?>