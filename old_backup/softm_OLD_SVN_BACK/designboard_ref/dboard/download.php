<?
/*------- ��ȸ �����Ͱ� ���� ���� �ʾ� ������ �߻��� �� �����ϴ�.--------------*/
// ���� ���� �ٿ�ε�ÿ��� header������ ���������� header�� �����ϱ� ����.
// ǥ�� ����� ��ġ�� ������ �������� �Ǵ� Process�� ������ �߻���ŵ�ϴ�.
// �׷����� header�� �̿��Ͽ� Rediection�� ��Ŵ�ϴ�.
        if ( !$HTTP_GET_VARS['no'] ) { 
            echo 'DOWNLOAD PAGE';
            exit;
        } else if ( $HTTP_GET_VARS['no'] ) {
            $no = $HTTP_GET_VARS['no'];
//          header("location:download_ok.php?id=$id&no=$no");
//	        redirectPage("download_ok.php?id=$id&no=$no");
            include 'common/board_lib.inc' ; // �Խ��� ���̺귯��

            include 'common/lib.inc'       ; // ���� ���̺귯��
            include 'common/db_connect.inc'; // Data Base ���� Ŭ����
            include 'common/_service.inc'  ; // ���� ȭ�� ����
            $db = initDBConnection ();             // �����ͺ��̽� ����

            $memInfor = getMemInfor     (                              ); // ȸ��   ����
            $admin_yn = $memInfor['admin_yn'];
            $user_id  = $memInfor['user_id' ];

            $bbsGrant = getBbsGrantByID ($id,$memInfor['member_level'] ); // ����   ����

            if ( $bbsGrant['grant_down'] == 'Y' ) {

                $sql = "select no, user_id, f_path1, f_name1, f_ext1, f_size1, f_date1, f_path2, f_name2, f_ext2, f_size2, f_date2, use_st from $tb_bbs_data" . "_" . $id . " where no = '".$no."'";
                $data = singleRowSQLQuery($sql);

                $sql  = "update $tb_bbs_data" . "_" . $id;

                if ( $gubun == '1' ) {
                    $f_path   = $data["f_path1"  ];  // ���� ���1
                    $f_name   = $data["f_name1"  ];  // ���� ��1
                    $f_ext    = $data["f_ext1"   ];  // Ȯ���� ��1
                    $f_date   = $data["f_date1"  ];  // ���� ���ϸ�1
                    $w_user_id= $data["user_id"  ];  // �ۼ��� ���̵�
                    $use_st   = $data["use_st"   ];  // �� ����

                    $down_hit1_cotent_chk   = $HTTP_SESSION_VARS['down_hit1_cotent_chk'];
                    $down_hit1_cotent_stats = ereg('%' . $id . '_' . $no, $down_hit1_cotent_chk);
//                    echo ' $down_hit1_cotent_chk  : ' . $down_hit1_cotent_chk   . '<BR>';
//                    echo ' $down_hit1_cotent_stats: ' . $down_hit1_cotent_stats . '<BR>';
                    $sql .= " set   down_hit1 = down_hit1 + 1";
                } else if ( $gubun == '2' ) {
                    $f_path   = $data["f_path2"  ];  // ���� ���2
                    $f_name   = $data["f_name2"  ];  // ���� ��2
                    $f_ext    = $data["f_ext2"   ];  // Ȯ���� ��2
                    $f_date   = $data["f_date2"  ];  // ���� ���ϸ�2
                    $w_user_id= $data["user_id"  ];  // �ۼ��� ���̵�
                    $use_st   = $data["use_st"   ];  // �� ����

                    $down_hit2_cotent_chk   = $HTTP_SESSION_VARS['down_hit2_cotent_chk'];
                    $down_hit2_cotent_stats = ereg('%' . $id . '_' . $no, $down_hit2_cotent_chk);
                    $sql .= " set   down_hit2 = down_hit2 + 1";
                }
                $sql .= " where no  = '$no';";

                $down_grant = 'N';
                if ( ( $use_st == '1' && $user_id == $w_user_id ) || $use_st != '1' || $admin_yn == 'Y' ) {
                    // ��������� �� �����, ��������� �ƴ� ��, ������ �ٿ� �����մϴ�.
                    $down_grant = 'Y';
                }

                if ( $down_grant == 'Y' ) {
                    if ( $gubun == '1' && !$down_hit1_cotent_stats ) {
                        $down_hit1_cotent_chk = '%' . $id . '_' . $no . $down_hit1_cotent_chk;
                        @session_register('down_hit1_cotent_chk');
						$_SESSION['down_hit1_cotent_chk'] = $down_hit1_cotent_chk;  // 4.10 ���� ó��.
                        simpleSQLExecute($sql);
                    }

                    if ( $gubun == '2' && !$down_hit2_cotent_stats ) {
                        $down_hit2_cotent_chk = '%' . $id . '_' . $no . $down_hit2_cotent_chk;
                        @session_register('down_hit2_cotent_chk');
						$_SESSION['down_hit2_cotent_chk'] = $down_hit2_cotent_chk;  // 4.10 ���� ó��.
                        simpleSQLExecute($sql);
                    }

                    if ( $data['no'] ) {    
						$file    = $baseDir . "data/file/" . $id. "/$f_date.$f_ext";
                        $REAL_FILE = "$f_name.$f_ext"       ;
                        if ( @is_file("$file") ) {
                            downHeader($file, $REAL_FILE);
                            $fp = fopen($file, "r"); 
                            if (!fpassthru($fp)) fclose($fp);
                            flush();
                            $point=0;
                            $point       = getPointGrant ($id, $memInfor['member_level'], 4); // �ٿ�ε� ����Ʈ
                            setPointGrant ($user_id, $point); // ����Ʈ �߰�
                        } else {
                            include 'common/message_table.inc'; // �޽��� ���̺�
                            echo ( "<SCRIPT LANGUAGE='JavaScript'>\n");
                            echo ( "<!--\n");
                            echo ( "    alert ('". $errMsgTable['S0066'] . " ( " . $file . " )');\n"); // ������ �������� ����
							echo ( "    self.document.location.replace ('about:blank');\n");
                            echo ( "//-->\n");
                            echo ( "</SCRIPT>\n");
                        }
                    }
                } else {
					include 'common/message_table.inc'; // �޽��� ���̺�
                    echo ( "<SCRIPT LANGUAGE='JavaScript'>\n");
                    echo ( "<!--\n");
                    echo ( "    alert ('". $errMsgTable['S0060'] ."');\n"); // �ٿ�ε� ���� ����. ( ��б� )
					echo ( "    self.document.location.replace ('about:blank');\n");
                    echo ( "//-->\n");
                    echo ( "</SCRIPT>\n");
                }
                if ( $db ) closeDBConnection (); // db disconnect
            } else {
				include 'common/message_table.inc'; // �޽��� ���̺�
                echo ( "<SCRIPT LANGUAGE='JavaScript'>\n");
                echo ( "<!--\n");
                echo ( "    alert ('". $errMsgTable['S0051'] ."');\n"); // �ٿ�ε� ���� ����.
				echo ( "    self.document.location.replace ('about:blank');\n");
                echo ( "//-->\n");
                echo ( "</SCRIPT>\n");
            }
        }
?>