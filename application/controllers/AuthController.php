<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }



    public function loginAction()
    {
        // prihlasi s hashom
        $form = $this->view->form = new Application_Form_Login();
        $this->view->loginTitle = "Prihlásenie do aplikácie";
        //$this->view->wrongCredentials = false;

        $this->_helper->layout()->disableLayout();
        if ($this->getRequest()->isPost()
            && $form->isValid($this->getRequest()->getPost())
        ) {
            $adapter = new Zend_Auth_Adapter_DbTable(
                Zend_Db_Table_Abstract::getDefaultAdapter(),
                'users',
                'email',
                'password',
                'SHA1(?)'
            );
            $adapter->setIdentity($form->getValue('email'));
            $adapter->setCredential($form->getValue('password'));
            //$adapter->setIdentityColumn('hollaAtMe');


            $result = Zend_Auth::getInstance()->authenticate($adapter);

            if (!$result->isValid()) {
                $this->view->wrongCredentials = true;

                //d($result->getMessages());
            } else {
                $storage = Zend_Auth::getInstance()->getStorage();
                $storage->write(
                    $adapter->getResultRowObject(
                        array('email', 'name', 'users_types_enum', 'id')
                    )
                );

                $zendAuthIdentity = (array) Zend_Auth::getInstance()->getIdentity();
                $zendAuthEmail = $zendAuthIdentity['email'];
                $usersModel = new Application_Model_DbTable_Users();
                $userType = $usersModel->getUserType($zendAuthEmail);

                //redirector na úvodné stránky na základe typu účtu užívateľa
                //TODO - toto bude treba niekedy v buducnosti asi prerobit - dlho bude vypocitavat
                switch ($userType){
                    //superadmin
                    case 1:
                        echo "Nacitam profil";
                        $ubytky = new Application_Model_DbTable_UbytkyHmotnosti();
                        $ubytky->refreshTableDataByDate(Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('calendar_start_date'), date('Y-m-d'));

                        $this->_redirect('/default');
                        break;
                    //admin
                    case 2:
                        $ubytky = new Application_Model_DbTable_UbytkyHmotnosti();
                        $ubytky->refreshTableDataByDate(Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('calendar_start_date'), date('Y-m-d'));

                        $this->_redirect('/default');
                        break;
                    //skladnik
                    case 3:
                        $this->_redirect('/skladnik');
                        break;
                }


            }
        }
    }

    public function logoutAction()
    {
        // odhlási z aplikácie
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/auth/login');
    }


}





