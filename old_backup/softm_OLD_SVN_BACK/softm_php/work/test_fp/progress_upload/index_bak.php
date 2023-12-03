<?
//setCookie("ZUfileSize",'111111111111111111111',0,"");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<!-- <link rel="stylesheet" type="text/css" href="http://localhost/progress_upload/skin/basic/style.css" />
 --><SCRIPT LANGUAGE="JavaScript" src='./asyncConnector.js'></SCRIPT>
</HEAD>
<?
//echo phpinfo();
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
    String.prototype.trim = function(){return this.replace(/^\s+|\s+$/g, "");}
  //var _pfurogessFileUpload= {
    var _pfu= {
        count:0,
        iframe:null,
        timer:null,
        progress_area:null,
        info_area:null,
        form:null,
        xmlHttp:null,
        skinHttp:null,
        baseURL:null,
        skin:null,
        openIndex:null,
        init:function() {
            var ifr = null;

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
            _pfu.iframe = ifr;

            var prgArea = null;
            prgArea = document.createElement('div');
            prgArea.id = '_a_progress';
            prgArea.style.border = '1 solid red';
            prgArea.style.width  = '1000';
            document.body.appendChild(prgArea);
            _pfu.progress_area = prgArea;

            var infoArea = null;
            infoArea = document.createElement('div');
            infoArea.id = '_a_info';
            infoArea.style.border = '1 solid red';
            infoArea.style.width  = '1000';
            infoArea.innerHTML = '업로드정보';
            document.body.appendChild(infoArea);
            _pfu.info_area = infoArea;

            _pfu.xmlHttp= new asyncConnector('xmlhttp');
            _pfu.skinHttp= new asyncConnector('xmlhttp');
            //alert (_pfu.iframe.id);
        },
        start:function(chk) {
            //alert ( _pfu.form.length);
            var l = _pfu.form.length;
            var idx = 0;
            var _exec= true;
            if ( chk ) {
                for(var i=0;i<l;i++) {
                    if ( _pfu.form.elements[i].type.toLowerCase() == 'file' ){
                        _pfu.count++;
                        if( _exec && _pfu.form.elements[i].value.trim() == '' ) {
                            _exec = false;
                            idx = i;
                        }
                    }
                }
            }
            if( !_exec ) {
                alert('파일을 선택하세요.');
                _pfu.form.elements[idx].focus();
                return false;
            } else {
                _pfu.form.target = _pfu.iframe.name;
                _pfu.submit();

                return false;
            }
        },
        submit:function() {
            document.getElementById('_a_ready_state').innerHTML = 'start';

            _pfu.xmlHttp.openCallBack= function () {
                if ( _pfu.xmlHttp.readyState() == 4 ) {
                    //alert ( _pfu.xmlHttp.responseText() );

                    _pfu.xmlHttp.dataArea.innerHTML = _pfu.xmlHttp.responseText();
                    _pfu.openIndex = _pfu.xmlHttp.responseText();

                    if ( parseInt(_pfu.openIndex,10) > 0 ) {
                        //alert ( _pfu.openIndex );
                        _pfu.loadCss (_pfu.skin); // css load
                        _pfu.loadSkin(_pfu.skin); // skin load

                        var aUrl = _pfu.form.action;

                        var eI = aUrl.indexOf('?');
                            eI = eI>-1?eI:aUrl.length;
                        var fName = aUrl.substring(0,eI);
                            pStr  = aUrl.substring(eI);
                            pStr = pStr.replace(/[\?|\&]p_open_index=([\d]+)/g,'');
                            if ( pStr.charAt(0) == '&' || pStr.charAt(0) == '?' ) {
                                pStr = '&' + pStr.substring(1);
                                aUrl = fName + '?p_open_index=' + _pfu.openIndex + pStr;
                            } else {
                                aUrl = fName + '?p_open_index=' + _pfu.openIndex;
                            }
                        alert ( aUrl );
                        _pfu.form.action = aUrl;
                        _pfu.form.submit(); // 파일 서브밋 load
                        //_pfu.getInfo();
                        _pfu.timer = window.setInterval(_pfu.getInfo,500);
                    } else {
                       // alert('에러발생');
                    }
                }
            }
            _pfu.xmlHttp.open(_pfu.baseURL + 'check_upload.php?mode=get_open_index' , _pfu.info_area, 'GET',true)

            if ( document.all ) {
                _pfu.iframe.onreadystatechange = null;
                _pfu.iframe.onreadystatechange = function() {
                    if(_pfu.iframe.readyState=="complete"){
                        _pfu.end();
                    }
                }
            }
        },

        end:function(f) {
            document.getElementById('_a_ready_state').innerHTML = 'complete';
            window.clearInterval(_pfu.timer);
        },

        setForm:function(f) {
            _pfu.form = f;
            //alert ( _pfu.form );
        },
        loadSkin:function(skin) {
            _pfu.skinHttp.openCallBack= function () {
                if ( _pfu.skinHttp.readyState() == 4 ) {
                    //alert ( _pfu.xmlHttp.responseText );
                    _pfu.skinHttp.dataArea.innerHTML = _pfu.skinHttp.responseText();
                }
            }
            _pfu.skinHttp.open(_pfu.baseURL + 'skin/' + _pfu.skin + '/template.html' , _pfu.progress_area, 'GET',true);
        },
        loadCss:function(skin) {
            var script=document.createElement("link")
            script.setAttribute("rel", "stylesheet")
            script.setAttribute("type", "text/css")
            script.setAttribute("href", _pfu.baseURL + 'skin/' + skin + "/style.css");
            if (typeof(script)!="undefined") {
                document.getElementsByTagName("head")[0].appendChild(script);
            }
        },
        getInfo:function() {
            _pfu.xmlHttp.openCallBack= function () {
                //alert ();
                if ( _pfu.xmlHttp.readyState() == 4 ) {
                    //alert ( _pfu.xmlHttp.responseText() );
                    _pfu.count++;
                    _pfu.xmlHttp.dataArea.innerHTML = _pfu.count + ' / ' + getCookie('ZUfileSize') + ' / ' + _pfu.xmlHttp.responseText();
                    //_pfu.timer = window.setTimeout(_pfu.getInfo,10);
                }
            }
            _pfu.xmlHttp.open(_pfu.baseURL + 'check_upload.php?mode=get_size_info&p_open_index='+_pfu.openIndex , _pfu.info_area, 'GET',true)
        }
    }
