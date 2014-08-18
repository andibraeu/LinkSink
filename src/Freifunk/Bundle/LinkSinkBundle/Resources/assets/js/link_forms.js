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
        title: {
            identifier: 'title',
            rules: [
                {
                    type: 'empty',
                    prompt: 'Bitte gib einen Titel an'
                }
            ]
        },
        pubdate: {
            identifier: 'pubdate',
            rules: [
                {
                    type: 'empty',
                    prompt: 'Bitte gib ein Veröffentlichungsdatum an'
                }
            ]
        },
        category: {
            identifier: 'category',
            rules: [
                {
                    type: 'empty',
                    prompt: 'Bitte gib eine Kategorie an'
                }
            ]
        }
    },
    {
        inline: true,
        on     : 'blur'
    });
$('.ui.input.popup')
.popup();