<?php

class MiestastiepeniaController extends Zend_Controller_Action
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
        $form = new Application_Form_MiestoStiepenia();

        $form->submit->setLabel('Pridať miesto');

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $nazov = $form->getValue('nazov_miesta');

                $miestaStiepenia = new Application_Model_DbTable_MiestaStiepenia();
                $miestaStiepenia->addMiestoStiepenia($nazov);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $form = new Application_Form_MiestoStiepenia();

        $form->submit->setLabel('Upraviť miesto');

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('miesta_stiepenia_id');
                $nazov = $form->getValue('nazov_miesta');

                $miestaStiepenia = new Application_Model_DbTable_MiestaStiepenia();
                $miestaStiepenia->updateMiestoStiepenia($id, $nazov);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $miestaStiepenia = new Application_Model_DbTable_MiestaStiepenia();
                    $form->populate($miestaStiepenia->getMiestoStiepenia($id));
                }
        }
    }

    public function listAction()
    {
        $miestaStiepenia = new Application_Model_DbTable_MiestaStiepenia();

        $this->view->miestaStiepenia = $miestaStiepenia->fetchAll();

        $this->view->title = "Miesta štiepenia - zoznam";
    }

    public function deleteAction()
    {
        // action body
    }


}









