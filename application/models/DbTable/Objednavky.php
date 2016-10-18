<?php

class Application_Model_DbTable_Objednavky extends Zend_Db_Table_Abstract
{

    protected $_name = 'objednavky';

    public function getObjednavka($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('objednavky_id = ' . $id);
        if (!$row) {
            //throw new Exception("Could not find row $id");
            return null;
        }
        return $row->toArray();
    }

    public function getIds()
    {
        $objednavky = $this->fetchAll()->toArray();
        $ids = array();

        foreach ($objednavky as $objednavka) {
            $ids[] = $objednavka['objednavky_id'];
        }
        return $ids;
    }

    public function getKratkyPopis($id){
        $rokyModel = new Application_Model_DbTable_Roky();
        $mesiaceModel = new Application_Model_DbTable_Mesiace();
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

        $id = (int)$id;
        $row = $this->fetchRow('objednavky_id = ' . $id);
        if (!$row) {
            //throw new Exception("Could not find row $id");
            return "žiadny popis nie je k dispozícii";
        }

        $kratkyPopis =
            $rokyModel->getNazov($row->rok_enum)."/".
            $mesiaceModel->getNazov($row->mesiac_enum)." ".
            $zakazniciModel->getNazov($row->zakaznik_enum)." ".
            $row->mnozstvo.
            $merneJednotkyModel->getSkratka($row->merna_jednotka_enum);
        if ($kratkyPopis == null){
            return "žiadny";
        }else {
            return $kratkyPopis;
        }
    }

    public function getMoznosti()
    {
        $pole = $this->fetchAll();
        $moznosti = array();

        $rokyModel = new Application_Model_DbTable_Roky();
        $mesiaceModel = new Application_Model_DbTable_Mesiace();
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

        foreach ($pole as $hodnota){
            //$moznosti[$hodnota['objednavky_id']] = $hodnota['meno'];

            $moznosti[$hodnota['objednavky_id']] =
                $hodnota['objednavky_id']."-".
                $rokyModel->getNazov($hodnota['rok_enum'])."."
                .$mesiaceModel->getNazov($hodnota['mesiac_enum'])." "
                .$zakazniciModel->getNazov($hodnota['zakaznik_enum'])." "
                .number_format($hodnota['mnozstvo'], 2, ",", " ")
                .$merneJednotkyModel->getSkratka($hodnota['merna_jednotka_enum']);
        }

        return $moznosti;
    }

    //$zakaznik, $rok, $mesiac, $mnozstvo, $merna_jednotka, $poznamka
    public function addObjednavka($zakaznik, $rok, $mesiac, $mnozstvo, $merna_jednotka, $poznamka)
    {
        $data = array(
            'rok_enum' => $rok,
            'mesiac_enum' => $mesiac,
            'mnozstvo' => $mnozstvo,
            'zakaznik_enum' => $zakaznik,
            'merna_jednotka_enum' => $merna_jednotka,
            'poznamka' => $poznamka
        );
        $this->insert($data);
    }

    //$zakaznik, $rok, $mesiac, $mnozstvo, $merna_jednotka, $poznamka
    public function updateObjednavka($id, $zakaznik, $rok, $mesiac, $mnozstvo, $merna_jednotka, $poznamka)
    {
        $data = array(
            'rok_enum' => $rok,
            'mesiac_enum' => $mesiac,
            'mnozstvo' => $mnozstvo,
            'zakaznik_enum' => $zakaznik,
            'merna_jednotka_enum' => $merna_jednotka,
            'poznamka' => $poznamka
        );
        $this->update($data, 'objednavky_id = '. (int)$id);
    }

    public function deleteObjednavka($id)
    {
        $this->delete('objednavky_id =' . (int)$id);
    }

    //kontrola ci v objednavkach existuje na toto obdobie pre tohto zakaznika objednavka - ak ano, nesmie byt nova vytvorena
    //pre validator
    public function existujeObjednavka($rok_enum, $mesiac_enum, $zakaznik_enum){
        //echo $rok_enum."+".$mesiac_enum."+".$zakaznik_enum;
        $sql = "rok_enum = ".$rok_enum." AND mesiac_enum = ".$mesiac_enum." AND zakaznik_enum = ".$zakaznik_enum;
        $objednavky = $this->fetchAll($sql);
        $pocetObjednavok = count($objednavky);
        //echo "existuje duplicita? = ".$pocetObjednavok;
        if ($pocetObjednavok > 0){
            return true;
        }else{
            return false;
        }
    }

     //pre validator
    public function existujeObjednavkaSId($objednavkaId){
        //echo $rok_enum."+".$mesiac_enum."+".$zakaznik_enum;
        $sql = "objednavky_id = ".$objednavkaId;
        $objednavky = $this->fetchAll($sql);
        $pocetObjednavok = count($objednavky);
        //echo "existuje duplicita? = ".$pocetObjednavok;
        if ($pocetObjednavok > 0){
            return true;
        }else{
            return false;
        }
    }

     //pre validator
    public function checkObjednavkaById($objednavkaId, $zakaznik_enum, $rok_enum, $mesiac_enum){
        //echo $rok_enum."+".$mesiac_enum."+".$zakaznik_enum;
        $sql = "objednavky_id = ".$objednavkaId;
        $objednavky = $this->fetchAll($sql)->toArray();
        //print_r( $objednavky[0]['zakaznik_enum']);
        if ($objednavky[0]['zakaznik_enum'] == $zakaznik_enum && $objednavky[0]['rok_enum'] == $rok_enum && $objednavky[0]['mesiac_enum'] == $mesiac_enum){
            return true;
        }else{
            return false;
        }
    }

    //vracia pocet objednavok kde definovane MJ je rozne od MJ zakaznika
    public function getCountNekompatibilneObjednavky(){
        $sum = 0;
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $objednavky = $this->fetchAll();

        foreach ($objednavky AS $objednavka){
            if ($objednavka->merna_jednotka_enum <> $zakazniciModel->getMernaJednotka($objednavka->zakaznik_enum)){
                    $sum++;
                }
        }
        return $sum;
    }


}

