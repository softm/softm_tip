<?
$print_no = $tot - $s + 2;

$sql  = "select a.user_id user_id, a.name name, a.e_mail e_mail, a.home home, a.tel tel, a.point point, a.reg_date reg_date, a.acc_date acc_date, a.member_st member_st, b.member_nm member_nm from $tb_member a LEFT JOIN $tb_member_kind b ";

$sql .= $where;

if ( $sort == 'name' || $sort == 'user_id' || $sort == 'reg_date' || $sort == 'point' ) {
    if ( $desc == 'desc' ) {
        $sql .= " order by $sort desc";
    } else {
        $sql .= " order by $sort";
    }
} else {
    $sql .= ' order by a.reg_date desc';
}

$sql .= " limit " . ( $s - 1 ) . ", " . $how_many;
$stmt = multiRowSQLQuery($sql);

$search_start_tag = '<font class="text_04">';
$search_end_tag   = '</font>'           ;

while ( $row = multiRowFetch  ($stmt) ) {
    $print_no--;
    $reg_date = $row['reg_date'];
    $acc_date = $row['acc_date'];
    $name     = $row['name'    ];
    $user_id  = $row['user_id' ];
    $member_nm= $row['member_nm' ];
    $point    = $row['point'   ];

    if ( $row['member_st'] == '1' ) { // 사용
        $member_st = '사용';
    } else if ( $row['member_st'] == '0' ) { // 미사용
        $member_st = '사용 정지';
    } else if ( $row['member_st'] == '9' ) { // 탈퇴
        $member_st = '탈퇴';
    }
    $member  = '이름          : ' . $name . "\n";
    $member .= '아이디       : ' . $user_id  . "\n";
    $member .= '포인트       : ' . $row['point']  . "\n";
    if ( $row['e_mail' ] ) $member .= '이메일       : ' . $row['e_mail' ]  . "\n";
    if ( $row['home'   ] ) $member .= '홈페이지    : ' . $row['home'   ]  . "\n";
    if ( $row['tel'    ] ) $member .= '연락처번호 : ' . $row['tel'    ]  . "\n";


    $reg_year  = substr($reg_date, 0,4);
    $reg_month = substr($reg_date, 4,2);
    $reg_day   = substr($reg_date, 6,2);
    $reg_hour  = substr($reg_date, 8,2);
    $reg_min   = substr($reg_date,10,2);
    $reg_sec   = substr($reg_date,12,2);
    if ( $reg_year ) $member .= '가입일       : ' . $reg_year . "." . $reg_month . "." . $reg_day . " " . $reg_hour . ":" . $reg_min . ":" . $reg_sec . "\n";

    $acc_year  = substr($acc_date, 0,4);
    $acc_month = substr($acc_date, 4,2);
    $acc_day   = substr($acc_date, 6,2);
    $acc_hour  = substr($acc_date, 8,2);
    $acc_min   = substr($acc_date,10,2);
    $acc_sec   = substr($acc_date,12,2);
    if ( $acc_year ) $member .= '최근접속일 : ' . $acc_year . "." . $acc_month . "." . $acc_day . " " . $acc_hour . ":" . $acc_min . ":" . $acc_sec . "\n";
    $member .= '사용 상태   : ' . $member_st;

    if ( $search ) {
        if ( $search_gb == 'name'    ) {
            $name    = str_replace($search,$search_start_tag.$search.$search_end_tag, $name   );
        } else if ( $search_gb == 'user_id' ) {
            $user_id = str_replace($search,$search_start_tag.$search.$search_end_tag, $user_id);
        } else {
            if ( $search_gb == 'point' ) {
                $name    = str_replace($search,$search_start_tag.$search.$search_end_tag, $name   );
                $user_id = str_replace($search,$search_start_tag.$search.$search_end_tag, $user_id);
            }
        }
    }
?>
                                <tr title='<?=$member?>'>
                                  <td bgcolor="F7F7F7" height="20" align="center"> 
                                    <input type="checkbox" name="chk_no[]" value="<?=$row['user_id']?>">
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_01" align="center"><?=$print_no?></td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <b><a href='#' onClick="window.open ('member_view.php?user_id=<?=$row['user_id']?>', '_dboard_m_view','width=537,height=575,toolbar=no,scrollbars=yes');return false;"><?=$name?></a></b>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center"><b><?=$user_id?></b></td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center"><b><?=$point?></b></td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center"><?=$member_nm?></td>
                                  <td bgcolor="F7F7F7" class="text_01" align="center"><?=substr($reg_date, 0,4).'.'.substr($reg_date, 4,2).'.'.substr($reg_date, 6,2)?></td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick='moveWritePage ("<?=$row['user_id']?>");return false;'>수정</a></td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center"><a href="javascript:deleteData('<?=$row['user_id']?>');">삭제</a></td>
                                </tr>
<?
} // while END
?>