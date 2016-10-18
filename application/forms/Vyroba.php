<?php

class Application_Form_Vyroba extends ZendX_JQuery_Form{

    public function init()
    {
        $this->setName('vyroba');

        $id = new Zend_Form_Element_Hidden('tx_vyroba_id');
        $id->addFilter('Int');

        /*
         * definicia filtrov
         */
        $filterCislaDesatinaCiarka = new Zend_Filter_PregReplace(array('match' => '/,/', 'replace' => '.'));
        $filterTagy = new Zend_Filter_StripTags();
        $strToUpper = new Zend_Filter_StringToUpper();
        $filterOdstranCiarku = new Zend_Filter_PregReplace(array('match'=>'/-/', 'replace'=>''));
        $filterOdstranMedzery = new Zend_Filter_PregReplace(array('match'=>'/ /', 'replace'=>''));

        /*
         * definicia validatorov
         */
        $validatorDatum = new Zend_Validate_Date();
        $validatorDatum->setMessage('Dátum nevyhovuje formátu rrrr-mm-dd', Zend_Validate_Date::FALSEFORMAT);
        $validatorPercentaRange = new Zend_Validate_Between(array('min' => 0, 'max' => 99.99));
        $validatorPercentaRange->setMessage("Zadané číslo sa nenachádza v intervale od 0 do 99,99.");
        $validatorCislaRange = new Zend_Validate_Between(array('min' => 0, 'max' => 999.99));
        $validatorCislaRange->setMessage("Zadané číslo sa nenachádza v intervale od 0 do 999,99.");
        $validatorSelecty= new Zend_Validate_Between(array('min' => 1, 'max' => 9999999));
        $validatorSelecty->setMessage("Hodnota je povinná");
        $validatorSPZ = new Zend_Validate_Regex(array('pattern'=> "/^[a-zA-Z0-9]{5,8}$/"));
        $validatorSPZ->setMessage('Zadajte ŠPZ v tvare ZV123BU.', Zend_Validate_Regex::NOT_MATCH);


        $actionName = strtolower(Zend_Controller_Front::getInstance()->getRequest()->getActionName());
        $submitButtonClass = "success";
        if ($actionName == 'edit'){
            $submitButtonClass = "primary";
        }

        $datum_vyroby = new ZendX_JQuery_Form_Element_DatePicker("datum_xvyroby_d",
                            "12.12.2014", array(), array());

        $datum_vyroby->setValue(Zend_Date::now()->toString('YYYY-MM-dd'));

        $datum_vyroby->setJQueryParam('dateFormat', 'yy-mm-dd')
            ->setRequired(true)
            ->setLabel("Dátum externej výroby")
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator($validatorDatum)
            ->setAttrib('class', 'form-control');


        $zakaznik = new Zend_Form_Element_Select('$zakaznik_enum');
        $zakaznik->addMultiOptions(array(
            '0' => '' ));
        $zakaznik->addMultiOptions($this->getAttrib('zakazniciMoznosti'));
        $zakaznik->setLabel("Zákazník")
            ->addValidator($validatorSelecty)
            ->setAttrib('class', 'form-control');

        $dodavatel = new Zend_Form_Element_Select('$dodavatel_enum');
        $dodavatel->addMultiOptions(array(
            '0' => '' ));
        $dodavatel->addMultiOptions($this->getAttrib('dodavateliaMoznosti'));
        $dodavatel->setLabel("Dodávateľ")
            ->addValidator($validatorSelecty)
            ->setAttrib('class', 'form-control');

        $miesta_stiepenia = new Zend_Form_Element_Select('$miesto_stiepenia_enum');
        $miesta_stiepenia->addMultiOptions(array(
            '0' => '' ));
        $miesta_stiepenia->addMultiOptions($this->getAttrib('miestaStiepeniaMoznosti'));
        $miesta_stiepenia->setLabel("Miesto štiepenia")
            ->addValidator($validatorSelecty)
            ->setAttrib('class', 'form-control');

        $prepravca = new Zend_Form_Element_Select('prepravca_enum');
        $prepravca->addMultiOptions(array(
            '0' => '' ));
        $prepravca->addMultiOptions($this->getAttrib('prepravciMoznosti'));
        $prepravca->setLabel('Prepravca')
            ->addValidator($validatorSelecty)
            ->setAttrib('class', 'form-control');

        $prepravca_spz = new Zend_Form_Element_Text('prepravca_spz');
        $prepravca_spz->setLabel('ŠPZ');
        $prepravca_spz->setRequired(true)
            ->setAttrib('class', 'form-control')
            ->addFilter($strToUpper)
            ->addFilter($filterOdstranCiarku)
            ->addFilter($filterOdstranMedzery)
            ->addValidator($validatorSPZ);

        $stroj_enum = new Zend_Form_Element_Select('$stroj_enum');
        $stroj_enum->addMultiOptions(array(
            '0' => '' ));
        $stroj_enum->addMultiOptions($this->getAttrib('strojeMoznosti'));
        $stroj_enum->setLabel('Stroj');
        $stroj_enum->addValidator($validatorSelecty)
                    ->setAttrib('class', 'form-control');

        /*
         * KVANTITA
         */
        $q_m3_merane = new Zend_Form_Element_Text('q_m3_merane');
        $q_m3_merane->setLabel('Merané m3' )
            ->setAttrib('class', 'form-control in')
            ->setAttrib('tabindex', '-1')
            ->addFilter($filterCislaDesatinaCiarka)
            ->addValidator($validatorCislaRange);
            //->addValidator('float');

        $q_prm_merane = new Zend_Form_Element_Text('q_prm_merane');
        $q_prm_merane->setLabel('Merané PRM')
            ->setAttrib('class', 'form-control in')
            ->setAttrib('tabindex', '-1')
            ->addFilter($filterCislaDesatinaCiarka)
            ->addValidator($validatorCislaRange);
            //->addValidator('float');

        $q_tony_merane = new Zend_Form_Element_Text('q_tony_merane');
        $q_tony_merane->setLabel('Tony netto')
            ->setAttrib('class', 'form-control in')
            ->setAttrib('tabindex', '-1')
            ->addFilter($filterCislaDesatinaCiarka)
            ->addValidator($validatorCislaRange);
            //->addValidator('float');

        $q_vlhkost = new Zend_Form_Element_Text('q_vlhkost');
        $q_vlhkost->setLabel('Vlhkosť')
            ->setAttrib('class', 'form-control in')
            ->setAttrib('tabindex', '-1')
            ->addFilter($filterCislaDesatinaCiarka)
            ->addValidator($validatorPercentaRange);
            //->addValidator('Float');

        /*
         * DOPLNUJUCE INFO
         */




        $material_typ = new Zend_Form_Element_Select('material_typ_enum');
        $material_typ->addMultiOptions(array(
            '0' => '' ));
        $material_typ->addMultiOptions($this->getAttrib('materialyTypyMoznosti'));
        $material_typ->setLabel('Materiál typ')
            ->addValidator($validatorSelecty)
            ->setAttrib('class', 'form-control');

        $material_druh = new Zend_Form_Element_Select('material_druh_enum');
        $material_druh->addMultiOptions(array(
            '0' => '' ));
        $material_druh->addMultiOptions($this->getAttrib('materialyDruhyMoznosti'));
        $material_druh->setLabel('Materiál druh');
        $material_druh->setAttrib('class', 'form-control')
            ->addValidator($validatorSelecty);

        $doklad_typ = new Zend_Form_Element_Select('doklad_typ_enum');
        $doklad_typ->setMultiOptions($this->getAttrib('dokladyTypyMoznosti'));
        $doklad_typ->setLabel('Doklad typ')
            ->setAttrib('class', 'form-control');


        $poznamka = new Zend_Form_Element_Text('poznamka');
        $poznamka->setLabel('Poznámka')
            ->setAttrib('class', 'form-control')
            ->addFilter($filterTagy);

        $chyba = new Zend_Form_Element_Checkbox('chyba');
        $chyba->setLabel('Chyba');
//            ->setAttrib('class', 'form-control');

        $stav_transakcie = new Zend_Form_Element_Select('stav_transakcie');
        $stav_transakcie->addMultiOptions($this->getAttrib('transakcieStavyMoznosti'));
        $stav_transakcie->setLabel('Stav transakcie')
            ->setAttrib('class', 'form-control')
            ->addValidator($validatorSelecty)
            ->addValidator('DefinedQuantity');

        $potvrdzujuceTlacidlo = new Zend_Form_Element_Submit('potvrdzujuceTlacidlo');
        $potvrdzujuceTlacidlo->setLabel($this->getAttrib('potvrdzujuceTlacidlo'));
        $potvrdzujuceTlacidlo->setAttrib('id', 'submitbutton')
            ->setAttrib('class', 'form-control btn-'.$submitButtonClass);




        $this->addElements(array(
            $id,
            $datum_vyroby,
            $zakaznik,
            $dodavatel,
            $miesta_stiepenia,
            $prepravca,
            $prepravca_spz,
            $q_tony_merane,
            $q_m3_merane,
            $q_prm_merane,
            $q_vlhkost,
            $doklad_typ,
            $stroj_enum,
            $material_druh,
            $material_typ,
            $poznamka,
            $chyba,
            $stav_transakcie,
            $potvrdzujuceTlacidlo
        ));
    }
}

