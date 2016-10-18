<?php

class ObjednavkyController extends Zend_Controller_Action
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
        $objednavkyModel = new Application_Model_DbTable_Objednavky();
        $mikroObjednavkyModel = new Application_Model_DbTable_MikroObjednavky();
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xdodavkyModel = new Application_Model_DbTable_ExternaDodavka();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();

        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();
        $rokyModel = new Application_Model_DbTable_Roky();
        $mesiaceModel = new Application_Model_DbTable_Mesiace();

        $this->view->objednavky = $objednavkyModel->fetchAll();
        $this->view->mikroObjednavkyModel = $mikroObjednavkyModel;
        $this->view->objednavkyModel = $objednavkyModel;
        $this->view->zakazniciModel = $zakazniciModel;
        $this->view->merneJednotkyModel = $merneJednotkyModel;
        $this->view->rokyModel = $rokyModel;
        $this->view->mesiaceModel = $mesiaceModel;
        $this->view->vydajeModel = $vydajeModel;
        $this->view->xvyrobyModel = $xvyrobyModel;
        $this->view->xdodavkyModel = $xdodavkyModel;

        $this->view->title = "Objednávky - zoznam";

    }

    public function addAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'objednavky');
        $this->view->fromController = $fromController;

        /*
         * Data pre ciselniky
         */
        $objednavkyModel = new Application_Model_DbTable_Objednavky();
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $rokyModel = new Application_Model_DbTable_Roky();
        $mesiaceModel = new Application_Model_DbTable_Mesiace();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

        $zakazniciMoznosti = $zakazniciModel->getMoznosti();
        $rokyMoznosti = $rokyModel->getMoznosti();
        $mesiaceMoznosti = $mesiaceModel->getMoznosti();
        $merneJednotkyMoznosti = $merneJednotkyModel->getMoznosti();

        //zoradenie
        asort($zakazniciMoznosti);

        $form = new Application_Form_Objednavka(array(
            'zakazniciMoznosti' => $zakazniciMoznosti,
            'rokyMoznosti' => $rokyMoznosti,
            'mesiaceMoznosti' => $mesiaceMoznosti,
            'merneJednotkyMoznosti' => $merneJednotkyMoznosti
        ));

        $form->submit->setLabel('Pridať objednávku');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $zakaznik = $form->getValue('zakaznik_enum');
                $rok = $form->getValue('rok_enum');
                $mesiac = $form->getValue('mesiac_enum');
                $mnozstvo = $form->getValue('mnozstvo');
                $merna_jednotka= $form->getValue('merna_jednotka_enum');
                $poznamka = $form->getValue('poznamka');

                $objednavkyModel->addObjednavka($zakaznik, $rok, $mesiac, $mnozstvo, $merna_jednotka, $poznamka);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        /*
         * Data pre ciselniky
         */
        $objednavkyModel = new Application_Model_DbTable_Objednavky();
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $rokyModel = new Application_Model_DbTable_Roky();
        $mesiaceModel = new Application_Model_DbTable_Mesiace();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

        $zakazniciMoznosti = $zakazniciModel->getMoznosti();
        $rokyMoznosti = $rokyModel->getMoznosti();
        $mesiaceMoznosti = $mesiaceModel->getMoznosti();
        $merneJednotkyMoznosti = $merneJednotkyModel->getMoznosti();

        //zoradenie
        asort($zakazniciMoznosti);
        
        $form = new Application_Form_Objednavka(array(
            'zakazniciMoznosti' => $zakazniciMoznosti,
            'rokyMoznosti' => $rokyMoznosti,
            'mesiaceMoznosti' => $mesiaceMoznosti,
            'merneJednotkyMoznosti' => $merneJednotkyMoznosti
        ));

        $form->submit->setLabel('Upraviť objednávku');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('objednavky_id');
                $zakaznik = $form->getValue('zakaznik_enum');
                $rok = $form->getValue('rok_enum');
                $mesiac = $form->getValue('mesiac_enum');
                $mnozstvo = $form->getValue('mnozstvo');
                $merna_jednotka= $form->getValue('merna_jednotka_enum');
                $poznamka = $form->getValue('poznamka');

                $objednavkyModel->updateObjednavka($id, $zakaznik, $rok, $mesiac, $mnozstvo, $merna_jednotka, $poznamka);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $objednavky = new Application_Model_DbTable_Objednavky();
                    $form->populate($objednavky->getObjednavka($id));
                }
                }
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Áno') {
                $id = $this->getRequest()->getPost('id');
                $objednavky = new Application_Model_DbTable_Objednavky();
                $objednavky->deleteObjednavka($id);
            }
            $this->_helper->redirector('list');
        } else {
            $id = $this->_getParam('id', 0);
            $objednavky = new Application_Model_DbTable_Objednavky();

            $zakazniciModel = new Application_Model_DbTable_Zakaznici();
            $rokyModel = new Application_Model_DbTable_Roky();
            $mesiaceModel = new Application_Model_DbTable_Mesiace();
            $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

            $this->view->objednavka = $objednavky->getObjednavka($id);
            $this->view->objednavkaId = $id;
            $this->view->zakazniciModel = $zakazniciModel;
            $this->view->mesiaceModel = $mesiaceModel;
            $this->view->rokyModel = $rokyModel;
            $this->view->merneJednotkyModel = $merneJednotkyModel;
        }
    }

    public function previewAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $fromController = $this->_getParam('fromController', 'objednavky');
        $this->view->fromAction = $fromAction;
        $this->view->fromController = $fromController;

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
        $this->view->objednavka = $objednavkyModel->getObjednavka($id);
        $this->view->objednavkaId = $id;
    }

    public function calendarAction()
    {
        // action body
    }


}













