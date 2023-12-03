    <!--
    //**************** �Ⱓ�� �󸶳� �ǳ� ??? **************//
    //** Function Name    : DayCount          **************//
    //** Argument1        : Fryyyymmdd ( ���� ���� )  ******//
    //** Argument2        : Toyyyymmdd ( ���� ���� )  ******//
    //** Argument2        : Frddhh24ss ( ���� �ð�����) ****//
    //** Argument2        : Toddhh24ss ( ���� �ð����� ) ***//
    //******************************************************//
    function DayCount ( Fryyyymmdd, Toyyyymmdd, Frddhh24ss, Toddhh24ss ) {
        var t_Frddhh24ss = ( Frddhh24ss == null || Frddhh24ss == "" || isNaN ( Frddhh24ss ) ) ? "000000" : Frddhh24ss;
        var t_Toddhh24ss = ( Toddhh24ss == null || Toddhh24ss == "" || isNaN ( Toddhh24ss ) ) ? "000000" : Toddhh24ss;
//		alert ( t_Frddhh24ss.substring(0, 2) );
        var FrDt = new Date( Fryyyymmdd.substring(0, 4),
                             Fryyyymmdd.substring(4, 6) - 1,
                             Fryyyymmdd.substring(6, 8),
                             t_Frddhh24ss.substring(0, 2),
                             t_Frddhh24ss.substring(2, 4),
                             t_Frddhh24ss.substring(4, 6));
        var ToDt = new Date( Toyyyymmdd.substring(0, 4),
                             Toyyyymmdd.substring(4, 6) - 1,
                             Toyyyymmdd.substring(6, 8),
                             t_Toddhh24ss.substring(0, 2),
                             t_Toddhh24ss.substring(2, 4),
                             t_Toddhh24ss.substring(4, 6));
    //    alert (  "FrDt : " + FrDt.getTime() ) ;
    //    alert (  "ToDt : " + ToDt.getTime() ) ;
    //    alert (  "FrDt : " + FrDt.getYear() +  "." + ( FrDt.getMonth() + 1 ) + "." + FrDt.getDate() );
    //    alert (  "ToDt : " + ToDt.getYear() +  "." + ( ToDt.getMonth() + 1 ) + "." + ToDt.getDate() );
    var tmp    = ToDt.getTime() - FrDt.getTime();
    var DayCnt = ( tmp  / 24 / 60 / 60 / 1000 );
        DayCnt = DayCnt + 1;
//alert (  "�ϼ� : " +  DayCnt );
    return DayCnt;
    }
    //-->