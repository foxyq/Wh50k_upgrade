<?php

class PrepravciController extends Zend_Controller_Action
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
        $form = new Application_Form_Prepravca();

        $form->submit->setLabel('Pridať prepravcu');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $kod = $form->getValue('kod');
                $meno= $form->getValue('meno');
                $prepravci = new Application_Model_DbTable_Prepravci();
                $prepravci->addPrepravca($kod, $meno);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function listAction()
    {
        $prepravci = new Application_Model_DbTable_Prepravci();
        $this->view->prepravci = $prepravci->fetchAll();

        $this->view->title = "Prepravcovia - zoznam";
    }

    public function editAction()
    {
        {
            $form = new Application_Form_Prepravca();
            $form->submit->setLabel('Uložiť');
            $this->view->title = "Upraviť prepravcu";
            $this->view->form = $form;

            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $id = (int)$form->getValue('prepravci_id');
                    $kod = $form->getValue('kod');
                    $meno = $form->getValue('meno');
                    $prepravci = new Application_Model_DbTable_Prepravci();
                    $prepravci->updatePrepravca($id, $kod, $meno);

                    $this->_helper->redirector('list');
                } else {
                    $form->populate($formData);
                }
            } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $prepravci= new Application_Model_DbTable_Prepravci();
                    $form->populate($prepravci->getPrepravca($id));
                }
            }
        }
    }


}







