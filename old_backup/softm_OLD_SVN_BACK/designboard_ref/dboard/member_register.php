<?
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'       ; // ���� ���̺귯��
include 'common/message.inc'   ; // ���� ������ ó��
include 'common/db_connect.inc'; // Data Base ���� Ŭ����

// �����ͺ��̽��� �����մϴ�.
$db   = initDBConnection (); // �����ͺ��̽��� �����մϴ�.

$memInfor = getMemInfor();      // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
$memForm  = getMemFormSetup(0); // ȸ�� �� ���� ������ ******* ȸ�� ���� �о� �帲. ********
$login_yn = $memInfor['login_yn']; // �α��� ����
$admin_yn = $memInfor['admin_yn']; // ���� ����

// logs ($memForm['member_level'] . '<BR>',true);
// logs ($memForm['sex'         ] . '<BR>',true);
// logs ($memForm['agreement'   ] . '<BR>',true);
// logs ($memForm['name'        ] . '<BR>',true);
// logs ($memForm['e_mail'      ] . '<BR>',true);
// logs ($memForm['jumin'       ] . '<BR>',true);
// logs ($memForm['tel'         ] . '<BR>',true);
// logs ($memForm['address'     ] . '<BR>',true);
// logs ($memForm['news_yn'     ] . '<BR>',true);
if ( !$mexec ) { $mexec  = 'insert'; }

