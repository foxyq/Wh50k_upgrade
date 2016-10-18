<?php

class Application_Form_MiestoStiepenia extends Zend_Form
{

    public function init()
    {
        $this->setName('miestoStiepenia');

        $id = new Zend_Form_Element_Hidden('miesta_stiepenia_id');
        $id->addFilter('Int');

        $actionName = strtolower(Zend_Controller_Front::getInstance()->getRequest()->getActionName());
         $submitButtonClass = "success";
         if ($actionName == 'edit'){
             $submitButtonClass = "primary";
         }

        $nazov_miesta = new Zend_Form_Element_Text('nazov_miesta');
        $nazov_miesta->setLabel('Názov')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator(new Zend_Validate_StringLength(array(
                     'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('miesta_stiepenia_nazov'))))
        ->setAttrib('class', 'form-control');




        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
        ->setAttrib('class', 'form-control btn-'.$submitButtonClass);

        $this->addElements(array($id, $nazov_miesta, $submit));
    }


}

