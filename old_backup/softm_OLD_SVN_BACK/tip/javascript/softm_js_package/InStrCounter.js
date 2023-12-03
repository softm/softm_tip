
    // val을 넘겨 받아 문자열에 포함된 val의 갯수를 구합니다.
    function InStrCounter ( str, val ) {
        var len = str.length;
//        alert ( len );
        var cnt = 0;
        for(var i=0;i<len; i++ ) {
            if ( str.indexOf(val,i) >= 0) {
                i = str.indexOf(val,i);
                cnt++;
            }
        }
        return cnt;
    }