<?php

class Application_Model_DbTable_Podsklady extends Zend_Db_Table_Abstract
{
	//namapovanie tabuľky podľa mena z databáze pre aplikáciu
    protected $_name = 'podsklady';

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
    	$id = (int)$id;
    	$nazov = $this->fetchRow('podsklady_id = '.$id)->nazov_podskladu;
    	return $nazov;
    }

    public function getSkratka($id)
    {
        $id = (int)$id;
        $skratkaSkladu = $this->fetchRow('podsklady_id = ' . $id)->kod_podskladu;
        return $skratkaSkladu;

    }

    public function getPodsklad($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('podsklady_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    //metoda vracia pole pre vypisy a formulare - id a nazov skladu
    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota['podsklady_id']] = $hodnota['nazov_podskladu'];
        }

        return $moznosti;
    }

    public function getIdsSoSkladIds(){
        $pole = $this->fetchAll();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota->podsklady_id]['podsklad_id'] = $hodnota->podsklady_id;
            $moznosti[$hodnota->podsklady_id]['sklad_id'] = $hodnota->sklad_enum;
        }

        return $moznosti;
    }

    public function addPodsklad($nazov, $kod, $sklad, $mesto, $adresa)
    {
        $data = array(
            'nazov_podskladu' => $nazov,
            'kod_podskladu' => $kod,
            'sklad_enum' => $sklad,
            'mesto_enum' => $mesto,
            'adresa' => $adresa
        );
        $this->insert($data);
    }

    public function updatePodsklad($id, $nazov, $kod, $sklad, $mesto, $adresa)
    {
        $data = array(
            'nazov_podskladu' => $nazov,
            'kod_podskladu' => $kod,
            'sklad_enum' => $sklad,
            'mesto_enum' => $mesto,
            'adresa' => $adresa
        );
        $this->update($data, 'podsklady_id = '. (int)$id);
    }



}

