<?
/*
* include 되었는지를 검사
**/
if( defined("_dboard_lib_included") ) return;
    define ("_dboard_lib_included", true);

// 테이블 정보 설정
$tb_bbs_infor           = "kyh_bbs_infor"   ;
$tb_bbs_category        = "kyh_bbs_category";
$tb_bbs_abstract        = "kyh_bbs_abstract";
$tb_bbs_skin            = "kyh_bbs_skin"    ;
$tb_bbs_grant           = "kyh_bbs_grant"   ;
$tb_point_infor         = "kyh_point_infor" ;
$tb_bbs_data            = "kyh_bbs_data"    ;
$tb_bbs_comment         = "kyh_bbs_comment" ;

$tb_bbs_file            = "kyh_bbs_file"    ;

/*
* 함수명: _admin_bbsListBox
* 설명  : 게시판 정보를 조회하여 리스트 상자를 출력 합니다.
* 예)  _admin_bbsListBox('게시판 아이디')
* Argus : bbsId : 게시판 아이디
**/
function _admin_bbsListBox ($bbsId='') {
//include ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
// 데이터베이스에 접속합니다.
//$db = initDBConnection ($sysInfor["host_nm"],$sysInfor["db_nm"],$sysInfor["id"],$sysInfor["password"],$sysInfor["driver"]);
    global $tb_bbs_infor;
    global $id          ;
    $sql = "select no, bbs_id from $tb_bbs_infor where bbs_id != '$id' order by no desc;";
    $stmt = multiRowSQLQuery($sql);
    $_rtn  = "\n<select id='_dboard_s_id' name='_dboard_s_id' class='admin_listbox'>";
    $_rtn .= "<option value=''>&nbsp;&nbsp;게시판선택&nbsp;&nbsp;</option>";
    while ( $row = multiRowFetch  ($stmt) ) {
            if($bbsId==$row['bbs_id']) $select="selected"; else $select="";
            $_rtn .= "<option value=" . $row['bbs_id'] . " $select>". $row['bbs_id'] . "</option>";
    }
    $_rtn .= "</select>\n";
    return $_rtn;
}

/*
* 함수명: getPointGrant
* 설명  : 게시판별 포인트 정보를 조회 합니다.
* Argus : $bbsId : 게시판 아이디
*
   1 : "일정 작성"
   2 : "의견글 작성"
   3 : "파일 업로드"
   4 : "다운로드"
   5 : "답글작성"
**/
function getPointGrant ($bbsId, $memberLevel, $no) {
    global $tb_point_infor;
    $point = 0;
    if ( $memberLevel > 0 ) { // 비회원이 아니면
        global $tb_point_infor, $tb_member;
        $sql = "select point from $tb_point_infor where bbs_id='$bbsId' and no = '$no' and member_level = '$memberLevel';";
        $point = (int) simpleSQLQuery($sql);
    }
    return $point;
}

/*
* 함수명: getBbsInfor
* 설명  : 게시판 정보를 조회 합니다.
* Argus : $bbsId : 게시판 아이디
**/
function getBbsInfor ($bbsId) {
    global $tb_bbs_infor;
    $sql = "select * from $tb_bbs_infor where bbs_id='$bbsId';";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $bbsInfor = singleRowSQLQuery($sql);
    return $bbsInfor;
}

/*
* 함수명: getNoticeInfor
* 설명  : 게시판 추출 정보를 조회 합니다.
* Argus : $bbsId : 게시판 아이디
**/
function getNoticeInfor ($bbsId) {
    global $tb_bbs_abstract;
    $sql = "select * from $tb_bbs_abstract where bbs_id='$bbsId';";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $noticeInfor = singleRowSQLQuery($sql);
    return $noticeInfor;
}

/*
* 함수명: getBbsGrant
* 설명  : 게시판 권한 조회 합니다.
* Argus : $bbsNo       : 게시판 번호
*       : $memberLevel : 회원 레벨
**/
function getBbsGrant ($bbsNo,$memberLevel) {
    global $tb_bbs_grant;
    $sql = "select * from $tb_bbs_grant where no='$bbsNo' and member_level = $memberLevel;";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $bbsGrant = singleRowSQLQuery($sql);
    return $bbsGrant;
}

/*
* 함수명: getBbsGrantByID
* 설명  : 게시판 권한 조회 합니다.
* Argus : $bbsId       : 게시판 아이디
*       : $memberLevel : 회원 레벨
**/
function getBbsGrantByID ($bbsId,$memberLevel) {
    global $tb_bbs_grant;
    $sql = "select * from $tb_bbs_grant where bbs_id='$bbsId' and member_level = $memberLevel;";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $bbsGrant = singleRowSQLQuery($sql);
    return $bbsGrant;
}

