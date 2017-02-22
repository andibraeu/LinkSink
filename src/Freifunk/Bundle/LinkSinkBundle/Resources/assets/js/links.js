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
    var box_width = Math.floor((screen_width / columns));
    if (box_width >= 395) {
        card_selector.css('width',box_width - 10);
    } else if ( columns == 1 ) {
        card_selector.css('width',box_width);
    }
    else {
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

    if (jQuery('#link_pubdate').length > 0) {
        jQuery('#link_pubdate').datepicker({dateFormat: 'yy-mm-dd'}).keydown(function (e) {
            //   TAB: 9
            //  LEFT: 37
            //    UP: 38
            // RIGHT: 39
            //  DOWN: 40
            //             IE        OTHER
            var code = e.keyCode || e.which;
            // If key is not TAB
            if (code == '37' || code == '38' || code == '39' || code == '40') {
                e.preventDefault();
                var currentDate = jQuery('#link_pubdate').datepicker("getDate");
                if (currentDate == null) {
                    currentDate = new Date();
                }
                // Show next/previous day/week
                switch (code) {
                    // LEFT, -1 day
                    case 37:
                        currentDate.setDate(currentDate.getDate() - 1);
                        break;
                    // UP, -1 week
                    case 38:
                        currentDate.setDate(currentDate.getDate() - 7);
                        break;
                    // RIGHT, +1 day
                    case 39:
                        currentDate.setDate(currentDate.getDate() + 1);
                        break;
                    // DOWN, +1 week
                    case 40:
                        currentDate.setDate(currentDate.getDate() + 7);
                        break;
                }
                // If result is ok then write it
                if (currentDate != null) {
                    jQuery('#link_pubdate').datepicker("setDate", currentDate);
                }
            }
        });
    }

    if(jQuery('#link_tags').length > 0) {
        $('#link_tags').selectize({
            create: true,
            diacritics: true,
            valueField: 'name',
            labelField: 'name',
            searchField: 'name',
            render: {
                item: function (data, escape) {
                    console.log([data, escape]);
                    return '<div class="ui primary compact small label"><i class="tag icon"></i>' + escape(data.name) + '</div>';
                }
            },
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: "/tags/query/",
                    type: "GET",
                    dataType: 'json',
                    data: {
                        q: query
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        console.log(res);
                        callback(res);
                    }
                });
            }
        });
    }

});


