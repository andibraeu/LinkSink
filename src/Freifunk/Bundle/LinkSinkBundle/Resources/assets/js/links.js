/**
 * Created by tim on 06.07.14.
 */

// initializing with settings

function addGeoCoordinates(ev) {
    return false;
}
var map = null;
jQuery(document).ready(function () {
    if (jQuery('.icon.link').length > 0) {
        jQuery('.icon.link').popup();
    }

    if (jQuery('input[type=datetime]').length > 0) {
        jQuery('input[type=datetime]').datetimepicker({lang: 'de', format: 'Y-m-d',timepicker:false, scrollMonth:false});
    }

});
