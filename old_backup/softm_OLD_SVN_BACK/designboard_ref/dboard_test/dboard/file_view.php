<?
/*------- ��ȸ �����Ͱ� ���� ���� �ʾ� ������ �߻��� �� �����ϴ�.--------------*/
// ���� ���� �ٿ�ε�ÿ��� header������ ���������� header�� �����ϱ� ����.
// ǥ�� ����� ��ġ�� ������ �������� �Ǵ� Process�� ������ �߻���ŵ�ϴ�.
// �׷����� header�� �̿��Ͽ� Rediection�� ��Ŵ�ϴ�.
        if ( !$_GET['no'] ) { 
            echo 'FILE VIEW PAGE';
            exit;
        } else if ( $_GET['no'] ) {
            $no = $_GET['no'];
            $page_gubun = $_GET['page_gubun'];
//          header("location:download_ok.php?id=$id&no=$no");
//	        redirectPage("download_ok.php?id=$id&no=$no");
            include ( 'common/lib.inc'          ); // ���� ���̺귯��
            include ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
            include ( 'common/_service.inc'     ); // ���� ȭ�� ����
            include ( 'common/message.inc'      ); // ���� ������ ó��

            include 'common/board_lib.inc'    ; // �Խ��� ���̺귯��

            $db = initDBConnection ();             // �����ͺ��̽� ����

            $memInfor = getMemInfor     (                              ); // ȸ��   ����
            $admin_yn = $memInfor['admin_yn'];
            $user_id  = $memInfor['user_id' ];

            $bbsGrant = getBbsGrantByID ($id,$memInfor['member_level'] ); // ����   ����
            $bbsInfor = getBbsInfor ($id                               ); // �Խ��� ����
            $_skinName = ''; // ��Ų��
            if ( $_GET['skin_name'] || !$skin_name ) {
                $_skinName  = $bbsInfor['skin_name'];
            } else {
                $_skinName  = $skin_name;
            }
            $skinDir  = 'skin/board/' . $_skinName . '/'   ;
            $msgNo = '';

            if      ( $page_gubun == 'list' ) { $msgNo = 'S0061'; }
            else if ( $page_gubun == 'view' ) { $msgNo = 'S0062'; }

            if ( ( $msgNo && $page_gubun = 'list' && $bbsGrant['grant_list'] == 'Y' ) ||
                 ( $msgNo && $page_gubun = 'view' && $bbsGrant['grant_view'] == 'Y' ) ) {

                // no, user_id, f_path1, f_name1, f_ext1, f_size1, f_date1, f_path2, f_name2, f_ext2, f_size2, f_date2, use_st
                $sql = "select * from $tb_bbs_data" . "_" . $id . " where no = '".$no."'";
                $data = singleRowSQLQuery($sql);

                $sql  = "update $tb_bbs_data" . "_" . $id;

                if ( $gubun == '1' ) {
                    $f_path   = $data["f_path1"  ];  // ���� ���1
                    $f_name   = $data["f_name1"  ];  // ���� ��1
                    $f_ext    = $data["f_ext1"   ];  // Ȯ���� ��1
                    $f_date   = $data["f_date1"  ];  // ���� ���ϸ�1
                    $w_user_id= $data["user_id"  ];  // �ۼ��� ���̵�
                    $use_st   = $data["use_st"   ];  // �� ����

                    $down_hit1_cotent_chk   = $_SESSION['down_hit1_cotent_chk'];
                    $down_hit1_cotent_stats = preg_match("/%${id}_${no}/", $down_hit1_cotent_chk);
//                  echo ' $down_hit1_cotent_chk  : ' . $down_hit1_cotent_chk   . '<BR>';
//                  echo ' $down_hit1_cotent_stats: ' . $down_hit1_cotent_stats . '<BR>';
                    $sql .= " set   down_hit1 = down_hit1 + 1";
                } else if ( $gubun == '2' ) {
                    $f_path   = $data["f_path2"  ];  // ���� ���2
                    $f_name   = $data["f_name2"  ];  // ���� ��2
                    $f_ext    = $data["f_ext2"   ];  // Ȯ���� ��2
                    $f_date   = $data["f_date2"  ];  // ���� ���ϸ�2
                    $w_user_id= $data["user_id"  ];  // �ۼ��� ���̵�
                    $use_st   = $data["use_st"   ];  // �� ����

                    $down_hit2_cotent_chk   = $_SESSION['down_hit2_cotent_chk'];
                    $down_hit2_cotent_stats = preg_match("/%${id}_${no}/", $down_hit2_cotent_chk);
                    $sql .= " set   down_hit2 = down_hit2 + 1";
                }
                $sql .= " where no  = '$no';";

                $file_grant = 'N';
                if ( ( $use_st == '1' && $user_id == $w_user_id ) || $use_st != '1' || $admin_yn == 'Y' ) {
                    // ��������� �� �����, ��������� �ƴ� ��, ������ �ٿ� �����մϴ�.
                    $file_grant = 'Y';
                }

                if ( $file_grant == 'Y' ) {
                    if ( $gubun == '1' && !$down_hit1_cotent_stats ) {
                        $down_hit1_cotent_chk = '%' . $id . '_' . $no . $down_hit1_cotent_chk;
                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
                            @session_register('down_hit1_cotent_chk');
                        } else {
                            $_SESSION['down_hit1_cotent_chk'] = $down_hit1_cotent_chk;  // 4.10 ���� ó��.
                        }
                        simpleSQLExecute($sql);
                    }

                    if ( $gubun == '2' && !$down_hit2_cotent_stats ) {
                        $down_hit2_cotent_chk = '%' . $id . '_' . $no . $down_hit2_cotent_chk;
                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
                            @session_register('down_hit2_cotent_chk');
                        } else {
                            $_SESSION['down_hit2_cotent_chk'] = $down_hit2_cotent_chk;  // 4.10 ���� ó��.
                        }
                        simpleSQLExecute($sql);
                    }

                    if ( $data['no'] ) {    
						$file    = $baseDir . "data/file/" . $id. "/$f_date.$f_ext";
                        $REAL_FILE = "$f_name.$f_ext"       ;
                        $imgInfor = getimagesize($file);
/*
                        logs ( '0 : '. $imgInfor[0] . '<BR>' , true);
                        logs ( '1 : '. $imgInfor[1] . '<BR>' , true);
                        logs ( '2 : '. $imgInfor[2] . '<BR>' , true);
                        logs ( '3 : '. $imgInfor[3] . '<BR>' , true);
                        logs ( '4 : '. $imgInfor[4] . '<BR>'. "\n" , true);
*/
                        // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 
                        // 8 = TIFF (motorola byte order, 9 = JPC, 10 = JP2, 11 = JPX.
                        $window_width = '';
                        $window_height= '';
                        if ( $mode == 'img' ) {
                            if ( $display_mode == '1' && ( ( $imgInfor[2] > 0 && $imgInfor[2] < 4 ) || $imgInfor[2] == 6 ) ) {
                                $window_width  = $imgInfor[0] + 12; // ����
                                $window_height = $imgInfor[1] + 32; // ����
                            } else if ( $display_mode == '2' ) {
                                $window_width  = $img_w + 12;
                                $window_height = $img_h + 32;
                            } else if ( $display_mode == '3' ) {
                                $img_w = $img_w + 12;
                                $img_h = $img_h + 32;
                                $window_width  = $popup_w; // ����
                                $window_height = $popup_h; // ����
                            }
                            if ( (int) $plus_w ) { $window_width  =  $window_width  + (int) $plus_w; }
                            if ( (int) $plus_h ) { $window_height =  $window_height + (int) $plus_h; }
                        } else if ( $mode == 'media' ) {
                            $window_width  = $media_w; // ����
                            $window_height = $media_h; // ����
                        }
                        if ( @is_file("$file") ) {
//                          include $skinDir . "file_view.php";

                            echo ( "<script type='text/javascript'>\n");
                            echo ( "<!--\n");
                            echo ( "    var window_width  = '$window_width';\n");
                            echo ( "    var window_height = '$window_height';\n");
                            echo ( "    var winPro        = '';\n");
//                          echo ( "   parent.fpWin.close();\n");
                            echo ( "   winPro       = 'toolbar=no,menubar=no,resizable=yes,scrollbars=no,top=0,left=0'\n");
                            echo ( "   if ( window_width > screen.width ) {\n");
                            echo ( "       window_width = screen.width;\n");
                            echo ( "       winPro       = 'toolbar=no,menubar=no,resizable=yes,scrollbars=yes,top=0,left=0'\n");
                            echo ( "   }\n");
                            echo ( "   if ( window_height > screen.height ) {\n");
                            echo ( "       window_height = screen.height;\n");
                            echo ( "       winPro       = 'toolbar=no,menubar=no,resizable=yes,scrollbars=yes,top=0,left=0'\n");
                            echo ( "   }\n");
                            echo ( "   var fpWin = window.open('about:blank','".$no . '_' . $id . "', winPro + ',width=' + window_width + ',height=' + window_height );\n");

//                          echo ( "    var obj = getObject( 'test' );\n");
//                          echo ( "    alert ( getObject( 'test' ) );\n");
//                          echo ( "    alert ( obj.innerHTML );\n");
// window.document.body.innerHTML 
                            $fp = '';
                            if ( $mode == 'img' ) {
                                $fp = fopen ($skinDir . "popup_image.php", "r");
                            } else if ( $mode == 'media' ) {
                                $fp = fopen ($skinDir . "popup_media.php", "r");
                            }
                            echo ( "    fpWin.document.open();\n");
                            while (!feof ($fp)) {
                                $content = fgets ($fp,1024);
                                $content = str_replace("\n", "", $content);
                                $content = str_replace("\r", "", $content);
                                $content = str_replace('<?=$f_name?' . '>', $f_name, $content);
                                if ( $mode == 'img' ) {
                                    if ( $display_mode == '2' ) {
                                        $t_size  = ( $img_w ) ? " width='"  . $img_w . "'" : ' ';
                                        $t_size .= ( $img_h ) ? " height='" . $img_h . "'" : ' ';
                                        $content = str_replace('<?=$f_preview?' . '>', "<img  name='_dboard_display_obj' src='$file' $t_size border=0>", $content);
                                    } else if ( $display_mode == '3') {
                                        $t_size  = ( $img_w ) ? " width='"  . $img_w . "'" : ' ';
                                        $t_size .= ( $img_h ) ? " height='" . $img_h . "'" : ' ';
                                        $content = str_replace('<?=$f_preview?' . '>', "<img src='$file' border=0 $t_size>", $content);
                                    } else {
                                        $content = str_replace('<?=$f_preview?' . '>', "<img src='$file' border=0>", $content);
                                    }
                                } else if ( $mode == 'media' ) {

                                    $t_media  = ( $show       == 'Y' ) ? " hidden=false"   : ' hidden=true'    ;
                                    $t_media .= ( $auto_start == 'Y' ) ? " autostart=true" : ' autostart=false';

                                    if ( $loop == 'Y' ) { // ���� ����
                                        $t_media .= " loop=-1";
                                    } else if ( $loop == 'N' ) { // �ѹ� ���
                                        $t_media .= " loop";
                                    } else {                               // ��ȯ Ƚ�� ����
                                        $t_media .= " loop=" . $loop;
                                    }

                                    $t_media .= ( $media_player_w            ) ? " width="  . $media_player_w : ' ';
                                    if ( strpos("[wav, mp3, mp2]", strtolower ($f_ext) ) == false ) { // ���� ������ ���� ��������
                                        $t_media .= ( $media_player_h           ) ? " height=" . $media_player_h: ' ';
                                    }

                                    $content = str_replace('<?=$f_preview?' . '>', '<embed name=\"_dboard_display_obj\" src=\"' . $file . '\" ' . $t_media . '></embed>', $content);
                                }
                                echo ( "    fpWin.document.writeln(\"$content\");\n");
                            }
//                          echo ( "    fpWin.document.write(\"$content\");\n");
//                          echo ( "    fpWin.document.write(obj.innerHTML);\n");

                            echo ( "    fpWin.document.close();\n");
                            echo ( "    fpWin.resizeTo(window_width, window_height);\n");
                            echo ( "    fpWin.focus();\n");
							echo ( "    self.document.location.replace ('about:blank');\n");
//                          echo ( "    alert (parseInt(width) + ' ' + parseInt(height) );\n");
//                          echo ( "    alert (parent.fpWin.width + ' ' + parent.fpWin.height);\n");
//                          echo ( "    alert ( obj.innerHTML );\n");
                            echo ( "//-->\n");
                            echo ( "</SCRIPT>\n");

                        } else {
							include 'common/message_table.inc'; // �޽��� ���̺�
                            echo "�ش� �����̳� ��ΰ� �������� �ʽ��ϴ�.";
                            echo ( "<script type='text/javascript'>\n");
                            echo ( "<!--\n");
                            echo ( "    alert ('". $errMsgTable['S0066'] ."');\n"); // ���� ���� ������ ����
							echo ( "    self.document.location.replace ('about:blank');\n");
                            echo ( "//-->\n");
                            echo ( "</SCRIPT>\n");
                        }
                    }
                } else {
					include 'common/message_table.inc'; // �޽��� ���̺�
                    echo ( "<script type='text/javascript'>\n");
                    echo ( "<!--\n");
                    echo ( "    alert ('". $errMsgTable[$msgNo] ."');\n"); // �ٿ�ε� ���� ����. ( ��б� )
					echo ( "    self.document.location.replace ('about:blank');\n");
                    echo ( "//-->\n");
                    echo ( "</SCRIPT>\n");
                }
                closeDBConnection (); // �����ͺ��̽� ���� ���� ����
            } else {
				include 'common/message_table.inc'; // �޽��� ���̺�
                echo ( "<script type='text/javascript'>\n");
                echo ( "<!--\n");
                echo ( "    alert ('". $errMsgTable['S0061'] ."');\n"); // ���� ���� ������ ����
				echo ( "    self.document.location.replace ('about:blank');\n");
                echo ( "//-->\n");
                echo ( "</SCRIPT>\n");
            }
        }
?>