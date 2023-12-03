function onInit() {
//    //alert("load");
//    //alert(Util.Browser.msie);
//    if (jQuery.browser.msie) {
//        document.wForm.user_name.onfocus=Util.Form.placeHolder;
//        document.wForm.user_id.onfocus=Util.Form.placeHolder;
//      //document.wForm.passwd.onfocus=Util.Form.placeHolder;
//      //document.wForm.passwd.setAttribute("org_type",document.wForm.passwd.type);
//      //document.wForm.passwd.type = "text";
//    }

}

//function 파일업로드() {
//    //loading.show();        
//    //fileUpload.submit();
//}

function 파일업로드() {
	callService({
	    requestType : 'form', // JSON, POST
	    dataType    : 'xml' , // xml,html,script,json
		infor:{
		   className  : 'sample.Sample' ,
		   method     : 'sample.Sample.get' ,
		   params     : '',
	       argus      : {
	           p_user_name:'1',
	           p_user_id:'2',
	           p_passwd:'3'
	       }
		},
		form:$S("wForm"),
	    cb:function(xmlDoc){
//	    	alert(xmlDoc);
	        var json  = Util.xml2json(xmlDoc);
	        //json["return"];
	        alert(json["return"]);
	    },
	    debug:false,
	    contentType:"text/xml; charset=UTF-8"
	});
	
    return false;
}
