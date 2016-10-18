<?php

class Application_Model_DbTable_UbytkyHmotnosti extends Zend_Db_Table_Abstract
{
    /*
     * Úbytky sa počítajú LEN pre sklady s mernou jednotkou TONY (id = 1)
     * V prípade m3 alebo PRM ako mernej jednotky skladu sa vývoj skladu ukladá tiež do tabuľky úbytky hmoty do
     * q_konecny_stav_tony ale ukladajú sa tam m3 alebo PRM hodnoty.
     */
    protected $_name = 'ts_ubytky_hmotnosti';

    //vymaze vsetky data v tabulke
    public function dropTableData(){
        $this->delete(1);
    }

    //vymaze vsetky data v tabulke od datumu do datumu
    private function dropTableDataByDate($dateFrom, $dateTo){
        $sql = "datum_ubytku_d BETWEEN '".$dateFrom."' AND '".$dateTo."'";
        $this->delete($sql);

    }

    //Tato metoda vyhradi vypocita vsetky data v tabulke ubytky hmotnosti od datumu $start do datumu $end
    private function calculateTableData($start, $end){
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);


        $prijmy = new Application_Model_DbTable_Prijmy();
        $vydaje = new Application_Model_DbTable_Vydaje();
        $sklady = new Application_Model_DbTable_Sklady();
        $parametreUbytkov = new Application_Model_DbTable_UbytkyParametre();

        $skladyIds = $sklady->getIds();
        $id = 1;

