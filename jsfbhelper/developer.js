function showErrorPop(msg) {
    $('#errorpop_content').html('<p>' + msg + '</p>');
    //$('#errorclose').css("display","block");
    $("#errorclose").addClass("errorclose");
    $('#fade').css("display", "block");
    $('#errorpop').css("display", "block");
}
function hideErrorPop() {
    $('#errorpop').css("display", "none");
    $('#errorclose').css("display", "none");
    $('#errorpop').css("display", "none");
    $('#fade').css("display", "none");
}
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57))
        if (charCode != 46)
            return false;
    return true;
}