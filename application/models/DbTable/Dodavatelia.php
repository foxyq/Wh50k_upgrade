<?php

class Application_Model_DbTable_Dodavatelia extends Zend_Db_Table_Abstract
{
	//namapovanie tabuľky podľa mena z databáze pre aplikáciu
    protected $_name = 'dodavatelia';

    public function getDodavatel ($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('dodavatelia_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
    	$id = (int)$id;
    	$nazov = $this->fetchRow('dodavatelia_id = '.$id)->meno;
    	return $nazov;
    }

    //metoda vracia pole pre vypisy a formulare - id a nazov skladu
    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota['dodavatelia_id']] = $hodnota['meno'];
        }

        return $moznosti;
    }

    public function addDodavatel (
            $meno,
            $nazov,
            $ico,
            $ic_dph,
            $adresa,
            $interny_kod){

        $data = array(
            'meno' => $meno,
            'nazov_spolocnosti' => $nazov,
            'ico' => $ico,
            'ic_dph' => $ic_dph,
            'adresa' => $adresa,
            'interny_kod' => $interny_kod
        );

        $this->insert($data);

    }
    public function editDodavatel (
        $id,
        $meno,
        $nazov,
        $ico,
        $ic_dph,
        $adresa,
        $interny_kod){

        $data = array(
            'dodavatelia_id' => $id,
            'meno' => $meno,
            'nazov_spolocnosti' => $nazov,
            'ico' => $ico,
            'ic_dph' => $ic_dph,
            'adresa' => $adresa,
            'interny_kod' => $interny_kod
        );

        $this->update($data, 'dodavatelia_id=' . (int)$id);

    }

}