if ( $mexec == 'insert' ) {
    $point = $memForm['point'];
    $a_member_secession    ="<a href='#' style='display:none'>"   ;   // ȸ�� Ż��
} else if ( $mexec == 'update' ) {
    $row = singleRowSQLQuery("select * from $tb_member where user_id = '".$memInfor['user_id']."'");
    $user_id      = $row['user_id'     ];
    if ( $user_id ) { $existChk = true; }
    $member_level = $row['member_level'];
    $password     = $row['password'    ];
    $name         = $row['name'        ];
    $nick_name    = $row['nick_name'   ];
    $sex          = $row['sex'         ];
    $e_mail       = $row['e_mail'      ];
    $home         = $row['home'        ];
    $birth        = $row['birth'       ];
    $age          = $row['age'         ];
    $tel          = $row['tel'         ];
    $address      = $row['address'     ];
    $post_no      = $row['post_no'     ];
    $member_st    = $row['member_st'   ];
    $news_yn      = $row['news_yn'     ];

    $point                = $row['point'               ];
    $user_id_open         = $row['user_id_open'        ];
    $member_level_open    = $row['member_level_open'   ];
    $name_open            = $row['name_open'           ];
    $nick_name_open       = $row['nick_name_open'      ];
    $sex_open             = $row['sex_open'            ];
    $e_mail_open          = $row['e_mail_open'         ];
    $home_open            = $row['home_open'           ];
    $birth_open           = $row['birth_open'          ];
    $age_open             = $row['age_open'            ];
    $tel_open             = $row['tel_open'            ];
    $address_open         = $row['address_open'        ];
    $post_no_open         = $row['post_no_open'        ];
    $point_open           = $row['point_open'          ];
    $picture_image_open   = $row['picture_image_open'  ];
    $character_image_open = $row['character_image_open'];
    $hint                 = $row['hint'                ];
    $answer               = $row['answer'              ];

    $reg_date     = $row['reg_date'    ];
    $acc_date     = $row['acc_date'    ];

    //ȸ�� Ż��
    // mode : '1' : �˾�   ȸ�� Ż�� ������ ����
    //        '2' : ����â ȸ�� Ż�� ������ ����
    if ( !$member_secession_mode         ) { $member_secession_mode         = '1'   ;}
    if ( !$member_secession_succ_url     ) { $member_secession_succ_url     = ''    ;} // ���� URL
    if ( !$member_secession_popup_width  ) { $member_secession_popup_width  = '400' ;} // �˾� ���� ����
    if ( !$member_secession_popup_height ) { $member_secession_popup_height = '205' ;} // �˾� ���� ����
    if ( !$member_secession_scroll_yn    ) { $member_secession_scroll_yn    = 'N'   ;} // �˾� ��ũ�ѹ� ���� ���� ( 'Y', 'N' )

    $a_member_secession    ="<a href='#' onClick=\"openMemberSecession('$member_secession_mode', '$member_secession_succ_url', '$member_secession_popup_width', '$member_secession_popup_height', '$member_secession_scroll_yn');return false;\">";// ȸ�� Ż��
}
if ( $mexec == 'insert' || ( $mexec == 'update' && $existChk ) ) {

    if ( $mexec == 'update' ) {
        head('ȸ�� ���� ����', 'memberOnLoad();');  // Header ���
        _css();
    } else {
        head('ȸ�� ����'     , 'memberOnLoad();');  // Header ���
        _css();
    }

    echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
    echo ( " var exec = '".$exec ."';\n" );
    echo ( " var id   = '".$id   ."';\n" );
    echo ( " var no   = '".$no   ."';\n" );
    echo ( " var npop = '".$npop ."';\n" );
    echo ( "</SCRIPT>\n" );

	include 'common/js/common_js.php'; // ���� javascript
	include 'common/js/member_js.php'; // ȸ�� javascript
?>
    <SCRIPT LANGUAGE='javascript'>
    <!--
        function memberOnLoad() {
			if ( typeof(document.memberRegForm.hint) == 'object' ) document.memberRegForm.hint.selectedIndex = '<?=$hint?>';
            if ( typeof( opener ) == 'object' ) {
//              WindowResize ( 100, 100 );
//              var y = parseInt(document.body.clientHeight) / 2 + parseInt(document.body.scrollTop ) - ( parseInt(document.body.clientHeight ) / 2 );
//              window.moveTo(0, y);
            }
        }
        function dupCheck() {
            var userId = document.memberRegForm.user_id.value;
            if (  memberIdCheck(userId) ) {
                document.dupChkForm.user_id.value = userId;
                var dupWin = window.open('about:blank','dupChkWin','toolbar=no,menubar=no,resizable=no,scrollbars=no,width=300,height=150');
                dupWin.focus();
                document.dupChkForm.target = 'dupChkWin';
                document.dupChkForm.submit();
            }
        }

        function memberIdCheck(userId) {
            if ( userId.length < 4 || userId.length > 20 ) {
                alert("���̵�� 4�� �̻�, 20�� ���Ͽ��� �մϴ�.");
                document.memberRegForm.user_id.focus();
                return false;
            }
            if ( inStrBlankCheck (userId) ) {
                alert ("���̵� �Էµ��� �ʾҰų� ���� ���ڸ� ����ϼ̽��ϴ�.");
                document.memberRegForm.user_id.focus();
                return false;
            }
            if ( !isAlphaNum (userId) ) {
                alert ("'����', '����', '_'�θ� ���̵� �ۼ��� �ּ���.");
                document.memberRegForm.user_id.focus();
                return false;
            }
            if ( userId.length > 40 ) {
                alert ("40���̳��� �Է��� �ּ���.");
                document.memberRegForm.user_id.focus();
                return false;
            }
            return true;
        }
        var memberLevel = <?=$memInfor['member_level']?>;
        var enableJumin = '<?=$memForm['jumin' ]?>';
        var enableEmail = '<?=$memForm['e_mail']?>';
        var enableHint  = '<?=$memForm['hint'  ]?>';

        var enableNickName      = '<?=$memForm['nick_name'       ]?>';
        var enableSex           = '<?=$memForm['sex'             ]?>';
        var enableHome          = '<?=$memForm['home'            ]?>';
        var enableBirth         = '<?=$memForm['birth'           ]?>';
        var enableAge           = '<?=$memForm['age'             ]?>';
        var enableTel           = '<?=$memForm['tel'             ]?>';
        var enableAddress       = '<?=$memForm['address'         ]?>';
        var enablePictureImage  = '<?=$memForm['picture_image'   ]?>';
        var enableCharacterImage= '<?=$memForm['character_image' ]?>';

        function writeData() {

            if ( typeof( document.memberRegForm.agree_chk ) == 'object' && !isChecked( document.memberRegForm.agree_chk ) ) {
                alert ( '����� �����ϼž� ȸ�� ������ �˴ϴ�.' );
                document.memberRegForm.agree_chk.focus();
                return false;
            }

            var userId = '';
            if ( typeof( document.memberRegForm.user_id ) == 'object' ) {
                userId = document.memberRegForm.user_id.value;
                if ( !memberIdCheck(userId) ) { return false; }
            }

            if ( !document.memberRegForm.password.disabled && inStrBlankCheck (document.memberRegForm.password) ) {
                alert ("��� ��ȣ �Է��� Ȯ���� �ּ���.");
                document.memberRegForm.password.focus();
                return false;
            }

            if ( document.memberRegForm.password.value != document.memberRegForm.confirm_password.value ) {
                alert ("��� ��ȣ�� ��ġ ���� �ʽ��ϴ�.");
                document.memberRegForm.confirm_password.focus();
                return false;
            }

            if ( typeof ( document.memberRegForm.hint ) == 'object' && document.memberRegForm.hint.value == '' ) {
                alert ("��Ʈ�� �������ּ���.");
                document.memberRegForm.hint.focus();
                return false;
            }

            if ( typeof ( document.memberRegForm.answer ) == 'object' && inStrAllBlankCheck (document.memberRegForm.answer ) ) {
                alert ("�亯�� �Է����ּ���.");
                document.memberRegForm.answer.focus();
                return false;
            }

            if ( typeof ( document.memberRegForm.name ) == 'object' && inStrAllBlankCheck (document.memberRegForm.name) ) {
                alert ("�̸� �Է��� Ȯ���� �ּ���.");
                document.memberRegForm.name.focus();
                return false;
            }

            if ( typeof ( document.memberRegForm.nick_name ) == 'object' && enableNickName == 'C' && inStrAllBlankCheck (document.memberRegForm.nick_name) ) {
                alert ("���� �Է��� Ȯ���� �ּ���.");
                document.memberRegForm.nick_name.focus();
                return false;
            }

            if ( typeof ( document.memberRegForm.sex ) == 'object' && enableSex == 'C' && !isChecked (document.memberRegForm.sex) ) {
                alert ("������ ������ �ּ���.");
                document.memberRegForm.sex[0].focus();
                return false;
            }

            if ( typeof ( document.memberRegForm.sex ) == 'object' && enableSex == 'C' && !isChecked (document.memberRegForm.sex) ) {
                alert ("������ ������ �ּ���.");
                document.memberRegForm.sex[0].focus();
                return false;
            }

            if ( enableJumin == 'N' && enableEmail == 'Y' ) {
                if ( typeof ( document.memberRegForm.e_mail ) == 'object' && ( inStrBlankCheck (document.memberRegForm.e_mail) || !isEmail (document.memberRegForm.e_mail) ) ) {
                    alert ("�̸����� �ݵ�� �ùٸ��� �Է��ϼž� �մϴ�.\n�ùٸ� �̸��� ������ �Է��ϼž߸� ���̵�/��й�ȣ �нǽ� ������ �޾� ���Ǽ� �ֽ��ϴ�.");
                    document.memberRegForm.e_mail.focus();
                    return false;
                }
            } else {
                if ( typeof ( document.memberRegForm.e_mail ) == 'object' && document.memberRegForm.e_mail.value !='' && inStrBlankCheck (document.memberRegForm.e_mail) ) {
                    alert ("�̸��� �Է��� Ȯ���� �ּ���.");
                    document.memberRegForm.e_mail.focus();
                    return false;
                }
            }

            if ( typeof ( document.memberRegForm.home ) == 'object' && enableHome == 'C' && inStrAllBlankCheck (document.memberRegForm.home) ) {
                alert ("Ȩ������ �ּ� �Է��� Ȯ���� �ּ���.");
                document.memberRegForm.home.focus();
                return false;
            }

            // ������ ��� �ֹ� ��ȣ �˻縦 ����
            if (  memberLevel != 99 ) {
                if ( typeof ( document.memberRegForm.jumin_1 ) == 'object' && !juminCheck (document.memberRegForm.jumin_1.value, document.memberRegForm.jumin_2.value) ) {
                    alert ("�ֹι�ȣ �Է��� Ȯ���� �ּ���.");
                    document.memberRegForm.jumin_1.focus();
                    return false;
                }

                if ( typeof ( document.memberRegForm.birth ) == 'object' && enableBirth == 'C' && document.memberRegForm.birth.value == '' ) {
                    alert ( "��������� �Է����ּ���." );
                    document.memberRegForm.birth_year.focus();
                    return false;
                }

                if ( typeof ( document.memberRegForm.age ) == 'object' && enableAge == 'C' && document.memberRegForm.age.value == '' ) {
                    alert ( "���̸� �Է����ּ���." );
                    document.memberRegForm.age.focus();
                    return false;
                }

                if ( typeof ( document.memberRegForm.tel ) == 'object' && enableTel == 'C' && document.memberRegForm.tel.value == '' ) {
                    alert ( "����ó ��ȣ�� �Է����ּ���." );
                    document.memberRegForm.tel.focus();
                    return false;
                }

                if ( typeof ( document.memberRegForm.post_cd1 ) == 'object' && enableAddress == 'C' && ( document.memberRegForm.post_cd1.value == '' || inStrBlankCheck (document.memberRegForm.post_cd1) || !isNumber(document.memberRegForm.post_cd1.value) ) )
                {
                    alert ("�����ȣ �Է��� Ȯ���� �ּ���.");
                    document.memberRegForm.post_cd1.focus();
                    return false;
                }
                if ( typeof ( document.memberRegForm.post_cd2 ) == 'object' && enableAddress == 'C' && ( document.memberRegForm.post_cd2.value == '' || inStrBlankCheck (document.memberRegForm.post_cd2) || !isNumber(document.memberRegForm.post_cd2.value) ) )
                {
                    alert ("�����ȣ �Է��� Ȯ���� �ּ���.");
                    document.memberRegForm.post_cd2.focus();
                    return false;
                }
                if ( typeof ( document.memberRegForm.address  ) == 'object' && enableAddress == 'C' && ( document.memberRegForm.address.value  == '' || inStrAllBlankCheck (document.memberRegForm.address ) ) )
                {
                    alert ("�ּ� �Է��� Ȯ���� �ּ���.");
                    document.memberRegForm.address.focus();
                    return false;
                }
                if ( typeof ( document.memberRegForm.detail_address  ) == 'object' && enableAddress == 'C' && ( document.memberRegForm.detail_address.value  == '' || inStrAllBlankCheck (document.memberRegForm.detail_address ) ) )
                {
                    alert ("�� �ּ� �Է��� Ȯ���� �ּ���.");
                    document.memberRegForm.detail_address.focus();
                    return false;
                }

                if ( enablePictureImage == 'C' && document.memberRegForm.picture_exist.value == 'N' ) {
                    alert ("���� �Է��� Ȯ���� �ּ���.");
                    document.memberRegForm.picture_image.focus();
                    return false;
                }

                if ( enableCharacterImage == 'C' && document.memberRegForm.character_exist.value == 'N' ) {
                    alert ("ȸ�� ������ �Է��� Ȯ���� �ּ���.");
                    document.memberRegForm.character_image.focus();
                    return false;
                }
            }

            document.memberRegForm.action = baseDir + 'member_register_exec.php?id=' + id + '&exec=' + exec + '&no=' + no + '&npop' + npop;
            return true;

        }

        function autoSex() {
            if ( typeof ( document.memberRegForm.jumin_2 ) == 'object' && typeof ( document.memberRegForm.sex ) == 'object' && document.memberRegForm.jumin_1.value.length == 6 && document.memberRegForm.jumin_2.value.length == 7 ) {
                if ( document.memberRegForm.jumin_2.value.substr(0,1) % '2' == 1 ) {
                    document.memberRegForm.sex[0].checked = true;
                } else if ( document.memberRegForm.jumin_2.value.substr(0,1) % '2' == 0 ) {
                    document.memberRegForm.sex[1].checked = true;
                }
            }
        }

        function passwordEnabled() {
            if ( isChecked(document.memberRegForm.password_change) ) {
                objectBackColor( document.memberRegForm.password, 'white'  );
                objectDisabled ( document.memberRegForm.password ,'N'     );
                objectBackColor( document.memberRegForm.confirm_password,'white' );
                objectDisabled ( document.memberRegForm.confirm_password,'N'     );
                document.memberRegForm.password.focus();
            } else {
                objectBackColor( document.memberRegForm.password, '#E1E1E1'  );
                objectDisabled ( document.memberRegForm.password ,'Y'     );
                objectBackColor( document.memberRegForm.confirm_password,'#E1E1E1'  );
                objectDisabled ( document.memberRegForm.confirm_password,'Y'     );
                document.memberRegForm.password.value = '';
                document.memberRegForm.confirm_password.value = '';
            }
        }

    var systemDate = '<?=date ( "YmdHis" )?>';
    function birthDateCheck () {
        var birth_year  = parseInt(document.memberRegForm.birth_year.value );
        var birth_month = parseInt(document.memberRegForm.birth_month.value);
        var birth_day   = parseInt(document.memberRegForm.birth_day.value  );
        var birth_date  = birth_year + birth_month + birth_day;
//        alert ( birth_date );
        if ( birth_date.length == 8 ) {
            var _age = age ( birth_date, systemDate );
            if ( ( !isDate(birth_date) || _age < 0 ) ) { return false; }
        } else {
            birth_year  = paddingChar(birth_year , 4,'0');
            birth_month = paddingChar(birth_month, 2,'0');
            birth_day   = paddingChar(birth_day  , 2,'0');
            birth_date  = birth_year + birth_month + birth_day;
            var _age = age ( birth_date, systemDate );
            if ( _age < 0 ) { return false; }
        }
//      alert ( _age );
        document.memberRegForm.birth.value = birth_date;
//      alert ( typeof ( document.memberRegForm.age ) );
        if ( typeof ( document.memberRegForm.age ) != 'undefined' ) {
            document.memberRegForm.age.value = _age;
        }
        return true;
    }

    function juminAgeInsert() {
        var jumin1 = document.memberRegForm.jumin_1.value
        var jumin2 = document.memberRegForm.jumin_2.value
        if ( juminCheck (jumin1, jumin2) ) {
            var _age    = null;
            var century = null;
            if ( parseInt ( jumin2.substr(0,1) ) < 3 ) { // 19xx
                century = '19';
            } else {  // 20xx
                century = '20';
            }
            var birthDate = century + jumin1;
            _age = age ( birthDate, systemDate );
            document.memberRegForm.age.value   = _age;
            document.memberRegForm.birth_year.value     = birthDate.substr(0,4);
            document.memberRegForm.birth_month.value    = birthDate.substr(4,2);
            document.memberRegForm.birth_day.value      = birthDate.substr(6,2);
            document.memberRegForm.birth.value          = birthDate;
        }
    }

    var dboardPreViewImg   = null;
    var dboardPreViewWidth = 200 ;
    var dboardPreImgPath   = null;

    var dboardTmpImg1=new Image();

    function imagePreView(fileInfor,viewAreaId) {
        var src = null;
        if ( typeof(fileInfor) == 'object' ) { dboardPreImgPath = fileInfor.value; }
        else                                 { dboardPreImgPath = fileInfor      ; }
        dboardPreImgPath = 'file:///' + dboardPreImgPath.replace(/\\/g,'/');

        dboardPreViewImg = getObject(viewAreaId);

		dboardTmpImg1.src       = dboardPreImgPath;
		dboardPreViewImg.src    = dboardPreImgPath;

		if ( viewAreaId == '_dboard_preview_img1' ) {
			document.memberRegForm.picture_exist.value = 'Y';
		} else if ( viewAreaId == '_dboard_preview_img2' ) {
			document.memberRegForm.character_exist.value = 'Y'
		}

        // imagePreViewResize();
        setTimeout('imagePreViewResize()',1000);
    }

    function imagePreViewResize() {

        var width  = dboardTmpImg1.width ;
        var height = dboardTmpImg1.height;

        dboardPreViewImg.realWidth  = width ; // ���� ���� ����
        dboardPreViewImg.realHeight = height; // ���� ���� ����


        if ( width > dboardPreViewWidth ) dboardPreViewImg.width = dboardPreViewWidth;
        else                              dboardPreViewImg.width = width;
        dboardPreViewImg.style.display="";

    /*
        var dd='';
        for (var i in dboardPreViewImg) {
            dd += i + ' ' + dboardPreViewImg[i] + '<bR>';
        }
        document.write(dd);
    */
    }

    var dboardPopWin = null;
    var dboardPopImg = null;
    function imagePopup(id) {
        dboardPopImg =new Image();
        dboardPopImg.src=getObject(id).src;

        setTimeout('imagePopupOpen()',1000);

        return false;
    }
    function imagePopupOpen() {
        if ( dboardPopImg != null ) {
            var width  = dboardPopImg.width ;
            var height = dboardPopImg.height;

            if ( dboardPopWin == null ) {
                dboardPopWin = window.open("about:blank","_dboard_preview_img_window","width=" + width +",height=" + height + ",toolbar=no,menubar=no,resizable=yes,scrollbars=auto");
            } else {
                dboardPopWin.close();
                dboardPopWin = window.open("about:blank","_dboard_preview_img_window","width=" + width +",height=" + height + ",toolbar=no,menubar=no,resizable=yes,scrollbars=auto");
            }
            dboardPopWin.document.open();
            dboardPopWin.document.write("<html>");
            dboardPopWin.document.write("<title>�̸�����</title>");
            dboardPopWin.document.write("<body bgcolor='#FFFFFF' text='#000000' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' onUnLoad='opener.dboardPopWin=null;' onClick='window.close();'>");
            dboardPopWin.document.write("<img id='_dboard_popup_img' src='" + dboardPopImg.src + "'>");
            dboardPopWin.document.write("</body>");
            dboardPopWin.document.write("</html>");
            dboardPopWin.document.close();
            dboardPopWin.focus();
        }
        dboardPopImg = null;
    }
//-->
</SCRIPT>

<style>
body {scrollbar-face-color: #FFFFFF; scrollbar-shadow-color: #B4B4B4;
scrollbar-highlight-color: #FFFFFF; scrollbar-3dlight-color: #B4B4B4;
scrollbar-darkshadow-color: #FFFFFF; scrollbar-track-color: #F1F2F2;
scrollbar-arrow-color: #FFFFFF}body
</style>

    <form name='dupChkForm' method='post' target='_dup_check' action='<?=$baseDir?>member_register_exec.php'>
        <input type='hidden' name='user_id'   value=''>
        <input type='hidden' name='gubun'     value='dup_check'>
    </form>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <form name='memberRegForm' method='post' action='<?=$baseDir?>member_register_exec.php' onSubmit='return writeData();' enctype='multipart/form-data'>
        <input type='hidden' name='mexec' value='<?=$mexec?>'>
        <input type='hidden' name='succ_url' value='<?=$succ_url?>'>
      <tr>
        <td>
          <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_01.gif" width="17" height="17"></td>
              <td background="<?=$baseDir?>images/join_bg01.gif">&nbsp;</td>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_02.gif" width="17" height="17"></td>
            </tr>
            <tr>
              <td background="<?=$baseDir?>images/join_bg02.gif">&nbsp;</td>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">


    <?
    if ( $mexec == 'insert' && $memForm['agreement'] == 'Y') {
    ?>

                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>
                            <textarea name="textarea4" class="textarea_03" style="width:100%" rows="10">
    <?=htmlspecialchars ($memForm['agreement_content'], ENT_QUOTES);?>
                            </textarea>
                          </td>
                        </tr>
                        <tr>
                          <td height="10"></td>
                        </tr>
                        <tr>
                          <td class="text_01">
                            <input type="checkbox" name="agree_chk" value="Y">
                            ���� �¶��� ȸ�� ����� �����մϴ�.</td>
                        </tr>
                        <tr>
                          <td height="10"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
    <?
    } // if END
    ?>
                  <tr>
                    <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td bgcolor="cccccc" height="1"></td>
                              </tr>
                              <tr>
                                <td bgcolor="efefef" height="5"></td>
                              </tr>
                              <tr>
                                <td bgcolor="FFFFFF" height="2"></td>
                              </tr>
                            </table>

                      <table width="100%" border="0" cellspacing="0" cellpadding="5" class="text_01" bgcolor="#FFFFFF">

                        <tr bgcolor="fafafa">
                          <td align="right" width="120" bgcolor="f7f7f7"><b>���̵�</b></td>
                          <td>&nbsp;&nbsp;
    <? if ( $mexec == 'insert' ) {
          $checked = "checked"; // ����
    ?>
                            <input type="text" name="user_id" maxlength='20'>
                            <a href='#' onClick='dupCheck();return false;'><img border="0" name="imageField3222" src="<?=$baseDir?>images/button_idc.gif" width="68" height="19" align="absmiddle"></a>
    <? } else if ( $mexec == 'update' ) {
    ?>
    <?=$user_id?>
    <?
          $checked = ( $user_id_open == 'Y' ) ? "checked" : ''; // ����
       }
    ?>
                            <input type="checkbox" name="user_id_open"   value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>

                        <tr bgcolor="fafafa">
                          <td align="right" width="120" bgcolor="f7f7f7"><b>ȸ������</b></td>
                          <td>&nbsp;&nbsp;
<?if ( $admin_yn == 'Y' ) {
echo "<select name='member_level'>";

$sql  = "select member_level, member_nm, etc from $tb_member_kind";
$sql .= ' where member_level != 0 ';
$sql .= ' order by member_level ';
$stmt = multiRowSQLQuery($sql);

while ( $kind = multiRowFetch  ($stmt) ) {
    $member_level = $kind['member_level' ];
    $member_nm    = $kind['member_nm'    ];
    $checked = ( $row['member_level'] == $member_level ) ? "selected" : ''; // ȸ�� ���� ( ��ȸ�� )
    echo "<option value='" . $member_level . "' $checked>". $member_nm ."</option>\n";
}
echo "</select>";

} else {
    $sql  = "select member_nm, etc from $tb_member_kind";
    $sql .= ' where member_level = 1 ';
    $member_nm    = simpleSQLQuery($sql);
    echo $member_nm;
}

$checked = ""; // ����
if( $mexec == 'insert' || ( $mexec == 'update' && $member_level_open == 'Y') ) $checked = "checked"; // ����
?>
                        <input type="checkbox" name="member_level_open" value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>


                        <tr bgcolor="fafafa">
                          <td align="right"><b>��й�ȣ</b></td>
                          <td>&nbsp;&nbsp;
    <? if($mexec == 'update') {?>
                            <input type="password" name="password"         maxlength='20' style='background:#E1E1E1' disabled>
                        ��� ��ȣ ���� <input type="checkbox" value='Y' name="password_change" onClick='passwordEnabled()'>
    <? } else {?>
                            <input type="password" name="password"         maxlength='20'>
    <? }?>
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>

                        <tr bgcolor="fafafa">
                          <td align="right"><b>��й�ȣȮ��</b></td>
                          <td>&nbsp;&nbsp;
    <? if($mexec == 'update') {?>
                            <input type="password" name="confirm_password" maxlength='20' style='background:#E1E1E1' disabled>
    <? } else {?>
                            <input type="password" name="confirm_password" maxlength='20'>
    <? }?>
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>

    <?
    if ( $memForm['hint'] == 'Y' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right" width="120" bgcolor="f7f7f7"><b>��Ʈ / �亯</b></td>
                          <td>&nbsp;&nbsp;
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $name_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <select name='hint'>
                            <option value=''  >----------- ��Ʈ ���� -----------</option>
                            <option value='1' >���� ���� ��1ȣ��?             </option>
                            <option value='2' >���� ģ�� ģ�� �̸���?         </option>
                            <option value='3' >���� ���� �����ϴ� ��������?   </option>
                            <option value='4' >�� ������?                     </option>
                            <option value='5' >�����ϴ� ����?                 </option>
                        </select>
                        <input type='text' name='answer' maxlength="100" value='<?=$answer?>'>
                        </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['name'] == 'Y' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right" width="120" bgcolor="f7f7f7"><b>�̸�</b></td>
                          <td>&nbsp;&nbsp;
                            <input type='text' name='name' value='<?=$name?>'>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $name_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <input type="checkbox" name="name_open" value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['nick_name'] == 'Y' || $memForm['nick_name'] == 'C' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right"><b>����</b></td>
                          <td>&nbsp;&nbsp;
                            <input type="text" name="nick_name" size="49"  maxlength='100' value='<?=$nick_name?>'>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $nick_name_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <input type="checkbox" name="nick_name_open" value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['sex'] == 'Y' || $memForm['sex'] == 'C' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right" width="120" bgcolor="f7f7f7"><b>����</b></td>
                          <td>&nbsp;&nbsp;
    <?
        if ( $sex == '1' ) { // ����
            echo "<input type='radio' name='sex' value='1' checked> �� <input type='radio' name='sex' value='2'> ��";
        } else if ( $sex == '2' ) {
            echo "<input type='radio' name='sex' value='1'> �� <input type='radio' name='sex' value='2' checked> ��";
        } else {
            echo "<input type='radio' name='sex' value='1'> �� <input type='radio' name='sex' value='2'> ��";
        }

        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $sex_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <input type="checkbox" name="sex_open" value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['e_mail'] == 'Y' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right"><b>�̸���</b></td>
                          <td>&nbsp;&nbsp;
                            <input type="text" name="e_mail" size="49"  maxlength='100' value='<?=$e_mail?>'>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $e_mail_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <input type="checkbox" name="e_mail_open" value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['home'] == 'Y' || $memForm['home'] == 'C' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right"><b>Ȩ������</b></td>
                          <td>&nbsp;&nbsp;
                            <input type="text" name="home" size="49"  maxlength='100' value='<?=$home?>'>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $home_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <input type="checkbox" name="home_open" value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $mexec=='insert' && $memForm['jumin'] == 'Y' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right"><b>�ֹε�Ϲ�ȣ</b></td>
                          <td>&nbsp;&nbsp;
                            <input type="text" name="jumin_1" maxlength='6' onBlur='autoSex();' value='<?=$jumin_1?>' onChange='juminAgeInsert();'>
                            -
                            <input type="text" name="jumin_2" maxlength='7' onBlur='autoSex();' value='<?=$jumin_2?>' onChange='juminAgeInsert();'>
                            <br>
                            &nbsp;&nbsp;&nbsp;* �ߺ� ������ ������ ( ��ȣȭ �Ǿ� �����ڵ� �˼� �����ϴ�. )</td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['birth'] == 'Y' || $memForm['birth'] == 'C' ) {
        $birth_year  = (int)substr($birth, 0,4);if ( $birth_year  == '0000' ) $birth_year  = '';
        $birth_month = (int)substr($birth, 4,2);if ( $birth_month == '00'   ) $birth_month = '';
        $birth_day   = (int)substr($birth, 6,2);if ( $birth_day   == '00'   ) $birth_day   = '';
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right" height="20"><b>�������</b></td>
                          <td height="20">&nbsp;&nbsp;
                        <input type="text" name="birth_year"  value='<?=$birth_year ?>' size='4' maxlength="4" onChange='if(this.value != "" && !isNumber (this.value)) { alert("��¥ �Է��� �ùٸ��� �ʽ��ϴ�.");return false; } if ( !birthDateCheck () ) { return false; }'>��
                        <input type="text" name="birth_month" value='<?=$birth_month?>' size='2' maxlength="2" onChange='if(this.value != "" && !isNumber (this.value)) { alert("��¥ �Է��� �ùٸ��� �ʽ��ϴ�.");return false; } if ( !birthDateCheck () ) { return false; }'>��
                        <input type="text" name="birth_day"   value='<?=$birth_day  ?>' size='2' maxlength="2" onChange='if(this.value != "" && !isNumber (this.value)) { alert("��¥ �Է��� �ùٸ��� �ʽ��ϴ�.");return false; } if ( !birthDateCheck () ) { return false; }'>��

                        <input type="hidden" name="birth"  value='<?=$birth  ?>'>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $birth_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <input type="checkbox" name="birth_open" value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    } else {
    ?>
        <input type="hidden" name="birth"       >
        <input type="hidden" name="birth_year"  >
        <input type="hidden" name="birth_month" >
        <input type="hidden" name="birth_day"   >
    <?
    }
    ?>

    <?
    if ( $memForm['age'] == 'Y' || $memForm['age'] == 'C' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right" height="20"><b>����</b></td>
                          <td height="20">&nbsp;&nbsp;
                        <input type="text" name="age" value='<?=$age?>' size='4' maxlength="3" style='text-align:right'  onChange='if(this.value != "" && !isNumber (this.value)) { alert("���� �Է��� �ùٸ��� �ʽ��ϴ�.");return false; }'>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $age_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <input type="checkbox" name="age_open" value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['age'] == 'N' ) {
    ?>
                        <input type="hidden" name="age" value='<?=$age?>'>
    <?
    }
    ?>

    <?
    if ( $memForm['news_yn'] == 'Y' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right" height="20"><b>�������� ����</b></td>
                          <td height="20">&nbsp;
    <?
            $checked = ( $news_yn == 'Y' || $mexec == 'insert' ) ? "checked" : '';
            echo "<input type='checkbox' name='news_yn' value='Y' $checked>";
    ?>
                            �������͸� �ްڽ��ϴ�.
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['tel'] == 'Y' || $memForm['tel'] == 'C' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right" height="20"><b>����ó ��ȣ</b></td>
                          <td height="20">&nbsp;&nbsp;
                            <input type="text" name="tel" maxlength='20' value='<?=$tel?>'>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $tel_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <input type="checkbox" name="tel_open" value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['address'] == 'Y' || $memForm['address'] == 'C' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right" height="20"><b>�����ȣ</b></td>
                          <td height="20">&nbsp;&nbsp;
    <?
    if ( $post_no != '-' ) {
        $post_cd1 = substr($post_no, 0, 3);
        $post_cd2 = substr($post_no, 4, 3);
    }
    $address = explode("$$", $address);
    $detail_address = $address[1];
    $address        = $address[0];
    ?>
                            <input type="text" name="post_cd1" id="post_cd1" size='8' maxlength='3' value='<?=$post_cd1?>'> - <input type="text" name="post_cd2" id="post_cd2" size='8' maxlength='3' value='<?=$post_cd2?>'>
                            <a href='#' onClick="window.open('<?=$baseDir?>post.php?post_cd_field1=post_cd1&post_cd_field2=post_cd2&address_field=address&detail_address_field=detail_address','_dboard_m_post','width=500,height=165,toolbar=no,scrollbars=no');return false;"><img border="0" name="imageField3222" src="<?=$baseDir?>images/button_search.gif" align="top"></a>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $post_no_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <input type="checkbox" name="post_no_open" value='Y' <?=$checked?>> ����
                            </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" height="20"><b>�ּ�</b></td>
                          <td height="20"> &nbsp;&nbsp;
                            <input type="text" name="address" id="address" size='49' value='<?=$address?>'>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $address_open == 'Y') ) $checked = "checked"; // ����
    ?>
                        <input type="checkbox" name="address_open" value='Y' <?=$checked?>> ����
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" height="20"><b>���ּ�</b></td>
                          <td height="20"> &nbsp;&nbsp;
                            <input type="text" name="detail_address" id="detail_address" size="49" value='<?=$detail_address?>'>
                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="#FFFFFF" align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>
<img src='images/timg.gif' id='_dboard_tmp_img' style='position:absolute;visibility:hidden;'>


    <?
    if ( $memForm['picture_image'] == 'Y' || $memForm['picture_image'] == 'C' ) {
    ?>

                        <tr bgcolor="fafafa">
                          <td align="right"><strong>����&nbsp;</strong></td>
                          <td class="text_01">&nbsp;&nbsp; <input name="picture_image" type="file" class="textarea_01" onChange='imagePreView(this,"_dboard_preview_img1");' onKeyDown='return false;'>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $picture_image_open == 'Y') ) $checked = "checked"; // ����
    ?>
                            <input type="checkbox" name="picture_image_open" value='Y' <?=$checked?>> ����

                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right"><strong>���� �̸�����&nbsp;</strong></td>
                          <td class="text_01">
                            <table border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="10">&nbsp;</td>
                                <td width="200">
                                  <table border="0" cellpadding="0" cellspacing="1" bgcolor="cccccc">
                                    <tr>
                                      <td width="200" height="50" align="center" bgcolor="#FFFFFF">
