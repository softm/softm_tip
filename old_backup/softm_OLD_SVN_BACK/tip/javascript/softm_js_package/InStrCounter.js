
    // val�� �Ѱ� �޾� ���ڿ��� ���Ե� val�� ������ ���մϴ�.
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