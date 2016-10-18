<?php

class ExternadodavkaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction()
    {
        // vytvorenie instancií modelov
        $externeDodavky = new Application_Model_DbTable_ExternaDodavka();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();

        // priradenie modelov do premenných a poslanie na view script
        $param = $this->_getParam('param', null);
        $title = $this->_getParam('title', null);
        if (!isset($title)){$title = 'Externé dodávky - zoznam';}

        // priradenie modelov do premenných a poslanie na view script
        $this->view->externeDodavky = $externeDodavky->fetchAll($param);
        $this->view->externeDodavkyModel = $externeDodavky;
        $this->view->zakaznici = $zakaznici;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;

        //názov stránky
        $this->view->title = "Externá dodávka - zoznam";
    }

    public function waitingsAction()
    {
        // vytvorenie instancií modelov
        $externeDodavky = new Application_Model_DbTable_ExternaDodavka();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();

        // priradenie modelov do premenných a poslanie na view script
        //$param = $this->_getParam('param', null);
        //$title = $this->_getParam('title', null);
        //if (!isset($title)){$title = 'Externé dodávky - zoznam';}

        // priradenie modelov do premenných a poslanie na view script
        $this->view->externeDodavky = $externeDodavky->fetchAll("stav_transakcie = 1");
        $this->view->zakaznici = $zakaznici;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;

        //názov stránky
        $this->view->title = "Externá dodávka - čaká na schválenie";
    }

    public function errorsAction()
    {


        // vytvorenie instancií modelov
        $externeDodavky = new Application_Model_DbTable_ExternaDodavka();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();

        // priradenie modelov do premenných a poslanie na view script
        //$param = $this->_getParam('param', null);
        //$title = $this->_getParam('title', null);
        //if (!isset($title)){$title = 'Externé dodávky - zoznam';}

        // priradenie modelov do premenných a poslanie na view script
        $this->view->externeDodavky = $externeDodavky->fetchAll("chyba = 1");
        $this->view->zakaznici = $zakaznici;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;

        //názov stránky
        $this->view->title = "Externá dodávka - chyby";
    }

    public function addAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'externadodavka');
        $this->view->fromController = $fromController;
        //instancia modelu z ktoreho budeme tahat zoznam

        $zakazniciMoznosti = new Application_Model_DbTable_Zakaznici();
        $prepravciMoznosti = new Application_Model_DbTable_Prepravci();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $dodavateliaModel = new Application_Model_DbTable_Dodavatelia();

        //metoda ktorou vytiahneme do premennej zoznam

        $zakazniciMoznosti = $zakazniciMoznosti->getMoznosti();
        $prepravciMoznosti = $prepravciMoznosti->getMoznosti();
        $materialyDruhyMoznosti = $materialyDruhy->getMoznosti();
        $materialyTypyMoznosti = $materialyTypy->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();
        $dodavateliaMoznosti = $dodavateliaModel->getMoznosti();

        //zoradenie
        asort($zakazniciMoznosti);
        asort($prepravciMoznosti);
        asort($dodavateliaMoznosti);

        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Vložiť';
        $form = new Application_Form_Dodavka(array(
            'zakazniciMoznosti' => $zakazniciMoznosti,
            'prepravciMoznosti' => $prepravciMoznosti,
            'materialyDruhyMoznosti' => $materialyDruhyMoznosti,
            'materialyTypyMoznosti' => $materialyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'dodavateliaMoznosti' => $dodavateliaMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo,
        ));
        $this->view->form = $form;


        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $datum_xdodavky = $form->getValue('datum_xdodavky_d');
                $zakaznik = $form->getValue('zakaznik_enum');
                $dodavatel = $form->getValue('dodavatel_enum');
                $prepravca = $form->getValue('prepravca_enum');
                $prepravca_spz = $form->getValue('prepravca_spz');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
//                $code = str_replace('-', '', $datum_xdodavky);
//                $code = substr( $code, 2);
//                $doklad_cislo = 'ED'.$code.'-'.substr(uniqid(),6);

                $dodavka = new Application_Model_DbTable_ExternaDodavka();

                $count = count($dodavka->getDokladyCislaByDate($datum_xdodavky));

//                $max = $count + 1;

//                $count = count($prijmy->getDokladyCislaByDate($datum_prijmu));
//                $max = $count + 1;

                if ($count == 0) {

                    $max = 1;
                }
                else {

                    $last = end($dodavka->getDokladyCislaByDate($datum_xdodavky));
                    $max = substr($last, -3);
                    $max += 1;
                }

                $max = sprintf("%03d", $max);


                $nove_meno = "ED-" . $datum_xdodavky . "-" .$max; // . ".pdf";
                $doklad_cislo = $nove_meno;
