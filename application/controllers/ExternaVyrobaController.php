<?php

class ExternavyrobaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
    }

    public function indexAction()
    {
        // action body

    }

    public function listAction()
    {
        // vytvorenie instancií modelov
        $externeVyroby = new Application_Model_DbTable_ExternaVyroba();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $miestaStiepenia = new Application_Model_DbTable_MiestaStiepenia();
        $stroje = new Application_Model_DbTable_Stroje();

        // priradenie modelov do premenných a poslanie na view script
        $param = $this->_getParam('param', null);
        $title = $this->_getParam('title', null);
        if (!isset($title)){$title = 'Externé výroby - zoznam';}

        // priradenie modelov do premenných a poslanie na view script
        $this->view->externeVyroby = $externeVyroby->fetchAll($param);
        $this->view->externeVyrobyModel = $externeVyroby;
        $this->view->zakaznici = $zakaznici;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;
        $this->view->miestaStiepenia = $miestaStiepenia;
        $this->view->stroje = $stroje;

        //názov stránky
        $this->view->title = "Externá výroba - zoznam";
    }

    public function errorsAction()
    {
        // vytvorenie instancií modelov
        $externeVyroby = new Application_Model_DbTable_ExternaVyroba();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $miestaStiepenia = new Application_Model_DbTable_MiestaStiepenia();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $stroje = new Application_Model_DbTable_Stroje();

        // priradenie modelov do premenných a poslanie na view script
        //$param = $this->_getParam('param', null);
        //$title = $this->_getParam('title', null);
        //if (!isset($title)){$title = 'Externé výroby - zoznam';}

        // priradenie modelov do premenných a poslanie na view script
        $this->view->externeVyroby = $externeVyroby->fetchAll("chyba = 1");
        $this->view->zakaznici = $zakaznici;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->miestaStiepenia = $miestaStiepenia;
        $this->view->prepravci = $prepravci;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;
        $this->view->stroje = $stroje;

        //názov stránky
        $this->view->title = "Externá výroba - chyby";
    }

    public function waitingsAction()
    {
        // vytvorenie instancií modelov
        $externeVyroby = new Application_Model_DbTable_ExternaVyroba();
        $zakaznici = new Application_Model_DbTable_Zakaznici();
        $dodavatelia = new Application_Model_DbTable_Dodavatelia();
        $prepravci = new Application_Model_DbTable_Prepravci();
        $miestaStiepenia = new Application_Model_DbTable_MiestaStiepenia();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $stroje = new Application_Model_DbTable_Stroje();

        // priradenie modelov do premenných a poslanie na view script
        //$param = $this->_getParam('param', null);
        //$title = $this->_getParam('title', null);
        //if (!isset($title)){$title = 'Externé výroby - zoznam';}

        // priradenie modelov do premenných a poslanie na view script
        $this->view->externeVyroby = $externeVyroby->fetchAll("stav_transakcie = 1");
        $this->view->zakaznici = $zakaznici;
        $this->view->prepravci = $prepravci;
        $this->view->dodavatelia = $dodavatelia;
        $this->view->miestaStiepenia = $miestaStiepenia;
        $this->view->materialyTypy = $materialyTypy;
        $this->view->materialyDruhy = $materialyDruhy;
        $this->view->transakcieStavy = $transakcieStavy;
        $this->view->stroje = $stroje;

        //názov stránky
        $this->view->title = "Externá výroba - čaká na schválenie";
    }

    public function printAction()
    {
        // action body
    }

    public function addAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'externavyroba');
        $this->view->fromController = $fromController;
        //instancia modelu z ktoreho budeme tahat zoznam

        $zakazniciMoznosti = new Application_Model_DbTable_Zakaznici();
        $dodavateliaMoznosti = new Application_Model_DbTable_Dodavatelia();
        $miestaStiepenia = new Application_Model_DbTable_MiestaStiepenia();
        $prepravciMoznosti = new Application_Model_DbTable_Prepravci();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $stroje = new Application_Model_DbTable_Stroje();
        //metoda ktorou vytiahneme do premennej zoznam

        $zakazniciMoznosti = $zakazniciMoznosti->getMoznosti();
        $dodavateliaMoznosti = $dodavateliaMoznosti->getMoznosti();
        $miestaStiepeniaMoznosti = $miestaStiepenia->getMoznosti();
        $prepravciMoznosti = $prepravciMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $materialyDruhyMoznosti = $materialyDruhy->getMoznosti();
        $materialyTypyMoznosti = $materialyTypy->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();
        $strojeMoznosti = $stroje->getMoznosti();

        //zoradenie
        asort($zakazniciMoznosti);
        asort($dodavateliaMoznosti);
        asort($prepravciMoznosti);
        asort($miestaStiepeniaMoznosti);
        //samostatne premenne ktore posielame na form

        $potvrdzujuceTlacidlo = 'Vložiť';
        $form = new Application_Form_Vyroba(array(

            'zakazniciMoznosti' => $zakazniciMoznosti,
            'dodavateliaMoznosti' => $dodavateliaMoznosti,
            'miestaStiepeniaMoznosti' => $miestaStiepeniaMoznosti,
            'prepravciMoznosti' => $prepravciMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'materialyDruhyMoznosti' => $materialyDruhyMoznosti,
            'materialyTypyMoznosti' => $materialyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'strojeMoznosti' => $strojeMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo,
        ));
        $this->view->form = $form;


        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) {
                $datum_vydaju = $form->getValue('datum_xvyroby_d');
                $zakaznik = $form->getValue('zakaznik_enum');
                $dodavatel = $form->getValue('dodavatel_enum');
                $miestoStiepenia = $form->getValue('miesto_stiepenia_enum');
                $prepravca = $form->getValue('prepravca_enum');
                $prepravca_spz = $form->getValue('prepravca_spz');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $stroj = $form->getValue('stroj_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
//                $code = str_replace('-', '', $datum_vydaju);
//                $code = substr( $code, 2);
                $vyroba = new Application_Model_DbTable_ExternaVyroba();


                $count = count($vyroba->getDokladyCislaByDate($datum_vydaju));

//                $max = $count + 1;


                if ($count == 0) {

                    $max = 1;
                }
                else {

                    $last = end($vyroba->getDokladyCislaByDate($datum_vydaju));
                    $max = substr($last, -3);
                    $max += 1;
                }

                $max = sprintf("%03d", $max);



                $nove_meno = "EV-" . $datum_vydaju. "-" .$max; // . ".pdf";
                $doklad_cislo = $nove_meno;

//                echo $doklad_cislo;

                $vyroba->addXVyroba(
                    $datum_vydaju,
                    $zakaznik,
                    $dodavatel,
                    $miestoStiepenia,
                    $prepravca,
                    $prepravca_spz,
                    $q_tony_merane,
                    $q_m3_merane,
                    $q_prm_merane,
                    $q_vlhkost,
                    $doklad_typ,
                    $material_typ,
                    $material_druh,
                    $stroj,
                    $poznamka,
                    $chyba,
                    $stav_transakcie,
                    $doklad_cislo);

                $this->_helper->redirector($fromAction);
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'externavyroba');
        $this->view->fromController = $fromController;
        //instancia modelu z ktoreho budeme tahat zoznam
        $zakazniciMoznosti = new Application_Model_DbTable_Zakaznici();
        $dodavateliaMoznosti = new Application_Model_DbTable_Dodavatelia();
        $miestaStiepenia = new Application_Model_DbTable_MiestaStiepenia();
        $prepravciMoznosti = new Application_Model_DbTable_Prepravci();
        $dokladyTypyMoznosti = new Application_Model_DbTable_DokladyTypy();
        $materialyDruhy = new Application_Model_DbTable_MaterialyDruhy();
        $materialyTypy = new Application_Model_DbTable_MaterialyTypy();
        $transakcieStavy = new Application_Model_DbTable_TransakcieStavy();
        $stroje = new Application_Model_DbTable_Stroje();
        //metoda ktorou vytiahneme do premennej zoznam
        $zakazniciMoznosti = $zakazniciMoznosti->getMoznosti();
        $dodavateliaMoznosti = $dodavateliaMoznosti->getMoznosti();
        $miestaStiepeniaMoznosti = $miestaStiepenia->getMoznosti();
        $prepravciMoznosti = $prepravciMoznosti->getMoznosti();
        $dokladyTypyMoznosti = $dokladyTypyMoznosti->getMoznosti();
        $materialyDruhyMoznosti = $materialyDruhy->getMoznosti();
        $materialyTypyMoznosti = $materialyTypy->getMoznosti();
        $transakcieStavyMoznosti = $transakcieStavy->getMoznosti();
        $strojeMoznosti = $stroje->getMoznosti();
        //zoradenie
        asort($zakazniciMoznosti);
        asort($dodavateliaMoznosti);
        asort($prepravciMoznosti);
        asort($miestaStiepeniaMoznosti);
        //samostatne premenne ktore posielame na form
        $potvrdzujuceTlacidlo = 'Upraviť';
        $form = new Application_Form_Vyroba(array(
            'zakazniciMoznosti' => $zakazniciMoznosti,
            'dodavateliaMoznosti' => $dodavateliaMoznosti,
            'miestaStiepeniaMoznosti' => $miestaStiepeniaMoznosti,
            'prepravciMoznosti' => $prepravciMoznosti,
            'dokladyTypyMoznosti' => $dokladyTypyMoznosti,
            'materialyDruhyMoznosti' => $materialyDruhyMoznosti,
            'materialyTypyMoznosti' => $materialyTypyMoznosti,
            'transakcieStavyMoznosti' => $transakcieStavyMoznosti,
            'strojeMoznosti' => $strojeMoznosti,
            'potvrdzujuceTlacidlo' => $potvrdzujuceTlacidlo
        ));
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
//            print_r($formData);
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('tx_vyroba_id');
                $datum_xvyroby_d = $form->getValue('datum_xvyroby_d');
                $zakaznik = $form->getValue('zakaznik_enum');
                $dodavatel = $form->getValue('dodavatel_enum');
                $miestoStiepenia = $form->getValue('miesto_stiepenia_enum');
                $prepravca = $form->getValue('prepravca_enum');
                $prepravca_spz = $form->getValue('prepravca_spz');
                $q_tony_merane = $form->getValue('q_tony_merane');
                $q_m3_merane = $form->getValue('q_m3_merane');
                $q_prm_merane = $form->getValue('q_prm_merane');
                $q_vlhkost = $form->getValue('q_vlhkost');
                $doklad_typ = $form->getValue('doklad_typ_enum');
                $material_typ = $form->getValue('material_typ_enum');
                $material_druh = $form->getValue('material_druh_enum');
                $stroj = $form->getValue('stroj_enum');
                $poznamka = $form->getValue('poznamka');
                $chyba = $form->getValue('chyba');
                $stav_transakcie = $form->getValue('stav_transakcie');
                $vyroba = new Application_Model_DbTable_ExternaVyroba();
                $vyroba->editXVyroba(
                    $id,
                    $datum_xvyroby_d,
                    $zakaznik,
                    $dodavatel,
                    $miestoStiepenia,
                    $prepravca,
                    $prepravca_spz,
                    $q_tony_merane,
                    $q_m3_merane,
                    $q_prm_merane,
                    $q_vlhkost,
                    $doklad_typ,
                    $material_typ,
                    $material_druh,
                    $stroj,
                    $poznamka,
                    $chyba,
                    $stav_transakcie);

                $this->_helper->redirector($fromAction);
            } else {
                $form->populate($formData);

            }
        } else {
            $id = $this->_getParam('id', 0);
            //$id = (int)$this->$form->getValue('tx_vyroba_id');

            if ($id > 0) {
                $vyroba = new Application_Model_DbTable_ExternaVyroba();
                $form->populate($vyroba->getXVyrobaFormatted($id));
                $this->view->data = $vyroba->getXVyroba($id);

            }
        }
    }

    public function deleteAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $this->view->fromAction = $fromAction;
        $fromController = $this->_getParam('fromController', 'externavyroba');
        $this->view->fromController = $fromController;
        //inicializacia pre vypis premennych - pre getNazov() metody

        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $prepravciModel = new Application_Model_DbTable_Prepravci();
        $strojeModel = new Application_Model_DbTable_Stroje();
        $dokladyTypyModel = new Application_Model_DbTable_DokladyTypy();
        $materialyTypyModel = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhyModel = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();
        $ciselniky = array(
            'zakazniciModel' => $zakazniciModel,
            'prepravciModel' => $prepravciModel,
            'strojeModel'=>$strojeModel,
            'dokladyTypyModel' => $dokladyTypyModel,
            'materialyTypyModel' => $materialyTypyModel,
            'materialyDruhyModel' => $materialyDruhyModel,
            'transakcieStavyModel' => $transakcieStavyModel,
            'strojeMoznosti' => $strojeModel
        );
        $this->view->ciselniky = $ciselniky;
        $this->view->title = "Zmazať externú výrobu?";
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Áno') {
                $id = $this->getRequest()->getPost('tx_vyroba_id');
                $vyroba = new Application_Model_DbTable_ExternaVyroba();
                $vyroba->deleteXVyroba($id);
            }
            $this->_helper->redirector($fromAction);

        } else {
            $id = $this->_getParam('id', 0);
            $vyroba = new Application_Model_DbTable_ExternaVyroba();
            $this->view->vyroba = $vyroba->getXVyroba($id);

        }
    }

    public function previewAction()
    {
        $fromAction = $this->_getParam('fromAction', 'list');
        $fromController = $this->_getParam('fromController', 'externavyroba');
        $fromId = $this->_getParam('fromId', null);
        $this->view->fromAction = $fromAction;
        $this->view->fromController = $fromController;
        $this->view->fromId = $fromId;

        //inicializacia pre vypis premennych - pre getNazov() metody
        $zakazniciModel = new Application_Model_DbTable_Zakaznici();
        $dodavateliaModel = new Application_Model_DbTable_Dodavatelia();
        $miestaStiepenia = new Application_Model_DbTable_MiestaStiepenia();
        $prepravciModel = new Application_Model_DbTable_Prepravci();
        $strojeModel = new Application_Model_DbTable_Stroje();
        $dokladyTypyModel = new Application_Model_DbTable_DokladyTypy();
        $materialyTypyModel = new Application_Model_DbTable_MaterialyTypy();
        $materialyDruhyModel = new Application_Model_DbTable_MaterialyDruhy();
        $transakcieStavyModel = new Application_Model_DbTable_TransakcieStavy();
        $ciselniky = array(
            'zakazniciModel' => $zakazniciModel,
            'dodavateliaModel' => $dodavateliaModel,
            'miestaStiepeniaModel' => $miestaStiepenia,
            'prepravciModel' => $prepravciModel,
            'strojeModel'=>$strojeModel,
            'dokladyTypyModel' => $dokladyTypyModel,
            'materialyTypyModel' => $materialyTypyModel,
            'materialyDruhyModel' => $materialyDruhyModel,
            'transakcieStavyModel' => $transakcieStavyModel
        );
        $id = $this->_getParam('id');
        $vyroby = new Application_Model_DbTable_ExternaVyroba();
//        $vyroba = $vyroby->getXVyrobaByDokladCislo($id);
        $vyroba = $vyroby->getXVyroba($id);
        $this->view->vyroba = $vyroba;
        $this->view->ciselniky = $ciselniky;
    }

    public function getdodavkyAction()
    {
        $request = $this->getRequest()->getPost();
        $message = $request['message'];
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host'     => 'localhost',
            'username' => 'root',
            'password' => 'mysql',
            'dbname'   => 'database',
            'charset'  => 'utf8'
        ));
        $limit = $message;
        $stmt = $db->query(
            'SELECT
            tx_vyroba_id AS id,
            datum_xvyroby_d AS datum,
            zakaznici.meno  AS zakaznik,
            dodavatelia.meno AS dodavatel,
            prepravci.meno AS prepravca,
            miesta_stiepenia.nazov_miesta AS miesto_stiepenia,
            stroje.nazov_stroja AS stroj,
            q_tony_merane AS tony,
            q_m3_merane AS m3,
            q_prm_merane AS prm ,
            q_vlhkost AS vlhkost,
            doklad_cislo AS doklad_cislo,
            materialy_typy.nazov AS typ,
            chyba,
            stav_transakcie AS stav

            FROM
            tx_vyroba

            LEFT JOIN stroje ON tx_vyroba.stroj_enum=stroje.stroje_id
            LEFT JOIN miesta_stiepenia ON tx_vyroba.miesto_stiepenia_enum=miesta_stiepenia.miesta_stiepenia_id
            LEFT JOIN zakaznici ON tx_vyroba.zakaznik_enum=zakaznici.zakaznici_id
            LEFT JOIN dodavatelia ON tx_vyroba.dodavatel_enum=dodavatelia.dodavatelia_id
            LEFT JOIN prepravci ON tx_vyroba.prepravca_enum=prepravci.prepravci_id
            LEFT JOIN materialy_typy ON tx_vyroba.material_typ_enum=materialy_typy.materialy_typy_id
            LEFT JOIN materialy_druhy ON tx_vyroba.material_druh_enum=materialy_druhy.materialy_druhy_id'
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);

        echo json_encode($data, JSON_UNESCAPED_UNICODE);

    }


}



















