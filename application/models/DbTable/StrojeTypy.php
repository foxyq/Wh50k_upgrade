<?php

class Application_Model_DbTable_StrojeTypy extends Zend_Db_Table_Abstract
{

    protected $_name = 'stroje_typy';

    public function getNazov($id){
        $id = (int)$id;
        $nazov_kategorie = $this->fetchRow('stroje_typy_id = '.$id)->nazov_kategorie;
        return $nazov_kategorie;
    }

    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota) {
            $moznosti[$hodnota['stroje_typy_id']] = $hodnota['nazov_kategorie'];
        }
        return $moznosti;
    }


}

