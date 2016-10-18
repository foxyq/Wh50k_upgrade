function autoCunt() {

<?php
        $materialyDruhyModel = new Application_Model_DbTable_MaterialyDruhy();
    $konverznaTabulka = $materialyDruhyModel->getKonverzieAll();
    ?>

    $(".in").keyup(function () {




        var konverznaTabulka = <?php echo  json_encode($konverznaTabulka);?>
        ;
        var tonym = +$("#q_tony_merane").val().replace(",", ".");
        var tonyb = +$("#q_tony_brutto").val().replace(",", ".");
        var tonyt = +$("#q_tony_tara").val().replace(",", ".");
        var m3 = +$("#q_m3_merane").val().replace(",", ".");
        var prm = +$("#q_prm_merane").val().replace(",", ".");
        var materialDruh = +$("#material_druh_enum").val();
        var tony2m3 = konverznaTabulka[materialDruh]["ton_m3"];
        var tony2prm = konverznaTabulka[materialDruh]["ton_prm"];
        var m32tony = konverznaTabulka[materialDruh]["m3_ton"];
        var m32prm = konverznaTabulka[materialDruh]["m3_prm"];
        var prm2tony = konverznaTabulka[materialDruh]["prm_ton"];
        var prm2m3 = konverznaTabulka[materialDruh]["prm_m3"];
        var nula = "";
//
        if ($('#q_tony_brutto').is(':focus')) {
            document.getElementById('q_m3_merane').readOnly = true;
            document.getElementById('q_prm_merane').readOnly = true;
            $("#q_tony_merane").val(tonyb - tonyt);
            $("#q_prm_merane").val((tonyb - tonyt ) * tony2prm);
            $("#q_m3_merane").val((tonyb - tonyt ) * tony2m3);
        }
        if ($('#q_tony_tara').is(':focus')) {
            document.getElementById('q_m3_merane').readOnly = true;
            document.getElementById('q_prm_merane').readOnly = true;
            $("#q_tony_merane").val(tonyb - tonyt);
            $("#q_prm_merane").val((tonyb - tonyt ) * tony2prm);
            $("#q_m3_merane").val((tonyb - tonyt ) * tony2m3);
        }
        if ($('#q_tony_nadrozmer').is(':focus')) {
//                document.getElementById('q_m3_merane').readOnly = true;
//                document.getElementById('q_prm_merane').readOnly = true;
//                $("#q_tony_merane").val(tonyb - tonyt);
//                $("#q_prm_merane").val( (tonyb - tonyt ) * tony2prm);
//                $("#q_m3_merane").val( (tonyb - tonyt ) * tony2m3);
        }
        if ($('#q_m3_merane').is(':focus')) {
            document.getElementById('q_tony_merane').readOnly = true;
            document.getElementById('q_tony_brutto').readOnly = true;
            document.getElementById('q_tony_tara').readOnly = true;
//                document.getElementById('q_tony_nadrozmer').readOnly = true;
            document.getElementById('q_prm_merane').readOnly = true;
            $("#q_tony_brutto").val(nula);
            $("#q_tony_tara").val(nula);
            $("#q_tony_nadrozmer").val(nula);
            $("#q_tony_merane").val(m3 * m32tony);
            $("#q_prm_merane").val(m3 * m32prm);
        }
        if ($('#q_prm_merane').is(':focus')) {
            document.getElementById('q_tony_merane').readOnly = true;
            document.getElementById('q_tony_brutto').readOnly = true;
            document.getElementById('q_tony_tara').readOnly = true;
//                document.getElementById('q_tony_nadrozmer').readOnly = true;
            document.getElementById('q_m3_merane').readOnly = true;
            $("#q_tony_brutto").val(nula);
            $("#q_tony_tara").val(nula);
            $("#q_tony_nadrozmer").val(nula);
            $("#q_tony_merane").val(prm * prm2tony);
            $("#q_m3_merane").val(prm * prm2m3);
        }
    });

}