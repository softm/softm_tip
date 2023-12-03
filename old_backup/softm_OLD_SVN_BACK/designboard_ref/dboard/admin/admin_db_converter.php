<?
$baseDir = '../';
include ( "../common/lib.inc"          ); // 공통 라이브러리
include ( "../common/message.inc"      ); // 에러 페이지 처리

if ( $config ) {
    $memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
    $libDir = "lib/" . $sysInfor['driver'] . '/';
    if ( $memInfor['admin_yn'] == "Y" ) {
    head("디자인보드 DB 변환 툴","init();");          // Header 출력
    _css($baseDir);
	include $baseDir.'common/js/common_js.php'; // 공통 javascript
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
    var st_fRead     = '0' ; // 0 : 대기, 1 : 읽기 시작, 2 : 읽기 종료(성공), 3 : 읽기 종료(실패), 4 : 변환 시작, 5 : 변환 종료, 6 : 변환 실패
    var msgObj       = null; // 메세지 출력을 위한 객체
    var fInforObj    = null; // 파일 정보
    var backFileInfor= null; // 백업 파일 정보 출력 영역

    var curKindData  = null; // 컨버팅 데이터

    var dataPannelObj      = null; // dataPannel IFRAME   OBJECT
    var dataPannelWindow   = null; // dataPannel WINDOW   OBJECT
    var dataPannelDocument = null; // dataPannel DOCUMENT OBJECT

    var dataExecObj        = null; // dataExec   IFRAME   OBJECT
    var dataExecWindow     = null; // dataExec   WINDOW   OBJECT
    var dataExecDocument   = null; // dataExec   DOCUMENT OBJECT
    var total              = 0;
    var member_tot         = 0;
    var member_kind_tot    = 0;

    var board_tot          = 0;
    var category_tot       = 0;
    var comment_tot        = 0;
    var grant_tot          = 0;
    var point_tot          = 0;
    var bbs_id             = null;
    var progressObj = null;
    var percentObj  = null;

    function readTempage(gubun) {
        document.dataReadyForm.target = 'dataPannel';
        document.dataReadyForm.submit();
        readStart();
    }

    function readEnd() {
        curKindData  = document.dataReadyForm.kind_data.value            ; // 컨버팅 데이터
        document.dataConvertForm.kind_data.value  = curKindData  ;
        if ( st_fRead == '2' ) { // 읽기 성공
            if ( curKindData == 'member' ) {
                member_tot          = getObject ( 'member_tot'       ,'dataPannel').innerHTML;
                member_kind_tot     = getObject ( 'member_kind_tot'  ,'dataPannel').innerHTML;
                total = parseInt(member_tot) + parseInt(member_kind_tot);

                getObject('member_total'                ).innerHTML = member_tot        ; // 회원 총수
                getObject('member_insert_total'         ).innerHTML = member_tot        ; // 회원

                getObject('member_kind_total'           ).innerHTML = member_kind_tot   ; // 회원 종류 총수
                getObject('member_kind_insert_total'    ).innerHTML = member_kind_tot   ; // 회원 종류
                getObject('board_total'                 ).innerHTML = 0                 ; // 게시글 총수
                getObject('board_insert_total'          ).innerHTML = 0                 ; // 게시글

                getObject('category_total'              ).innerHTML = 0                 ; // 카테고리 총수
                getObject('category_insert_total'       ).innerHTML = 0                 ; // 카테고리

                getObject('comment_total'               ).innerHTML = 0                 ; // 의견글 총수
                getObject('comment_insert_total'        ).innerHTML = 0                 ; // 의견글

                getObject('grant_total'                 ).innerHTML = 0                 ; // 권한 총수
                getObject('grant_insert_total'          ).innerHTML = 0                 ; // 권한

            } else if ( curKindData == 'board' ) {
                board_tot          = parseInt( getObject ( 'board_tot'   ,'dataPannel').innerHTML );
                category_tot       = parseInt( getObject ( 'category_tot','dataPannel').innerHTML );
                comment_tot        = parseInt( getObject ( 'comment_tot' ,'dataPannel').innerHTML );
                grant_tot          = parseInt( getObject ( 'grant_tot'   ,'dataPannel').innerHTML );
                point_tot          = parseInt( getObject ( 'point_tot'   ,'dataPannel').innerHTML );
                bbs_id             =           getObject ( 'bbs_id'      ,'dataPannel').innerHTML  ;
                total = board_tot + category_tot + comment_tot + grant_tot + point_tot;

                getObject('board_total'                 ).innerHTML = board_tot     ; // 게시글 총수
                getObject('board_insert_total'          ).innerHTML = 0             ; // 게시글

                getObject('category_total'              ).innerHTML = category_tot  ; // 카테고리 총수
                getObject('category_insert_total'       ).innerHTML = 0             ; // 카테고리

                getObject('comment_total'               ).innerHTML = comment_tot   ; // 의견글 총수
                getObject('comment_insert_total'        ).innerHTML = 0             ; // 의견글

                getObject('grant_total'                 ).innerHTML = grant_tot + point_tot; // 권한 총수
                getObject('grant_insert_total'          ).innerHTML = 0                    ; // 권한

                getObject('member_total'                ).innerHTML = 0             ; // 회원 총수
                getObject('member_insert_total'         ).innerHTML = 0             ; // 회원

                getObject('member_kind_total'           ).innerHTML = 0             ; // 회원 종류 총수
                getObject('member_kind_insert_total'    ).innerHTML = 0             ; // 회원 종류

            }

            getObject('all_kind_total'       ).innerHTML = total        ; // 전체 자료수
            getObject('all_kind_insert_total').innerHTML = 0            ; // 전체

            objectShow( 'convert_bt' );
            fInforObj           = getObject ( 'convert_file','dataPannel');
            backFileInfor.innerHTML = '(<font color="990000"><strong> 백업 파일명 : ' + fInforObj.innerHTML + '.sql</strong></font> )';
        } else if ( st_fRead == '3' ) { // // 읽기 실패
            clearInfor();
        }
    }

    function readStart() {
        msgObj.innerHTML = '잠시만 기다려 주세요.';
        st_fRead = '1';
    }

    function initMsg(kindData) {
//      alert ( curKindData );
        if ( typeof(kindData)!='undefined' && kindData == '' ) {
            alert ( '데이터 종류를 선택해주세요.' );
            document.dataReadyForm.kind_data.focus();
            return false;
        }
        clearInfor();
    }

    function clearInfor() {
        fInforObj           = null;
        member_tot          = 0;
        member_kind_tot     = 0;
        board_tot           = 0;
        category_tot        = 0;
        comment_tot         = 0;
        grant_tot           = 0;
        objectHide( 'convert_bt' );
        progressObj.width       ='';
        percentObj.innerHTML    ='';
        backFileInfor.innerHTML ='';
        st_fRead = '0';
    }

    function init() {
        objectPosition('board_statistics' , 'absolute' );
        objectPosition('member_statistics', 'absolute' );
        objectHide('board_statistics' );
        objectHide('member_statistics');

        msgObj      = getObject('msg'     ); // 메시지 객체
        progressObj = getObject('progress');
        percentObj  = getObject('percent' );
        backFileInfor= getObject('file_infor' );

        initMsg();
        objectHide( 'convert_bt' ); // 변환 버튼

        dataPannelObj      = getObject("dataPannel")    ;
        dataPannelWindow   = dataPannelObj.contentWindow;
        dataPannelDocument = dataPannelWindow.document  ;

        dataExecObj        = getObject("dataExec"  )    ;
        dataExecWindow     = dataExecObj.contentWindow  ;
        dataExecDocument   = dataExecWindow.document    ;
    }

    function kindChange(val) {
        clearInfor();
        curKindData  = document.dataReadyForm.kind_data.value            ; // 컨버팅 데이터
        if ( curKindData == 'board' ) {
            msgObj.innerHTML    = '디자인 보드 게시판 복구';
            objectShow('board_statistics' );
            objectPosition('board_statistics' , 'relative' );
            objectHide('member_statistics');
            objectPosition('member_statistics' , 'absolute' );
        } else if ( curKindData == 'member' ) {
            msgObj.innerHTML    = '디자인 보드 회원 복구';
            objectHide('board_statistics' );
            objectPosition('board_statistics' , 'absolute' );
            objectShow('member_statistics');
            objectPosition('member_statistics' , 'relative' );
        } else {
            msgObj.innerHTML    = '상태표시를 나타내는 부분입니다.';
            objectHide('board_statistics' );
            objectHide('member_statistics');
        }

        clearInfor();
    }

    function dataConverStart() {
        if ( fInforObj != null && fInforObj.innerText != '' && st_fRead != '4' ) {
            document.dataConvertForm.c_file.value     = fInforObj.innerText;
            if ( curKindData == 'member' ) {
                document.dataConvertForm.member_order.value      = getObject ( 'member_order'       ,'dataPannel').innerHTML;
                document.dataConvertForm.member_kind_order.value = getObject ( 'member_kind_order'  ,'dataPannel').innerHTML;
            } else if ( curKindData == 'board' ) {
                document.dataConvertForm.infor_order.value      = getObject ( 'infor_order'   ,'dataPannel').innerHTML;
                document.dataConvertForm.board_order.value      = getObject ( 'board_order'   ,'dataPannel').innerHTML;
                document.dataConvertForm.category_order.value   = getObject ( 'category_order','dataPannel').innerHTML;
                document.dataConvertForm.comment_order.value    = getObject ( 'comment_order' ,'dataPannel').innerHTML;
                document.dataConvertForm.grant_order.value      = getObject ( 'grant_order'   ,'dataPannel').innerHTML;
                document.dataConvertForm.point_order.value      = getObject ( 'point_order'   ,'dataPannel').innerHTML;
                document.dataConvertForm.bbs_id.value           = bbs_id;
            }
            document.dataConvertForm.submit();
            msgObj.innerHTML = '변환 시작....';
            st_fRead = '4';
        }
    }

    function dataConverEnd() {
        if ( st_fRead == '4' ) {
            msgObj.innerHTML = '변환 종료....';
            objectHide( 'convert_bt' );
            total = 0;
            st_fRead = '5';
        } else if ( st_fRead == '6' ) { // 변환 실패
        }
    }
    function progress(gubun, totProgCnt, curCnt ) {

        var proVal   = parseInt(( totProgCnt / parseInt(total) ) * 100);
            percentObj.innerHTML   = Math.round(parseFloat(proVal),-2) + '%';
            if ( proVal > 0 ) {
                progressObj.width      = proVal + '%';
            }

            if ( gubun == 'board' ) {
                getObject('board_insert_total'          ).innerHTML = curCnt; // 게시글
            }

            if ( gubun == 'category' ) {
                getObject('category_insert_total'       ).innerHTML = curCnt; // 카테고리
            }

            if ( gubun == 'comment' ) {
                getObject('comment_insert_total'        ).innerHTML = curCnt; // 의견글
            }

            if ( gubun == 'grant' ) {
                getObject('grant_insert_total'          ).innerHTML = curCnt; // 권한
            }

            if ( gubun == 'member' ) {
                getObject('member_insert_total'         ).innerHTML = curCnt; // 회원
            }

            if ( gubun == 'member_kind' ) {
                getObject('member_kind_insert_total'    ).innerHTML = curCnt; // 회원 종류
            }

            getObject('all_kind_insert_total').innerHTML = totProgCnt   ; // 전체

//          dataPannelDocument.write ( proVal +'<BR>');
//          send_message.innerHTML   = '총 <span class="text_04">' + saveArea.totCnt + '</span>명중 <span class="text_04">' + ( saveArea.curIdx ) + '</span>명 의 회원께 발송중입니다.';
    }

function objectShow( id, tier ) {
	var obj = null;
	if ( typeof(id) == 'object' ) {
		obj = id;
	} else {
		obj = getObject(id, tier);
	}
	if ( obj != null && typeof(obj) == 'object' ) { 
		obj.style.visibility="visible"
	}
/*        obj.style.zIndex=0;     Object들의 기본적인 zIndex 값은 0 입니다. */
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

/* sytle의 Position 값을 설정합니다.
   static , relative, absolute*/
function objectPosition(id,position, tier) {
	var obj = null;
	if ( typeof(id) == 'object' ) {
		obj = id;
	} else {
		obj = getObject(id, tier);
	}
	if ( obj != null && typeof(obj) == 'object' ) { 
		obj.style.position=position;
	}
}
//-->
</SCRIPT>
<table width="100%" height="100%" border="0" cellpadding="20" cellspacing="0" class="text_01">
  <tr>
    <td valign="top"><strong>디자인보드 백업자료 복구</strong><br>
      <br>

      <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01">
<form name='dataReadyForm' method='post' action='admin_db_converter_data.php' enctype="multipart/form-data">
    <input type='hidden' name='kind_board' value='dboard'>
        <tr>
          <td width="100" align="right" bgcolor="efefef"><strong>데이타종류&nbsp;</strong></td>
          <td bgcolor="fafafa">
            <SELECT name="kind_data" class="listbox_01" onChange='kindChange();'>
                <option selected        >백업종류선택</option>
                <option value='board'   >게시판백업  </option>
                <option value='member'  >회원백업    </option>
            </SELECT>
          </td>
        </tr>
        <tr>
          <td align="right" bgcolor="efefef"><strong>파일선택</strong>&nbsp;</td>
          <td bgcolor="fafafa">
            <input type='file'  name='data_file'  onChange="readTempage('header');" onClick='return initMsg(document.dataReadyForm.kind_data.value);' class="textarea_01">
            &nbsp;<button id='convert_bt' style='visibility:hidden' class="submit_01" onClick='dataConverStart();'>변환 시작</button>
          </td>
        </tr>
</form>
        <tr>
          <td align="right" bgcolor="efefef"><strong>상태표시&nbsp;</strong></td>
          <td bgcolor="fafafa"><font color="990000"><span id='msg'>상태표시를 나타내는 부분입니다.</span></font></td>
        </tr>
        <tr>
          <td align="right" bgcolor="efefef"><strong>진행상황&nbsp;</strong></td>
          <td bgcolor="fafafa">
            <table width="600" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="500">
                  <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="828282">
                    <tr>
                      <td height="20" id='progress' width="" bgcolor="990000"></td>
                      <td bgcolor="#FFFFFF" width='1'></td>
                    </tr>
                  </table></td>
                <td width="10">&nbsp;</td>
                <td class="text_01"><font color="990000">
<span id='percent'></span>
                </font></td>
              </tr>
            </table>
            </td>
        </tr>
      </table>
      <br>
      <strong><font color="990000"><strong><br>
      </strong></font>백업자료 <font color="990000"></font> 상세보기 <span id='file_infor'></span><br>
      </strong><br>
      <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01">
        <tr>
          <td width="100" align="right" bgcolor="efefef">
<p><strong>데이타통계&nbsp;</strong></p></td>
          <td bgcolor="fafafa"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%" valign="top">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01">
                    <tr align="center" bgcolor="eeeeee">
                      <td height="30" colspan="2"><strong> 전체현황 통계</strong></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td width="100" bgcolor="f7f7f7">복구할 자료 </td>
                      <td><font color="990000"><span id='all_kind_total'               >0</span></font>개 (명)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7"> 복구된 자료</td>
                      <td><font color="990000"><span id='all_kind_insert_total'        >0</span></font>개 (명)</td>
                    </tr>
                  </table></td>
                <td>&nbsp;&nbsp;</td>
                <td width="50%" valign="top">
                  <table id='board_statistics' width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01" style='visibility:hidden;position:absolute'>
                    <tr align="center" bgcolor="#FFFFFF">
                      <td height="30" colspan="4" bgcolor="eeeeee"><strong>게시판 백업 부분현황 통계</strong></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td width="100" bgcolor="f7f7f7">복구할 게시글</td>
                      <td><font color="990000"><span id='board_total'                  >0</span></font>개 (명)</td>
                      <td bgcolor="f7f7f7">복구된 게시글 </td>
                      <td><font color="990000"><span id='board_insert_total'           >0</span></font>개 (명)</td>
                    </tr>

                    <tr bgcolor="#FFFFFF">
                      <td width="100" bgcolor="f7f7f7">복구할 카테고리</td>
                      <td><font color="990000"><span id='category_total'               >0</span></font>개 (명)</td>
                      <td bgcolor="f7f7f7">복구된 카테고리</td>
                      <td><font color="990000"><span id='category_insert_total'        >0</span></font>개 (명)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7">복구할 의견글</td>
                      <td><font color="990000"><span id='comment_total'                >0</span></font>개 (명)</td>
                      <td bgcolor="f7f7f7">복구된 의견글</td>
                      <td><font color="990000"><span id='comment_insert_total'         >0</span></font>개 (명)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7">복구할 권한</td>
                      <td><font color="990000"><span id='grant_total'                  >0</span></font>개 (명)</td>
                      <td bgcolor="f7f7f7">복구된 권한</td>
                      <td><font color="990000"><span id='grant_insert_total'           >0</span></font>개 (명)</td>
                    </tr>
                  </table>
                  <table id='member_statistics' width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01" style='visibility:hidden;position:absolute'>
                    <tr align="center" bgcolor="#FFFFFF">
                      <td height="30" colspan="2" bgcolor="eeeeee"><strong>회원 백업 부분현황 통계</strong></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td width="100" bgcolor="f7f7f7">복구할 회원 총수 </td>
                      <td><font color="990000"><span id='member_total'                 >0</span></font>개 (명)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7">복구된 회원 </td>
                      <td><font color="990000"><span id='member_insert_total'          >0</span></font>개 (명)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7">복구할 회원종류 총수 </td>
                      <td><font color="990000"><span id='member_kind_total'            >0</span></font>개 (명)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7">복구된 회원종류</td>
                      <td><font color="990000"><span id='member_kind_insert_total'     >0</span></font>개 (명)</td>
                    </tr>
                  </table>
                 </td>
              </tr>
            </table>
            </td>
        </tr>
      </table>
      </td>
<iframe marginHeight='0' marginWidth='0' frameborder='0' width='0%' height='0%' name='dataPannel' id='dataPannel' scrolling='yes' src='admin_db_converter_data.php'></iframe><BR>
<iframe marginHeight='0' marginWidth='0' frameborder='0' width='0%' height='0%' name='dataExec'   id='dataExec' scrolling='yes' src='<?=$libDir?>admin_db_converter_exec.php'></iframe>
<form name='dataConvertForm' method='post' target='dataExec' action='<?=$libDir?>admin_db_converter_exec.php'>
    <input type='hidden' name='kind_board'        value=''>
    <input type='hidden' name='kind_data'         value=''>
    <input type='hidden' name='c_file'            value=''>
    <input type='hidden' name='member_order'      value=''>
    <input type='hidden' name='member_kind_order' value=''>
    <input type='hidden' name='board_order'       value=''>
    <input type='hidden' name='category_order'    value=''>
    <input type='hidden' name='comment_order'     value=''>
    <input type='hidden' name='grant_order'       value=''>
    <input type='hidden' name='point_order'       value=''>
    <input type='hidden' name='infor_order'       value=''>
    <input type='hidden' name='bbs_id'            value=''>
</form>
  </tr>
</table>
<?
        footer(); // Footer 출력
    }
} // if END
else {
    head();          // Header 출력
    _css($baseDir);
    Message ("U", "0002", "MOVE:setup.php:설치 ..");
} // else END
?>