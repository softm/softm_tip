<?
if ( function_exists('_head') ) {
    $baseWall = "^http^ftp^https"; // �� ���ƾ� �ұ.
    $IJTSEC = false;
    if ( ( $IJTERROR = strpos ( $libDir, "://") ) > 0 ) {
        if ( strpos ( $baseWall, substr ( $libDir, 0 , $IJTERROR ) ) < 1 ) { $IJTSEC = true; }
    } else { $IJTSEC = true; }

    if ( $IJTSEC ) {
        if ( ( $package == 'board' && $displayView[2] ) || ( $package == 'poll' && $opiniony_yn == 'Y' && $pollGrant['grant_write'] == 'Y' ) ) {

            if ( file_exists($skinDir ."view_comment.php") ) {
                // name ������ ������ �̸����� ���ǹǷ� �� ���� [�α��� �̸�]
                $name       = $memInfor['name'    ];
                if ( $package == 'board' ) {
                    $comment_table    = $tb_bbs_comment       ; // �Խ��� �ǰ߱� ���̺�
                    $displayCharacter = $displayList[9]       ;
                    $GRANT            = $bbsGrant             ; // ����   ����
                } else if ( $package == 'poll' ) {
                    $comment_table    = $tb_poll_comment      ; // ����   �ǰ߱� ���̺�
                    $displayCharacter = '1'                   ; // �������� ȸ���̹����� ��Ų ���������� �ݿ���
                    $GRANT            = $pollGrant            ; // ����   ����
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
                    /* ----- �� ���� ------------------------------------ */
                    $c_no      = $data['no'       ];   /* �ڸ�Ʈ ��ȣ  */
                    $p_no      = $data['p_no'     ];   /* �Խù� ��ȣ  */
                    $c_member_level = $data['member_level'  ];   /* ȸ�� ���� */
                    $c_user_id = $data['user_id'  ];   /* ����� ID    */
                    $home      = $data['home'     ];   /* Ȩ������     */
                    if ( ( $package == 'board' && $bbsGrant['grant_comment'] == 'Y' ) || ( $package == 'poll' && $pollGrant['grant_write'] == 'Y' ) ) {
                        if ( $admin_yn=='Y' || ( $user_id == $c_user_id ) || !$c_user_id ) { // �ǰ� �ޱ� ����
            //              $a_delete_comment = "<a href='#' onClick=\"deleteCommentData('delete_comment_exec','$p_no','$c_no');\">";
                            if ( $package == 'board' ) {
                                $a_delete_comment = "<a href='".getReqPageName ()."$a_params&p_no=$p_no&no=$c_no&exec=delete_comment'>";
                            } else if ( $package == 'poll' ) { // ����
                                $a_delete_comment = "<a href='" . $baseDir ."dpoll.php$a_params&poll_no=$c_no&poll_exec=delete_comment'>";
                            }
                        }  else {
                            $a_delete_comment = "<a href='#' onClick='return false;' style='display:none'>";
                        }
                    } else {
                        $a_delete_comment = "<a href='#' onClick='return false;' style='display:none'>";
                    }
                    $name      = $data['name'     ];   /* �̸�         */
                    $e_mail    = $data['e_mail'   ];   /* E-mail       */

                    if ( $mailSendMethod == '1' ) {    // ������
                        if ( $e_mail ) {
                            $a_e_mail = "<a href='#' onClick='openFormMail(\"$package\",\"$id\",\"$c_member_level\",\"$c_user_id\",\"". base64_encode($tmp_name) . "\", \"" . base64_encode($e_mail) . "\",$mail_popup_width, $mail_popup_height);return false;'>";
                        } else {
                            $a_e_mail = '';
                        }
                    } else {                           // �ƿ���
                        if ( $e_mail ) {
                            $a_e_mail = "<a href='#' onClick='openOutLookMail(\"$package\",\"$id\",\"" . base64_encode($e_mail) . "\");return false;'>";
                        } else {
                            $a_e_mail = '';
                        }
                    }

                    // Ŭ�� : 'click', ���� : 'over'
                    if ( $member_layer_box_use == 'Y' ) {
                        if ( $member_layer_box_event )  {
                            $a_member_layer_box  ="<a href='#' on" . $member_layer_box_event . "='memberLayerBox (\"$package\", \"$id\",";
                            $a_member_layer_box .="\"$c_user_id\"    , ";
                            $a_member_layer_box .="\"$mailSendMethod\",\"" . base64_encode($e_mail) . "\", \"". base64_encode($tmp_name) . "\", \"$c_member_level\", \"$mail_popup_width\", \"$mail_popup_height\", \"$home\", \"$member_view_mode\", \"$member_view_succ_url\", \"$member_view_popup_width\", \"$member_view_popup_height\", \"$member_view_scroll_yn\" );return false;'";
                            $a_member_layer_box .= " onClick='return false;'>"   ; // ȸ�� ���� ���̾�
                        } else {
                            $a_member_layer_box = '<a>';
                        }
                    }

            //      $memo      = nl2br ( htmlspecialchars ( $data['memo'  ], ENT_QUOTES ) );   /* ���� */
                    $memo      = nl2br ( $data['memo'] );   /* ���� */
                    $memo      = str_replace( '<?', '&lt;?', $memo );   /* ���� */

                    $ip        = $data['ip'       ];   /* �ۼ� IP �ּ� */
                    $reg_date  = $data['reg_date' ];   /* �ۼ� �� �������� */
                    $reg_year  = substr($reg_date, 0 ,4);
                    $reg_month = substr($reg_date, 4 ,2);
                    $reg_day   = substr($reg_date, 6 ,2);
                    $reg_hour  = substr($reg_date, 8 ,2);
                    $reg_min   = substr($reg_date, 10,2);
                    $reg_sec   = substr($reg_date, 12,2);

                    $character = '';    // ȸ�� ������
                    $character = printMemberIcon($c_member_level          , $c_user_id, $displayCharacter ); // ȸ�� ������

                    $memo      = autoLink ($memo); // �ڵ� ��ũ

                    include $skinDir ."view_comment.php"; //  ���� �亯 ��Ų
                }
            }
        }
    }
}
?>