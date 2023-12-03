<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE> New Document </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
 </HEAD>
  <SCRIPT LANGUAGE="JavaScript">
  <!--
    var fileUpload = {
        callBack:null,
        url:null,
        readyState:0,
        iframe:null,
        form:null,
        init:function(){
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
            fileUpload.iframe = ifr;
            fileUpload.iframe.style.display = 'inline';
            if ( document.all ) {
                fileUpload.iframe.onreadystatechange = function() {
                    if (fileUpload.iframe.readyState == 'complete') {
                        if (fileUpload.callBack) fileUpload.callBack();
                    }
                }
            } else {
                fileUpload.iframe.onload = function() {
                    if ( fileUpload.readyState == 1 ) {
                        if (fileUpload.callBack) fileUpload.callBack();
                    } else {
                        fileUpload.readyState++;
                    }
                }
            }
        }
        ,setForm:function(f,url,cb){
            fileUpload.callBack = cb;
            fileUpload.url = url;
            f.target = '_up_frame';
            f.encType="multipart/form-data";
            f.method="POST";
            f.action = url;
            fileUpload.form = f;
        }
        ,submit:function(f){
            fileUpload.form.submit();
        }
    };

    fileUpload.init();

    function init() {
        var ff = document.createElement('input');
            ff.type = 'file';
            ff.value = 'C:\selog.txt';
            document.upForm.appendChild(ff);
    }

    function testSubmit() {
        fileUpload.setForm(document.upForm,'/sample/upload.php', function () {alert('전송완료');}  );
        fileUpload.submit();
    }

  //-->
</SCRIPT>
 <BODY onload='init()'>

  <button onclick='testSubmit();'>
  </button>
    <form name="upForm" >
    </form>
<SCRIPT LANGUAGE="JavaScript">
<!--
fileUpload.init();
//-->
</SCRIPT>
 </BODY>
</HTML>
