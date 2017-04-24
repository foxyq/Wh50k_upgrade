$(document).ready(function() {

    window.setInterval(function(){

        var vlhkosti = document.getElementsByClassName("vlhkost");
        var nakupne = document.getElementsByClassName("nakupna");
        var predajne = document.getElementsByClassName("predajna");
        var pocet_zobrazenych = 0;
        var suma_vlhkosti = 0;
        var tmp = '';

        var tonaze = document.getElementsByClassName("tonaz");
        var suma_tonaz = 0;


        // SUM TONAZE

        for( i=0; i<tonaze.length; i++) {
            //suma_tonaz +=  Number(tonaze[i].innerHTML.toString().replace(/[,]/, "."));

            var helper = Number(tonaze[i].innerHTML.toString().replace(/[,]/, "."));

            if (isNaN(helper) == false )
            suma_tonaz +=  helper;
                }

        $('#tonaz').html('Suma ton = ' + suma_tonaz.toFixed(2) );


        // VAZENE VLHKOSTI

        var totalsuma = 0;

        for(var i=0; i<vlhkosti.length; i++) {

            // ********* bejzik priemer

            //tmp = vlhkosti[i].innerHTML.toString().replace(/[,]/, ".");

            //var res = tmp.replace("%", "");
            //res =  res.replace("-","0");

            //suma_vlhkosti +=  Number(res);
            //pocet_zobrazenych++;

            // **************** new vazeny priemer

            tmp = vlhkosti[i].innerHTML.toString().replace(/[,]/, ".");
            tmpton = tonaze[i].innerHTML.toString().replace(/[,]/, ".");

            var res = tmp.replace("%", "");
            res =  res.replace("-","0");

            if (isNaN(Number(res)) == false && isNaN(Number(tmpton)) == false )

            totalsuma += Number (res) * Number (tmpton);

            //pocet_zobrazenych++;

        }

        //var result = suma_vlhkosti / pocet_zobrazenych;

        var result = totalsuma / suma_tonaz;

        if (isNaN(result) == false ) {
            // $('#priemer').html('.. total' + totalsuma + 'tonaz ' +suma_tonaz + ' .. Priemer vlhkostí = ' + result.toFixed(2) + '%'); //.....  suma ' + suma_vlhkosti +',  pocet ' + pocet_zobrazenych);
            $('#priemer').html('Vážený priemer vlhkostí = ' + result.toFixed(2) + '%'); //.....  suma ' + suma_vlhkosti +',  pocet ' + pocet_zobrazenych);

        }

        // VAZENE NAKUPNE CENY

        totalsuma = 0;

        for(var i=0; i<nakupne.length; i++) {

            tmp = nakupne[i].innerHTML.toString().replace(/[,]/, ".");
            tmpton = tonaze[i].innerHTML.toString().replace(/[,]/, ".");

            var res = tmp.replace("€", "");
            res =  res.replace("-","0");

            if (isNaN(Number(res)) == false && isNaN(Number(tmpton)) == false )

                totalsuma += Number (res) * Number (tmpton);
        }

        var result = totalsuma / suma_tonaz;

        if (isNaN(result) == false ) {
            $('#nakupne').html('Vážený priemer nákupných cien = ' + result.toFixed(2) + '€'); //.....  suma ' + suma_vlhkosti +',  pocet ' + pocet_zobrazenych);
        }



        /* VAZENE PREDAJNE CENY */
        totalsuma = 0;

        for(var i=0; i<predajne.length; i++) {

            tmp = predajne[i].innerHTML.toString().replace(/[,]/, ".");
            tmpton = tonaze[i].innerHTML.toString().replace(/[,]/, ".");

            var res = tmp.replace("€", "");
            res =  res.replace("-","0");

            if (isNaN(Number(res)) == false && isNaN(Number(tmpton)) == false )

                totalsuma += Number (res) * Number (tmpton);
        }

        var result = totalsuma / suma_tonaz;

        if (isNaN(result) == false ) {
            $('#predajne').html('Vážený priemer predajných cien = ' + result.toFixed(2) + '€'); //.....  suma ' + suma_vlhkosti +',  pocet ' + pocet_zobrazenych);

        }


        // SUMA m3

        var m3 = document.getElementsByClassName("m3");
        var suma_m3= 0;

        for( i=0; i<m3.length; i++) {

            var helper = Number(m3[i].innerHTML.toString().replace(/[,]/, "."));

            if (isNaN(helper) == false ) suma_m3 +=  helper;
        }

        // SUMA PRM

        $('#m3').html('Suma m<sup>3</sup>= ' + suma_m3.toFixed(2) );

        var prm = document.getElementsByClassName("prm");
        var suma_prm= 0;

        for( i=0; i<prm.length; i++) {

            var helper = Number(prm[i].innerHTML.toString().replace(/[,]/, "."));

            if (isNaN(helper) == false ) suma_prm +=  helper;


        }

        $('#prm').html('Suma prm = ' + suma_prm.toFixed(2) );

    }, 500);

});