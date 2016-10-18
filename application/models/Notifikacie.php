<?php

class Application_Model_Notifikacie
{

    public function getStatusArray(){
        $status = array();

        $prijmy = new Application_Model_DbTable_Prijmy();
        $vydaje = new Application_Model_DbTable_Vydaje();
        $ubytky = new Application_Model_DbTable_UbytkyHmotnosti();
        $externeDodavky = new Application_Model_DbTable_ExternaDodavka();
        $externeVyroby = new Application_Model_DbTable_ExternaVyroba();
        $objednavky = new Application_Model_DbTable_Objednavky();
        $mikroObjednavky = new Application_Model_DbTable_MikroObjednavky();

        $status['prijmy_waitings'] = $prijmy->getNumberOfWaitings();
        $status['prijmy_errors'] = $prijmy->getNumberOfErrors();
        $status['vydaje_waitings'] = $vydaje->getNumberOfWaitings();
        $status['vydaje_errors'] = $vydaje->getNumberOfErrors();
        $status['ubytky_chyba'] = $ubytky->getErrorNedostatokNaSklade();
        $status['externe_dodavky_waitings'] = $externeDodavky->getNumberOfWaitings();
        $status['externe_dodavky_errors'] = $externeDodavky->getNumberOfErrors();
        $status['externe_vyroby_waitings'] = $externeVyroby->getNumberOfWaitings();
        $status['externe_vyroby_errors'] = $externeVyroby->getNumberOfErrors();
        $status['objednavky_nekompatibilne'] = $objednavky->getCountNekompatibilneObjednavky();
        $status['mikroObjednavky_nekompatibilne'] = $mikroObjednavky->getCountNekompatibilneMikroObjednavky();
        $status['mikroObjednavky_nekompatibilne_ku_objednavkam'] = $mikroObjednavky->getCountNekompatibilneMikroObjednavkyVsObjednavky();


        $status['total'] =
            (int)$prijmy->getNumberOfWaitings() +
            (int)$prijmy->getNumberOfErrors() +
            (int)$vydaje->getNumberOfWaitings() +
            (int)$vydaje->getNumberOfErrors() +
            (int)$externeDodavky->getNumberOfWaitings() +
            (int)$externeDodavky->getNumberOfErrors() +
            (int)$externeVyroby->getNumberOfWaitings() +
            (int)$externeVyroby->getNumberOfErrors() +
            (int)$ubytky->getErrorNedostatokNaSklade() +
            (int)$objednavky->getCountNekompatibilneObjednavky() +
            (int)$mikroObjednavky->getCountNekompatibilneMikroObjednavky() +
            (int)$mikroObjednavky->getCountNekompatibilneMikroObjednavkyVsObjednavky();;

        return $status;


    }

    //vracia iba cislo - pocet notifikacii
    public function getStatusTotal(){
        $statusArray = $this->getStatusArray();
        $statusCount = $statusArray['total'];
        return $statusCount;
    }


}

