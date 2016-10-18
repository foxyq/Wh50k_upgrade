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
class Zend_Validate_OrderDuplicity extends Zend_Validate_Abstract
{
    //tu musis definovat konstantu
    const ORDER_DUPLICITY = 'orderDuplicity';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::ORDER_DUPLICITY => "Transakcia pre tohto zákazníka na toto obdobie už existuje!"
    );


    public function isValid($value)
    {
        //nastav $array ako vsetky parametre z formularu
        $array = func_get_arg(1);

        //vytiahni si samotne hodnoty
        $rok_enum = $array['rok_enum'];
        $mesiac_enum = $array['mesiac_enum'];
        $zakaznik_enum = $array['zakaznik_enum'];
        $objednavka_id = $array['objednavky_id'];

        $objednavkyModel = new Application_Model_DbTable_Objednavky();
        $existujeDuplicita = $objednavkyModel->existujeObjednavka($rok_enum, $mesiac_enum, $zakaznik_enum);
        $existujeObjednavkaSId = $objednavkyModel->existujeObjednavkaSId($objednavka_id);
        $checkObjednavkaById = $objednavkyModel->checkObjednavkaById($objednavka_id, $zakaznik_enum, $rok_enum, $mesiac_enum);

        //porovnanie ak stav transakcie je na hodnote "SCHVALENE"
        if ($existujeDuplicita){
            //ak uz existuje hodnota v db tak error
            if ($checkObjednavkaById){
                return true;
            }
            $this->_error(self::ORDER_DUPLICITY);
            return false;
        }else{
            //ak neexistuje tak OK
            return true;
        }
    }
}
