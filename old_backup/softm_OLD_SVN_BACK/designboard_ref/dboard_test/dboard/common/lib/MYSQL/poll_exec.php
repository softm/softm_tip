<?
if ( function_exists('head') ) {

    if ( $poll_id && $grant == 'Y' && ( $poll_exec == 'poll_exec' ) && preg_match("/${HTTP_HOST}/", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' )
    {
        if ( $pollInfor )  { // 게시판 정보 존재
            $poll_key  = $REMOTE_ADDR . '$$' . $user_id . '$$' . $poll_id;
            $poll_name = $baseDir . 'data/poll/' . $poll_id . $start_date;

            if ( $poll_exec == 'poll_exec' ) {
                include ( $baseDir . 'common/profile.inc'      ); // 프로 파일 설정
                $val = getKey ( $poll_name, $poll_key );
                if ( !$val || $admin_yn == 'Y' ) {
                    setKey ( $poll_name, $poll_key, 'isononey' );
                    $sql  = "update $tb_poll_item";
                    $sql .= " set hit = hit + 1";
                    $sql .= " where no   = '" . $poll_no . "'";
                    $sql .= " and   p_no = '" . $poll_id . "'";
                    simpleSQLExecute($sql);

                    $sql  = "update $tb_poll_master";
                    $sql .= " set total_hit = total_hit + 1";
                    $sql .= " where no   = '" . $poll_id . "'";
                    simpleSQLExecute($sql);

                    $retunPage = '';
                    $display_mode = $pollInfor['display_mode'];
                    $poll_process = $pollInfor['poll_process'];

                    if ( $display_mode == '1' ) { // 현재 창, 투표후 처리페이지 : 결과화면으로 이동
                        $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
                        $retunPage .= '?poll_id='   . $poll_id    ;
                    } else if ( $display_mode == '2' ) { // 새창
                        $retunPage = 'dpoll.php?poll_id='   . $poll_id ;
                    }

                    if ( $poll_process == '1' ) {
                        $retunPage .= '&p_poll_exec=poll_result&p_poll_id=' . $poll_id;
                    } else if ( $poll_process == '2' ) {
                        if ( $display_mode == '1' ) { // 현재창일 경우 알림상자 출력만
                            $retunPage .= '&p_poll_exec=poll_result_alert_only';
                        } else if ( $display_mode == '2' ) { // 새창 경우 알림상자 출력과 결과화면으로 표시
                            $retunPage .= '&p_poll_exec=poll_result_alert_change';
                        }
                    } else if ( $poll_process == '3' ) {
                        $retunPage = $pollInfor['suc_url'];
                    }

					$point = getPollPointGrant ($poll_id, $memInfor['member_level'], 1); // 설문 투표
					setPointGrant ($user_id, $point); // 포인트 추가

                    if ( $pollInfor['poll_process'] != '3' ) {
                        $key_name  = array_keys  ($_POST);
                        $key_value = array_values($_POST);

                        for($i = 0 ;$i <count($_POST);$i++) {
                            if ( $key_value[$i] != '' && $key_name[$i] != 'poll_id' && $key_name[$i] != 'poll_exec' && $key_name[$i] != 'tot' && $key_name[$i] != 'display_mode' ) {
                                $retunPage .= '&' . $key_name[$i] . '=' . $key_value[$i];
                            }
                        }
                    }
                    if ( $display_mode == '1' ) { // 현재창
                        redirectPage($retunPage);
                    } else { // 새창
                        echo ( "<script type='text/javascript'>\n");
                        echo ( "<!--\n");
                        echo ( "    var pollWin = window.open('$retunPage','pollWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,top=0,left=0,width=$poll_result_popup_width,height=$poll_result_popup_height');\n");
                        echo ( "    pollWin.focus();\n");
                        echo ( "//-->\n");
                        echo ( "</SCRIPT>\n");
                    }
    /*
                    $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);

                    $key_name  = array_keys  ($_POST);
                    $key_value = array_values($_POST);
                    for($i = 0 ;$i <count($_POST);$i++) {
                        if ( $key_name[$i] != 'poll_exec' && $key_name[$i] != 'tot' ) {
                            $params[$key_name[$i]] = $key_value[$i];
                        }
                    }
                    $params['poll_id'   ] = $poll_id     ;
                    $params['poll_exec' ] = 'poll_result';
                    formMove('chageYour_MM',$retunPage, $params);
    */
                } else {
                    if ( $display_mode == '1' ) { // 현재 창, 투표후 처리페이지 : 결과화면으로 이동
                    } else if ( $display_mode == '2' ) { // 새창
                        $retunPage = 'dpoll.php?poll_id='   . $poll_id ;
                    }

                    echo ( "<script type='text/javascript'>\n");
                    echo ( "<!--\n");
                    echo ( "    function windowClose() {\n");
                    echo ( "        if ( typeof( opener ) == 'object' ) {\n");
                    echo ( "            self.close();\n");
                    echo ( "        } else {\n");
                    echo ( "            history.back();\n");
                    echo ( "        }\n");
                    echo ( "    }\n");
                    echo ( "//-->\n");
                    echo ( "</SCRIPT>\n");

                    if ( $display_mode == '1' ) { // 현재 창
                        Message('S', '0048',"javascript:windowClose();:확인", $skinDir);   // 이미 투표 하셨습니다.
                    } else if ( $display_mode == '2' ) { // 새창
                        $retunPage  = 'dpoll.php?poll_id='   . $poll_id ;
                        $retunPage .= '&poll_exec=poll_exec';
                        $retunPage .= '&poll_no='. $poll_no ;
                        $retunPage .= '&poll_id='. $poll_id ;
                        $retunPage .= '&error=1';
                        echo ( "<script type='text/javascript'>\n");
                        echo ( "<!--\n");
                        echo ( "    var pollWin = window.open('$retunPage','pollWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,top=0,left=0,width=$poll_result_popup_width,height=$poll_result_popup_height');\n");
                        echo ( "    pollWin.focus();\n");
                        echo ( "//-->\n");
                        echo ( "</SCRIPT>\n");
                    }
                }
            }

        } // if END
    }
}
?>