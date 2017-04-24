<?php

class Skladnik_VydajeController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;

        //instancia modelu z ktoreho budeme tahat zoznam
        $skladyMoznosti = new Application_Model_DbTable_Sklady();
        $podskladyMoznosti = new Application_Model_DbTable_Podsklady();
        $zakazniciMoznosti = new Application_Model_DbTable_Zakaznici();
        $prepravciMoznosti = new Application_Model_DbTable_Prepravci();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $stroje = new Application_Model_DbTable_Stroje();

        //metoda ktorou vytiahneme do premennej zoznam
        $skladyMoznosti = $skladyMoznosti->getMoznosti();
        $podskladyMoznosti = $podskladyMoznosti->getMoznosti();
        $zakazniciMoznosti = $zakazniciMoznosti->getMoznosti();
        $prepravciMoznosti = $prepravciMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $materialyDruhyMoznosti = $materialyDruhy->getMoznosti();
        $materialyTypyMoznosti = $materialyTypy->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();
        $strojeMoznosti = $stroje->getMoznosti();

        //zoradenie
        asort($zakazniciMoznosti);
        asort($prepravciMoznosti);


        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Vložiť';

        $form = new Application_Form_Vydaj(array(
            'skladyMoznosti' => $skladyMoznosti,
            'podskladyMoznosti' => $podskladyMoznosti,
            'zakazniciMoznosti' => $zakazniciMoznosti,
            'prepravciMoznosti' => $prepravciMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'materialyDruhyMoznosti' => $materialyDruhyMoznosti,
            'materialyTypyMoznosti' => $materialyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'strojeMoznosti' => $strojeMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo,
        ));

//        $form->getElement('datum_vydaju_d')->setAttribs(array(
//            'disabled' => 'disabled'));


        $this->view->form = $form;

        //pageManager
        //$_SESSION[pageManager][ignore] = 1;


        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();

