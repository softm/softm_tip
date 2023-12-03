    function DP_HashTable() {
        this.k = new Array();
        this.v = new Array();
        this.DP_putValue      = DP_putValue;
        this.DP_appendValue   = DP_appendValue;
        this.DP_getValue      = DP_getValue;
        this.DP_getValues     = DP_getValues;
        this.DP_getValueALL   = DP_getValueALL;
        this.DP_getValueInclude = DP_getValueInclude;
        this.DP_getKey        = DP_getKey;
        this.DP_getKeys       = DP_getKeys;
        this.DP_getKeyALL     = DP_getKeyALL;
        this.DP_getKeyInclude = DP_getKeyInclude;
        this.DP_getKeyHowMaNy = DP_getKeyHowMany;
        this.DP_getKeyIdx     = DP_getKeyIdx;
        this.DP_getVal        = DP_getVal;
        this.DP_getSize       = DP_getSize;
        this.DP_removeKey     = DP_removeKey;
        this.DP_idxUp         = DP_idxUp;
        this.DP_idxDown       = DP_idxDown;
    }

    function DP_removeKey(key) {
        this.k.splice(key, 1);
        this.v.splice(key, 1);
    }

    function DP_idxUp(idx) {
        var _rtn = 0;
        if ( idx != 0 ) { // 맨 처음 자료
            var tmpUpArray   = this.k[idx   ];
            var tmpDownArray = this.k[idx-1 ];
            this.k.splice(idx-1, 1, tmpUpArray  );
            this.k.splice(idx  , 1, tmpDownArray);
                tmpUpArray   = this.v[idx   ];
                tmpDownArray = this.v[idx-1 ];
            this.v.splice(idx-1, 1, tmpUpArray  );
            this.v.splice(idx  , 1, tmpDownArray);
            _rtn=idx-1;
        }
        return _rtn;
    }

    function DP_idxDown(idx) {
        var _rtn = 0;
        if ( idx < this.k.length - 1 ) { // 맨 마지막 자료
            var tmpDownArray = this.k[idx   ];
            var tmpUpArray   = this.k[idx +1];
            this.k.splice(idx+1, 1, tmpDownArray);
            this.k.splice(idx  , 1, tmpUpArray  );
                tmpDownArray = this.v[idx   ];
                tmpUpArray   = this.v[idx +1];
            this.v.splice(idx+1, 1, tmpDownArray);
            this.v.splice(idx  , 1, tmpUpArray  );
            _rtn=idx+1;
        }
        return _rtn;
    }

    function DP_putValue(key, dpObj) {
        /* 배열에 추가및 수정할 위치 */
        var s = this.k.length;
        
        for ( var i=0;i<s;i++ ){
            if ( key == this.k[i] ) { s = i; break; }
        }
        /* key */
        this.k [s] = key    ;
        /* menu Object */
        this.v [s] = dpObj;
    }

    function DP_appendValue(key, dpObj) {
        /* 배열에 추가및 수정할 위치 */
        var s = this.k.length;
        /* key */
        this.k [s] = key    ;
        /* menu Object */
        this.v [s] = dpObj;
    }


    function DP_getValue(key) {
        var obj = null;
        if ( typeof(key) == 'number' ) {
            obj = this.v[key];
        } else {
            /* 배열에 추가및 수정할 위치 */
            var s = this.k.length;
            for ( var i=0;i<s;i++ ){
                if ( key == this.k[i] ) {
                    /* menu Object */
                    obj = this.v[i];
                    break;
                }
            }
        }
        return obj;
    }

    function DP_getValues(key) {
        var s    = this.k.length;
        var values = new Array();
        var idx  = 0;
        for ( var i=0;i<s;i++ ){
            if ( this.k[i] == key ) {
                values[idx] = this.v[i];
                idx++;
            }
        }
        return values;
    }

    function DP_getValueALL() {
        var s    = this.k.length;
        var values = new Array();
        var idx  = 0;
        for ( var i=0;i<s;i++ ){
                values[idx] = this.v[i];
                idx++;
        }
        return values;
    }

    function DP_getValueInclude(value) {
        var s    = this.k.length;
        var values = new Array();
        var idx  = 0;
        for ( var i=0;i<s;i++ ){
            if ( this.v[i].indexOf(value) >= 0 ) {
                values[idx] = this.v[i];
                idx++;
            }
        }
        return values;
    }

    function DP_getKey(idx) {
        var key = null;
        if ( typeof(idx) == 'number' ) {
            key = this.k[idx];
        } else {
            key = "DP_HashTable Function Exception 발생";
        }
        return key;
    }

    function DP_getKeys(key) {
        var s    = this.k.length;
        var keys = new Array();
        var idx  = 0;
        for ( var i=0;i<s;i++ ){
            if ( this.k[i] == key ) {
                keys[idx] = this.k[i];
                idx++;
            }
        }
        return keys;
    }

    function DP_getKeyALL() {
        var s    = this.k.length;
        var keys = new Array();
        var idx  = 0;
        for ( var i=0;i<s;i++ ){
                keys[idx] = this.k[i];
                idx++;
        }
        return keys;
    }

    function DP_getKeyInclude(key) {
        var s    = this.k.length;
        var keys = new Array();
        var idx  = 0;
        for ( var i=0;i<s;i++ ){
            if ( this.k[i].indexOf(key) >= 0 ) {
                keys[idx] = this.k[i];
                idx++;
            }
        }
        return keys;
    }

    function DP_getKeyHowMany(key) {
        var s   = this.k.length;
        var cnt = 0;             /* 갯수 */
        for ( var i=0;i<s;i++ ){
            if ( this.k[i].indexOf(key) >= 0 ) {
                cnt++;
            }
        }
        return cnt;
    }

    function DP_getKeyIdx(key) {
        var s    = this.k.length;
        var idx  = null;
        for ( var i=0;i<s;i++ ) {
            if ( this.k[i] == key ) {
                idx = i;
                break;
            }
        }
        return idx;
    }

    function DP_getVal(idx) {
        var val = null;
        if ( typeof(idx) == 'number' ) {
            val = this.v[idx];
        }
        return val;
    }

    function DP_getSize() {
        var s   = this.k.length;
        return s;
    }