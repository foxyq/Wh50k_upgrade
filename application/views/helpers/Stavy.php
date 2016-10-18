<?php
class Zend_View_Helper_stavy extends Zend_View_Helper_Abstract
{
public function stavy($parameter)
{
    if  ( $parameter->stav_transakcie == 2 ) {
        echo '<i class="fa fa-check-circle-o" alt="schválené"></i>';
    }
    else if ( $parameter->stav_transakcie == 1) {
        echo '<i class="fa fa-clock-o" alt="čakajúce"></i>';
    }
    else {
        echo '<i class="fa fa-times-circle-o" alt="zrušené"></i>';
    }
}
} 
?>