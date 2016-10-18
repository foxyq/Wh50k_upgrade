<?php

class Application_Form_MaterialTyp extends Zend_Form
{

    public function init()
    {
        $this->setName('materialTyp');

        $id = new Zend_Form_Element_Hidden('materialy_typy_id');
        $id->addFilter('Int');

        $actionName = strtolower(Zend_Controller_Front::getInstance()->getRequest()->getActionName());
         $submitButtonClass = "success";
         if ($actionName == 'edit'){
             $submitButtonClass = "primary";
         }

        $nazov = new Zend_Form_Element_Text('nazov');
        $nazov->setLabel('Názov')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator(new Zend_Validate_StringLength(array(
                     'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('materialy_typy_nazov'))))
        ->setAttrib('class', 'form-control');

        $skratka = new Zend_Form_Element_Text('skratka');
        $skratka->setLabel('Skratka')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator(new Zend_Validate_StringLength(array(
                     'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('materialy_typy_skratka'))))
        ->setAttrib('class', 'form-control');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
        ->setAttrib('class', 'form-control btn-'.$submitButtonClass);

        $this->addElements(array($id, $nazov, $skratka, $submit));
    }


}

