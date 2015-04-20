/**
 * Created by tim on 06.07.14.
 */

// initializing with settings

function addGeoCoordinates(ev) {
    return false;
}

function calcBoxSize(columns) {
    var card_selector = jQuery('.ui.cards .card');
    var screen_width = $(window).width() - 14 - 14; /* padding of basic segment */
    // first check if we can display 4 cards on the screen with a minimum width of 399px
    var box_width = Math.floor((screen_width / columns)) - 10;
    if ((box_width >= 395) || (columns == 1)) {
        card_selector.css('width',box_width);
    } else {
        calcBoxSize(columns - 1);
    }
}

$(window).resize(function(){
    var card_selector = jQuery('.ui.cards .card');

    if (card_selector.length > 0) {
        calcBoxSize(4);
    }
})

var map = null;
jQuery(document).ready(function () {
    var card_selector = jQuery('.ui.cards .card');

    if (card_selector.length > 0) {
        calcBoxSize(4);
    }

    if (jQuery('.icon.link').length > 0) {
        jQuery('.icon.link').popup();
    }

    if (jQuery('input[type=datetime]').length > 0) {
        jQuery('input[type=datetime]').datetimepicker({lang: 'de', format: 'Y-m-d',timepicker:false, scrollMonth:false});
    }

});


