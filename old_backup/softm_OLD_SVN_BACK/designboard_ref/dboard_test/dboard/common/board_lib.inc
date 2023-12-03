<?
/*
* include �Ǿ������� �˻�
**/
if( defined("_dboard_lib_included") ) return;
    define ("_dboard_lib_included", true);

include 'lib/var/table.inc'; // ���̺� ���� ����

/*
* �Լ���: _admin_bbsListBox
* ����  : �Խ��� ������ ��ȸ�Ͽ� ����Ʈ ���ڸ� ��� �մϴ�.
* ��)  _admin_bbsListBox('�Խ��� ���̵�')
* Argus : bbsId : �Խ��� ���̵�
**/
function _admin_bbsListBox ($bbsId='') {
//include ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
// �����ͺ��̽��� �����մϴ�.
//$db = initDBConnection ($sysInfor["host_nm"],$sysInfor["db_nm"],$sysInfor["id"],$sysInfor["password"],$sysInfor["driver"]);
    global $tb_bbs_infor;
    global $id          ;
    $sql = "select no, bbs_id from $tb_bbs_infor where bbs_id != '$id' order by no desc;";
    $stmt = multiRowSQLQuery($sql);
    $_rtn  = "\n<select id='_dboard_s_id' name='_dboard_s_id' class='admin_listbox'>";
//    $_rtn .= "<option value=''>&nbsp;&nbsp;�Խ��Ǽ���&nbsp;&nbsp;</option>";
    $_rtn .= "<option value=''>�Խ��Ǽ���</option>";
    while ( $row = multiRowFetch  ($stmt) ) {
            if($bbsId==$row['bbs_id']) $select="selected"; else $select="";
            $_rtn .= "<option value=" . $row['bbs_id'] . " $select>". $row['bbs_id'] . "</option>";
    }
    $_rtn .= "</select>\n";
    return $_rtn;
}

/*
* �Լ���: getPointGrant
* ����  : �Խ��Ǻ� ����Ʈ ������ ��ȸ �մϴ�.
* Argus : $bbsId : �Խ��� ���̵�
*
   1 : "���� �ۼ�"
   2 : "�ǰ߱� �ۼ�"
   3 : "���� ���ε�"
   4 : "�ٿ�ε�"
   5 : "����ۼ�"
**/
function getPointGrant ($bbsId, $memberLevel, $no) {
    global $tb_point_infor;
    $point = 0;
    if ( $memberLevel > 0 ) { // ��ȸ���� �ƴϸ�
        global $tb_point_infor, $tb_member;
        $sql = "select point from $tb_point_infor where bbs_id='$bbsId' and no = '$no' and member_level = '$memberLevel';";
        $point = (int) simpleSQLQuery($sql);
    }
    return $point;
}

/*
* �Լ���: getBbsInfor
* ����  : �Խ��� ������ ��ȸ �մϴ�.
* Argus : $bbsId : �Խ��� ���̵�
**/
function getBbsInfor ($bbsId) {
    global $tb_bbs_infor;
    $sql = "select * from $tb_bbs_infor where bbs_id='$bbsId';";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $bbsInfor = singleRowSQLQuery($sql);
    return $bbsInfor;
}

/*
* �Լ���: getNoticeInfor
* ����  : �Խ��� ���� ������ ��ȸ �մϴ�.
* Argus : $bbsId : �Խ��� ���̵�
**/
function getNoticeInfor ($bbsId) {
    global $tb_bbs_abstract;
    $sql = "select * from $tb_bbs_abstract where bbs_id='$bbsId';";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $noticeInfor = singleRowSQLQuery($sql);
    return $noticeInfor;
}

/*
* �Լ���: getBbsGrant
* ����  : �Խ��� ���� ��ȸ �մϴ�.
* Argus : $bbsNo       : �Խ��� ��ȣ
*       : $memberLevel : ȸ�� ����
**/
function getBbsGrant ($bbsNo,$memberLevel) {
    global $tb_bbs_grant;
    $sql = "select * from $tb_bbs_grant where no='$bbsNo' and member_level = $memberLevel;";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $bbsGrant = singleRowSQLQuery($sql);
    return $bbsGrant;
}

/*
* �Լ���: getBbsGrantByID
* ����  : �Խ��� ���� ��ȸ �մϴ�.
* Argus : $bbsId       : �Խ��� ���̵�
*       : $memberLevel : ȸ�� ����
**/
function getBbsGrantByID ($bbsId,$memberLevel) {
    global $tb_bbs_grant;
    $sql = "select * from $tb_bbs_grant where bbs_id='$bbsId' and member_level = $memberLevel;";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $bbsGrant = singleRowSQLQuery($sql);
    return $bbsGrant;
}

/*
* �Լ���: _category
* ����  : ī�� ���� ������ ��ȸ�մϴ�.
* ��)  _category ()
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
* �Լ���: createCategory
* ����  : ī�װ������� tagName �±׸� �̿��� ȭ�鿡 ����մϴ�.
*         ��)  createCategory ('S',SELECT);   //SELECT Box ��ȸ
*              createCategory ('R',RADIO );   //RADIO  Box ��ȸ
* $mode    : 'W' : �Է�
           : 'S' : �˻�
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
* �Լ���: boardFormCreate
* ����  : ���α׷������� ���Ǵ� �⺻ ���� �����մϴ�.
**/
function boardFormCreate() {
	global $_dboard_form_included;
	global $PHP_SELF,$id, $notice_id, $s, $tot, $search, $search_cond, $no, $print_no, $exec,
           $npop, $sort, $desc,
           $search_cat_no, $search_word, $search, $search_condition, $search_cond;
	if(!$_dboard_form_included) {
echo "
<span id='_dboard_member_layer_box' style='position:absolute;z-index:1'></span>
<iframe name='_dboard_iframe' src='#' style='position:relative;top:-100;width:0;height:0;display:none'></iframe>
<TABLE border=0 cellspacing=0 cellpadding=0 align='center'><FORM name='boardPageForm' METHOD=POST ACTION='". getUrlPath ($PHP_SELF) . getReqPageName ($PHP_SELF) ."'><input name='id' type=hidden value='$id'><input name='notice_id' type=hidden value='$notice_id'><input name='s' type=hidden value='$s'><input name='tot' type=hidden value='$tot'><input name='$search_word' type=hidden value='$search'><input name='$search_condition' type=hidden value='$search_cond'><input name='no' type=hidden value='$no'><input name='print_no' type=hidden value='$print_no'><input name='exec' type=hidden value='$exec'><input name='npop' type=hidden value='$npop'><input name='sort' type=hidden value='$sort'><input name='desc' type=hidden value='$desc'><input name='search_cat_no' type=hidden value='$search_cat_no'></FORM></TABLE>
<TABLE border=0 cellspacing=0 cellpadding=0 align='center'><FORM name='boardMailForm' METHOD=POST ACTION=''><input name='gubun' type=hidden value=''><input name='id' type=hidden value='$id'><input name='exec' type=hidden value='$exec'><input name='member_level' type=hidden value=''><input name='notice_id' type=hidden value='$notice_id'><input name='user_id' type=hidden value=''><input name='to_name' type=hidden value=''><input name='to_mail' type=hidden value=''><input name='outlook_mail' type=hidden value='outlook_mail'></FORM></TABLE>
";
		$_dboard_form_included = true;
	}
}
?>