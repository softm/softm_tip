<?
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'       ; // ���� ���̺귯��
include 'common/message.inc'   ; // ���� ������ ó��
include 'common/db_connect.inc'; // Data Base ���� Ŭ����

head('ȸ�� ����');  // Header ���
_css();

// �����ͺ��̽��� �����մϴ�.
$db   = initDBConnection (); // �����ͺ��̽��� �����մϴ�.

$memInfor = getMemInfor();      // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
$memForm  = getMemFormSetup(0); // ȸ�� �� ���� ������ ******* ȸ�� ���� �о� �帲. ********
$login_yn = $memInfor['login_yn']; // �α��� ����
$admin_yn = $memInfor['admin_yn']; // ���� ����
$openChk = true;
if ( $user_id ) {
    $row = singleRowSQLQuery("select * from $tb_member where user_id = '" . $user_id . "'");
    $user_id      = $row['user_id'     ];
    if ( $user_id ) { $existChk = true ; }
    else            { $existChk = false; }
    if ( $existChk ) {
        $member_level = $row['member_level'];
        $password     = $row['password'    ];
        $name         = $row['name'        ];
        $nick_name    = $row['nick_name'   ];
        $sex          = $row['sex'         ];
        if ( $sex == '1' ) { $sex = "����"; } else { $sex = "����"; }
        $e_mail       = $row['e_mail'      ];
        $home         = $row['home'        ];
        $tel          = $row['tel'         ];
        $address      = $row['address'     ];
        $post_no      = $row['post_no'     ];
        $member_st    = $row['member_st'   ];
        $news_yn      = $row['news_yn'     ];
        $point        = $row['point'       ];

        $point                = $row['point'               ];
        $access               = $row['access'              ];
        $user_id_open         = $row['user_id_open'        ];
        $member_level_open    = $row['member_level_open'   ];
        $name_open            = $row['name_open'           ];
        $nick_name_open       = $row['nick_name_open'      ];
        $sex_open             = $row['sex_open'            ];
        $e_mail_open          = $row['e_mail_open'         ];
        $home_open            = $row['home_open'           ];
        $tel_open             = $row['tel_open'            ];
        $address_open         = $row['address_open'        ];
        $post_no_open         = $row['post_no_open'        ];
        $point_open           = $row['point_open'          ];
        $access_open          = $row['access_open'         ];
        $picture_image_open   = $row['picture_image_open'  ];
        $character_image_open = $row['character_image_open'];

        $reg_date     = $row['reg_date'    ];
        $acc_date     = $row['acc_date'    ];

        if ( $user_id_open       == 'Y' ||
             $member_level_open  == 'Y' ||
           ( $memForm['name'           ] != 'N' && $name_open              == 'Y' ) ||
           ( $memForm['nick_name'      ] != 'N' && $nick_name_open         == 'Y' ) ||
           ( $memForm['sex'            ] != 'N' && $sex_open               == 'Y' ) ||
           ( $memForm['point_yn'       ] != 'N' && $point_open             == 'Y' ) ||
           (                                       $access_open            == 'Y' ) ||
           ( $memForm['e_mail'         ] != 'N' && $e_mail_open            == 'Y' ) ||
           ( $memForm['home'           ] != 'N' && $home_open              == 'Y' ) ||
           ( $memForm['tel'            ] != 'N' && $tel_open               == 'Y' ) ||
           ( $memForm['address'        ] != 'N' && $post_no_open           == 'Y' ) ||
           ( $memForm['address'        ] != 'N' && $address_open           == 'Y' ) ||
           ( $memForm['picture_image'  ] != 'N' && $picture_image_open     == 'Y' ) ||
           ( $memForm['character_image'] != 'N' && $character_image_open   == 'Y' ) ) {
            $openChk = true ;
        } else {
            $existChk= false;
            $openChk = false;
        }
    }
} else {
    $existChk = false;
}

