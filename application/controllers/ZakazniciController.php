<?php

class ZakazniciController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        //potrebne modely
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $rokyModel = new Application_Model_DbTable_Roky();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();

        //transakcne modely
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xdodavkyModel = new Application_Model_DbTable_ExternaDodavka();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();

        //preposielanie na view
        $this->view->zakazniciModel = $zakazniciModel;
        $this->view->rokyModel = $rokyModel;
        $this->view->merneJednotkyModel = $merneJednotkyModel;
        $this->view->vydajeModel = $vydajeModel;
        $this->view->xdodavkyModel = $xdodavkyModel;
        $this->view->xvyrobyModel = $xvyrobyModel;

        $this->view->title = "Zákazníci - prehľad";
    }

    public function addAction()
    {

        $merneJednotkyMoznosti = new  Application_Model_DbTable_MerneJednotky();
        $merneJednotkyMoznosti = $merneJednotkyMoznosti->getMoznosti();

        $form = new Application_Form_Zakaznik(array(
            'merneJednotkyMoznosti' => $merneJednotkyMoznosti
        ));


        $form->submit->setLabel('Pridať zákanzíka');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $meno = $form->getValue('meno');
                $nazov_spolocnosti= $form->getValue('nazov_spolocnosti');
                $merna_jednotka= $form->getValue('merna_jednotka_enum');
                $ico = $form->getValue('ico');
                $ic_dph = $form->getValue('ic_dph');
                $adresa = $form->getValue('adresa');
                $internyKod = $form->getValue('interny_kod');
                $zakaznici = new Application_Model_DbTable_Zakaznici();
                $zakaznici->addZakaznik($meno, $nazov_spolocnosti, $merna_jednotka, $ico, $ic_dph, $adresa, $internyKod);

            } else {
                $form->populate($formData);
            }
        }
    }

    public function listAction()
    {
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $this->view->zakaznici = $zakaznici->fetchAll();

        $merneJednotky = new Application_Model_DbTable_MerneJednotky();
        $this->view->merneJednotky = $merneJednotky;

        $this->view->title = "Zákazníci - zoznam";
    }

    public function deleteAction()
    {
        //tato funkcionalita sa nepouziva ale asi  bude buggovat
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('zakaznici_id');
                $zakaznici = new Application_Model_DbTable_Zakaznici();
                $zakaznici->deleteZakaznik($id);
            }
            $this->_helper->redirector('index');
        } else {
            //tu bude mozno problem pretoze nebude vediet najst 'zakaznici_id' ale len 'id'
            $id = $this->_getParam('zakaznici_id', 0);
            $zakaznici = new Application_Model_DbTable_Zakaznici();
            $this->view->zakaznik = $zakaznici->getZakaznik($id);
        }
    }

    public function editAction()
    {
        {
            $merneJednotkyMoznosti = new  Application_Model_DbTable_MerneJednotky();
            $merneJednotkyMoznosti = $merneJednotkyMoznosti->getMoznosti();

            $form = new Application_Form_Zakaznik(array(
            'merneJednotkyMoznosti' => $merneJednotkyMoznosti
            ));

            $form->submit->setLabel('Uložiť');
            $this->view->form = $form;

            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $id = (int)$form->getValue('zakaznici_id');
                    $meno = $form->getValue('meno');
                    $nazov_spolocnosti = $form->getValue('nazov_spolocnosti');
                    $merna_jednotka= $form->getValue('merna_jednotka_enum');
                    $ico = $form->getValue('ico');
                    $ic_dph = $form->getValue('ic_dph');
                    $adresa = $form->getValue('adresa');
                    $internyKod = $form->getValue('interny_kod');
                    $zakaznici = new Application_Model_DbTable_Zakaznici();
                    $zakaznici->updateZakaznik($id, $meno, $nazov_spolocnosti, $merna_jednotka, $ico, $ic_dph, $adresa, $internyKod);

                    $this->_helper->redirector('list');
                } else {
                    $form->populate($formData);
                }
            } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $zakaznici= new Application_Model_DbTable_Zakaznici();
                    $form->populate($zakaznici->getZakaznik($id));
                }
            }
        }
    }


}