        foreach ($skladyIds AS $skladId){
            //ak je sklad v tonách
            if ($sklady->getMernaJednotka($skladId) == 1) {
                $date = new DateTime($start);
                do {
                    if ($date == $startDate) {
                        $stavRano = 0;
                    }
                    $prijem = $prijmy->getSumByDateAndStock('q_tony_merane', 'datum_prijmu_d', $date->format('Y-m-d'), 'sklad_enum', $skladId);
                    $vydaj = $vydaje->getSumByDateAndStock('q_tony_merane', 'datum_vydaju_d', $date->format('Y-m-d'), 'sklad_enum', $skladId);
                    $parameterUbytku = $parametreUbytkov->getParameter($date->format('Y-m-d'));
                    $dennyPohyb = $prijem - $vydaj;
                    $stavVecer = $stavRano + $dennyPohyb;
                    if ($stavVecer < 0) {
                        $stavVecer = 0;
                        $poznamka = 'Nedostatok na sklade.';
                    }
                    $stavCelyDen = min($stavRano, $stavVecer);
                    $ubytok = $stavCelyDen * $parameterUbytku;
                    $konecnyStav = $stavVecer - $ubytok;

                    $this->insert(array
                    (
                        'ts_ubytky_hmotnosti_id' => $id,
                        'datum_ubytku_d' => $date->format('Y-m-d'),
                        'sklad_enum' => $skladId,
                        'q_rano_tony' => $stavRano,
                        'q_denny_pohyb_tony' => $dennyPohyb,
                        'q_vecer_tony' => $stavVecer,
                        'q_cely_den_tony' => $stavCelyDen,
                        'q_ubytok_tony' => $ubytok,
                        'q_konecny_stav_tony' => $konecnyStav,
                        'poznamka' => $poznamka,
                        'merna_jednotka_enum' => $sklady->getMernaJednotka($skladId)
                    ));

                    $date->modify('+1 day');
                    $id++;
                    $stavRano = $konecnyStav;
                    $poznamka = null;
                } while ($endDate >= $date);
            }else{
                //ak sklad nie je v tonách
                if ($sklady->getMernaJednotka($skladId) == 3){
                    $stlpec = 'q_m3_merane';
                }else{
                    $stlpec = 'q_prm_merane';
                }
                $date = new DateTime($start);
                do {
                    if ($date == $startDate) {
                        $stavRano = 0;
                    }
                    $prijem = $prijmy->getSumByDateAndStock($stlpec, 'datum_prijmu_d', $date->format('Y-m-d'), 'sklad_enum', $skladId);
                    $vydaj = $vydaje->getSumByDateAndStock($stlpec, 'datum_vydaju_d', $date->format('Y-m-d'), 'sklad_enum', $skladId);
                    //$parameterUbytku = $parametreUbytkov->getParameter($date->format('Y-m-d'));
                    $parameterUbytku = 0;
                    $dennyPohyb = $prijem - $vydaj;
                    $stavVecer = $stavRano + $dennyPohyb;
                    if ($stavVecer < 0) {
                        $stavVecer = 0;
                        $poznamka = 'Nedostatok na sklade.';
                    }
                    $stavCelyDen = min($stavRano, $stavVecer);
                    $ubytok = $stavCelyDen * $parameterUbytku;
                    $konecnyStav = $stavVecer - $ubytok;

                    $this->insert(array
                    (
                        'ts_ubytky_hmotnosti_id' => $id,
                        'datum_ubytku_d' => $date->format('Y-m-d'),
                        'sklad_enum' => $skladId,
                        'q_rano_tony' => $stavRano,
                        'q_denny_pohyb_tony' => $dennyPohyb,
                        'q_vecer_tony' => $stavVecer,
                        'q_cely_den_tony' => $stavCelyDen,
                        'q_ubytok_tony' => $ubytok,
                        'q_konecny_stav_tony' => $konecnyStav,
                        'poznamka' => $poznamka,
                        'merna_jednotka_enum' => $sklady->getMernaJednotka($skladId)
                    ));

                    $date->modify('+1 day');
                    $id++;
                    $stavRano = $konecnyStav;
                    $poznamka = null;
                } while ($endDate >= $date);
            }
        }

    }

    //matoda, ktora spusti refresh celej tabulky -dropData, calculateData podla datum od $startDate do $endDate
    public function refreshTableDataByDate($startDate, $endDate){
        $this->dropTableData();
        $this->calculateTableData($startDate,$endDate);

    }

    //vrati stav skladu v tonach, m3 a PRM
    public function getLastStavSkladu($skladId){
        $transakcie = $this->fetchAll("sklad_enum = ".$skladId)->toArray();
        $defaultneKonverzie = new Application_Model_DbTable_MerneJednotky();
        $lastElementTony = end($transakcie);


        $lastStavSkladuArray = $defaultneKonverzie->getPrepoctyArrayDefault($lastElementTony['q_konecny_stav_tony'], 1);

        return $lastStavSkladuArray;
    }

    //vracia pole s poslednymi $pocetHodnot hodnotami pre vykreslovanie grafu - hodnoty na konci dna po odpocte ubytkov
    //pole je v poradi od najstarsieho [0] po najnovsie [max]
    public function getLastXValues($skladId, $pocetHodnot)
    {
        $poslednychXHodnot = array();

        $sql = "sklad_enum = ". $skladId;
        $pocetZaznamov = $this->fetchAll($sql)->count();
        if ($pocetZaznamov  < $pocetHodnot)
        {
            $pocetHodnot = $pocetZaznamov;
        }

        for ($i = 1; $i <= $pocetHodnot; $i++)
        {
            $poslednychXHodnot[] = $ubytky = $this->fetchAll($sql)->getRow($pocetZaznamov-$pocetHodnot-1+$i)->toArray();
        }

        $poslednychXHodnotVystup = array();

        $counter = 0;
        foreach ($poslednychXHodnot as $polozka){
            $poslednychXHodnotVystup[$counter]['datum']=$polozka['datum_ubytku_d'];
            $poslednychXHodnotVystup[$counter]['stav']=$polozka['q_konecny_stav_tony'];
            $counter++;
        }

        ksort($poslednychXHodnotVystup);

        return $poslednychXHodnotVystup;


    }

    //vracia pole s poslednymi $pocetHodnot hodnotami pre vykreslovanie grafu - hodnoty na konci dna po odpocte ubytkov
    //pole je v poradi od najstarsieho [0] po najnovsie [max]
    public function getLastXValuesForAllWHs($pocetHodnot)
    {
        $poslednychXHodnot = array();

        $zaciatokKalendara = strtotime(Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('calendar_start_date'));
        $pocetDniOdZaciatkuKalendara = floor(abs(time() - $zaciatokKalendara) / 86400);

        if ($pocetDniOdZaciatkuKalendara  < $pocetHodnot)
        {
            $pocetHodnot = $pocetDniOdZaciatkuKalendara;
        }

        $zaciatokDatum = date('Y-m-d', strtotime('-'.($pocetHodnot - 1).' days'));

        $skladyModel = new Application_Model_DbTable_Sklady();
        $sklady = $skladyModel->getIds();
        $counterDatum = strtotime(date("Y-m-d", strtotime($zaciatokDatum)) . " +0 day");

        for ($i = 1; $i <= $pocetHodnot; $i++)
        {
            $poslednychXHodnot[$i-1]['datum'] = date('Y-m-d', $counterDatum);
            foreach ($sklady AS $sklad){
                $sql = "datum_ubytku_d = '".date('Y-m-d', $counterDatum)."' AND sklad_enum = ".$sklad;
                $stavNaKonciDna = $this->fetchRow($sql);
                $poslednychXHodnot[$i-1]['sklad'.$sklad] = $stavNaKonciDna->q_konecny_stav_tony;
            }
            $counterDatum = strtotime(date("Y-m-d", strtotime($zaciatokDatum)) . " +".$i." day");
        }


        //ksort($poslednychXHodnotVystup);


        return $poslednychXHodnot;


    }


    public function getErrorNedostatokNaSklade(){
        $sql = "poznamka = 'Nedostatok na sklade.'";
        $pocetChyb = $this->fetchAll($sql)->count();
        return $pocetChyb;
    }









}