//            var_dump($this->getRequest()->getPost());

            if ($form->isValid($formData)) {

                $datum_vydaju = $form->getValue('datum_vydaju_d');
                $sklad = $form->getValue('sklad_enum');
                $podsklad = $form->getValue('podsklad_enum');
                $zakaznik = $form->getValue('zakaznik_enum');
                $prepravca = $form->getValue('prepravca_enum');
                $prepravca_spz = $form->getValue('prepravca_spz');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $kapacita_kamionu_prm = $form->getValue('kapacita_kamionu_prm');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $stroj = $form->getValue('stroj_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = 0;
                $stav_transakcie = 1;

                $vydaje = new Application_Model_DbTable_Vydaje();
                $count = count($vydaje->getDokladyCislaByDate($datum_vydaju));

//                $max = $count + 1;

                if ($count == 0) {

                    $max = 1;
                }
                else {

                    $last = end($vydaje->getDokladyCislaByDate($datum_vydaju));
                    $max = substr($last, -3);
                    $max += 1;
                }

                $max = sprintf("%03d", $max);


                $nove_meno = "SV-" . $datum_vydaju . "-" .$max; // . ".pdf";
                $doklad_cislo = $nove_meno;

                $vydaje->addVydaj(
                    $datum_vydaju,
                    $sklad,
                    $podsklad,
                    $zakaznik,
                    $prepravca,
                    $prepravca_spz,
                    $q_tony_merane,
                    $q_m3_merane,
                    $q_prm_merane,
                    $q_vlhkost,
                    $kapacita_kamionu_prm,
                    $doklad_typ,
                    $material_typ,
                    $material_druh,
                    $stroj,
                    $poznamka,
                    $chyba,
                    $stav_transakcie,
                    $doklad_cislo);

                //$this->_helper->redirector('list');
                //var_dump( $doklad_cislo);

                //pageManager
                //$this->_helper->redirector($_SESSION['pageManager']['lastPageParameters']['action']);

                $this->getHelper('Redirector')->gotoSimple('preview', 'vydaje', 'skladnik', array('id'=>$doklad_cislo, 'fromAction'=>$fromAction));


            } else {
                $form->populate($formData);

                //pageManager
                //$_SESSION[pageManager][ignore] = 1;
            }
        }
    }

    public function listAction()
    {
        // vytvorenie instancií modelov
        $vydaje = new Application_Model_DbTable_Vydaje();
        $sklady = new Application_Model_DbTable_Sklady();
        $podsklady = new Application_Model_DbTable_Podsklady();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();

        // priradenie modelov do premenných a poslanie na view script
        $param = $this->_getParam('param', null);
        $title = $this->_getParam('title', null);
        if (!isset($title)){$title = 'Výdaje - zoznam';}

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];
        $sql = "vytvoril_u =".$identity;

        // priradenie modelov do premenných a poslanie na view script
        $this->view->vydaje = $vydaje->fetchAll($sql);
        $this->view->sklady = $sklady;
        $this->view->podsklady = $podsklady;
        $this->view->zakaznici = $zakaznici;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;

        //názov stránky
        $this->view->title = "Výdaje - zoznam";
    }

    public function previewAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;

        //inicializacia pre vypis premennych - pre getNazov() metody
        $skladyModel = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $prepravciModel = new Application_Model_DbTable_Prepravci();
        $strojeModel = new Application_Model_DbTable_Stroje();

        $dokladyTypyModel = new Application_Model_DbTable_DokladyTypy();
        $materialyTypyModel = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhyModel = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();

        $ciselniky = array(
            'skladyModel' => $skladyModel,
            'podskladyModel' => $podskladyModel,
            'zakazniciModel' => $zakazniciModel,
            'prepravciModel' => $prepravciModel,
            'strojeModel'=>$strojeModel,
            'dokladyTypyModel' => $dokladyTypyModel,
            'materialyTypyModel' => $materialyTypyModel,
            'materialyDruhyModel' => $materialyDruhyModel,
            'transakcieStavyModel' => $transakcieStavyModel
        );




        $id = $this->_getParam('id');
        $vydaje = new Application_Model_DbTable_Vydaje();
        $vydaj = $vydaje->getVydajByDokladCislo($id);

        $this->view->vydaj = $vydaj;
        $this->view->ciselniky = $ciselniky;
    }

    public function printAction()
    {
        $id = $this->_getParam('ts_vydaje_id', 0);
        $vydaje = new Application_Model_DbTable_Vydaje();
        $this->view->vydaj = $vydaje->getVydaj($id);
    }

    public function noErrorsAction()
    {
        // vytvorenie instancií modelov
        $vydaje = new Application_Model_DbTable_Vydaje();
        $sklady = new Application_Model_DbTable_Sklady();
        $podsklady = new Application_Model_DbTable_Podsklady();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();

        // priradenie modelov do premenných a poslanie na view script
        $param = $this->_getParam('param', null);
        $title = $this->_getParam('title', null);
        if (!isset($title)){$title = 'Výdaje - zoznam';}

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];
        $sql = "vytvoril_u =".$identity ." AND chyba = 0";

        // priradenie modelov do premenných a poslanie na view script
        $this->view->vydaje = $vydaje->fetchAll($sql);
        $this->view->sklady = $sklady;
        $this->view->podsklady = $podsklady;
        $this->view->zakaznici = $zakaznici;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;

        //názov stránky
        $this->view->title = "Výdaje - bez chýb";
    }

    public function errorsAction()
    {
        // vytvorenie instancií modelov
        $vydaje = new Application_Model_DbTable_Vydaje();
        $sklady = new Application_Model_DbTable_Sklady();
        $podsklady = new Application_Model_DbTable_Podsklady();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();

        // priradenie modelov do premenných a poslanie na view script
        $param = $this->_getParam('param', null);
        $title = $this->_getParam('title', null);
        if (!isset($title)){$title = 'Výdaje - zoznam';}

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];
        $sql = "vytvoril_u =".$identity ." AND chyba = 1";

        // priradenie modelov do premenných a poslanie na view script
        $this->view->vydaje = $vydaje->fetchAll($sql);
        $this->view->sklady = $sklady;
        $this->view->podsklady = $podsklady;
        $this->view->zakaznici = $zakaznici;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;

        //názov stránky
        $this->view->title = "Výdaje - chyby";
    }

    public function markAsErrorAction()
    {

        $id = (int)Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $fromAction = Zend_Controller_Front::getInstance()->getRequest()->getParam('fromAction');

        //die($id);
        $vydaje = new Application_Model_DbTable_Vydaje();
        $vydaje->markAsError($id);
        $this->_helper->redirector($fromAction);
        die('mrtvlka');
    }

    public function printtonAction()
    {
        $sklady = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $uzivatelia = new Application_Model_DbTable_Users();

        $this->view->sklady = $sklady;
        $this->view->podsklady = $podskladyModel;
        $this->view->zakaznici = $zakaznici;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->uzivatelia = $uzivatelia;

        $id = $this->_getParam('id', 0);
        $vydaje = new Application_Model_DbTable_Vydaje();
        $this->view->vydaj = $vydaje->getVydaj($id);
    }

    public function printm3Action()
    {
        $sklady = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $uzivatelia = new Application_Model_DbTable_Users();

        $this->view->sklady = $sklady;
        $this->view->podsklady = $podskladyModel;
        $this->view->zakaznici = $zakaznici;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->uzivatelia = $uzivatelia;

        $id = $this->_getParam('id', 0);
        $vydaje = new Application_Model_DbTable_Vydaje();
        $this->view->vydaj = $vydaje->getVydaj($id);
    }

    public function printprmAction()
    {
        $sklady = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $uzivatelia = new Application_Model_DbTable_Users();

        $this->view->sklady = $sklady;
        $this->view->podsklady = $podskladyModel;
        $this->view->zakaznici = $zakaznici;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->uzivatelia = $uzivatelia;

        $id = $this->_getParam('id', 0);
        $vydaje = new Application_Model_DbTable_Vydaje();
        $this->view->vydaj = $vydaje->getVydaj($id);
    }


}





















