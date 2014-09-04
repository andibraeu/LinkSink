// LinkSink Bookmarklet Code, loaded remotely (with jQuery in place).
// Code by Max F. Albrecht <1@178.is>, placed in Public Domain.

(function () {
  
  // config
  var apiURL = "http://rss.freifunk.net/links/neu";
  // 
  
  // jQuery should have been loaded by the wrapper
  if (!$().jquery) { fail("No jQuery found! It's a bug, please report it."); }

  //SiteName  
  var mySiteName = null;
  if ( $('meta[property="og:site_name"]').length>0) {
    mySiteName = $('head').find('meta[property="og:site_name"]').prop('content');
  }

  //Title 
  if ( $('meta[property="og:title"]').length>0) {
    var myTitle = $('meta[property="og:title"]').attr('content');
  } else {
    var myTitle = document.title;
  }

  //URL
  if ( $('meta[property="og:url"]').length>0) {
    var myUrl = $('meta[property="og:url"]').attr('content');
  } else {
    var myUrl = window.location.href;
  }

  //Description
  var myDescription = null;
  if ( $('meta[property="og:description"]').length>0) {
    var myDescription = $('meta[property="og:description"]').attr('content');
  }

  if (mySiteName) {
    myTitle = mySiteName + ": " + myTitle;
  }
  
  // get some info about the current page
  var link = {
    title: myTitle || "(Unknown Title)",
    url: myUrl || null,
    description: myDescription || "",
    date: new Date($('meta[name="date"]').attr('content'))
  };
  
  // a missing URL is a hard error
  if (!link.url) { bail("No URL found on current page!"); }
  
  // check for valid date, insert current time if not
  if (isNaN(link.date.getDate())) {
    link.date = Math.round(new Date().getTime() / 1000);
  } else {
    // get UNIX date
    link.date = link.date.getTime() / 1000;
  }
  
  // debug
  // console.log(link);
  
  // build API call
  var submitURL = apiURL+
    '?url='+encodeURIComponent(link.url)+
    '&title='+encodeURIComponent(link.title)+
    '&description='+encodeURIComponent(link.description)+
    '&date='+link.date;
    
  // redirect to the submit form
  window.location = submitURL;
  
}());

function fail(err) {
  console.error(err);
  throw new Error(err);
}


