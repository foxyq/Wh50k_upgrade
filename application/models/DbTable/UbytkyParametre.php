<?php

class Application_Model_DbTable_UbytkyParametre extends Zend_Db_Table_Abstract
{

    protected $_name = 'ubytky_parametre';

    public function getParameter($date){
        //vybere z $date z tvaru '2015-06-31' den a mesiac a oreze ich
        $den = (int)substr($date, 8, 2);
        $mesiac = (int)substr($date, 5, 2);

        $sql = "mesiac = ". $mesiac ." AND den = ". $den;
        $parameter = $this->fetchAll($sql)->toArray();
        $ubytokPercento = $parameter[0]['ubytok_percento'];

        return $ubytokPercento;

    }


}

