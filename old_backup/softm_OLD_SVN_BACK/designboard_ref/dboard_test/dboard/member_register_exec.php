<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'          ; // ���� ���̺귯��
include 'common/message.inc'      ; // ���� ������ ó��
include 'common/message_table.inc'; // �޽���
include 'common/_service.inc'     ; // ���� ȭ�� ����

if ( preg_match( "/admin_member.php/", $HTTP_REFERER) ) {
    $retunPage ="admin_member.php";
    $pageLevel = 99; // ������      ���������� ����
} else {
//. "?id=" . getUrlParamValue($HTTP_REFERER, 'id') . "&exec=" . getUrlParamValue($HTTP_REFERER, 'exec')
    $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
    $pageLevel = 1;  // �Ϲ� ����� ���������� ����
}

if ( preg_match("/${HTTP_HOST}/",$HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
    include ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
    $db = initDBConnection (); // �����ͺ��̽��� �����մϴ�.

    /* ----- ���� �б� ---------------------------------- */
    $memInfor = getMemInfor     (   ); // ȸ��   ����
    $memForm  = getMemFormSetup (0  ); // ȸ�� �� ����
    $login_yn = $memInfor['login_yn']; // �α��� ����
    $admin_yn = $memInfor['admin_yn']; // ���� ����
    if ( $mexec == 'insert' || $gubun == 'dup_check' ) {
    	$exec = $mexec. "_exec";
    	define ("NOT_INCLUDE_HTML_HEAD", true);
        head('ȸ�� ����');
    } else if ( $mexec == 'update' ) {
    	$exec = $mexec. "_exec";
    	define ("NOT_INCLUDE_HTML_HEAD", true);
        head('ȸ�� ���� ����');
    } else if ( $mexec == 'secession' ) { // ȸ�� Ż��
    	$exec = $mexec. "_exec";
    	define ("NOT_INCLUDE_HTML_HEAD", true);
		head('ȸ�� Ż��');
    } else if ( $gubun == 'dup_check' ) {
    	$exec = $gubun . "_exec";
    	define ("NOT_INCLUDE_HTML_HEAD", true);
    	head('ȸ�� ����');
    }
    css();
?>
<style>
body { overflow:hidden }
</style>
<script type="text/javascript">
<!--
	function getOnlyURL(_url) {
		var url = _url;
		var e = url.indexOf ( '?' );
		if ( e > 0 ) url = url.substring(0,e);
		return url;
	}
	function getFileName(val)
	{
		var rtnStr = val;
		var s1 = 0, s2 = 0;
		var s  = 0;
		s1 = rtnStr.lastIndexOf("\\") + 1 ;
		s2 = rtnStr.lastIndexOf("/")  + 1 ;
		if ( s1 > 0 ) { s = s1; }
		if ( s2 > 0 ) { s = s2; }
		if ( s > 0 ) {
			rtnStr = rtnStr.substring( s );
		} else {
			rtnStr = "";
		}
		return rtnStr;
	}
//-->
</SCRIPT>
<?
    if ( $gubun == 'dup_check' ) {
        $idCheck = simpleSQLQuery("select COUNT(user_id ) from $tb_member where user_id = '$user_id'");
        if ( $idCheck ) {
            Message('P', '0005', 'CLOSE:�ߺ��� ���̵� �Դϴ�.', $skinDir    );    // �ߺ��� ���̵�
        } else {
            Message('P', '0006', 'CLOSE:��밡���� ���̵� �Դϴ�.', $skinDir);    // ���   ���̵�
        }

    } else if ( $mexec == 'insert' ) {
        $idCheck = simpleSQLQuery("select COUNT(user_id ) from $tb_member where user_id  = '$user_id'");
        if ( $idCheck ) {
            Message('P', '0005', "", $skinDir);        // �ߺ��� ���̵�
        } else {
            $constraintChk = 0;
            $msgNo = '';
            if ( $memForm['jumin' ] == 'Y' ) {
                $jumin = $jumin_1 . $jumin_2;
                $constraintChk = simpleSQLQuery("select COUNT(user_id) from $tb_member where jumin = password('$jumin')");
                if ( $constraintChk && $memInfor['member_level'] != 99 ) { // ������ �ƴѰ�쿡�� �˻�
                    $msgNo = '0007';
                } else {
                    $constraintChk = 0;
                }
            } else {
                $constraintChk = simpleSQLQuery("select COUNT(user_id) from $tb_member where e_mail = '$e_mail'");
                if ( $constraintChk && $memForm['e_mail'] == 'Y' ) { // ������ �ƴѰ�쿡�� �˻�
                    $msgNo = '0018';
                } else {
                    $constraintChk = 0;
                }
            }

            if ( $constraintChk ) { // ������ �ƴѰ�쿡�� �˻�
                Message('P', $msgNo, "", $skinDir);    // �ߺ��� �ֹ� ��ȣ
            } else {
                // ȸ�� ����
                $news_yn = ( !$news_yn ) ? "N" : $news_yn;
                if ( !$_GET['member_level'] ) {
                    $member_level = ( !$member_level ) ? 1 : $member_level; // �⺻ȸ����� [�Ϲ�ȸ��] ����
                    $post_no = $post_cd1 . '-' . $post_cd2;
                    $address = $address . '$$' . $detail_address;
                    if ( !$user_id_open                 ) { $user_id_open         = 'N'; }
                    if ( !$member_level_open            ) { $member_level_open    = 'N'; }
                    if ( !$name_open                    ) { $name_open            = 'N'; }
                    if ( !$sex_open                     ) { $sex_open             = 'N'; }
                    if ( !$e_mail_open                  ) { $e_mail_open          = 'N'; }
                    if ( !$home_open                    ) { $home_open            = 'N'; }
                    if ( !$birth_open                   ) { $birth_open           = 'N'; }
                    if ( !$age_open                     ) { $age_open             = 'N'; }
                    if ( !$tel_open                     ) { $tel_open             = 'N'; }
                    if ( !$address_open                 ) { $address_open         = 'N'; }
                    if ( !$post_no_open                 ) { $post_no_open         = 'N'; }
                    if ( !$point_open                   ) { $point_open           = 'N'; }
                    if ( !$picture_image_open           ) { $picture_image_open   = 'N'; }
                    if ( !$character_image_open         ) { $character_image_open = 'N'; }

                    include ( "common/file.inc"         ); // ����
                    include ( "common/file_upload.inc"  ); // ���� ���ε�

                    $upFile  = FileUpload ( ); // ���ε� �ν��Ͻ� ����
                    $f1         = $user_id . "_p.gif";
                    if ( $delete_picture_image != 'Y' ) {
                        $fileExt = strtolower ( getFileExtraName($_FILES['picture_image']['name'] ) );
                        if ( $fileExt == 'gif' || $fileExt == 'jpg' || $fileExt == 'bmp' ) {
                            if ( @is_file("data/member/picture/". $f1) ) { @unlink ( "data/member/picture/". $f1 ); }
                            $upFile->addUploadFile ($_FILES['picture_image'], "data/member/picture/", $f1, "html^txt^", 99999999999999);
                        }
                    } else {
                        if ( @is_file("data/member/picture/". $f1) ) { @unlink ( "data/member/picture/". $f1 ); }
                    }

                    $f2         = '';
                    $f2_open         = $user_id . "_c.gif";
                    $f2_close        = $user_id . "_c_close.gif";
                    if ( $character_image_open == 'Y' ) { $f2 = $f2_open ; }
                    else                                { $f2 = $f2_close; }

                    if ( $delete_character_image != 'Y' ) {
                        $fileExt = strtolower ( getFileExtraName($_FILES['character_image']['name'] ) );
                        if ( $fileExt == 'gif' || $fileExt == 'jpg' || $fileExt == 'bmp' ) {
                            $upFile->addUploadFile ($_FILES['character_image'], "data/member/character/", $f2, "html^txt^", 99999999999999);
                        }
                    }

                    $sql  = "update $tb_dic_member_statistic set cnt = cnt + 1;";
                    simpleSQLExecute($sql); // �� ȸ���� ����

                    $upFile->Upload(); // ���ε� ����
                    $point = $memForm['point']; // ���� ����Ʈ
                    if ( $memForm['news_yn'] == 'Y' ) $point += $memForm['news_point']; // �������� ���� ����Ʈ

					if ( $admin_yn == 'N' && $member_level == '99' ) $member_level = 1;
                    $sql  = "insert into $tb_member ( user_id, member_level, password, name, sex, e_mail, home, birth, age, jumin, news_yn, tel, post_no, hint, answer, ";
                    $sql .= " point, user_id_open, member_level_open, name_open, sex_open, e_mail_open, home_open, birth_open, age_open, tel_open, address_open, post_no_open, point_open, picture_image_open, character_image_open, ";
                    $sql .= " address, reg_date";
                    $sql .= " ) values ";
                    $sql .= "('$user_id', $member_level, PASSWORD('$password'), '$name', '$sex', '$e_mail', '$home', '$birth', '$age', PASSWORD('$jumin'), '$news_yn', '$tel', '$post_no', '$hint', '$answer', ";
                    $sql .= "'" . $point . "', '$user_id_open', '$member_level_open', '$name_open', '$sex_open', '$e_mail_open', '$home_open', '$birth_open', '$age_open', '$tel_open', '$address_open', '$post_no_open', '$point_open', '$picture_image_open', '$character_image_open',";
                    $sql .= " '$address', '" . getYearToSecond() . "'";
                    $sql .= " );";
                    simpleSQLExecute($sql);

                    if ( $login_yn == 'N' ) {
                        $_s_memInfor['login_yn'    ] = 'Y'          ;
                        $_s_memInfor['admin_yn'    ] = 'N'          ;
                        $_s_memInfor['user_id'     ] = $user_id     ;
                        $_s_memInfor['member_level'] = $member_level;
                        $_s_memInfor['name'        ] = $name        ;
                        $_s_memInfor['home'        ] = $home        ;
                        $_s_memInfor['e_mail'      ] = $e_mail      ;
                        $_s_memInfor['member_st'   ] = 1            ;
                        $_s_memInfor['reg_date'    ] = $reg_date    ;
                        $_s_memInfor['news_yn'     ] = $news_yn     ;

                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
                            @session_register("_s_memInfor");
                        } else {
                            $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 ���� ó��.
                        }
//                      echo '�α��� ����.';
                    }

//                    if ( $pageLevel == 99 ) {
//                        Message---unused('P', '0008', 'javascript:opener.document.location.replace("admin_member.php");opener.focus();self.close();:���ԿϷ�', $skinDir);    // ȸ�� ���� �Ϸ�
//                    } else {
                        echo ( "\n<script type='text/javascript'>\n");
                        echo ( "function regEnd() {\n" );
                        echo ( "        var url = '?id=$id&exec=$exec&no=$no&npop=$npop';\n");
                        echo ( "    if ( typeof(opener) != 'undefined' ) {\n");
                            if ( $succ_url ) {
//                          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
                            echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
                            echo ( "        url = '$succ_url' ;\n" );
                            echo ( "    } else {\n");
                            echo ( "        url = '$succ_url' + url;\n" );
                            echo ( "    }\n");
                            } else {
                                echo ( "        if (typeof(opener.document)=='object') { \n" );
                                    echo ( "        url = opener.document.location.href;\n" );
//                                  echo ( "        url = getOnlyURL(opener.document.location.href) + url;\n" );
                                    echo ( "        opener.document.location.replace( url );\n" );
                                echo ( "        }\n" );
                            }
                        echo ( "        opener.focus();\n" );
                        echo ( "        self.close();\n" );
                        echo ( "    } else { \n");
                            if ( $succ_url ) {
//                          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
                            echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
                            echo ( "        url = '$succ_url' ;\n" );
                            echo ( "    } else {\n");
                            echo ( "        url = '$succ_url' + url;\n" );
                            echo ( "    }\n");
                            } else {
                                echo ( "        url = 'http://" . $HTTP_HOST . "';\n" );
                            }
                        echo ( "        document.location.replace( url );\n" );
                        echo ( "    }\n");
                        echo ( "}\n");
                        echo ( "</SCRIPT>\n" );
                        Message('P', '0008', "javascript:regEnd();:���ԿϷ�", $skinDir);    // ȸ�� ���� �Ϸ�
//                    }
                }
            }
        }
    } else if ( $mexec == 'update' ) {
        head('ȸ�� ���� ����');     // Header ���
        $news_yn = ( !$news_yn ) ? "N" : $news_yn;
        $post_no = $post_cd1 . '-' . $post_cd2;
        $address = $address . '$$' . $detail_address;
        if ( !$user_id_open                 ) { $user_id_open         = 'N'; }
        if ( !$member_level_open            ) { $member_level_open    = 'N'; }
        if ( !$name_open                    ) { $name_open            = 'N'; }
        if ( !$sex_open                     ) { $sex_open             = 'N'; }
        if ( !$e_mail_open                  ) { $e_mail_open          = 'N'; }
        if ( !$home_open                    ) { $home_open            = 'N'; }
        if ( !$birth_open                   ) { $birth_open           = 'N'; }
        if ( !$age_open                     ) { $age_open             = 'N'; }
        if ( !$tel_open                     ) { $tel_open             = 'N'; }
        if ( !$address_open                 ) { $address_open         = 'N'; }
        if ( !$post_no_open                 ) { $post_no_open         = 'N'; }
        if ( !$point_open                   ) { $point_open           = 'N'; }
        if ( !$picture_image_open           ) { $picture_image_open   = 'N'; }
        if ( !$character_image_open         ) { $character_image_open = 'N'; }

        if ( !escapeYN () ) { // magic_quotes_gpc Off
            $answer = addslashes($answer);
        }

        include ( "common/file.inc"         ); // ����
        include ( "common/file_upload.inc"  ); // ���� ���ε�

        $upFile  = FileUpload ( ); // ���ε� �ν��Ͻ� ����
        $user_id = $memInfor['user_id'];
        $f1      = $user_id . "_p.gif";

        if ( $delete_picture_image != 'Y' ) {
            $fileExt = strtolower ( getFileExtraName($_FILES['picture_image']['name'] ) );
            if ( $fileExt == 'gif' || $fileExt == 'jpg' || $fileExt == 'bmp' ) {
                if ( @is_file("data/member/picture/". $f1) ) { @unlink ( "data/member/picture/". $f1 ); }
                $upFile->addUploadFile ($_FILES['picture_image'], "data/member/picture/", $f1, "html^txt^", 99999999999999);
            }
        } else {
            if ( @is_file("data/member/picture/". $f1) ) { @unlink ( "data/member/picture/". $f1 ); }
        }

        $f2         = '';
        $character_open = simpleSQLQuery("select character_image_open from $tb_member where user_id = '$user_id';");
        $f2_open         = $user_id . "_c.gif";
        $f2_close        = $user_id . "_c_close.gif";
        if ( $character_image_open == 'Y' ) { $f2 = $f2_open ; }
        else                                { $f2 = $f2_close; }

        if ( $delete_character_image != 'Y' ) {
            $fileExt = strtolower ( getFileExtraName($_FILES['character_image']['name'] ) );
            if ( $fileExt == 'gif' || $fileExt == 'jpg' || $fileExt == 'bmp' ) {
                if ( $character_open == 'Y' ) { // ���� ���°� �����̸�.
                    @unlink ("data/member/character/". $f2_open );
                } else { // ���� ���°� ������̸�.
                    @unlink ("data/member/character/". $f2_close);
                }
                $upFile->addUploadFile ($_FILES['character_image'], "data/member/character/", $f2, "html^txt^", 99999999999999);
            } else {
                if ( $character_open == 'Y' && $character_image_open == 'N' ) { // ���� ���°� �����̸�.
                    @rename ( "data/member/character/". $f2_open , "data/member/character/". $f2_close );
                } else if ( $character_open == 'N' && $character_image_open == 'Y' ) {
                    @rename ( "data/member/character/". $f2_close, "data/member/character/". $f2_open  );
                }
            }
        } else {
            if ( @is_file("data/member/character/". $f2) ) { @unlink ( "data/member/character/". $f2 ); }
        }

        $upFile->Upload(); // ���ε� ����
        // �Խ��� ���� ���̺� ����
        $sql  = "update $tb_member set ";
        $sql .= " user_id_open        =  '$user_id_open'        ,";

        if ( $admin_yn == 'Y' ) { $sql .= " member_level=  $member_level,"; }

        $sql .= " user_id_open      =  '$user_id_open'      ,";
        $sql .= " member_level_open =  '$member_level_open' ,";

        if ( $password_change     == 'Y' ) { $sql .= " password    =  PASSWORD('$password')   ,"; }
        if ( $memForm['name'    ] == 'Y' || $memForm['name'    ] == 'C') { $sql .= " name        = '$name'       ,"; $sql .= " name_open           =  '$name_open'           ,";}
        if ( $memForm['sex'     ] == 'Y' || $memForm['sex'     ] == 'C') { $sql .= " sex         = '$sex'        ,"; $sql .= " sex_open            =  '$sex_open'            ,";}
        if ( $memForm['e_mail'  ] == 'Y' || $memForm['e_mail'  ] == 'C') { $sql .= " e_mail      = '$e_mail'     ,"; $sql .= " e_mail_open         =  '$e_mail_open'         ,";}
        if ( $memForm['home'    ] == 'Y' || $memForm['home'    ] == 'C') { $sql .= " home        = '$home'       ,"; $sql .= " home_open           =  '$home_open'           ,";}
        if ( $memForm['birth'   ] == 'Y' || $memForm['birth'   ] == 'C') { $sql .= " birth       = '$birth'      ,"; $sql .= " birth_open          =  '$birth_open'          ,";}
        if ( $memForm['age'     ] == 'Y' || $memForm['age'     ] == 'C') { $sql .= " age         = '$age'        ,"; $sql .= " age_open            =  '$age_open'            ,";}
        if ( $memForm['tel'     ] == 'Y' || $memForm['tel'     ] == 'C') { $sql .= " tel         = '$tel'        ,"; $sql .= " tel_open            =  '$tel_open'            ,";}
        if ( $memForm['address' ] == 'Y' || $memForm['address' ] == 'C') { $sql .= " address     = '$address'    ,"; $sql .= " address_open        =  '$address_open'        ,";
                                                                           $sql .= " post_no     = '$post_no'    ,"; $sql .= " post_no_open        =  '$post_no_open'        ,";}
        if ( $memForm['news_yn' ] == 'Y' || $memForm['news_yn' ] == 'C') { $sql .= " news_yn     = '$news_yn'    ,"; }
        if ( $memForm['point_yn'] == 'Y' || $memForm['point_yn'] == 'C') {                                           $sql .= " point_open          =  '$point_open'          ,";}

        if ( $memForm['picture_image'  ] == 'Y' || $memForm['picture_image'  ] == 'C' ) { $sql .= " picture_image_open    =  '$picture_image_open'    ,";}
        if ( $memForm['character_image'] == 'Y' || $memForm['character_image'] == 'C' ) { $sql .= " character_image_open  =  '$character_image_open'  ,";}
        $sql .= " hint          = '$hint'   ,";
        $sql .= " answer        = '$answer' ,";
        $sql .= " acc_date      = '" . getYearToSecond() . "'";
        $sql .= " where user_id   = '" . $user_id . "'";
        $sql .= " and   member_st != 0;";  // ��� ������ �ƴ� ȸ����

//      logs ("$sql <BR>",true);
        simpleSQLExecute($sql);

        $sql  = "select * from $tb_member where user_id = '" . $memInfor['user_id'] . "';";
        $result = singleRowSQLQuery($sql);

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

        echo ( "\n<script type='text/javascript'>\n");
        echo ( "function regEnd() {\n" );
        echo ( "        var url = '?id=$id&exec=$exec&no=$no&npop=$npop';\n");
        echo ( "    if ( typeof(opener) == 'object' && typeof(opener.document) == 'object' ) {\n");
            if ( $succ_url ) {
//          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
            echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
            echo ( "        url = '$succ_url' ;\n" );
            echo ( "    } else {\n");
            echo ( "        url = '$succ_url' + url;\n" );
            echo ( "    }\n");
            } else {
                echo ( "        url = opener.document.location.href;\n" );
//              echo ( "        url = getOnlyURL(opener.document.location.href) + url;\n" );
            }
        echo ( "        opener.document.location.replace( url );\n" );
        echo ( "        opener.focus();\n" );
        echo ( "        self.close();\n" );
        echo ( "    } else { \n");
            if ( $succ_url ) {
//          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
            echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
            echo ( "        url = '$succ_url' ;\n" );
            echo ( "    } else {\n");
            echo ( "        url = '$succ_url' + url;\n" );
            echo ( "    }\n");
            } else {
                echo ( "        url = 'http://" . $HTTP_HOST . "';\n" );
            }
        echo ( "        document.location.replace( url );\n" );
        echo ( "    }\n");
        echo ( "}\n");
        echo ( "</SCRIPT>\n" );

        if ( $result['member_st'] == 0 ) { // ��� ���� ����
            if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
                @session_unregister("_s_memInfor");
            } else {
                unset($_SESSION['_s_memInfor']);
            }
            $_s_memInfor= getMemInfor(); // �⺻������ �����ϱ� ���� ������ ���� ���� �ٽ� �о� ���Դϴ�.
            if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
                @session_register("_s_memInfor");
            } else {
                $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 ���� ó��.
            }
            Message('U', '0004',"javascript:windowClose();:Ȯ��", $skinDir); // ��� ������ ȸ��

        } else { // ��� ����

            $_s_memInfor['login_yn'    ] = 'Y';

            if ( $result['member_level'] == 99 ) {
                $_s_memInfor['admin_yn'    ] = 'Y';
            } else {
                $_s_memInfor['admin_yn'    ] = 'N';
            }

            setSessionMemberValue ('user_id'     ,$result['user_id'     ]);
            setSessionMemberValue ('member_level',$result['member_level']);
            setSessionMemberValue ('name'        ,$result['name'        ]);
            setSessionMemberValue ('e_mail'      ,$result['e_mail'      ]);
            setSessionMemberValue ('home'        ,$result['home'        ]);
            setSessionMemberValue ('member_st'   ,$result['member_st'   ]);
            setSessionMemberValue ('reg_date'    ,$result['reg_date'    ]);
            setSessionMemberValue ('news_yn'     ,$result['news_yn'     ]);
            // logs ( '$skinDir : '. $skinDir . '<BR>' , true);
            Message('P', '0013',"javascript:regEnd();:Ȯ��", $skinDir); // ȸ�� ������ ���� �Ǿ����ϴ�.
        }
    } else if ( $mexec == 'secession' ) { // ȸ�� Ż��
        $user_id          = $memInfor['user_id' ]; // ���̵�
        if ( $user_id ) {
            @session_destroy();
            echo ( "\n<script type='text/javascript'>\n");
            echo ( "function secessionEnd() {\n" );
            echo ( "        var url = '?id=$id&exec=$exec&no=$no&npop=$npop';\n");
            echo ( "    if ( typeof(opener     ) != 'undefined' ) {\n");
                if ( $succ_url ) {
//                          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
                echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
                echo ( "        url = '$succ_url' ;\n" );
                echo ( "    } else {\n");
                echo ( "        url = '$succ_url' + url;\n" );
                echo ( "    }\n");
                echo ( "    opener.document.location.replace( url );\n" );
                }
            echo ( "        opener.focus();\n" );
            echo ( "        self.close();\n" );
            echo ( "    } else { \n");
                if ( $succ_url ) {
//                          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
                echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
                echo ( "        url = '$succ_url' ;\n" );
                echo ( "    } else {\n");
                echo ( "        url = '$succ_url' + url;\n" );
                echo ( "    }\n");
                } else {
                    echo ( "        url = 'http://" . $HTTP_HOST . "';\n" );
                }
            echo ( "        document.location.replace( url );\n" );
            echo ( "    }\n");
            echo ( "}\n");
            echo ( "</SCRIPT>\n" );
/*
            $chg_user_id = '!@#$_' . $user_id;
            $sql  = "update $tb_member set ";
            $sql .= " member_st = '9',";
            $sql .= " jumin     = '' ,";
            $sql .= " user_id   = '$chg_user_id'";
            $sql .= " where user_id = '$user_id';"; // ȸ�� Ż��
*/
            $sql  = "delete from $tb_member where user_id = '$user_id'";
            simpleSQLExecute($sql);

            $sql  = "update $tb_dic_member_statistic set cnt = cnt - 1;";
            simpleSQLExecute($sql); // �� ȸ���� ����

            $f1         = $user_id . "_p.gif";
            $f2         = $user_id . "_c.gif";
            if ( @is_file("data/member/picture/"  . $f1) ) { @unlink ( "data/member/picture/"  . $f1 ); }
            if ( @is_file("data/member/character/". $f2) ) { @unlink ( "data/member/character/". $f2 ); }

            Message('P', '0016', "javascript:secessionEnd();:Ż��Ϸ�", $skinDir);    // ȸ�� Ż�� �Ϸ�
        }
    } else { // Parameter ������ ���
        Message('S', '0003', 'CLOSE:�ݱ�', $skinDir);    // ������ ������ �ź� �Ǿ����ϴ�.
    }

} else { // Parameter ������ ���
        Message('S', '0003', 'CLOSE:�ݱ�', $skinDir);    // ������ ������ �ź� �Ǿ����ϴ�.
}
?>
</head>
<body>
<?
closeDBConnection (); // �����ͺ��̽� ���� ���� ����
footer(); // Footer ���
?>