/*
* 함수명: _category
* 설명  : 카테 고리 정보를 조회합니다.
* 예)  _category ()
**/
function getCategory ($id) {
    global $tb_bbs_category;

    $_rtn = '';
    $sql = "select no, name from $tb_bbs_category" . '_' . $id . " order by o_seq;";
    $stmt = multiRowSQLQuery($sql);
    $idx = 1;
//        echo $id;
    while ( $row = multiRowFetch  ($stmt) ) {
        $no = $row['no'];
//      $_rtn ['no'    ][$no] = $row['no'    ];
//      $_rtn ['o_seq' ][$no] = $row['o_seq' ];
        $_rtn ['name'  ][$no] = $row['name'  ];
//      $_rtn ['etc'   ][$no] = $row['etc'   ];
        $idx++;
    }
    return $_rtn;
}

/*
* 함수명: createCategory
* 설명  : 카테고리명을 tagName 태그를 이용해 화면에 출력합니다.
*         예)  createCategory ('S',SELECT);   //SELECT Box 조회
*              createCategory ('R',RADIO );   //RADIO  Box 조회
* $mode    : 'W' : 입력
           : 'S' : 검색
  $tagName : 'SELECT'      >> SELECT Box
           : 'RADIO'       >> RADIO  Box
           : 'CHECKBOX'    >> CHECK  Box
**/
function createCategory ($mode, $tagName='SELECT') {
    global $category, $exec, $cat_no, $search_cat_no;
    global $category_setup;
    if ( $mode == 'W' || $exec == 'list' || $exec == 'view' ) {
        $tagName    = strtoupper($tagName);
        $_prop_name = ( $mode == 'W' ) ? "cat_no" : "search_cat_no";
        if ( is_array($category) ) { reset ( $category['name'] ); }

        $_rtn  = '';
        $_rtn .= $category_setup['start_tag'];
        if ( $tagName == 'SELECT' || !$tagName ) {
            if ( $category_setup['item_align'] == 'right' ) $item_align = "style='direction:rtl'";
            else $item_align = "style='direction:ltr'";

            $_rtn  = "\n<select name='$_prop_name' " . $category_setup['properties'] . ' ' . $category_setup['script'] . " $item_align>";

            if ( $category_setup['title'] ) $_rtn .= "<option value=''>" . $category_setup['title'] . "</option>";

            if ( is_array($category) ) {
                while (list ($key, $val) = each ($category['name'])) {
                    if ( ( $exec == 'update' && $cat_no == $key ) ||
                          ( ( $exec == 'insert' || $exec == 'answer' ) && $category_setup['select'] == $key ) ||
                          ( $exec == 'list' && $search_cat_no == $key ) ) {
                        if ( $checked ) { $_rtn .= $category_setup['active_start_tag'  ]; }
                        $_rtn .= "<option value='".$key."' selected>".$val ."</option>";
                        if ( $checked ) { $_rtn .= $category_setup['active_end_tag'    ]; }
                    } else {
                        if ( $checked ) { $_rtn .= $category_setup['active_start_tag'  ]; }
                        $_rtn .= "<option value='".$key."'>". $val ."</option>";
                        if ( $checked ) { $_rtn .= $category_setup['active_end_tag'    ]; }
                    }
                }
            }
            $_rtn .= "</select>\n";
        } else if ( $tagName == 'RADIO' ) {
            if ( is_array($category) ) {
                while (list ($key, $val) = each ($category['name'])) {
                    $_rtn .= $category_setup['loop_start_tag'];
                    $checked = '';
                    if ( ( $exec == 'update' && $cat_no == $key ) ||
                          ( ( $exec == 'insert' || $exec == 'answer' ) && $category_setup['select'] == $key ) ||
                          ( $exec == 'list' && $search_cat_no == $key ) ) { $checked = 'checked'; } else { $checked = ''; }
                    if ( $category_setup['item_align'] == 'right' ) {
                        if ( $checked ) { $_rtn .= $category_setup['active_start_tag'  ]; }
                        $_rtn .= "\n" . $val . "<input type='radio' name='$_prop_name' value='". $key ."' $checked " . $category_setup['properties'] . " " . $category_setup['script'] . ">";
                        if ( $checked ) { $_rtn .= $category_setup['active_end_tag'    ]; }
                    } else {
                        if ( $checked ) { $_rtn .= $category_setup['active_start_tag'  ]; }
                        $_rtn .= "\n<input type='radio' name='$_prop_name' value='". $key ."' $checked " . $category_setup['properties'] . " " . $category_setup['script'] . ">" . $val;
                        if ( $checked ) { $_rtn .= $category_setup['active_end_tag'    ]; }
                    }
                    $_rtn .= $category_setup['loop_end_tag'];
                }
            }
        } else if ( $tagName == 'CHECKBOX' ) {
            if ( is_array($category) ) {
                if ( $mode == 'W' ) {
                    $event_script = "onClick='checkBoxCategoryT ( this.form, this, \"$mode\" );'";
                } else {
                    $event_script = "onMouseDown='checkBoxCategoryT ( this.form, this, \"$mode\" );'";
                }
                while (list ($key, $val) = each ($category['name'])) {
                    $_rtn .= $category_setup['loop_start_tag'];
                    $checked = '';
                    if ( ( $exec == 'update' && $cat_no == $key ) ||
                          ( ( $exec == 'insert' || $exec == 'answer' ) && $category_setup['select'] == $key ) ||
                          ( $exec == 'list' && $search_cat_no == $key ) ) { $checked = 'checked'; } else { $checked = ''; }
                    if ( $category_setup['item_align'] == 'right' ) {
                        if ( $checked ) { $_rtn .= $category_setup['active_start_tag'  ]; }
                        $_rtn .= "\n" . $val . "<input type='checkbox' name='$_prop_name' value='". $key ."' $checked $event_script " . $category_setup['properties'] . " " . $category_setup['script'] . ">";
                        if ( $checked ) { $_rtn .= $category_setup['active_end_tag'    ]; }
                    } else {
                        if ( $checked ) { $_rtn .= $category_setup['active_start_tag'  ]; }
                        $_rtn .= "\n<input type='checkbox' name='$_prop_name' value='". $key ."' $checked $event_script " . $category_setup['properties'] . " " . $category_setup['script'] . ">" . $val;
                        if ( $checked ) { $_rtn .= $category_setup['active_end_tag'    ]; }
                    }
                    $_rtn .= $category_setup['loop_end_tag'];
                }
            }
        } else {
            if ( is_array($category) ) {
                while (list ($key, $val) = each ($category['name'])) {
                    $_rtn .= $category_setup['loop_start_tag'];
                    $checked = '';
                    if ( ( $exec == 'update' && $cat_no == $key ) ||
                          ( ( $exec == 'insert' || $exec == 'answer' ) && $category_setup['select'] == $key ) ||
                          ( $exec == 'list' && $search_cat_no == $key ) ) { $checked = 'checked'; } else { $checked = ''; }

                    if ( $checked ) { $_rtn .= $category_setup['active_start_tag'  ]; }
                    $_rtn .= "\n<$tagName name='$_prop_name' value='". $key ."' " . $category_setup['properties'] . " " . $category_setup['script'] . ">";
                    $_rtn .= $val;
                    $_rtn .= "\n</" . $tagName . ">";
                    if ( $checked ) { $_rtn .= $category_setup['active_end_tag'    ]; }

                    $_rtn .= $category_setup['loop_end_tag'];
                }
            }
        }
        $_rtn .= $category_setup['end_tag'];
        $category_setup='';
    }
    return $_rtn;
}

