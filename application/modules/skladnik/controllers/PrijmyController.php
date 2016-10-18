<?php

class Skladnik_PrijmyController extends Zend_Controller_Action
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
        // action body
    }

    public function listAction()
    {

        // vytvorenie instancií modelov
        $prijmy = new Application_Model_DbTable_Prijmy();
        $sklady = new Application_Model_DbTable_Sklady();
        $podsklady = new Application_Model_DbTable_Podsklady();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();


        // priradenie modelov do premenných a poslanie na view script
        //$param = $this->_getParam('param', null);
        //$title = $this->_getParam('title', null);
        //if (!isset($title)){$title = 'Príjmy - zoznam';}

        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];
        $sql = "vytvoril_u =".$identity;

        $this->view->prijmy = $prijmy->fetchAll($sql);

        $this->view->sklady = $sklady;
        $this->view->podsklady = $podsklady;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;

        //názov stránky
        $this->view->title = "Príjmy - zoznam";

    }

    public function printAction()
    {
        $id = $this->_getParam('id', 0);
        $prijmy = new Application_Model_DbTable_Prijmy();
        $this->view->prijem = $prijmy->getPrijem($id);
    }

    public function previewAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;

        //inicializacia pre vypis premennych - pre getNazov() metody
        $skladyModel = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $dodavateliaModel = new Application_Model_DbTable_Dodavatelia();
        $prepravciModel = new Application_Model_DbTable_Prepravci();
        $dokladyTypyModel = new Application_Model_DbTable_DokladyTypy();
        $materialyTypyModel = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhyModel = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();

        $ciselniky = array(
            'skladyModel' => $skladyModel,
            'podskladyModel' => $podskladyModel,
            'dodavateliaModel' => $dodavateliaModel,
            'prepravciModel' => $prepravciModel,
            'dokladyTypyModel' => $dokladyTypyModel,
            'materialyTypyModel' => $materialyTypyModel,
            'materialyDruhyModel' => $materialyDruhyModel,
            'transakcieStavyModel' => $transakcieStavyModel
        );

        $id = $this->_getParam('id');
        $prijmy = new Application_Model_DbTable_Prijmy();
        $prijem = $prijmy->getPrijemByDokladCislo($id);

        $this->view->prijem = $prijem;
        $this->view->ciselniky = $ciselniky;
    }

    public function addtonAction()
    {
         /* ak chces pouzit vo forme zoznam z tabuliek, musis najpr vytvorit instanciu modelu
        a metodou getMoznosti dostanes do premennej pole s moznostami so strukturou id a nazov
        nasledne toto pole das do pola ktore je ako parameter pre form*/
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;

        //instancia modelu z ktoreho budeme tahat zoznam
        $skladyMoznosti = new Application_Model_DbTable_Sklady();
        $podskladyMoznosti = new Application_Model_DbTable_Podsklady();
        $dodavateliaMoznosti = new Application_Model_DbTable_Dodavatelia();
        $prepravciMoznosti = new Application_Model_DbTable_Prepravci();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();



        //metoda ktorou vytiahneme do premennej zoznam
        $skladyMoznosti = $skladyMoznosti->getMoznosti();
        $podskladyMoznosti = $podskladyMoznosti->getMoznosti();
        $dodavateliaMoznosti = $dodavateliaMoznosti->getMoznosti();
        $prepravciMoznosti = $prepravciMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $materialyDruhyMoznosti = $materialyDruhy->getMoznosti();
        $materialyTypyMoznosti = $materialyTypy->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();


        //zoradenie
        asort($dodavateliaMoznosti);
        asort($prepravciMoznosti);

        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Vložiť';

        //vytvorime form a v paramatre mu tam posleme nase pole
        $form = new Application_Form_Prijem(array(
            'skladyMoznosti' => $skladyMoznosti,
            'podskladyMoznosti' => $podskladyMoznosti,
            'dodavateliaMoznosti' => $dodavateliaMoznosti,
            'prepravciMoznosti' => $prepravciMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'materialyDruhyMoznosti' => $materialyDruhyMoznosti,
            'materialyTypyMoznosti' => $materialyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo
        ));

//        $form->getElement('datum_prijmu_d')->setAttribs(array(
//            'disabled' => 'disabled'));

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $datum_prijmu = $form->getValue('datum_prijmu_d');
                $sklad = $form->getValue('sklad_enum');
                $podsklad = $form->getValue('podsklad_enum');
                $dodavatel = $form->getValue('dodavatel_enum');
                $prepravca = $form->getValue('prepravca_enum');
                $prepravca_spz = $form->getValue('prepravca_spz');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_tony_nadrozmer = $form->getValue('q_tony_nadrozmer');
                $q_tony_brutto = $form->getValue('q_tony_brutto');
                $q_tony_tara = $form->getValue('q_tony_tara');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = 0;
                $stav_transakcie = 1;
                $material_poznamka = $form->getValue('material_poznamka');


//                $code = str_replace('-', '', $datum_prijmu);
//                $code = substr( $code, 2);

                $prijmy = new Application_Model_DbTable_Prijmy();

                $count = count($prijmy->getDokladyCislaByDate($datum_prijmu));
//                $max = $count + 1;


                if ($count == 0) {

                    $max = 1;
                }
                else {

                    $last = end($prijmy->getDokladyCislaByDate($datum_prijmu));
                    $max = substr($last, -3);
                    $max += 1;
                }

                $max = sprintf("%03d", $max);





                $nove_meno = "SP-" . $datum_prijmu . "-" .$max; // . ".pdf";
                $doklad_cislo = $nove_meno;


                $prijmy->addPrijem(
                    $datum_prijmu,
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
                    $material_poznamka);


//                    print_r($datum_prijmu);

                //$this->_helper->redirector('list');
                $this->getHelper('Redirector')->gotoSimple('preview', 'prijmy', 'skladnik', array('id'=>$doklad_cislo, 'fromAction'=>$fromAction));
            } else {


                $form->populate($formData);

            }

        }
    }

    public function addprmAction()
    {
         /* ak chces pouzit vo forme zoznam z tabuliek, musis najpr vytvorit instanciu modelu
        a metodou getMoznosti dostanes do premennej pole s moznostami so strukturou id a nazov
        nasledne toto pole das do pola ktore je ako parameter pre form*/
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;

        //instancia modelu z ktoreho budeme tahat zoznam
        $skladyMoznosti = new Application_Model_DbTable_Sklady();
        $podskladyMoznosti = new Application_Model_DbTable_Podsklady();
        $dodavateliaMoznosti = new Application_Model_DbTable_Dodavatelia();
        $prepravciMoznosti = new Application_Model_DbTable_Prepravci();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();



        //metoda ktorou vytiahneme do premennej zoznam
        $skladyMoznosti = $skladyMoznosti->getMoznosti();
        $podskladyMoznosti = $podskladyMoznosti->getMoznosti();
        $dodavateliaMoznosti = $dodavateliaMoznosti->getMoznosti();
        $prepravciMoznosti = $prepravciMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $materialyDruhyMoznosti = $materialyDruhy->getMoznosti();
        $materialyTypyMoznosti = $materialyTypy->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();

        //zoradenie
        asort($dodavateliaMoznosti);
        asort($prepravciMoznosti);
        

        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Vložiť';

        //vytvorime form a v paramatre mu tam posleme nase pole
        $form = new Application_Form_Prijem(array(
            'skladyMoznosti' => $skladyMoznosti,
            'podskladyMoznosti' => $podskladyMoznosti,
            'dodavateliaMoznosti' => $dodavateliaMoznosti,
            'prepravciMoznosti' => $prepravciMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'materialyDruhyMoznosti' => $materialyDruhyMoznosti,
            'materialyTypyMoznosti' => $materialyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo
        ));
//        $form->getElement('datum_prijmu_d')->setAttribs(array(
//            'disabled' => 'disabled'));

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $datum_prijmu = $form->getValue('datum_prijmu_d');
                $sklad = $form->getValue('sklad_enum');
                $podsklad = $form->getValue('podsklad_enum');
                $dodavatel = $form->getValue('dodavatel_enum');
                $prepravca = $form->getValue('prepravca_enum');
                $prepravca_spz = $form->getValue('prepravca_spz');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_tony_nadrozmer = $form->getValue('q_tony_nadrozmer');
                $q_tony_brutto = $form->getValue('q_tony_brutto');
                $q_tony_tara = $form->getValue('q_tony_tara');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = 0;
                $stav_transakcie = 1;
                $material_poznamka = $form->getValue('material_poznamka');


                $prijmy = new Application_Model_DbTable_Prijmy();

                $count = count($prijmy->getDokladyCislaByDate($datum_prijmu));
//                $max = $count + 1;

                if ($count == 0) {

                    $max = 1;
                }
                else {

                    $last = end($prijmy->getDokladyCislaByDate($datum_prijmu));
                    $max = substr($last, -3);
                    $max += 1;
                }

                $max = sprintf("%03d", $max);


                $nove_meno = "SP-" . $datum_prijmu . "-" .$max; // . ".pdf";
                $doklad_cislo = $nove_meno;

                $prijmy->addPrijem(
                    $datum_prijmu,
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
                    $material_poznamka);


                //$this->_helper->redirector('list');
                $this->getHelper('Redirector')->gotoSimple('preview', 'prijmy', 'skladnik', array('id'=>$doklad_cislo, 'fromAction'=>$fromAction));
            } else {


                $form->populate($formData);

            }

        }
    }

    public function addm3Action()
    {
         /* ak chces pouzit vo forme zoznam z tabuliek, musis najpr vytvorit instanciu modelu
        a metodou getMoznosti dostanes do premennej pole s moznostami so strukturou id a nazov
        nasledne toto pole das do pola ktore je ako parameter pre form*/
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;

        //instancia modelu z ktoreho budeme tahat zoznam
        $skladyMoznosti = new Application_Model_DbTable_Sklady();
        $podskladyMoznosti = new Application_Model_DbTable_Podsklady();
        $dodavateliaMoznosti = new Application_Model_DbTable_Dodavatelia();
        $prepravciMoznosti = new Application_Model_DbTable_Prepravci();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();



        //metoda ktorou vytiahneme do premennej zoznam
        $skladyMoznosti = $skladyMoznosti->getMoznosti();
        $podskladyMoznosti = $podskladyMoznosti->getMoznosti();
        $dodavateliaMoznosti = $dodavateliaMoznosti->getMoznosti();
        $prepravciMoznosti = $prepravciMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $materialyDruhyMoznosti = $materialyDruhy->getMoznosti();
        $materialyTypyMoznosti = $materialyTypy->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();


        //zoradenie
        asort($dodavateliaMoznosti);
        asort($prepravciMoznosti);
        
        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Vložiť';

        //vytvorime form a v paramatre mu tam posleme nase pole
        $form = new Application_Form_Prijem(array(
            'skladyMoznosti' => $skladyMoznosti,
            'podskladyMoznosti' => $podskladyMoznosti,
            'dodavateliaMoznosti' => $dodavateliaMoznosti,
            'prepravciMoznosti' => $prepravciMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'materialyDruhyMoznosti' => $materialyDruhyMoznosti,
            'materialyTypyMoznosti' => $materialyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo
        ));
//        $form->getElement('datum_prijmu_d')->setAttribs(array(
//            'disabled' => 'disabled'));

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $datum_prijmu = $form->getValue('datum_prijmu_d');
                $sklad = $form->getValue('sklad_enum');
                $podsklad = $form->getValue('podsklad_enum');
                $dodavatel = $form->getValue('dodavatel_enum');
                $prepravca = $form->getValue('prepravca_enum');
                $prepravca_spz = $form->getValue('prepravca_spz');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_tony_nadrozmer = $form->getValue('q_tony_nadrozmer');
                $q_tony_brutto = $form->getValue('q_tony_brutto');
                $q_tony_tara = $form->getValue('q_tony_tara');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = 0;
                $stav_transakcie = 1;
                $material_poznamka = $form->getValue('material_poznamka');


                $prijmy = new Application_Model_DbTable_Prijmy();

                $count = count($prijmy->getDokladyCislaByDate($datum_prijmu));
//                $max = $count + 1;


                if ($count == 0) {

                    $max = 1;
                }
                else {

                    $last = end($prijmy->getDokladyCislaByDate($datum_prijmu));
                    $max = substr($last, -3);
                    $max += 1;
                }

                $max = sprintf("%03d", $max);

                $nove_meno = "SP-" . $datum_prijmu . "-" .$max; // . ".pdf";
                $doklad_cislo = $nove_meno;

                $prijmy->addPrijem(
                    $datum_prijmu,
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
                    $material_poznamka);


                //$this->_helper->redirector('list');
                $this->getHelper('Redirector')->gotoSimple('preview', 'prijmy', 'skladnik', array('id'=>$doklad_cislo, 'fromAction'=>$fromAction));
            } else {


                $form->populate($formData);

            }

        }
    }

    public function markAsErrorAction()
    {
        $id = (int)Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $fromAction = Zend_Controller_Front::getInstance()->getRequest()->getParam('fromAction');
        //print_r($id);
        $prijmy = new Application_Model_DbTable_Prijmy();
        $prijmy->markAsError($id);
        $this->_helper->redirector($fromAction);
    }

    public function errorsAction()
    {
        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];
        $sql = "chyba = 1 AND vytvoril_u =".$identity;

        // vytvorenie instancií modelov
        $prijmy = new Application_Model_DbTable_Prijmy();
        $sklady = new Application_Model_DbTable_Sklady();
        $podsklady = new Application_Model_DbTable_Podsklady();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();

        $this->view->prijmy = $prijmy->fetchAll($sql);

        $this->view->sklady = $sklady;
        $this->view->podsklady = $podsklady;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;

        //názov stránky
        $this->view->title = "Príjmy - chyby";
    }

    public function noErrorsAction()
    {
        $identity = (array) Zend_Auth::getInstance()->getIdentity();
        $identity = (int) $identity['id'];
        $sql = "chyba = 0 AND vytvoril_u =".$identity;

        // vytvorenie instancií modelov
        $prijmy = new Application_Model_DbTable_Prijmy();
        $sklady = new Application_Model_DbTable_Sklady();
        $podsklady = new Application_Model_DbTable_Podsklady();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();

        $this->view->prijmy = $prijmy->fetchAll($sql);

        $this->view->sklady = $sklady;
        $this->view->podsklady = $podsklady;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;

        //názov stránky
        $this->view->title = "Príjmy - bez chýb";
    }

    public function printtonAction()
    {
        $sklady = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $uzivatelia = new Application_Model_DbTable_Users();

        $this->view->sklady = $sklady;
        $this->view->podsklady = $podskladyModel;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->uzivatelia = $uzivatelia;

        $id = $this->_getParam('id', 0);
        $prijmy = new Application_Model_DbTable_Prijmy();
        $this->view->prijem = $prijmy->getPrijem($id);
    }

    public function printprmAction()
    {
        $sklady = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $uzivatelia = new Application_Model_DbTable_Users();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();

        $this->view->sklady = $sklady;
        $this->view->podsklady = $podskladyModel;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->uzivatelia = $uzivatelia;

        $id = $this->_getParam('id', 0);
        $prijmy = new Application_Model_DbTable_Prijmy();
        $this->view->prijem = $prijmy->getPrijem($id);
    }

    public function printm3Action()
    {
        $sklady = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $uzivatelia = new Application_Model_DbTable_Users();

        $this->view->sklady = $sklady;
        $this->view->podsklady = $podskladyModel;
        $this->view->uzivatelia = $uzivatelia;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;

        $id = $this->_getParam('id', 0);
        $prijmy = new Application_Model_DbTable_Prijmy();
        $this->view->prijem = $prijmy->getPrijem($id);
    }


}





























