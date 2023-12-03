function $() {
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

function getElementsByClass(className)
{
	var classElements = new Array();
	var els = document.getElementsByTagName("*");
	var elsLen = els.length;
	var pattern = new RegExp("\\b" + className + "\\b");
	for (var i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}

function $N(n) {
  return typeof(n)=='object'?n:document.getElementsByName(n);

}

function $C(elType) {
  return document.createElement(elType);
}
function $CT(v) {
  return document.createTextNode(v);
}

function $L(el) {
    var rtn = el;
    while( el ) {
        if ( el.nodeType != 1 ) {
            break;
        } else {
            rtn = el;
            if ( rtn.tagName.toUpperCase().indexOf('SELECT') > -1 ) break;
            el = el.childNodes[0] ;
        }
    }
    return rtn;
}

function openWindow(sURL, dlgWidth, dlgHeight,winName,prop){
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
}

function isEmail(s) {
    return s.search(/^\s*[\w\~\-\.]+\@[\w\~\-]+(\.[\w\~\-]+)+\s*$/g)>=0;
}

function isDate(strDT)
{
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
}
function isArray(obj) {
   if (obj.constructor.toString().indexOf("Array") == -1)
      return false;
   else
      return true;
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

function imagePreview(path,previewer) {
    previewer.innerHTML = "";
    var W = previewer.offsetWidth;
    var H = previewer.offsetHeight;
    var tmpImage = new Image();
    previewer.appendChild(tmpImage);

    tmpImage.onerror = function () {
        alert("잘못된 이미지 입니다.");
        return previewer.innerHTML = "";
    }
    /**/
    tmpImage.onload = function () {
        if (this.width > W) {
            this.height = this.height / (this.width / W);
            this.width = W;
        }
        if (this.height > H) {
            this.width = this.width / (this.height / H);
            this.height = H;
        }
    }
    tmpImage.src = path;
    return false;
}

function toggleCheckBox(c,tName) {
    var v = c.checked;
    var cObj = document.getElementsByName(tName);
    var l = cObj.length;
    for( var i=0;i<l;i++) {
        if ( !cObj[i].disabled ) cObj[i].checked = v;
    }
}

function checkedValue ( o ) {
    var rtn = "";
    var l = o.length;
    for (var i=0; i<l;i++ ) {
        if ( o[i].checked ) {
            rtn = o[i].value;
            break;
        }
    }
    return rtn;
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
//b = b||true;
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

Object.prototype.merge = (function (ob) {var o = this;var i = 0;for (var z in ob) {if (ob.hasOwnProperty(z)) {o[z] = ob[z];}}return o;})

Object.prototype.count = function() {
    var c = 0;
    var prototype = this.constructor.prototype;
    for ( var k in this ) {
        if (k in prototype) continue;
        if (this instanceof Array && isNaN(k)) continue;
        c++;
    }
    return c;
}

var json_merge = function (o,ob) {
    var t = {};
    for (var z in o ) { t[z] = o[z]; }
    for (var z in ob) {if (ob.hasOwnProperty(z)) {t[z] = ob[z];}}
    return t;
}

if ( !document.all  ){
    HTMLElement.prototype.__defineGetter__("innerText", function() { return this.textContent; });
    HTMLElement.prototype.__defineSetter__("innerText", function(txt) { this.textContent = txt; });
    Array.prototype.__defineGetter__('isEmpty', function(){
      return (this.length === 0);
    });
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

var userAgent = navigator.userAgent.toLowerCase();
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
    isDomReady:function () {
        var dr = Util.domReady;
        if (dr.done) return false;
        if (document && document.getElementsByTagName && document.getElementById && document.body)
        {
            clearInterval(dr.timer);
            dr.timer = null;
            for (var i=0; i<dr.ready.length; i++) {
                dr.ready[i]();
            }
            dr.ready = null;
            dr.done = true;
        }
    },
    domReady:function (f){
        var dr = Util.domReady;

        if (dr.done) return f();
        if (dr.timer) {
            dr.ready.push(f);
        } else {
            dr.ready = [f];
            dr.timer = setInterval(Util.isDomReady,13);
        }
    },
    Cookie:{
         get:function( cookieName ) {

          var search = cookieName + "=";
          var cookie = document.cookie;

          if( cookie.length > 0 )
          {
           startIndex = cookie.indexOf( cookieName );

           if( startIndex != -1 )
           {
            startIndex += cookieName.length;
            endIndex = cookie.indexOf( ";", startIndex );
            if( endIndex == -1) endIndex = cookie.length;
            return unescape( cookie.substring( startIndex + 1, endIndex ) );
           }
           else
           {
            return false;
           }
          }
          else
          {
           return false;
          }
         },

         set:function( cookieName, cookieValue, expireDate )
         {
          var today = new Date();
          today.setDate( today.getDate() + parseInt( expireDate ) );
          document.cookie = cookieName + "=" + escape( cookieValue ) + "; path=/; expires=" + today.toGMTString() + ";"
         },
         del:function( cookieName )
         {
          var expireDate = new Date();
          expireDate.setDate( expireDate.getDate() - 1 );
          document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString() + "; path=/";
         }
    },
    Color:{
        /* @format (hex|rgb|null) : Format to return, default is integer */
        getRandom:function (format) {
            var rint = Math.round(0xffffff * Math.random());
            switch(format)
            {
            case 'hex':
            return ('#0' + rint.toString(16)).replace(/^#0([0-9a-f]{6})$/i, '#$1');
            break;

            case 'rgb':
            return 'rgb(' + (rint >> 16) + ',' + (rint >> 8 & 255) + ',' + (rint & 255) + ')';
            break;

            default:
            return rint;
            break;
            }
        }
    },
    Alert:{
        id:'alert_box',
        KEYDOWNCANCEL:true,
        setPrevent:function(o) {
            var id      = ( o && typeof(o.id      ) == 'string'  ?o.id       :Util.Alert.id  );
            UI.setPreventArea({id:'prevent_area'});
            UI.setCenter({element:id,baseElement:document.documentElement});
        },
        show:function(o) {
            var id      = ( o && typeof(o.id      ) == 'string'  ?o.id       :Util.Alert.id  );
            var msg     = ( o && typeof(o.message ) == 'string'  ?o.message  :''             );
            var okF     = ( o && typeof(o.ok      ) == 'function'?o.ok       :null           );
            var cancelF = ( o && typeof(o.cancel  ) == 'function'?o.cancel   :null           );
            var callback= ( o && typeof(o.callback) == 'function'?o.callback :null           );
            var keydowncancel = ( o && typeof(o.keydowncancel) == 'boolean'?o.keydowncancel:true);
            Alert.KEYDOWNCANCEL = keydowncancel;
            if ( $(id) ) {
                Alert.id = id;
                $(id).style.display = 'inline';
                $(id + '.message').innerHTML = msg;
            }
            if ( window.addEventListener ) {
                window.addEventListener('resize',Util.Alert.setPrevent,true);
                window.addEventListener('scroll',Util.Alert.setPrevent,true);
                window.addEventListener('keydown',Util.Alert.keyCheck,true);
            } else {
                window.attachEvent('onresize',Util.Alert.setPrevent);
                window.attachEvent('onscroll',Util.Alert.setPrevent);
                window.attachEvent('onkeydown',Util.Alert.keyCheck);
            }
            UI.setPreventArea({id:'prevent_area',opacity:0.15});
            UI.setCenter({element:id,baseElement:document.documentElement});

            if ( cancelF ) $(id + '.cancel').attachEvent('onclick', cancelF);

            if ($(id + '.cancel')) {
                $(id + '.cancel').focus();
                $(id + '.cancel').onclick = function() { Util.Alert.hide({id:id}); if (cancelF) cancelF()};
            }

            if ($(id + '.ok')) {
                $(id + '.ok').focus();
                $(id + '.ok').onclick = function() { Util.Alert.hide({id:id}); if (okF) okF()};
            }
            try { if ( callback ) callback(); } catch (e) {} finally {};

            return Util.Alert;
        },
        keyCheck:function(e,keydowncancel) {
            var code = window.event?window.event.keyCode:e.keyCode;
            /*
                enter : 13
                esc   : 27
            */
            if ( code == 27 ) {
                if ( Alert.KEYDOWNCANCEL ) {
                    Util.Alert.hide();
                    if ( $(Alert.id + '.cancel') ) $(Alert.id + '.cancel').onclick();
                }
            } else if ( code == 13 ) {
                if ( $(Alert.id + '.ok') ) $(Alert.id + '.ok').onclick();
            }
            var o = window.event?e.srcElement:e.target;
            e.preventDefault();
        },
        hide:function(o) {
            var id      = ( o && typeof(o.id      ) == 'string'  ?o.id       :Util.Alert.id  );
            var callback= ( o && typeof(o.callback) == 'function'?o.callback :null           );
            $(id).style.display="none";
            UI.clearPreventArea({id:"prevent_area"});
            if ( window.removeEventListener) {
                window.removeEventListener('resize',Util.Alert.setPrevent,true);
                window.removeEventListener('scroll',Util.Alert.setPrevent,true);
                window.removeEventListener('keydown',Util.Alert.keyCheck,true);
            } else {
                window.detachEvent('onresize',Util.Alert.setPrevent);
                window.detachEvent('onscroll',Util.Alert.setPrevent);
                window.detachEvent('onkeydown',Util.Alert.keyCheck);
            }

            try { if ( callback ) callback(); } catch (e) {} finally {};
            return Util.Alert;
        }
    },
    Form:{
        nextGo:true,
        tmpval:null,
        autoNextElement:function(f,t,l,e) {
            var keycode = window.event?window.event.keyCode:e.keyCode;
            var filter  = window.event? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
            f = $(f);
            var v = f.value;
            if (v.length == l && !containsElement(filter,keycode)) {
                if ( this.nextGo || tmpval != v ) {
                    tmpval = v;
                    this.nextGo = false;
                    $(t).focus();
                }
                return true;
            }
            this.nextGo = true;

            function containsElement(arr, ele) {
                var found = false, index = 0;
                while(!found && index < arr.length)
                if(arr[index] == ele)
                found = true;
                else
                index++;
                return found;
            }

        },
        numeberOnly:function(e,checkFloat) {
            var e = window.event?event:e;
            var o = window.event?e.srcElement:e.target;
            //console.debug(e.type);
            if (e.type == 'focus') {
                o.setAttribute('org_val',o.value);
                o.attachEvent('onchange',function(e,checkFloat) {
                    Form.numeberOnly(e,checkFloat);
                });
                o.attachEvent('onkeydown',function(e,checkFloat) {
                    Form.numeberOnly(e,checkFloat);
                });
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
            var pattern = !checkFloat?/[^(0-9)]/g:/[^(0-9)(\.)]/;
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
        queryString:function(f) {
            var q = '';
            var c = f.elements.length;
            var q = '';
            var preEName = '';
            for (var i = 0; i < c; i++) {
                var fe = f.elements[i];
                if ( fe.type == 'radio' || fe.type == 'checkbox' ) {
                    if(fe.checked) {
                        //console.debug(fe.name,lastEName,fe.value);
                        if(fe.name == preEName) {
                            if(q.lastIndexOf('&') == q.length - 1) {
                                q = q.substring(0, q.length - 1);
                            }
                            q += ',' + encodeURIComponent(fe.value);
                        }
                        else {
                            q += fe.name + '=' + encodeURIComponent(fe.value);
                        }
                        q += '&';
                        preEName = fe.name;
                    }
                } else if ( fe.type == 'text' || fe.type == 'select-one' || fe.type == 'hidden' || fe.type == 'password' || fe.type == 'textarea' ) {
                    q += fe.name + '=' + encodeURIComponent(fe.value) + '&';
                    preEName = "";
                }

                //console.debug(fe.name,"-",q);
            }
            return q;
        },
        removeParameterString:function(params,n) {
            //var params = "a=11111111111111&bccd=2&c=3";
            //var n = 'a';
          //var regexp = new RegExp("([\\?\\&]|^)"+n+"=[^&]*", "gi");
            var regexp = new RegExp("([\\?\\&]|^)"+n+"=[^&]*", "g");
            params = params.replace(regexp,"");
            return ( params.charAt(0) == '?' || params.charAt(0) == '&'?params.substring(1):params);
        },
        enableFileUploadButton:function() {
            Util.Load.script({src:JS_SERVER + "/service/common/css/image_file_attach.css",type:'css',callback:function(){}}); // file attach button image css

            var W3CDOM = (document.createElement && document.getElementsByTagName);

            if (!W3CDOM) return;
            var fakeFileUpload = document.createElement('div');
            //fakeFileUpload.style.backgroundColor = 'blue';
            fakeFileUpload.className = 'fakefile';
            var ip = document.createElement('input');
            ip.style.verticalAlign = 'middle';
            //ip.style.backgroundColor = 'red';
            //ip.style.width= '100px';

            fakeFileUpload.appendChild(ip);
            var image = document.createElement('img');
            image.align = 'absmiddle';
            image.src='/images/admin/btn_search.gif';
            fakeFileUpload.appendChild(image);
            var x = document.getElementsByTagName('input');
            for (var i=0;i<x.length;i++) {
                if (x[i].type != 'file') continue;
                if (x[i].parentNode.className != 'fileinputs') continue;
                x[i].className = 'file hidden';
                var clone = fakeFileUpload.cloneNode(true);
                x[i].parentNode.appendChild(clone);
                x[i].relatedElement = clone.getElementsByTagName('input')[0];
                x[i].onchange = x[i].onmouseout = function () {
                    this.relatedElement.value = this.value;
                }
            }
        }
    },

    Function:{
        lastCallerName: function(fObj) {
            var f = fObj;
            var rtn = null;
            while (f) {
              rtn = f.toString();
              f = f.caller;
            }
            return rtn;
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

    Timer:function(obj, limitMin) {
        this.timerRunning = false;
        this.timerID      = null;
        this.limitSec     = Number(limitMin) * 60;
        this.panel        = obj;
        this.startTime    = 0;
    },
    StopWatch:function(obj) {
        this.timerRunning = false
        this.timerID = null

        this.object = obj;
        this.initial = null;
        this.startTime= 0;
    },
    Clock:function(obj,setDate,format) {
/*
Using
window.onload = function() {
    var a = new Util.Clock($('test'),new Date(2001,10,10,10,10,10),'dddd, mmmm dS, yyyy, h:MM:ss TT');
    a.start();
}
*/
        this.timerRunning = false
        this.timerID = null

        this.object = obj;
        this.initial = null;
        this.startTime= 0;
        this.setTime= setDate?setDate.getTime():null;
        this.format= format?format:'HH:MM:ss';
    },
    xml2json:function(x) {
        var J = {
            parseAttr:function(xx,jo){
                if (xx) {
                    var ll = xx.length;
                    for (var ii=0; ii<ll;ii++ ) {
                        if (jo instanceof Array)
                            jo[jo.length-1][xx[ii].nodeName] = xx[ii].nodeValue;
                        else
                            jo[xx[ii].nodeName] = xx[ii].nodeValue;
                    }
                }
                return jo;
            },
            parse: function(x) {
                /* 하위노드가 텍스트인경우 상위노드의 Attribute를 무시함...  */
                var json = {};

                if (x.nodeType==9) { /* document.node */
                    /*json = J.parse(x.getElementsByTagName(x.documentElement.tagName)); */
                    json = J.parse(x.documentElement);
                } else if (x.nodeType==1) {   /* element node */
                    J.removeWhite(x);
                    for (var n=x.firstChild; n; n=n.nextSibling) {
                        var d = n.nodeName;
                        if (n.nodeType == 3)  /* text node */
                           json["#text"] = J.escape(n.nodeValue);
                        else if (n.nodeType == 4)  /* cdata node */
                           json["#cdata"] = J.escape(n.nodeValue);
                        else if ( json[d] ) {
                           if (json[d] instanceof Array) {
                               if (n.firstChild && ( n.firstChild.nodeType == 3 || n.firstChild.nodeType == 4 ) ) {
                                    json[d][json[d].length] = n.firstChild.nodeValue;
                               } else {
                                    json[d][json[d].length] = J.parse(n);
                               }
                           } else {
                               if (n.firstChild && ( n.firstChild.nodeType == 3 || n.firstChild.nodeType == 4 ) ) {
                                    json[d] = [json[d], n.firstChild.nodeValue];
                               } else {
                                    json[d] = [json[d], J.parse(n)];
                               }
                           }
                        } else {
                           if (n.firstChild && ( n.firstChild.nodeType == 3 || n.firstChild.nodeType == 4 ) ) {
                                json[d] = n.firstChild.nodeValue;
                           } else {
                                json[d] = J.parse(n);
                           }
                        }

                        var xx = n.attributes;
                        if (xx) {
                            var ll = xx.length;
                            for (var ii=0; ii<ll;ii++ ) {
                                if (json[d] instanceof Array)
                                    json[d][json[d].length-1][xx[ii].nodeName] = xx[ii].nodeValue;
                                else
                                    json[d][xx[ii].nodeName] = xx[ii].nodeValue;
                            }
                        }
                    }
                }
                return json;
            },
            escape: function(txt) {
                return txt.replace(/[\\]/g, "\\\\")
                       .replace(/[\"]/g, '\\"')
                       .replace(/[\n]/g, '\\n')
                       .replace(/[\r]/g, '\\r');
            },
          removeWhite: function(e) {
             e.normalize();
             for (var n = e.firstChild; n; ) {
                if (n.nodeType == 3) {  /* text node */
                   if (!n.nodeValue.match(/[^ \f\n\r\t\v]/)) { /* pure whitespace text node */
                      var nxt = n.nextSibling;
                      e.removeChild(n);
                      n = nxt;
                   }
                   else
                      n = n.nextSibling;
                }
                else if (n.nodeType == 1) {  /* element node */
                   J.removeWhite(n);
                   n = n.nextSibling;
                }
                else                      /* any other node */
                   n = n.nextSibling;
             }
             return e;
          }
        };

        return J.parse(x);
    }
};

var _uttimer = Util.Timer.prototype;

_uttimer.start = function(){
    this.stopTimer();
    this.startTime = (new Date()).getTime();
    this.showTimer();
}

_uttimer.stop = function(){
    this.stopTimer();
}

_uttimer.stopTimer = function(){
    if (this.timerRunning){
        clearTimeout(this.timerID);
    }
    this.timerRunning = false;
}

_uttimer.timeout = function(handler,delay){
    var self=this;
    var wrapper=function(){
        handler.call(self)
    };
    return window.setTimeout(wrapper,delay?delay:0)
}

_uttimer.showTimer = function(){
    var current = new Date();
    var curTime = current.getTime();
    var interval_in_milliSec = curTime - this.startTime;
    var interval_in_sec = interval_in_milliSec/1000;
    var counter_in_sec  = this.limitSec - interval_in_sec;

    var h = Math.floor(   counter_in_sec/3600              );
    var m = Math.floor( ( counter_in_sec - h*3600 ) / 60   );
    var s = Math.floor(   counter_in_sec - h*3600 - m*60   );
    var hh = (''+h).padLeft('0',2);
    var mm = (''+m).padLeft('0',2);
    var ss = (''+s).padLeft('0',2);

    this.panel.innerText = hh + ":" + mm + ":" + ss;

    if( h == 0 && m == 0 && s == 0 ){
        this.stop();
        this.overtimeHandler();
    }
    else{
        var thisObj = this;
        this.timerID = this.timeout( function(){thisObj.showTimer()}, 1000);
        this.timerRunning = true;
    }
}
var _utstopwatch = Util.StopWatch.prototype;
_utstopwatch.start = function(){
    this.initial = new Date();
    this.startTime = this.initial.getTime();
    this.stopTimer();
    this.showTimer();
}

_utstopwatch.stop = function(){
  this.stopTimer();
}
_utstopwatch.stop = function(){
    if (this.timerRunning) clearTimeout(this.timerID);
    this.timerRunning = false;
}

_utstopwatch.stopTimer = function(){
    if (this.timerRunning){
        clearTimeout(this.timerID);
    }
    this.timerRunning = false;
}

_utstopwatch.timeout = function(handler,delay){
    var self=this;
    var wrapper=function(){
        handler.call(self)
    };
    return window.setTimeout(wrapper,delay?delay:0)
}

_utstopwatch.showTimer = function(){
    var current = new Date();
    var curTime = current.getTime();
    var dif = curTime - this.startTime;
    var result = dif/1000;
    var hh = "00";
    var mi = "00";
    var ss = "00";

    var h = Math.floor( result/3600              );
    var m = Math.floor( (result - hh*3600) / 60  );
    var s = Math.floor( result - hh*3600 - mi*60 );

    var hh = (''+h).padLeft('0',2);
    var mm = (''+m).padLeft('0',2);
    var ss = (''+s).padLeft('0',2);

    this.object.innerText = hh + ":" + mi + ":" + ss;
    var thisObj = this;
    this.timerID = this.timeout(function() {thisObj.showTimer()}, 1000);
    this.timerRunning=true;
}

var _utclock = Util.Clock.prototype;

_utclock.start = function(){
    this.initial = new Date();
    this.startTime = this.initial.getTime();
    this.stopTimer();
    this.showTimer();
}

_utclock.stop = function(){
  this.stopTimer();
}
_utclock.stop = function(){
    if (this.timerRunning) clearTimeout(this.timerID);
    this.timerRunning = false;
}

_utclock.stopTimer = function(){
    if (this.timerRunning){
        clearTimeout(this.timerID);
    }
    this.timerRunning = false;
}

_utclock.timeout = function(handler,delay){
    var self=this;
    var wrapper=function(){
        handler.call(self)
    };
    return window.setTimeout(wrapper,delay?delay:0)
}

_utclock.showTimer = function(){
    var curTime = (new Date()).getTime();
    var dif = curTime - this.startTime;
    var current = this.setTime?new Date(this.setTime+dif):new Date();

    var h = current.getHours();
    var m = current.getMinutes();
    var s = current.getSeconds();

    var hh = (''+h).padLeft('0',2);
    var mi = (''+m).padLeft('0',2);
    var ss = (''+s).padLeft('0',2);
    this.object.innerText = current.format(this.format);
    var thisObj = this;
    this.timerID = this.timeout(function() {thisObj.showTimer()}, 1000);
    this.timerRunning=true;
}


var UI = {
    setCenter:function(o){
        var e = $(o.element     );
        var b = $(o.baseElement );
        if ( b.offsetWidth > 0 ) {
            var _t = b.offsetTop + b.clientTop  ;
            var _l = b.offsetLeft + b.clientLeft;
            var _w = b.clientWidth ;
            var _h = b.clientHeight;
            var rT = ((_h - e.offsetHeight) / 2) + b.scrollTop  + b.offsetTop  + document.body.style.borderTop + document.body.style.paddingTop ;
            var rL = ((_w - e.offsetWidth ) / 2) + b.scrollLeft + b.offsetLeft + document.body.style.borderLeft+ document.body.style.paddingLeft;
            e.style.top  = rT+'px';
            e.style.left = rL+'px';
        }
        return Util.Alert;
    },

    setPreventArea:function(o){
        var id      = ( o && typeof(o.id        ) == 'string'?o.id      :'prevent_area');
        var e = $(id);
        if ( !e ) {
            e = $C('DIV');
            e.id            = id;
            e.style.zIndex  = 1;
            document.body.appendChild(e);
        } else {
            e.style.zIndex    = 1;
            e.style.display  = 'inline';
        }

        if ( o && typeof(o.opacity ) == 'number') e.style.opacity = o.opacity;
        var d = document.documentElement;
        var w = d.scrollWidth ;
        var h = d.scrollHeight>=d.clientHeight?d.scrollHeight:d.clientHeight;
        $(id).style.width  = (w) +'px';
        $(id).style.height = (h) +'px';
    },
    clearPreventArea:function(o){
        var id  = ( o && typeof(o.id      ) == 'string'?o.id     :'prevent_area');
        var e = $(id);
        if ( e ) {
            e.style.display = 'none';
            document.body.removeChild(e);
        }
    },
    OLDBANNER_HEIGHTS:new Object(),
    scrollBanner:function(o){
        var e = $(o);
        if ( e ) {
            var oldhe = parseInt(e.style.top,10) ;
            UI.OLDBANNER_HEIGHTS[e.id] = UI.OLDBANNER_HEIGHTS[e.id]?this.OLDBANNER_HEIGHTS[e.id]:oldhe; /* orghe =*/
            var a = setInterval(function () {
                var he = parseInt(Math.max(document.documentElement.scrollTop,document.body.scrollTop),10) ;
                var sethe = (he - oldhe)/10 ;   /* 옆의 /숫자가 무빙 스피드 */
                e.style.top= ( oldhe + sethe + UI.OLDBANNER_HEIGHTS[e.id] ) + 'px';
                oldhe = oldhe + sethe ;
            },10);
        }
    },

    Loading:{
        display:function(src,ty,tg) {
            this.id         = 'loading_' + (Math.floor(Math.random() * 1000) + 1);
            this.width      = '';
            this.height     = '';
            this.src        = src?src:'';
            this.type       = ty?ty:'image';
            this.target     = tg?tg:document.documentElement;
            var info = this.src.split('.');
            this.file_type  = info.length>0?this.src.split('.')[info.length-1].toLowerCase():'';
            this.print();
        }
    },
/*
# using
    <span id=ttt style="position:absolute;top:100px;left:100px">
    <script>ProgressBar.display ('element1',10.5,1);</script>
    </span>
*/
    /* WebAppers Progress Bar, version 0.2
    * (c) 2007 Ray Cheung
    *
    * WebAppers Progress Bar is freely distributable under the terms of an Creative Commons license.
    * For details, see the WebAppers web site: http://wwww.Webappers.com/
    *
    /*--------------------------------------------------------------------------*/
    ProgressBar:{
        initial:-120,
        imageWidth:240,
        eachPercent:0,
        setText:function(id, percent) {
            $(id+'Text').innerHTML = percent+"%";
        },
        display:function( id, percentage,color ) {
            if (typeof color == "undefined") {
            color = "1";
            }
            this.eachPercent = (this.imageWidth/2)/100;
            var percentageWidth = this.eachPercent * percentage;
            var actualWidth = this.initial + percentageWidth   ;

            document.write('<img id="'+id+'" src="/service/common/js/progressbar/images/percentImage.png" alt="'+percentage+'%" class="percentImage'+color+'" style="display:inline;background-position: '+actualWidth+'px 0pt;"/> <span id="'+id+'Text">'+percentage+'%</span>');
        },
        emptyProgress:function(id) {
            var newProgress = this.initial+'px';
            $(id).style.backgroundPosition=newProgress+' 0';
            this.setText(id,'0');
        },
        getProgress:function(id) {
            var nowWidth = $(id).style.backgroundPosition.split("px");
            return (Math.floor(100+(nowWidth[0]/this.eachPercent))+'%');
        },
        setProgress:function(id, percentage) {
            var percentageWidth = this.eachPercent * percentage;
            var newProgress = eval(this.initial)+eval(percentageWidth)+'px';
            $(id).style.backgroundPosition=newProgress+' 0';
            this.setText(id,percentage);
        },
        plus:function(id, percentage ) {
            var nowWidth = $(id).style.backgroundPosition.split("px");
            var nowPercent = Math.floor(100+(nowWidth[0]/this.eachPercent))+eval(percentage);
            var percentageWidth = this.eachPercent * percentage;
            var actualWidth = eval(nowWidth[0]) + eval(percentageWidth);
            var newProgress = actualWidth+'px';
            if(actualWidth>=0 && percentage <100)
            {
                var newProgress = 1+'px';
                $(id).style.backgroundPosition=newProgress+' 0';
                this.setText(id,100);
                alert('full');
            }
            else
            {
                $(id).style.backgroundPosition=newProgress+' 0';
                this.setText(id,nowPercent);
            }
        },
        minus:function(id, percentage ) {
            var nowWidth = $(id).style.backgroundPosition.split("px");
            var nowPercent = Math.floor(100+(nowWidth[0]/this.eachPercent))-eval(percentage);
            var percentageWidth = this.eachPercent * percentage;
            var actualWidth = eval(nowWidth[0]) - eval(percentageWidth);
            var newProgress = actualWidth+'px';
            if(actualWidth<=-120)
            {
                var newProgress = -120+'px';
                $(id).style.backgroundPosition=newProgress+' 0';
                this.setText(id,0);
                alert('empty');
            }
            else
            {
                $(id).style.backgroundPosition=newProgress+' 0';
                this.setText(id,nowPercent);
            }
        },
        fillProgress:function(id, endPercent) {
            var nowWidth = $(id).style.backgroundPosition.split("px");
            startPercent = Math.ceil(100+(nowWidth[0]/this.eachPercent))+1;
            var actualWidth = this.initial + (this.eachPercent * endPercent);
            if (startPercent <= endPercent && nowWidth[0] <= actualWidth)
            {
                this.plus(id,'1');
                this.setText(id,startPercent);

                var thisObj = this;
                setTimeout(function() { thisObj.fillProgress(id,endPercent)},10);
            }
        }
    }
}
var _uild = UI.Loading.display.prototype;
_uild.print = function(){
    var attrStr = "id='" + this.id + "' style='position:absolute" + (this.width?';width:'+this.width:'') + "" + (this.height?';height:'+this.height:'') + ";left:0;top:0;display:none;border:0px;z-index:10;'";
    if (this.type == 'swf') {
        if (document.all) {
            document.write( "<OBJECT " + attrStr + ""
                            +" classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' WIDTH='" + this.width + "' HEIGHT='" + this.height + "'>"
                            +"  <PARAM NAME=movie   VALUE='" + this.src + "'>"
                            +"  <PARAM NAME=quality VALUE=high>"
                            +"  <PARAM NAME=bgcolor VALUE=red>"
                            +"  <PARAM NAME='wmode' value='transparent'>"
                            +"</OBJECT>");
        } else {
            document.write( "<EMBED " + attrStr + " src='" + this.src + "' "
                            +" quality=high bgcolor=#FFFFFF wmode=transparent "
                            +"WIDTH='" + this.width + "' HEIGHT='" + this.height + "' ALIGN='middle' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'></EMBED>"
                            );
        }
    } else if (this.type == 'image' ) {
        document.write( "<img " + attrStr + " src='" + this.src + "'>");
    } else if (this.type == 'html' ) {
        document.write( "<span " + attrStr + ">" + this.src + "</span>");
    }
}

_uild.show = function(to){
    var o = typeof(to)=='object'?to:$(to);
    if (o) this.setTarget(o);
    $(this.id).style.display = '';
    $(this.id).style.zIndex = 1000;
}

_uild.hide = function(){
    $(this.id).style.display = 'none';
}

_uild.setSize = function(w, h){
    this.width  = w;
    this.height = h;
    $(this.id).style.width  = w;
    $(this.id).style.height = h;
    this.setTarget(this.target);
}

_uild.setPos = function(x, y){
    if ( x ) $(this.id).style.left  = x;
    if ( y ) $(this.id).style.top   = y;
}

_uild.setTarget = function(to){
    var o = typeof(to)=='object'?to:$(to);
    this.target = o;
    var o = typeof(to)=='object'?to:document.getElementById(to);
    this.target = o;
    var l = document.getElementById(this.id);

    var _t = o.offsetTop + o.clientTop  ;
    var _l = o.offsetLeft + o.clientLeft;
    var _w = o.offsetWidth > 0?o.offsetWidth:document.body.offsetWidth;
    var _h = o.offsetHeight;

    var rT = ((_h - l.offsetHeight) / 2) + o.offsetTop  + document.body.style.borderTop + document.body.style.paddingTop ;
    var rL = ((_w - l.offsetWidth ) / 2) + o.offsetLeft + document.body.style.borderLeft+ document.body.style.paddingLeft;
    l.style.top  = rT+'px';
    l.style.left = rL+'px';
}

var Effect= {
    TWINKLE_INTERVAL:150,
    TWINKLE_OBJECT:{},
    DEFAULT_INFO:{cssText:'background-color:#BFE2FF;border:1px dotted #99CCCC;color:black',during:700,interval_time:150,callback:function(){}},
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
    twinkle:function(o,i) {
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
        //console.debug(oId);
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
            //console.debug(eFo);
            if ( !eFo.playing ) {
                eFo.playing = true;
                function start(eFo) {
                    //eFo = Effect.TWINKLE_OBJECT[oId];
                    //console.debug(eFo);
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
    }
}

var EVENT= {
    eventArray:{},
    attach:{
        reset:function() {
            EVENT.eventArray = {};
        },
        add:function(o,eventType,object,direct) {
            direct = !!direct;
            var k = o.id;
            if (k) {
                if (!EVENT.eventArray[k] ) {
                    EVENT.eventArray[k]= {};
                }
                eventType = eventType.replace(/on/, "").toLowerCase();
                if (!EVENT.eventArray[k][eventType] ) {
                    EVENT.eventArray[k][eventType]= new Array();
                }
                EVENT.eventArray[k][eventType].push(object);
            } else {
                alert('Object Unique ID Exception!');
            }
        },
        exec:function() {
            for (k in EVENT.eventArray) {
                for (t in EVENT.eventArray[k]) {
                    if ( $(k) ) {
                        if (t) {
                            $(k).attachEvent('on'+t,this.call);
                        }
                    }
                }
            }
        },
        call:function(e) {
            var o = window.event?e.srcElement:e.target;
            var k = o.id;
            if (k) {
                    if ( EVENT.eventArray[k] ) {
                        if (EVENT.eventArray[k][e.type]) {
                        var l = EVENT.eventArray[k][e.type].length;
                        for (var i=0; i<l; i++) {
                            EVENT.eventArray[k][e.type][i](e);
                        }

                    }
                }
            }
        }
    }
};

/* prototype.js */
/*  Prototype JavaScript framework, version 1.6.1
 *  (c) 2005-2009 Sam Stephenson
 *
 *  Prototype is freely distributable under the terms of an MIT-style license.
 *  For details, see the Prototype web site: http://www.prototypejs.org/
 *
 *--------------------------------------------------------------------------*/
(function() {

  var _toString = Object.prototype.toString;

  function extend(destination, source) {
    for (var property in source)
      destination[property] = source[property];
    return destination;
  }

  function inspect(object) {
    try {
      if (isUndefined(object)) return 'undefined';
      if (object === null) return 'null';
      return object.inspect ? object.inspect() : String(object);
    } catch (e) {
      if (e instanceof RangeError) return '...';
      throw e;
    }
  }

  function toJSON(object) {
    var type = typeof object;
    switch (type) {
      case 'undefined':
      case 'function':
      case 'unknown': return;
      case 'boolean': return object.toString();
    }

    if (object === null) return 'null';
    if (object.toJSON) return object.toJSON();
    if (isElement(object)) return;

    var results = [];
    for (var property in object) {
      var value = toJSON(object[property]);
      if (!isUndefined(value))
        results.push(property.toJSON() + ': ' + value);
    }

    return '{' + results.join(', ') + '}';
  }

  function toQueryString(object) {
    return $H(object).toQueryString();
  }

  function toHTML(object) {
    return object && object.toHTML ? object.toHTML() : String.interpret(object);
  }

  function keys(object) {
    var results = [];
    for (var property in object)
      results.push(property);
    return results;
  }

  function values(object) {
    var results = [];
    for (var property in object)
      results.push(object[property]);
    return results;
  }

  function clone(object) {
    return extend({ }, object);
  }

  function isElement(object) {
    return !!(object && object.nodeType == 1);
  }

  function isArray(object) {
    return _toString.call(object) == "[object Array]";
  }


  function isHash(object) {
    return object instanceof Hash;
  }

  function isFunction(object) {
    return typeof object === "function";
  }

  function isString(object) {
    return _toString.call(object) == "[object String]";
  }

  function isNumber(object) {
    return _toString.call(object) == "[object Number]";
  }

  function isUndefined(object) {
    return typeof object === "undefined";
  }

    function d2h(d) {return d.toString(16);}
    function h2d(h) {return parseInt(h,16);}
    function js_xor(a,b){return (a|b) & ~(a&b)}

  extend(Object, {
    extend:        extend,
    inspect:       inspect,
    toJSON:        toJSON,
    toQueryString: toQueryString,
    toHTML:        toHTML,
    keys:          keys,
    values:        values,
    clone:         clone,
    isElement:     isElement,
    isArray:       isArray,
    isHash:        isHash,
    isFunction:    isFunction,
    isString:      isString,
    isNumber:      isNumber,
    isUndefined:   isUndefined,
    d2h:   d2h,
    h2d:   h2d,
    js_xor:   js_xor
  });
})();

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

/*
CSS Browser Selector v0.3.4 (Sep 29, 2009)
Rafael Lima (http://rafael.adm.br)
http://rafael.adm.br/css_browser_selector
License: http://creativecommons.org/licenses/by/2.5/
Contributors: http://rafael.adm.br/css_browser_selector#contributors
*/
function css_browser_selector(u){var ua = u.toLowerCase(),is=function(t){return ua.indexOf(t)>-1;},g='gecko',w='webkit',s='safari',o='opera',h=document.getElementsByTagName('html')[0],b=[(!(/opera|webtv/i.test(ua))&&/msie\s(\d)/.test(ua))?('ie ie'+RegExp.$1):is('firefox/2')?g+' ff2':is('firefox/3.5')?g+' ff3 ff3_5':is('firefox/3')?g+' ff3':is('gecko/')?g:is('opera')?o+(/version\/(\d+)/.test(ua)?' '+o+RegExp.$1:(/opera(\s|\/)(\d+)/.test(ua)?' '+o+RegExp.$2:'')):is('konqueror')?'konqueror':is('chrome')?w+' chrome':is('iron')?w+' iron':is('applewebkit/')?w+' '+s+(/version\/(\d+)/.test(ua)?' '+s+RegExp.$1:''):is('mozilla/')?g:'',is('j2me')?'mobile':is('iphone')?'iphone':is('ipod')?'ipod':is('mac')?'mac':is('darwin')?'mac':is('webtv')?'webtv':is('win')?'win':is('freebsd')?'freebsd':(is('x11')||is('linux'))?'linux':'','js']; c = b.join(' '); h.className += ' '+c; return c;}; css_browser_selector(navigator.userAgent);

var Alert = Util.Alert;
var Form  = Util.Form;
var ProgressBar = UI.ProgressBar;

function ARRAYITEM(k,v){
    this.value = k;
    this.text  = v;
}

var GRID = {
    infor:{},
    sort:{},
    dubleTrans:false,
    init:function(o) { /* table:tbl,onedit:'onfocus' */
        var tId = o.table.id;
        if ( tId ) {
            this.infor[tId] = o;
            if ( typeof this.infor[tId].message == 'undefined' ) this.infor[tId].message={};
            if ( typeof this.infor[tId].code == 'undefined' ) this.infor[tId].code={};
            if ( typeof this.infor[tId].cell == 'undefined' ) this.infor[tId].cell={};
            if ( typeof this.infor[tId].cell.color == 'undefined' ) this.infor[tId].cell.color={};
            if ( typeof this.infor[tId].cell.active == 'undefined' ) this.infor[tId].cell.active={};
            if ( typeof this.infor[tId].cell.active.cssText == 'undefined' ) this.infor[tId].cell.active.cssText={};

            if ( typeof this.infor[tId].row == 'undefined' ) this.infor[tId].row={};
            if ( typeof this.infor[tId].row.active == 'undefined' ) this.infor[tId].row.active={};
            if ( typeof this.infor[tId].row.active.cssText == 'undefined' ) this.infor[tId].row.active.cssText={};

            this.infor[tId].cell.color.save   = (o.cell.color.active?o.cell.color.save  :'#996699');
            this.infor[tId].cell.active.cssText = (o.cell.active.cssText?o.cell.active.cssText:'background-color:#E8E8FF;color:#000000');

            this.infor[tId].row.active.cssText = (o.row.active.cssText?o.row.active.cssText:'background-color:LightSteelBlue;color:#000000');

            this.infor[tId].message['delete'] = (o.message['delete']?o.message['delete']:'Want to delete it?');
            this.infor[tId].message['insert'] = (o.message['insert']?o.message['insert']:'Want to insert it?');

            return true;
        } else {
            alert('id attribute must be assign to table');
            return false;
        }
    },
    bind:function(o) { /* o:table, o.data, o.start */
        var url = _url;
        var tbl = $(o.table);
        var items = o.data;
        var tId = tbl.id;
        var th = tbl.tHead     ;
        var tb = tbl.tBodies[0];
        var tf = tbl.tFoot     ;

        var r=null;
        var c=null;
        GRID.clearBody({table:tbl}); /* clear table */
        GRID.clearFoot({table:tbl}); /* clear table */
        var rows = new Array();
        var l = items.length;
        for (var i=0; i<l;i++ ) {
            r=tb.insertRow(-1);
            r.style.cursor='pointer';
            r.style.height='20px';
            var rIdx = r.rowIndex;
            c =null;
            var ll = GRID.infor[tId].fields.count();
            var prototype = GRID.infor[tId].fields.constructor.prototype;
            for ( var j in GRID.infor[tId].fields ) {
                if (j in prototype) continue;
                if (GRID.infor[tId].fields instanceof Array && isNaN(n)) continue;
                var v = items[i][j].value;
                    v = (typeof v == 'object'?'':v);
                var n = items[i][j].isnull;
                var t = GRID.infor[tId].fields[j].type + '';
                if ( t == 'TEXT' ) {
                    c = GRID.row.addCell({row:r,value:v,updatable:GRID.infor[tId].fields[j].updatable,cssText:GRID.infor[tId].fields[j].cssText,isnull:n,status:'U'});
                    c.setAttribute('data',v);
                } else if ( t == 'SELECT' ) {
                    if ( o.code[j][v] ) {
                        c = GRID.row.addCell({row:r,value:o.code[j][v],updatable:GRID.infor[tId].fields[j].updatable,cssText:GRID.infor[tId].fields[j].cssText,isnull:n,status:'U'});
                    } else {
                        c = GRID.row.addCell({row:r,value:v,updatable:GRID.infor[tId].fields[j].updatable,cssText:GRID.infor[tId].fields[j].cssText,isnull:n,status:'U'});
                    }
                    c.setAttribute('data',v);
                } else {
                    var err = new Error();
                    err.name = 'My API Input Error';
                    err.message = 'Undefined fieldInfo type in php!';
                    alert('Undefined fieldInfo type!::>' + t);
                    throws(this);
                    break;
                }
            }
            c = GRID.row.addCell({row:r,value:'',updatable:false});
            rows.push(r);
        }
        return rows;
    },
    cancel:function(o) {
        var td = GRID.cell.getTd(o.td);
        var mode = o.mode;
        var tId = td.offsetParent.id;
        var cg = GRID.getColgroup($(tId));
        var fId = cg.childNodes[td.cellIndex].getAttribute('field_name');

        var orgText = td.childNodes[1]; /* org */
        if ( orgText ) {
            td.setAttribute('data',orgText.innerText);

            if ( mode == 'U') {
                var t = GRID.infor[tId].fields[fId].type;
                if ( t == 'TEXT' ) {
                    td.firstChild.nodeValue = orgText.innerText;
                } else if ( t == 'SELECT' ) {
                    td.firstChild.nodeValue = GRID.infor[tId].code[fId][orgText.innerText];
                }
                if ( Util.Browser.mozilla || Util.Browser.opera) {
                    if ( t == 'SELECT' ) {
                        td.focus();
                    } else {
                        td.focus();
                        /*td.previousSibling.focus();*/
                    }
                } else {
                    td.focus();
                }
            }
        }
    },
    save:function(o) { /* o.td,mode:'I',callback:function() */
        var ajaxR = new asyncConnector('xmlhttp');
        var mode = o.mode;
        var td = GRID.cell.getTd(o.td);

        var tId = td.offsetParent.id;
        var tbl = td.offsetParent;

        var cg = GRID.getColgroup($(tId));
        var fId = cg.childNodes[td.cellIndex].getAttribute('field_name');

        var url  = _url;
        var exec = true;
        if ( typeof GRID.infor[tId].onsubmit == 'function' ) {
            exec = GRID.infor[tId].onsubmit({tId:tId,td:td});
        }
        if ( exec ) {
            this.dubleTrans = true;
            if (loading) loading.show();
            this.infor[tId].cssText = td.style.cssText;/* cssText 보관 */
            td.style.backgroundColor = GRID.infor[tId].cell.color.save;
            var params = '&p_mode=' + mode
                       + '&' + GRID.getSaveParameter({td:td,fieldInfo:GRID.infor[tId].fields});
            ajaxR.openCallBack= function (str) {
                var xmlDoc=ajaxR.responseXML();
                var xml  = Util.xml2json(xmlDoc);
                if (loading) loading.hide();
                if (xml.status.code == 'SUCCESS') { /* success */
                    if ( mode == 'U' ) {
                        o    = td.firstChild;
                        orgO = td.childNodes[1]; /* o.nextSibling; */
                        td.removeChild(orgO);
                        td.setAttribute('isnull',0);
                        td.style.cssText = GRID.infor[tId].cssText;
                        td.focus();
                        if ( typeof GRID.infor[tId].callback.update == 'function' ) GRID.infor[tId].callback.update();
                    } else if ( mode == 'I' ) {
                        if ( typeof GRID.infor[tId].callback.insert == 'function' ) GRID.infor[tId].callback.insert();
                    } else if ( mode == 'D' ) {
                        if ( typeof GRID.infor[tId].callback['delete'] == 'function' ) GRID.infor[tId].callback['delete']();
                    }
                } else if (xml.status.code == 'ERROR') {
                    if ( mode == 'U' ) {
                        alert(xml.status.message); /* error */
                    } else if ( mode == 'I' ) {
                        alert(xml.status.message);
                        td.parentNode.cells[0].firstChild.focus();
                    }
                    this.cell.cancel({td:td,mode:mode});
                }
            }
            ajaxR.httpOpen('POST', url, true,params, null);
            this.dubleTrans = false;
        }
        return td.parentNode;
    },
    insertRow:function(o) { /* table:tId */
        var tbl = $(o.table);
        var tId = tbl.id;
        var th = tbl.tHead     ;
        var tb = tbl.tBodies[0];
        var tf = tbl.tFoot     ;

        var r=tb.insertRow(-1);
        var c =null;
        var rIdx = r.rowIndex;
        var l = GRID.infor[tId].fields.length;
        r.style.cursor='pointer';
        r.style.height='20px';
        var c=null;
        var prototype = GRID.infor[tId].fields.constructor.prototype;
        for ( var j in GRID.infor[tId].fields ) {
            if (j in prototype) continue;
            if (GRID.infor[tId].fields instanceof Array && isNaN(n)) continue;
            var c = GRID.row.addCell({row:r,value:'',updatable:true,status:'I',isnull:'1'});
            c.tabIndex = parseInt(r.rowIndex+''+c.cellIndex);
            c.setAttribute('data','');
        }
        var bt = $C('button');
        bt.innerText = 'save';
        c = GRID.row.addCell({row:r,value:'',updatable:false,status:'I'});
        c.style.verticalAlign = 'middle';
        c.appendChild(bt);

        bt.onclick = (function(r){
            return function(e){
                var mode = c.getAttribute('status');
                var msg = '';
                if      ( mode == 'I' ) msg = GRID.infor[tId].message['insert'];
                else if ( mode == 'U' ) msg = GRID.infor[tId].message['update'];
                if ( !msg || ( msg && confirm(msg) ) ){
                    GRID.save({td:c,mode:'I',table:tId});
                }
            };
        })(r);
        try { r.cells[0].focus(); } catch(e) {}
        return r;
    },
    row:{
        onActivate:function (e){
            try {
            if (e) {
                var r = e.type?(window.event?event.srcElement:e.target):e;
                var tId = r.offsetParent.id;
                var rObj = GRID.infor[tId].row;

                if ( rObj.sRow ) this.onDeactivate(rObj.sRow);
                if (r) {
                    rObj.cssTexts  = new Array();
                    rObj.cssTexts1 = new Array();
                    rObj.cssTexts2 = new Array();
                    rObj.sRow = r;
                    var hRL = !rObj.sRow.parentNode.parentNode.tHead?0:rObj.sRow.parentNode.parentNode.tHead.rows.length;
                    var rI = rObj.sRow.parentNode.rows[rObj.sRow.rowIndex-hRL];
                    var l = rI.cells.length;

                    for (var i=0; i<l; i++) {
                        var rCellStyle = rI.cells[i].style;
                        var rLStyle    = $L(rI.cells[i]).style;
                        var lastE = $L(rI.cells[i]);
                        rObj.cssTexts.push({object:$(rI.cells[i]),cssText:$(rI.cells[i]).style.cssText});
                        rObj.cssTexts.push({object:lastE,cssText:lastE.style.cssText});
                        var cellCssText = rObj.active.cssText.split(';');
                        for ( var j=0; j<cellCssText.length;j++) {
                            if ( cellCssText[j] ) {
                                var tmp = cellCssText[j].split(':');
                                var n = tmp[0].cssString();
                                var v = tmp[1].trim();
                                $(rI.cells[i]).style[n] = v;
                                if ( !( lastE.tagName == 'INPUT' && lastE.type=='text') && lastE.tagName.toUpperCase().indexOf('SELECT') == -1 ) {
                                    lastE.style[n] = v;
                                }
                            }
                        }
                    }
                }
            }
            }catch(e){
                console.debug(e);
            }
        },
        onDeactivate:function (r){
            var tId = r.offsetParent.id;
            var rObj = GRID.infor[tId].row;
            try
            {
                while(v = rObj.cssTexts.pop()) {
                    v.object.style.cssText = v.cssText;
                }
            }
            catch (e) {
            }
            this.sRow = null;
        },
        insertCell:function(r) {
            var c = null;
            if        ( r.parentNode.tagName == 'TBODY' || r.parentNode.tagName == 'TFOOT' ) {
                c = r.insertCell(-1);
            } else if ( r.parentNode.tagName == 'THEAD' ) {
                c = $C('th');
                r.appendChild(c);
            }
            return c;
        },
        addCell:function(o) { /* {row:r,value:l>0?xml.pagenavi.html:'Data not Found',updatable:false}*/
            var isnull   = typeof o.isnull   == 'undefined' || o.isnull   == 0?0:1;
            var updatable = typeof o.updatable == 'undefined' || o.updatable == false?0:1;
            var html     = typeof o.html     == 'undefined' || o.html     == false?0:1;
            var status   = typeof o.status   == 'undefined' || o.status   == null?'':o.status;
            var cssText  = typeof o.cssText  == 'undefined' || o.cssText  == null?'':o.cssText;

            var tId = o.row.offsetParent.id;
            var c  = GRID.row.insertCell(o.row);
            if ( html == '1' ) {
                c.innerHTML = o.value;
            } else {
                c.appendChild($CT(o.value));
            }
            c.noWrap='true';
            c.style.overflow ='hidden';
            c.tabIndex = parseInt(o.row.rowIndex+''+c.cellIndex);
            c.setAttribute("updatable",updatable  );
            c.setAttribute("isnull"  ,isnull    );
            c.setAttribute("status"  ,status    );
            var eventStr = GRID.infor[tId].onedit;
            if ( status == 'I' ) eventStr = 'onfocus';
            if ( status == 'I' && eventStr == 'onfocus' ) {
                    c.attachEvent('onfocus',function(e) {
                        GRID.row.onActivate(this.parentNode);
                        GRID.cell.onFocus(e);
                        GRID.cell.onEdit(e);
                    });
            } else {
                if ( document.all ) {
                    if ( updatable == '1' ) {
                        c.attachEvent(eventStr ,
                            function(e) {
                                GRID.cell.onEdit(e);
                            }
                        );
                    }
                    if ( status == 'U' ) {
                        /* 아래코딩이 없으면 ipod safari에서는 onfocus 이벤트가 발생하지 않음. */
                        c.attachEvent('onclick',function(e) {
                            /* alert( userAgent ); */
                        });
                        c.attachEvent('onfocus',function(e) {
                            GRID.row.onActivate(this.parentNode);
                            GRID.cell.onFocus(e);
                        });
                    }
                } else {
                    if ( status == 'U' ) {
                        /* 아래코딩이 없으면 ipod safari에서는 onfocus 이벤트가 발생하지 않음. */
                        c.attachEvent('onclick',function(e) {
                        });

                        c.attachEvent('onfocus',function(e) {
                            GRID.row.onActivate(this.parentNode);
                            GRID.cell.onFocus(e);
                        });
                    }
                    if ( updatable == '1' ) {
                        c.attachEvent(eventStr ,
                            function(e) {
                                GRID.cell.onEdit(e);
                            }
                        );
                    }
                }
            }
            c.style.cssText = cssText;
            c.className = 'col' + c.cellIndex;
            return c;
        },
        addCellByTag:function(r,tag) {
            var c  = r.insertCell(-1);
                c.innerHTML = tag;
                return c;
        }
    },
    cell:{
        getTh:function(th){ /* 상위 TH Element를 반환한다. */
            for( var i=0;i<3;i++ ) {
                if ( th.tagName =='TH' ) break;
                else                     th = th.parentNode;
            }
            return th;
        },
        getTd:function(td){ /* 상위 TD Element를 반환한다. */
            for( var i=0;i<3;i++ ) {
                if ( td == null || td.tagName =='TD' ) break;
                else                     td = td.parentNode;
            }
            return td;
        },
        getData:function(tId,rIdx,fId) {
            var cIdx = GRID.infor[tId].fields[fId].index;
            var hRL = !$(tId).tHead?0:$(tId).tHead.rows.length;
            var rI = rIdx-hRL;
            return $(tId).tBodies[0].rows[rI].cells[cIdx].getAttribute('data');
        },
        setData:function(tId,rIdx,fId,data) {
            var cIdx = GRID.infor[tId].fields[fId].index;
            var hRL = !$(tId).tHead?0:$(tId).tHead.rows.length;
            var rI = rIdx-hRL;
            var td = $(tId).tBodies[0].rows[rI].cells[cIdx];
            if ( td.childNodes[0].tagName == 'TD' ) {
                td.childNodes[0].nodeValue = data;
            } else {
                td.childNodes[0].value = data;
            }
            return data;
        },
        onActivate:function (e){
            var c = GRID.cell.getTd(window.event?event.srcElement:e.target);
            if (c) {
                var tId = c.offsetParent.id;
                var cObj = GRID.infor[tId].cell;
                if (c) {
                    cObj.sCell = c;
                    cObj.cssTexts = new Array();
                    var lastE = $L(c);
                    cObj.cssTexts.push({object:c,cssText:c.style.cssText});
                    var cellCssText = cObj.active.cssText;
                    c.style.cssText     = cellCssText;
                } else {
                    cObj.sCell = null;
                }
            }
        },
        onDeactivate:function (c){
            var tId = c.offsetParent.id;
            var cObj = GRID.infor[tId].cell;
            try
            {
                while(v = cObj.cssTexts.pop()) {
                    v.object.style.cssText = v.cssText;
                }
            }
            catch (e) {
                alert( e.toString() );
            }
            cObj.sCell = null;
        },
        onFocus:function(e) {
            var td = window.event?event.srcElement:e.target;
                td = GRID.cell.getTd(td);
            var tId = td.offsetParent.id;
            var cg = GRID.getColgroup($(tId));
            var fId = cg.childNodes[td.cellIndex].getAttribute('field_name');

            var exec = true;
            if ( typeof GRID.infor[tId].onfocus == 'function' ) {
                exec = GRID.infor[tId].onfocus({tId:tId,td:td,fId:fId});
            }
            if ( exec ) {
                var tBody = td.parentNode.parentNode;
                var hRL = !tBody.parentNode.tHead?0:tBody.parentNode.tHead.rows.length;
                var tRL = !tBody.parentNode.tFoot?0:tBody.parentNode.tFoot.rows.length;
                var cIdx = td.cellIndex;
                var rIdx = td.parentNode.rowIndex ;
                if ( tBody.rows ) GRID.row.onActivate(tBody.rows[rIdx-hRL]);

                if ( td.getAttribute('status') == 'U' ) {
                    var btId = tBody.parentNode.id + '_del_button';
                    var btO  = $(btId);
                    if ( btO ) btO.parentNode.removeChild(btO);
                    var bt = $C('button');
                        bt.id = btId;
                        bt.innerText = 'delete';
                    td.style.verticalAlign = 'middle';
                    td.parentNode.cells[td.parentNode.cells.length-1].appendChild(bt);
                    bt.onfocus = GRID.cell.onFocus;
                    bt.onmousedown= function(e) {
                        GRID.cell.onFocus(e);
                        var exec = true;
                        if ( typeof GRID.infor[tId].ondelete == 'function' ) {
                            exec = GRID.infor[tId].ondelete({tId:tId,td:td});
                        }
                        if ( exec ) {
                            var msg = GRID.infor[tId].message['delete'];
                            if ( !msg || ( msg && confirm(msg) ) ){
                                GRID.save({td:td,mode:'D',table:tBody.parentNode.id});
                            }
                        }
                    }
                }
                td.onkeydown= function (event) {
                    var e = window.event?window.event:event;
                    if (e.keyCode == 13) { /* enter */
                        /* eR.onblur(); */
                    }
                    if (e.keyCode == 9 || ( e.shiftKey && e.keyCode == 9 )) { /* tab || shift + tab */
                        if ( Util.Browser.mozilla || Util.Browser.opera) {
                            e.preventDefault();
                            e.stopPropagation();
                        } else {
                            e.cacelBubble = true;
                            e.returnValue = false;
                        }
                        if ( !(e.shiftKey && e.keyCode == 9) ) {
                            if ( td.nextSibling == null ) {
                                td.parentNode.nextSibling.cells[0].focus();
                            } else {
                                td.nextSibling.focus();
                            }
                        } else {
                            if ( td.previousSibling == null ) {
                                td.parentNode.previousSibling.cells[td.parentNode.cells.length - 1].focus();
                            } else {
                                td.previousSibling.focus();
                            }
                        }
                    } else if (e.keyCode == 113) { /* F2 */
                        var eventStr = GRID.infor[tId].onedit;
                        td.fireEvent(eventStr,e);
                    } else {
                        if ( td.firstChild.nodeType == 3 ) GRID.cell.onKeyDown(e);
                    }
                }
                GRID.cell.onActivate(e);
            }
            return exec;
        },
        onEdit:function(e) {
            var o = (window.event?event.srcElement:e.target);
            var c = this.getTd(o);
            var tId = c.offsetParent.id;
            var cg = GRID.getColgroup($(tId));
            var fId = cg.childNodes[c.cellIndex].getAttribute('field_name');

            var exec = true;
            if ( typeof GRID.infor[tId].onediting == 'function' ) {
                exec = GRID.infor[tId].onediting({tId:tId,td:c,fId:fId});
            }
            if ( exec ) {
                if ( c.getAttribute('updatable') == '1' ) {
                    if ( c.firstChild.nodeType == 3) {
                        var t = GRID.infor[tId].fields[fId].type;
                        var eI = null;
                        var data = c.getAttribute('data');
                        if ( t == 'TEXT' ) {
                            eI = document.createElement("textarea");
                            eI.value = data;
                            eI.style.border = '1px solid gray';
                            eI.style.width  = (c.offsetWidth - 5)+'px';
                            eI.style.height = (c.offsetHeight + 1)+'px';
                            eI.style.overflow = 'hidden';
                        } else if ( t == 'SELECT' ) {
                            var eI = $C(t);
                            var code = GRID.infor[tId].code[fId];
                            var prototype = code.constructor.prototype;
                            for ( var n in code ) {
                                if (n in prototype) continue;
                                if (code instanceof Array && isNaN(n)) continue;
                                var opt = new Option(code[n],n);
                                eI.options[(eI.options.length)] = opt;
                            }
                            eI.style.width = '99%';
                            eI.value = data;
                        }
                        var onblurExec = true;
                        if ( typeof GRID.infor[tId].fields[fId].onblur == 'function' ) {
                            eI.onblur= function (event) {
                                var e = window.event?window.event:event;
                                if ( typeof GRID.infor[tId].fields[fId].onblur == 'function' ) {
                                    GRID.infor[tId].fields[fId].onblur(e);
                                }
                            }
                        }
                        if ( onblurExec ) {
                            var t = GRID.infor[tId].fields[fId].type;
                            if ( t == 'TEXT' ) {
                                eI.attachEvent('onblur'  ,GRID.cell.onBlur);
                            } else if ( t == 'SELECT' ) {
                                eI.attachEvent('onblur'  ,GRID.cell.onBlur);
                                eI.attachEvent('onchange',GRID.cell.onBlur);
                            }

                            eI.tabindex = parseInt(c.tabIndex) -1;
                            eI.onkeydown= function (event) {
                                var e = window.event?window.event:event;
                                if (e.keyCode == 13) { /* enter */
                                    /* eI.onblur(); */
                                }
                                if ( e.keyCode== 27) { /* esc */
                                    var td = this.parentNode;
                                    orgText = td.childNodes[1]; /* org */
                                    eI.value = orgText.innerText;
                                    eI.fireEvent('onblur',e);
                                    td.focus();
                                }
                                this.style.height = '40px'  ;
                                this.style.overflowY = 'auto';
                            }

                            c.replaceChild(eI,c.firstChild);
                            /* 초기값 데이터 유지영역 생성 */
                            if ( !c.childNodes[1] ) {
                                var orgO= $C('span');
                                orgO.innerText = data;
                                orgO.style.display = 'none';
                                orgO.setAttribute("isnull"  ,c.getAttribute('isnull')    );
                                c.appendChild( orgO );
                            }

                            if ( t == 'TEXT' ) { eI.focus(); eI.select(); }
                            else { eI.focus(); }
                        }
                    }
                }
            }
        },
        onBlur:function(e) {
            var e = window.event?window.event:e;
            var eO = window.event?e.srcElement:e.target;
            var c  = GRID.cell.getTd(eO);
            var orgO = c.childNodes[1]; /* org */
            var tId = c.offsetParent.id;
            var cg = GRID.getColgroup($(tId));
            var fId = cg.childNodes[c.cellIndex].getAttribute('field_name');
            var t = GRID.infor[tId].fields[fId].type;
            if ( eO.tagName != 'TD' ) {
                var cValue = eO.value;
                var oValue = orgO.innerText;
                if ( t == 'TEXT' ) {
                    c.replaceChild($CT(eO.value),eO);
                } else if ( t == 'SELECT' ) {
                    c.replaceChild($CT(GRID.infor[tId].code[fId][eO.value]),eO);
                }
                var mode = c.getAttribute('status');
                if ( cValue != oValue ) {
                    var msg = '';
                    if      ( mode == 'I' ) msg = GRID.infor[tId].message['insert'];
                    else if ( mode == 'U' ) msg = GRID.infor[tId].message['update'];
                    if ( mode == 'U' ) {
                        var exec = true;
                        if ( typeof GRID.infor[tId].onchange== 'function' ) {
                            exec = GRID.infor[tId].onchange({tId:tId,td:c,fId:fId});
                        }
                        if ( exec ) {
                            if ( typeof GRID.infor[tId].fields[fId].onchange == 'function' ) {
                                if ( GRID.infor[tId].fields[fId].onchange({tId:tId,td:c,fId:fId}) ) {
                                    c.setAttribute('data',cValue);
                                    c.setAttribute('isnull','0');
                                    if ( !msg || ( msg && confirm(msg) ) ){
                                        GRID.save({td:c,mode:mode,table:tId});
                                    }
                                } else {
                                    GRID.cancel({td:c,mode:'U'});
                                }
                            } else {
                                if ( !msg || ( msg && confirm(msg) ) ){
                                    c.setAttribute('data',cValue);
                                    c.setAttribute('isnull','0');
                                    GRID.save({td:c,mode:mode,table:tId});
                                } else {
                                    GRID.cancel({td:c,mode:'U'});
                                }
                            }
                        } else {
                            GRID.cancel({td:c,mode:'U'});
                        }
                    } else if ( mode == 'I' ) {
                        c.setAttribute('data',cValue);
                        c.setAttribute('isnull','0');
                    }
                }
            }
        },
        onKeyDown:function(e) {
            var sRowObj = null;
        /*
            [trap = 37]
            [trap = 39]
            [trap = 38]
            [trap = 40]
        */
            var code = window.event?window.event.keyCode:e.keyCode;
            if (code == 38 || code == 40 ) {
                td = window.event?event.srcElement:e.target;
                td = GRID.cell.getTd(td);

                var cIdx = td.cellIndex;
                var rIdx = td.parentNode.rowIndex;

                var tBody = td.parentNode.parentNode;
                var hRL = !tBody.parentNode.tHead?0:tBody.parentNode.tHead.rows.length;
                var tRL = !tBody.parentNode.tFoot?0:tBody.parentNode.tFoot.rows.length;

                var newRIdx = rIdx + (code == 38?-1:1) - hRL;
                if ( newRIdx >= 0 && newRIdx < tBody.rows.length ) {
                    if ( tBody.rows[newRIdx].cells[cIdx] ) {
                   GRID.row.onActivate(tBody.rows[newRIdx]);
                   tBody.rows[newRIdx].cells[cIdx].focus();
                   var lastE = $L(tBody.rows[newRIdx].cells[cIdx]);
                   window.setTimeout( function() { try {lastE.focus();} catch(e){} },0);
                   }
                } else {
                    /* alert( tBody.tagName + ' / ' + code + ' / ' + rIdx + ' / ' + newRIdx + ' / ' + hRL + ' / ' + tRL + ' / ' + tBody.rows.length); */
                }
                if ( $L(td).tagName == 'INPUT' ) {
                    var n = $L(td).name;
                }
            }
        }
    },
    clearSort:function(tId) {
        this.infor[tId].sort={};
    },
    setSort:function(o) { /* event:e,fieldName:fId */
        var th = window.event?event.srcElement:o.event.target;
            th = GRID.cell.getTh(th);
        var arrowDraw = o.arrowDraw?o.arrowDraw:false;
        if ( th.childNodes[0].innerText == '▼' || th.childNodes[0].innerText == '▲' || th.childNodes[0].innerText == '' ) {
            th.removeChild(th.childNodes[0]);
        }
        var tbl = th.parentNode.parentNode.parentNode;
        var tId = tbl.id;
        var sId = o.fieldName;
        if (!this.sort[tId]     ) this.sort[tId] = {};
        if (!this.sort[tId][sId]) this.sort[tId][sId] = {};
        var direction = this.sort[tId][sId].direction?this.sort[tId][sId].direction:'';
        if      ( direction == '▲' ) direction = '▼';
        else if ( direction == '▼' ) direction = '' ;
        else                         direction = '▲';
        this.sort[tId][sId].direction = direction;
        if ( direction == '' ) delete this.sort[tId][sId];
        if(typeof GRID.infor[tId].callback.sort === 'function') {
            GRID.infor[tId].callback.sort();
        }

        if( arrowDraw ) {
            this.drawSortArrow({td:th,fieldName:sId}); /* arrow display */
        }
    },
    getSortString:function(tId){
        var params = '';
        if ( typeof this.sort[tId] == 'object' ) {
            var prototype = this.sort[tId].constructor.prototype;
            for ( var sid in this.sort[tId] ) {
                if (sid in prototype) continue;
                if (this.sort[tId] instanceof Array && isNaN(sid)) continue;
                params+='&sort_f[]='+sid.toLowerCase().replace(/sort_/,'') + '&sort_d[]=' + this.sort[tId][sid].direction;
            }
        }
        return params;
    },
    getXMLValue:function (o,nm) {
        var isnull = o.getElementsByTagName(nm)[0].attributes.getNamedItem("isnull");
        return (isnull!=null&&isnull.value=='1')?null:o.getElementsByTagName(nm)[0].firstChild.data;
    },
    codeXmlToJson:function(o) {
        var l = o.length;
        var _r = {};
        for (var i=0; i<l;i++ ) {
            var k = o[i].getAttribute('id');
            _r[k] = {};
            _r[k] = o[i].firstChild.nodeValue;
            var x=o[i].attributes;
            var ll = x.length;
            for ( var j=0;j<ll;j++ ) {
                _r[k][x[j].nodeName] = x[j].nodeValue;
            }
        }
        return _r;
    },
    clearHead:function(o) { /* table:tId */
        var tbl = $(o.table);
        var cG = GRID.getColgroup(tbl);
        if ( cG ) {
            while (cG.childNodes.length>0) {cG.removeChild(cG.firstChild); }
            tbl.removeChild(cG);
        }
        while (tbl.tHead.rows.length> 0     ) {tbl.tHead.deleteRow(0);      }
    },
    clearBody:function(o) { /* table:tId */
        var tbl = $(o.table);
        while (tbl.tBodies[0].rows.length> 0) {tbl.tBodies[0].deleteRow(0); }
    },
    clearFoot:function(o) { /* table:tId */
        var tbl = $(o.table);
        while (tbl.tFoot.rows.length> 0     ) {tbl.tFoot.deleteRow(0);      }
    },
    clearTable:function(o) { /* table:tId */
        var tbl = $(o.table);
        while (tbl.tBodies[0].rows.length> 0) {tbl.tBodies[0].deleteRow(0); }
     /* while (tbl.tHead.rows.length> 0     ) {tbl.tHead.deleteRow(0);      } */
        this.clearHead({table:tbl});
        while (tbl.tFoot.rows.length> 0     ) {tbl.tFoot.deleteRow(0);      }
    },
    drawSortArrow:function(o) { /* td:c, fieldName:fId */
        var td = o.td;
        //console.debug(td);
        //alert( td.style.display );
        if ( td.offsetParent ) {
            var tId = td.offsetParent.id;
            var fId = o.fieldName;
            var fieldInfo = GRID.infor[tId].fields;
            if ( this.sort[tId] && this.sort[tId][fId] ) {
                s = $C('SPAN');
                s.type = 'TEXT';
                var setStr = '▲';
                s.innerText = this.sort[tId][fId].direction; /*  ▲ / ▼ SPAN */
                s.style.backgroundColor = 'transparent';
                s.style.width = '11px';
                s.style.height = '10px';
                s.style.border = '0px';
             /* o.appendChild(s);*/
                o.td.insertBefore(s, o.td.firstChild);
            }
        }
    },
    createHead:function(o) { /* table,fieldInfo,calback */
        var tbl = $(o.table);
        var th = tbl.tHead     ;
        var tId = tbl.id;
        var r = null;
        GRID.clearTable({table:tbl}); /* clear table */
        if ( th.rows.length == 0 ) {
            r=th.insertRow(-1);
            var fieldInfo = GRID.infor[tId].fields;
            var ll = fieldInfo.count();
            var cg = GRID.getColgroup(tbl);
                cg = cg?cg:$C('COLGROUP');
            var prototype = GRID.infor[tId].fields.constructor.prototype;
            for ( var j in GRID.infor[tId].fields ) {
                if (j in prototype) continue;
                if (GRID.infor[tId].fields instanceof Array && isNaN(n)) continue;
                var fId = j;
                var c = GRID.row.addCell({row:r,value:fieldInfo[j].title,updatable:false,status:'R'});
                c.style.cursor = 'pointer';
                c.onclick = (function(fId){
                    return function(e){
                        GRID.setSort({event:e,fieldName:fId,arrowDraw:true});
                    };
                })(fId);
                c.className = 'col' + c.cellIndex;

                this.drawSortArrow({td:c,fieldName:fId}); /* arrow display */
                var col = $C('COL');
                    col.width = fieldInfo[j].width;
                    col.setAttribute('field_name',j);

                    if ( fieldInfo[j].align ) col.align = fieldInfo[j].align;
                    cg.appendChild(col);
            }
            tbl.insertBefore(cg, tbl.tHead);
         /* tbl.tHead.appendChild(cg); */
            if ( th.rows[0].cells.length == fieldInfo.count() ) {
                c = GRID.row.addCell({row:r,value:'',updatable:false});
                co = GRID.addCol(tbl);
                co.align ='right';
            }
        } else {
            r = tbl.tHead.rows[0];
        }
        return null;
    },
    getColgroup:function(tbl) {
        var l = tbl.children.length;
        var _r = null;
        for (var i=0; i<l;i++ ) {
            if ( tbl.children[i].tagName.toLowerCase() == 'colgroup') {
                _r = tbl.children[i];
                break;
            }
        }
        return _r;
    },
    addCol:function(tbl) {
        var cg = this.getColgroup(tbl);
        var col = $C('COL');
            cg.appendChild(col);
        return col;
    },
    getFieldParameter:function(fieldInfo) { /* 사용안함. */
        var p_field_names = new Array();
        var ll = fieldInfo.length;
        for (var j=0; j<ll;j++ ) p_field_names.push(fieldInfo[j].id);
        return p_field_names;
    },
    getSaveParameter:function(o) {
        var ajaxR = new asyncConnector('xmlhttp');
        var fParams = '';
        var td = GRID.cell.getTd(o.td);
        var fieldInfo = o.fieldInfo;

        var cIdx = td.cellIndex;
        var rIdx = td.parentNode.rowIndex;
        var tBody = td.parentNode.parentNode;
        var hRL = !tBody.parentNode.tHead?0:tBody.parentNode.tHead.rows.length;
        var tRL = !tBody.parentNode.tFoot?0:tBody.parentNode.tFoot.rows.length;
        var tId = tBody.parentNode.id;
        var l = tBody.rows[rIdx-hRL].cells.length;
        var l = fieldInfo.length;
        var i=0;
        var ll = fieldInfo.length;
        var prototype = GRID.infor[tId].fields.constructor.prototype;
        for ( var j in GRID.infor[tId].fields ) {
            if (j in prototype) continue;
            if (GRID.infor[tId].fields instanceof Array && isNaN(n)) continue;
            o    = tBody.rows[rIdx-hRL].cells[i].firstChild;
            orgO = tBody.rows[rIdx-hRL].cells[i].childNodes[1];
            if ( orgO != null && o.nodeValue != orgO.innerText ) {
                fParams += '&' + j + '_org=' + encodeURIComponent(orgO.innerText==null?'':orgO.innerText);
                fParams += '&' + j + '_org_isnull=' + orgO.getAttribute('isnull');
            }
            fParams += '&' + j + '=' + encodeURIComponent(o.parentNode.getAttribute('data')==null?'':o.parentNode.getAttribute('data'));
            fParams += '&' + j + '_isnull=' + o.parentNode.getAttribute('isnull');
            i++;
        }
        return fParams;
    },
    reGenTable:function(tObj,cellIndexs) {
        var getCellValueString = function (tObj,rIdx,cellIndexs) {

            var l = cellIndexs.length;
            var _rtn = new Array();
            for (var i=0; i<l; i++) {
                _rtn.push(tObj.rows[rIdx].cells[cellIndexs[i]].innerText);
            }
            return _rtn.join('|');
        }

        cellIndexs.sort();
        var rLen = tObj.rows.length - 1;
        var cLen = 0;
        if ( rLen > 0 ) {
            cLen = tObj.rows[1].cells.length;
        }
        var tmpInfoStr = '';
        var htKey = new Object();
        var htCnt = new Object();
        for (i=1; i<=rLen; i++) {
            var iStr = getCellValueString(tObj,i,cellIndexs);
            if (iStr == tmpInfoStr ) {
                var tmpHtV = parseInt(htKey[iStr],10);
                    tmpHtV = isNaN(tmpHtV)?0:tmpHtV;
                htKey[iStr] = tmpHtV + 1;
            }
            tmpInfoStr = iStr;
        }

        for (i=1; i<=rLen; i++) {
            var infoStr = tObj.rows[i].cells[0].innerText;
            var iStr = getCellValueString(tObj,i,cellIndexs);
            var rowSpan = parseInt(htKey[iStr],10);
            if (rowSpan > 0 ) {
                var si = i+1;
                var ei = i+rowSpan;
                var banNames = '';
                var banIdx=7;
                for (j=si; j<=ei; j++) {
                   var l = cellIndexs.length;
                   for (var k=l-1; k>=0; k--) {
                        if ( j == si ) {
                            tObj.rows[j].cells[cellIndexs[k]].rowSpan = rowSpan;
                        } else {
                            tObj.rows[j].cells[k].style.backgroundColor = 'blue';
                            tObj.rows[j].removeChild(tObj.rows[j].cells[cellIndexs[k]]);
                        }
                    }
                }
                i += rowSpan;
            }
        }
    },
    getObject:function(o) {
        var tbl = $(o);
        var th = tbl.tHead     ;
        var tb = tbl.tBodies[0];
        var tf = tbl.tFoot     ;
        var rtn = {};
            rtn.table = tbl;
            rtn.head = th;
            rtn.body = tb;
            rtn.foot = tf;
        return rtn;
    }
}
    function onComplete() { }
    function getContent(dir,pg,o) {
        window.onComplete = function(){};
        if (dir != '' ) {
            dir = dir.charAt(0)=='/'?dir.substr(1):dir;
        }
        //alert( document.location.pathname );
        var root = document.location.pathname.substring(1).split('.')[0];

        root = root == 'sub'?'ac':root;
        root = root == 'root'?"":root;
//
        var url = (root?"/"+root:"") + "/" + dir + "/" + pg + ".jsp";
        var jsSrc = (root?"/"+root:"") + "/" + dir + "/js/" + pg + ".js";
        var cssSrc = (root?"/"+root:"") + "/" + dir + "/css/" + pg + ".css";
        var dUrl = (root?"/"+root:"") + ".jsp?p_prg=" + dir +"/" + pg;
        var source = "C:\\WEB_APP\\JWAS\\java_doc\\" + SITE_ID + "\\ROOT\\" + (root?root+"\\":"") + dir.replace(/\//g,"\\") + "\\" + pg + ".jsp";
        var sourceJS = "C:\\WEB_APP\\JWAS\\java_doc\\" + SITE_ID + "\\ROOT\\" + (root?root+"\\":"") + dir.replace(/\//g,"\\") + "\\js\\" + pg + ".js";
        o = o?o:{};
        var params = (typeof(o) == 'object' && o.params )?o.params:"";
        if ( params.charAt(params.length-1) == '&' ) params = params.substring(0,params.length-1);
        //if ( $('_info') ) $('_info').innerHTML = "root : <input type=text value='" + "/" + root + "/" + dir + "/' onclick='this.select();'>";
        //if ( $('_info') ) $('_info').innerHTML += "<BR>prog : <input type=text value='" + pg + "' onclick='this.select();'>";
        //if ( $('_info') ) $('_info').innerHTML += "<BR><input type=text value='" + url + "' onclick='this.select();'>";
        //console.debug("jsSrc : " + jsSrc);

        if ( $('_info') ) $('_info').innerHTML  = "<BR><div style='overflow:hidden;width:150px' title='" + dUrl +(params?'&'+params:'') + "' ><a href='" + dUrl +(params?'&'+params:'') + "' style='color:red'>" + dUrl +(params?'&'+params:'')+ "</a></div>";
        if ( $('_info') ) $('_info').innerHTML += "<a href='" + jsSrc + "' style='color:red' target=_new>"+ pg + ".js</a>";
        //if ( $('_info') ) $('_info').innerHTML += "<BR><input type=text value='" + dUrl+ "' onclick='this.select();'>";
        if ( $('_info') ) $('_info').innerHTML += "<BR><span style='color:#24779b'>jsp</span> : <input type=text value='" + source+ "' onclick='this.select();' size=30>";
        if ( $('_info') ) $('_info').innerHTML += "<BR><span style='color:#e0788a'>js</span>  : <input type=text value='" + sourceJS+ "' onclick='this.select();' size=30>";
        //if ( $('_info') ) $('_info').innerHTML += "<BR><a href='#' onclick='window.open(\"file:///" + source+ "\");'>source</a>";
        //if ( $('_info') ) $('_info').innerHTML += "<BR><a href='file:///" + sourceJS+ "'>js</a>";

        Util.Load.script({src:cssSrc,type:'css',callback:function(){
            if ( $('_info') ) $('_info').innerHTML += "<BR><input type=text value='" + cssSrc + "' onclick='this.select();'>";
        }});

        var subList = false;
        var ar = null;
        if ($(o.target)) {
            ar = $(o.target);
        } else {
            if ($('sub_list')) {
                ar = $('sub_list');
                params+=(params?"&":"") + "s_sub_list=1";
                subList = true;

            } else {
                ar = $('area_content1');
            }
        }

        if (!subList || o.change_menu ) {
            try {
                if ( !o.donot_change_menu ) {
                    menu.leftSelect.Content(dir,pg,o);
                }
            } catch (e) {}
        }
        var xhr = new asyncConnector('xmlhttp');
        xhr.openCallBack= function (str) {
            if (loading) loading.hide();
            xhr.dataArea.innerHTML = xhr.responseText();
            xhr.dataArea.style.display = 'inline' ;
            if (typeof(o) == 'object' && o.cb) o.cb();
            try {
                var cbSon =callback?eval ( 'callback.' + dir.replace(/\//g,".") + '.' + pg ):null;
                console.debug('cbSon' , cbSon);
                if (typeof cbSon == 'function') {
                    cbSon();
                }
            }
            catch (e) { }
                Util.domReady(function(){
                    Util.Load.script({src:jsSrc,type:'js',callback:function(){
                        //if ( $('_info') ) $('_info').innerHTML += "<BR><input type=text value='" + jsSrc + "' onclick='this.select();'>";
                        //if ( $('_info') ) $('_info').innerHTML += "<BR><a href='" + jsSrc + "' style='color:red'>"+ pg + ".js</a>";
                        window.setTimeout(function() {
                            if (!subList && typeof onComplete == 'function') onComplete();
                        },100);
                    }});
                });
            try {

            }
            catch (e) { }
            writingImgResource();
        }
        //alert(url);
        //document.body.scrollTop = 0;
        //document.body.scrollTop = 400;
        if ( typeof(o) == 'object' && o.method ) {
            if ( o.method == 'POST' ) {
                xhr.httpOpen(o.method, url, true,params,ar);
            } else {
                xhr.httpOpen('GET', url + '?' + params, true,params,ar);
            }
        } else {

            xhr.httpOpen('GET', url + '?' + params, true,params,ar);
        }

        try
        {
            loading.setTarget(document.documentElement);
            loading.setPos('','400px');
            loading.show();
        }
        catch ( e ) { }

        if ( $('_info') ) $('_info').innerHTML += "<BR><textarea type=text onclick='this.select();' style='height:100px;'>" + dUrl +(params?'&'+params:'') + "</textarea>";
        return false;
    }

    function getContent2(p_prg,o) {
        o = o?o:{};
        var info = p_prg.split('/');
            info = info.join(new Array());
            info = p_prg.split('/');
        if (Object.isArray( info )) {
            dir = info.slice(0,info.length-1).join('/');
            pg  = info[info.length-1];
        }
        //alert (dir + ' / ' + pg );
        return getContent(dir,pg,o);
    }


    var leftMenuIdx = 1;
    function getService(m,s,l,o) {
        window.onComplete = function(){};
        leftMenuIdx = l;
        var url   = "/service/sub" + m + "/sub_" + m + "_" + s + "_" + leftMenuIdx + ".jsp";
        var jsSrc = "/service/sub" + m + "/js/sub_" + m + "_" + s + "_" + leftMenuIdx + ".js";
        var cssSrc= "/service/sub" + m + "/css/sub_" + m + "_" + s + "_" + leftMenuIdx + ".css";
        var dUrl = "/sub.jsp?p_m=" + m +"&p_s=" + s+"&p_l=" + l;
        var source = "C:\\WEB_APP\\JWAS\\java_doc\\" + SITE_ID + "\\ROOT\\service\\sub" + m + "\\sub_" + m + "_" + s + "_" + leftMenuIdx + ".jsp";
        var sourceJS = "C:\\WEB_APP\\JWAS\\java_doc\\" + SITE_ID + "\\ROOT\\service\\sub" + m + "\\js" + "\\sub_" + m + "_" + s + "_" + leftMenuIdx + ".js";

        o = o?o:{};
        var params = (typeof(o) == 'object' && o.params )?o.params:"";
        Util.Load.script({src:cssSrc,type:'css',callback:function(){
        }});

        if ( $('_info') ) $('_info').innerHTML  = "<BR><div style='overflow:hidden;width:140px' title='" + dUrl +'&'+(params?params:"")+ "' ><a href='" + dUrl +'&'+(params?params:"")+ "' style='color:red'>" + dUrl +'&'+(params?params:"")+ "</div></a>";

        if ( $('_info') ) $('_info').innerHTML += "<BR><input type=text value='" + dUrl+ "' onclick='this.select();'>";
        if ( $('_info') ) $('_info').innerHTML += "<BR><input type=text value='" + source+ "' onclick='this.select();'>";
        if ( $('_info') ) $('_info').innerHTML += "<BR><input type=text value='" + sourceJS+ "' onclick='this.select();'>";
        var subList = false;
        var ar = null;
        if ($(o.target)) {
            ar = $(o.target);
        } else {
            if ($('sub_list')) {
                ar = $('sub_list');
                params+=(params?"&":"") + "s_sub_list=1";
                subList = true;
            } else {
                ar = $('area_content1');
            }
        }

        if (!subList) menu.leftSelect.Service(m,s,l,o);

        var xhr = new asyncConnector('xmlhttp');
        xhr.openCallBack= function (str) {
            if (loading) loading.hide();
            xhr.dataArea.innerHTML = xhr.responseText();
            xhr.dataArea.style.display = 'inline' ;
            if (typeof(o) == 'object' && o.cb) o.cb();
            try {

                var cbSon =eval ( 'callback.' + "service.sub" + m + "_" + s + "_" + leftMenuIdx );
                if (typeof cbSon == 'function') {
                    cbSon();
                }
            }
            catch (e) { }
            try {
                Util.domReady(function(){
                    Util.Load.script({src:jsSrc,type:'js',callback:function(){
                        if ( $('_info') ) $('_info').innerHTML += "<BR><input type=text value='" + jsSrc + "' onclick='this.select();'>";
                        window.setTimeout(function() {
                            if (!subList && typeof onComplete == 'function') onComplete();
                        },100);
                    }});
                });
            }
            catch (e) { }
            writingImgResource();
        }
        //document.body.scrollTop = 0;
        //document.body.scrollTop = 400;

        if ( typeof(o) == 'object' && o.method ) {
            if ( o.method == 'POST' ) {
                xhr.httpOpen(o.method, url, true,params,ar);
            } else {
                xhr.httpOpen('GET', url + '?' + params, true,params,ar);
            }
        } else {
            xhr.httpOpen('GET', url + '?' + params, true,params,ar);
        }

        try
        {
            loading.setTarget(document.documentElement);
            loading.setPos('','400px');
            loading.show();
        } catch ( e ) { }

        if ( $('_info') ) $('_info').innerHTML += "<BR><textarea type=text onclick='this.select();' style='height:100px;'>" + params + "</textarea>";
        return false;
    }

var proc = {
    wordSearch:function(s){
        if ( s ) {
        } else {
            alert("검색어를 입력하세요!");
        }
    },
    dicSearch:function(f){
        f.target ="opendic";
        var s = $("s_dic").value.trim();
        if ( s ) {
          var w = openWindow("/service/pop_dic.jsp?p_search=" + s, 442, 560,"opendic",{scrollbars:'no'});
            w.focus();
            return false;
        } else {
            alert("검색어를 입력하세요!");
            return false;

        }
    },
    qsSearch:function(o){
        var v = document.qsSearchForm.qs_id.value.trim();
        if (!v) {
            document.qsSearchForm.qs_id.focus();
            document.qsSearchForm.qs_id.select();
            Effect.twinkle(document.qsSearchForm.qs_id);
            alert('문제번호를 입력해주세요!');
            return false;
        } else {
            var qsId = document.qsSearchForm.qs_id.value;
            if ( qsId.length > 2 && qsId.toUpperCase().substring(0,2) == "NG" ) { /* 내신 */
                $('ifrm_temp').contentWindow.document.location.href = "/ac/board_view/mp3/naesin_grammar_count.jsp?p_lect_cd=" + qsId.toUpperCase();
                var openPopup = window.open("http://havenglish.com/ac/board_view/mp3/LMWViewer.jsp?p_content_id=/test/" + qsId.toUpperCase()+".lmd", "lmd_lecture", "toolbar=no,width=1010,height=690,directories=no,status=yes,scrollbars=no,menubar=no");
                if(openPopup == null) {
                    alert("차단 된 팝업을 허용해 주십시오.");
                }
                openPopup.focus();
                return false;
            } else {
                document.qsSearchForm.target = '';
                document.qsSearchForm.action = '/ac.jsp';
                return true;
            }
        }
    },
    qsLMSearch:function(o){
        var o = o?o:{}; // not used
        var v = document.qsSearchForm.qs_id.value.trim();
        if (!v) {
            document.qsSearchForm.qs_id.focus();
            document.qsSearchForm.qs_id.select();
            Effect.twinkle(document.qsSearchForm.qs_id);
            alert('문제번호를 입력해주세요!');
            return false;
        } else {
            var qsId = document.qsSearchForm.qs_id.value;
            if (qsId.toUpperCase().substring(0,2) == "NG") {
                qsId = qsId.toUpperCase().substring(2);
            }
            if ( qsId ) { /* 내신 */
                $('ifrm_temp').contentWindow.document.location.href = "/ac/board_view/mp3/naesin_grammar_count.jsp?p_lect_cd=NG" + qsId.toUpperCase();
                var openPopup = window.open("http://havenglish.com/ac/board_view/mp3/LMWViewer.jsp?p_content_id=/test/NG" + qsId.toUpperCase()+".lmd", "lmd_lecture", "toolbar=no,width=1010,height=690,directories=no,status=yes,scrollbars=no,menubar=no");
                if(openPopup == null) {
                    alert("차단 된 팝업을 허용해 주십시오.");
                }
                openPopup.focus();
                return false;
            }
        }
    },
    main:{
        sBoxTabId:1,
        boxIndex:{start:1,end:3},
        fToggleBbsBox:function(sIdx,img) {
            var sB = document.getElementById('bbs_box0' + sIdx);
            var sT = document.getElementById('bbs_boxtab0' + sIdx);
            for (var i=this.boxIndex.start; i<=this.boxIndex.end; i++) {
                var nB = document.getElementById('bbs_box0' + i);
                    nB.style.display = 'none';
                var nT = document.getElementById('bbs_boxtab0' + i);
                var src = nT.src.replace(/\_on/,'_off');
                nT.src = src;
            }
            sB.style.display = "inline";
            var src = sT.src.replace(/_off/,'_on');
            sT.src = src;
            this.sBoxTabId = sIdx;
        },
        go_catalog:function (){
            url="http://www.havenglish.com/ecatalog.jsp";
            window.open(url,"ecatalog","scrollbars=yes,status=no,resizable=yes");
        }
    }
}

var menu = {
    pMimg:null,
    cMImg:null,
    pM:null,
    toggleImage:function (img) {
        img.onmouseout = function ( e) {
            if (menu.cMImg && menu.cMImg.src.indexOf("_off") )
            {
                menu.cMImg.src = menu.cMImg.src.replace(/_off/,'_on');
            }
            if ( menu.pMimg && menu.pMimg != menu.cMImg ) menu.pMimg.src = menu.pMimg.src.replace(/_on/,'_off');
            menu.pMimg.style.opacity =1;
            img.style.filter = "alpha(opacity=100)";
        }
        if (img != menu.cMImg)
        {
            var src = img.src.replace(/_off/,'_on');
            img.src = src;
            img.style.filter = "alpha(opacity=50)";
            img.style.opacity =0.5;
        }
        menu.pMimg = img;
    },
    leftSelect:{
        Service:function (m,s,l,o) {
            var params = (typeof(o) == 'object' && o.params )?o.params:"";
            var ml  = document.getElementsByTagName("a");
            if ( menu.pM ) {
                var src =  menu.pM.childNodes[0].src.replace(/_on/,'_off');
                 menu.pM.childNodes[0].src = src;
            }
            var isSelected = false;
            for (var i=0; i<ml.length; i++) {
                var mStr = ml[i].parentNode.innerHTML;
                    mStr = mStr.replaceAll("&amp;","&");
                var inc = (mStr.indexOf("getService("+m+","+s+","+l+(params?",{params:'"+params+"'":'')+"") > -1);
                    inc = inc || (mStr.indexOf("sub.jsp?p_m="+m+"&p_s="+s+"&p_l="+l+(params?"&"+params+"":'')) > - 1);
                if (ml[i].className == 'left_menu' ) {
                    //console.debug(mStr, m + "/" + s + "/" + l ,(mStr.indexOf("sub.jsp?p_m="+m+"&p_s="+s+"&p_l="+l+(params?"&"+params+"":'')) > - 1) );
                    if (inc ) {
                        var src =  ml[i].childNodes[0].src.replace(/_off/,'_on');
                        ml[i].childNodes[0].src = src;
                        menu.pM = ml[i];
                        menu.cMImg = menu.pM.childNodes[0];
                        menu.cMImg.style.opacity =1;
                        menu.cMImg.style.filter = "alpha(opacity=100)";
                        isSelected = true;
                        break;
                    }
                }
            }
            if (!isSelected) {
                for (var i=0; i<ml.length; i++) {
                    var mStr = ml[i].parentNode.innerHTML;
                        mStr = mStr.replaceAll("&amp;","&");
                    var inc = (mStr.indexOf("getService("+m+","+s+","+l+"") > -1);
                        inc = inc || mStr.indexOf("sub.jsp?p_m="+m+"&p_s="+s+"&p_l="+l+"") > - 1;
                    if (ml[i].className == 'left_menu' && inc ) {
                        var src =  ml[i].childNodes[0].src.replace(/_off/,'_on');
                        ml[i].childNodes[0].src = src;
                        menu.pM = ml[i];
                        menu.cMImg = menu.pM.childNodes[0];
                        menu.cMImg.style.opacity =1;
                        menu.cMImg.style.filter = "alpha(opacity=100)";
                        break;
                    }
                }
            }
        },
        Content:function (dir,pg,o) {
            var params = (typeof(o) == 'object' && o.params )?o.params:"";
            var ml  = document.getElementsByTagName("a");
            if ( menu.pM ) {
                var src =  menu.pM.childNodes[0].src.replace(/_on/,'_off');
                menu.pM.childNodes[0].src = src;
            }
            var isSelected = false;
            //console.debug(dir,pg,o);
            for (var i=0; i<ml.length; i++) {
                if (ml[i].className == 'left_menu' ) {
                    var myReg = new RegExp(".*getContent(.?)[(](\"|')?(\/)?"+dir+"(\"|')(,).((\"|')?"+pg+"(\"|'))?(,)?", "gi");
                    var mStr = ml[i].parentNode.innerHTML;
                    mStr = mStr.replaceAll("&amp;","&");
                    var b = false;
                        b = myReg.test(mStr) && ( mStr.indexOf(pg) > -1 );
                    if ( b ) {
                        if (o&&o.params) {
                            //alert( o.params );
                            //alert( 'params:' + o.params );
                            b = b && ( (mStr.indexOf('params:"' + o.params ) > -1) || (mStr.indexOf("params:'" + o.params) > -1)  );
                            if (b) {
                                //alert('x');
                            }
                        }
                        //console.debug(b,myReg,ml[i].parentNode.innerHTML,pg);
                    } else {
                        //console.debug(b,myReg,ml[i].parentNode.innerHTML,pg);
                    }
                    if (ml[i].className == 'left_menu' && b ) {
                        var src =  ml[i].childNodes[0].src.replace(/_off/,'_on');
                        ml[i].childNodes[0].src = src;
                        menu.pM = ml[i];
                        menu.cMImg = menu.pM.childNodes[0];
                        menu.cMImg.style.opacity =1;
                        menu.cMImg.style.filter = "alpha(opacity=100)";
                        isSelected = true;
                        break;
                    }
                }
            }

        }
    }
}
var preUpdateResource = new Array();

function getImgResource(e) {
    var o = e.target?e.target:window.event.srcElement;
    var aImg = new Array();
    var host = document.location.hostname;
    var port = document.location.port;
    var regexp = new RegExp("http:\\/\\/"+host+"(:"+port+")?", "gi");
    var exec = false;
    try {
        var istr = o.getAttribute('src').replace(regexp,"");
        if (istr && istr!= "about:blank") {
            var v = 'i='+ istr + '&t='+ o.tagName.toLowerCase()+ '&a=src';
            if ( !preUpdateResource.in_array(v) ) {
                aImg.push(v);
                preUpdateResource.push(v);
                exec = true;
            }
        }
    } catch (e){
    }
    try {
        var istr = o.getAttribute('background').replace(regexp,"");
        if (istr && istr!= "about:blank") {
            var v = 'i='+ istr + '&t='+ o.tagName.toLowerCase()+ '&a=src';
            if ( !preUpdateResource.in_array(v) ) {
                aImg.push(v);
                preUpdateResource.push(v);
                exec = true;
            }
        }
    } catch (e){
    }
    try {
        var istr = o.style.backgroundImage.replace(regexp,"");
        if (istr && istr!= "about:blank") {
            var v = 'i='+ istr + '&t='+ o.tagName.toLowerCase() + '-style' + '&a=background-image';
            if ( !preUpdateResource.in_array(v) ) {
                aImg.push(v);
                preUpdateResource.push(v);
                exec = true;
            }
        }
    } catch (e){
    }

    if (exec && aImg.unique().count() > 0 ) {
        var xhr = new asyncConnector('xmlhttp');
        xhr.openCallBack= function (str) {
            if (loading) loading.hide();
            xhr.dataArea.innerHTML = xhr.responseText();
        }
        if ( $('_image_resource') ) {
            document.body.removeChild($('_image_resource'));
        }
            var c = $C('DIV');
            c.id = '_image_resource';
            c.style.position = 'absolute';
            c.style.top = '10px';
            c.style.left = '0px';
            document.body.appendChild(c);
        //$('_image_resource').innerHTML += "<font style='font-weight:bold'>" + document.location.pathname + "</font> : <font style='font-weight:bold' color=" + Util.Color.getRandom('hex')+ ">" + "이미지 정보 추출 : " + ( aImg.unique().count()) + "</font><BR>";
        xhr.httpOpen("POST", "/include/img_check.jsp", true,'aa=&'+aImg.unique().join('&'));
    }
}

function writingImgResource(){
    if ( IMG_SAVE ) {
        var obj  = document.getElementsByTagName("*");
        var aImg = new Array();
        var host = document.location.hostname;
        var port = document.location.port;
        var regexp = new RegExp("http:\\/\\/"+host+"(:"+port+")?", "gi");
        for (var ii=0; ii<obj.length; ii++) {
            var oo =obj[ii];
            var t = oo.tagName.toLowerCase();
            try
            {
                if ( t == 'img' ) {
                    oo.attachEvent('onmouseover',getImgResource);
                    oo.attachEvent('onclick',getImgResource);
                } else if ( t == 'td' ) {
                    oo.attachEvent('onclick',getImgResource);
                } else {
                    oo.attachEvent('onmouseover',getImgResource);
                    //oo.attachEvent('onclick',getImgResource);
                }
                if ( oo.getAttribute("background") ) {
                    var istr = oo.getAttribute("background").replace(regexp,"");
                    if (istr && istr!= "about:blank") {
                        aImg.push('i='+ istr + '&t='+ t+ '&a=background');
                    }
                }
                if ( oo.getAttribute("src") ) {
                    var istr = oo.getAttribute("src").replace(regexp,"");
                    if (istr && istr!= "about:blank") {
                        aImg.push('i='+ istr + '&t='+ t+ '&a=src');
                    }
                }
                var istr = oo.style.backgroundImage.replace(regexp,"");
                if (istr) aImg.push('i='+ istr + '&t=style&a=background-image');
            }
            catch (e)
            {
            }
        }
        var xhr = new asyncConnector('xmlhttp');
        xhr.openCallBack= function (str) {
            if (loading) loading.hide();
            xhr.dataArea.innerHTML = xhr.responseText();
        }
        if ( !$('_image_resource') ) {
            var c = $C('DIV');
            c.id = '_image_resource';
            c.style.position = 'absolute';
            c.style.top = '10px';
            c.style.left = '0px';
            document.body.appendChild(c);
        }
        //$('_image_resource').innerHTML += "<font style='font-weight:bold'>" + document.location.pathname + "</font> : <font style='font-weight:bold' color=" + Util.Color.getRandom('hex')+ ">" + "이미지 정보 추출 : " + ( aImg.unique().count()) + "</font><BR>";
        xhr.httpOpen("POST", "/include/img_check.jsp", true,'aa=&'+aImg.unique().join('&'));
    }
}

Util.domReady(function(){
    //writingImgResource();
});

if (Util.Browser.ie) {
    // BackgroundImageCache Command를 지원할 경우
    if (document.execCommand("BackgroundImageCache", false, true)) {
        // Background Position 변경하면서 Rolling;
    } else {
        // 이미지 절대좌표 변경하면서 Rolling;
    }
}

var Create = {
//  Create.textNode({value:"aa"})
    textNode:function(o) {
        var el = $CT(o.value);
        return el;
    },
//  Create.textTag({tag:"span",name:'tmp_name1',value:"sssssssssss"})
    textTag:function(o) {
        var el = $C(o.tag);
        if ( o.name ) el.name = o.name;
        if ( o.value) el.innerHTML = o.value;
        return el;
    },
//  Create.hidden({name:'tmp_name2',value:""})
    hidden:function(o) {
        var el = $C('INPUT');
            el.name = o.name;
            el.type = 'hidden';
            el.value= o.value;
        return el;
    },
//  Create.textBox({name:'tmp_name2',value:"",size:7,readOnly:true})
    textBox:function(o) {
        var el = $C('INPUT');
            //alert(o.name);
           //el.setAttribute("name",o.name);
            el.name = o.name;
            el.type = 'text';
            el.value= o.value;
            if ( o.size      ) el.size= o.size;
            if ( o.readOnly  ) el.readOnly= o.readOnly;
            if ( o.maxLength ) el.maxLength= o.maxLength;
        return el;
    },
//  Create.checkbox({name:'tmp_name3',value:"Y",checked:true})
    checkbox:function(o) {
        var el = $C('INPUT');
            el.name = o.name;
            el.type = 'checkbox';
            el.value= o.value;
            el.checked= o.checked;
        return el;
    },
//  Create.radio({name:'tmp_name4',value:"Y",checked:true})
    radio:function(o) {
        var el = $C('INPUT');
            el.name = o.name;
            el.type = 'radio';
            el.value= o.value;
            el.checked= o.checked;
        return el;
    },
//  Create.listBox({name:'tmp_name5',value:{"1":"1값","2":"2값","3":"3값"}})
    listBox:function(o) {
        var el = $C('SELECT');
            el.name = o.name;
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
        }

        return el;
    }
}