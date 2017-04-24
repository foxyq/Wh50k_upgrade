<?php

class Application_Model_DbTable_Inventury extends Zend_Db_Table_Abstract
{
    //metody modelu vychadzaju z modelu Vydajov

    protected $_name = 'ts_inventury';

    public function addInventura(
        $datum_inventury,
        $sklad,
        $podsklad,
        $q_tony_merane,
        $q_m3_merane,
        $q_prm_merane,
        $q_vlhkost,
        $doklad_typ,
        $poznamka,
        $chyba,
        $stav_transakcie,
        $doklad_cislo){

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];

        $data = array(
            'datum_inventury_d' => $datum_inventury,
            'sklad_enum' => $sklad,
            'podsklad_enum' => $podsklad,
            'q_tony_merane' => $q_tony_merane,
            'q_m3_merane' => $q_m3_merane,
            'q_prm_merane' => $q_prm_merane,
            'q_vlhkost' => $q_vlhkost,
            'doklad_typ_enum' => $doklad_typ,
            'poznamka' => $poznamka,
            'chyba' => $chyba,
            'stav_transakcie' => $stav_transakcie,
            'doklad_cislo' => $doklad_cislo,
            'vytvoril_u' => $identity,
            'posledna_uprava_u' => $identity,


        );
//        var_dump( $data);
        $this->insert($data);
    }

    public function editInventura(
        $id,
        $datum_inventury,
        $sklad,
        $podsklad,
        $q_tony_merane,
        $q_m3_merane,
        $q_prm_merane,
        $q_vlhkost,
        $doklad_typ,
        $poznamka,
        $chyba,
        $stav_transakcie){

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];

        $data = array(
            'datum_inventury_d' => $datum_inventury,
            'sklad_enum' => $sklad,
            'podsklad_enum' => $podsklad,
            'q_tony_merane' => $q_tony_merane,
            'q_m3_merane' => $q_m3_merane,
            'q_prm_merane' => $q_prm_merane,
            'q_vlhkost' => $q_vlhkost,
            'doklad_typ_enum' => $doklad_typ,
            'poznamka' => $poznamka,
            'chyba' => $chyba,
            'stav_transakcie' => $stav_transakcie,

            'vytvoril_u' => self::getAutor($id),
            'posledna_uprava_u' => $identity

        );
        $this->update($data, 'ts_inventury_id ='. (int)$id);
    }

    public function deleteInventura($id)
    {
        $this->delete('ts_inventury_id =' . (int)$id);
    }

    //get SUM of column1 by column2

    public function getInventura($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('ts_inventury_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function getAutor($id){
        $id = (int)$id;
        $row = $this->fetchRow('ts_inventury_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        return $row['vytvoril_u'];
    }
    //toto nie je optimalne pri velkom mnozstve dat to bude dlho trvat
    public function getSumByColumn($column1, $column2, $column2_value){
        $inventury = $this->fetchAll($column2.' = '. $column2_value);
        $sum = 0;
        foreach ($inventury as $inventura){
            $sum = $sum + $inventura[$column1];
        }
        return $sum;
    }

    //get Count of rows where column equals $column_value
    //toto nie je optimalne pri velkom mnozstve dat to bude dlho trvat
    public function getRowCountByColumn($column, $column_value){
        $inventury = $this->fetchAll($column.' = '. $column_value . ' AND stav_transakcie = 2');
        $rowCount = count($inventury);
        return $rowCount;
    }

    //get SUM of column1 by column2 (date) and column3 (stock)
    public function getSumByDateAndStock($column1, $column2, $column2_value, $column3, $column3_value){
        $inventury = $this->fetchAll($column2." = '".$column2_value."' AND ".$column3." = ".$column3_value." AND stav_transakcie = 2");
        $sum = 0;
        foreach ($inventury as $inventura){
            $sum = $sum + $inventura[$column1];
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
        $inventury = $this->fetchAll($sql);

        $sum = 0;
        foreach ($inventury as $inventura){
            $sum = $sum + $inventura[$column1];
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
        $inventury = $this->fetchAll($sql);

        $sum = 0;
        foreach ($inventury as $inventura){
            $sum = $sum + $inventura[$column1];
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
        $this->update($data, 'ts_inventury_id ='. (int)$id);
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
        $sql = $columnName." = ".$columnValue." AND (datum_inventury_d BETWEEN ".$dateFrom." AND ".$dateTo.") AND stav_transakcie = 2";
        $inventury = $this->fetchAll($sql);

        //SUMA v definovanom stlpci
        $sum = 0;
        foreach ($inventury as $inventura){
            $sum = $sum + $inventura[$column];
        }
        return $sum;



    }

    public function getDokladyCislaByDate($date){
        $sql = "datum_inventury_d = '".$date."'";
        $inventury = $this->fetchAll($sql);
        $cislaDokladovArray = array();
        $counter = 0;

        foreach ($inventury AS $inventura){
            $cislaDokladovArray[$counter] = $inventura->doklad_cislo;
            $counter++;
        }

        return $cislaDokladovArray;
    }

    public function getSubmittedSumByColumn($column1, $column2, $column2_value){
        $inventury = $this->fetchAll($column2.' = '.$column2_value. " AND stav_transakcie = 2");
        $sum = 0;
        foreach ($inventury as $inventura){
            $sum = $sum + $inventura[$column1];
        }
        return $sum;
    }

    public function getInventuraFormatted($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('ts_inventury_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        $row['q_tony_merane']=number_format($row['q_tony_merane'], 2, ",", "");
        $row['q_tony_merane_brutto']=number_format($row['q_tony_merane_brutto'], 2, ",", "");
        $row['q_tony_merane_tara']=number_format($row['q_tony_merane_tara'], 2, ",", "");
        $row['q_tony_nadrozmer']=number_format($row['q_tony_nadrozmer'], 2, ",", "");
        //$row['q_tony_vypocet']=number_format($row['q_tony_vypocet'], 2, ",", "");
        $row['q_m3_merane']=number_format($row['q_m3_merane'], 2, ",", "");
        //$row['q_m3_vypocet']=number_format($row['q_m3_vypocet'], 2, ",", "");
        $row['q_prm_merane']=number_format($row['q_prm_merane'], 2, ",", "");
        //$row['q_prm_vypocet']=number_format($row['q_prm_vypocet'], 2, ",", "");


        return $row;
    }

    public function getInventuryAjax()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $stmt = $db->query(
            'SELECT
            ts_inventury_id AS id,
            datum_inventury_d AS datum,
            nazov_skladu AS sklad,
            nazov_podskladu AS podsklad,
            q_tony_merane AS tony,
            q_m3_merane AS m3,
            q_prm_merane AS prm ,
            q_vlhkost AS vlhkost,
            doklad_cislo AS doklad_cislo,
            chyba,
            stav_transakcie AS stav

            FROM
            ts_inventury
            LEFT JOIN sklady ON ts_inventury.sklad_enum=sklady.sklady_id
            LEFT JOIN podsklady ON ts_inventury.podsklad_enum=podsklady.podsklady_id'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function getInventuryWaitingsAjax()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $stmt = $db->query(
            'SELECT
            ts_inventury_id AS id,
            datum_inventury_d AS datum,
            nazov_skladu AS sklad,
            nazov_podskladu AS podsklad,
            q_tony_merane AS tony,
            q_m3_merane AS m3,
            q_prm_merane AS prm ,
            q_vlhkost AS vlhkost,
            doklad_cislo AS doklad_cislo,
            chyba,
            stav_transakcie AS stav

            FROM
            ts_inventury
            LEFT JOIN sklady ON ts_inventury.sklad_enum=sklady.sklady_id
            LEFT JOIN podsklady ON ts_inventury.podsklad_enum=podsklady.podsklady_id
            WHERE stav_transakcie=1'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


    public function getInventuryErrorsAjax()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $stmt = $db->query(
            'SELECT
            ts_inventury_id AS id,
            datum_inventury_d AS datum,
            nazov_skladu AS sklad,
            nazov_podskladu AS podsklad,
            q_tony_merane AS tony,
            q_m3_merane AS m3,
            q_prm_merane AS prm ,
            q_vlhkost AS vlhkost,
            doklad_cislo AS doklad_cislo,
            chyba,
            stav_transakcie AS stav

            FROM
            ts_inventury
            LEFT JOIN sklady ON ts_inventury.sklad_enum=sklady.sklady_id
            LEFT JOIN podsklady ON ts_inventury.podsklad_enum=podsklady.podsklady_id
            WHERE chyba=1'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


}

