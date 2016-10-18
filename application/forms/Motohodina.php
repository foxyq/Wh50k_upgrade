<?php

class Application_Form_Motohodina extends Zend_Form
{

    public function init()
    {
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
        $validatorSelecty= new Zend_Validate_Between(array('min' => 1, 'max' => 999));
        $validatorSelecty->setMessage("Hodnota je povinná");
        $validatorSPZ = new Zend_Validate_Regex(array('pattern'=> "/^[a-zA-Z0-9]{5,7}$/"));
        $validatorSPZ->setMessage('Zadajte ŠPZ v tvare ZV123BU.', Zend_Validate_Regex::NOT_MATCH);

        /*
         * definicia elementov formu
         */

        $this->setName('motohodina');

        $id = new Zend_Form_Element_Hidden('motohodiny_id');
        $id->addFilter('Int')
        ->addValidator('MotohodinaDuplicity');

        $actionName = strtolower(Zend_Controller_Front::getInstance()->getRequest()->getActionName());
        $submitButtonClass = "success";
        if ($actionName == 'edit'){
            $submitButtonClass = "primary";
        }

        $stroj = new Zend_Form_Element_Select('stroj_enum');
        $stroj->setMultiOptions($this->getAttrib('strojeMoznosti'));
        $stroj->setLabel('Stroj')
            ->setAttrib('class', 'form-control')
            ->setRequired(true);

        $rok = new Zend_Form_Element_Select('rok_enum');
        $rok->setMultiOptions($this->getAttrib('rokyMoznosti'));
        $rok->setLabel('Rok')
            ->setAttrib('class', 'form-control')
        ->setRequired(true);

        $mesiac = new Zend_Form_Element_Select('mesiac_enum');
        $mesiac->setMultiOptions($this->getAttrib('mesiaceMoznosti'));
        $mesiac->setLabel('Mesiac')
            ->setAttrib('class', 'form-control')
        ->setRequired(true);


        $pocetHodin = new Zend_Form_Element_Text('pocet_hodin');
        $pocetHodin->setLabel('Počet hodín' )
            ->setAttrib('class', 'form-control in')
            ->addFilter($filterCislaDesatinaCiarka)
            ->addValidator($validatorCislaRange99999)
        ->setRequired(true);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
        ->setAttrib('class', 'form-control btn-'.$submitButtonClass);

        $this->addElements(array($id, $stroj, $rok, $mesiac, $pocetHodin, $submit));
    }


}

