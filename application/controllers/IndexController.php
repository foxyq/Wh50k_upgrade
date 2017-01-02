<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $_SESSION['pomoc'] = "mala macinka";

        $ajaxContext = $this->_helper->getHelper('AjaxContext');

        $ajaxContext->addActionContext('list', 'html')
            ->addActionContext('modify', 'html')
            ->initContext();

    }

    public function indexAction()
    {
        $request = $this->getRequest()->getServer('HTTP_REFERER');

        /*
         * SKLADOVA CAST
         */
        $sklady = new Application_Model_DbTable_Sklady();
        $prijmy = new Application_Model_DbTable_Prijmy();
        $vydaje = new Application_Model_DbTable_Vydaje();
        $ubytky = new Application_Model_DbTable_UbytkyHmotnosti();

        $this->view->skladyModel = $sklady;
        $this->view->sklady = $sklady->fetchAll();
        $this->view->skladyModel = $sklady;
        $this->view->prijmy = $prijmy;
        $this->view->vydaje = $vydaje;
        $this->view->ubytky = $ubytky;

        //vypocty pre pohyby
        $pohyby = array();
        $skladyIdArray = $sklady->getIds();

        foreach ($skladyIdArray as $skladId)
        {
            switch ($sklady->getMernaJednotka($skladId))
            {
                case 1:
                    $stlpec = 'q_tony_merane';
                    break;
                case 2:
                    $stlpec = 'q_prm_merane';
                    break;
                case 3:
                    $stlpec = 'q_m3_merane';
                    break;
            }

            //den
            $pohyby[$skladId]['den']['prijmy'] = $prijmy->getSumByDateAndStock($stlpec, "sklad_enum", $skladId, "datum_prijmu_d", "'".date('Y-m-d')."'");
            $pohyby[$skladId]['den']['vydaje'] = $vydaje->getSumByDateAndStock($stlpec, "sklad_enum", $skladId, "datum_vydaju_d", "'".date('Y-m-d')."'");
            $pohyby[$skladId]['den']['total'] = $pohyby[$skladId]['den']['prijmy'] - $pohyby[$skladId]['den']['vydaje'];

            //tyzden
            $pohyby[$skladId]['tyzden']['prijmy'] = $prijmy->getSubmittedSumByColumnBetween($stlpec, "datum_prijmu_d", date('Y-m-d', strtotime('-7 days')), date('Y-m-d'), "sklad_enum", $skladId);
            $pohyby[$skladId]['tyzden']['vydaje'] = $vydaje->getSubmittedSumByColumnBetween($stlpec, "datum_vydaju_d", date('Y-m-d', strtotime('-7 days')), date('Y-m-d'), "sklad_enum", $skladId);
            $pohyby[$skladId]['tyzden']['total'] = $pohyby[$skladId]['tyzden']['prijmy'] - $pohyby[$skladId]['tyzden']['vydaje'];


            //mesiac
            $pohyby[$skladId]['mesiac']['prijmy'] = $prijmy->getSubmittedSumByColumnBetween($stlpec, "datum_prijmu_d", date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), "sklad_enum", $skladId);
            $pohyby[$skladId]['mesiac']['vydaje'] = $vydaje->getSubmittedSumByColumnBetween($stlpec, "datum_vydaju_d", date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), "sklad_enum", $skladId);
            $pohyby[$skladId]['mesiac']['total'] = $pohyby[$skladId]['mesiac']['prijmy'] - $pohyby[$skladId]['mesiac']['vydaje'];
        }

        $this->view->pohyby = $pohyby;

        //vypocet pre grafy
        $vyvojStavuSkladov = array();
        foreach ($skladyIdArray as $skladId) {
            $vyvojStavuSkladov[$skladId] = $ubytky->getLastXValues($skladId, 30);
        }
        $this->view->vyvojStavuSkladov = $vyvojStavuSkladov;

        /*
         * OBJEDNAVKY CAST
         */
        $objednavkyModel = new Application_Model_DbTable_Objednavky();
        $vydajeModel = new Application_Model_DbTable_Vydaje();
        $xdodavkyModel = new Application_Model_DbTable_ExternaDodavka();
        $xvyrobyModel = new Application_Model_DbTable_ExternaVyroba();

        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $merneJednotkyModel = new Application_Model_DbTable_MerneJednotky();
        $rokyModel = new Application_Model_DbTable_Roky();
        $mesiaceModel = new Application_Model_DbTable_Mesiace();

        $this->view->objednavky = $objednavkyModel->fetchAll();
        $this->view->objednavkyModel = $objednavkyModel;
        $this->view->zakazniciModel = $zakazniciModel;
        $this->view->merneJednotkyModel = $merneJednotkyModel;
        $this->view->rokyModel = $rokyModel;
        $this->view->mesiaceModel = $mesiaceModel;
        $this->view->vydajeModel = $vydajeModel;
        $this->view->xvyrobyModel = $xvyrobyModel;
        $this->view->xdodavkyModel = $xdodavkyModel;

