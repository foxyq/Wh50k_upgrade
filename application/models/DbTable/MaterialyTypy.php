<?php

class Application_Model_DbTable_MaterialyTypy extends Zend_Db_Table_Abstract
{

    protected $_name = 'materialy_typy';

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('materialy_typy_id = '.$id)->nazov;
        return $nazov;

    }

    public function getTyp($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('materialy_typy_id = ' . $id);
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
            $moznosti[$hodnota['materialy_typy_id']] = $hodnota['nazov'];
        }

        return $moznosti;
    }

    public function addTyp($nazov, $skratka)
    {
        $data = array(
            'nazov' => $nazov,
            'skratka' => $skratka,
        );
        $this->insert($data);
    }

    public function updateTyp($id, $nazov, $skratka)
    {
        $data = array(
            'nazov' => $nazov,
            'skratka' => $skratka,
        );
        $this->update($data, 'materialy_typy_id = '. (int)$id);
    }

}

