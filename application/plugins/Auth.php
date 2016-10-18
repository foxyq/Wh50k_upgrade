<?php

class Application_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request){

        if (!$this->_isRestrictedRequest($request)){
            return;
        }

        if (!Zend_Auth::getInstance()->hasIdentity()){
            $r = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
            $r->gotoUrlAndExit('/auth/login');
        }

    }

    protected function _isRestrictedRequest($request){

        $controller = $request->getControllerName();
        $action = $request->getActionName();

        if($controller = 'auth' && in_array($action, array('login')))
        {
            return false;
        }
        else
        {
            return true;
        }

    }

}
?>