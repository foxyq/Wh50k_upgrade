<?php

class Application_Model_DbTable_MikroObjednavky extends Zend_Db_Table_Abstract
{

    protected $_name = 'objednavky_mikro';

    public function getMikroObjednavka($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('objednavky_mikro_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function getMikroObjednavkyByObjednavkaId($objednavkaId)
    {
        $objednavkaId = (int)$objednavkaId;
        $rows = $this->fetchAll('nadobjednavka_enum = ' . $objednavkaId);
        if (!$rows) {
            throw new Exception("Could not find row $objednavkaId");
        }
        return $rows;
    }

    public function getIds()
    {
        $mikroObjednavky = $this->fetchAll()->toArray();
        $ids = array();

        foreach ($mikroObjednavky as $mikroObjednavka) {
            $ids[] = $mikroObjednavka['objednavky_mikro_id'];
        }
        return $ids;
    }

    public function getKratkyPopis($id){
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

        $id = (int)$id;
        $row = $this->fetchRow('objednavky_mikro_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }

        $kratkyPopis =
            $row->datum_od_d."-".$row->datum_do_d.
            $zakazniciModel->getNazov($row->zakaznik_enum)." ".
            $row->mnozstvo.
            $merneJednotkyModel->getSkratka($row->merna_jednotka_enum);
        return $kratkyPopis;
    }

    public function addMikroObjednavka($nadobjednavka, $datum_od, $datum_do, $mnozstvo, $zakaznik, $merna_jednotka, $poznamka)
    {
        $data = array(
            'nadobjednavka_enum' => $nadobjednavka,
            'datum_od_d' => $datum_od,
            'datum_do_d' => $datum_do,
            'mnozstvo' => $mnozstvo,
            'zakaznik_enum' => $zakaznik,
            'merna_jednotka_enum' => $merna_jednotka,
            'poznamka' => $poznamka
        );
        $this->insert($data);
    }

    public function updateMikroObjednavka($id, $nadobjednavka, $datum_od, $datum_do, $mnozstvo, $zakaznik, $merna_jednotka, $poznamka)
    {
        $data = array(
            'nadobjednavka_enum' => $nadobjednavka,
            'datum_od_d' => $datum_od,
            'datum_do_d' => $datum_do,
            'mnozstvo' => $mnozstvo,
            'zakaznik_enum' => $zakaznik,
            'merna_jednotka_enum' => $merna_jednotka,
            'poznamka' => $poznamka
        );
        $this->update($data, 'objednavky_mikro_id = '. (int)$id);
    }

    public function deleteMikroObjednavka($id)
    {
        $this->delete('objednavky_mikro_id =' . (int)$id);
    }

    //kontrola ci v objednavkach existuje na toto obdobie pre tohto zakaznika objednavka - ak ano, nesmie byt nova vytvorena
    //pre validator
    //TODO
    public function existujeMikroObjednavka(/*$rok_enum, $mesiac_enum, $zakaznik_enum*/){
        //echo $rok_enum."+".$mesiac_enum."+".$zakaznik_enum;

        /*$sql = "rok_enum = ".$rok_enum." AND mesiac_enum = ".$mesiac_enum." AND zakaznik_enum = ".$zakaznik_enum;
        $objednavky = $this->fetchAll($sql);
        $pocetObjednavok = count($objednavky);
        //echo "existuje duplicita? = ".$pocetObjednavok;
        if ($pocetObjednavok > 0){
            return true;
        }else{
            return false;
        }*/
    }

     //pre validator
    //TODO
    public function existujeObjednavkaSId($objednavkaId){
        //echo $rok_enum."+".$mesiac_enum."+".$zakaznik_enum;

        /*$sql = "objednavky_id = ".$objednavkaId;
        $objednavky = $this->fetchAll($sql);
        $pocetObjednavok = count($objednavky);
        //echo "existuje duplicita? = ".$pocetObjednavok;
        if ($pocetObjednavok > 0){
            return true;
        }else{
            return false;
        }*/
    }

     //pre validator
    //TODO
    public function checkObjednavkaById($objednavkaId, $zakaznik_enum, $rok_enum, $mesiac_enum){
        //echo $rok_enum."+".$mesiac_enum."+".$zakaznik_enum;

        /*$sql = "objednavky_id = ".$objednavkaId;
        $objednavky = $this->fetchAll($sql)->toArray();
        //print_r( $objednavky[0]['zakaznik_enum']);
        if ($objednavky[0]['zakaznik_enum'] == $zakaznik_enum && $objednavky[0]['rok_enum'] == $rok_enum && $objednavky[0]['mesiac_enum'] == $mesiac_enum){
            return true;
        }else{
            return false;
        }*/
    }

    //vracia pocet objednavok kde definovane MJ je rozne od MJ zakaznika
    public function getCountNekompatibilneMikroObjednavky(){
        $sum = 0;
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $mikroObjednavky = $this->fetchAll();

        foreach ($mikroObjednavky AS $mikroObjednavka){
            if ($mikroObjednavka->merna_jednotka_enum <> $zakazniciModel->getMernaJednotka($mikroObjednavka->zakaznik_enum)){
                    $sum++;
                }
        }
        return $sum;
    }

    //vracia pocet objednavok kde definovane MJ je rozne od MJ zakaznika
    public function getCountNekompatibilneMikroObjednavkyVsObjednavky(){
        $sum = 0;
        $objednavkyModel = new Application_Model_DbTable_Objednavky();
        $mikroObjednavky = $this->fetchAll();

        foreach ($mikroObjednavky AS $mikroObjednavka){
            if ($mikroObjednavka->nadobjednavka_enum > 0) {
                $objednavka = $objednavkyModel->getObjednavka($mikroObjednavka->nadobjednavka_enum);
                if ($mikroObjednavka->merna_jednotka_enum <> $objednavka['merna_jednotka_enum']) {
                    $sum++;
                }
            }
        }
        return $sum;
    }

}

