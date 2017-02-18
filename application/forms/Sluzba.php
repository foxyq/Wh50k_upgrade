<?php

class Application_Form_Sluzba extends ZendX_JQuery_Form
{

    public function init()
    {
        $this->setName('sluzba');

        $id = new Zend_Form_Element_Hidden('t_sluzby_id');
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




        $datum_sluzby_od = new ZendX_JQuery_Form_Element_DatePicker("datum_sluzby_od_d",
            "12.12.2014", array(), array());

        $datum_sluzby_od->setValue(Zend_Date::now()->toString('YYYY-MM-dd'));

        $datum_sluzby_od->setJQueryParam('dateFormat', 'yy-mm-dd')
            ->setRequired(true)
            ->setLabel("Dátum služby od")
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator($validatorDatum)
            ->setAttrib('class', 'form-control');


        $datum_sluzby_do = new ZendX_JQuery_Form_Element_DatePicker("datum_sluzby_do_d",
            "12.12.2014", array(), array());

        $datum_sluzby_do->setValue(Zend_Date::now()->toString('YYYY-MM-dd'));

        $datum_sluzby_do->setJQueryParam('dateFormat', 'yy-mm-dd')
            ->setRequired(true)
            ->setLabel("Dátum služby do")
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

        $miestoStiepenia = new Zend_Form_Element_Select('$miesto_stiepenia_enum');
        $miestoStiepenia->addMultiOptions(array(
            '0' => '' ));
        $miestoStiepenia->addMultiOptions($this->getAttrib('miestaStiepeniaMoznosti'));
        $miestoStiepenia->setLabel("Miesto štiepenia")
            ->addValidator($validatorSelecty)
            ->setAttrib('class', 'form-control');

        $stroj = new Zend_Form_Element_Select('$stroj_enum');
        $stroj->addMultiOptions(array(
            '0' => '' ));
        $stroj->addMultiOptions($this->getAttrib('strojeMoznosti'));
        $stroj->setLabel('Stroj');
        $stroj->addValidator($validatorSelecty)
            ->setAttrib('class', 'form-control');

        /*
         * KVANTITA
         */
        $q_tony = new Zend_Form_Element_Text('q_tony');
        $q_tony->setLabel('Tony ')
            ->setAttrib('class', 'form-control in')
            ->setAttrib('tabindex', '-1')
            ->addFilter($filterCislaDesatinaCiarka)
            ->addValidator($validatorCislaRange);
        //->addValidator('float');

        $q_prm = new Zend_Form_Element_Text('q_prm');
        $q_prm->setLabel('PRM')
            ->setAttrib('class', 'form-control in')
            ->setAttrib('tabindex', '-1')
            ->addFilter($filterCislaDesatinaCiarka)
            ->addValidator($validatorCislaRange);
        //->addValidator('float');

        $q_motohodiny = new Zend_Form_Element_Text('q_motohodiny');
        $q_motohodiny->setLabel('Motohodiny')
            ->setAttrib('class', 'form-control in')
            ->setAttrib('tabindex', '-1')
            ->addFilter($filterCislaDesatinaCiarka)
            ->addValidator($validatorCislaRange);
        //->addValidator('float');

        /*
         * DOPLNUJUCE INFO
         */

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
            $datum_sluzby_od,
            $datum_sluzby_do,
            $zakaznik,
            $miestoStiepenia,
            $stroj,
            $q_tony,
            $q_prm,
            $q_motohodiny,
            $doklad_typ,
            $poznamka,
            $chyba,
            $stav_transakcie,
            $potvrdzujuceTlacidlo
        ));
    }


}

