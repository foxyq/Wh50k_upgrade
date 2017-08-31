<?php

class Application_Model_DbTable_Sluzby extends Zend_Db_Table_Abstract
{

    protected $_name = 't_sluzby';

    public function addSluzba(
        $datum_sluzby_od,
        $datum_sluzby_do,
        $zakaznik,
        $miesto_stiepenia,
        $stroj,
        $q_tony,
        $q_prm,
        $q_motohodiny,
        $doklad_typ,
        $poznamka,
        $chyba,
        $stav_transakcie,
        $doklad_cislo){

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];

        $data = array(
            'datum_sluzby_od_d' => $datum_sluzby_od,
            'datum_sluzby_do_d' => $datum_sluzby_do,
            'zakaznik_enum' => $zakaznik,
            'miesto_stiepenia' => $miesto_stiepenia,
            'stroj_enum' => $stroj,
            'q_tony' => $q_tony,
            'q_prm' => $q_prm,
            'q_motohodiny' => $q_motohodiny,
            'poznamka' => $poznamka,
            'chyba' => $chyba,
            'doklad_typ_enum' => $doklad_typ,
            'stav_transakcie' => $stav_transakcie,
            'doklad_cislo' => $doklad_cislo,
            'vytvoril_u' => $identity,
            'posledna_uprava_u' => $identity,


        );
//        var_dump( $data);
        $this->insert($data);
    }

    public function editSluzba(
        $id,
        $datum_sluzby_od,
        $datum_sluzby_do,
        $zakaznik,
        $miesto_stiepenia,
        $stroj,
        $q_tony,
        $q_prm,
        $q_motohodiny,
        $doklad_typ,
        $poznamka,
        $chyba,
        $stav_transakcie){

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];

        $data = array(
            'datum_sluzby_od_d' => $datum_sluzby_od,
            'datum_sluzby_do_d' => $datum_sluzby_do,
            'zakaznik_enum' => $zakaznik,
            'miesto_stiepenia' => $miesto_stiepenia,
            'stroj_enum' => $stroj,
            'q_tony' => $q_tony,
            'q_prm' => $q_prm,
            'q_motohodiny' => $q_motohodiny,
            'poznamka' => $poznamka,
            'chyba' => $chyba,
            'doklad_typ_enum' => $doklad_typ,
            'stav_transakcie' => $stav_transakcie,
            'vytvoril_u' => $identity,
            'posledna_uprava_u' => $identity,

            'vytvoril_u' => self::getAutor($id),
            'posledna_uprava_u' => $identity

        );
        $this->update($data, 't_sluzby_id ='. (int)$id);
    }

    public function deleteSluzba($id)
    {
        $this->delete('t_sluzby_id =' . (int)$id);
    }

    //get SUM of column1 by column2

    public function getSluzba($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('t_sluzby_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function getAutor($id){
        $id = (int)$id;
        $row = $this->fetchRow('t_sluzby_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        return $row['vytvoril_u'];
    }
    //toto nie je optimalne pri velkom mnozstve dat to bude dlho trvat
    public function getSumByColumn($column1, $column2, $column2_value){
        $sluzby = $this->fetchAll($column2.' = '. $column2_value);
        $sum = 0;
        foreach ($sluzby as $sluzba){
            $sum = $sum + $sluzba[$column1];
        }
        return $sum;
    }

    //get Count of rows where column equals $column_value
    //toto nie je optimalne pri velkom mnozstve dat to bude dlho trvat
    public function getRowCountByColumn($column, $column_value){
        $sluzby = $this->fetchAll($column.' = '. $column_value . ' AND stav_transakcie = 2');
        $rowCount = count($sluzby);
        return $rowCount;
    }

    //get SUM of column1 by column2 (date) and column3 (stock)
    public function getSumByDateAndStock($column1, $column2, $column2_value, $column3, $column3_value){
        $sluzby = $this->fetchAll($column2." = '".$column2_value."' AND ".$column3." = ".$column3_value." AND stav_transakcie = 2");
        $sum = 0;
        foreach ($sluzby as $sluzba){
            $sum = $sum + $sluzba[$column1];
        }
        return $sum;
    }

    //$column1 - co sledujeme
    //$column2 - parametre od do
    //$column3 - goup by - standardne id skladu
    public function getSumByColumnBetween($column1, $column2, $column2_value1, $column2_value2, $column3, $column3_value1){

        if ($column2_value1 > $column2_value2){
            $pomocna = $column2_value2;
            $column2_value2 = $column2_value1;
            $column2_value1 = $pomocna;
        }

        $sql = $column3." = ".$column3_value1." AND (".$column2." BETWEEN '".$column2_value1."' AND '".$column2_value2."')";
        $sluzby = $this->fetchAll($sql);

        $sum = 0;
        foreach ($sluzby as $sluzba){
            $sum = $sum + $sluzba[$column1];
        }
        return $sum;
    }


    //$column1 - co sledujeme
    //$column2 - parametre od do
    //$column3 - goup by - standardne id skladu
    public function getSubmittedSumByColumnBetween($column1, $column2, $column2_value1, $column2_value2, $column3, $column3_value1){

        if ($column2_value1 > $column2_value2){
            $pomocna = $column2_value2;
            $column2_value2 = $column2_value1;
            $column2_value1 = $pomocna;
        }

        $sql = $column3." = ".$column3_value1." AND (".$column2." BETWEEN '".$column2_value1."' AND '".$column2_value2."') AND stav_transakcie = 2";
        $sluzby = $this->fetchAll($sql);

        $sum = 0;
        foreach ($sluzby as $sluzba){
            $sum = $sum + $sluzba[$column1];
        }
        return $sum;
    }

    public function getNumberOfErrors(){
        $select = $this->select();
        $select->from($this, array('count(*) as amount'))->where("chyba = 1");
        $rows = $this->fetchAll($select);

        return($rows[0]->amount);
    }

    public function getNumberOfWaitings(){
        $select = $this->select();
        $select->from($this, array('count(*) as amount'))->where("stav_transakcie = 1");
        $rows = $this->fetchAll($select);

        return($rows[0]->amount);
    }

    public function markAsError($id){

        $id = (int) $id;
        $data = array('chyba'=>1);
        $this->update($data, 't_sluzby_id ='. (int)$id);
    }

    public function getQuantityByYearIdQuantityTypeIdColumnAndColumnValue($yearId, $quantityTypeId, $columnName, $columnValue){
        //definicia od do datumov pre sql
        $rokyModel = new Application_Model_DbTable_Roky();
        $year = $rokyModel->getNazov($yearId);
        $dateFrom = "'".$year."-01-01'";
        $dateTo = "'".$year."-12-31'";

        //definicia pocitaneho typu kvantity
        $column = 'q_tony_merane';
        switch ($quantityTypeId){
            case 1:
                $column = 'q_tony_merane';
                break;
            case 2:
                $column = 'q_prm_merane';
                break;
            case 3:
                $column = 'q_m3_merane';
                break;
        }

        //SQL dotaz
        $sql = $columnName." = ".$columnValue." AND (datum_sluzby_od_d BETWEEN ".$dateFrom." AND ".$dateTo.") AND stav_transakcie = 2";
        $sluzby = $this->fetchAll($sql);

        //SUMA v definovanom stlpci
        $sum = 0;
        foreach ($sluzby as $sluzba){
            $sum = $sum + $sluzba[$column];
        }
        return $sum;



    }

    public function getDokladyCislaByDate($date){
        $sql = "datum_sluzby_od_d = '".$date."'";
        $sluzby = $this->fetchAll($sql);
        $cislaDokladovArray = array();
        $counter = 0;

        foreach ($sluzby AS $sluzba){
            $cislaDokladovArray[$counter] = $sluzba->doklad_cislo;
            $counter++;
        }

        return $cislaDokladovArray;
    }

    public function getSubmittedSumByColumn($column1, $column2, $column2_value){
        $sluzby = $this->fetchAll($column2.' = '.$column2_value. " AND stav_transakcie = 2");
        $sum = 0;
        foreach ($sluzby as $sluzba){
            $sum = $sum + $sluzba[$column1];
        }
        return $sum;
    }

    public function getSluzbaFormatted($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('t_sluzby_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        $row['q_tony']=number_format($row['q_tony'], 2, ",", "");
        $row['q_prm']=number_format($row['q_prm'], 2, ",", "");
        $row['q_motohodiny']=number_format($row['q_motohodiny'], 2, ",", "");



        return $row;
    }

    public function getSluzbyAjax()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $stmt = $db->query(
            'SELECT
            t_sluzby_id AS id,
            datum_sluzby_od_d AS datum_od,
            datum_sluzby_do_d AS datum_do,
            q_tony AS tony,
            q_prm AS prm,
            q_motohodiny AS motohodiny,
            doklad_cislo AS doklad_cislo,
            miesto_stiepenia AS miesto,
            chyba AS chyba,
            stav_transakcie AS stav
            FROM
            `t_sluzby`'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function getSluzbyErrorsAjax()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $stmt = $db->query(
            'SELECT
            t_sluzby_id AS id,
            datum_sluzby_od_d AS datum_od,
            datum_sluzby_do_d AS datum_do,
            q_tony AS tony,
            q_prm AS prm,
            q_motohodiny AS motohodiny,
            doklad_cislo AS doklad_cislo,
            miesto_stiepenia AS miesto,
            chyba AS chyba,
            stav_transakcie AS stav
            FROM
            `t_sluzby`
            WHERE chyba=1'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function getSluzbyWaitingsAjax()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $stmt = $db->query(
            'SELECT
            t_sluzby_id AS id,
            datum_sluzby_od_d AS datum_od,
            datum_sluzby_do_d AS datum_do,
            q_tony AS tony,
            q_prm AS prm,
            q_motohodiny AS motohodiny,
            doklad_cislo AS doklad_cislo,
            miesto_stiepenia AS miesto,
            chyba AS chyba,
            stav_transakcie AS stav
            FROM
            `t_sluzby`
            WHERE stav_transakcie=1'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


}

