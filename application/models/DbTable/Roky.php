<?php

class Application_Model_DbTable_Roky extends Zend_Db_Table_Abstract
{

    protected $_name = 'roky';

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('roky_id = ' . $id)->nazov_roku;
        return $nazov;

    }


    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota['roky_id']] = $hodnota['nazov_roku'];
        }

        return $moznosti;
    }

    public function getIds(){
        $roky = $this->fetchAll()->toArray();
        $ids = array();

        foreach ($roky as $rok) {
            $ids[] = $rok['roky_id'];
        }
        return $ids;
    }


}

