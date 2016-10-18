<?php

class Application_Form_Dodavatel extends Zend_Form
{

    public function init()
    {
        $this->setName('dodavatel');


         $actionName = strtolower(Zend_Controller_Front::getInstance()->getRequest()->getActionName());
         $submitButtonClass = "success";
         if ($actionName == 'edit'){
             $submitButtonClass = "primary";
         }


        $id = new Zend_Form_Element_Hidden('dodavatelia_id');
        $id->addFilter('Int');

        $meno = new Zend_Form_Element_Text('meno');
        $meno->setLabel('Meno')
             ->setRequired(true)
             ->addValidator(new Zend_Validate_StringLength(array(
                 'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('dodavatelia_meno'))))
        ->setAttrib('class', 'form-control');

        $nazov_spolocnosti = new Zend_Form_Element_Text('nazov_spolocnosti');
        $nazov_spolocnosti->setLabel('Názov spoločnosti')
                          ->setRequired(true)
                          ->addValidator(new Zend_Validate_StringLength(array(
                              'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('dodavatelia_nazov'))))
            ->setAttrib('class', 'form-control');

        $ico = new Zend_Form_Element_Text('ico');
        $ico->setLabel('IČO')
            ->setRequired(false)
            ->addValidator(new Zend_Validate_StringLength(array(
                 'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('dodavatelia_ico'))))
        ->setAttrib('class', 'form-control');

        $icDph = new Zend_Form_Element_Text('ic_dph');
        $icDph->setLabel('IČ DPH')
            ->setRequired(false)
            ->addValidator(new Zend_Validate_StringLength(array(
                 'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('dodavatelia_ic_dph'))))
        ->setAttrib('class', 'form-control');

        $adresa = new Zend_Form_Element_Text('adresa');
        $adresa->setLabel('Adresa')
            ->setRequired(false)
            ->addValidator(new Zend_Validate_StringLength(array(
                 'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('dodavatelia_adresa'))))
        ->setAttrib('class', 'form-control');

        $internyKod = new Zend_Form_Element_Text('interny_kod');
        $internyKod->setLabel('Interný kód')
            ->setRequired(false)
            ->addValidator(new Zend_Validate_StringLength(array(
                 'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('dodavatelia_interny_kod'))))
        ->setAttrib('class', 'form-control');

        $potvrdzujuceTlacidlo = new Zend_Form_Element_Submit('potvrdzujuceTlacidlo');
        $potvrdzujuceTlacidlo->setLabel($this->getAttrib('potvrdzujuceTlacidlo'));
        $potvrdzujuceTlacidlo->setAttrib('id', 'submitbutton')
        ->setAttrib('class', 'form-control btn-'.$submitButtonClass);
//            ->setAttrib('class', 'form-control btn-success btn');

        $this->addElements(array(
            $id,
            $meno,
            $nazov_spolocnosti,
            $ico,
            $icDph,
            $adresa,
            $internyKod,
            $potvrdzujuceTlacidlo
        ));

    }


}

