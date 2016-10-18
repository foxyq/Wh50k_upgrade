<?php

class Application_Model_DbTable_Mesta extends Zend_Db_Table_Abstract
{

    protected $_name = 'mesta';

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('mesta_id = '.$id)->nazov_mesta;
        return $nazov;

    }

    //metoda vracia pole pre vypisy a formulare - id a nazov skladu
    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota) {
            $moznosti[$hodnota['mesta_id']] = $hodnota['nazov_mesta'];
        }

        return $moznosti;
    }


}

