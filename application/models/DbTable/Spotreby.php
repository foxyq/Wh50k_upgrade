<?php

class Application_Model_DbTable_Spotreby extends Zend_Db_Table_Abstract
{
    //metody modelu vychadzaju z modelu Vydajov

    protected $_name = 'ts_spotreby';

    public function getSpotreba($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('ts_spotreby_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function getAutor($id){
        $id = (int)$id;
        $row = $this->fetchRow('ts_spotreby_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        return $row['vytvoril_u'];
    }

    public function addSpotreba(
                             $datum_spotreby,
                             $sklad,
                             $podsklad,
                             $zakaznik,
                             $q_tony_merane,
                             $q_m3_merane,
                             $q_prm_merane,
                             $q_vlhkost,
                             $doklad_typ,
                             $material_typ,
                             $material_druh,
                             $stroj,
                             $poznamka,
                             $chyba,
                             $stav_transakcie,
                             $doklad_cislo){

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];

        $data = array(
            'datum_spotreby_d' => $datum_spotreby,
            'sklad_enum' => $sklad,
            'podsklad_enum' => $podsklad,
            'zakaznik_enum' => $zakaznik,
            'q_tony_merane' => $q_tony_merane,
            'q_m3_merane' => $q_m3_merane,
            'q_prm_merane' => $q_prm_merane,
            'q_vlhkost' => $q_vlhkost,
            'doklad_typ_enum' => $doklad_typ,
            'material_typ_enum' => $material_typ,
            'material_druh_enum' => $material_druh,
            'stroj_enum' => $stroj,
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


    public function editSpotreba(
        $id,
        $datum_spotreby,
        $sklad,
        $podsklad,
        $zakaznik,
        $q_tony_merane,
        $q_m3_merane,
        $q_prm_merane,
        $q_vlhkost,
        $doklad_typ,
        $material_typ,
        $material_druh,
        $stroj,
        $poznamka,
        $chyba,
        $stav_transakcie){

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];

        $data = array(
            'datum_spotreby_d' => $datum_spotreby,
            'sklad_enum' => $sklad,
            'podsklad_enum' => $podsklad,
            'zakaznik_enum' => $zakaznik,
            'q_tony_merane' => $q_tony_merane,
            'q_m3_merane' => $q_m3_merane,
            'q_prm_merane' => $q_prm_merane,
            'q_vlhkost' => $q_vlhkost,
            'doklad_typ_enum' => $doklad_typ,
            'material_typ_enum' => $material_typ,
            'material_druh_enum' => $material_druh,
            'stroj_enum' => $stroj,
            'poznamka' => $poznamka,
            'chyba' => $chyba,
            'stav_transakcie' => $stav_transakcie,

            'vytvoril_u' => self::getAutor($id),
            'posledna_uprava_u' => $identity

        );
        $this->update($data, 'ts_spotreby_id ='. (int)$id);
    }

    public function deleteSpotreba($id)
    {
        $this->delete('ts_spotreby_id =' . (int)$id);
    }

    //get SUM of column1 by column2
    //toto nie je optimalne pri velkom mnozstve dat to bude dlho trvat
    public function getSumByColumn($column1, $column2, $column2_value){
        $spotreby = $this->fetchAll($column2.' = '. $column2_value);
        $sum = 0;
        foreach ($spotreby as $spotreba){
            $sum = $sum + $spotreba[$column1];
        }
        return $sum;
    }

    //get Count of rows where column equals $column_value
    //toto nie je optimalne pri velkom mnozstve dat to bude dlho trvat
    public function getRowCountByColumn($column, $column_value){
        $spotreby = $this->fetchAll($column.' = '. $column_value . ' AND stav_transakcie = 2');
        $rowCount = count($spotreby);
        return $rowCount;
    }

    //get SUM of column1 by column2 (date) and column3 (stock)
    public function getSumByDateAndStock($column1, $column2, $column2_value, $column3, $column3_value){
        $spotreby = $this->fetchAll($column2." = '".$column2_value."' AND ".$column3." = ".$column3_value." AND stav_transakcie = 2");
        $sum = 0;
        foreach ($spotreby as $spotreba){
            $sum = $sum + $spotreba[$column1];
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
        $spotreby = $this->fetchAll($sql);

        $sum = 0;
        foreach ($spotreby as $spotreba){
            $sum = $sum + $spotreba[$column1];
        }
        return $sum;
    }


    //$quantity_column_name - ex. 'prm_merane', 'm3_merane'
    //$zakaznik_id
    public function getSubmittedQuantityByStockYearMonth($merna_jednotka, $zakaznik_id, $yearId, $monthId){
        $rokyModel = new Application_Model_DbTable_Roky();

        $year = $rokyModel->getNazov($yearId);
        $month = $monthId;
        $dateFrom = "'".$year."-".$month."-"."01'";
        $dateTo = "'".$year."-".$month."-"."31'";
        $column = 'q_tony_merane';
        switch ($merna_jednotka){
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

        $sql = "zakaznik_enum = ".$zakaznik_id." AND (datum_spotreby_d BETWEEN ".$dateFrom." AND ".$dateTo.") AND stav_transakcie = 2";
        $spotreby = $this->fetchAll($sql);

        $sum = 0;
        foreach ($spotreby as $spotreba){
            $sum = $sum + $spotreba[$column];
        }
        return $sum;
    }

    //$quantity_column_name - ex. 'prm_merane', 'm3_merane'
    //$zakaznik_id
    public function getSubmittedQuantityByCustomerDateFromDateTo($merna_jednotka, $zakaznik_id, $dateFrom, $dateTo){

        $column = 'q_tony_merane';
        switch ($merna_jednotka){
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

        $sql = "zakaznik_enum = ".$zakaznik_id." AND (datum_spotreby_d BETWEEN '".$dateFrom."' AND '".$dateTo."') AND stav_transakcie = 2";
        $spotreby = $this->fetchAll($sql);

        $sum = 0;
        foreach (spotreby as $spotreba){
            $sum = $sum + $spotreba[$column];
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
        //$prijmy = $this->fetchAll($column2.' > '. $column2_value1);
        $spotreby = $this->fetchAll($sql);

        $sum = 0;
        foreach ($spotreby as $spotreba){
            $sum = $sum + $spotreba[$column1];
        }
        return $sum;
    }

    /**
     * Pre účely notifikácií
     */
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
        $this->update($data, 'ts_spotreby_id ='. (int)$id);
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
        $sql = $columnName." = ".$columnValue." AND (datum_spotreby_d BETWEEN ".$dateFrom." AND ".$dateTo.") AND stav_transakcie = 2";
        $spotreby = $this->fetchAll($sql);

        //SUMA v definovanom stlpci
        $sum = 0;
        foreach ($spotreby as $spotreba){
            $sum = $sum + $spotreba[$column];
        }
        return $sum;



    }

    public function getQuantitiesByYearIdColumnAndColumnValue($yearId, $columnName, $columnValue){
        //definicia od do datumov pre sql
        $rokyModel = new Application_Model_DbTable_Roky();
        $year = $rokyModel->getNazov($yearId);
        $dateFrom = "'".$year."-01-01'";
        $dateTo = "'".$year."-12-31'";

        //pre potreby vypoctu
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();

        //SQL dotaz
        $sql = $columnName." = ".$columnValue." AND (datum_spotreby_d BETWEEN ".$dateFrom." AND ".$dateTo.") AND stav_transakcie = 2";
        $spotreby = $this->fetchAll($sql);

        //SUMA v definovanom stlpci
        $sum = array('q_tony_merane' => 0,'q_prm_merane' => 0,'q_m3_merane' => 0);
        foreach ($spotreby as $spotreba){
            switch ($zakazniciModel->getMernaJednotka($spotreba->zakaznik_enum)){
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
            //$vydajAry = $spotreba->toArray();
            $sum[$column] = $sum[$column] + $spotreba[$column];
        }
        return $sum;
    }

    public function getQuantitiesByYearIdMonthIdColumnAndColumnValue($yearId, $monthId, $columnName, $columnValue){
        //definicia od do datumov pre sql
        $rokyModel = new Application_Model_DbTable_Roky();
        $year = $rokyModel->getNazov($yearId);
        $dateFrom = "'".$year."-".$monthId."-01'";
        $dateTo = "'".$year."-".$monthId."-31'";

        //pre potreby vypoctu
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();

        //SQL dotaz
        $sql = $columnName." = ".$columnValue." AND (datum_spotreby_d BETWEEN ".$dateFrom." AND ".$dateTo.") AND stav_transakcie = 2";
        $spotreby = $this->fetchAll($sql);

        //SUMA v definovanom stlpci
        $sum = array('q_tony_merane' => 0,'q_prm_merane' => 0,'q_m3_merane' => 0);
        foreach ($spotreby as $spotreba){
            switch ($zakazniciModel->getMernaJednotka($spotreba->zakaznik_enum)){
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
            //$vydajAry = $spotreba->toArray();
            $sum[$column] = $sum[$column] + $spotreba[$column];
        }
        return $sum;
    }
    public function getDokladyCislaByDate($date){
        $sql = "datum_spotreby_d = '".$date."'";
        $spotreby = $this->fetchAll($sql);
        $cislaDokladovArray = array();
        $counter = 0;

        foreach ($spotreby AS $spotreba){
            $cislaDokladovArray[$counter] = $spotreba->doklad_cislo;
            $counter++;
        }

        return $cislaDokladovArray;
    }

    public function getSubmittedSumByColumn($column1, $column2, $column2_value){
        $spotreby = $this->fetchAll($column2.' = '.$column2_value. " AND stav_transakcie = 2");
        $sum = 0;
        foreach ($spotreby as $spotreba){
            $sum = $sum + $spotreba[$column1];
        }
        return $sum;
    }

    public function getSpotrebaFormatted($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('ts_spotreby_id = ' . $id);
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

    public function getSpotrebyAjax()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $stmt = $db->query(
            'SELECT
            ts_spotreby_id AS id,
            datum_spotreby_d AS datum,
            nazov_skladu AS sklad,
            nazov_podskladu AS podsklad,
            nazov_spolocnosti AS zakaznik,
            q_tony_merane AS tony,
            q_m3_merane AS m3,
            q_prm_merane AS prm ,
            q_vlhkost AS vlhkost,
            doklad_cislo AS doklad_cislo,
            materialy_typy.nazov AS typ,
            chyba,
            stav_transakcie AS stav

            FROM
            ts_spotreby
            LEFT JOIN sklady ON ts_spotreby.sklad_enum=sklady.sklady_id
            LEFT JOIN podsklady ON ts_spotreby.podsklad_enum=podsklady.podsklady_id
            LEFT JOIN zakaznici ON ts_spotreby.zakaznik_enum=zakaznici.zakaznici_id
            LEFT JOIN materialy_typy ON ts_spotreby.material_typ_enum=materialy_typy.materialy_typy_id
            LEFT JOIN materialy_druhy ON ts_spotreby.material_druh_enum=materialy_druhy.materialy_druhy_id'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


}