//        $this->view->title = "Nástenka";
        $this->view->title = "";




    }

    public function previewAction()
    {
        // action body
        /*
        $prijmy = new Application_Model_DbTable_Prijmy();
        $sklady = new Application_Model_DbTable_Sklady();

        $podsklady = new Application_Model_DbTable_Podsklady();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();


        $this->view->prijmy = $prijmy->fetchAll();
        $this->view->sklady = $sklady;
        
        $this->view->podsklady = $podsklady;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        */
    }

    private function getStatus()
    {
        $status = array();

        $prijmy = new Application_Model_DbTable_Prijmy();
        $vydaje = new Application_Model_DbTable_Vydaje();

        $status['prijmy_waitings'] = $prijmy->getNumberOfWaitings();
        $status['prijmy_errors'] = $prijmy->getNumberOfErrors();
        $status['vydaje_waitings'] = $vydaje->getNumberOfWaitings();
        $status['vydaje_errors'] = $vydaje->getNumberOfErrors();

        return $status;


    }

    /*public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');

    }*/

    public function hashAction()
    {

        $form = $this->view->form = new Application_Form_Login();
        if ($this->getRequest()->isPost()
            && $form->isValid($this->getRequest()->getPost())
        ) {
            $adapter = new Zend_Auth_Adapter_DbTable(
                Zend_Db_Table_Abstract::getDefaultAdapter(),
                'users_v02',
                'email',
                'password',
                'SHA1(?)'
            );
            $adapter->setIdentity($form->getValue('email'));
            $adapter->setCredential($form->getValue('password'));

            $result = Zend_Auth::getInstance()->authenticate($adapter);
            if (!$result->isValid()) {
                d($result->getMessages());
            } else {
                $this->_redirect('/');
            }
        }

    }

    /*
    public function moreAction()
    {
        $form = $this->view->form = new Application_Form_Login();
        if ($this->getRequest()->isPost()
            && $form->isValid($this->getRequest()->getPost())
        ) {
            $adapter = new Zend_Auth_Adapter_DbTable(
                Zend_Db_Table_Abstract::getDefaultAdapter(),
                'users_v02',
                'email',
                'password',
                'SHA1(?)'
            );
            $adapter->setIdentity($form->getValue('email'));
            $adapter->setCredential($form->getValue('password'));

            $result = Zend_Auth::getInstance()->authenticate($adapter);
            if (!$result->isValid()) {
                d($result->getMessages());
            } else {
                $storage = Zend_Auth::getInstance()->getStorage();
                $storage->write(
                    $adapter->getResultRowObject(
                        array('email', 'name')
                    )
                );
                $this->_redirect('/');
            }
        }
    }*/

    public function secretAction()
    {
        print_r($_SESSION['pomoc']);
        $request = $this->getRequest()->getServer('HTTP_REFERER');
        //$request->getHeader('referer');
        print_r( $request);
    }


}









