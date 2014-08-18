$(document).ready(function(){
    $('.ui.dropdown.selection')
        .dropdown()
        .dropdown('set value',$('.ui.dropdown.selection input[type=hidden]').val())
    ;
});
$('.ui.form')
    .form({
        url: {
            identifier  : 'url',
            rules: [
                {
                    type   : 'url',
                    prompt : 'Bitte gib einen validen Link an (URL)'
                }
            ]
        },
        enclosureurl: {
            identifier: 'enclosureurl',
            rules: [
               {
                    type : 'url',
                    prompt: 'Bitte gib einen validen Medienlink an'
                }
            ]
        }
    },
    {
        on: 'change',
        revalidate: true
    });
$('.ui.input')
.popup();