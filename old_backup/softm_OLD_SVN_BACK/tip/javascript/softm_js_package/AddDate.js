    <!--
    /**************** 기간이 얼마나 되나 ???
    * AddDate("20020317231415", "DATE" , 15)
    * @param datetimestamps the String 년 월 일 시 분 초 ( 20020317231415 )
    * @param field :  "YEAR"  ,"MONTH" ,"DATE"  ,"HOUR"  ,"MINUTE","SECOND"
    * @param addValue 더하거나 뺄값.
    * alert ( AddDate("20030101000000","HOUR",-24) );
    ******************************************************/
    function AddDate  ( Fryyyymmddhh24ss, field, addValue ) {
        var FrDt = new Date( Fryyyymmddhh24ss.substring(0, 4),
                             Fryyyymmddhh24ss.substring(4, 6) - 1,
                             Fryyyymmddhh24ss.substring(6, 8),
                             Fryyyymmddhh24ss.substring(8, 10),
                             Fryyyymmddhh24ss.substring(10, 12),
                             Fryyyymmddhh24ss.substring(12, 14));

//        alert (  "FrDt : " + FrDt.getTime() ) ;
//        alert (  "FrDt : " + FrDt.getYear() +  "." + ( FrDt.getMonth() + 1 ) + "." + FrDt.getDate() + "/" + FrDt.getHours() + "/" + FrDt.getMinutes () + "." + FrDt.getSeconds ());

        if      ( field == "YEAR"  ) { FrDt.setYear    (FrDt.getYear    ()      + addValue) ; }
        else if ( field == "MONTH" ) { FrDt.setMonth   (FrDt.getMonth   ()      + addValue) ; }
        else if ( field == "DATE"  ) { FrDt.setDate    (FrDt.getDate    ()      + addValue) ; }
        else if ( field == "HOUR"  ) { FrDt.setHours   (FrDt.getHours   ()      + addValue) ; }
        else if ( field == "MINUTE") { FrDt.setMinutes (FrDt.getMinutes ()      + addValue) ; }
        else if ( field == "SECOND") { FrDt.setSeconds (FrDt.getSeconds ()      + addValue) ; }

//        alert (  "End FrDt : " + FrDt.getTime() ) ;
//        alert (  "End FrDt : " + FrDt.getYear() +  "." + ( FrDt.getMonth() + 1 ) + "." + FrDt.getDate() + "/" + FrDt.getHours() + "/" + FrDt.getMinutes () + "." + FrDt.getSeconds ());

        var tmp    = "" + FrDt.getYear    ();
            tmp  += ( FrDt.getMonth   () >= 10 ) ? FrDt.getMonth   () : "0" + FrDt.getMonth   ();
            tmp  += ( FrDt.getDate    () >= 10 ) ? FrDt.getDate    () : "0" + FrDt.getDate    ();
            tmp  += ( FrDt.getHours   () >= 10 ) ? FrDt.getHours   () : "0" + FrDt.getHours   ();
            tmp  += ( FrDt.getMinutes () >= 10 ) ? FrDt.getMinutes () : "0" + FrDt.getMinutes ();
            tmp  += ( FrDt.getSeconds () >= 10 ) ? FrDt.getSeconds () : "0" + FrDt.getSeconds ();
//        alert (tmp);
        return tmp;
    }

    //-->