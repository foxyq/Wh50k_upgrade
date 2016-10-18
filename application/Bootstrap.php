<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
//
    protected function _initViewHelpers()
    {


        $view = new Zend_View();
//        aj toto je dolezite pre jquery ... kto by to bol povedal
//        tu sa to nejako inicializuje, a potom vzdy ked to chces pouzit v nejakej metode controlleru
//        tak to treba v nej volat zas, alebo rovno v controller->init (vydaje, prijmy ...)
        $view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');



        $view->headLink()->headLink(array('rel' => 'favicon',
                              'href' => $view->baseUrl("public/images/favicon.ico"),
                                'type' => 'image/x-icon' ));


//        $view->jQuery()->addStylesheet('http://localhost/wh50k/public/js/jquery/jquery-ui-dark.css')
//        ->setLocalPath('http://localhost/wh50k/public/js/jquery.min.js')
//        ->setUiLocalPath('http://localhost/wh50k/public/js/jquery-ui.min.js');

//         KONIEC HLASENIA ... na live zmazat a odkomentovat cast v application.ini
        return $view;
    }

    protected function _getPublicPath() {
        chdir(APPLICATION_PATH);
        return realpath("../public");
    }

    protected function _getApplicationUrl() {
        return $_SERVER['SERVER_NAME'];
    }

    protected function _initAutoLoad(){


        //Acl nacitanie pluginu
        $acl = new Application_Model_LibraryAcl();
        $auth = Zend_Auth::getInstance();
        $fc = Zend_Controller_Front::getInstance();
        $fc->registerPlugin(new Application_Plugin_AccessCheck($acl, $auth));
        //koniec nacitania pluginu



    }

    protected function _initRoutes()
{
    $router = Zend_Controller_Front::getInstance()->getRouter();
    include APPLICATION_PATH . "/configs/routes.php";
}
}

