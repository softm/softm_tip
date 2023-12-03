<SCRIPT LANGUAGE="JavaScript">
<!--
function listPage() {
	document.boardPageForm.exec.value = 'list';
	document.boardPageForm.sort.value = '';
	document.boardPageForm.desc.value = '';
	document.boardPageForm.no.value = '';
	document.boardPageForm.target = '';
	document.boardPageForm.action = '';
	document.boardPageForm.submit();
}

function inStrAllBlankCheck (argu) {
	if ( typeof ( argu ) == "object" ) argu = argu.value;
	var ch1="";
	for (var i=0;i<argu.length;i++) ch1 += " ";
	if ( argu == ch1 ) return true;
	else return false;
}

function imageAutoResize () {
    var displayObj = getObject('_d_display_obj');
    var imageLimitObj = getObject('_dboard_image_limit_width');

    var displayObjWidth = null;
    var imageLimitWidth = null;

    if ( displayObj != null && displayObj != 'undefined' && imageLimitObj != null && imageLimitObj != 'undefined' ) {
        if ( typeof( displayObj.length ) != 'undefined' ) {
            if ( typeof( imageLimitObj.length ) == 'undefined' ) {
                imageLimitWidth = imageLimitObj.width;
            }

            for ( var k=0; k<displayObj.length; k++ ) {
                if ( typeof( imageLimitObj.length ) != 'undefined' ) {
                    imageLimitWidth = imageLimitObj[k].width;
                }

                displayObjWidth = displayObj[k].width;

                if ( displayObjWidth > imageLimitWidth ) {
                    displayObj[k].width = imageLimitWidth;
                }
            }
        } else {
            imageLimitWidth   = imageLimitObj.width;
            displayObjWidth = displayObj.width;
            if ( displayObjWidth > imageLimitWidth ) {

                displayObj.width = imageLimitWidth;
            }
        }
    }
}

<?if ( $bbsInfor['use_category'] == 'Y') {?>
function categorySearch (myForm) {
	myForm.target = '';
	myForm.action = getActionUrl(myForm);
	myForm.submit();
}
function categoryLinkSearch (cat_no) {
	document.boardPageForm.search_cat_no.value = cat_no;
	document.boardPageForm.method = 'get';
	document.boardPageForm.target = '';
	document.boardPageForm.action = '';
	document.boardPageForm.submit();
}
// 체크박스 카테고리 선택
function checkBoxCategoryT(myform,obj,mode) {
	if ( typeof(obj.form) == 'object' ) {
		if ( mode == 'W' ) {
			if ( typeof(myform.cat_no.length) != 'undefined' ) {
				setCheckedAll ( myform.cat_no, false );
				obj.checked = true;
			}
		} else if ( mode == 'S' ) {
//                alert ( typeof(myform.search_cat_no.length) );
			if ( typeof(myform.search_cat_no.length) != 'undefined' ) {
				setCheckedAll ( myform.search_cat_no, false );
				obj.checked = true;
			}
		}
	}
}
function setCheckedAll ( obj, boolVal ) {
	var oppVal = !boolVal;
	if ( isNaN ( obj.length ) ) {
		obj.checked = boolVal;
	} else {
		for (i=0 ; i<obj.length; i++) obj[i].checked = boolVal;
	}
}
<?}?>
//-->
</SCRIPT>
