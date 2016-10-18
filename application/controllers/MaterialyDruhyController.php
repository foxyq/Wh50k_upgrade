<?php

class MaterialyDruhyController extends Zend_Controller_Action
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
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();

        $this->view->materialyDruhy = $materialyDruhy->fetchAll();

        $this->view->title = "Druhy materiálov - zoznam";
    }

    public function addAction()
    {
       $form = new Application_Form_MaterialDruh();

        $form->submit->setLabel('Pridať druh');

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $nazov = $form->getValue('nazov');
                $skratka= $form->getValue('skratka');

                $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
                $materialyDruhy->addDruh($nazov, $skratka);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $form = new Application_Form_MaterialDruh();

        $form->submit->setLabel('Upraviť druh');

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('materialy_druhy_id');
                $nazov = $form->getValue('nazov');
                $skratka = $form->getValue('skratka');

                $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
                $materialyDruhy->updateDruh($id, $nazov, $skratka);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
                    $form->populate($materialyDruhy->getDruh($id));
                }
        }
    }


}







