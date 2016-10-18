<?php

class Application_Model_DbTable_MerneJednotky extends Zend_Db_Table_Abstract
{

    protected $_name = 'merne_jednotky';

    //na zaklade id vracia skratku mernej jednotky t, PRM, m3 ...
    public function getSkratka($id){

        $id = (int)$id;
    	$nazov = $this->fetchRow('merne_jednotky_id = '.$id)->skratka;
    	return $nazov;
    }

    //vracia v poli moznosti pre vypis
    public function getMoznosti(){
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota['merne_jednotky_id']] = $hodnota['skratka'];
        }

        return $moznosti;
    }

    public function getIds(){
        $merne_jednotky = $this->fetchAll()->toArray();
        $ids = array();

        foreach ($merne_jednotky as $merna_jednotka) {
            $ids[] = $merna_jednotka['merne_jednotky_id'];
        }
        return $ids;
    }

    //vracia pole s mnozstvom vo vsetkych dostupnych jednotkach prepocitanych podla konverzii definovanych druhom dreva
    //vracia pole s nasledovnymi klucmy $prepoctyArray['t'], $prepoctyArray['prm'], $prepoctyArray['m3']
    public function getPrepoctyArray($mnozstvo, $mernaJednotkaId, $materialDruhId){
        $materialDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $konverzie = $materialDruhy->getKonverzie($materialDruhId);
        $prepoctyArray = array();

        switch ($mernaJednotkaId){
            case 1:
                $prepoctyArray['t'] = $mnozstvo;
                $prepoctyArray['prm'] = $mnozstvo * $konverzie['ton_prm'];
                $prepoctyArray['m3'] = $mnozstvo * $konverzie['ton_m3'];
                break;
            case 2:
                $prepoctyArray['prm'] = $mnozstvo;
                $prepoctyArray['t'] = $mnozstvo * $konverzie['prm_ton'];
                $prepoctyArray['m3'] = $mnozstvo * $konverzie['prm_m3'];
                break;
            case 3:
                $prepoctyArray['m3'] = $mnozstvo;
                $prepoctyArray['t'] = $mnozstvo * $konverzie['m3_ton'];
                $prepoctyArray['prm'] = $mnozstvo * $konverzie['m3_prm'];
                break;
        }

        return $prepoctyArray;
    }

    public function getPrepoctyArrayDefault($mnozstvo, $mernaJednotkaId){
        $materialDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $konverzie = $materialDruhy->getKonverzieDefault();
        $prepoctyArray = array();

        switch ($mernaJednotkaId){
            case 1:
                $prepoctyArray['t'] = $mnozstvo;
                $prepoctyArray['prm'] = $mnozstvo * $konverzie['ton_prm'];
                $prepoctyArray['m3'] = $mnozstvo * $konverzie['ton_m3'];
                break;
            case 2:
                $prepoctyArray['prm'] = $mnozstvo;
                $prepoctyArray['t'] = $mnozstvo * $konverzie['prm_ton'];
                $prepoctyArray['m3'] = $mnozstvo * $konverzie['prm_m3'];
                break;
            case 3:
                $prepoctyArray['m3'] = $mnozstvo;
                $prepoctyArray['t'] = $mnozstvo * $konverzie['m3_ton'];
                $prepoctyArray['prm'] = $mnozstvo * $konverzie['m3_prm'];
                break;
        }



        return $prepoctyArray;
    }


}