<?
$f1         = "";
if ( $picture_image_open == 'Y' ) { $f1 = $user_id . "_p.gif"; }
else                              { $f1 = $user_id . "_p_close.gif"; }
$dir = $baseDir . "data/member/picture/";
if ( !@is_file($dir . $f1 ) ) {
    echo "<a href='#' onClick='imagePopup(\"_dboard_preview_img1\");return false;'>";
    echo "  <img src='images/timg.gif' id='_dboard_preview_img1' border='0'>";
    echo "</a>";
    echo "<input type='hidden' name='picture_exist' value='N'>";
} else {
    $f1Infor = "  <img src='$dir" . $f1 . "' id='_dboard_preview_img1' border='0' ";
    $size = @GetImageSize($dir . $f1);
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
    echo "<input type='hidden' name='picture_exist' value='Y'>";
}
?>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                <td valign='bottom'>
<?
if ( $mexec == 'update' && $memForm['picture_image'] != 'C' ) {
?>
    <input type="checkbox" name="delete_picture_image" value="Y"> ����
<?
}
?>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="#FFFFFF" align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['character_image'] == 'Y' || $memForm['character_image'] == 'C' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right"><strong>&nbsp;ȸ�� ������</strong>&nbsp;
                          </td>
                          <td class="text_01">&nbsp;&nbsp; <input name="character_image" type="file" class="textarea_01" onChange='imagePreView(this,"_dboard_preview_img2");' onKeyDown='return false;'>
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $character_image_open == 'Y') ) $checked = "checked"; // ����
    ?>
                            <input type="checkbox" name="character_image_open" value='Y' <?=$checked?>> ����<BR>
                            &nbsp;&nbsp; (16�ȼ� �� 16�ȼ� ������ ���ּ���.)
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right"><strong>������ �̸�����</strong>&nbsp;</td>
                          <td class="text_01">
                            <table border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="10">&nbsp;</td>
                                <td width="200">
                                  <table border="0" cellpadding="0" cellspacing="1" bgcolor="cccccc">
                                    <tr>
                                      <td width="200" height="50" align="center" bgcolor="#FFFFFF">
