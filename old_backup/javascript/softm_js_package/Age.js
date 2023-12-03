    <!--
        function Age ( Byyyymmdd, Syyyymmdd ) {

        var birthyear   = parseInt( Byyyymmdd.substring(0,4), 10 );
        var birthmonth  = parseInt( Byyyymmdd.substring(4,6), 10 );
        var birthday    = parseInt( Byyyymmdd.substring(6,8), 10 );

        var systemyear  = parseInt( Syyyymmdd.substring(0,4), 10 );
        var systemmonth = parseInt( Syyyymmdd.substring(4,6), 10 );
        var systemday   = parseInt( Syyyymmdd.substring(6,8), 10 );

        var age =0;

        age = ( systemyear - birthyear ) - 1;
        if ( birthmonth < systemmonth  ) { // 태어난 달이 지나갔을 경우에는 한살 더 먹었쥐..
        //     10           9
            age += 1;
        } else if ( birthmonth = systemmonth ) { //  태어난 달이랑 시스템 달이랑 같으면 날짜를 비교해보는거쥐.
            if ( birthday <= systemday ) {
                age += 1;
            }
        }
        return age;
    }
    //-->