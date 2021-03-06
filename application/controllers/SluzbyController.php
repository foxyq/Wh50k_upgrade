<?php

class SluzbyController extends Zend_Controller_Action
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
        $fromController = $this->_getParam('fromController', 'sluzby');
        $this->view->fromController = $fromController;


        //instancia modelu z ktoreho budeme tahat zoznam
        $zakazniciSluzbyMoznosti = new Application_Model_DbTable_ZakazniciSluzby();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $stroje = new Application_Model_DbTable_Stroje();

        //metoda ktorou vytiahneme do premennej zoznam
        $zakazniciSluzbyMoznosti = $zakazniciSluzbyMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();
        $strojeMoznosti = $stroje->getMoznosti();

        //zoradenie
        asort($zakazniciSluzbyMoznosti);

        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Vložiť';
        $form = new Application_Form_Sluzba(array(
            'zakazniciSluzbyMoznosti' => $zakazniciSluzbyMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'strojeMoznosti' => $strojeMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo,
        ));
        $this->view->form = $form;
        //pageManager
        //$_SESSION[pageManager][ignore] = 1;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
//            var_dump($this->getRequest()->getPost());
            if ($form->isValid($formData)) {
                $datum_sluzby_od = $form->getValue('datum_sluzby_od_d');
                $datum_sluzby_do = $form->getValue('datum_sluzby_do_d');
                $zakaznik = $form->getValue('zakaznik_enum');
                $miestoStiepenia = $form->getValue('miesto_stiepenia');
                $q_tony = $form->getValue('q_tony');
                $q_prm = $form->getValue('q_prm');
                $q_motohodiny = $form->getValue('q_motohodiny');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $stroj = $form->getValue('stroj_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
//                $code = str_replace('-', '', $datum_vydaju);
//                $code = substr( $code, 2);
//                $doklad_cislo = 'SV'.$code.'-'.substr(uniqid(),6);

                $sluzby = new Application_Model_DbTable_Sluzby();
                $count = count($sluzby->getDokladyCislaByDate($datum_sluzby_od));

//                $max = $count + 1;


                if ($count == 0) {

                    $max = 1;
                }
                else {

                    $last = end($sluzby->getDokladyCislaByDate($datum_sluzby_od));
                    $max = substr($last, -3);
                    $max += 1;
                }

                $max = sprintf("%03d", $max);



                $nove_meno = "SL-" . $datum_sluzby_od . "-" .$max; // . ".pdf";
                $doklad_cislo = $nove_meno;

//                echo $doklad_cislo;

                ////////////////////


                $sluzby->addSluzba(
                    $datum_sluzby_od,
                    $datum_sluzby_do,
                    $zakaznik,
                    $miestoStiepenia,
                    $stroj,
                    $q_tony,
                    $q_prm,
                    $q_motohodiny,
                    $doklad_typ,
                    $poznamka,
                    $chyba,
                    $stav_transakcie,
                    $doklad_cislo);

                //$this->_helper->redirector('list');
                //var_dump( $doklad_cislo);
                //pageManager
                //$this->_helper->redirector($_SESSION['pageManager']['lastPageParameters']['action']);

                //$this->_helper->redirector($fromAction);
                $this->_helper->redirector("list");

            } else {
                $form->populate($formData);
                //pageManager
                //$_SESSION[pageManager][ignore] = 1;
            }
        }
    }

    public function editAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'sluzby');
        $this->view->fromController = $fromController;

        //instancia modelu z ktoreho budeme tahat zoznam
        $zakazniciSluzbyMoznosti = new Application_Model_DbTable_ZakazniciSluzby();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $stroje = new Application_Model_DbTable_Stroje();

        //metoda ktorou vytiahneme do premennej zoznam
        $zakazniciSluzbyMoznosti = $zakazniciSluzbyMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();
        $strojeMoznosti = $stroje->getMoznosti();

        //zoradenie
        asort($zakazniciSluzbyMoznosti);

        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Upraviť';
        $form = new Application_Form_Sluzba(array(
            'zakazniciSluzbyMoznosti' => $zakazniciSluzbyMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'strojeMoznosti' => $strojeMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo
        ));
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
//            print_r($formData);
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('t_sluzby_id');
                $datum_sluzby_od = $form->getValue('datum_sluzby_od_d');
                $datum_sluzby_do = $form->getValue('datum_sluzby_do_d');
                $zakaznik = $form->getValue('zakaznik_enum');
                $q_tony = $form->getValue('q_tony');
                $q_prm = $form->getValue('q_prm');
                $q_motohodiny = $form->getValue('q_motohodiny');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $stroj = $form->getValue('stroj_enum');
                $miestoStiepenia = $form->getValue('miesto_stiepenia');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');

                $sluzby = new Application_Model_DbTable_Sluzby();
                $sluzby->editSluzba(
                    $id,
                    $datum_sluzby_od,
                    $datum_sluzby_do,
                    $zakaznik,
                    $miestoStiepenia,
                    $stroj,
                    $q_tony,
                    $q_prm,
                    $q_motohodiny,
                    $doklad_typ,
                    $poznamka,
                    $chyba,
                    $stav_transakcie);

                $this->_helper->redirector($fromAction);
            } else {
                $form->populate($formData);

            }
        } else {
            $id = $this->_getParam('id', 0);

            if ($id > 0) {
                $sluzby = new Application_Model_DbTable_Sluzby();
                $form->populate($sluzby->getSluzbaFormatted($id));
                $this->view->data = $sluzby->getSluzba($id);

            }
        }
    }

    public function deleteAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'sluzby');
        $this->view->fromController = $fromController;
        //inicializacia pre vypis premennych - pre getNazov() metody
        $zakazniciSluzbyModel = new Application_Model_DbTable_ZakazniciSluzby();
        $strojeModel = new Application_Model_DbTable_Stroje();
        $dokladyTypyModel = new Application_Model_DbTable_DokladyTypy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();
        $ciselniky = array(
            'zakazniciModel' => $zakazniciSluzbyModel,
            'strojeModel'=>$strojeModel,
            'dokladyTypyModel' => $dokladyTypyModel,
            'transakcieStavyModel' => $transakcieStavyModel,
            'strojeMoznosti' => $strojeModel
        );
        $this->view->ciselniky = $ciselniky;
        $this->view->title = "Zmazať službu?";
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Áno') {
                $id = $this->getRequest()->getPost('t_sluzby_id');
                $sluzby = new Application_Model_DbTable_Sluzby();
                $sluzby->deleteSluzba($id);
            }
            $this->_helper->redirector($fromAction);
            //pageManager
            //$this->_helper->redirector($_SESSION['pageManager']['lastPageParameters']['action']);
        } else {
            $id = $this->_getParam('id', 0);
            $sluzby = new Application_Model_DbTable_Sluzby();
            $this->view->sluzba = $sluzby->getSluzba($id);
            //pageManager
            //$_SESSION[pageManager][ignore] = 1;
        }
    }

    public function listAction()
    {
        $this->view->title = "Služby - list";
    }

    public function listajaxAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $sluzbyModel = new Application_Model_DbTable_Sluzby();
        echo $sluzbyModel->getSluzbyAjax();
    }

    public function printAction()
    {
        // action body
    }

    public function previewAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $fromController = $this->_getParam('fromController', 'Sluzby');
        $fromId = $this->_getParam('fromId', null);
        $this->view->fromAction = $fromAction;
        $this->view->fromController = $fromController;
        $this->view->fromId = $fromId;

        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        //inicializacia pre vypis premennych - pre getNazov() metody
        $skladyModel = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $zakazniciSluzbyModel = new Application_Model_DbTable_ZakazniciSluzby();
        $prepravciModel = new Application_Model_DbTable_Prepravci();
        $strojeModel = new Application_Model_DbTable_Stroje();
        $dokladyTypyModel = new Application_Model_DbTable_DokladyTypy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();
        $ciselniky = array(
            'skladyModel' => $skladyModel,
            'podskladyModel' => $podskladyModel,
            'zakazniciSluzbyModel' => $zakazniciSluzbyModel,
            'prepravciModel' => $prepravciModel,
            'strojeModel'=>$strojeModel,
            'dokladyTypyModel' => $dokladyTypyModel,
            'transakcieStavyModel' => $transakcieStavyModel
        );
        $id = $this->_getParam('id');
        $sluzby = new Application_Model_DbTable_Sluzby();
        $sluzba = $sluzby->getSluzba($id);
        $this->view->sluzba = $sluzba;
        $this->view->ciselniky = $ciselniky;
    }

    public function waitingsAction()
    {
        $this->view->title = "Služby - čakajúce";
    }

    public function waitingsajaxAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $sluzbyModel = new Application_Model_DbTable_Sluzby();
        echo $sluzbyModel->getSluzbyWaitingsAjax();
    }

    public function errorsAction()
    {
        $this->view->title = "Služby - chybné";
    }

    public function errorsajaxAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $sluzbyModel = new Application_Model_DbTable_Sluzby();
        echo $sluzbyModel->getSluzbyErrorsAjax();
    }

}

















