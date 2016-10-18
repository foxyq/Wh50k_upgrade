<?php

class Application_Model_DbTable_DokladyTypy extends Zend_Db_Table_Abstract
{

    protected $_name = 'doklady_typy';

    //metoda vracia pole pre vypisy a formulare - id a nazov skladu
    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota['doklady_typy_id']] = $hodnota['kod'];
        }

        return $moznosti;
    }

    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('doklady_typy_id = '.$id)->nazov;
        return $nazov;

    }

}

