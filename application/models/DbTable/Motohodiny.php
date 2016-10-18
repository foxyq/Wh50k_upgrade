<?php

class Application_Model_DbTable_Motohodiny extends Zend_Db_Table_Abstract
{

    protected $_name = 'motohodiny';

    public function getMotohodina($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('motohodiny_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function getMotohodinaByRokIdMesiacIdStrojId($rokId, $mesiacId, $strojId)
    {
        $rokId = (int)$rokId;
        $mesiacId = (int)$mesiacId;
        $strojId = (int)$strojId;

        $row = $this->fetchRow('rok_enum = ' . $rokId .' && mesiac_enum = '. $mesiacId . ' && stroj_enum = '. $strojId);
        if (!$row) {
            return null;
            //throw new Exception("Could not find row");
        }
        return $row->toArray();
    }

    public function addMotohodina($stroj, $rok, $mesiac, $pocetHodin)
    {
        $data = array(
            'rok_enum' => $rok,
            'mesiac_enum' => $mesiac,
            'pocet_hodin' => $pocetHodin,
            'stroj_enum' => $stroj
        );
        $this->insert($data);
    }

    public function updateMotohodina($id, $stroj, $rok, $mesiac, $pocetHodin)
    {
        $data = array(
            'rok_enum' => $rok,
            'mesiac_enum' => $mesiac,
            'pocet_hodin' => $pocetHodin,
            'stroj_enum' => $stroj
        );
        $this->update($data, 'motohodiny_id = '. (int)$id);
    }

    public function deleteMotohodina($id)
    {
        $this->delete('motohodiny_id =' . (int)$id);
    }

    //kontrola ci v motohodinach existuje na toto obdobie pre tento strojmotohodina - ak ano, nesmie byt nova vytvorena
    //pre validator
    public function existujeMotohodina($rok_enum, $mesiac_enum, $stroj_enum){
        $sql = "rok_enum = ".$rok_enum." AND mesiac_enum = ".$mesiac_enum." AND stroj_enum = ".$stroj_enum;
        $motohodiny = $this->fetchAll($sql);
        $pocetMotohodin = count($motohodiny);
        if ($pocetMotohodin > 0){
            return true;
        }else{
            return false;
        }
    }

     //pre validator
    public function existujeMotohodinaSId($motohodinaId){
        $sql = "motohodiny_id = ".$motohodinaId;
        $motohodiny = $this->fetchAll($sql);
        $pocetMotohodin = count($motohodiny);
        if ($pocetMotohodin > 0){
            return true;
        }else{
            return false;
        }
    }

     //pre validator
    public function checkMotohodinaById($motohodinaId, $stroj_enum, $rok_enum, $mesiac_enum){
        $sql = "motohodiny_id = ".$motohodinaId;
        $motohodiny = $this->fetchAll($sql)->toArray();
        if ($motohodiny[0]['stroj_enum'] == $stroj_enum && $motohodiny[0]['rok_enum'] == $rok_enum && $motohodiny[0]['mesiac_enum'] == $mesiac_enum){
            return true;
        }else{
            return false;
        }
    }


}

