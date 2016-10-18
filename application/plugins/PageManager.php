<?php

class Application_Plugin_PageManager extends Zend_Controller_Plugin_Abstract
{
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {


        $pageManager = new Zend_Session_Namespace('pageManager');


        if (isset($pageManager->ignore)) {
            //
        } else {
            $pageManager->ignore = 0;
        }


        if ($pageManager->ignore == 1) {
            $pageManager->ignore = 0;
        } else {

            $pageManager->lastPageController = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
            $pageManager->lastPageAction = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
            $pageManager->lastPageParameters = Zend_Controller_Front::getInstance()->getRequest()->getParams();


        }

        /*
         * Poznámka: tam kde chces aby action ignorovalo plugin PageManagera tak das do controllera toto:
         * $_SESSION[pageManager][ignore] = 1;
         *
         * PageManager pouzivame pre tlacidlo spat a pre redirecty z method edit, add a delete (mali by sme teda pokial mame filtrovacky
         */

    }


}
?>