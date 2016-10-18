<?php

class NotifikacieController extends Zend_Controller_Action
{
    //TODO - zmazat tento controller! - bol nahradeny modelom ktory je lepsim riesenim - toto by nemal byt controller ale model


    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $notifikacie = new Application_Model_Notifikacie();
        $notifikacieArray = $notifikacie->getStatusArray();
        $notifikacieTotal = $notifikacie->getStatusTotal();

        $this->view->notifikacieArray = $notifikacieArray;
        $this->view->notifikacieTotal = $notifikacieTotal;

    }




}

