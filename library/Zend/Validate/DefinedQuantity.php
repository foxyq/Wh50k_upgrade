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
class Zend_Validate_DefinedQuantity extends Zend_Validate_Abstract
{
    //tu musis definovat konstantu
    const NOT_DEFINED = 'notDef';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_DEFINED => "Transakcia nemôže byť schválená bez kvantity!"
    );


    public function isValid($value)
    {
        //nastav $array ako vsetky parametre z formularu
        $array = func_get_arg(1);

        //vytiahni si samotne hodnoty pre tony, m3 a PRM
        $tony = $array['q_tony_merane'];
        $m3 = $array['q_m3_merane'];
        $prm = $array['q_prm_merane'];
        $sucet_kvantit = $tony + $m3 + $prm;
        $stav_transakcie = $array['stav_transakcie'];

        //porovnanie ak stav transakcie je na hodnote "SCHVALENE"
        if ($stav_transakcie == 2){
            //ak stav na "SCHVALENE" tak cekni ci je aspon jedna hodnota definovana
            if($sucet_kvantit == 0){
                //ak je sucet 0 tak to znamena ze nie je definovana ziadna kvantita
                $this->_error(self::NOT_DEFINED);
                return false;
            }else{
                //ak je aspon jedna hodnota viac nez 0
                return true;
            }
        }else{
            //ak je iny stav ako "SCHVALENE" nemusime cekovat nic
            return true;
        }

        //TESTING printing
        //print_r($array."**tony: ".$tony."**m3: ".$m3."**PRM: ".$prm);
        //print_r($array);
    }
}
