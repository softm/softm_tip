
    function HashTable() {
        this.k = new Array();
        this.v = new Array();
        this.putValue      = putValue;
        this.appendValue   = appendValue;
        this.getValue      = getValue;
        this.getValues     = getValues;
        this.getValueALL   = getValueALL;
        this.getValueInclude = getValueInclude;
        this.getKey        = getKey;
        this.getKeys       = getKeys;
        this.getKeyALL     = getKeyALL;
        this.getKeyInclude = getKeyInclude;
        this.getKeyHowMany = getKeyHowMany;
        this.getSize       = getSize;
    }

    function putValue(key, menuObj) {
        /* 배열에 추가및 수정할 위치 */
        var s = this.k.length;
        
        for ( var i=0;i<s;i++ ){
            if ( key == this.k[i] ) { s = i; break; }
        }
        /* key */
        this.k [s] = key    ;
        /* menu Object */
        this.v [s] = menuObj;
    }

    function appendValue(key, menuObj) {
        /* 배열에 추가및 수정할 위치 */
        var s = this.k.length;
        /* key */
        this.k [s] = key    ;
        /* menu Object */
        this.v [s] = menuObj;
    }


    function getValue(key) {
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

    function getValues(key) {
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

    function getValueALL() {
        var s    = this.k.length;
        var values = new Array();
        var idx  = 0;
        for ( var i=0;i<s;i++ ){
                values[idx] = this.v[i];
                idx++;
        }
        return values;
    }

    function getValueInclude(value) {
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

    function getKey(idx) {
        var key = null;
        if ( typeof(idx) == 'number' ) {
            key = this.k[idx];
        } else {
            key = "HashTable Function Exception 발생";
        }
        return key;
    }

    function getKeys(key) {
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

    function getKeyALL() {
        var s    = this.k.length;
        var keys = new Array();
        var idx  = 0;
        for ( var i=0;i<s;i++ ){
                keys[idx] = this.k[i];
                idx++;
        }
        return keys;
    }

    function getKeyInclude(key) {
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

    function getKeyHowMany(key) {
        var s   = this.k.length;
        var cnt = 0;             /* 갯수 */
        for ( var i=0;i<s;i++ ){
            if ( this.k[i].indexOf(key) >= 0 ) {
                cnt++;
            }
        }
        return cnt;
    }

    function getSize() {
        var s   = this.k.length;
        return s;
    }