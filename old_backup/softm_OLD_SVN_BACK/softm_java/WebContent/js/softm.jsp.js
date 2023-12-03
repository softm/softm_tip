// Prototype --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
var userAgent = navigator.userAgent.toLowerCase();
if ( !document.all  ) {
    HTMLElement.prototype.__defineGetter__("innerText", function() { return this.textContent; });
    HTMLElement.prototype.__defineSetter__("innerText", function(txt) { this.textContent = txt; });
    HTMLDocument.prototype.attachEvent =
        HTMLElement.prototype.attachEvent = function(event, handler,useCapture) {
        if ( this.addEventListener ) {
            this.addEventListener(event.substring(2), handler, useCapture);
        } else {
            this[event] = handler;
        }
    }
    HTMLDocument.prototype.attachEvent =
        HTMLElement.prototype.detachEvent = function(event, handler,useCapture) {
        this.removeEventListener(event.substring(2), handler, useCapture);
    }
    HTMLElement.prototype.click = function() {
        var evt = this.ownerDocument.createEvent('MouseEvents');
        evt.initMouseEvent('click', true, true, this.ownerDocument.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
        this.dispatchEvent(evt);
    }
    HTMLElement.prototype.fireEvent = function(eventStr,event) {
        try {
            var evt = document.createEvent("HTMLEvents");
            evt.initEvent(eventStr.substring(2), true, true ); /* event type,bubbling,cancelable */
            return !this.dispatchEvent(evt);
        }catch(e){
        }    }
}

String.prototype.cssString = function(){
    var info = this.toLowerCase().split('-');
    var _rtn = '';
    for ( var i=0;i<info.length;i++ ) {
        _rtn += (i==0)?info[i]:info[i].charAt(0).toUpperCase() + info[i].substr(1);
    }
    return _rtn;
}
String.prototype.trim = function(){return this.replace(/^\s+|\s+$/g, "");}
String.prototype.padLeft = function(c, len){return (new Array(len - this.length + 1).join(c) + this);}
String.prototype.padRight = function(c, len){return (this + new Array(len - this.length + 1).join(c));}

Number.prototype.format = function(){
    var str = (""+this).replace(/,/gi,"");
    if ( str ) {
        var rxSplit = new RegExp('([0-9])([0-9][0-9][0-9][,.])');
        var arrNumber = str.split('.');
        arrNumber[0] += '.';
        do {
            arrNumber[0] = arrNumber[0].replace(rxSplit, '$1,$2');
        } while (rxSplit.test(arrNumber[0]));

        if (arrNumber.length > 1) {
            str = arrNumber.join('');
        }else{
            str = arrNumber[0].split('.')[0];
        }
        return str;
    }
}
Number.prototype.numberFormat= function(){
    return this.format();
}
String.prototype.numberFormat = function(b){ // true : integer, false : float
//  b = b||true;
    var v = this.replace(/,/gi,"");
    if ( v && !isNaN(v) ) {
        if (b) {
            v = parseFloat(v).format();
        } else {
            v = parseInt(v).format();
        }

    }
    return v;
}
String.prototype.removeComma = function(){return this.replace(/,/gi,"");}
String.prototype.toNumber    = function(){
    var rtn = parseFloat(this.removeComma(/,/gi,""));
    if (isNaN(rtn)) {
    }
    //console.debug(rtn);
    return rtn;
}

String.prototype.toDate= function (y,m,d) {
    var _r = new Date();
    var year    = null;
    var month   = null;
    var day     = null;
    if (!y || !m || !d) {
        var dO = this.toDateEum();
        //alert( dO.year + " # " + dO.month+ " # " + dO.day );
        return this.toDate(dO.year,dO.month,dO.day);
    } else {
        var year    = Number(y);
        var month   = Number(m);
        var day     = Number(d);
    }
    _r.setYear (year);
    _r.setMonth(month-1);
    _r.setDate (day);
    return _r;
}

String.prototype.toDateEum= function () { // d : 2000-11-11
    var o = {};
    o.year = this.substring(0, 4).toNumber();
    o.month= this.substring(5, 7).toNumber();
    o.day  = this.substring(8,10).toNumber();
    return o;
}

Array.prototype.removeItems = function(itemsToRemove) {
    if ( itemsToRemove ) {
        if (!/Array/.test(itemsToRemove.constructor)) {
            itemsToRemove = [ itemsToRemove ];
        }

        var j;
        for (var i = 0; i < itemsToRemove.length; i++) {
            j = 0;
            while (j < this.length) {
                if (this[j] == itemsToRemove[i]) {
                    this.splice(j, 1);
                } else {
                    j++;
                }
            }
        }
    }
}

Array.prototype.unique = function () {
    var item, seen=[];
    for (var i=0, len=this.length; i<len ; i++) {
        item = this[i];
        if (!(seen.toString().indexOf(item) +1) ) {
            seen[seen.length] = item;
        }
    }
    return seen;
}

Array.prototype.in_array = function(p_val) {
    for(var i = 0, l = this.length; i < l; i++) {
        if(this[i] == p_val) {
            return true;
        }
    }
    return false;
}
Array.prototype.inArray = function(p_val) {
    for(var i = 0, l = this.length; i < l; i++) {
        if(this[i] == p_val) {
            return true;
        }
    }
    return false;
}
Array.prototype.remove_push = function(p_val) {
    var exec = false;
    for(var i = 0, l = this.length; i < l; i++) {
        if(this[i] == p_val) {
            this.splice(i,1);
            this.push(p_val);
            exec = true;
            break;
        }
    }
    if (!exec) {
        this.push(p_val);
    }
    return false;
}
Array.prototype.remove = function(p_val) {
    var exec = false;
    for(var i = 0, l = this.length; i < l; i++) {
        if(this[i] == p_val) {
            this.splice(i,1);
            exec = true;
            break;
        }
    }
    return exec;
}

String.prototype.replaceAll = function( searchStr, replaceStr )
{
    var temp = this;

    while( temp.indexOf( searchStr ) != -1 )
    {
        temp = temp.replace( searchStr, replaceStr );
    }

    return temp;
}

/* For convenience...*/
Date.prototype.format = function (mask, utc) {
    return dateFormat(this, mask, utc);
};
Date.prototype.calDate= function (arg) {
    var year    = arg.year == null ? 0 : Number(arg.year);
    var month   = arg.month == null ? 0 : Number(arg.month);
    var day     = arg.day == null ? 0 : Number(arg.day);
    this.setYear (this.getFullYear() + year);
    this.setMonth(this.getMonth() + month);
    this.setDate (this.getDate() + day);
    return this;
}
Date.prototype.calDateString= function (arg) {
    this.calDate(arg);//
    return this.format(arg.mask?arg.mask:dateFormat.masks.isoDate);
}

Date.prototype.toDateString= function (mask) {
    return this.format(mask?mask:dateFormat.masks.isoDate);
}
/* blog.stevenlevithan.com
 * Date Format 1.2.3
 * (c) 2007-2009 Steven Levithan <stevenlevithan.com>
 * MIT license
 *
 * Includes enhancements by Scott Trenda <scott.trenda.net>
 * and Kris Kowal <cixar.com/~kris.kowal/>
 *
 * Accepts a date, a mask, or a date and a mask.
 * Returns a formatted version of the given date.
 * The date defaults to the current date/time.
 * The mask defaults to dateFormat.masks.default.
 */
var dateFormat = function () {
    var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
    timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
    timezoneClip = /[^-+\dA-Z]/g,
    pad = function (val, len) {
        val = String(val);
        len = len || 2;
        while (val.length < len) val = "0" + val;
        return val;
    };
    /* Regexes and supporting functions are cached through closure */
    return function (date, mask, utc) {
        var dF = dateFormat;

        /* You can't provide utc if you skip other args (use the "UTC:" mask prefix) */
        if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
            mask = date;
            date = undefined;
        }

        /* Passing date through Date applies Date.parse, if necessary */
        date = date ? new Date(date) : new Date;
        if (isNaN(date)) throw SyntaxError("invalid date");

        mask = String(dF.masks[mask] || mask || dF.masks["default"]);

        /* Allow setting the utc argument via the mask */
        if (mask.slice(0, 4) == "UTC:") {
            mask = mask.slice(4);
            utc = true;
        }

        var _ = utc ? "getUTC" : "get",
                d = date[_ + "Date"](),
                D = date[_ + "Day"](),
                m = date[_ + "Month"](),
                y = date[_ + "FullYear"](),
                H = date[_ + "Hours"](),
                M = date[_ + "Minutes"](),
                s = date[_ + "Seconds"](),
                L = date[_ + "Milliseconds"](),
                o = utc ? 0 : date.getTimezoneOffset(),
                        flags = {
                        d:    d,
                        dd:   pad(d),
                        ddd:  dF.i18n.dayNames[D],
                        dddd: dF.i18n.dayNames[D + 7],
                        m:    m + 1,
                        mm:   pad(m + 1),
                        mmm:  dF.i18n.monthNames[m],
                        mmmm: dF.i18n.monthNames[m + 12],
                        yy:   String(y).slice(2),
                        yyyy: y,
                        h:    H % 12 || 12,
                        hh:   pad(H % 12 || 12),
                        H:    H,
                        HH:   pad(H),
                        M:    M,
                        MM:   pad(M),
                        s:    s,
                        ss:   pad(s),
                        l:    pad(L, 3),
                        L:    pad(L > 99 ? Math.round(L / 10) : L),
                        t:    H < 12 ? "a"  : "p",
                                tt:   H < 12 ? "am" : "pm",
                                        T:    H < 12 ? "A"  : "P",
                                                TT:   H < 12 ? "AM" : "PM",
                                                        Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
                                                                o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
                                                                S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
                };

        return mask.replace(token, function ($0) {
            return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
        });
    };
}();