<?
$f2         = "";
if ( $character_image_open == 'Y' ) { $f2 = $user_id . "_c.gif"; }
else                                       { $f2 = $user_id . "_c_close.gif"; }

$dir = $baseDir . "data/member/character/";
if ( !@is_file($dir . $f2 ) ) {
    echo "<a href='#' onClick='imagePopup(\"_dboard_preview_img2\");return false;'>";
    echo "  <img src='images/timg.gif' id='_dboard_preview_img2' border='0'>";
    echo "</a>";
    echo "<input type='hidden' name='character_exist' value='N'>";
} else {
    $f1Infor = "  <img src='$dir" . $f2 . "' id='_dboard_preview_img2' border='0' ";

    $size = @GetImageSize($dir . $f2);
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
    echo "<input type='hidden' name='character_exist' value='Y'>";
}
?>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                <td valign='bottom'>
<?
if ( $mexec == 'update' && $memForm['character_image'] != 'C' ) {
?>
    <input type="checkbox" name="delete_character_image" value="Y"> ����
<?
}
?>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="#FFFFFF" align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>

    <?
    if ( $memForm['point_yn'] == 'Y' ) {
    ?>
                        <tr bgcolor="fafafa">
                          <td align="right"><strong>����Ʈ</strong>&nbsp;</td>
                          <td class="text_01">&nbsp;&nbsp;
                            <?=$point?>
                            ����Ʈ
    <?
        $checked = ""; // ����
        if( $mexec == 'insert' || ( $mexec == 'update' && $point_open == 'Y') ) $checked = "checked"; // ����
    ?>
                            <input type="checkbox" name="point_open" value='Y' <?=$checked?>> ����
                            </td>
                        </tr>
                        <tr>
                          <td bgcolor="#FFFFFF" align="right" height="1" colspan="2" background="<?=$baseDir?>images/bg2.gif"></td>
                        </tr>
    <?
    }
    ?>
                      </table>
                      <br>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="right">