//                echo $doklad_cislo;

                $dodavka->addXDodavka($datum_xdodavky,
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
                    $doklad_cislo);

                $this->_helper->redirector($fromAction);
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'externadodavka');
        $this->view->fromController = $fromController;
        //instancia modelu z ktoreho budeme tahat zoznam

        $zakazniciMoznosti = new Application_Model_DbTable_Zakaznici();
        $prepravciMoznosti = new Application_Model_DbTable_Prepravci();
        $dodavateliaMoznosti = new Application_Model_DbTable_Dodavatelia();

        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();

        //metoda ktorou vytiahneme do premennej zoznam

        $zakazniciMoznosti = $zakazniciMoznosti->getMoznosti();
        $dodavateliaMoznosti = $dodavateliaMoznosti->getMoznosti();
        $prepravciMoznosti = $prepravciMoznosti->getMoznosti();
        $materialyDruhyMoznosti = $materialyDruhy->getMoznosti();
        $materialyTypyMoznosti = $materialyTypy->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();

        //zoradenie
        asort($zakazniciMoznosti);
        asort($prepravciMoznosti);
        asort($dodavateliaMoznosti);

        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Upraviť';
        $form = new Application_Form_Dodavka(array(
            'zakazniciMoznosti' => $zakazniciMoznosti,
            'dodavateliaMoznosti' => $dodavateliaMoznosti,
            'prepravciMoznosti' => $prepravciMoznosti,
            'materialyDruhyMoznosti' => $materialyDruhyMoznosti,
            'materialyTypyMoznosti' => $materialyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo
        ));
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) {
//                $id = (int)$form->getValue('id');
//                $id = $form->getValue('tx_dodavka_id');
                $id = $this->_getParam('id', 0);
                $datum_xdodavky = $form->getValue('datum_xdodavky_d');
                $zakaznik = $form->getValue('zakaznik_enum');
                $dodavatel = $form->getValue('dodavatel_enum');
                $prepravca = $form->getValue('prepravca_enum');
                $prepravca_spz = $form->getValue('prepravca_spz');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $material_typ = $form->getValue('material_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');

                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');

                $dodavka = new Application_Model_DbTable_ExternaDodavka();
                $dodavka->editXDodavka(
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
                    $stav_transakcie);

//                print_r($id);
                $this->_helper->redirector($fromAction);
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);

            if ($id > 0) {
                $dodavka = new Application_Model_DbTable_ExternaDodavka();
                $form->populate($dodavka->getXDodavkaFormatted($id));
                $this->view->data = $dodavka->getXDodavka($id);

            }
        }
    }

    public function previewAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $fromController = $this->_getParam('fromController', 'externadodavka');
        $fromId = $this->_getParam('fromId', null);
        $this->view->fromAction = $fromAction;
        $this->view->fromController = $fromController;
        $this->view->fromId = $fromId;

        //inicializacia pre vypis premennych - pre getNazov() metody

        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $dodavateliaModel = new Application_Model_DbTable_Dodavatelia();
        $prepravciModel = new Application_Model_DbTable_Prepravci();
        $materialyTypyModel = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhyModel = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();
        $ciselniky = array(
            'zakazniciModel' => $zakazniciModel,
            'dodavateliaModel' => $dodavateliaModel,
            'prepravciModel' => $prepravciModel,
            'materialyTypyModel' => $materialyTypyModel,
            'materialyDruhyModel' => $materialyDruhyModel,
            'transakcieStavyModel' => $transakcieStavyModel
        );

        $id = $this->_getParam('id');
        $dodavky = new Application_Model_DbTable_ExternaDodavka();
        $dodavka = $dodavky->getXDodavkaByDokladCislo($id);
        $this->view->dodavka = $dodavka;
        $this->view->ciselniky = $ciselniky;
    }

    public function deleteAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'externadodavka');
        $this->view->fromController = $fromController;
        //inicializacia pre vypis premennych - pre getNazov() metody

        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $dodavateliaModel = new Application_Model_DbTable_Dodavatelia();
        $prepravciModel = new Application_Model_DbTable_Prepravci();
        $materialyTypyModel = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhyModel = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();
        $ciselniky = array(

            'zakazniciModel' => $zakazniciModel,
            'dodavateliaModel' => $dodavateliaModel,
            'prepravciModel' => $prepravciModel,
            'materialyTypyModel' => $materialyTypyModel,
            'materialyDruhyModel' => $materialyDruhyModel,
            'transakcieStavyModel' => $transakcieStavyModel
        );
        $this->view->ciselniky = $ciselniky;
        $this->view->title = "Zmazať externú dodávku?";
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Áno') {
                $id = $this->getRequest()->getPost('tx_dodavka_id');
                $dodavka = new Application_Model_DbTable_ExternaDodavka();
                $dodavka->deleteXDodavka($id);
            }
            $this->_helper->redirector($fromAction);


        } else {
            $id = $this->_getParam('id', 0);
            $dodavka = new Application_Model_DbTable_ExternaDodavka();
            $this->view->dodavka = $dodavka->getXDodavka($id);

        }
    }

    public function printAction()
    {
        // action body
    }


}

















