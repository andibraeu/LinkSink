// Wrapper from <http://benalman.com/projects/run-jquery-code-bookmarklet/>
// See License <http://benalman.com/about/license/>
// Modified and beautified by Max F. Albrecht <1@178.is>, in Public Domain.

// Minified version created with <https://atom.io/packages/bookmarklet>

(function(e, a, g, h, f, c, b, d) {
    if (!(f = e.jQuery) || g > f.fn.jquery || h(f)) {
        c = a.createElement("script");
        c.type = "text/javascript";
        c.src = "//ajax.googleapis.com/ajax/libs/jquery/" + g + "/jquery.min.js";
        c.onload = c.onreadystatechange = function() {
            if (!b && (!(d = this.readyState) || d == "loaded" || d == "complete")) {
                h((f = e.jQuery).noConflict(1), b = 1);
                f(c).remove();
            }
        };
        a.getElementsByTagName('head')[0].appendChild(c);
    }
})(window, document, "1.11.1", function(jQuery, L) {
  
  // config:
  var scriptURL = "//rss.freifunk.net/js/bookmarklet/bookmarklet.js";

  // jQuery has loaded, now load and execute the actual script
    jQuery.getScript(scriptURL, function (script, textStatus, jqXHR) {
    if (jqXHR.status !== 200) {
      console.error("Loading of Bookmarklet Script failed!", textStatus);
    }
  });

});
