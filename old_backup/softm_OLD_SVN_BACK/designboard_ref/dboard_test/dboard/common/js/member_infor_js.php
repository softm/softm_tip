<?
if( defined("_dboard_member_infor_js_included") ) return;
	define ("_dboard_member_infor_js_included", true);
?>

<script type="text/javascript">
<!--
var member_register_popup_width = '<?=$member_register_popup_width?>';
var member_register_popup_height = '<?=$member_register_popup_height?>';
var member_update_popup_width = '<?=$member_update_popup_width?>';
var member_update_popup_height = '<?=$member_update_popup_height?>';
var member_secession_popup_width = '<?=$member_secession_popup_width?>';
var member_secession_popup_height = '<?=$member_secession_popup_height?>';
var member_login_popup_width = '<?=$member_login_popup_width?>';
var member_login_popup_height = '<?=$member_login_popup_height?>';
var member_view_scroll_yn = '<?=$member_view_scroll_yn?>';
var member_view_popup_width = '<?=$member_view_popup_width?>';
var member_view_popup_height = '<?=$member_view_popup_height?>';
var member_infor_search_popup_width = '<?=$member_infor_search_popup_width?>';
var member_infor_search_popup_height = '<?=$member_infor_search_popup_height?>';

<?if ( !$js_member_layer && $member_layer_box_use == 'Y' ) {
    echo ( " var eventGubun = \"" . strtolower ($member_layer_box_event) . "\";\n");
?>

function memberLayerBoxCB (eventGubun, contentStr, skinDir, pack_age,id,user_id,mailSendMethod,e_mail,name,memberLevel,mailPopupWidth, mailPopupHeight, home, memberViewMode, memberViewSuccUrl, memberViewPopupWidth, memberViewPopupHeight, memberViewScrollYn ) {
	var displayExec = false;

	var dboardMemberLayer = getObject('_d<?=$package?>_member_layer_box');
	contentStr = contentStr.replace(/\<\?=\$skinDir\?>/g ,skinDir);
	if ( home != '' ) {
		if ( home.indexOf( 'http://' ) == 0 ) {
			contentStr = contentStr.replace(/\<\?=\$a_home\?>/g ,"<a href='" + home + "' target='_blank'>");
		} else {
			contentStr = contentStr.replace(/\<\?=\$a_home\?>/g ,"<a href='http://" + home + "' target='_blank'>");
		}
		displayExec = true;
	} else {
		contentStr = contentStr.replace(/\<\?=\$a_home\?>/g ,'<a href="#" target="_blank">');
		contentStr = contentStr.replace(/\<\?=\$hide_home_s\?>/g ,'<!--' );
		contentStr = contentStr.replace(/\<\?=\$hide_home_e\?>/g ,'//-->');
	}

	if ( e_mail != '' ) {
		if ( mailSendMethod == '1' ) { // Æû¸ÞÀÏ
			contentStr = contentStr.replace(/\<\?=\$a_e_mail\?>/g ,"<a href='#' onClick='openFormMail   (\"" + pack_age + '","' + id + '","' + memberLevel + '","' + user_id + '","' + name + '","' + e_mail + '","' + mailPopupWidth + '","' + mailPopupHeight + '");return false;\'>');
		} else {					   // ¾Æ¿ô·è
			contentStr = contentStr.replace(/\<\?=\$a_e_mail\?>/g ,"<a href='#' onClick='openOutLookMail(\"" + pack_age + '","' + id + '","' + e_mail + '");return false;\'>');
		}
		displayExec = true;
	} else {
		contentStr = contentStr.replace(/\<\?=\$hide_e_mail_s\?>/g ,'<!--' );
		contentStr = contentStr.replace(/\<\?=\$hide_e_mail_e\?>/g ,'//-->');
	}
//  contentStr = contentStr.replace(/\<\?=\$a_member_view\?>/g ,'<a href="#" onClick=\'openMemberView("' + user_id + '","' + memberViewMode + '","' + memberViewSuccUrl + '","' + memberViewPopupWidth + '","' + memberViewPopupHeight + '","' + memberViewScrollYn + '");return false;\'>');
	contentStr = contentStr.replace(/\<\?=\$a_member_view\?>/g ,"<a href='#' onClick='window.open(\"" + baseDir + 'member_view.php?user_id='+ user_id + '","_dboard_m_view","width=' + member_view_popup_width + ',height=' + member_view_popup_height + ',toolbar=no,scrollbars=' + member_view_scroll_yn + '").focus();return false;\'>');
	contentStr = contentStr.replace(/\<\?=\$home\?>/g ,home);

// alert ( '<a href="#" onClick=\'window.open("' + baseDir + 'member_view.php?user_id='+ user_id + '","_dboard_m_view","width=' + member_view_popup_width + ',height=' + member_view_popup_height + ',toolbar=no,scrollbars=' + member_view_scroll_yn + '");return false;\'>' );
	if ( user_id == '' ) {
		contentStr = contentStr.replace(/\<\?=\$show_login_s\?>/g ,'<!--' );
		contentStr = contentStr.replace(/\<\?=\$show_login_e\?>/g ,'//-->');
	} else {
		displayExec = true;
	}
	if ( user_id != '' ) {
		contentStr = contentStr.replace(/\<\?=\$hide_login_s\?>/g ,'<!--' );
		contentStr = contentStr.replace(/\<\?=\$hide_login_s\?>/g ,'//-->');
	}
	if ( displayExec ) {
		dboardMemberLayer.innerHTML = contentStr;
		dboardMemberLayer.style.left = xPos;
		dboardMemberLayer.style.top  = yPos;
		dboardMemberLayer.style.visibility="visible";
		mouseEventClear ();

		if (is.ns) {
			if ( eventGubun == 'click' ) {
				document.body.onmousedown = dboardMemberLayerMouseDown;
			} else if ( eventGubun == 'mouseover' ) {
				document.body.onmousedown = dboardMemberLayerMouseDown;
			}
		} else if (is.ie) {
			if ( eventGubun == 'click' ) {
				document.body.onmousedown = dboardMemberLayerMouseDown;
			} else if ( eventGubun == 'mouseover' ) {
				document.body.onmousedown = dboardMemberLayerMouseDown;
			}
		}
	} else {
		dboardMemberLayer.style.visibility="hidden";
	}
}

var eventObj = null;
function dboardMemberLayerMouseDown	(e) {
    if (is.ie) {
	    targetObj = eventObj.srcElement;
    } else if (is.ns) {
//      alert ( ' eventObj.currentTarget : ' + eventObj.currentTarget );
//      alert ( ' eventObj : ' + typeof(e.target.type))  ;
	    targetObj = e.target;
    }

    if ( typeof(targetObj.type) == 'undefined' ) {
        var dboardMemberLayer = getObject('_d<?=$package?>_member_layer_box');
        dboardMemberLayer.style.visibility="hidden";
        document.body.onmousedown = null;
    } else {
        // event.returnValue = true;
    }
}

function dboardMemberLayerMouseClick   () {
	var dboardMemberLayer = getObject('_d<?=$package?>_member_layer_box');
	dboardMemberLayer.style.visibility="hidden";
	document.body.onmouseout = null;
}

var  xPos = 0;
var  yPos = 0;
var  mouseEventName = 0;

function mouseEventPosition (e) {
	if ( is.ie ) {
        eventObj = window.event;
		xPos = window.document.body.scrollLeft + window.event.clientX;
		yPos = window.document.body.scrollTop  + window.event.clientY;
	} else if( is.ns ) {
        eventObj = e;
		xPos = e.pageX;
		yPos = e.pageY;
	}
    //alert ( ' mouseEventPosition ' );
}
if ( eventGubun == 'click' ) {
    document.onmousedown = mouseEventPosition;
} else if ( eventGubun == 'mouseover' ) {
    document.onmousedown = mouseEventPosition;
}

function getMouseXPos() { return xPos;}
function getMouseYPos() { return yPos;}

function mouseEventClear () {
	if      ( mouseEventName == 'down' ) document.body.onmousedown = null;
	else if ( mouseEventName == 'move' ) document.body.onmousemove = null;
}

<?
    echo ( "function memberLayerBox (pack_age,id,user_id,mailSendMethod,e_mail,name,memberLevel,mailPopupWidth, mailPopupHeight, home, memberViewMode, memberViewSuccUrl, memberViewPopupWidth, memberViewPopupHeight, memberViewScrollYn) {\n");
        if ( file_exists($skinDir ."member_layer_box.php") ) { // È¸¿ø Á¤º¸ ·¹ÀÌ¾î »óÀÚ

            $fp = fopen ($skinDir . "member_layer_box.php", "r");
            $member_layer_content = '';
            while (!feof ($fp)) {
                $tmp_content = fgets ($fp,1024);
                $tmp_content = str_replace("\n", ""  , $tmp_content);
                $tmp_content = str_replace("\r", ""  , $tmp_content);
                $tmp_content = str_replace('"' , '\"', $tmp_content);
                $member_layer_content .= $tmp_content ;
            }
            echo ( " var contentStr = \"$member_layer_content\";\n");
            echo ( " var skinDir = \"$skinDir\";\n");
            echo ( " memberLayerBoxCB(eventGubun, contentStr, skinDir, pack_age,id,user_id,mailSendMethod,e_mail,name,memberLevel,mailPopupWidth, mailPopupHeight, home, memberViewMode, memberViewSuccUrl, memberViewPopupWidth, memberViewPopupHeight, memberViewScrollYn);\n");
        }
    echo ( "}\n");

	$js_member_layer = true;
}
?>