if ( $existChk ) {
    echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
    echo ( " var exec = '".$exec ."';\n" );
    echo ( " var id   = '".$id   ."';\n" );
    echo ( " var no   = '".$no   ."';\n" );
    echo ( " var npop = '".$npop ."';\n" );
    echo ( "</SCRIPT>\n" );

	include 'common/js/common_js.php'; // ���� javascript
	include 'common/js/member_js.php'; // ȸ�� javascript
?>
<style>body
{scrollbar-face-color: #FFFFFF; scrollbar-shadow-color: #B4B4B4;
scrollbar-highlight-color: #FFFFFF; scrollbar-3dlight-color: #B4B4B4;
scrollbar-darkshadow-color: #FFFFFF; scrollbar-track-color: #F1F2F2;
scrollbar-arrow-color: #FFFFFF}body
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td width="17" height="17"><img src="images/join_01.gif" width="17" height="17"></td>
          <td background="images/join_bg01.gif">&nbsp;</td>
          <td width="17" height="17"><img src="images/join_02.gif" width="17" height="17"></td>
        </tr>
        <tr>
          <td background="images/join_bg02.gif">&nbsp;</td>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="10"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td bgcolor="cccccc" height="1"></td>
                          </tr>
                          <tr>
                            <td bgcolor="efefef" height="5"></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="5" class="text_01" bgcolor="#FFFFFF">
<?
    if ( $user_id_open == 'Y' || $admin_yn == 'Y' ) {
?>
                    <tr bgcolor="fafafa">
                      <td align="right" width="120" bgcolor="f7f7f7"><b>���̵�</b></td>
                      <td>&nbsp;&nbsp; <span class="text_03"><b><?=$user_id?></b></span><b>
                        </b></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" colspan="2" height="1" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>
<?
    if ( $member_level_open == 'Y' || $admin_yn == 'Y' ) {
        $sql  = "select member_nm, etc from $tb_member_kind";
        $sql .= " where member_level = '$member_level'";
        $member_nm    = simpleSQLQuery($sql);
?>

                    <tr bgcolor="fafafa">
                      <td align="right"><strong>ȸ������</strong></td>
                      <td>&nbsp;&nbsp; <?=$member_nm?></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" colspan="2" background="images/bg2.gif" height="1"></td>
                    </tr>
<?
    }
?>

<?
    if ( ( $memForm['name'] != 'N' && $name_open == 'Y' ) || $admin_yn == 'Y' ) {
?>

                    <tr bgcolor="fafafa">
                      <td align="right"><b>�� ��</b></td>
                      <td>&nbsp;&nbsp; <?=$name?></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" colspan="2" height="1" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>

<?
    if ( ( $memForm['nick_name'] != 'N' && $nick_name_open == 'Y' ) || $admin_yn == 'Y' ) {
?>

                    <tr bgcolor="fafafa">
                      <td align="right"><b>�г���</b></td>
                      <td>&nbsp;&nbsp; <?=$nick_name?></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" colspan="2" height="1" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>

<?
    if ( ( $memForm['sex'] != 'N' && $sex_open == 'Y' ) || $admin_yn == 'Y' ) {
?>

                    <tr bgcolor="fafafa">
                      <td align="right"><strong>����</strong></td>
                      <td>&nbsp;&nbsp; <?=$sex?>
                      </td>
                    </tr>
                    <tr bgcolor="fafafa" >
                      <td height="1" colspan="2" align="right"background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>

<?
    if ( $access_open == 'Y' || $admin_yn == 'Y' ) {
?>
                    <tr bgcolor="fafafa">
                      <td align="right"><strong>����Ƚ��</strong></td>
                      <td>&nbsp;&nbsp; <span class="text_03"><strong><?=$access?></strong></span>
                        ��</td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td height="1" colspan="2" align="right" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>

<?
    if ( $point_open == 'Y' || $admin_yn == 'Y' ) {
?>
                    <tr bgcolor="fafafa">
                      <td align="right"><strong>����Ʈ</strong></td>
                      <td>&nbsp;&nbsp; <span class="text_03"><strong><?=$point?></strong></span>
                        ��</td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td height="1" colspan="2" align="right" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>

<?
    if ( ( $memForm['e_mail'] == 'Y' && $e_mail_open == 'Y' ) || $admin_yn == 'Y' ) {
?>
                    <tr bgcolor="fafafa">
                      <td align="right"><b>�̸���</b></td>
                      <td>&nbsp;&nbsp; <?=$e_mail?></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" colspan="2" height="1" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>

<?
    if ( ( $memForm['home'] != 'N' && $home_open == 'Y' ) || $admin_yn == 'Y' ) {
?>
                    <tr bgcolor="fafafa">
                      <td align="right"><b>Ȩ������</b></td>
                      <td> &nbsp;&nbsp; <?=$home?></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" height="1" colspan="2" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>

<?
    if ( ( $memForm['tel'] != 'N' && $tel_open == 'Y' ) || $admin_yn == 'Y' ) {
?>
                    <tr bgcolor="fafafa">
                      <td align="right" height="20"><b>����ó ��ȣ</b></td>
                      <td height="20">&nbsp;&nbsp; <?=$tel?></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" height="1" colspan="2" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>
<?
    if ( ( $memForm['address'] != 'N' && $post_no_open == 'Y' ) || $admin_yn == 'Y' ) {
        if ( $post_no != '-' ) {
            $post_cd1 = substr($post_no, 0, 3);
            $post_cd2 = substr($post_no, 4, 3);
        }
?>
                    <tr bgcolor="fafafa">
                      <td align="right" height="20"><b>�����ȣ</b></td>
                      <td height="20">&nbsp;&nbsp; <?=$post_cd1?> - <?=$post_cd2?> </td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" height="1" colspan="2" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>
<?
    if ( ( $memForm['address'] != 'N' && $address_open == 'Y' ) || $admin_yn == 'Y' ) {
        $address = explode("$$", $address);
        $detail_address = $address[1];
        $address        = $address[0];
?>
                    <tr bgcolor="fafafa">
                      <td align="right" height="20"><b>�ּ�</b></td>
                      <td height="20"> &nbsp;&nbsp;  <?=$address?> <?=$detail_address?></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" height="1" colspan="2" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>
<img src='images/timg.gif' id='_dboard_tmp_img' style='position:absolute;visibility:hidden;'>

<?
    if ( ( $memForm['picture_image'] != 'N' && $picture_image_open == 'Y' ) || $admin_yn == 'Y' ) {
?>

                    <tr bgcolor="fafafa">
                      <td align="right" height="20"><strong>����</strong></td>
                      <td height="20"><table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="10">&nbsp;</td>
                            <td width="200"><table width="200" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc">
                                <tr>
                                  <td height="50" bgcolor="#FFFFFF">
<?
$f1         = $user_id . "_p.gif";
if ( !@is_file("data/member/picture/" . $f1 ) ) {
    echo "<a href='#' onClick='imagePopup(\"_dboard_preview_img1\");return false;'>";
    echo "  <img src='images/timg.gif' id='_dboard_preview_img1' border='0'>";
    echo "</a>";
} else {
    $f1Infor = "  <img src='data/member/picture/" . $f1 . "' id='_dboard_preview_img1' border='0' ";

    $size = @GetImageSize("data/member/picture/" . $f1);
    if($size[0] == 0 ) $size[0]=1;
    if($size[1] == 0 ) $size[1]=1;
    if ( $size[0] <= 200 ) {
        $f1Infor .= " width="  . $size[0];
    } else {
        $f1Infor .= " width=200";
    }
    $f1Infor .= ">";
    echo "<a href='#' onClick='imagePopup(\"_dboard_preview_img1\");return false;'>";
    echo $f1Infor;
    echo "</a>";
}
?>
                                  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td height="1" colspan="2" align="right" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>
<?
    if ( ( $memForm['character_image'] != 'N' && $character_image_open == 'Y' ) || $admin_yn == 'Y' ) {
?>
                    <tr bgcolor="fafafa">
                      <td align="right" height="20"><strong>ȸ�� ������</strong></td>
                      <td height="20"><table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="10">&nbsp;</td>
                            <td width="200"><table width="200" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc">
                                <tr>
                                  <td height="50" bgcolor="#FFFFFF">
<?
$f2         = "";
if ( $character_image_open == 'Y' ) { $f2 = $user_id . "_c.gif"      ; }
else                                { $f2 = $user_id . "_c_close.gif"; }

if ( !@is_file("data/member/character/" . $f2 ) ) {
    echo "<a href='#' onClick='imagePopup(\"_dboard_preview_img2\");return false;'>";
    echo "  <img src='images/timg.gif' id='_dboard_preview_img2' border='0'>";
    echo "</a>";
} else {
    $f1Infor = "  <img src='data/member/character/" . $f2 . "' id='_dboard_preview_img2' border='0' ";

    $size = @GetImageSize("data/member/character/" . $f2);
    if($size[0] == 0 ) $size[0]=1;
    if($size[1] == 0 ) $size[1]=1;
    if ( $size[0] <= 200 ) {
        $f1Infor .= " width="  . $size[0];
    } else {
        $f1Infor .= " width=200";
    }
    $f1Infor .= ">";
    echo "<a href='#' onClick='imagePopup(\"_dboard_preview_img2\");return false;'>";
    echo $f1Infor;
    echo "</a>";
}
?>
                                  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td height="1" colspan="2" align="right" background="images/bg2.gif"></td>
                    </tr>
<?
    }
?>
                  </table>
                  <br>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="right"><a href='#' onClick='self.close();return false;'><img src="images/button_close.gif" width="66" height="30" border='0'></a></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <td background="images/join_bg03.gif">&nbsp;</td>
        </tr>
        <tr>
          <td width="17" height="17"><img src="images/join_03.gif" width="17" height="17"></td>
          <td background="images/join_bg04.gif"></td>
          <td width="17" height="17"><img src="images/join_04.gif" width="17" height="17"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
    closeDBConnection (); // �����ͺ��̽� ���� ���� ����
} else {
    echo ( "<SCRIPT LANGUAGE='JavaScript'>\n");
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

    if ( !$openChk ) {
        MessageC ('P', '0017',"javascript:windowClose();:Ȯ��", $skinDir); // ������ ȸ�� ������ �����ϴ�.
    } else {

        MessageC ('P', '0012',"javascript:windowClose();:Ȯ��", $skinDir); // ȸ�� ���� ������ �������� �ʽ��ϴ�.
    }
}
footer(); // Footer ���
?>