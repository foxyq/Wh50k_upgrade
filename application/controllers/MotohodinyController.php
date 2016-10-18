<?php

class MotohodinyController extends Zend_Controller_Action
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
        // action body
        $motohodinyModel = new Application_Model_DbTable_Motohodiny();
        $rokyModel = new Application_Model_DbTable_Roky();
        $mesiaceModel = new Application_Model_DbTable_Mesiace();
        $strojeModel = new Application_Model_DbTable_Stroje();

        $this->view->motohodinyModel = $motohodinyModel;
        $this->view->rokyModel = $rokyModel;
        $this->view->mesiaceModel = $mesiaceModel;
        $this->view->strojeModel = $strojeModel;
        $this->view->title = "Motohodiny - zoznam";
    }

    public function addAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'motohodiny');
        $this->view->fromController = $fromController;
        /*
         * Data pre ciselniky
         */
        $strojeModel = new Application_Model_DbTable_Stroje();
        $rokyModel = new Application_Model_DbTable_Roky();
        $mesiaceModel = new Application_Model_DbTable_Mesiace();
        $motohodinyModel = new Application_Model_DbTable_Motohodiny();

        $strojeMoznosti = $strojeModel->getMoznosti();
        $rokyMoznosti = $rokyModel->getMoznosti();
        $mesiaceMoznosti = $mesiaceModel->getMoznosti();

        $form = new Application_Form_Motohodina(array(
            'strojeMoznosti' => $strojeMoznosti,
            'rokyMoznosti' => $rokyMoznosti,
            'mesiaceMoznosti' => $mesiaceMoznosti
        ));

        $form->submit->setLabel('Pridať motohodinu');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $stroj = $form->getValue('stroj_enum');
                $rok = $form->getValue('rok_enum');
                $mesiac = $form->getValue('mesiac_enum');
                $pocetHodin = $form->getValue('pocet_hodin');

                $motohodinyModel->addMotohodina($stroj, $rok, $mesiac, $pocetHodin);

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
        $fromController = $this->_getParam('fromController', 'motohodiny');
        $this->view->fromController = $fromController;
        /*
         * Data pre ciselniky
         */
        $strojeModel = new Application_Model_DbTable_Stroje();
        $rokyModel = new Application_Model_DbTable_Roky();
        $mesiaceModel = new Application_Model_DbTable_Mesiace();
        $motohodinyModel = new Application_Model_DbTable_Motohodiny();

        $strojeMoznosti = $strojeModel->getMoznosti();
        $rokyMoznosti = $rokyModel->getMoznosti();
        $mesiaceMoznosti = $mesiaceModel->getMoznosti();

        $form = new Application_Form_Motohodina(array(
            'strojeMoznosti' => $strojeMoznosti,
            'rokyMoznosti' => $rokyMoznosti,
            'mesiaceMoznosti' => $mesiaceMoznosti
        ));

        $form->submit->setLabel('Upraviť motohodinu');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('motohodiny_id');
                $stroj = $form->getValue('stroj_enum');
                $rok = $form->getValue('rok_enum');
                $mesiac = $form->getValue('mesiac_enum');
                $pocetHodin = $form->getValue('pocet_hodin');

                $motohodinyModel->updateMotohodina($id, $stroj, $rok, $mesiac, $pocetHodin);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $motohodinyModel = new Application_Model_DbTable_Motohodiny();
                    $form->populate($motohodinyModel->getMotohodina($id));
                }
                }
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Áno') {
                $id = $this->getRequest()->getPost('id');
                $motohodiny = new Application_Model_DbTable_Motohodiny();
                $motohodiny->deleteMotohodina($id);
            }
            $this->_helper->redirector('list');
        } else {
            $id = $this->_getParam('id', 0);
            $motohodiny = new Application_Model_DbTable_Motohodiny();

            $strojeModel = new Application_Model_DbTable_Stroje();
            $rokyModel = new Application_Model_DbTable_Roky();
            $mesiaceModel = new Application_Model_DbTable_Mesiace();

            $this->view->motohodina = $motohodiny->getMotohodina($id);
            $this->view->motohodinaId = $id;
            $this->view->strojeModel = $strojeModel;
            $this->view->mesiaceModel = $mesiaceModel;
            $this->view->rokyModel = $rokyModel;
        }
    }


}









