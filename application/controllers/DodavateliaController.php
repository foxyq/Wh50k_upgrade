<?php

class DodavateliaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

    }

    public function addAction()
    {
        $potvrdzujuceTlacidlo = 'Vložiť';

        $form = new Application_Form_Dodavatel(array(

            'meno' => $meno,
            'nazov_spolocnosti' => $nazov_spolocnosti,
            'ico' => $ico,
            'ic_dph' => $icDph,
            'adresa' => $adresa,
            'interny_kod' => $internyKod,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo

        ));

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();


            if ($form->isValid($formData)) {

                $meno = $form->getValue('meno');
                $nazov_spolocnosti = $form->getValue('nazov_spolocnosti');
                $ico = $form->getValue('ico');
                $ic_dph = $form->getValue('ic_dph');
                $adresa = $form->getValue('adresa');
                $internyKod = $form->getValue('interny_kod');

               $dodavatelia = new Application_Model_DbTable_Dodavatelia();

                $dodavatelia->addDodavatel(
                    $meno,
                    $nazov_spolocnosti,
                    $ico,
                    $ic_dph,
                    $adresa,
                    $internyKod

                );

                $this->_helper->redirector('list');


            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $potvrdzujuceTlacidlo = 'Upraviť';

        $form = new Application_Form_Dodavatel(array(

            'meno' => $meno,
            'nazov_spolocnosti' => $nazov_spolocnosti,
            'ico' => $ico,
            'ic_dph' => $icDph,
            'adresa' => $adresa,
            'interny_kod' => $internyKod,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo

        ));

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();


            if ($form->isValid($formData)) {

                $id = (int)$form->getValue('dodavatelia_id');
                $meno = $form->getValue('meno');
                $nazov_spolocnosti = $form->getValue('nazov_spolocnosti');
                $ico = $form->getValue('ico');
                $ic_dph = $form->getValue('ic_dph');
                $adresa = $form->getValue('adresa');
                $internyKod = $form->getValue('interny_kod');

                $dodavatelia = new Application_Model_DbTable_Dodavatelia();

                $dodavatelia->editDodavatel(
                    $id,
                    $meno,
                    $nazov_spolocnosti,
                    $ico,
                    $ic_dph,
                    $adresa,
                    $internyKod
                );

                $this->_helper->redirector('list');


            } else {
                $form->populate($formData);
            }
        } else {

            $id = $this->_getParam('dodavatelia_id', 0);

            if ($id > 0) {
                $dodavatelia = new Application_Model_DbTable_Dodavatelia();
                $form->populate($dodavatelia->getDodavatel($id));
                $this->view->data = $dodavatelia->getDodavatel($id);

            }
        }
    }

    public function listAction()
    {
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $this->view->dodavatelia = $dodavatelia->fetchAll();
        $this->view->title = "Zoznam dodávateľov";
    }


}




