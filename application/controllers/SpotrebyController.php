<?php

class SpotrebyController extends Zend_Controller_Action
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
        $fromController = $this->_getParam('fromController', 'spotreby');
        $this->view->fromController = $fromController;


        //instancia modelu z ktoreho budeme tahat zoznam
        $skladyMoznosti = new Application_Model_DbTable_Sklady();
        $podskladyMoznosti = new Application_Model_DbTable_Podsklady();
        $zakazniciMoznosti = new Application_Model_DbTable_Zakaznici();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $stroje = new Application_Model_DbTable_Stroje();

        //metoda ktorou vytiahneme do premennej zoznam
        $skladyMoznosti = $skladyMoznosti->getMoznosti();
        $podskladyMoznosti = $podskladyMoznosti->getMoznosti();
        $zakazniciMoznosti = $zakazniciMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $materialyDruhyMoznosti = $materialyDruhy->getMoznosti();
        $materialyTypyMoznosti = $materialyTypy->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();
        $strojeMoznosti = $stroje->getMoznosti();

        //zoradenie
        asort($zakazniciMoznosti);

        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Vložiť';
        $form = new Application_Form_Spotreba(array(
            'skladyMoznosti' => $skladyMoznosti,
            'podskladyMoznosti' => $podskladyMoznosti,
            'zakazniciMoznosti' => $zakazniciMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'materialyDruhyMoznosti' => $materialyDruhyMoznosti,
            'materialyTypyMoznosti' => $materialyTypyMoznosti,
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
                $datum_spotreby = $form->getValue('datum_spotreby_d');
                $sklad = $form->getValue('sklad_enum');
                $podsklad = $form->getValue('podsklad_enum');
                $zakaznik = $form->getValue('zakaznik_enum');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $stroj = $form->getValue('stroj_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
//                $code = str_replace('-', '', $datum_vydaju);
//                $code = substr( $code, 2);
//                $doklad_cislo = 'SV'.$code.'-'.substr(uniqid(),6);

                $spotreby = new Application_Model_DbTable_Spotreby();
                $count = count($spotreby->getDokladyCislaByDate($datum_spotreby));

//                $max = $count + 1;


                if ($count == 0) {

                    $max = 1;
                }
                else {

                    $last = end($spotreby->getDokladyCislaByDate($datum_spotreby));
                    $max = substr($last, -3);
                    $max += 1;
                }

                $max = sprintf("%03d", $max);



                $nove_meno = "SS-" . $datum_spotreby . "-" .$max; // . ".pdf";
                $doklad_cislo = $nove_meno;

//                echo $doklad_cislo;

                ////////////////////


                $spotreby->addSpotreba(
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
                    $doklad_cislo);
                //$this->_helper->redirector('list');
                //var_dump( $doklad_cislo);
                //pageManager
                //$this->_helper->redirector($_SESSION['pageManager']['lastPageParameters']['action']);
                $this->_helper->redirector($fromAction);
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
        $fromController = $this->_getParam('fromController', 'spotreby');
        $this->view->fromController = $fromController;

        //instancia modelu z ktoreho budeme tahat zoznam
        $skladyMoznosti = new Application_Model_DbTable_Sklady();
        $podskladyMoznosti = new Application_Model_DbTable_Podsklady();
        $zakazniciMoznosti = new Application_Model_DbTable_Zakaznici();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $stroje = new Application_Model_DbTable_Stroje();

        //metoda ktorou vytiahneme do premennej zoznam
        $skladyMoznosti = $skladyMoznosti->getMoznosti();
        $podskladyMoznosti = $podskladyMoznosti->getMoznosti();
        $zakazniciMoznosti = $zakazniciMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $materialyDruhyMoznosti = $materialyDruhy->getMoznosti();
        $materialyTypyMoznosti = $materialyTypy->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();
        $strojeMoznosti = $stroje->getMoznosti();

        //zoradenie
        asort($zakazniciMoznosti);

        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Upraviť';
        $form = new Application_Form_Spotreba(array(
            'skladyMoznosti' => $skladyMoznosti,
            'podskladyMoznosti' => $podskladyMoznosti,
            'zakazniciMoznosti' => $zakazniciMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'materialyDruhyMoznosti' => $materialyDruhyMoznosti,
            'materialyTypyMoznosti' => $materialyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'strojeMoznosti' => $strojeMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo
        ));
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
//            print_r($formData);
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('ts_spotreby_id');
                $datum_spotreby = $form->getValue('datum_spotreby_d');
                $sklad = $form->getValue('sklad_enum');
                $podsklad = $form->getValue('podsklad_enum');
                $zakaznik = $form->getValue('zakaznik_enum');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $stroj = $form->getValue('stroj_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
                $spotreby = new Application_Model_DbTable_Spotreby();
                $spotreby->editSpotreba(
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
                    $stav_transakcie);

                $this->_helper->redirector($fromAction);
            } else {
                $form->populate($formData);

            }
        } else {
            $id = $this->_getParam('id', 0);

            if ($id > 0) {
                $spotreby = new Application_Model_DbTable_Spotreby();
                $form->populate($spotreby->getSpotrebaFormatted($id));
                $this->view->data = $spotreby->getSpotreba($id);

            }
        }
    }

    public function listAction()
    {
        $this->view->title ='Spotreby - list';
    }

    public function listajaxAction(){

        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $spotrebyModel = new Application_Model_DbTable_Spotreby();

        echo $spotrebyModel->getSpotrebyAjax();
    }

    public function deleteAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'spotreby');
        $this->view->fromController = $fromController;
        //inicializacia pre vypis premennych - pre getNazov() metody
        $skladyModel = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $strojeModel = new Application_Model_DbTable_Stroje();
        $dokladyTypyModel = new Application_Model_DbTable_DokladyTypy();
        $materialyTypyModel = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhyModel = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();
        $ciselniky = array(
            'skladyModel' => $skladyModel,
            'podskladyModel' => $podskladyModel,
            'zakazniciModel' => $zakazniciModel,
            'strojeModel'=>$strojeModel,
            'dokladyTypyModel' => $dokladyTypyModel,
            'materialyTypyModel' => $materialyTypyModel,
            'materialyDruhyModel' => $materialyDruhyModel,
            'transakcieStavyModel' => $transakcieStavyModel,
            'strojeMoznosti' => $strojeModel
        );
        $this->view->ciselniky = $ciselniky;
        $this->view->title = "Zmazať spotrebu?";
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Áno') {
                $id = $this->getRequest()->getPost('ts_spotreby_id');
                $spotreby = new Application_Model_DbTable_Spotreby();
                $spotreby->deleteSpotreba($id);
            }
            $this->_helper->redirector($fromAction);
            //pageManager
            //$this->_helper->redirector($_SESSION['pageManager']['lastPageParameters']['action']);
        } else {
            $id = $this->_getParam('id', 0);
            $spotreby = new Application_Model_DbTable_Spotreby();
            $this->view->spotreba = $spotreby->getSpotreba($id);
            //pageManager
            //$_SESSION[pageManager][ignore] = 1;
        }
    }

    public function printAction()
    {
        // action body
    }

    public function previewAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $fromController = $this->_getParam('fromController', 'Vydaje');
        $fromId = $this->_getParam('fromId', null);
        $this->view->fromAction = $fromAction;
        $this->view->fromController = $fromController;
        $this->view->fromId = $fromId;

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
//        $vydaj = $vydaje->getVydajByDokladCislo($id);
        $vydaj = $vydaje->getVydaj($id);
        $this->view->vydaj = $vydaj;
        $this->view->ciselniky = $ciselniky;
    }

    public function waitingsAction()
    {

        $this->view->title = 'Spotreby - čakajúce';
    }

    public function waitingsajaxAction(){

        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $spotrebyModel = new Application_Model_DbTable_Spotreby();

        echo $spotrebyModel->getSpotrebyWaitingsAjax();

    }

    public function errorsAction()
    {
        $this->view->title = 'Spotreby - chybné';
    }

    public function errorsajaxAction(){

        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $spotrebyModel = new Application_Model_DbTable_Spotreby();

        echo $spotrebyModel->getSpotrebyErrorsAjax();
    }

    //tato metoda je obsolete
    public function getspotrebyAction()
    {
        $spotrebyModel = new Application_Model_DbTable_Spotreby();
        echo $spotrebyModel->getSpotrebyAjax();

    }


}



















