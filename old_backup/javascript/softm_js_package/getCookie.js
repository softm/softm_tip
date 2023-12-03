<!--    
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
