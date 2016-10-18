<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';


    public function getUserType($email)
    {
        //$email = (int)$email;
        $userType = $this->fetchRow("email = '" . $email ."'")->users_types_enum;
        return $userType;

    }

    public function getMeno($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('id = ' . $id)->name;
        return $nazov;

    }


}