<?if ( !$js_open_form_mail && $mailSendMethod == '1' ) {?>
function openFormMail (gubun, id, member_level, user_id, name, e_mail, width, height) {
    var mailForm = document.<?=$package?>MailForm;
//	mailForm.gubun.value   = gubun      ;
//	mailForm.exec.value    = 'send_mail';
//	mailForm.id.value      = id     ;
//	mailForm.member_level.value = member_level;
//	mailForm.user_id.value = user_id;
//	mailForm.to_name.value = name   ;
//	mailForm.to_mail.value = e_mail ;
//	var mailWin = window.open("about:blank","_d_mail","width=" + width + ",height=" + height + ",toolbar=no,scrollbars=no");
//	mailWin.focus();
//	mailForm.target ='_d_mail';
//	mailForm.action = baseDir + 'form_mail.php?send_mail_method=1';
//	mailForm.submit();
    var params = "&gubun="          + encodeURIComponent(gubun          )
               + "&exec="           +                   ('send_mail'    )
               + "&id="             + encodeURIComponent(id             )
               + "&member_level="   + encodeURIComponent(member_level   )
               + "&user_id="        + encodeURIComponent(user_id        )
               + "&to_name="        + encodeURIComponent(name           )
               + "&to_mail="        + encodeURIComponent(e_mail         )
        ;
	var mailWin = window.open(baseDir + 'form_mail.php?send_mail_method=1'+params,"_d_mail","width=" + width + ",height=" + height + ",toolbar=no,scrollbars=no");
	mailWin.focus();
//	mailForm.target ='_d_mail';
//	mailForm.action = baseDir + 'form_mail.php?send_mail_method=1';
//	mailForm.submit();

}
<?
	$js_open_form_mail = true;
} else if ( !$js_open_outlook_mail ){?>
function openOutLookMail ( gubun, id, e_mail ) {
	mailForm.gubun.value   = gubun         ;
	mailForm.exec.value    = 'outlook_mail';
	mailForm.id.value      = id     ;
	mailForm.to_mail.value = e_mail ;
	mailForm.target ='_d<?=$package?>_iframe';
	mailForm.action = baseDir + 'form_mail.php?send_mail_method=2';
	mailForm.submit();
}
<?
	$js_open_outlook_mail = true;
}?>

//-->
</SCRIPT>
