<?php

class Application_Form_Prepravca extends Zend_Form
{

    public function init()
    {


        $this->setName('prepravca');

        $id = new Zend_Form_Element_Hidden('prepravci_id');
        $id->addFilter('Int');

        $actionName = strtolower(Zend_Controller_Front::getInstance()->getRequest()->getActionName());
        $submitButtonClass = "success";
        if ($actionName == 'edit'){
            $submitButtonClass = "primary";
        }

        $kod = new Zend_Form_Element_Text('kod');
        $kod->setLabel('Kod')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator(new Zend_Validate_StringLength(array(
                     'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('prepravcovia_kod'))))
        ->setAttrib('class', 'form-control');

        $meno = new Zend_Form_Element_Text('meno');
        $meno->setLabel('Meno')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator(new Zend_Validate_StringLength(array(
                     'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('prepravcovia_meno'))))
        ->setAttrib('class', 'form-control');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
        ->setAttrib('class', 'form-control btn-'.$submitButtonClass);

        $this->addElements(array($id, $kod, $meno, $submit));
    }



}

