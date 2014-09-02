// LinkSink Bookmarklet Code, loaded remotely (with jQuery in place).
// Code by Max F. Albrecht <1@178.is>, placed in Public Domain.

(function () {
  
  // config
  var apiURL = "http://rss.freifunk.net/links/neu";
  // 
  
  // jQuery should have been loaded by the wrapper
  if (!$().jquery) { fail("No jQuery found! It's a bug, please report it."); }
  
  // get some info about the current page
  var link = {
    title: document.title || "(Unknown Title)",
    url: window.location.href || null,
    date: new Date($('head').find('meta[name="date"]').prop('content'))
  };
  
  // a missing URL is a hard error
  if (!link.url) { bail("No URL found on current page!"); }
  
  // check for valid date, insert current time if not
  if (isNaN(link.date.getDate())) {
    link.date = Math.round(new Date().getTime() / 1000);
  }
  // get UNIX date
  link.date = link.date.getTime();
  
  // debug
  // console.log(link);
  
  // build API call
  var submitURL = apiURL+
    '/'+encodeURIComponent(link.url)+
    '/'+encodeURIComponent(link.title)+
    '/'+link.date;
    
  // redirect to the submit form
  window.location = submitURL;
  
}());

function fail(err) {
  console.error(err);
  throw new Error(err);
}


