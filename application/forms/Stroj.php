<?php

class Application_Form_Stroj extends Zend_Form
{

    public function init()
    {
        $this->setName('stroj');

        $id = new Zend_Form_Element_Hidden('stroje_id');
        $id->addFilter('Int');

        $actionName = strtolower(Zend_Controller_Front::getInstance()->getRequest()->getActionName());
        $submitButtonClass = "success";
        if ($actionName == 'edit'){
            $submitButtonClass = "primary";
        }

        $nazov = new Zend_Form_Element_Text('nazov_stroja');
        $nazov->setLabel('Názov')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator(new Zend_Validate_StringLength(array(
                     'max' => Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('stroje_nazov'))))
        ->setAttrib('class', 'form-control');


        $typ_stroja = new Zend_Form_Element_Select('typ_stroja');
        $typ_stroja->setMultiOptions($this->getAttrib('strojeTypyMoznosti'));
        $typ_stroja->setLabel('Typ')
            ->setAttrib('class', 'form-control');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
        ->setAttrib('class', 'form-control btn-'.$submitButtonClass);

        $this->addElements(array($id, $nazov, $typ_stroja, $submit));
    }


}

