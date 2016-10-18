<?php
class Zend_View_Helper_prijmybuttons extends Zend_View_Helper_Abstract
{
    public function prijmybuttons($a,$prijmy_w, $prijmy_e,$controller)
    {

        echo '<p class="no-print">
                <a href="'. $a->url(array('controller'=>$controller, 'action'=>'add', 'fromAction' => 'list')).'" type="button" class="btn btn-success">';
        if ($controller == 'prijmy') echo 'Pridať príjem</a> ';
        else if ($controller == 'vydaje') echo 'Pridať výdaj</a> ';
        else echo 'Pridať novú</a> ';

        echo ' <a href="' .$a->url(array('controller'=>$controller, 'action'=>'list')).'" type="button" class="btn btn-info">Všetky </a> ' ;


    if ($prijmy_w >0) {

        echo ' <a href="' . $a->url(array('controller' => $controller, 'action' => 'waitings'), null, true) . '" type="button" class="btn btn-warning">Na schválenie (' . $prijmy_w . ')</a> ';
    }

    if ($prijmy_e > 0) {

        echo ' <a href="' . $a->url(array('controller' => $controller, 'action' => 'errors'), null, true) . '" type="button" class="btn btn-danger"> Chybné (' . $prijmy_e . ')</a> ';
    }

    echo ' <a class="btn btn-primary" href="javascript:window.print()">Tlačiť</a> </p>';

    }
}
?>