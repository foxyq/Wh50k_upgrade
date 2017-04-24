<?php

class Application_Model_DbTable_Sklady extends Zend_Db_Table_Abstract
{
    //namapovanie tabuľky podľa mena z databáze pre aplikáciu
    protected $_name = 'sklady';

    protected $_dependentTables = array('Prijmy');

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('sklady_id = ' . $id)->nazov_skladu;
        return $nazov;

    }

    //vracanie názvov pre výpisy
    public function getSkratka($id)
    {
        $id = (int)$id;
        $skratkaSkladu = $this->fetchRow('sklady_id = ' . $id)->skratka_skladu;
        return $skratkaSkladu;

    }

    public function getSklad($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('sklady_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    //$kod, $nazov, $skratka, $mesto, $merna_jednotka, $adresa,
    public function addSklad($kod, $nazov, $skratka, $mesto, $merna_jednotka, $adresa)
    {
        $data = array(
            'kod_skladu' => $kod,
            'nazov_skladu' => $nazov,
            'skratka_skladu' => $skratka,
            'mesto_enum' => $mesto,
            'merna_jednotka_enum' => $merna_jednotka,
            'adresa' => $adresa,
        );
        $this->insert($data);
    }

    public function updateSklad($id, $kod, $nazov, $skratka, $mesto, $merna_jednotka, $adresa)
    {
        $data = array(
            'kod_skladu' => $kod,
            'nazov_skladu' => $nazov,
            'skratka_skladu' => $skratka,
            'mesto_enum' => $mesto,
            'merna_jednotka_enum' => $merna_jednotka,
            'adresa' => $adresa,
        );
        $this->update($data, 'sklady_id = '. (int)$id);
    }

    //metoda vracia pole pre vypisy a formulare - id a nazov skladu
    public function getMoznosti()
    {
        $select = $this->select()->where('viditelnost = 1');

        $pole = $this->fetchAll($select)->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota) {
            $moznosti[$hodnota['sklady_id']] = $hodnota['nazov_skladu'];
        }

        return $moznosti;
    }

    public function getIds()
    {
        $sklady = $this->fetchAll()->toArray();
        $ids = array();

        foreach ($sklady as $sklad) {
            $ids[] = $sklad['sklady_id'];
        }
        return $ids;
    }

    public function getTonWarehousesIds(){
        //keď id tony je 1
        $sql = "merna_jednotka_enum = 1";
        $sklady = $this->fetchAll($sql)->toArray();
        $ids = array();

        foreach ($sklady as $sklad) {
            $ids[] = $sklad['sklady_id'];
        }
        return $ids;
    }

    public function getMernaJednotka($idSkladu)
    {
        $sql = "sklady_id = " . $idSkladu;
        $sklady = $this->fetchAll($sql)->toArray();
        return $sklady[0]['merna_jednotka_enum'];
    }

    public function getMernaJednotkaSkratka($idSkladu)
    {
        $merneJednotky = new Application_Model_DbTable_MerneJednotky();
        $sql = "sklady_id = " . $idSkladu;
        $sklady = $this->fetchAll($sql)->toArray();
        $skratka = $merneJednotky->getSkratka($sklady[0]['merna_jednotka_enum']);
        return $skratka;
    }

}