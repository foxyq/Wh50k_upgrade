<?php

class UbytkyController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // asi netreba
        //$prijmy = new Application_Model_DbTable_Prijmy();
        //$ubytky->dropTableData();


        //$ubytky = new Application_Model_DbTable_UbytkyHmotnosti();
        //$ubytky->refreshTableDataByDate('2015-06-01', '2015-06-30');

    }

    public function listAction()
    {
        // action body
        $ubytky = new Application_Model_DbTable_UbytkyHmotnosti();
        $sklady = new Application_Model_DbTable_Sklady();
        $prijmy = new Application_Model_DbTable_Prijmy();
        $notifikacieModel = new Application_Model_Notifikacie();

        $this->view->ubytky = $ubytky->fetchAll();

        $ubytkyVPoli = array();
        foreach ($sklady->getIds() as $skladId){
            $ubytkyVPoli[$skladId] = $ubytky->fetchAll('sklad_enum = '.$skladId);
        }
        $this->view->ubytkyVPoli = $ubytkyVPoli;

        $this->view->ubytkyModel = $ubytky;
        $this->view->sklady = $sklady;
        $this->view->prijmy = $prijmy;
        $this->view->notifikacieModel = $notifikacieModel;
        $this->view->title = 'Prehľad úbytkov a vývoja stavu skladov';


    }

    public function refreshdataAction()
    {
        $ubytky = new Application_Model_DbTable_UbytkyHmotnosti();
        $ubytky->refreshTableDataByDate(Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('calendar_start_date'), date('Y-m-d'));
        $this->_helper->redirector('list');
    }

    public function refreshdataexternalAction()
    {
        //nakoniec nepouzivame
        $fromAction = Zend_Controller_Front::getInstance()->getRequest()->getParam('fromAction');
        $fromController = Zend_Controller_Front::getInstance()->getRequest()->getParam('fromController');

        $ubytky = new Application_Model_DbTable_UbytkyHmotnosti();
        $ubytky->refreshTableDataByDate(Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('calendar_start_date'), date('Y-m-d'));
        $this->_helper->redirector($fromAction, $fromController);
    }


}







