<?php
class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract{

    private $_acl = null;
    private $_auth = null;

    public function __construct(Zend_Acl $acl, Zend_Auth $auth){
        $this->_acl = $acl;
        $this->_auth = $auth;

    }

    public function preDispatch(Zend_Controller_Request_Abstract $request){
        //Toto vsetko nechaj zakomentovane
        //$resource = $request->getModuleName()->getControllerName();
        //$modulName = $request->getModuleName();

        /*
        if (isset($modulName)){
            $controller = $request->getModuleName() . ':' . $request->getControllerName();
        }
        else{
            $controller = 'default:'.$request->getControllerName();
        }
        */

        $resource = $request->getModuleName() . ':' . $request->getControllerName();
        $action = $request->getActionName();

        $identity = $this->_auth->getStorage()->read();
        $role = $identity->users_types_enum;

        if(!$this->_acl->isAllowed($role, strtolower($resource), strtolower($action))){
            $request->setModuleName('default')
                    ->setControllerName('error')
                    ->setActionName('nopermission');

        }

    }




}