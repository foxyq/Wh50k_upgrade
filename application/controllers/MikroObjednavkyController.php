<?php

class MikroobjednavkyController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction()
    {
        $mikroObjednavkyModel = new Application_Model_DbTable_MikroObjednavky();
        $objednavkyModel = new Application_Model_DbTable_Objednavky();
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xdodavkyModel = new Application_Model_DbTable_ExternaDodavka();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();

        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

        $this->view->mikroObjednavky = $mikroObjednavkyModel->fetchAll();
        $this->view->mikroObjednavkyModel = $mikroObjednavkyModel;
        $this->view->objednavkyModel = $objednavkyModel;
        $this->view->zakazniciModel = $zakazniciModel;
        $this->view->merneJednotkyModel = $merneJednotkyModel;
        $this->view->vydajeModel = $vydajeModel;
        $this->view->xvyrobyModel = $xvyrobyModel;
        $this->view->xdodavkyModel = $xdodavkyModel;

        $this->view->title = "Mikro objednávky - zoznam";
    }

    public function addAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'mikroobjednavky');
        $this->view->fromController = $fromController;

        /*
         * Data pre ciselniky
         */
        $mikroObjednavkyModel = new Application_Model_DbTable_MikroObjednavky();
        $objednavkyModel = new Application_Model_DbTable_Objednavky();
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

        $zakazniciMoznosti = $zakazniciModel->getMoznosti();
        $merneJednotkyMoznosti = $merneJednotkyModel->getMoznosti();
        $objednavkyMoznosti = $objednavkyModel->getMoznosti();

        //zoradenie
        asort($zakazniciMoznosti);

        $form = new Application_Form_MikroObjednavka(array(
            'zakazniciMoznosti' => $zakazniciMoznosti,
            'merneJednotkyMoznosti' => $merneJednotkyMoznosti,
            'objednavkyMoznosti' => $objednavkyMoznosti
        ));

        $form->submit->setLabel('Pridať mikro objednávku');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $zakaznik = $form->getValue('zakaznik_enum');
                $nadobjednavka = $form->getValue('nadobjednavka_enum');
                $datumOd = $form->getValue('datum_od_d');
                $datumDo = $form->getValue('datum_do_d');
                $mnozstvo = $form->getValue('mnozstvo');
                $merna_jednotka= $form->getValue('merna_jednotka_enum');
                $poznamka = $form->getValue('poznamka');

                $mikroObjednavkyModel->addMikroObjednavka(
                    $nadobjednavka,
                    $datumOd,
                    $datumDo,
                    $mnozstvo,
                    $zakaznik,
                    $merna_jednotka,
                    $poznamka);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'mikroobjednavky');
        $this->view->fromController = $fromController;

        /*
         * Data pre ciselniky
         */
        $mikroObjednavkyModel = new Application_Model_DbTable_MikroObjednavky();
        $objednavkyModel = new Application_Model_DbTable_Objednavky();
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

        $zakazniciMoznosti = $zakazniciModel->getMoznosti();
        $merneJednotkyMoznosti = $merneJednotkyModel->getMoznosti();
        $objednavkyMoznosti = $objednavkyModel->getMoznosti();

        //zoradenie
        asort($zakazniciMoznosti);

        $form = new Application_Form_MikroObjednavka(array(
            'zakazniciMoznosti' => $zakazniciMoznosti,
            'merneJednotkyMoznosti' => $merneJednotkyMoznosti,
            'objednavkyMoznosti' => $objednavkyMoznosti
        ));

        $form->submit->setLabel('Upraviť mikro objednávku');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int) $form->getValue('objednavky_mikro_id');
                $zakaznik = $form->getValue('zakaznik_enum');
                $nadobjednavka = $form->getValue('nadobjednavka_enum');
                $datumOd = $form->getValue('datum_od_d');
                $datumDo = $form->getValue('datum_do_d');
                $mnozstvo = $form->getValue('mnozstvo');
                $merna_jednotka= $form->getValue('merna_jednotka_enum');
                $poznamka = $form->getValue('poznamka');

                $mikroObjednavkyModel->updateMikroObjednavka(
                    $id,
                    $nadobjednavka,
                    $datumOd,
                    $datumDo,
                    $mnozstvo,
                    $zakaznik,
                    $merna_jednotka,
                    $poznamka);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        }else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $mikroObjednavky = new Application_Model_DbTable_MikroObjednavky();
                $form->populate($mikroObjednavky->getMikroObjednavka($id));
            }
        }
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Áno') {
                $id = $this->getRequest()->getPost('id');
                $mikroObjednavky = new Application_Model_DbTable_MikroObjednavky();
                $mikroObjednavky->deleteMikroObjednavka($id);
            }
            $this->_helper->redirector('list');
        } else {
            $id = $this->_getParam('id', 0);
            $mikroObjednavkyModel = new Application_Model_DbTable_MikroObjednavky();
            $zakazniciModel = new Application_Model_DbTable_Zakaznici();
            $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

            $this->view->mikroObjednavka = $mikroObjednavkyModel->getMikroObjednavka($id);
            $this->view->mikroObjednavkaId = $id;
            $this->view->zakazniciModel = $zakazniciModel;
            $this->view->merneJednotkyModel = $merneJednotkyModel;
        }
    }

    public function previewAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $fromController = $this->_getParam('fromController', 'mikroobjednavky');
        $fromId = $this->_getParam('fromId', null);
        $this->view->fromAction = $fromAction;
        $this->view->fromController = $fromController;
        $this->view->fromId = $fromId;

        //inicializacia modelov pre vypis
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $rokyModel = new Application_Model_DbTable_Roky();
        $mesiaceModel = new Application_Model_DbTable_Mesiace();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();
        $objednavkyModel = new Application_Model_DbTable_Objednavky();
        $mikroObjednavkyModel = new Application_Model_DbTable_MikroObjednavky();
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xdodavkyModel = new Application_Model_DbTable_ExternaDodavka();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();

        $this->view->zakazniciModel = $zakazniciModel;
        $this->view->rokyModel = $rokyModel;
        $this->view->mesiaceModel = $mesiaceModel;
        $this->view->merneJednotkyModel = $merneJednotkyModel;
        $this->view->objednavkyModel = $objednavkyModel;
        $this->view->mikroObjednavkyModel = $mikroObjednavkyModel;
        $this->view->vydajeModel = $vydajeModel;
        $this->view->xdodavkyModel = $xdodavkyModel;
        $this->view->xvyrobyModel = $xvyrobyModel;

        $id = $this->_getParam('id');
        $this->view->mikroObjednavka = $mikroObjednavkyModel->getMikroObjednavka($id);
        $this->view->mikroObjednavkaId = $id;
    }


}











