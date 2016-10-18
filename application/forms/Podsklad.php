<?php

class Application_Form_Podsklad extends Zend_Form
{

    public function init()
    {
        $this->setName('podsklad');

        $id = new Zend_Form_Element_Hidden('podsklady_id');
        $id->addFilter('Int');

        $actionName = strtolower(Zend_Controller_Front::getInstance()->getRequest()->getActionName());
        $submitButtonClass = "success";
        if ($actionName == 'edit'){
            $submitButtonClass = "primary";
        }

        $nazov = new Zend_Form_Element_Text('nazov_podskladu');
        $nazov->setLabel('Názov')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator(new Zend_Validate_StringLength(array(
                     'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('podsklady_nazov'))))
        ->setAttrib('class', 'form-control');


        $kod = new Zend_Form_Element_Text('kod_podskladu');
        $kod->setLabel('Kód')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator(new Zend_Validate_StringLength(array(
                     'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('podsklady_kod'))))
        ->setAttrib('class', 'form-control');

        $sklad = new Zend_Form_Element_Select('sklad_enum');
        $sklad->setMultiOptions($this->getAttrib('skladyMoznosti'));
        $sklad->setLabel('Patrí skladu')
            ->setAttrib('class', 'form-control');


        $mesto = new Zend_Form_Element_Select('mesto_enum');
        $mesto->setMultiOptions($this->getAttrib('mestaMoznosti'));
        $mesto->setLabel('Mesto')
            ->setAttrib('class', 'form-control');

        $adresa = new Zend_Form_Element_Text('adresa');
        $adresa->setLabel('Adresa')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator(new Zend_Validate_StringLength(array(
                     'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('podsklady_adresa'))))
        ->setAttrib('class', 'form-control');


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
        ->setAttrib('class', 'form-control btn-'.$submitButtonClass);

        $this->addElements(array($id, $nazov, $kod, $sklad, $mesto, $adresa, $submit));
    }


}

