<?php

class Application_Form_MikroObjednavka extends Zend_Form
{

    public function init()
    {
        //print_r($this->getAttrib('objednavkyMoznosti'));
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
        $validatorCislaRange99999 = new Zend_Validate_Between(array('min' => 0, 'max' => 99999.99));
        $validatorCislaRange99999->setMessage("Zadané číslo sa nenachádza v intervale od 0 do 99999,99.");
        $validatorSelecty= new Zend_Validate_Between(array('min' => 1, 'max' => 9999999));
        $validatorSelecty->setMessage("Hodnota je povinná");
        $validatorSPZ = new Zend_Validate_Regex(array('pattern'=> "/^[a-zA-Z0-9]{5,7}$/"));
        $validatorSPZ->setMessage('Zadajte ŠPZ v tvare ZV123BU.', Zend_Validate_Regex::NOT_MATCH);

        /*
         * definicia elementov formu
         */

        $this->setName('mikroObjednavka');

        $id = new Zend_Form_Element_Hidden('objednavky_mikro_id');
        $id->addFilter('Int')/*
        ->addValidator('OrderDuplicity')*/;

        $actionName = strtolower(Zend_Controller_Front::getInstance()->getRequest()->getActionName());
        $submitButtonClass = "success";
        if ($actionName == 'edit'){
            $submitButtonClass = "primary";
        }

        $nadobjednavka = new Zend_Form_Element_Select('nadobjednavka_enum');
        $nadobjednavka->addMultiOptions(array(
            '0' => '' ));
        $nadobjednavka->addMultiOptions($this->getAttrib('objednavkyMoznosti'));
        $nadobjednavka->setLabel('Nadobjednávka')
            ->setAttrib('class', 'form-control')
        ->setRequired(false);


        $datum_od = new ZendX_JQuery_Form_Element_DatePicker("datum_od_d",
            "12.12.2014", array(), array());

        $datum_od->setValue(Zend_Date::now()->toString('YYYY-MM-dd'));

        $datum_od->setJQueryParam('dateFormat', 'yy-mm-dd')
            ->setRequired(true)
            ->setLabel("Dátum od")
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator($validatorDatum)
            ->setAttrib('class', 'form-control');


        $datum_do = new ZendX_JQuery_Form_Element_DatePicker("datum_do_d",
            "12.12.2014", array(), array());

        $datum_do->setValue(Zend_Date::now()->toString('YYYY-MM-dd'));

        $datum_do->setJQueryParam('dateFormat', 'yy-mm-dd')
            ->setRequired(true)
            ->setLabel("Dátum do")
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator($validatorDatum)
            ->setAttrib('class', 'form-control');

        $mnozstvo = new Zend_Form_Element_Text('mnozstvo');
        $mnozstvo->setLabel('Množstvo' )
            ->setAttrib('class', 'form-control in')
            ->addFilter($filterCislaDesatinaCiarka)
            ->addValidator($validatorCislaRange99999)
        ->setRequired(true);

        $zakaznik = new Zend_Form_Element_Select('zakaznik_enum');
        $zakaznik->addMultiOptions(array(
            '0' => '' ));
        $zakaznik->addMultiOptions($this->getAttrib('zakazniciMoznosti'));
        $zakaznik->setLabel('Zákazník')
            ->setAttrib('class', 'form-control')
        ->setRequired(true)
        ->addValidator($validatorSelecty);

        $merna_jednotka = new Zend_Form_Element_Select('merna_jednotka_enum');
        $merna_jednotka->setMultiOptions($this->getAttrib('merneJednotkyMoznosti'));
        $merna_jednotka->setLabel('Merná jednotka')
            ->setAttrib('class', 'form-control')
        ->setRequired(true);

        $poznamka = new Zend_Form_Element_Text('poznamka');
        $poznamka->setLabel('Poznámka')
            ->setAttrib('class', 'form-control')
            ->addFilter($filterTagy);


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
        ->setAttrib('class', 'form-control btn-'.$submitButtonClass);

        $this->addElements(array($id, $nadobjednavka, $datum_od, $datum_do, $mnozstvo, $zakaznik, $merna_jednotka, $poznamka, $submit));

    }


}

