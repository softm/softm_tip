
<script type="text/javascript">
<!--
function checkedValue ( obj ) {
	var rtn = "";
	if ( typeof( obj.length ) == "undefined" ) {
		if ( obj.checked ) {
			rtn = obj.value;
		} else {
			rtn = "";
		}
	} else {
		for ( var i=0; i<obj.length; i++){
			if ( obj[i].checked ) {
				rtn = obj[i].value;
				break;
			}
		}
	}
	return rtn;
}

var doubleTrans = false; // �ι� ���� ���۵��� �ʵ��� ó��.
function writeData(myForm) {
	if ( doubleTrans ) { return false; }
	if ( typeof ( myForm.cat_no ) == 'object' ) {
		if ( typeof( myForm.cat_no.selectedIndex ) == 'undefined' ) { // üũ �� ���� ����
			if ( checkedValue ( myForm.cat_no ) == '' ) {
				if ( typeof( myForm.cat_no.length ) == 'undefined' ) {
					if ( myForm.cat_no.type != 'hidden' ) {
						myForm.cat_no.focus();
						alert ( "ī�װ��� �������ּ���." );
						return false;
					}
				} else {
					myForm.cat_no[0].focus();
					alert ( "ī�װ��� �������ּ���." );
					return false;
				}
			}
		} else {
			if ( myForm.cat_no.value == '' ) {
				myForm.cat_no.focus();
				alert ( "ī�װ��� �������ּ���." );
				return false;
			}
		}
	}

	if ( typeof ( myForm.name ) == 'object' && ( myForm.name.value == '' || inStrAllBlankCheck ( myForm.name ) ) ) {
		alert ("�̸� �Է��� Ȯ���� �ּ���.");
		myForm.name.focus();
		return false;
	}

	if ( typeof ( myForm.e_mail ) == 'object' && myForm.e_mail.value !='' && ( inStrBlankCheck (myForm.e_mail) || !isEmail (myForm.e_mail) ) ) {
		alert ("�̸��� �Է��� Ȯ���� �ּ���.");
		myForm.e_mail.focus();
		return false;
	}

	if ( typeof ( myForm.home ) == 'object' && myForm.home.value !='' && inStrBlankCheck (myForm.home) ) {
		alert ("Ȩ������ �Է��� Ȯ���� �ּ���.");
		myForm.home.focus();
		return false;
	}

	if ( typeof ( myForm.title ) == 'object' && ( myForm.title.value == '' || inStrAllBlankCheck ( myForm.title ) ) ) {
		alert ("���� �Է��� Ȯ���� �ּ���.");
		myForm.title.focus();
		return false;
	}

    $("#dboardWForm").remove();
    $("<form></form>").attr("id","dboardWForm").appendTo('body');
    $($("form[name='writeForm']")[0].elements).clone().appendTo("#dboardWForm").hide();
    var attributes = $("form[name='writeForm']").prop("attributes");
    $.each(attributes, function() {
      if ( this.name != "name" && this.name != "onsubmit" ) {
        $("#dboardWForm").attr(this.name, this.value);
      }
    });
    var cO = $("#dboardWForm [name='content']");
    if ( cO ) {
        cO.val(myForm.content.value);
    }
    var c = cO.val();
	if ( myForm.html_yn && myForm.html_yn.checked ) {
        var reg = new RegExp( '<(/?)(script)\\b((?:[^>"\']|"[^"]*"|\'[^\']*\')*)>',"gim");
    //    console.info(reg);
    //    if(reg.test(input)){
    //       alert ( 'ok' );
    //    }
//        c = c.replace(reg,"<$1script$3>")
        c = c.replace(reg,"��$1$2$3>");
        c = c.replace(/ /gi, '&nbsp;');
		IframeSubmit.init();
		var ifrm = IframeSubmit.iframe;
		ifrm = (ifrm.contentWindow) ? ifrm.contentWindow : (ifrm.contentDocument.document) ? ifrm.contentDocument.document : ifrm.contentDocument;
		ifrm.document.open();
	    ifrm.document.write("<pre>"+c+"</pre>"); // swing
		ifrm.document.close();
    var v = ifrm.document.body.innerHTML;
		cO.val(v.substr(5,v.length-11));
    }

	if ( cO && !c ) {
		alert ("���� �Է��� Ȯ���� �ּ���.");
		myForm.content.focus();
		return false;
	}

	if ( typeof ( myForm.password ) == 'object' && myForm.password.value == '' ) {
		alert ("��� ��ȣ �Է��� Ȯ���� �ּ���.");
		myForm.password.focus();
		return false;
	}
	var url = getOnlyURL(document.location.href) + '?id=' + id;
	if ( exec == 'update' || exec == 'answer' ) {
		url += '&no=' + no;
	} else {
		exec = 'insert';
	}

	url += "&exec=" + exec + '_exec&npop=' + npop;
    $("#dboardWForm").attr("action",url);
	doubleTrans = true;
    $("#dboardWForm").submit();
	return false;
}

// html ��� ����
function htmlMode (obj) {
	if ( obj.checked ) {
		if ( confirm ( '�Խù� ���뿡 �ٹٲ��� ���� <BR>�� �����Ͻðڽ��ϱ�?' ) ) {
			obj.value = 'B';
		} else {
			obj.value = 'Y';
		}
	}
}

function objectHide( id, tier ) {
	var obj = null;
	if ( typeof(id) == 'object' ) {
		obj = id;
	} else {
		obj = getObject(id, tier);
	}
	if ( obj != null && typeof(obj) == 'object' ) {
		obj.style.visibility="hidden"
	}
}
function inStrBlankCheck(argu)
{
	if ( typeof ( argu ) == "object" ) { argu = argu.value; }
	var ii = 0;
	var ch1="";
	for (var i=0;i<argu.length;i++)
	{
		var ch1 = argu.charAt(i);
		if ( ch1 != ' ' ) ii=10;
		else ii = 0; break;
	}

	if ( ii == 0 ){ return true;} else { return false; }
}

/* �̸��� üũ �Լ� */
/* �������� �̸������� üũ �� ������� ��ȯ�Ѵ�. */
function isEmail (email){
	if ( typeof ( email ) == "object" ) email = email.value;
	//myRe=/^[\w-]+@[\w-]+([.][\w-]+){1,3}$/;
    myRe=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	myArray = myRe.exec(email);
	if(myArray) return true;
	else return false;
}

function hideFileInfor(name) {
    var obj = getObject(name);
//    obj.style = 'display:none';
    if ( obj != null && typeof(obj) != 'undefined' ) {
        obj.style.display = 'none';
    }
}

//-->
</SCRIPT>
