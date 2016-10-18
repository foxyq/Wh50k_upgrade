<?php

class Application_Model_DbTable_Prijmy extends Zend_Db_Table_Abstract
{
	//namapovanie tabuľky podľa mena z databáze pre aplikáciu
    protected $_name = 'ts_prijmy';

    public function getPrijem($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('ts_prijmy_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        return $row;
    }

    public function getPrijemFormatted($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('ts_prijmy_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        $row['q_tony_merane']=number_format($row['q_tony_merane'], 2, ",", "");
        $row['q_tony_brutto']=number_format($row['q_tony_merane_brutto'], 2, ",", "");
        $row['q_tony_tara']=number_format($row['q_tony_merane_tara'], 2, ",", "");
        $row['q_tony_nadrozmer']=number_format($row['q_tony_nadrozmer'], 2, ",", "");
        //$row['q_tony_vypocet']=number_format($row['q_tony_vypocet'], 2, ",", "");
        $row['q_m3_merane']=number_format($row['q_m3_merane'], 2, ",", "");
        //$row['q_m3_vypocet']=number_format($row['q_m3_vypocet'], 2, ",", "");
        $row['q_prm_merane']=number_format($row['q_prm_merane'], 2, ",", "");
        //$row['q_prm_vypocet']=number_format($row['q_prm_vypocet'], 2, ",", "");



        return $row;
    }

    public function getPrijemByDokladCislo($id)
    {
        //$id = $id;
        $row = $this->fetchRow("doklad_cislo = '" . $id."'");
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        return $row;
    }

    public function getAutor($id){
        $id = (int)$id;
        $row = $this->fetchRow('ts_prijmy_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $row = $row->toArray();
        return $row['vytvoril_u'];
    }

    public function deletePrijem($id)
    {
        $this->delete('ts_prijmy_id =' . (int)$id);
    }

    public function addPrijem($datum_prijmu,
                              $sklad,
                              $podsklad,
                              $dodavatel,
                              $prepravca,
                              $prepravca_spz,
                              $q_tony_merane,
                              $q_tony_nadrozmer,
                              $q_tony_brutto,
                              $q_tony_tara,
                              $q_m3_merane,
                              $q_prm_merane,
                              $q_vlhkost,
                              $doklad_typ,
                              $material_typ,
                              $material_druh,
                              $poznamka,
                              $chyba,
                              $stav_transakcie,
                            $doklad_cislo,
                            $material_poznamka){
        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];

        $data = array(
            'datum_prijmu_d' => $datum_prijmu,
            'sklad_enum' => $sklad,
            'podsklad_enum' => $podsklad,
            'dodavatel_enum' => $dodavatel,
            'prepravca_enum' => $prepravca,
            'prepravca_spz' => $prepravca_spz,
            'q_tony_merane' => $q_tony_merane,
            'q_tony_nadrozmer' => $q_tony_nadrozmer,
            'q_tony_merane_brutto' => $q_tony_brutto,
            'q_tony_merane_tara' => $q_tony_tara,
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
            'material_poznamka' => $material_poznamka

        );
        $this->insert($data);
    }

    public function editPrijem(
        $id,
        $datum_prijmu,
        $sklad,
        $podsklad,
        $dodavatel,
        $prepravca,
        $prepravca_spz,
        $q_tony_merane,
        $q_tony_brutto,
        $q_tony_tara,
        $q_tony_nadrozmer,
        $q_m3_merane,
        $q_prm_merane,
        $q_vlhkost,
//        $doklad_typ,
        $material_druh,
        $material_typ,
        $poznamka,
        $chyba,
        $stav_transakcie,
        $material_poznamka){

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];


        $data = array(
            'datum_prijmu_d' => $datum_prijmu,
            'sklad_enum' => $sklad,
            'podsklad_enum' => $podsklad,
            'dodavatel_enum' => $dodavatel,
            'prepravca_enum' => $prepravca,
            'prepravca_spz' => $prepravca_spz,
            'q_tony_merane' => $q_tony_merane,
            'q_tony_nadrozmer' => $q_tony_nadrozmer,
            'q_tony_merane_brutto' => $q_tony_brutto,
            'q_tony_merane_tara' => $q_tony_tara,
            'q_m3_merane' => $q_m3_merane,
            'q_prm_merane' => $q_prm_merane,
            'q_vlhkost' => $q_vlhkost,
//            'doklad_typ_enum' => $doklad_typ,
            'material_druh_enum' => $material_druh,
            'material_typ_enum' => $material_typ,
            'poznamka' => $poznamka,
            'chyba' => $chyba,
            'stav_transakcie' => $stav_transakcie,

            'vytvoril_u' => self::getAutor($id),
            'posledna_uprava_u' =>  $identity,
            'material_poznamka' => $material_poznamka


        );
        $this->update($data, 'ts_prijmy_id ='. (int)$id);

    }

    //get SUM of column1 by column2
    //toto nie je optimalne pri velkom mnozstve dat to bude dlho trvat
    public function getSumByColumn($column1, $column2, $column2_value){
       $prijmy = $this->fetchAll($column2.' = '.$column2_value);
        $sum = 0;
        foreach ($prijmy as $prijem){
            $sum = $sum + $prijem[$column1];
        }
        return $sum;
    }

    public function getSubmittedSumByColumn($column1, $column2, $column2_value){
       $prijmy = $this->fetchAll($column2.' = '.$column2_value. " AND stav_transakcie = 2");
        $sum = 0;
        foreach ($prijmy as $prijem){
            $sum = $sum + $prijem[$column1];
        }
        return $sum;
    }



    //get SUM of column1 by column2 (date) and column3 (stock)
    public function getSumByDateAndStock($column1, $column2, $column2_value, $column3, $column3_value){
       $prijmy = $this->fetchAll($column2." = '".$column2_value."' AND ".$column3." = ".$column3_value." AND stav_transakcie = 2");
        $sum = 0;
        foreach ($prijmy as $prijem){
            $sum = $sum + $prijem[$column1];
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
        //$prijmy = $this->fetchAll($column2.' > '. $column2_value1);
        $prijmy = $this->fetchAll($sql);

        $sum = 0;
        foreach ($prijmy as $prijem){
            $sum = $sum + $prijem[$column1];
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

        $sql = $column3." = ".$column3_value1." AND (".$column2." BETWEEN '".$column2_value1."' AND '".$column2_value2.".') AND stav_transakcie = 2";
        //$prijmy = $this->fetchAll($column2.' > '. $column2_value1);
        $prijmy = $this->fetchAll($sql);

        $sum = 0;
        foreach ($prijmy as $prijem){
            $sum = $sum + $prijem[$column1];
        }
        return $sum;
    }

    //toto netreba pre plnenie objednavok
    //$quantity_column_name - ex. 'prm_merane', 'm3_merane'
    //$stock_id
    public function getSubmittedQuantityByStockYearMonth($merna_jednotka, $stock_id, $year, $month){
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

        $sql = "sklad_enum = ".$stock_id." AND (datum_prijmu_d BETWEEN ".$dateFrom." AND ".$dateTo.") AND stav_transakcie = 2";
        $prijmy = $this->fetchAll($sql);

        $sum = 0;
        foreach ($prijmy as $prijem){
            $sum = $sum + $prijem[$column];
        }
        return $sum;
    }


    public function getColumnById($column, $id){
        $sql = "ts_prijmy_id = " . $id;
        $value = $this->fetchAll($sql);
        return $value[$column];
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
        $this->update($data, 'ts_prijmy_id ='. (int)$id);
    }

    public function getDokladyCislaByDate($date){
        $sql = "datum_prijmu_d = '".$date."'";
        $prijmy = $this->fetchAll($sql);
        $cislaDokladovArray = array();
        $counter = 0;

        foreach ($prijmy AS $prijem){
            $cislaDokladovArray[$counter] = $prijem->doklad_cislo;
            $counter++;
        }

        return $cislaDokladovArray;
    }


}

