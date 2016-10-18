<?php

class Application_Model_DbTable_Prepravci extends Zend_Db_Table_Abstract
{
	//namapovanie tabuľky podľa mena z databáze pre aplikáciu
    protected $_name = 'prepravci';

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
    	$id = (int)$id;
    	$nazov = $this->fetchRow('prepravci_id = '.$id)->meno;
    	return $nazov;

    }

    //metoda vracia pole pre vypisy a formulare - id a nazov skladu
    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota['prepravci_id']] = $hodnota['meno'];
        }

        return $moznosti;
    }

    public function getPrepravca($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('prepravci_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        return $row;
    }

    public function addPrepravca($kod, $meno){
        $data = array(
            'kod' => $kod,
            'meno' => $meno,
        );
        $this->insert($data);
    }

    public function updatePrepravca($id, $kod, $meno)
    {
        $data = array(
            'kod' => $kod,
            'meno' => $meno,
        );
        $this->update($data, 'prepravci_id = '. (int)$id);
    }

}



