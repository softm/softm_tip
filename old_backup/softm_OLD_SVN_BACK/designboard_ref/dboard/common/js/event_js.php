<SCRIPT LANGUAGE="JavaScript">
<!--
var doubleTrans = false; // 두번 폼이 전송되지 않도록 처리.
function eventJoin(myForm, event_id, grant) {
    if ( alreadyJoin == 'Y' ) {
        alert ( message );
        return false;
    } else if ( login_yn == 'N' ) {
        alert ( message );
        var url = document.location.href;
        if ( url.indexOf('&lg=Y') < 0 ) {
            url += '&lg=Y';
        }
        document.location.href = url;
//          var url = getOnlyURL(document.location.href) + '?id=' + id;
    } else if ( grant != 'Y' ) {
        alert ( message );
        return false;
    } else {
        if ( confirm (message) ) {
            if ( doubleTrans ) { return false; }
            var url  = baseDir + 'common/lib/' + driver + '/event_exec.php';
            myForm.event_id.value   = event_id;
            myForm.event_exec.value = 'event_join_exec';
            myForm.action = url;
            doubleTrans = true;
            myForm.submit();
        }
    }
    return false;
}

function closeEventPopup(day) {
    var expires = new Date();
        expires.setTime(expires.getTime() + ( parseInt(day) * 24*60*60*1000 ) );
        setCookie("popup_open", "N" , expires);
    self.close();
}

function setCookie(name, value) {

   var argv = setCookie.arguments;
   var argc = setCookie.arguments.length;

   var expires = (2 < argc) ? argv[2] : null;
   var path    = (3 < argc) ? argv[3] : '/';
   var domain  = (4 < argc) ? argv[4] : null;
   var secure  = (5 < argc) ? argv[5] : false;
   document.cookie = name + "=" + escape (value) +
      ((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
      ((path    == null) ? "" : ("; path="    + path)) +
      ((domain  == null) ? "" : ("; domain=" + domain)) +
      ((secure  == true) ? "; secure" : "");
}

function getCookie(name)
{
        var prefix = name + '=';
        var cookieStartIndex = document.cookie.indexOf(prefix);
        var rtV = "";
        if (cookieStartIndex == -1) return rtV;
        var cookieEndIndex = document.cookie.indexOf(';', cookieStartIndex + prefix.length);
        if (cookieEndIndex == -1) cookieEndIndex = document.cookie.length;
        var rtV = unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex));
        rtV = "" + rtV;
//        return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex));
        if ( rtV == 'null' ) {
            rtV = '';
        }
        return rtV;
}

function delCookie (name) {
    var expireNow = new Date();
    document.cookie = name + "=" + "; expires=Thu, 01-Jan-70 00:00:01 GMT" +  "; path=/";
}
//-->
</SCRIPT>