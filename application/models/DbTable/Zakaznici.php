<?php

class Application_Model_DbTable_Zakaznici extends Zend_Db_Table_Abstract
{

    protected $_name = 'zakaznici';

    public function getZakaznik($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('zakaznici_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('zakaznici_id = '.$id)->nazov_spolocnosti;
        return $nazov;
    }

    public function getIds()
    {
        $zakaznici = $this->fetchAll()->toArray();
        $ids = array();

        foreach ($zakaznici as $zakaznik) {
            $ids[] = $zakaznik['zakaznici_id'];
        }
        return $ids;
    }

    public function addZakaznik($meno, $nazov_spolocnosti, $merna_jednotka, $ico, $ic_dph, $adresa, $internyKod)
    {
        $data = array(
            'meno' => $meno,
            'nazov_spolocnosti' => $nazov_spolocnosti,
            'merna_jednotka_enum' => $merna_jednotka,
            'ico' => $ico,
            'ic_dph' => $ic_dph,
            'adresa' => $adresa,
            'interny_kod' => $internyKod
        );
        $this->insert($data);
    }

    public function deleteZakaznik($id)
    {
        $this->delete('zakaznici_id =' . (int)$id);
    }

    public function updateZakaznik($id, $meno, $nazov_spolocnosti, $merna_jednotka, $ico, $ic_dph, $adresa, $internyKod)
    {
        $data = array(
            'meno' => $meno,
            'nazov_spolocnosti' => $nazov_spolocnosti,
            'merna_jednotka_enum' => $merna_jednotka,
            'ico' => $ico,
            'ic_dph' => $ic_dph,
            'adresa' => $adresa,
            'interny_kod' => $internyKod
        );
        $this->update($data, 'zakaznici_id = '. (int)$id);
    }

    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota['zakaznici_id']] = $hodnota['meno'];
        }

        return $moznosti;
    }

    public function getMernaJednotka($idZakaznika)
    {
        $sql = "zakaznici_id = " . $idZakaznika;
        $zakaznici = $this->fetchAll($sql)->toArray();
        return $zakaznici[0]['merna_jednotka_enum'];
    }

    public function getCountTransactionsByStrojId($zakaznikId){
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();
        $xdodavkyModel = new Application_Model_DbTable_ExternaDodavka();

        $pocetVydajov = $vydajeModel->getRowCountByColumn('zakaznik_enum', $zakaznikId);
        $pocetXVyrob = $xvyrobyModel->getRowCountByColumn('zakaznik_enum', $zakaznikId);
        $pocetXDodaviek = $xdodavkyModel->getRowCountByColumn('zakaznik_enum', $zakaznikId);

        return $pocetVydajov + $pocetXVyrob + $pocetXDodaviek;
    }

    public function getQuantityByYearIdQuantityTypeIdZakaznikId($yearId, $zakaznikId){
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();
        $xdodavkyModel = new Application_Model_DbTable_ExternaDodavka();

        $quantityTypeId = $this->getMernaJednotka($zakaznikId);

        $sumOfVydaje = $vydajeModel->getQuantityByYearIdQuantityTypeIdColumnAndColumnValue($yearId, $quantityTypeId, 'zakaznik_enum', $zakaznikId);
        $sumOfXVyroby = $xvyrobyModel->getQuantityByYearIdQuantityTypeIdColumnAndColumnValue($yearId, $quantityTypeId, 'zakaznik_enum', $zakaznikId);
        $sumOfXDodavky = $xdodavkyModel->getQuantityByYearIdQuantityTypeIdColumnAndColumnValue($yearId, $quantityTypeId, 'zakaznik_enum', $zakaznikId);

        return $sumOfVydaje + $sumOfXDodavky + $sumOfXVyroby;

    }




}

