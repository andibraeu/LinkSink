$(document).ready(function(){
    $('.ui.dropdown.selection')
        .dropdown()
        .dropdown('set value',$('.ui.dropdown.selection input[type=hidden]').val())
    ;
});
