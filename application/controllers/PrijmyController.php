<?php
class PrijmyController extends Zend_Controller_Action
{
    protected $_request = null;
    public function init()
    {
//        celkom dolezite pre jquery ...
        $this->view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
    }
    public function indexAction()
    {
        // action body
        $this->view->message = 'Stránka kde sa bude zobrazovať prehľad za príjmy.';
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
        $this->view->prijmy = $prijmy->fetchAll();
        $this->view->prijmyModel = $prijmy;
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
    public function addAction()
    {

        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'prijmy');
        $this->view->fromController = $fromController;
        /* ak chces pouzit vo forme zoznam z tabuliek, musis najpr vytvorit instanciu modelu
        a metodou getMoznosti dostanes do premennej pole s moznostami so strukturou id a nazov
        nasledne toto pole das do pola ktore je ako parameter pre form*/


        //instancia modelu z ktoreho budeme tahat zoznam
        $prijmy = new Application_Model_DbTable_Prijmy();
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
        $this->view->form = $form;
        //pageManager
        $_SESSION[pageManager][ignore] = 1;
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
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
                $material_poznamka = $form->getValue('material_poznamka');

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


                $prijmy = new Application_Model_DbTable_Prijmy();
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
//
//                print_r($doklad_cislo);

//                echo "<br>";

//                print_r($last);

                $this->_helper->redirector($fromAction);
            } else {
                $form->populate($formData);
                //pageManager
//                $_SESSION[pageManager][ignore] = 1;
            }
        }
    }
    /* OLD VERSION
    public function editAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'prijmy');
        $this->view->fromController = $fromController;

        //$request = $this->getRequest()->getServer('HTTP_REFERER');
        //print_r($request);
        //TDODO THIS: print_r( $this->_request);

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
        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Upraviť';
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
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            //tu musi byt premenne $id pretoze podla toho on upravuje a nacitava data
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('ts_prijmy_id');
                $datum_prijmu = $form->getValue('datum_prijmu_d');
                $sklad = $form->getValue('sklad_enum');
                $podsklad = $form->getValue('podsklad_enum');
                $dodavatel = $form->getValue('dodavatel_enum');
                $prepravca = $form->getValue('prepravca_enum');
                $prepravca_spz = $form->getValue('prepravca_spz');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_tony_nadrozmer = $form->getValue('q_tony_nadrozmer');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
//                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
//                var_dump($datum_prijmu);
                $prijmy = new Application_Model_DbTable_Prijmy();
                $prijmy->editPrijem(
                    $id,
                    $datum_prijmu,
                    $sklad,
                    $podsklad,
                    $dodavatel,
                    $prepravca,
                    $prepravca_spz,
                    $q_tony_merane,
                    $q_tony_nadrozmer,
                    $q_m3_merane,
                    $q_prm_merane,
                    $q_vlhkost,
//                    $doklad_typ,
                    $material_druh,
                    $material_typ,
                    $poznamka,
                    $chyba,
                    $stav_transakcie
                );
                $this->_helper->redirector($fromAction);
                //pageManager
                //$this->_helper->redirector($_SESSION['pageManager']['lastPageParameters']['action']);
            } else {
                $form->populate($formData);
                //pageManager
                //$_SESSION[pageManager][ignore] = 1;
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $prijmy = new Application_Model_DbTable_Prijmy();
                $form->populate($prijmy->getPrijemFormatted($id));
                $this->view->data = $prijmy->getPrijem($id);
                //pageManager
                //$_SESSION[pageManager][ignore] = 1;
            }
        }
    }*/

    public function deleteAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'prijmy');
        $this->view->fromController = $fromController;
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
        $this->view->ciselniky = $ciselniky;
        /*  kontrola ci prisiel post alebo get
            ak pride post - tak mazeme
            ak pride get - tak posielam do formulara, kde sa pytame ci skutocne vymazat
        */
        //ak pride POST
    
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            //ak prisiel POST a v premennej del je hodnota Yes tak zmaze
            if ($del == 'Áno') {
                $id = $this->getRequest()->getPost('id');
                $prijmy = new Application_Model_DbTable_Prijmy();
                $prijmy->deletePrijem($id);
            }
            //presmeruje po zmazani na stranku list
            $this->_helper->redirector($fromAction);
            //pageManager
            //$this->_helper->redirector($_SESSION['pageManager']['lastPageParameters']['action']);
            //ak pride GET tak nacita model a posle na kontrolny vypis a otazku zmazat? data zo zaznamu
        } else {
            $id = $this->_getParam('id', 0);
            $prijmy = new Application_Model_DbTable_Prijmy();
            $this->view->prijem = $prijmy->getPrijem($id);
            //pageManager
            //$_SESSION[pageManager][ignore] = 1;
        }
    }

    //NEW VERSION
        public function editAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'prijmy');
        $this->view->fromController = $fromController;

        //$request = $this->getRequest()->getServer('HTTP_REFERER');
        //print_r($request);
        //TDODO THIS: print_r( $this->_request);

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
        $potvrdzujuceTlacidlo = 'Upraviť';
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
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            //tu musi byt premenne $id pretoze podla toho on upravuje a nacitava data
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('ts_prijmy_id');
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
//                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
                $material_poznamka = $form->getValue('material_poznamka');
