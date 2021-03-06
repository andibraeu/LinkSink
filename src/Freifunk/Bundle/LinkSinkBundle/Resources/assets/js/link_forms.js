$(document).ready(function(){
    $('.ui.dropdown.selection')
        .dropdown()
        //.dropdown('set value',$('.ui.dropdown.selection input[type=hidden]').val())
    ;
});
//create rule that allows empty or url values
$.fn.form.settings.rules['notemptyandurl'] = function (value) {var urlRegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/ ; if (value == '') {return true;} else {return urlRegExp.test(value);}};
$('.ui.form.category')
    .form({
        name: {
            identifier  : 'name',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Bitte gib einen Kategorienamen an'
                }
            ]
        }
    },
    {
        inline: true,
        on     : 'blur'
    });
$('.ui.form.filter')
    .form({
        inline: true,
        on     : 'blur'
    });
$('.ui.form.delete')
    .form({
        inline: true,
        on     : 'blur'
    });
$('.ui.form.link')
    .form({
        url: {
            identifier  : 'ls_url',
            rules: [
                {
                    type   : 'url',
                    prompt : 'Bitte gib einen gültigen Link an (URL)'
                }
            ]
        },
        title: {
            identifier: 'ls_title',
            rules: [
                {
                    type: 'empty',
                    prompt: 'Bitte gib einen Titel an'
                }
            ]
        },
        pubdate: {
            identifier: 'ls_pubdate',
            rules: [
                {
                    type: 'empty',
                    prompt: 'Bitte gib ein Veröffentlichungsdatum an'
                }
            ]
        },
        category: {
            identifier: 'ls_category',
            rules: [
                {
                    type: 'empty',
                    prompt: 'Bitte gib eine Kategorie an'
                }
            ]
        },
        enclosureurl: {
            identifier: 'ls_enclosureurl',
            rules: [
                {
                    type: 'notemptyandurl',
                    prompt: 'Bitte gib einen gültigen Link zu einer Mediendatei an'
                }
            ]
        }
    },
    {
        inline: true,
        on     : 'blur',
        keyboardShortcuts : false
    });
$('.ui.input.hint')
.popup();
