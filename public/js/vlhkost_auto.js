$(document).ready(function() {
    window.setInterval(function(){

    var nadrozmer = +$("#help").val();
    var tony = +$("#q_tony_merane").val();

        var result = Number(nadrozmer * 0.01 * tony);
        $('#q_tony_nadrozmer').val(result);

    }, 1000);
})