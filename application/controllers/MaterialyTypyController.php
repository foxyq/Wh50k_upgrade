<?php

class MaterialytypyController extends Zend_Controller_Action
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
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();

        $this->view->materialyTypy = $materialyTypy->fetchAll();

        $this->view->title = "Typy materiálov - zoznam";
    }

    public function editAction()
    {
        $form = new Application_Form_MaterialTyp();

        $form->submit->setLabel('Upraviť typ');

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('materialy_typy_id');
                $nazov = $form->getValue('nazov');
                $skratka = $form->getValue('skratka');

                $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
                $materialyTypy->updateTyp($id, $nazov, $skratka);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
                    $form->populate($materialyTypy->getTyp($id));
                }
        }
    }

    public function addAction()
    {
        $form = new Application_Form_MaterialTyp();

        $form->submit->setLabel('Pridať typ');

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $nazov = $form->getValue('nazov');
                $skratka= $form->getValue('skratka');

                $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
                $materialyTypy->addTyp($nazov, $skratka);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }


}







