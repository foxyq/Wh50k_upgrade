<?php

class InventuryController extends Zend_Controller_Action
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
        $fromController = $this->_getParam('fromController', 'inventury');
        $this->view->fromController = $fromController;


        //instancia modelu z ktoreho budeme tahat zoznam
        $skladyMoznosti = new Application_Model_DbTable_Sklady();
        $podskladyMoznosti = new Application_Model_DbTable_Podsklady();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();

        //metoda ktorou vytiahneme do premennej zoznam
        $skladyMoznosti = $skladyMoznosti->getMoznosti();
        $podskladyMoznosti = $podskladyMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();


        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Vložiť';
        $form = new Application_Form_Inventura(array(
            'skladyMoznosti' => $skladyMoznosti,
            'podskladyMoznosti' => $podskladyMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo,
        ));
        $this->view->form = $form;
        //pageManager
        //$_SESSION[pageManager][ignore] = 1;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
//            var_dump($this->getRequest()->getPost());
            if ($form->isValid($formData)) {
                $datum_inventury = $form->getValue('datum_inventury_d');
                $sklad = $form->getValue('sklad_enum');
                $podsklad = $form->getValue('podsklad_enum');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
//                $code = str_replace('-', '', $datum_vydaju);
//                $code = substr( $code, 2);
//                $doklad_cislo = 'SV'.$code.'-'.substr(uniqid(),6);

                $inventury = new Application_Model_DbTable_Inventury();
                $count = count($inventury->getDokladyCislaByDate($datum_inventury));

//                $max = $count + 1;


                if ($count == 0) {

                    $max = 1;
                }
                else {

                    $last = end($inventury->getDokladyCislaByDate($datum_inventury));
                    $max = substr($last, -3);
                    $max += 1;
                }

                $max = sprintf("%03d", $max);



                $nove_meno = "SI-" . $datum_inventury . "-" .$max; // . ".pdf";
                $doklad_cislo = $nove_meno;

//                echo $doklad_cislo;

                ////////////////////


                $inventury->addInventura(
                    $datum_inventury,
                    $sklad,
                    $podsklad,
                    $q_tony_merane,
                    $q_m3_merane,
                    $q_prm_merane,
                    $q_vlhkost,
                    $doklad_typ,
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
        $fromController = $this->_getParam('fromController', 'inventury');
        $this->view->fromController = $fromController;

        //instancia modelu z ktoreho budeme tahat zoznam
        $skladyMoznosti = new Application_Model_DbTable_Sklady();
        $podskladyMoznosti = new Application_Model_DbTable_Podsklady();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $stroje = new Application_Model_DbTable_Stroje();

        //metoda ktorou vytiahneme do premennej zoznam
        $skladyMoznosti = $skladyMoznosti->getMoznosti();
        $podskladyMoznosti = $podskladyMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();
        $strojeMoznosti = $stroje->getMoznosti();


        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Upraviť';
        $form = new Application_Form_Inventura(array(
            'skladyMoznosti' => $skladyMoznosti,
            'podskladyMoznosti' => $podskladyMoznosti,
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
                $id = (int)$form->getValue('ts_inventury_id');
                $datum_inventury = $form->getValue('datum_inventury_d');
                $sklad = $form->getValue('sklad_enum');
                $podsklad = $form->getValue('podsklad_enum');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
                $inventury = new Application_Model_DbTable_Inventury();
                $inventury->editInventura(
                    $id,
                    $datum_inventury,
                    $sklad,
                    $podsklad,
                    $q_tony_merane,
                    $q_m3_merane,
                    $q_prm_merane,
                    $q_vlhkost,
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
                $inventury = new Application_Model_DbTable_Inventury();
                $form->populate($inventury->getInventuraFormatted($id));
                $this->view->data = $inventury->getInventura($id);

            }
        }
    }

    public function listAction()
    {
        $this->view->title = "Inventúry - list";
    }

    public function listajaxAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $model = new Application_Model_DbTable_Inventury();
        echo $model->getInventuryAjax();
    }

    public function deleteAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'inventury');
        $this->view->fromController = $fromController;
        //inicializacia pre vypis premennych - pre getNazov() metody
        $skladyModel = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $dokladyTypyModel = new Application_Model_DbTable_DokladyTypy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();
        $ciselniky = array(
            'skladyModel' => $skladyModel,
            'podskladyModel' => $podskladyModel,
            'dokladyTypyModel' => $dokladyTypyModel,
            'transakcieStavyModel' => $transakcieStavyModel
        );
        $this->view->ciselniky = $ciselniky;
        $this->view->title = "Zmazať inventuru?";
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Áno') {
                $id = $this->getRequest()->getPost('ts_inventury_id');
                $inventury = new Application_Model_DbTable_Inventury();
                $inventury->deleteInventura($id);
            }
            $this->_helper->redirector($fromAction);
            //pageManager
            //$this->_helper->redirector($_SESSION['pageManager']['lastPageParameters']['action']);
        } else {
            $id = $this->_getParam('id', 0);
            $inventury = new Application_Model_DbTable_Inventury();
            $this->view->inventura = $inventury->getInventura($id);
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
        $fromController = $this->_getParam('fromController', 'inventury');
        $fromId = $this->_getParam('fromId', null);
        $this->view->fromAction = $fromAction;
        $this->view->fromController = $fromController;
        $this->view->fromId = $fromId;

        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        //inicializacia pre vypis premennych - pre getNazov() metody
        $skladyModel = new Application_Model_DbTable_Sklady();
        $podskladyModel = new Application_Model_DbTable_Podsklady();
        $dokladyTypyModel = new Application_Model_DbTable_DokladyTypy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();
        $ciselniky = array(
            'skladyModel' => $skladyModel,
            'podskladyModel' => $podskladyModel,
            'dokladyTypyModel' => $dokladyTypyModel,
            'transakcieStavyModel' => $transakcieStavyModel
        );
        $id = $this->_getParam('id');
        $inventuryModel = new Application_Model_DbTable_Inventury();
        $inventura = $inventuryModel->getInventura($id);
        $this->view->inventura = $inventura;
        $this->view->ciselniky = $ciselniky;
    }



    public function waitingsAction()
    {
        $this->view->title = "Inventúry - čakajúce";
    }
    public function waitingsajaxAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $model = new Application_Model_DbTable_Inventury();
        echo $model->getInventuryWaitingsAjax();
    }

    public function errorsAction()
    {
        $this->view->title = "Inventúry - chybné";
    }
    public function errorsajaxAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $model = new Application_Model_DbTable_Inventury();
        echo $model->getInventuryErrorsAjax();
    }


}

















