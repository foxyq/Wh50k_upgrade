<?php

/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/Abstract.php';

/**
 * @see Zend_Locale_Format
 */
require_once 'Zend/Locale/Format.php';

/**
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com) + PKY team
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * Tento validator bol vytvoreny PKY teamom a postavený naj jadre Int validatora
 */
class Zend_Validate_MotohodinaDuplicity extends Zend_Validate_Abstract
{
    //tu musis definovat konstantu
    const MOTOHODINA_DUPLICITY = 'MotohodinaDuplicity';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::MOTOHODINA_DUPLICITY => "Motohodina pre tento stroj na toto obdobie už existuje!"
    );


    public function isValid($value)
    {
        //nastav $array ako vsetky parametre z formularu
        $array = func_get_arg(1);

        //vytiahni si samotne hodnoty
        $rok_enum = $array['rok_enum'];
        $mesiac_enum = $array['mesiac_enum'];
        $stroj_enum = $array['stroj_enum'];
        $motohodina_id = $array['motohodiny_id'];

        $motohodinyModel = new Application_Model_DbTable_Motohodiny();
        $existujeDuplicita = $motohodinyModel->existujeMotohodina($rok_enum, $mesiac_enum, $stroj_enum);
        $existujeMotohodinaSId = $motohodinyModel->existujeMotohodinaSId($motohodina_id);
        $checkMotohodinaById = $motohodinyModel->checkMotohodinaById($motohodina_id, $stroj_enum, $rok_enum, $mesiac_enum);

        //porovnanie ak stav transakcie je na hodnote "SCHVALENE"
        if ($existujeDuplicita){
            //ak uz existuje hodnota v db tak error
            if ($checkMotohodinaById){
                return true;
            }
            $this->_error(self::MOTOHODINA_DUPLICITY);
            return false;
        }else{
            //ak neexistuje tak OK
            return true;
        }
    }
}