//                var_dump($datum_prijmu);
                $prijmy = new Application_Model_DbTable_Prijmy();
                $prijmy->editPrijem(
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
//                    $doklad_typ,
                    $material_druh,
                    $material_typ,
                    $poznamka,
                    $chyba,
                    $stav_transakcie,
                    $material_poznamka
                );
                $this->_helper->redirector($fromAction);
                //pageManager
                //$this->_helper->redirector($_SESSION['pageManager']['lastPageParameters']['action']);
            } else {
                $form->populate($formData);
                //pageManager
                //$_SESSION[pageManager][ignore] = 1;
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $prijmy = new Application_Model_DbTable_Prijmy();
                $form->populate($prijmy->getPrijemFormatted($id));
                $this->view->data = $prijmy->getPrijem($id);
                //pageManager
                //$_SESSION[pageManager][ignore] = 1;
            }
        }
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
        $fromController = $this->_getParam('fromController', 'prijmy');
        $fromId = $this->_getParam('fromId', null);
        $this->view->fromAction = $fromAction;
        $this->view->fromController = $fromController;
        $this->view->fromId = $fromId;

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
        $prijem = $prijmy->getPrijem($id);
        $this->view->prijem = $prijem;
        $this->view->ciselniky = $ciselniky;
    }
    public function waitingsAction()
    {
        //$param = "stav_transakcie = 1";
        //$title = "Príjmy - čaká na schválenie";
        //$this->_forward('list', 'prijmy', null, array('param' => $param, 'title' => $title));
        // vytvorenie instancií modelov
        $prijmy = new Application_Model_DbTable_Prijmy();
        $sklady = new Application_Model_DbTable_Sklady();
        $podsklady = new Application_Model_DbTable_Podsklady();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $this->view->prijmy = $prijmy->fetchAll("stav_transakcie = 1");
        $this->view->sklady = $sklady;
        $this->view->podsklady = $podsklady;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;
        //názov stránky
        $this->view->title ='Príjmy - čaká na schválenie';
    }
    public function errorsAction()
    {
        //$param = "chyba = 1";
        //$title = "Príjmy - chyby";
        //$this->_forward('list', 'prijmy', null, array('param' => $param, 'title' => $title));
        // vytvorenie instancií modelov
        $prijmy = new Application_Model_DbTable_Prijmy();
        $sklady = new Application_Model_DbTable_Sklady();
        $podsklady = new Application_Model_DbTable_Podsklady();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $this->view->prijmy = $prijmy->fetchAll("chyba = 1");
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
}