<?if ( $mexec == 'update' ) {?>
<?=$a_member_secession?><img src='<?=$baseDir?>images/button_secession.gif' border='0'></a>
                            <Input type="image" border="0" name="imageField" src="<?=$baseDir?>images/button_modify.gif" width="66" height="30">
<?} else {?>
                            <Input type="image" border="0" name="imageField" src="<?=$baseDir?>images/button_join.gif" width="66" height="30">
<?}?>
                            <!--a href='#' onClick='document.memberRegForm.reset();'><img src="<?=$baseDir?>images/button_cancel.gif" border='0'></a-->
                            <a href='#' onClick='self.close();return false;'><img src="<?=$baseDir?>images/button_close.gif" border='0'></a>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td background="<?=$baseDir?>images/join_bg03.gif">&nbsp;</td>
            </tr>
            <tr>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_03.gif" width="17" height="17"></td>
              <td background="<?=$baseDir?>images/join_bg04.gif"></td>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_04.gif" width="17" height="17"></td>
            </tr>
          </table>
          <br>
          <br>
          <br>
          <br>
        </td>
      </tr>
    </form>
    </table>
<?
    closeDBConnection (); // �����ͺ��̽� ���� ���� ����
    footer(); // Footer ���
} else {
    head('ȸ�� ���� ����');  // Header ���
    _css();
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
    MessageC ('P', '0012',"javascript:windowClose();:Ȯ��", $skinDir); // ȸ�� ���� ������ �������� �ʽ��ϴ�.
}
?>

