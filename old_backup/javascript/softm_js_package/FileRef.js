<!--
//** Function Name  : getFileName
//** Argument1      : ���� ��θ�
//** Description    : ���� ��θ��� ���� �̸��� ��ȯ
    function getFileName(val)
    {
        var rtnStr = val;
        var s1 = 0, s2 = 0;
        var s  = 0;
        s1 = rtnStr.lastIndexOf("\\") + 1 ;
        s2 = rtnStr.lastIndexOf("/")  + 1 ;
        if ( s1 > 0 ) { s = s1; }
        if ( s2 > 0 ) { s = s2; }
        if ( s > 0 ) {
            rtnStr = rtnStr.substring( s );
        } else {
            rtnStr = "";
        }
        return rtnStr;
    }

//** Function Name  : getFileExtraName
//** Argument1      : ���� ��θ�
//** Description    : ���� ��θ��� Ȯ��� ���� ��ȯ
    function getFileExtraName(val)
    {
        var rtnStr = val;
        var s1 = 0, s2 = 0;
        var s  = 0;
        s1 = rtnStr.lastIndexOf("\\") + 1 ;
        s2 = rtnStr.lastIndexOf("/")  + 1 ;
        if ( s1 > 0 ) { s = s1; }
        if ( s2 > 0 ) { s = s2; }
        if ( s > 0 ) {
            var e  = 0;
            e = rtnStr.lastIndexOf(".");
            if ( e > 0 ) {
                rtnStr = rtnStr.substring( e + 1 );
            } else {
                rtnStr = "";
            }
        } else {
            rtnStr = "";
        }
        return rtnStr;
    }
//** Function Name  : getFileNameOnly
//** Argument1      : ���� ��θ�
//** Description    : ���� ��θ��� ���� �̸����� ��ȯ
    function getFileNameOnly(val)
    {
        var rtnStr = val;
        var s1 = 0, s2 = 0;
        var s  = 0;
        s1 = rtnStr.lastIndexOf("\\") + 1 ;
        s2 = rtnStr.lastIndexOf("/")  + 1 ;
        if ( s1 > 0 ) { s = s1; }
        if ( s2 > 0 ) { s = s2; }
        if ( s > 0 ) {
            var e  = 0;
            e = rtnStr.lastIndexOf(".");
            if ( e > 0 ) {
                rtnStr = rtnStr.substring( s, e );
            } else {
                rtnStr = rtnStr.substring( s );
            }
        } else {
            rtnStr = "";
        }
        return rtnStr;
    }
//-->