function getCookie(name){
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length ){
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ){
				endOfCookie = document.cookie.length;
			}
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
		break;
	}
	return "";
}


/*
stopWatch.prototype.timeout = function(handler,delay){
    var self=this;
    var wrapper=function(){
        handler.call(self)
    };
    return window.setTimeout(wrapper,delay?delay:0)
}

*/
/*
    var curInfor = saveArea.document.saveMailForm.data[saveArea.curIdx].value;
    curInfor = curInfor.split('$$');
    document.mailerForm.to_name.value = curInfor[0];
    document.mailerForm.to_mail.value = curInfor[1];
    var progress = getObject('progress');
    var percent  = getObject('percent' );
    var infor_1  = getObject('infor_1' );
    var infor_2  = getObject('infor_2' );
    var send_message = saveArea.getObject('send_message');
    var proVal   = ( saveArea.curIdx  / saveArea.totCnt ) * 100 + '%';

    if ( parseInt(proVal) > 0 ) {
        progress.width      = proVal;
        var _proVal = Math.round(parseFloat(proVal),-2);
        percent.innerHTML   = _proVal + '%';
        if ( _proVal == 100 ) {
            infor_1.innerHTML   = ''         ;
            infor_2.innerHTML   = '발송 완료';
        }
    }
*/
    if     (window.addEventListener) window.addEventListener("load"  , _pfu.init, false);
    else if(window.attachEvent     ) window.attachEvent     ("onload", _pfu.init       );
////// ////// ////// ////// ////// ////// ////// ////// ////// ////// ////// ////// ////// ////// //////

    if     (window.addEventListener) window.addEventListener("load"  , function() {
                                                                                    _pfu.form = document.writeForm;
                                                                                    _pfu.form.action = './upload.php';
                                                                                    _pfu.baseURL     = 'http://localhost/progress_upload/';
                                                                                    _pfu.skin        = 'basic';
                                                                                   }, false);
    else if(window.attachEvent     ) window.attachEvent     ("onload", function() {
                                                                                    _pfu.form = document.writeForm;
                                                                                    _pfu.form.action = './upload.php';
                                                                                    _pfu.baseURL     = 'http://localhost/progress_upload/';
                                                                                    _pfu.skin        = 'basic';
                                                                                   }       );


//-->
</SCRIPT>

<BODY>
<div id=_a_ready_state>_a_ready_state</div>

<button onclick=>
</button>

<TABLE>
<form name="writeForm" enctype="multipart/form-data" method="post" onsubmit='return _pfu.start(false);' action='upload.php'>
<TR>
    <TD></TD>
    <TD></TD>
    <TD></TD>
    <TD></TD>
    <TD></TD>
</TR>
<TR>
    <TD></TD>
    <TD></TD>
    <TD></TD>
    <TD></TD>
    <TD></TD>
</TR>
<TR>
    <TD></TD>
    <TD></TD>
    <TD></TD>
    <TD></TD>
    <TD>
    <input type="file" name="up1" style="width:400"><br>
    <input type="file" name="up2" style="width:400"><br>
    <input type="file" name="up3" style="width:400"><br>
    <input type="file" name="up4" style="width:400"><br>
    <input type="file" name="up5" style="width:400"><br>
    <input type="submit" value="업로드"><br>
    </TD>
</TR>
</form>
</TABLE>


</BODY>
</HTML>
