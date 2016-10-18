<?php

class Application_Model_DbTable_TransakcieStavy extends Zend_Db_Table_Abstract
{

    protected $_name = 'transkacie_stavy';

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('transakcie_stavy_id = '.$id)->nazov;
        return $nazov;

    }

    //metoda vracia pole pre vypisy a formulare - id a nazov skladu
    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota['transakcie_stavy_id']] = $hodnota['nazov'];
        }

        return $moznosti;
    }

}

