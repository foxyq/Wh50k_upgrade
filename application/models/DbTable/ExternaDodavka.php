<?php

class Application_Model_DbTable_ExternaDodavka extends Zend_Db_Table_Abstract
{

    protected $_name = 'tx_dodavka';

    public function getXDodavka($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('tx_dodavka_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function getXDodavkyByZakaznikIdAndDateMJ($zakaznikId, $yearId, $monthId, $mernaJednotkaId){
        $rokyModel = new Application_Model_DbTable_Roky();

        $year = $rokyModel->getNazov($yearId);
        $month = $monthId;
        $dateFrom = "'".$year."-".$month."-"."01'";
        $dateTo = "'".$year."-".$month."-"."31'";
        $stlpecKvantity = 'q_tony_merane';

        switch ($mernaJednotkaId){
            case 1:
                $stlpecKvantity = 'q_tony_merane';
                break;
            case 2:
                $stlpecKvantity = 'q_prm_merane';
                break;
            case 3:
                $stlpecKvantity = 'q_m3_merane';
                break;
        }

        $sql = "zakaznik_enum = ".$zakaznikId." AND (datum_xdodavky_d BETWEEN ".$dateFrom." AND ".$dateTo.") AND stav_transakcie = 2 AND ".$stlpecKvantity." > 0";
        $xdodavky = $this->fetchAll($sql);

        return $xdodavky;

    }


    public function getXDodavkyByZakaznikIdAndDateFromdateToMJ($zakaznikId, $dateFrom, $dateTo, $mernaJednotkaId){
        $stlpecKvantity = 'q_tony_merane';

        switch ($mernaJednotkaId){
            case 1:
                $stlpecKvantity = 'q_tony_merane';
                break;
            case 2:
                $stlpecKvantity = 'q_prm_merane';
                break;
            case 3:
                $stlpecKvantity = 'q_m3_merane';
                break;
        }
        $sql = "zakaznik_enum = ".$zakaznikId." AND (datum_xdodavky_d BETWEEN '".$dateFrom."' AND '".$dateTo."') AND stav_transakcie = 2 AND ".$stlpecKvantity." > 0";
        $xdodavky = $this->fetchAll($sql);

        return $xdodavky;

    }

    public function getXDodavkaFormatted($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('tx_dodavka_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        $row['q_tony_merane']=number_format($row['q_tony_merane'], 2, ",", "");
        $row['q_tony_merane_brutto']=number_format($row['q_tony_merane_brutto'], 2, ",", "");
        $row['q_tony_merane_tara']=number_format($row['q_tony_merane_tara'], 2, ",", "");
        $row['q_tony_nadrozmer']=number_format($row['q_tony_nadrozmer'], 2, ",", "");
        $row['q_m3_merane']=number_format($row['q_m3_merane'], 2, ",", "");
        $row['q_prm_merane']=number_format($row['q_prm_merane'], 2, ",", "");

        return $row;
    }

    public function getXDodavkaByDokladCislo($id)
    {
        $id = $id;
        $row = $this->fetchRow("doklad_cislo = '" . $id."'");
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        return $row;
    }

     public function getAutor($id){
        $id = (int)$id;
        $row = $this->fetchRow('tx_dodavka_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        return $row['vytvoril_u'];
    }

    public function addXDodavka($datum_xdodavky,
                              $zakaznik,
                              $dodavatel,
                              $prepravca,
                              $prepravca_spz,
                              $q_tony_merane,
                              $q_m3_merane,
                              $q_prm_merane,
                              $q_vlhkost,
                              $doklad_typ,
                              $material_typ,
                              $material_druh,
                              $poznamka,
                              $chyba,
                              $stav_transakcie,
                             $doklad_cislo){

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];

        $data = array(
            'datum_xdodavky_d' => $datum_xdodavky,
            'zakaznik_enum' => $zakaznik,
            'dodavatel_enum' => $dodavatel,
            'prepravca_enum' => $prepravca,
            'prepravca_spz' => $prepravca_spz,
            'q_tony_merane' => $q_tony_merane,
            'q_m3_merane' => $q_m3_merane,
            'q_prm_merane' => $q_prm_merane,
            'q_vlhkost' => $q_vlhkost,
            'doklad_typ_enum' => $doklad_typ,
            'material_typ_enum' => $material_typ,
            'material_druh_enum' => $material_druh,
            'poznamka' => $poznamka,
            'chyba' => $chyba,
            'stav_transakcie' => $stav_transakcie,
            'doklad_cislo' => $doklad_cislo,
            'vytvoril_u' => $identity,
            'posledna_uprava_u' => $identity,


        );
//        var_dump($data);
        $this->insert($data);
    }


    public function editXDodavka(
                            $id,
                            $datum_xdodavky,
                             $zakaznik,
                            $dodavatel,
                             $prepravca,
                             $prepravca_spz,
                             $q_tony_merane,
                             $q_m3_merane,
                             $q_prm_merane,
                             $q_vlhkost,
                             $material_typ,
                             $material_druh,
                             $poznamka,
                             $chyba,
                             $stav_transakcie){

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];

        $data = array(
            'datum_xdodavky_d' => $datum_xdodavky,
            'zakaznik_enum' => $zakaznik,
            'dodavatel_enum' => $dodavatel,
            'prepravca_enum' => $prepravca,
            'prepravca_spz' => $prepravca_spz,
            'q_tony_merane' => $q_tony_merane,
            'q_m3_merane' => $q_m3_merane,
            'q_prm_merane' => $q_prm_merane,
            'q_vlhkost' => $q_vlhkost,
            'material_typ_enum' => $material_typ,
            'material_druh_enum' => $material_druh,
            'poznamka' => $poznamka,
            'chyba' => $chyba,
            'stav_transakcie' => $stav_transakcie,
            'posledna_uprava_u' => $identity

        );
        $this->update($data, 'tx_dodavka_id ='. (int)$id);
    }

    public function deleteXDodavka($id)
    {
        $this->delete('tx_dodavka_id =' . (int)$id);
    }

    //get SUM of column1 by column2
    //toto nie je optimalne pri velkom mnozstve dat to bude dlho trvat
    public function getSumByColumn($column1, $column2, $column2_value){
        $dodavky = $this->fetchAll($column2.' = '. $column2_value);
        $sum = 0;
        foreach ($dodavky as $dodavka){
            $sum = $sum + $dodavka[$column1];
        }
        return $sum;
    }

    //get Count of rows where column equals $column_value
    //toto nie je optimalne pri velkom mnozstve dat to bude dlho trvat
    public function getRowCountByColumn($column, $column_value){
        $dodavky = $this->fetchAll($column.' = '. $column_value . ' AND stav_transakcie = 2');
        $rowCount = count($dodavky);
        return $rowCount;
    }

    //get SUM of column1 by column2 (date) and column3 (stock)
    public function getSumByDateAndStock($column1, $column2, $column2_value, $column3, $column3_value){
        $dodavky = $this->fetchAll($column2." = '".$column2_value."' AND ".$column3." = ".$column3_value." AND stav_transakcie = 2");
        $sum = 0;
        foreach ($dodavky as $dodavka){
            $sum = $sum + $dodavka[$column1];
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
        $dodavky = $this->fetchAll($sql);

        $sum = 0;
        foreach ($dodavky as $dodavka){
            $sum = $sum + $dodavka[$column1];
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

        $sql = "zakaznik_enum = ".$zakaznik_id." AND (datum_xdodavky_d BETWEEN ".$dateFrom." AND ".$dateTo.") AND stav_transakcie = 2";
        $xdodavky = $this->fetchAll($sql);

        $sum = 0;
        foreach ($xdodavky as $xdodavka){
            $sum = $sum + $xdodavka[$column];
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

        $sql = "zakaznik_enum = ".$zakaznik_id." AND (datum_xdodavky_d BETWEEN '".$dateFrom."' AND '".$dateTo."') AND stav_transakcie = 2";
        $xdodavky = $this->fetchAll($sql);

        $sum = 0;
        foreach ($xdodavky as $xdodavka){
            $sum = $sum + $xdodavka[$column];
        }
        return $sum;
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
        $sql = $columnName." = ".$columnValue." AND (datum_xdodavky_d BETWEEN ".$dateFrom." AND ".$dateTo.") AND stav_transakcie = 2";
        $xdodavky = $this->fetchAll($sql);

        //SUMA v definovanom stlpci
        $sum = 0;
        foreach ($xdodavky as $xdodavka){
            $sum = $sum + $xdodavka[$column];
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
        $this->update($data, 'tx_dodavka_id ='. (int)$id);
    }

    public function getDokladyCislaByDate($date){
        $sql = "datum_xdodavky_d = '".$date."'";
        $xdodavky = $this->fetchAll($sql);
        $cislaDokladovArray = array();
        $counter = 0;

        foreach ($xdodavky AS $xdodavka){
            $cislaDokladovArray[$counter] = $xdodavka->doklad_cislo;
            $counter++;
        }

        return $cislaDokladovArray;
    }

    public function getDodavkyAjax()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $stmt = $db->query(
            'SELECT
            tx_dodavka_id AS id,
            datum_xdodavky_d AS datum,
            zakaznici.meno  AS zakaznik,
            dodavatelia.meno AS dodavatel,
            prepravci.meno AS prepravca,
            prepravca_spz AS spz,
            q_tony_merane AS tony,
            q_m3_merane AS m3,
            q_prm_merane AS prm ,
            q_vlhkost AS vlhkost,
            doklad_cislo AS doklad_cislo,
            materialy_typy.nazov AS typ,
            chyba,
            stav_transakcie AS stav

            FROM
            tx_dodavka

            LEFT JOIN zakaznici ON tx_dodavka.zakaznik_enum=zakaznici.zakaznici_id
            LEFT JOIN dodavatelia ON tx_dodavka.dodavatel_enum=dodavatelia.dodavatelia_id
            LEFT JOIN prepravci ON tx_dodavka.prepravca_enum=prepravci.prepravci_id
            LEFT JOIN materialy_typy ON tx_dodavka.material_typ_enum=materialy_typy.materialy_typy_id
            LEFT JOIN materialy_druhy ON tx_dodavka.material_druh_enum=materialy_druhy.materialy_druhy_id'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    public function getDodavkyWaitings()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $stmt = $db->query(
            'SELECT
            tx_dodavka_id AS id,
            datum_xdodavky_d AS datum,
            zakaznici.meno  AS zakaznik,
            dodavatelia.meno AS dodavatel,
            prepravci.meno AS prepravca,
            prepravca_spz AS spz,
            q_tony_merane AS tony,
            q_m3_merane AS m3,
            q_prm_merane AS prm ,
            q_vlhkost AS vlhkost,
            doklad_cislo AS doklad_cislo,
            materialy_typy.nazov AS typ,
            chyba,
            stav_transakcie AS stav

            FROM
            tx_dodavka

            LEFT JOIN zakaznici ON tx_dodavka.zakaznik_enum=zakaznici.zakaznici_id
            LEFT JOIN dodavatelia ON tx_dodavka.dodavatel_enum=dodavatelia.dodavatelia_id
            LEFT JOIN prepravci ON tx_dodavka.prepravca_enum=prepravci.prepravci_id
            LEFT JOIN materialy_typy ON tx_dodavka.material_typ_enum=materialy_typy.materialy_typy_id
            LEFT JOIN materialy_druhy ON tx_dodavka.material_druh_enum=materialy_druhy.materialy_druhy_id
            WHERE stav_transakcie=1'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    public function getDodavkyErrors()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $stmt = $db->query(
            'SELECT
            tx_dodavka_id AS id,
            datum_xdodavky_d AS datum,
            zakaznici.meno  AS zakaznik,
            dodavatelia.meno AS dodavatel,
            prepravci.meno AS prepravca,
            prepravca_spz AS spz,
            q_tony_merane AS tony,
            q_m3_merane AS m3,
            q_prm_merane AS prm ,
            q_vlhkost AS vlhkost,
            doklad_cislo AS doklad_cislo,
            materialy_typy.nazov AS typ,
            chyba,
            stav_transakcie AS stav

            FROM
            tx_dodavka

            LEFT JOIN zakaznici ON tx_dodavka.zakaznik_enum=zakaznici.zakaznici_id
            LEFT JOIN dodavatelia ON tx_dodavka.dodavatel_enum=dodavatelia.dodavatelia_id
            LEFT JOIN prepravci ON tx_dodavka.prepravca_enum=prepravci.prepravci_id
            LEFT JOIN materialy_typy ON tx_dodavka.material_typ_enum=materialy_typy.materialy_typy_id
            LEFT JOIN materialy_druhy ON tx_dodavka.material_druh_enum=materialy_druhy.materialy_druhy_id
            WHERE chyba=1'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


}

