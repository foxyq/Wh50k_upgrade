<?php

class ProfilController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body

    }

    public function ajaxAction() {

        //get post request (standart approach)
        $request = $this->getRequest()->getPost();

        //referring to the index
        //gets value from ajax request
        $message = $request['message'];

        // makes disable renderer
        $this->_helper->viewRenderer->setNoRender();

        //makes disable layout
        $this->_helper->getHelper('layout')->disableLayout();


        //return callback message to the function javascript
        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host'     => 'localhost',
            'username' => 'root',
            'password' => 'mysql',
            'dbname'   => 'database',
            'charset'  => 'utf8'
        ));
        $limit = $message;
        $stmt = $db->query(
            'SELECT
            ts_prijmy_id AS id,
            datum_prijmu_d AS datum,
            nazov_skladu AS sklad,
            nazov_podskladu AS podsklad,
            nazov_spolocnosti AS dodavatel,
            prepravci.meno AS prepravca,
            prepravca_spz AS spz,
            q_tony_merane AS tony,
            q_m3_merane AS m3,
            q_prm_merane AS prm,
            doklad_cislo AS listok,
            materialy_typy.nazov AS typ,
            materialy_druhy.nazov AS druh,
            poznamka,
            chyba,
            stav_transakcie AS stav
            FROM
            ts_prijmy
            LEFT JOIN sklady ON ts_prijmy.sklad_enum=sklady.sklady_id
            LEFT JOIN podsklady ON ts_prijmy.podsklad_enum=podsklady.podsklady_id
            LEFT JOIN dodavatelia ON ts_prijmy.dodavatel_enum=dodavatelia.dodavatelia_id
            LEFT JOIN prepravci ON ts_prijmy.prepravca_enum=prepravci.prepravci_id
            LEFT JOIN materialy_typy ON ts_prijmy.material_typ_enum=materialy_typy.materialy_typy_id
            LEFT JOIN materialy_druhy ON ts_prijmy.material_druh_enum=materialy_druhy.materialy_druhy_id
            LIMIT '.$limit
        );

        $vystup = (array) $stmt->fetchAll();
        $data = array('data' => $vystup);
        //print_r($vystup);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);

        //print_r($vystup);
        /*
        echo "
        <table style=\"width:100%\">
        ";
        echo
            "<tr>".
            "<th>"."id"."</th>".
            "<th>"."datum"."</th>".
            "<th>"."sklad"."</th>".
            "<th>"."podsklad"."</th>".
            "<th>"."dodavatel"."</th>".
            "<th>".'prepravca'."</th>".
            "<th>".'spz'."</th>".
            "<th>".'tony'."</th>".
            "<th>".'m3'."</th>".
            "<th>".'prm'."</th>".
            "<th>".'listok'."</th>".
            "<th>".'typ'."</th>".
            "<th>".'druh'."</th>".
            "<th>".'poznamka'."</th>".
            "<th>".'chyba'."</th>".
            "<th>".'stav'."</th>".
            "</tr>";

        while ($row = $stmt->fetch()) {
            echo
                "<tr>".
                "<td>".$row['id']."</td>".
                "<td>".$row['datum']."</td>".
                "<td>".$row['sklad']."</td>".
                "<td>".$row['podsklad']."</td>".
                "<td>".$row['dodavatel']."</td>".
                "<td>".$row['prepravca']."</td>".
                "<td>".$row['spz']."</td>".
                "<td>".$row['tony']."</td>".
                "<td>".$row['m3']."</td>".
                "<td>".$row['prm']."</td>".
                "<td>".$row['listok']."</td>".
                "<td>".$row['typ']."</td>".
                "<td>".$row['druh']."</td>".
                "<td>".$row['poznamka']."</td>".
                "<td>".$row['chyba']."</td>".
                "<td>".$row['stav']."</td>".
                "</tr>";

        }

        echo "
        </table>
        ";*/

        //return $message." + upgrade";
        //print_r($stmt) ;
        //echo 'negga negga tnegga!';
        //print_r($jsonData);
    }

}