/*
* 함수명: boardFormCreate
* 설명  : 프로그램내에서 사용되는 기본 폼을 생성합니다.
**/
function boardFormCreate() {
	global $_dboard_form_included;
	global $PHP_SELF,$id, $notice_id, $s, $tot, $search, $search_cond, $no, $print_no, $exec, 
           $npop, $sort, $desc,
           $search_cat_no, $search_word, $search, $search_condition, $search_cond;
	if(!$_dboard_form_included) {
echo "
<span id='_dboard_member_layer_box' style='position:absolute;z-index:1'></span>
<iframe name='_dboard_iframe' src='#' style='position:relative;top:-100;width:0;height:0'></iframe>
<TABLE border=0 cellspacing=0 cellpadding=0 align='center'><FORM name='boardPageForm' METHOD=POST ACTION='". getUrlPath ($PHP_SELF) . getReqPageName ($PHP_SELF) ."'><input name='id' type=hidden value='$id'><input name='notice_id' type=hidden value='$notice_id'><input name='s' type=hidden value='$s'><input name='tot' type=hidden value='$tot'><input name='$search_word' type=hidden value='$search'><input name='$search_condition' type=hidden value='$search_cond'><input name='no' type=hidden value='$no'><input name='print_no' type=hidden value='$print_no'><input name='exec' type=hidden value='$exec'><input name='npop' type=hidden value='$npop'><input name='sort' type=hidden value='$sort'><input name='desc' type=hidden value='$desc'><input name='search_cat_no' type=hidden value='$search_cat_no'></FORM></TABLE>
<TABLE border=0 cellspacing=0 cellpadding=0 align='center'><FORM name='boardMailForm' METHOD=POST ACTION=''><input name='gubun' type=hidden value=''><input name='id' type=hidden value='$id'><input name='exec' type=hidden value='$exec'><input name='member_level' type=hidden value=''><input name='notice_id' type=hidden value='$notice_id'><input name='user_id' type=hidden value=''><input name='to_name' type=hidden value=''><input name='to_mail' type=hidden value=''><input name='outlook_mail' type=hidden value='outlook_mail'></FORM></TABLE>
";
		$_dboard_form_included = true;
	}
}
?>