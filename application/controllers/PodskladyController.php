<?php

class PodskladyController extends Zend_Controller_Action
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
        $podsklady = new Application_Model_DbTable_Podsklady();
        $skladyModel = new Application_Model_DbTable_Sklady();
        $mesta = new Application_Model_DbTable_Mesta();

        $this->view->podsklady = $podsklady->fetchAll();
        $this->view->podskladyModel = $podsklady;
        $this->view->skladyModel = $skladyModel;
        $this->view->mesta = $mesta;

        $this->view->title = "Sklady - zoznam";
    }

    public function addAction()
    {
        $mesta = new Application_Model_DbTable_Mesta();
        $sklady = new Application_Model_DbTable_Sklady();

        $mestaMoznosti = $mesta->getMoznosti();
        $skladyMoznosti = $sklady->getMoznosti();

        $form = new Application_Form_Podsklad(array(
            'mestaMoznosti' => $mestaMoznosti,
            'skladyMoznosti' => $skladyMoznosti));

        $form->submit->setLabel('Pridať sklad');

        $this->view->title = "Pridanie skladu";
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $nazov_podskladu = $form->getValue('nazov_podskladu');
                $kod_podskladu= $form->getValue('kod_podskladu');
                $sklad = $form->getValue('sklad_enum');
                $mesto_enum= $form->getValue('mesto_enum');
                $adresa= $form->getValue('adresa');

                $podsklady = new Application_Model_DbTable_Podsklady();
                $podsklady->addPodsklad($nazov_podskladu, $kod_podskladu, $sklad, $mesto_enum, $adresa);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $mesta = new Application_Model_DbTable_Mesta();
        $sklady = new Application_Model_DbTable_Sklady();

        $mestaMoznosti = $mesta->getMoznosti();
        $skladyMoznosti = $sklady->getMoznosti();

        $form = new Application_Form_Podsklad(array(
            'mestaMoznosti' => $mestaMoznosti,
            'skladyMoznosti' => $skladyMoznosti));

        $form->submit->setLabel('Upraviť sklad');

        $this->view->title = "Upraviť sklad";
        $this->view->form = $form;

            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $id = (int)$form->getValue('podsklady_id');
                    $nazov_podskladu = $form->getValue('nazov_podskladu');
                    $kod_podskladu= $form->getValue('kod_podskladu');
                    $sklad = $form->getValue('sklad_enum');
                    $mesto_enum= $form->getValue('mesto_enum');
                    $adresa= $form->getValue('adresa');

                    $podsklady = new Application_Model_DbTable_Podsklady();
                    $podsklady->updatePodsklad($id, $nazov_podskladu, $kod_podskladu, $sklad, $mesto_enum, $adresa);

                    $this->_helper->redirector('list');
                } else {
                    $form->populate($formData);
                }
            } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $podsklady = new Application_Model_DbTable_Podsklady();
                    $form->populate($podsklady->getPodsklad($id));
                }
            }
    }


}







