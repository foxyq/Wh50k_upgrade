<?php

class Application_Model_DbTable_MaterialyDruhy extends Zend_Db_Table_Abstract
{

    protected $_name = 'materialy_druhy';

    //vracanie názvov pre výpisy
    public function getNazov($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('materialy_druhy_id = '.$id)->nazov;
        return $nazov;

    }

    public function getSkratka($id)
    {
        $id = (int)$id;
        $nazov = $this->fetchRow('materialy_druhy_id = '.$id)->skratka;
        return $nazov;

    }

    public function getDruh($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('materialy_druhy_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }


    //metoda vracia pole pre vypisy a formulare - id a nazov skladu
    public function getMoznosti()
    {
        $pole = $this->fetchAll()->toArray();
        $moznosti = array();

        foreach ($pole as $hodnota){
            $moznosti[$hodnota['materialy_druhy_id']] = $hodnota['nazov'];
        }

        return $moznosti;
    }
    //vrati pole s koeficientami pre konverzie podla druhu materialu
    public function getKonverzie($druhId){
        $konverzie = array();
        $sql = "materialy_druhy_id = ".$druhId;
        $row = $this->fetchRow($sql);

        $konverzie['m3_ton'] = $row['m3_ton'];
        $konverzie['m3_prm'] = $row['m3_prm'];
        $konverzie['ton_m3'] = $row['ton_m3'];
        $konverzie['ton_prm'] = $row['ton_prm'];
        $konverzie['prm_ton'] = $row['prm_ton'];
        $konverzie['prm_m3'] = $row['prm_m3'];

        return $konverzie;

    }

    public function getKonverzieAll(){
        $konverzie = array();
        $rows = $this->fetchAll();

        foreach ($rows AS $row){
            $konverzie[$row['materialy_druhy_id']]['id'] = $row['materialy_druhy_id'];
            $konverzie[$row['materialy_druhy_id']]['m3_ton'] = $row['m3_ton'];
            $konverzie[$row['materialy_druhy_id']]['m3_prm'] = $row['m3_prm'];
            $konverzie[$row['materialy_druhy_id']]['ton_m3'] = $row['ton_m3'];
            $konverzie[$row['materialy_druhy_id']]['ton_prm'] = $row['ton_prm'];
            $konverzie[$row['materialy_druhy_id']]['prm_ton'] = $row['prm_ton'];
            $konverzie[$row['materialy_druhy_id']]['prm_m3'] = $row['prm_m3'];
        }

        return $konverzie;
    }

    public function getKonverzieDefault(){
        $konverzie = array();
        //$sql = "materialy_druhy_id = ".$druhId;
        //$row = $this->fetchRow($sql);

        $konverzie['m3_ton'] = 0.55;
        $konverzie['m3_prm'] = 1.7;
        $konverzie['ton_m3'] = 1.818182;
        $konverzie['ton_prm'] = 3.090909;
        $konverzie['prm_ton'] = 0.323529;
        $konverzie['prm_m3'] = 0.588235;



        return $konverzie;

    }

    public function getKonverzia($typKonverzie, $materialDruh){
        if (is_int($materialDruh)) {
            die($materialDruh);
        }else{
            die('Cislo je'.$materialDruh);
        }

        /*
        if (isset($materialDruh)){
            $materialDruh = (int) $materialDruh;
        }else{
            $materialDruh = 1;
        }

        $sql = "materialy_druhy_id = ".$materialDruh;
        $konverzia = $this->fetchRow($sql)->toArray();

        return $konverzia[$typKonverzie];*/
    }

    public function addDruh($nazov, $skratka)
    {
        $data = array(
            'nazov' => $nazov,
            'skratka' => $skratka,
        );
        $this->insert($data);
    }

    public function updateDruh($id, $nazov, $skratka)
    {
        $data = array(
            'nazov' => $nazov,
            'skratka' => $skratka,
        );
        $this->update($data, 'materialy_druhy_id = '. (int)$id);
    }


}

