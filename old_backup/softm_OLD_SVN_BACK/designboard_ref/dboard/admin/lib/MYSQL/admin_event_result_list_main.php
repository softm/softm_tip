<?
$print_no = $tot - $s + 2;

$sql  = "select a.no no, a.user_id user_id,a.prize_yn prize_yn, a.prize_point prize_point, a.join_date join_date, b.name name, b.e_mail e_mail, b.home home from $tb_event_result_master a LEFT JOIN $tb_member b ";

$sql .= $where;

if ( $sort == 'name' || $sort == 'user_id' || $sort == 'join_date' ) {
    if ( $desc == 'desc' ) {
        $sql .= " order by $sort desc";
    } else {
        $sql .= " order by $sort";
    }
} else {
    $sql .= ' order by a.join_date desc';
}

$sql .= " limit " . ( $s - 1 ) . ", " . $how_many;
$stmt = multiRowSQLQuery($sql);

$search_start_tag = '<font class="text_04">';
$search_end_tag   = '</font>'           ;

while ( $row = multiRowFetch  ($stmt) ) {
    $print_no--;
    $event_id   = $row['no'         ];
    $user_id    = $row['user_id'    ];
    $prize_yn   = $row['prize_yn'   ];
    $prize_point= $row['prize_point'];
    $join_date  = $row['join_date'  ];

    $name       = $row['name'       ];

    $member  = '이름          : ' . $name . "\n";
    $member .= '아이디       : ' . $user_id  . "\n";
    $member .= '포인트       : ' . $row['prize_point']  . "\n";
    if ( $row['e_mail' ] ) $member .= '이메일       : ' . $row['e_mail' ]  . "\n";
    if ( $row['home'   ] ) $member .= '홈페이지    : ' . $row['home'   ]  . "\n";
    if ( $row['tel'    ] ) $member .= '연락처번호 : ' . $row['tel'    ]  . "\n";


    $join_year  = substr($join_date, 0,4);
    $join_month = substr($join_date, 4,2);
    $join_day   = substr($join_date, 6,2);
    $join_hour  = substr($join_date, 8,2);
    $join_min   = substr($join_date,10,2);
    $join_sec   = substr($join_date,12,2);
    if ( $join_year ) $member .= '가입일       : ' . $join_year . "." . $join_month . "." . $join_day . " " . $join_hour . ":" . $join_min . ":" . $join_sec . "\n";

    if ( $search ) {
        if ( $search_gb == 'name'    ) {
            $name    = str_replace($search,$search_start_tag.$search.$search_end_tag, $name   );
        } else if ( $search_gb == 'user_id' ) {
            $user_id = str_replace($search,$search_start_tag.$search.$search_end_tag, $user_id);
        } else {
            $name    = str_replace($search,$search_start_tag.$search.$search_end_tag, $name   );
            $user_id = str_replace($search,$search_start_tag.$search.$search_end_tag, $user_id);
        }
    }
?>

                    <tr title='<?=$member?>'>
                      <td height="20" align="center" bgcolor="F7F7F7">
                        <input type="checkbox" name="chk_no[]" value="<?=$user_id?>">
                      </td>
                      <td bgcolor="F7F7F7" class="text_01" align="center"><?=$print_no?></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><b>
                      <a href='#' onClick="window.open ('member_view.php?user_id=<?=$user_id?>', '_dboard_m_view','width=537,height=575,toolbar=no,scrollbars=$_scroll');return false;"><?=$name?></a>
                      </b></td>
                      <td align="center" bgcolor="F7F7F7" class="text_03"><b>
                      <a href='#' onClick="openMemberView ('<?=$user_id?>', '1', '', '537', '575', 'Y');return false;"><?=$user_id?></a>
                      </b></td>
                      <td align="center" bgcolor="F7F7F7" class="text_03"><?=$join_year?>.<?=$join_month?>.<?=$join_day?></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick='moveWritePage ("<?=$event_id?>", "<?=$user_id?>");return false;'>수정</a></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="javascript:deleteData('<?=$user_id?>');">삭제</a></td>
                    </tr>
<?
} // while END
?>