/* Some common format strings */
dateFormat.masks = {
        "default":      "ddd mmm dd yyyy HH:MM:ss",
        shortDate:      "m/d/yy",
        mediumDate:     "mmm d, yyyy",
        longDate:       "mmmm d, yyyy",
        fullDate:       "dddd, mmmm d, yyyy",
        shortTime:      "h:MM TT",
        mediumTime:     "h:MM:ss TT",
        longTime:       "h:MM:ss TT Z",
        isoDate:        "yyyy-mm-dd",
        isoTime:        "HH:MM:ss",
        isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
        isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

/* Internationalization strings */
dateFormat.i18n = {
        dayNames: [
                   "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
                   "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
                   ],
                   monthNames: [
                                "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
                                "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
                                ]
};
// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- Prototype

// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- Selector
function $S() {
    if (arguments[0] instanceof $ ) {
        arguments[0] = arguments[0].get(0);
    }
    var elements = new Array();

    for (var i = 0; i < arguments.length; i++) {

        var element = arguments[i];

        if (typeof element == 'string') {
            if (document.getElementById) {
                element = document.getElementById(element);
            } else if (document.all) {
                element = document.all[element];
            }
        }
        elements.push(element);
    }
    if (arguments.length == 1 && elements.length > 0) {
        return elements[0];
    } else {
        return elements;
    }
}
function $N(n ) { return typeof(n)=='object'?n:document.getElementsByName(n); }
function $C(n ) { return document.createElement(n);}
function hasClass(ele,cls) {try { return !!ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)')); } catch (e) { log([e,ele]); }}

var Create = {
//      Create.textNode({value:"aa"})
    textNode:function(o) {
        var el = $CT(o.value);
        return el;
    },
//      Create.textTag({tag:"span",name:'tmp_name1',value:"sssssssssss"})
    textTag:function(o) {
        var el = $C(o.tag);
        if ( o.name ) el.name = o.name;
        if ( o.value) el.innerHTML = o.value;
        return el;
    },
//      Create.hidden({name:'tmp_name2',value:""})
    hidden:function(o) {
        var el = Util.Browser.msie?$C('<INPUT name=' + o.name+ '>'):$C('INPUT');
        if (!Util.Browser.msie) el.name = o.name;
        el.type = 'hidden';
        el.value= o.value;
        return el;
    },
//      Create.textBox({name:'tmp_name2',value:"",size:7,readOnly:true})
    textBox:function(o) {
        var el = Util.Browser.msie?$C('<INPUT name=' + o.name+ '>'):$C('INPUT');
        if (!Util.Browser.msie) el.name = o.name;
        el.type = 'text';
        el.value= o.value;
        if ( o.size      ) el.size= o.size;
        if ( o.readOnly  ) el.readOnly= o.readOnly;
        if ( o.maxLength ) el.maxLength= o.maxLength;
        return el;
    },
//      Create.checkbox({name:'tmp_name3',value:"Y",checked:true})
    checkbox:function(o) {
        var el = Util.Browser.msie?$C('<INPUT name=' + o.name+ '>'):$C('INPUT');
        if (!Util.Browser.msie) el.name = o.name;
        el.type = 'checkbox';
        el.value= o.value;
        el.checked= o.checked;
        return el;
    },
//      Create.radio({name:'tmp_name4',value:"Y",value:{"1":"1값","2":"2값","3":"3값"},checked:"1"})
    radio:function(o) {
        var rtn = new Array();
        var topEl = $C('span');
        var idx=0;
        for ( var k in o.value ) {
            var el = null;
            if ( Util.Browser.msie ) {
                el = $C('<INPUT name=' + o.name+ ' ' + (k == o.checked?"checked":"") + ' >');
            } else {
                el = $C('INPUT');
                el.name = o.name;
                if ( k == o.checked ) {
                    el.checked = true;
                }
            }
            el.type = 'radio';
            el.value= k;
            topEl.appendChild(el);

            var tEl = Create.textNode({value:o.value[k]});
            topEl.appendChild(tEl);
            ///rtn.push(el);

        }
//        console.debug( topEl.getElementsByName(o.name) );
       // return rtn;
       return topEl;

    },
//      Create.listBox({name:'tmp_name5',value:{"1":"1값","2":"2값","3":"3값"},selected:"1"})
    listBox:function(o) {
        var el = Util.Browser.msie?$C('<SELECT name=' + o.name+ '>'):$C('SELECT');
        if (!Util.Browser.msie) el.name = o.name;

        //alert(o.value instanceof Array );
        //this instanceof Array
        var prototype = o.value.constructor.prototype;
        var idx=0;
        for ( var k in o.value ) {
            if (k in prototype) continue;
            if (o.value instanceof Array ) continue;
            var op = new Option(o.value[k],k);
            //alert(oo[i].value + " / " + oo[i].text );
            el.options[idx++] = op;
            if ( k == o.selected ) op.selected = true;
        }

        return el;
    }
}
// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- Selector

// Util --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
var Util = {
    DOM:{
        getY:function( oElement ) {
            var iReturnValue = 0;
            while( oElement != null ) {
                iReturnValue += oElement.offsetTop;
                oElement = oElement.offsetParent;
            }
            return iReturnValue;
        },
        getX:function( oElement ) {
            var iReturnValue = 0;
            while( oElement != null ) {
                iReturnValue += oElement.offsetLeft;
                oElement = oElement.offsetParent;
            }
            return iReturnValue;
        }
    },
    // Util.Browser.msie
    Browser:{
        version: (userAgent.match( /.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/ ) || [])[1],
        safari: /webkit/.test( userAgent ),
        opera: /opera/.test( userAgent ),
        msie: /msie/.test( userAgent ) && !/opera/.test( userAgent ),
        mozilla: /mozilla/.test( userAgent ) && !/(compatible|webkit)/.test( userAgent )
    },
    Date:{
        toDayString:function(mask) {
            var d = new Date();
            return d.format(mask?mask:dateFormat.masks.isoDate);
        },
        toDay:function(mask) {
            var d = new Date();
            return d;
        }
    },
    Load:{
        script:function(o){
            var hd  = document.getElementsByTagName('head')[0];
            var sId = (typeof (o.id) == 'string'?o.id:o.src.split('/')[o.src.split('/').length-1]);
            Util.Load.remove({id:sId});
            var s = null;
            if ( o.type == 'js' ) {
                s = document.createElement('script');
                s.type= 'text/javascript';
            } else if ( o.type == 'css' ) {
                s = document.createElement('link');
                s.rel = 'stylesheet';
                s.type= 'text/css';
            }
            s.id  = sId  ;
            if ( typeof(o.callback) != 'undefined' ) {
                if ( typeof(o.callback) == 'function' ) {
                    /*
                    s.onreadystatechange= function () {
                        alert('this.readyState : ' + this.readyState);
                        alert( 'this.readyState : ' + this.readyState);
                        if (this.readyState == 'complete') {
                            o.callBack();
                            alert('complete');
                        }
                    }
                    */
                    if (s.readyState){  /* IE */
                        s.onreadystatechange = function() {
                            if (s.readyState == "complete" || s.readyState == "loaded" ) {
                                s.onreadystatechange = null;
                                o.callback();
                            }
                        }
                    } else {
                        s.onload= function () { o.callback(); }
                    }
                }
            }

            if ( o.type == 'js' ) {
                s.src = o.src;
            } else if ( o.type == 'css' ) {
                s.href = o.src;
            }
            hd.appendChild(s);
        },
        remove:function(o){
            var sId = (typeof (o.id) == 'string'?o.id:o.src.split('/')[o.src.split('/').length-1]);
            var hd  = document.getElementsByTagName('head')[0];
            var oc = document.getElementById(sId);
            if ( oc != null ) {
                hd.removeChild(oc);
            }
        }
    },
    isEmail:function(s){ return s.search(/^\s*[\w\~\-\.]+\@[\w\~\-]+(\.[\w\~\-]+)+\s*$/g)>=0;
    },
    isDate:function(strDT){
        if(strDT.length < 8) return false;

        var d = new Date(strDT.substring(0, 4),
                strDT.substring(4, 6) - 1,
                strDT.substring(6, 8),
                0, 0, 0);

        if(isNaN(d) == true) return false;
        var s = d.getFullYear().toString();
        var n = d.getMonth() + 1;
        s += (n < 10 ? "0" : "") + n;
        n = d.getDate();
        s += (n < 10 ? "0" : "") + n;

        if(strDT != s) return false;
        return true;
    },
    isArray:function(obj){ if (obj.constructor.toString().indexOf("Array") == -1) return false; else return true;
    }
};
// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- Util
// Form --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
var Form = {
    nextGo:true,
    tmpval:null,
    /**
    * # Using - script
    *   Form.validate( $S('lForm') ,{
    *       user_id:function(){ Effect.twinkle($S('lForm').user_id);},
    *       passwd:function(){ Effect.twinkle($S('lForm').passwd);},\
    *   });
    *
    * # Using - html
    * <input type="text" name="user_id" size="20" style="width:200px" value="" class="required trim focus email alert" maxlength=100 minlength=0 message="ID를 이메일 주소로 입력하세요."/>
    *
    * <input type="password" name="passwd" style="width:200px" size="20" maxlength="25" class="required focus "/>
    *
    * <input type="radio" name="rdo_user_id" value="Y" class="required focus">
    * <input type="radio" name="rdo_user_id" value="N" class="required focus">
    *
    * <input type="checkbox" name="chk_user_id" value="Y" class="required focus">
    *
    * <select name=test_select_one class="required focus">
    *  <option value=''>없음</option>
    *  <option value=1>1</option>
    *  <option value=2>2</option>
    * </select>
    *
    * <select name=test_select_multiy class="required focus" multiple="multiple">
    *   <option value=''>없음</option>
    *   <option value=1>1</option>
    *   <option value=2>2</option>
    * </select>
    */
    validate:function(form,infor) {
        var size = form.elements.length;
        var fe;
        var showAlert = hasClass(form,"alert");
        var chkValid = true;
        var CHKED_RADIO = {};
        for (var i = 0; i < size; i++) {
            fe = form[i];
            // maxlength=10 minlength=1 message="Please enter the ID"
            var  maxlength = fe.getAttribute("maxlength")?fe.getAttribute("maxlength"):100000000;
            var  minlength = fe.getAttribute("minlength")?fe.getAttribute("minlength"):0;
            var  message   = fe.getAttribute("message");
            var  focus     = hasClass(fe,"focus");
            showAlert = !showAlert?hasClass(fe,"alert"):showAlert;
            showAlert = hasClass(fe,"noalert")?false:showAlert;
            var required = hasClass(fe,"required");
            var numbered = hasClass(fe,"number");
            var emailed  = hasClass(fe,"email");
            if ( required || numbered || emailed ) {
//                      log(fe);
//                    log(fe.name +
//                          "\n type : " + fe.type +
//                          "\n required : " + required +
//                          "\n focus : " + focus +
//                          "\n maxlength : " + maxlength +
//                          "\n message : " + message +
//                          "\n minlength : " + minlength
//                    );

                if ( fe.type == 'textarea' || fe.type == 'text' || fe.type == 'password' || fe.type == 'select-one' ) {
                    var v = hasClass(fe,"trim") ? fe.value.trim():fe.value;
//                      log("v : " + v +
//                              "\n v.length : " + ( typeof( v.length) != 'undefined'? v.length:'없음'  )
//                      );

                    if ( ( fe.type == 'textarea' || fe.type == 'text' || fe.type == 'password' ) && v && numbered && isNaN(v) ) {
                        chkValid = false;
                        break;
                    } else {
                        if ( required ) {
                            if ( !v || v.length > maxlength || v.length < minlength ) {
                                chkValid = false;
                                break;
                            }
                        }
                    }

                    if ( v && emailed ) {
                        if ( !Util.isEmail(v) ) {
                            chkValid = false;
                            break;
                        }
                    }
                } else if ( fe.type == 'select-multiple' ) {
                    var isSelected = false;
                    var size1 = fe.options.length;
                    for (var j = 0; j < size1; j++) {
                        if ( fe.options[j].selected ) {
                            isSelected = true;
                            break;
                        }
                    }
                    if ( !isSelected ) {
                        chkValid = false;
                        break;
                    }
                } else if (  fe.type == 'radio' || fe.type == 'checkbox' ) {
                    var rGroup = document.getElementsByName(fe.name);
                    //alert(CHKED_RADIO[fe.name] );
                    if (!CHKED_RADIO[fe.name] ) {
                        CHKED_RADIO[fe.name] = true;
                        var isSelected = false;
                        var size1 = rGroup.length;
                        for (var j = 0; j < size1; j++) {
                            if ( rGroup[j].checked ) {
                                isSelected = true;
                                break;
                            }
                        }
                        if ( !isSelected ) {
                            chkValid = false;
                            break;
                        }
                    }
                } else {

                }
            }
        }
        if ( !chkValid ) {
            if ( showAlert && message ) alert(message);
            if ( focus ) fe.focus();
            if ( typeof(infor) == 'object' && typeof(infor[fe.name]) == 'function' ) infor[fe.name](fe);
            else Effect.twinkle(fe);
        }
        log("Form.validate->" + chkValid + (form?" / " + form.name:"") + (fe?"." + fe.name:"") );
        return chkValid;
    },
    /**
     * # Using
     * $S('lForm').user_id.onfocus = Form.numeberOnly;
     * $S('lForm').user_id.onfocus = function(e) { Form.numeberOnly(e,true); }
     */
    numeberOnly:function(e,allowComma) {
        var e = window.event?event:e;
        var o = window.event?e.srcElement:e.target;
        //console.debug(e.type);
        if (e.type == 'focus') {
            o.setAttribute('org_val',o.value);
            o.attachEvent('onblur',(function(allowComma){
//                  o.attachEvent('onchange',(function(allowComma){
                return function(e){
                    Form.numeberOnly(e,allowComma);
                };
            })(allowComma));
            o.attachEvent('onkeydown',(function(allowComma){
                return function(e){
                    Form.numeberOnly(e,allowComma);
                };
            })(allowComma));
        }

        if ( e.type == 'keydown' )
        {
            var evCode = ( window.event ) ? e.keyCode : e.which ;
            /* FF일 경우 Ev.which 값을,
            IE을 경우 event.keyCode 값을 evCode에 대입 */
            if ( ! ( evCode == 9 || evCode == 8 || evCode == 190 || ( evCode > 47 && evCode < 58  )
                    || ( evCode > 95 && evCode < 106 )
                    || ( evCode > 36 && evCode < 41 )
            ) ) {
                /* 눌러진 키 코드가 숫자가 아닌 경우
            ( '9'은 FF에서 Tab 키,
              '8'은 FF에서 BackSpace가 먹히지 않아 삽입)    */
                if ( !window.event ) {          /* FF일 경우 */
                    e.preventDefault() ;        /* 이벤트 무효화 */
                } else {                        /* IE일 경우 */
                    e.returnValue=false;    /* 이벤트 무효화 */
                }
            }
        }
//            log(checkFloat);
        var pattern = !allowComma?/[^0-9]/g:/[^0-9\.]/g;
        if(pattern.test(o.value)){
            var v = o.value.replace(pattern, "");
            o.value = o.value.replace(pattern, "");
        } else {
        }
        if (!o.value) {
            //alert("o.value : " + o.value);
            //o.value = o.getAttribute('org_val');
        } else {
            o.setAttribute('org_val',o.value);
        }
    },
    value:function(k) {
        var data = Array();
//        console.debug(fe.name,fe);
        var fe = typeof(k)=="object"?k:$S(k);
		if ( !fe ) {
		    try{
		        fe = $N(k);
		        if ( fe ) fe = fe[0];
		    } catch (e) { }
		}        
//        console.debug("Form.value - " , typeof(k),fe.name,fe,fe.value);
        if ( typeof(fe) == 'undefined' ) throw new Error('Form.value - fe element not exsist.');

        if ( fe.type == 'radio' || fe.type == 'checkbox' ) {
            var rGroup = document.getElementsByName(fe.name);
            var size1 = rGroup.length;
            for (var j = 0; j < size1; j++) {
                if ( fe.type == 'radio' ) {
                    if ( rGroup[j].checked ) {
                        data.push(encodeURIComponent(rGroup[j].value));
                        break;
                    }
                } else {
                    if ( rGroup[j].checked ) {
                        data.push(encodeURIComponent(rGroup[j].value));
                    }
                }
            }
        } else if ( fe.type == 'select-multiple' ) {
            var size1 = fe.options.length;
            for (var j = 0; j < size1; j++) {
                if ( fe.options[j].selected ) data.push(encodeURIComponent(fe.options[j].value));
            }
        } else {
            data.push(encodeURIComponent(fe.value));
        }
        return data.join(",");
    },
    jsonData:function(f) {
        var data = {};
        var size = f.elements.length;
        for (var i = 0; i < size; i++) {
            var fe = f[i];
            if ( !data[fe.name] ) data[fe.name] = Array();
            if ( fe.type == 'radio' || fe.type == 'checkbox' ) {
                if(fe.checked) data[fe.name].push(encodeURIComponent(fe.value));
            } else if ( fe.type == 'select-multiple' ) {
                var size1 = fe.options.length;
                for (var j = 0; j < size1; j++) {
                    if ( fe.options[j].selected ) data[fe.name].push(encodeURIComponent(fe.options[j].value));
                }
            } else {
                data[fe.name].push(encodeURIComponent(fe.value));
            }
        }
        return data;
    },
    queryString:function(f) {
        var rtn = "";
        var data = Form.jsonData(f);
        var prototype = data.constructor.prototype;
        for ( var key in data ) {
            if (key in prototype) continue;
            if (data instanceof Array && isNaN(key)) continue;
            if ( key ) rtn += key + "=" + data[key].join(",") + "&";
        }
        rtn = rtn.substring(0, rtn.length - 1);
        //console.debug(3);
        return rtn;
    },
    removeParameter:function(params,n) {
        //var params = "a=11111111111111&bccd=2&c=3";
        //var n = 'a';
        //var regexp = new RegExp("([\\?\\&]|^)"+n+"=[^&]*", "gi");
        var regexp = new RegExp("([\\?\\&]|^)"+n+"=[^&]*", "g");
        params = params.replace(regexp,"");
        return ( params.charAt(0) == '?' || params.charAt(0) == '&'?params.substring(1):params);
    },
    /**
     * form에 fieldInfo정보와 맵핑된 input 필드에 셋
     * @param form
     * @param json
     */
    bind:function(jsonItem,form,setRule) {
        //var form = $S('wForm');
        var items = jsonItem;
        //var items = typeof jsonItem == 'undefined'? new Array():jsonItem;
        //alert(isArray(items));
        //if ( isArray(items) ) {
        //
        //}
        if ( jsonItem ) {
            for ( var fId in jsonItem ) {
                var v = items[fId];
        //          (typeof items[fId].value == 'object'?'':items[fId].value );

                var fe = form[fId];
                var rGroup = null;
                var size1 = 0;
                var type = null;

        //      if ( fId == 'biz_field') alert('biz_field');
                if ( fe ) {
                    type = fe.type;
                    if ( typeof(type) == 'undefined' ) {
                        rGroup = document.getElementsByName(fId);
                        size1 = rGroup.length;
        //              alert ( fId + " / "  + size1);
                        if ( size1 > 0 ) {
            //              alert( fe.type );
                            type = rGroup[0].type;
            //              alert(type + " / " + size1 );
                        }
                    }
                } else {
                    rGroup = document.getElementsByName(fId+PARAMETER_SURFIX);
                    size1 = rGroup.length;
                    if (size1) type = rGroup[0].type;
                }
                try {
                    if ( type == 'text' || type == 'hidden' || type == 'password' || type == 'select-one' || type == 'textarea'  ) {
                        fe.value =v;
                    } else if (  type == 'radio' || type == 'checkbox' ) {

                        if ( v ) {
                            if ( type == 'radio' ) {
                                for (var j = 0; j < size1; j++) {
                                    if ( rGroup[j].value == v ) {
                                        rGroup[j].checked = true;
                                        break;
                                    }
                                }
                            } else if ( type == 'checkbox' ) {
                                var vInfor = v.split(",");
                                var size2 = vInfor.length;
        //                      alert( vInfor );
                                for (var k = 0; k < size2; k++) {
                                    for (var j = 0; j < size1; j++) {
                                        if ( vInfor[k] == rGroup[j].value  ) {
                                            rGroup[j].checked = true;
                                            break;
                                        }
                                    }
                                }
                            }
                        }

                    } else if ( type == 'select-multiple' ) {
                        // 우선코딩해놈. 아직 안될꺼임.
                        var vInfor = v.split(",");
                        var size2 = vInfor.length;
        //              alert( vInfor );
                        for (var k = 0; k < size2; k++) {
                            for (var j = 0; j < size1; j++) {
                                if ( vInfor[k] == rGroup[j].value  ) {
                                    rGroup[j].checked = true;
                                    break;
                                }
                            }
                        }
                    } else {

                    }
                    if ( setRule && typeof(setRule[fId]) == 'function' ) {
        //              alert(fId  + " / " + v);
                        setRule[fId](fe,v);
                    } else {

                    }

                } catch (e) {
                    //alert(fId + "를 확인해주세요.");
                    //throw new Error(fId + "를 확인해주세요.");
                }

            }        	
        } else {
        	//throw new Error("jsonItem not found : " + log(json) );
        }
    }
};
// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- Form
// IframeSubmit --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
var IframeSubmit = {
    callBack:null,
    url:null,
    readyState:0,
    iframe:null,
    form:null,
    init:function(){
        IframeSubmit.readyState=0;
        var ifr = document.getElementsByName('_up_frame')[0];
        if (ifr ) ifr.src="about:blank";
        if (ifr) document.body.removeChild(ifr);
//alert();

        if ( document.all ) {
            //alert('ie');
            ifr = document.createElement('<iframe name=' + '_up_frame>');
            ifr.id = '_up_frame';
        } else {
            //alert('ns');
            ifr = document.createElement('iframe');
            ifr.id = '_up_frame';
            ifr.setAttribute('name', ifr.id);
        }

        document.body.appendChild(ifr);
        IframeSubmit.iframe = ifr;
        IframeSubmit.iframe.style.display = 'inline';
        IframeSubmit.iframe.style.width   = '550px';
        IframeSubmit.iframe.style.height  = '550px';
        if ( document.all ) {
            IframeSubmit.iframe.onreadystatechange = function() {
                if ( IframeSubmit.readyState== 0 && IframeSubmit.iframe.readyState == 'complete') {
                    IframeSubmit.readyState++;
                    
                  var rtn = IframeSubmit.iframe.contentWindow.document.body.innerHTML;
//                  log(IframeSubmit.iframe.contentWindow.document.documentElement);
//                    var rtn = IframeSubmit.iframe.contentWindow.document.XMLDocument;
//                    alert(IframeSubmit.iframe.contentWindow.document.body.innerHTML);
                    //alert(rtn.nodeType);
                    
                    if (IframeSubmit.callBack) IframeSubmit.callBack(rtn);
                }
            }
        } else {
            IframeSubmit.iframe.onload = function() {
//              alert("IframeSubmit.iframe.onload : " +  IframeSubmit.readyState);
                //if ( IframeSubmit.readyState == 1 ) {
                    //alert("x");
                    //log(IframeSubmit.iframe.contentWindow.document.documentElement);
                  var rtn = IframeSubmit.iframe.contentWindow.document.body.innerHTML;
//                    var rtn = IframeSubmit.iframe.contentWindow.document.documentElement;
//                  alert(rtn);
                    if (IframeSubmit.callBack) IframeSubmit.callBack(rtn);
//                } else {
//                    IframeSubmit.readyState++;
//                }
            }
        }
    }
    ,setForm:function(f,url,cb){
        IframeSubmit.callBack = cb;
        IframeSubmit.url = url;
        f.target = '_up_frame';
        f.enctype="application/x-www-form-urlencoded" ;
//        f.method="post";
        f.action = url;
        IframeSubmit.form = f;
        //log(f);
    }
    ,setFormFile:function(f,url,cb){
        IframeSubmit.callBack = cb;
        IframeSubmit.url = url;
        f.target = '_up_frame';
        f.enctype="multipart/form-data";
        //f.method="POST";
        f.action = url;
        IframeSubmit.form = f;
    }
    ,submit:function(f){
        IframeSubmit.form.submit();
    }
};
// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- IframeSubmit

// UI--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
var UI = {
    /**
    * <a href=# onclick="UI.openWindow('/service/inc/common/company_infor_popup.php', 750, '768','w_company_infor',{scrollbars:'yes'}).focus();">팝업</a>
    * UI.openWindow('/service/inc/common/company_infor_popup.php', 750, '768','w_company_infor',{scrollbars:'yes'}).focus();
    */
    openWindow:function(sURL, dlgWidth, dlgHeight,winName,prop){
        // alert(sURL);
        var pTitlebar = pScrollbars = pLocation = pMenubar = pResizable = pStatus = pFullscreen = '';
        if ( prop ) {
            pTitlebar   = prop.titlebar    ?prop.titlebar  :'no' ;
            pScrollbars = prop.scrollbars  ?prop.scrollbars:'no' ;
            pLocation   = prop.location    ?prop.location  :'no' ;
            pMenubar    = prop.menubar     ?prop.menubar   :'no' ;
            pResizable  = prop.resizable   ?prop.resizable :'1';
            pStatus     = prop.status      ?prop.status    :'yes';
            pFullscreen = prop.fullscreen  ?prop.fullscreen:'no' ;
        }
        var xPos=0;
        var yPos=0;
        if (typeof(prop) != 'undefined' && typeof(prop.left) != 'undefined' ) {
            xPos=prop.left;
        } else {
            xPos=(window.screen.width) ? (window.screen.width-dlgWidth)/2 : 0;
        }
        if (typeof(prop) != 'undefined' && typeof(prop.top) != 'undefined' ) {
            yPos=prop.top ;
        } else {
            yPos=(window.screen.height) ? (window.screen.height-dlgHeight)/2 : 0;
        }
        //alert(xPos + " / " + yPos);
        //alert(pLocation);
        var sFeatures = "titlebar=" + pTitlebar +", scrollbars=" + pScrollbars +",location=" + pLocation +" ,menubar=" + pMenubar +", resizable=" + pResizable +", status=" + pStatus +", fullscreen=" + pFullscreen +", width="+dlgWidth+",height="+dlgHeight+",left="+xPos+", top="+yPos;
        return window.open(sURL,winName, sFeatures);
    },
    /**
     * 화면에 field name 또는 id 와 일치하는 DOM에 innerHTML 값 적용
     * @param form
     * @param json
     */
    bind:function(jsonItem,setRule) {
        var items = jsonItem;
        if (  jsonItem ) {
            var prototype = jsonItem.constructor.prototype;
            for ( var fId in jsonItem ) {
                var v = items[fId];
                var fe = $S(fId);
		        if ( !fe ) {
		            try{
		                fe = $N(fId);
		                if ( fe ) fe = fe[0];
		            } catch (e) { }
		        }
                try {
                    if ( fe ) {
                    	if ( fe.type && ( fe.type == "text" || fe.type == "hidden" ) ) {
                            fe.value  = v;                    		
                    	} else {
                            fe.innerHTML = v;                    		
                    	}
						if ( setRule && typeof(setRule[fId]) == 'function' ) {
							// alert(fId  + " / " + v);
						    setRule[fId](fe,v);
						} else {
						
						}
                    }
                } catch (e) {
                    //alert(fId + "를 확인해주세요.");
                    //throw new Error(fId + "를 확인해주세요.");
                }
            }        	
        } else {
        	//throw new Error("fieldInfo not found : " + log(json) );
        }
    }
}
// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- UI

// Effect --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
var Effect= {
    TWINKLE_INTERVAL:150,
    TWINKLE_OBJECT:{},
    DEFAULT_INFO:{cssText:'background-color:#fbffff;border:1px dotted red',during:700,interval_time:230,callback:function(){}},
    clearTwinkle:function(oId,cb) {
        if ( Effect.TWINKLE_OBJECT[oId] ) Effect.TWINKLE_OBJECT[oId].playing = false;
        //Effect.TWINKLE_OBJECT[oId] = null;
        var eFo = Effect.TWINKLE_OBJECT[oId];
        eFo.object.style.cssText = eFo.cssText;
        clearInterval(eFo.interval);
        if ( typeof cb == "function" ) cb();
    },
    /* using
Effect.twinkle($('part_msg' ),{cssText:'background-color:#BFE2FF;border:5px dotted #99CCCC;color:black',during:0,interval_time:1000,callback:function(){}});
     */
    twinkle:function(o,i,opt) {
        var execCnt = 0;
        var oId = '';
        if ( o.id ) {
            oId = o.id;
        } else {
            var oN = $N(o.name);
            if ( oN.length == 1 ) {
                //o = oN[0];
                oId = o.name;
            } else {
                for( var ii=0;ii<oN.length;ii++){
                    if ( o == oN[ii]) {
                        o = oN[ii];
                        oId = o.name + '_' + ii;
                        break;
                    }
                }
            }
        }
        //log(oId);
        if ( o ) {
            var cssText = o.style.cssText;
            var eFo = null;
            if ( !Effect.TWINKLE_OBJECT[oId] ){
                Effect.TWINKLE_OBJECT[oId] = {};
                eFo = Effect.TWINKLE_OBJECT[oId];
                eFo.interval = null;
                eFo.object   = o;
                eFo.execCnt  = 0;
                eFo.infor    = i = !i?this.DEFAULT_INFO:i;
                eFo.cssText  = o.style.cssText;
                eFo.playing  = false;
                eFo.id       = oId;
            } else {
                eFo = Effect.TWINKLE_OBJECT[oId];
            }
            //log(eFo);
            if ( !eFo.playing ) {
                eFo.playing = true;
                function start(eFo) {
                    //eFo = Effect.TWINKLE_OBJECT[oId];
                    //log(eFo);
                    //alert(eFo);
                    var it = eFo.infor.interval_time?eFo.infor.interval_time:Effect.TWINKLE_INTERVAL;
                    if ( eFo.playing && eFo.infor.during == 0 || eFo.execCnt * it < eFo.infor.during ) {
                        if ( eFo.execCnt % 2 == 0 ) {
                            eFo.object.style.cssText = eFo.cssText + ';' + eFo.infor.cssText;
                        } else {
                            eFo.object.style.cssText = eFo.cssText;
                        }
                        eFo.execCnt++;

                    } else {
                        //alert('clear : ' + eFo.id );
                        eFo.object.style.cssText = eFo.cssText;
                        if (typeof(eFo.infor.callback) === 'function') {
                            eFo.infor.callback();
                        }
                        //Effect.TWINKLE_OBJECT[eFo.oId]
                        clearInterval(eFo.interval);
                        Effect.clearTwinkle(eFo.id);
                        delete Effect.TWINKLE_OBJECT[oId];
                    }
                }
                if (eFo.infor.focus) o.focus();
                if ( Util.Browser.mozilla ) {
                    eFo.interval = setInterval(start,
                            eFo.infor.interval_time?eFo.infor.interval_time:Effect.TWINKLE_INTERVAL,
                                    eFo
                    );
                } else {
                    eFo.interval = setInterval(
                            function(){
                                start(eFo);
                            },
                            eFo.infor.interval_time?eFo.infor.interval_time:Effect.TWINKLE_INTERVAL
                    );
                }
            }
        }
        return o;
    }
}
// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- Effect

function onInit() { }

function getCss(dir,prg,o) {
    var getuicall   = (typeof(o.getuicall   ) == 'undefined')?false :o.getuicall      ; // 기본값 false

    var cssSrc = "/service/ui/" + dir + "/css/" + prg + ".css";
    var sourceCSS = ROOT_DIR + "/service/ui/" + dir + "/css/" + prg + ".css";
    Util.Load.script({src:cssSrc,type:'css',callback:function(){
        if ( AJAX_DEBUG ) {
            DEBUG_COPY_INDEX++;
            if ( Util.Browser.msie ) {
                $('#_info').get(0).innerHTML += "<div style='color:#e0788a;"+(getuicall?"margin-left:25px":"")+"'>--> getCss <B><a href='" + cssSrc + "' target='_new'>" + dir + "/css/" + prg + ".css</a></B>-> <a href='#' id=css_dir_copy" + DEBUG_COPY_INDEX + " copy_data=\'" + sourceCSS + "\'>[복사]</a></div>";
                //$('#_info').get(0).innerHTML += "<BR>&nbsp;&nbsp;&nbsp;&nbsp;------ getCss ---- ------------ -------- ---- ------------";
                //$('#_info').get(0).innerHTML += "<BR><span style='color:#e0788a'>src css</span>  : <input type=text value='" + sourceCSS + "' onclick='this.select();' size=30>";
                $('#css_dir_copy' + DEBUG_COPY_INDEX ).zclip({path:'/service/js/ZeroClipboard.swf',copy:function(){return 'file:///' + $(this).get(0).getAttribute("copy_data");}});
            } else {
                $('#_info').get(0).innerHTML += "<div style='color:#e0788a;"+(getuicall?"margin-left:25px":"")+"'>--> getCss <B><a href='" + cssSrc + "' target='_new'>" + dir + "/css/" + prg + ".css</a></B>-> <a href='#' onclick='softmCopyDebug(this)' copy_data=\'" + sourceCSS + "\'>[복사]</a></div>";
                //console.debug((getuicall?"    ":"") + '--> getCss ' + dir + "/css/" + prg + " | " + sourceCSS );
            }
        }
    }});
}

function getJsp(dir,prg,o) {
    o = o?o:{};
    if ( dir != '' ) dir = dir.charAt(0)=='/'?dir.substr(1):dir;

    o.method        = (typeof(o.method  ) == 'undefined')?'POST':o.method   ; // 기본값 POST
    o.target        = (typeof(o.target  ) == 'undefined')?'#contents':o.target   ; // 기본값 #contents

    var url    = "";
    var lib_include = (typeof(o.lib_include ) == 'undefined')?true  :!!o.lib_include  ; // 기본값 true
    var params      = (typeof(o.params      ) == 'undefined')?""    :o.params         ; // 기본값 ""
    var getuicall   = (typeof(o.getuicall   ) == 'undefined')?false :o.getuicall      ; // 기본값 false
    if (!lib_include) {
        url    = "/" + dir + "/" + prg + ".jsp";
    } else {
        url  = "/ui.jsp";
        url += '?p_tmp=';
        params += (params?"&":"")+"p_dir=" + dir;
        params += "&p_prg="  + prg;
    }
    if ( params.charAt(params.length-1) == '&' ) params = params.substring(0,params.length-1);

    var baseDir = document.location.pathname.replace(/\/service\//,'').split(".")[0];
    var sub = dir.replace(baseDir+'/','');

    var serviceUrl = document.location.pathname + "?p_prg=" + dir + "/" + prg;
    if ( params ) {
        paramsInfo = params.split("&");
//        console.debug(paramsInfo)
        var size = paramsInfo.length;
        for (var i = 0; i < size; i++) {
            var pInfo = paramsInfo[i].split("=");
            var k = pInfo[0];
            if ( k != "p_dir" && k != "p_prg" ) {
                o.argus[pInfo[0]] =pInfo.length>1?pInfo[1]:'';
            }
        }
       //params =  Form.removeParameter(params,"p_dir");
       //params =  Form.removeParameter(params,"p_dir");
    }
//    console.debug(o.argus);
    for ( var k in o.argus ) {
        if ( params.indexOf("&"+k + "=") == -1 ) {
            params += (params?"&":"") + k + "=" + o.argus[k];
        }
        if ( k != "sub" && k != "prg" ) serviceUrl += "&" + k + "=" + (o.argus[k]);
    }
//    alert(params);
/* */
    $.ajax({
        type: o.method,
        url: o.method=="POST"?url:url + '?' + params,
        data: o.method=="POST"?params:null,
        success: function(response) {
            //alert(o.target);
            //alert(ar.id);
            $(o.target).html(response);
        },
        complete: function(xhr) {
            if (typeof(o) == 'object' && o.cb) o.cb();

            //callback define
            //alert(xhr.status);
            //callback(xhr.status);
        },
        error: function(xhr, textStatus, thrownError) {
            // s = response;
            // sO.html(s);
            //console.debug(xhr.responseText)
            //console.debug(textStatus)
            //console.debug(thrownError)
            alert(xhr.responseText);
            //alert('Error!  Status = ' + xhr.status);
        },
        async: false

    });

    var source = ROOT_DIR + "/"+ dir + "/" + prg + ".jsp";

    if ( AJAX_DEBUG ) {
        DEBUG_COPY_INDEX++;
        if ( Util.Browser.msie ) {
            $('#_info').get(0).innerHTML += "<div style='"+(getuicall?"margin-left:25px":"")+";overflow:hidden;width:300px;border:0px solid red' title='" + serviceUrl + "' ><a href='" + serviceUrl + "' style='color:red'>" + serviceUrl+ "</a></div>";
            $('#_info').get(0).innerHTML += "<div style='color:#24779b;"+(getuicall?"margin-left:25px":"")+"'>--> getJsp <B><a target='_blank' href='" + url + "&" + params + "'>" + dir + "/" + prg + ".jsp</a></B>-> <a href='#' id=php_dir_copy" + DEBUG_COPY_INDEX + " copy_data=\'" + source + "\'>[복사]</a></div>";
//            $('#php_dir_copy' + DEBUG_COPY_INDEX).zclip({path:'/service/js/ZeroClipboard.swf',copy:function(){return 'file:///' + $(this).get(0).getAttribute("copy_data");}});
          //$('#_info').get(0).innerHTML += "<BR><span style='color:#24779b'>ui php</span> : <input type=text value='" + source+ "' onclick='this.select();' size=30>";
          //$('#_info').get(0).innerHTML += "<BR><textarea type=text onclick='this.select();' style='height:100px;'>" + url +(params?'&'+params:'') + "</textarea>";
        } else {
            $('#_info').get(0).innerHTML += "<div style='"+(getuicall?"margin-left:25px":"")+";overflow:hidden;width:300px;border:0px solid red' title='" + serviceUrl + "' ><a href='" + serviceUrl + "' style='color:red'>" + serviceUrl+ "</a></div>";
            $('#_info').get(0).innerHTML += "<div style='color:#24779b;"+(getuicall?"margin-left:25px":"")+"'>--> getJsp <B><a target='_blank' href='" + url + "&" + params + "'>" + dir + "/" + prg + ".jsp</a></B>-> <a href='#' onclick='softmCopyDebug(this)' copy_data=\'" + source + "\'>[복사]</a></div>";
            //console.debug((getuicall?"    ":"") + '--> getJsp ' + "<a href='"+serviceUrl+"'>" +serviceUrl+ "</a>"+ "\n" + dir + "/" + prg + ".php | " + source );
        }
    }
    return o;
}
function softmCopyDebug(o) {
    var text =  o.getAttribute("copy_data");
    window.prompt ("Copy to clipboard: Ctrl+C, Enter", "file:///" + text);
}
function getJs(dir,prg,o) {
    o = o?o:{};
    var params      = (typeof(o.params  ) == 'undefined')?""    :o.params         ; // 기본값 ''
    var getuicall   = (typeof(o.getuicall   ) == 'undefined')?false :o.getuicall      ; // 기본값 false

    if ( dir != '' ) dir = dir.charAt(0)=='/'?dir.substr(1):dir;

    o.argus = !o.argus?{}:o.argus;

    if ( params.charAt(params.length-1) == '&' ) params = params.substring(0,params.length-1);
    var baseDir = document.location.pathname.replace(/\/service\//,'').split(".")[0];
    var sub = dir.replace(baseDir+'/','');

    if ( params ) {
        paramsInfo = params.split("&");
        var size = paramsInfo.length;
        for (var i = 0; i < size; i++) {
            var pInfo = paramsInfo[i].split("=");
            var k = pInfo[0];
            if ( k != "p_dir" && k != "p_prg" ) {
                o.argus[pInfo[0]] =pInfo.length>1?pInfo[1]:'';
            }
        }
    }
    var jsSrc  = "/" + dir + "/js/" + prg + ".js";
    var sourceJS = ROOT_DIR + "/" + dir + "/js/" + prg + ".js";

    if ( AJAX_DEBUG ) {
        DEBUG_COPY_INDEX++;
        if ( Util.Browser.msie ) {
            $('#_info').get(0).innerHTML += "<div style='color:#e0788a;"+(getuicall?"margin-left:25px":"")+"'>--> getJs&nbsp;&nbsp;&nbsp;<B><a href='" + jsSrc + "' target='_blank'>" + dir + "/js/" + prg + ".js</a></B>-> <a href='#' id=js_dir_copy" + DEBUG_COPY_INDEX + " copy_data=\'" + sourceJS + "\'>[복사]</a></div>";
            //$('#_info').get(0).innerHTML += "<BR><span style='color:#e0788a'>src js</span>  : <input type=text value='" + sourceJS+ "' onclick='this.select();' size=30>";
//            $('#js_dir_copy' + DEBUG_COPY_INDEX).zclip({path:'/service/js/ZeroClipboard.swf',copy:function(){return 'file:///' + $(this).get(0).getAttribute("copy_data");}});
        } else {
            $('#_info').get(0).innerHTML += "<div style='color:#e0788a;"+(getuicall?"margin-left:25px":"")+"'>--> getJs&nbsp;&nbsp;&nbsp;<B><a href='" + jsSrc + "' target='_blank'>" + dir + "/js/" + prg + ".js</a></B>-> <a href='#' onclick='softmCopyDebug(this)' copy_data=\'" + sourceJS + "\'>[복사]</a></div>";
            //console.debug((getuicall?"    ":"") + '--> getJs ' + dir + "/js/" + prg + ".js | " + sourceJS );
        }
    }

    //alert(jsSrc);
    $.getScript(jsSrc)
        .done(function(script, textStatus) {
            var argus = SOFTMARGUMENT;
//          console.debug(argus,o.argus);
            var callArgus = json_merge(argus,o.argus);
            callArgus.sub = sub;
            callArgus.prg = prg ;
            if ( SOFTMARGUMENT["RESTORE"] ) {
                callArgus["RESTORE"] = SOFTMARGUMENT["RESTORE"];
                SOFTMARGUMENT = callArgus;
            } else {
                SOFTMARGUMENT = callArgus;
            }
//          alert(callArgus.sub + " / " + callArgus.prg);
//          console.debug("getui", SOFTMARGUMENT);

            window.setTimeout(function() {
//              console.debug(argus);
                if (typeof onInit == 'function'){
//                    alert(isRestore());
                    if ( isRestore() ) {
                        callRestore();
                    }
                    onInit(callArgus);
                }
            },100);
        })
        .fail(function(jqxhr, settings, exception) {
            if ( AJAX_DEBUG ) {
                if ( Util.Browser.msie ) {
                    $('#_info').get(0).innerHTML += ( '<font color=red>JS load exception : ' + exception + '</font>');
                } else {
                    console.debug('JS load exception' + dir + "/js/" + prg + ".js | " + sourceJS );
                }
            } else {
                alert('JS load exception : ' + exception);
            }
    });
    return o;
}

/**
* 실행순서.
* css => ui ==> js
getUI("admin/member","list",{
    method:'POST',
    target:"#contents",
    argus:{p_user_level:''},
    lib_include:true,
    loadcss:false,
    loadui:true,
    loadjs:true,
    cb:function() {
    }
});
*/
function getUI(dir,prg,o) {
    window.onInit = function(){};
    o = o?o:{};

    o.method        = (typeof(o.method  ) == 'undefined')?'POST':o.method   ; // 기본값 POST
    o.target        = (typeof(o.target  ) == 'undefined')?'#contents':o.target   ; // 기본값 #contents

    o.getuicall = true;
    if ( AJAX_DEBUG ) {
        if ( Util.Browser.msie ) {
            $('#_info').get(0).innerHTML += "<span style='color:red'>-->getUI</span>";
        } else {
            $('#_info').get(0).innerHTML += "<span style='color:red'>-->getUI</span>";
            //console.debug('-->getUI');
        }
    }
    var loadcss     = (typeof(o.loadcss ) == 'undefined')?false:!!o.loadcss ; // 기본값 false
    var loadui      = (typeof(o.loadui  ) == 'undefined')?true :!!o.loadui  ; // 기본값 true
    var loadjs      = (typeof(o.loadjs  ) == 'undefined')?true :!!o.loadjs  ; // 기본값 true

    o.argus = !o.argus?{}:o.argus;

    if (loadcss) getCss(dir,prg,o);

    if ( loadui ) {
    	getJsp(dir,prg,o); // o -> call by reference ( 변경됨 )
        delete o.params; // getProgram에서 params을 o.argus에 할당함으로 중복되게 수행되지 않게하기위해
    }

    //console.debug(o);
    if (loadjs ) getJs (dir,prg,o);
    //console.debug(o);
    return false;
}

/**
 * @param id string
 * @param value function Or string
 * @param variable boolean
 */
function setRestore(id,value,variable) {
    var key = SOFTMARGUMENT.sub+"_"+SOFTMARGUMENT.prg;
    if ( !SOFTMARGUMENT["RESTORE"] ) SOFTMARGUMENT["RESTORE"]={};
    if ( !SOFTMARGUMENT["RESTORE"][key] ) SOFTMARGUMENT["RESTORE"][key]={};

    if ( typeof(value) == 'function' ) {
        //console.debug(value);
        //SOFTMARGUMENT["RESTORE"][key][id] = (function(value){ return value(); })(value);
        SOFTMARGUMENT["RESTORE"][key][id] = value;
    } else if ( typeof(value) == 'string' || typeof(value) == 'number') {
        if ( !variable ) {
            SOFTMARGUMENT["RESTORE"][key][id] = value;
        } else {
//          alert("xx");
            if ( !SOFTMARGUMENT["RESTORE"][key]['softm_val'] ) SOFTMARGUMENT["RESTORE"][key]['softm_val'] = {};
            SOFTMARGUMENT["RESTORE"][key]['softm_val'][id] = value;
        }
    } else {
//      alert(typeof(value));
    }
//  console.debug("SET", key, SOFTMARGUMENT);
}


/**
 * @param id string
 * @param value function Or string
 */
function callRestore() {
    if ( SOFTMARGUMENT["RESTORE"] ) {
        var key     = SOFTMARGUMENT.sub+"_"+SOFTMARGUMENT.prg;
        var restore = SOFTMARGUMENT["RESTORE"][key];
//        console.debug("callRestore", key );

        for ( var k in restore ) {
            if ( typeof(restore[k]) == 'function' ) { restore[k](); }
            else                                    {
                if ( k != 'softm_val' ) {
                    var fe = $S(k);
//                        fe = fe?fe:$N(k);
                    if ( !fe ) {
                        try{
                            fe = $N(k);
//                            console.debug("callRestore - fe : ",typeof(k),k,typeof(fe),fe);
                            if ( fe ) fe = fe[0];
                        } catch (e) { }
                    }
//                   console.debug("callRestore - ", k, fe, restore[k] );
////                console.debug(fe);
//                    alert( fe );
//                    if ( fe && typeof(fe.length) == "number" && fe.type && fe.type.indexOf("select") == -1 ) fe = fe[0];
                    if ( typeof(fe) == 'undefined' ) {
//                    	throw new Error('callRestore - fe element not exsist.');
                    } else {
                        fe.value = decodeURIComponent(restore[k]);
                    }

                }
            }
        }
    }
}
/**
 * @param id string
 * @param value function Or string
 */
function isRestore() {
    var restore = SOFTMARGUMENT["RESTORE"];
    var key     = SOFTMARGUMENT.sub+"_"+SOFTMARGUMENT.prg;
    var rtn = restore && restore[key]?true:false;
//  alert("isRestore:"+key + ":" + rtn);
//  console.debug("isRestore:"+key + ":" + rtn);
    return rtn;
}
/**
 * @param id string
 */
function getRestoreValue(id) {
    var restore = SOFTMARGUMENT["RESTORE"];
    var key     = SOFTMARGUMENT.sub+"_"+SOFTMARGUMENT.prg;
    if ( restore&&restore[key] ) {
    	if ( restore[key][id] ) return restore[key][id];
    	else {
    		if ( restore[key]['softm_val'] && restore[key]['softm_val'][id] ) 
    			return restore[key]['softm_val'][id];
    		else 
    			return undefined;
    	}
    } else {
    	return undefined;
    }
}

/*
callService({
    requestType : 'POST', // JSON, POST
    dataType    : 'xml' , // xml,html,script,json
    async       : false,
    infor:{
       className  : 'common.Sample' ,
       method     : 'common.Sample.getList' ,
       params     : '',
       argus      : {
           p_user_name:'1',
           p_user_id:'2',
           p_passwd:'3'
       }
    },
    cb:function(xmlDoc){
        var json  = Util.xml2json(xmlDoc);
    },
    form:null,
    debug:false,
    contentType:"text/xml; charset=UTF-8"
});
 */
function callService(o) {
//  alert("callService");
    var className   = o.infor.className ;
    if ( !className ) throw new Error('class 정보가 없습니다.');
    o.debug = o.debug?o.debug:false;

    var tId         = o.table_id        ;
    var requestType = ( !o.requestType?"post":o.requestType).toLowerCase();
    var dataType    = ( !o.dataType?"xml":o.dataType).toLowerCase();
    var async       = (typeof(o.async ) == 'undefined')?true  :!!o.async  ; // 기본값 true
    var argus       = o.infor.argus instanceof Object?o.infor.argus:{};

    var params = o.infor.params?o.infor.params:"";
//    log(dataType);
//    log("o.infor.params: " + o.infor.params);
// alert(async);
    var url  = REST_ROOT + "/" + className;
//    url += '?p_hash=' + p_hash;

    if ( requestType == "post" ) {
        //alert(o.infor);
        params += params?"&":"";
        params += "p_tmp=";
        params += "&request_type=" + o.requestType ;
        params += "&className="   + className;
//        log(argus);
        if ( argus instanceof Object ) {
            var prototype = argus.constructor.prototype;
            for ( var k in argus ) {
                if (k in prototype) continue;
                if (argus instanceof Array ) continue;
                //params += (params?"&":"?")+k+"="+encodeURIComponent(argus[k]);
                params += (params?"&":"?")+k+"="+(argus[k]);
            }
        }

        // 우선 코딩만해놓음 확인 나중에 확인.
        if ( o.form ) {
            var aparams = Form.queryString( o.form );
            params += '&'+aparams;
        }
    } else if ( requestType == "json" ) {
        params += params?"&":"";
        params += "p_tmp=";
        params += "&request_type=" + o.requestType;

        // 우선 코딩만해놓음 확인 나중에 확인.
        if ( o.form ) {
            var aArgus = Form.jsonData( o.form );
//          if ( aArgus ) argus.merge(aArgus);
            if ( aArgus ) argus = json_merge( argus, aArgus );
        }

        var data = {
                className  : className,
                argus      : argus
        };
//log(["o.infor.argus: ", o.infor.argus]);

//log ( data );
//log ( [ "JSON.stringify(data)", JSON.stringify(data)]);
        params += "&softm_json_data=" + encodeURIComponent(JSON.stringify(data));

    } else if ( requestType == "form" || requestType == "form.file" ) {
        //alert(o.form);
//        alert("requestType : " + requestType);
        if ( requestType == "form" && !o.form ) {
            var frm = $N('_softm_form')[0];
            if (frm) document.body.removeChild(frm);
            var frm = $C("form");
            frm.name = "_softm_form";
            frm.method = "POST";
            document.body.appendChild(frm);
            o.form = frm;
            o.form.style.position = "absolute";
            o.form.style.top= "10px";
            o.form.style.left = "10px";
        } else if ( !o.form ) throw new Error('form 정보가 없습니다.'  );

        IframeSubmit.init();
//        o.form.appendChild(Create.hidden({name:'p_hash',value:p_hash}));
        o.form.appendChild(Create.hidden({name:'request_type',value:o.requestType}));
        o.form.appendChild(Create.hidden({name:'className',value:className}));
//        o.form.appendChild(Create.hidden({name:'method',value:methodName}));

        if ( argus instanceof Object ) {
            var prototype = argus.constructor.prototype;
            for ( var k in argus ) {
                if (k in prototype) continue;
                if (argus instanceof Array ) continue;
//                    o.form.appendChild(Create.textBox({name:k,value:encodeURIComponent(argus[k]})));
                o.form.appendChild(Create.hidden({name:k,value:argus[k]}));
            }
        }

        if ( params ) {
            paramsInfo = params.split("&");
            var size = paramsInfo.length;
            for (var i = 0; i < size; i++) {
                var pInfo = paramsInfo[i].split("=");
                o.form.appendChild(Create.hidden({name:pInfo[0],value:pInfo.length>1?pInfo[1]:''}));
            }
        }
        //console.debug(o.form);
        //Form.queryString(GRID[tId].form);

    }

//log("params: " + params );
//    if ( $('#_info').get(0) ) $('#_info').get(0).innerHTML += "<BR><textarea type=text onclick='this.select();' style='height:100px;'>" + filePath + "\n" + method + "\n" + params +"</textarea>";
        if ( AJAX_DEBUG )
        {
            DEBUG_COPY_INDEX++;
            if ( Util.Browser.msie ) {
                $('#_info').get(0).innerHTML += "<div style='color:#0000ff'>--> callService <B><a href='" + url + "?" + params +"' target='_blank'>" + url + "?" + params + "</a></B>-> </div>";
//                $('#class_dir_copy' + DEBUG_COPY_INDEX).zclip({path:'/service/js/ZeroClipboard.swf',copy:function(){return 'file:///' + $(this).get(0).getAttribute("copy_data");}});
            } else {
                $('#_info').get(0).innerHTML += "<div style='color:#0000ff'>--> callService <B><a href='" + url + "?" + params + "' target='_blank'>" + url + "?" + params + "</a></B>-> </div>";
                //console.debug('--> callService /service/classes/' + className.replace(/\./g,'/') + '.php / ' + source);
            }
        }
//    console.debug( className, methodName, requestType, async );
    if ( requestType == "post" || requestType == "json" ) {
        $.ajax({
            type: 'POST',
            dataType: dataType,
            async: async,
            url: url,
            data: params,
            success: function(data) {
                var rtn ="";
//                alert(this.dataType);
                try {
                	if ( this.dataType=="xml" ) {
                		rtn = data.responseXML; 
                	} else if ( this.dataType=="json" ) {
                		rtn = data;                		
                	} else {
                        rtn = data.responseText;                		
                	}
//                    console.debug("data" , data);
                } catch (e) {
                    alert(e);
                }
                if (typeof(o) == 'object' && o.cb) o.cb(rtn);
            },
            complete: function(data) {
            },
            error: function(xhr, textStatus, thrownError) {
                //alert('Error!  Status = ' + xhr.status);
                //log(thrownError);
//                throw thrownError;
            }
        });
        
    } else if ( requestType == "form" || requestType == "form.file" ) {
        if ( requestType == "form" ) {
            IframeSubmit.setForm(o.form,url,o.cb);
        } else {
            IframeSubmit.setFormFile(o.form,url,o.cb);
        }
        IframeSubmit.submit();
    }
}

function call(requestType,className,argus,cb,form) {
    if ( requestType == 'JSON' ) {
    	callJSON(className,argus,cb);
    } else if ( requestType == 'POST' ) {
    	callPOST(className,argus,cb);
    } else if ( requestType == 'FORM' ) {
        callFORM(form,className,argus,cb);
    } else if ( requestType == 'FORM.FILE' ) {
//      alert(cb);
        callFORMFILE(form,className,argus,cb);
    }
}
function callPOST(className,argus,cb) {
    callService({
        requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        infor:{
           className  : className   ,
           //params     : tInfor.service_infor.params,
           argus      : argus
        },
        cb:cb,
        debug:false,
        contentType:"text/xml; charset=UTF-8"
    });
}

function callJSON(className,argus,cb) {
    callService({
        requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        dataType: 'json',
        infor:{
           className  : className   ,
           //params     : tInfor.service_infor.params,
           argus      : argus
        },
        cb:cb,
        debug:false,
        contentType:"text/xml; charset=UTF-8"
    });
}

function callFORM(form,className,argus,cb) {
    callService({
        requestType : 'FORM', // JSON, POST, FORM, FORM.FILE
        infor:{
           className  : className   ,
           //params     : tInfor.service_infor.params,
           argus      : argus
        },
        form:form,
        cb:cb,
        debug:false,
        contentType:"text/xml; charset=UTF-8"
    });
}

function callFORMFILE(form,className,argus,cb) {
    callService({
        requestType : 'FORM.FILE', // JSON, POST, FORM, FORM.FILE
        infor:{
            className  : className   ,
            //params     : tInfor.service_infor.params,
            argus      : argus
        },
        form:form,
        cb:cb,
        debug:false,
        contentType:"text/xml; charset=UTF-8"
    });
}

function callJSONSync(className,argus,cb) {
    callService({
        requestType : 'JSON', // JSON, POST, FORM, FORM.FILE
        async : false,
        infor:{
           className  : className   ,
           //params     : tInfor.service_infor.params,
           argus      : argus
        },
        cb:cb,
        debug:false,
        contentType:"text/xml; charset=UTF-8"
    });
}

function callJSONSyncToText(className,argus,cb) {
    callService({
        requestType : 'JSON', // JSON, POST, FORM, FORM.FILE
        dataType    : 'html' , // xml,html,script,json
        async : false,
        infor:{
           className  : className   ,
           //params     : tInfor.service_infor.params,
           argus      : argus
        },
        cb:cb,
        debug:false,
        contentType:"text/xml; charset=UTF-8"
    });
}


function callJSONSyncToJson(className,argus,cb) {
    callService({
        requestType : 'JSON', // JSON, POST, FORM, FORM.FILE
        dataType    : 'json' , // xml,html,script,json
        async : false,
        infor:{
           className  : className   ,
           //params     : tInfor.service_infor.params,
           argus      : argus
        },
        cb:cb,
        debug:false,
        contentType:"text/xml; charset=UTF-8"
    });
}

var json_merge = function (o,ob) {
    var t = {};
    for (var z in o ) { t[z] = o[z]; }
    for (var z in ob) {if (ob.hasOwnProperty(z)) {t[z] = ob[z];}}
    return t;
}
function json_clone(o) {
	  function c(o) {
	    for (var i in o) {
	      this[i] = o[i];
	    }
	  }
	  return new c(o);
};
var json_count = function (o) {
    var c = 0;
//    try {
        for ( var k in o ) c++;
//    } catch(e) {
//      alert(typeof(o));
//    }
    return c;
}
//Object.prototype.merge = (function (ob) {var o = this;var i = 0;for (var z in ob) {if (ob.hasOwnProperty(z)) {o[z] = ob[z];}}return o;})
//
//Object.prototype.count = function() {
//    var c = 0;
//    var prototype = this.constructor.prototype;
//    for ( var k in this ) {
//        if (k in prototype) continue;
//        if (this instanceof Array && isNaN(k)) continue;
//        c++;
//    }
//    return c;
//}

function toValue(v) {
    return v = (typeof v == 'object'?'':v);
}

function toArrayJson(jsonItem) {
    var items = typeof jsonItem == 'undefined'? new Array():jsonItem;
        items = typeof items.length == 'undefined'? new Array(items):items;
    return items;
}

function toJson(item) {
    var rtn = {};
    for ( var id in item ) {
        rtn[id] = toValue(item[id].value);
    }
    return rtn;
}

function enforceNumber(checkFloat) {
    if(window.event.type == "propertychange" ){
        if ( window.event.propertyName == "value" ) {
            var pattern = !checkFloat?/[^(0-9)]/g:/[^(0-9)(\.)]/;
            if(pattern.test(window.event.srcElement.value)){
                var v = window.event.srcElement.value.replace(pattern, "");
                window.event.srcElement.value = window.event.srcElement.value.replace(pattern, "");
            }
        }
    }
}

// Debug --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
function log() {
//if      ( window.console.log ) window.console.log (arguments instanceof Array?arguments:arguments[0]);
//else if ( console && console.debug ) console.debug(arguments instanceof Array?arguments:arguments[0]);
}
function deleteLog() {
    $('#_info').html("");
}
function handleError(err, url, line) {
    alert ( '오류 : ' + err + '\nURL : ' + url + '\nLine : ' + line);
    //log('오류 : ' + err + '\nURL : ' + url + '\nLine : ' + line);
    return true;
}
//window.onerror = handleError;
// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- Debug

var $ajax_load_area_id = "#contents";
$(function() {
  //var contextPath = "<%=request.getContextPath()%>";
  //var rootUrl     = "<%=request.getScheme() + "://" + request.getServerName() + (":"+request.getServerPort())%>";
  //alert(contextPath);
  $("<div id='viewLoading'><img src='/common/viewLoading.gif' /></div>")
  .insertAfter('#contents');

  // 페이지가 로딩될 때 'Loading 이미지'를 숨긴다.
  $('#viewLoading').hide();

  // ajax 실행 및 완료시 'Loading 이미지'의 동작을 컨트롤하자.
  $('#viewLoading')
  .ajaxStart(function()
  {
      if ( $ajax_load_area_id ) {
          //alert($ajax_load_area_id);
          // 로딩이미지의 위치 및 크기조절
          $(this).css('position', 'absolute');
          $(this).css('left', $($ajax_load_area_id).offset().left);
          $(this).css('top', $($ajax_load_area_id).offset().top);
          $(this).css('width', $($ajax_load_area_id).css('width'));
          $(this).css('height', $($ajax_load_area_id).css('height'));
          $(this).css('backgroundColor', "#FFFFF0");
          $(this).css('zIndex', "1");
          $(this).css('opacity', "0.6");
//          $(this).css('filter', "alpha(opacity=0.6)");
          $(this).css('textAlign', "center");
          $(this).css('padding-top', "70px");

          $(this).get(0).style.filter = "alpha(opacity=60)";
          $(this).get(0).style.opacity=0.6;
          $(this).show();
//          $(this).fadeIn(200);
      }
  })
  .ajaxStop(function()
  {
//      $(this).hide();
//      $(this).fadeOut(500);
//      $(this).hide();
      //window.setTimeout(function(){$('#viewLoading').fadeOut(500);},1000);
      window.setTimeout(function(){$('#viewLoading').hide();},1);
  })
  .ajaxComplete(function()
  {
//    $(this).fadeOut(500);
//    alert('');
//    $('#viewLoading').hide();
      window.setTimeout(function(){$('#viewLoading').hide();},1);
  })
  .ajaxError(function()
  {
      //alert("error");
      $(this).hide();
//      $(this).fadeOut(500);
  })
  .ajaxSend(function()
  {
  })
  .ajaxSuccess(function()
  {
//      $(this).hide();
  });
  //log($("body").css('width'));
//  $("<div id='log'></div>").insertBefore('body').css("position","absolute").css("zIndex","100").css("top","0px").css("left",700).css("display","none");
//  //console.debug(document.location);
//  var basePath = "D:\\WEB_APP\\JWAS\\java_doc\\GSnPointMApp_New\\WebContent";
//  var p = document.location.pathname;
//  //alert( p );
//  p = p.replace(contextPath,"");
//  p = p.replace(/\//g,"\\");
//  var u = basePath + p;
//  $("<input type=text>").appendTo($("#log")).attr("id","src_path").css("width",700).val(u).click(function(){ $(this).select()});
  //alert("x");
});
var ROOT_DIR = "D:/WEB_APP/eclipse_workspace/work/test/WebContent";
var SOFTMARGUMENT = {};
var PARAMETER_SURFIX="[]";
var DEBUG_COPY_INDEX=0;
var AJAX_DEBUG = true;