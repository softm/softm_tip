<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE> New Document </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
 </HEAD>

 <BODY>
  <SCRIPT LANGUAGE="JavaScript">
  <!--
var xmlHttp = null;
function startRequest()
{
    xmlHttp=createXmlHttpRequest();
    var video="D:\\Project\\okmmc_doc\\progress_upload\\updata\\pipedream.wmv";
    xmlHttp.open("POST","./upload.php",true);
    xmlHttp.onreadystatechange=handleStateChange;
    xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlHttp.send("up1="+video);

}
function handleStateChange()
{
    var message=" ";
    if(xmlHttp.readyState==4)
    {
        var results=xmlHttp.responseText;
        alert (results);
        document.getElementById("div1").style.visibility = "visible"; 

        document.getElementById('div1').innerHTML = results;

    }

    else
    {
        alert ('xxxxxxxxxxxx');
    }
}



function createXmlHttpRequest()
{
    alert ();
    if ( document.all) {
        xmlHttp = new ActiveXObject('MSXML2.XMLHTTP.3.0'); // XMLHttpRequest Object
    } else {
        xmlHttp = new XMLHttpRequest(); // XMLHttpRequest Object
    }
    return xmlHttp;
}
  //-->
  </SCRIPT>
<button onclick='startRequest();'></button>
<div id='div1'></div>
 </BODY>
</HTML>
