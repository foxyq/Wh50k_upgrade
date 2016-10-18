<?php

class Application_Model_DbTable_Stroje extends Zend_Db_Table_Abstract
{

    protected $_name = 'stroje';

    public function getStroj($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('stroje_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function getIds()
    {
        $stroje = $this->fetchAll()->toArray();
        $ids = array();

        foreach ($stroje as $stroj) {
            $ids[] = $stroj['stroje_id'];
        }
        return $ids;
    }

    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('stroje_id = ' . $id)->nazov_stroja;
        return $nazov;

    }

    public function getTyp($id)
    {
        $id = (int)$id;
        $typ = $this->fetchRow('stroje_id = ' . $id)->typ_stroja;
        return $typ;

    }

    public function addStroj($nazov, $typ)
    {
        $data = array(
            'nazov_stroja' => $nazov,
            'typ_stroja' => $typ,
        );
        $this->insert($data);
    }

    public function updateStroj($id, $nazov, $typ)
    {
        $data = array(
            'nazov_stroja' => $nazov,
            'typ_stroja' => $typ,
        );
        $this->update($data, 'stroje_id = '. (int)$id);
    }

    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota) {
            $moznosti[$hodnota['stroje_id']] = $hodnota['nazov_stroja'];
        }

        return $moznosti;
    }

    public function getCountTransactionsByStrojId($strojId){
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();

        $pocetVydajov = $vydajeModel->getRowCountByColumn('stroj_enum', $strojId);
        $pocetXVyrob = $xvyrobyModel->getRowCountByColumn('stroj_enum', $strojId);

        return $pocetVydajov + $pocetXVyrob;
    }

    public function getQuantitiesByYearIdStrojId($yearId, $strojId){
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();

        $sumsOfVydaje = $vydajeModel->getQuantitiesByYearIdColumnAndColumnValue($yearId, 'stroj_enum', $strojId);
        $sumsOfXVyroby = $xvyrobyModel->getQuantitiesByYearIdColumnAndColumnValue($yearId, 'stroj_enum', $strojId);

        $sums = array(
            'q_tony_merane' => $sumsOfVydaje['q_tony_merane'] + $sumsOfXVyroby['q_tony_merane'],
            'q_prm_merane' => $sumsOfVydaje['q_prm_merane'] + $sumsOfXVyroby['q_prm_merane'],
            'q_m3_merane' => $sumsOfVydaje['q_m3_merane'] + $sumsOfXVyroby['q_m3_merane']
        );

        return $sums;
    }

    public function getQuantitiesByYearIdMonthIdStrojId($yearId, $monthId, $strojId){
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();

        $sumsOfVydaje = $vydajeModel->getQuantitiesByYearIdMonthIdColumnAndColumnValue($yearId, $monthId, 'stroj_enum', $strojId);
        $sumsOfXVyroby = $xvyrobyModel->getQuantitiesByYearIdMonthIdColumnAndColumnValue($yearId, $monthId, 'stroj_enum', $strojId);

        $sums = array(
            'q_tony_merane' => $sumsOfVydaje['q_tony_merane'] + $sumsOfXVyroby['q_tony_merane'],
            'q_prm_merane' => $sumsOfVydaje['q_prm_merane'] + $sumsOfXVyroby['q_prm_merane'],
            'q_m3_merane' => $sumsOfVydaje['q_m3_merane'] + $sumsOfXVyroby['q_m3_merane']
        );

        return $sums;
    }

}

