$(document).ready(function() {
    $('.select2js').select2();
    $('form').validator();

});
function successMessage(message){
    if(message!=''){
        Snackbar.show({text: message, pos: 'bottom-center'});
    }
}
