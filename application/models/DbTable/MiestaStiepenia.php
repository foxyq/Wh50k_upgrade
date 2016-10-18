<?php

class Application_Model_DbTable_MiestaStiepenia extends Zend_Db_Table_Abstract
{

    protected $_name = 'miesta_stiepenia';

     public function getMiestoStiepenia($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('miesta_stiepenia_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function getIds()
    {
        $miesta_stiepenia = $this->fetchAll()->toArray();
        $ids = array();

        foreach ($miesta_stiepenia as $miesto_stiepenia) {
            $ids[] = $miesto_stiepenia['miesta_stiepenia_id'];
        }
        return $ids;
    }

    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('miesta_stiepenia_id = ' . $id)->nazov_miesta;
        return $nazov;

    }


    public function addMiestoStiepenia($nazov)
    {
        $data = array(
            'nazov_miesta' => $nazov
        );
        $this->insert($data);
    }

    public function updateMiestoStiepenia($id, $nazov)
    {
        $data = array(
            'nazov_miesta' => $nazov
        );
        $this->update($data, 'miesta_stiepenia_id = '. (int)$id);
    }

    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota) {
            $moznosti[$hodnota['miesta_stiepenia_id']] = $hodnota['nazov_miesta'];
        }

        return $moznosti;
    }
    /*
    public function getCountTransactionsByStrojId($strojId){
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();

        $pocetVydajov = $vydajeModel->getRowCountByColumn('stroj_enum', $strojId);
        $pocetXVyrob = $xvyrobyModel->getRowCountByColumn('stroj_enum', $strojId);

        return $pocetVydajov + $pocetXVyrob;
    }
    */
}

