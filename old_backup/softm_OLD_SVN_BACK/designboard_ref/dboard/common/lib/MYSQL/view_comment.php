<?
if ( function_exists('_head') ) {
    $baseWall = "^http^ftp^https"; // 멀 막아야 할까염.
    $IJTSEC = false;
    if ( ( $IJTERROR = strpos ( $libDir, "://") ) > 0 ) {
        if ( strpos ( $baseWall, substr ( $libDir, 0 , $IJTERROR ) ) < 1 ) { $IJTSEC = true; }
    } else { $IJTSEC = true; }

    if ( $IJTSEC ) {
        if ( ( $package == 'board' && $displayView[2] ) || ( $package == 'poll' && $opiniony_yn == 'Y' && $pollGrant['grant_write'] == 'Y' ) ) {

            if ( file_exists($skinDir ."view_comment.php") ) {
                // name 변수가 동일한 이름으로 사용되므로 재 설정 [로그인 이름]
                $name       = $memInfor['name'    ];
                if ( $package == 'board' ) {
                    $comment_table    = $tb_bbs_comment       ; // 게시판 의견글 테이블
                    $displayCharacter = $displayList[9]       ;
                    $GRANT            = $bbsGrant             ; // 권한   정보
                } else if ( $package == 'poll' ) {
                    $comment_table    = $tb_poll_comment      ; // 설문   의견글 테이블
                    $displayCharacter = '1'                   ; // 설문에서 회원이미지는 스킨 의존적으로 반영됨
                    $GRANT            = $pollGrant            ; // 권한   정보
                }

                $sql  = "select a.no     no    , a.p_no      p_no    , a.user_id user_id ,";
                $sql .= "       a.name   name  , a.password  password, a.memo    memo    ,";
                $sql .= "       a.ip     ip    , a.reg_date  reg_date, b.e_mail  e_mail  ,";
                $sql .= "       b.member_level member_level, b.home home";

                if ( $package == 'board' ) {
                    $sql .= " from $comment_table" . "_" . $id . " a, $tb_member b";
                    $sql .= " where a.p_no    = '$no'";
                    $sql .= " and a.user_id = b.user_id ";
                } else if ( $package == 'poll' ) {
                    $sql .= " from $comment_table" . "_" . $poll_id . " a, $tb_member b";
                    $id = $poll_id;
                    $sql .= " where a.p_no    = '$poll_id'";
                    $sql .= " and a.user_id = b.user_id ";
                }

                $sql .= " order by a.no;";

//             logs ( '$sql : ' . $sql . '<BR>', true);

                $stmt1 = multiRowSQLQuery ($sql);

                while ( $data = multiRowFetch  ($stmt1) ) {
                    /* ----- 값 설정 ------------------------------------ */
                    $c_no      = $data['no'       ];   /* 코멘트 번호  */
                    $p_no      = $data['p_no'     ];   /* 게시물 번호  */
                    $c_member_level = $data['member_level'  ];   /* 회원 레벨 */
                    $c_user_id = $data['user_id'  ];   /* 사용자 ID    */
                    $home      = $data['home'     ];   /* 홈페이지     */
                    if ( ( $package == 'board' && $bbsGrant['grant_comment'] == 'Y' ) || ( $package == 'poll' && $pollGrant['grant_write'] == 'Y' ) ) {
                        if ( $admin_yn=='Y' || ( $user_id == $c_user_id ) || !$c_user_id ) { // 의견 달기 삭제
            //              $a_delete_comment = "<a href='#' onClick=\"deleteCommentData('delete_comment_exec','$p_no','$c_no');\">";
                            if ( $package == 'board' ) {
                                $a_delete_comment = "<a href='".getReqPageName ()."$a_params&p_no=$p_no&no=$c_no&exec=delete_comment'>";
                            } else if ( $package == 'poll' ) { // 설문
                                $a_delete_comment = "<a href='" . $baseDir ."dpoll.php$a_params&poll_no=$c_no&poll_exec=delete_comment'>";
                            }
                        }  else {
                            $a_delete_comment = "<a href='#' onClick='return false;' style='display:none'>";
                        }
                    } else {
                        $a_delete_comment = "<a href='#' onClick='return false;' style='display:none'>";
                    }
                    $name      = $data['name'     ];   /* 이름         */
                    $e_mail    = $data['e_mail'   ];   /* E-mail       */

                    if ( $mailSendMethod == '1' ) {    // 폼메일
                        if ( $e_mail ) {
                            $a_e_mail = "<a href='#' onClick='openFormMail(\"$package\",\"$id\",\"$c_member_level\",\"$c_user_id\",\"". base64_encode($tmp_name) . "\", \"" . base64_encode($e_mail) . "\",$mail_popup_width, $mail_popup_height);return false;'>";
                        } else {
                            $a_e_mail = '';
                        }
                    } else {                           // 아웃룩
                        if ( $e_mail ) {
                            $a_e_mail = "<a href='#' onClick='openOutLookMail(\"$package\",\"$id\",\"" . base64_encode($e_mail) . "\");return false;'>";
                        } else {
                            $a_e_mail = '';
                        }
                    }

                    // 클릭 : 'click', 오버 : 'over'
                    if ( $member_layer_box_use == 'Y' ) {
                        if ( $member_layer_box_event )  {
                            $a_member_layer_box  ="<a href='#' on" . $member_layer_box_event . "='memberLayerBox (\"$package\", \"$id\",";
                            $a_member_layer_box .="\"$c_user_id\"    , ";
                            $a_member_layer_box .="\"$mailSendMethod\",\"" . base64_encode($e_mail) . "\", \"". base64_encode($tmp_name) . "\", \"$c_member_level\", \"$mail_popup_width\", \"$mail_popup_height\", \"$home\", \"$member_view_mode\", \"$member_view_succ_url\", \"$member_view_popup_width\", \"$member_view_popup_height\", \"$member_view_scroll_yn\" );return false;'";
                            $a_member_layer_box .= " onClick='return false;'>"   ; // 회원 정보 레이어
                        } else {
                            $a_member_layer_box = '<a>';
                        }
                    }

            //      $memo      = nl2br ( htmlspecialchars ( $data['memo'  ], ENT_QUOTES ) );   /* 내용 */
                    $memo      = nl2br ( $data['memo'] );   /* 내용 */
                    $memo      = str_replace( '<?', '&lt;?', $memo );   /* 내용 */

                    $ip        = $data['ip'       ];   /* 작성 IP 주소 */
                    $reg_date  = $data['reg_date' ];   /* 작성 및 변경일자 */
                    $reg_year  = substr($reg_date, 0 ,4);
                    $reg_month = substr($reg_date, 4 ,2);
                    $reg_day   = substr($reg_date, 6 ,2);
                    $reg_hour  = substr($reg_date, 8 ,2);
                    $reg_min   = substr($reg_date, 10,2);
                    $reg_sec   = substr($reg_date, 12,2);

                    $character = '';    // 회원 아이콘
                    $character = printMemberIcon($c_member_level          , $c_user_id, $displayCharacter ); // 회원 아이콘

                    $memo      = autoLink ($memo); // 자동 링크

                    include $skinDir ."view_comment.php"; //  간단 답변 스킨
                }
            }
        }
    }
}
?>