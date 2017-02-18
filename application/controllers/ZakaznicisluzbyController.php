<?php

class ZakaznicisluzbyController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_helper->redirector('list');

    }

    public function listAction()
    {

        $zakazniciSluzby = new Application_Model_DbTable_ZakazniciSluzby();
        $this->view->zakazniciSluzby = $zakazniciSluzby->fetchAll();

        $merneJednotky = new Application_Model_DbTable_MerneJednotky();
        $this->view->merneJednotky = $merneJednotky;

        $this->view->title = "Zákazníci pre služby- zoznam";

    }

    public function addAction()
    {
        $merneJednotkyMoznosti = new  Application_Model_DbTable_MerneJednotky();
        $merneJednotkyMoznosti = $merneJednotkyMoznosti->getMoznosti();

        $form = new Application_Form_ZakaznikSluzby(array(
            'merneJednotkyMoznosti' => $merneJednotkyMoznosti
        ));


        $form->submit->setLabel('Pridať zákazníka');
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
                $zakazniciSluzby = new Application_Model_DbTable_ZakazniciSluzby();
                $zakazniciSluzby->addZakaznikSluzby($meno, $nazov_spolocnosti, $merna_jednotka, $ico, $ic_dph, $adresa, $internyKod);

                $this->_helper->redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        {
            $merneJednotkyMoznosti = new  Application_Model_DbTable_MerneJednotky();
            $merneJednotkyMoznosti = $merneJednotkyMoznosti->getMoznosti();

            $form = new Application_Form_ZakaznikSluzby(array(
                'merneJednotkyMoznosti' => $merneJednotkyMoznosti
            ));

            $form->submit->setLabel('Uložiť');
            $this->view->form = $form;

            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $id = (int)$form->getValue('zakaznici_sluzby_id');
                    $meno = $form->getValue('meno');
                    $nazov_spolocnosti = $form->getValue('nazov_spolocnosti');
                    $merna_jednotka= $form->getValue('merna_jednotka_enum');
                    $ico = $form->getValue('ico');
                    $ic_dph = $form->getValue('ic_dph');
                    $adresa = $form->getValue('adresa');
                    $internyKod = $form->getValue('interny_kod');
                    $zakazniciSluzby = new Application_Model_DbTable_ZakazniciSluzby();
                    $zakazniciSluzby->updateZakaznikSluzby($id, $meno, $nazov_spolocnosti, $merna_jednotka, $ico, $ic_dph, $adresa, $internyKod);

                    $this->_helper->redirector('list');
                } else {
                    $form->populate($formData);
                }
            } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $zakazniciSluzby= new Application_Model_DbTable_ZakazniciSluzby();
                    $form->populate($zakazniciSluzby->getZakaznikSluzby($id));
                }
            }
        }
    }

    public function previewAction()
    {
        // dočasne redirect na list pokiaľ nebude potrebný preview
        $this->_helper->redirector('list');

    }


}









