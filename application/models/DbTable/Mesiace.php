<?php

class Application_Model_DbTable_Mesiace extends Zend_Db_Table_Abstract
{

    protected $_name = 'mesiace';

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('mesiace_id = ' . $id)->nazov_mesiaca;
        return $nazov;

    }

    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota['mesiace_id']] = $hodnota['nazov_mesiaca'];
        }

        return $moznosti;
    }

    public function getIds(){
        $mesiace = $this->fetchAll()->toArray();
        $ids = array();

        foreach ($mesiace as $mesiac) {
            $ids[] = $mesiac['mesiace_id'];
        }
        return $ids;
    }


}

