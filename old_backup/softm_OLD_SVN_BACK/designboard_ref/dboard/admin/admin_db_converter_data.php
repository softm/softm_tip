<?

$baseDir = '../';

include $baseDir . 'common/lib.inc'          ; // ���� ���̺귯��

include $baseDir . 'common/board_lib.inc'    ; // �Խ��� ���̺귯��
include $baseDir . 'common/poll_lib.inc'     ; // ���� ���̺귯��
include $baseDir . 'common/event_lib.inc'    ; // �̺�Ʈ ���̺귯��
include $baseDir . 'common/member_lib.inc'   ; // ��� ���̺귯��

include $baseDir . 'common/message.inc'      ; // ���� ������ ó��

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����

if ( $memInfor['admin_yn'] == "Y" ) {
set_time_limit ( 0 );

echo "<body onLoad=\"parent.readEnd();\" onClick='return false;' >\r\n";
//onContextMenu='return false;'
echo "<style type='text/css'>\n";
echo "<!--\n";
echo ".text_01 {font-family: '����';	font-size: 12px;	color: #333333;	text-decoration: none;}\n";
echo ".textarea_01 {BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: 1px solid; COLOR: 7E7E7E; BORDER-BOTTOM: 1px solid; BACKGROUND-COLOR: white}\n";
echo ".submit_01 {BORDER-RIGHT: 0px solid; BORDER-TOP: 0px solid; FONT-SIZE: 9pt; BORDER-LEFT: 0px solid; COLOR: white; BORDER-BOTTOM: 0px solid; HEIGHT: 19px; BACKGROUND-COLOR: black}\n";
echo ".listbox_01 {BORDER-RIGHT: 0px solid; BORDER-TOP: 0px solid; FONT-SIZE: 9pt; BORDER-LEFT: 0px solid; COLOR: 333333; BORDER-BOTTOM: 0px solid; HEIGHT: 19px; BACKGROUND-COLOR: EEEEEE}\n";
echo "-->\n";
echo "</style>\n";
    if ( $HTTP_POST_FILES['data_file'] ) {

        include ( $baseDir . 'common/file_upload.inc'  ); // ���� ���ε�
        include ( $baseDir . 'common/file.inc'         ); // ����

        $full_file1_name = $HTTP_POST_FILES['data_file'][name     ];
        $tmp_file1       = $HTTP_POST_FILES['data_file'][tmp_name ];
        $file_infor = explode(".","$full_file1_name");
        $file_name = $file_infor[0];                    // ���� ��
        $file_ext  = $file_infor[sizeof($file_infor)-1];// Ȯ�� ��
        $file1     = $file_name . '.' . $file_ext;

echo "<span id='convert_file' style=\"visibility:hidden;position:absolute\">$file_name</span>";

        if ( $kind_board == 'dboard' ) {

                if ( $kind_data == 'member' ) {
                    $f = fopen($tmp_file1,"r");
                    $file1_str = fread($f, filesize($tmp_file1));
                    fclose($f);
                    $field_order = '';
                    $data_order  = '';
                    $order_s_pos = strpos($file1_str, $tb_member . "_FIELD_ORDER_START##" ) + strlen( $tb_member . "_FIELD_ORDER_START##" ) + 2;
                    $order_e_pos = strpos($file1_str, $tb_member . "_FIELD_ORDER_END##"   );
//                  echo '<BR>'. $order_s_pos . ' / ' . $order_e_pos;
                    if ( $order_s_pos == $order_e_pos - 2 || $order_e_pos == false ) { // ȸ�� �ʵ� ���� ����
                        echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                        echo "<!--\r\n";
                        echo "    parent.st_fRead='3';\r\n";
                        echo "    parent.msgObj.innerHTML='ȸ�� �ʵ� ������ ���� ���� �ʽ��ϴ�.';\r\n";
                        echo "//-->\r\n";
                        echo "</SCRIPT>\r\n";
                        exit;
                    } else {
                        $field_order = substr ( $file1_str, $order_s_pos, $order_e_pos - $order_s_pos );
                        $field_order = explode( '��', $field_order ) ;
                        for ( $i=1;$i<sizeof($field_order)-1;$i++ ) {
                            if ( $field_order[$i] == 'user_id'              ) { $m_user_id_addr                   = $i-1; }
                            if ( $field_order[$i] == 'member_level'         ) { $m_member_level_addr              = $i-1; }
                            if ( $field_order[$i] == 'password'             ) { $m_password_addr                  = $i-1; }
                            if ( $field_order[$i] == 'name'                 ) { $m_name_addr                      = $i-1; }
                            if ( $field_order[$i] == 'sex'                  ) { $m_sex_addr                       = $i-1; }
                            if ( $field_order[$i] == 'e_mail'               ) { $m_e_mail_addr                    = $i-1; }
                            if ( $field_order[$i] == 'home'                 ) { $m_home_addr                      = $i-1; }
                            if ( $field_order[$i] == 'jumin'                ) { $m_jumin_addr                     = $i-1; }
                            if ( $field_order[$i] == 'tel'                  ) { $m_tel_addr                       = $i-1; }
                            if ( $field_order[$i] == 'address'              ) { $m_address_addr                   = $i-1; }
                            if ( $field_order[$i] == 'post_no'              ) { $m_post_no_addr                   = $i-1; }
                            if ( $field_order[$i] == 'member_st'            ) { $m_member_st_addr                 = $i-1; }
                            if ( $field_order[$i] == 'news_yn'              ) { $m_news_yn_addr                   = $i-1; }
                            if ( $field_order[$i] == 'point'                ) { $m_point_addr                     = $i-1; }
                            if ( $field_order[$i] == 'user_id_open'         ) { $m_user_id_open_addr              = $i-1; }
                            if ( $field_order[$i] == 'member_level_open'    ) { $m_member_level_open_addr         = $i-1; }
                            if ( $field_order[$i] == 'name_open'            ) { $m_name_open_addr                 = $i-1; }
                            if ( $field_order[$i] == 'sex_open'             ) { $m_sex_open_addr                  = $i-1; }
                            if ( $field_order[$i] == 'e_mail_open'          ) { $m_e_mail_open_addr               = $i-1; }
                            if ( $field_order[$i] == 'home_open'            ) { $m_home_open_addr                 = $i-1; }
                            if ( $field_order[$i] == 'tel_open'             ) { $m_tel_open_addr                  = $i-1; }
                            if ( $field_order[$i] == 'address_open'         ) { $m_address_open_addr              = $i-1; }
                            if ( $field_order[$i] == 'post_no_open'         ) { $m_post_no_open_addr              = $i-1; }
                            if ( $field_order[$i] == 'point_open'           ) { $m_point_open_addr                = $i-1; }
                            if ( $field_order[$i] == 'picture_image_open'   ) { $m_picture_image_open_addr        = $i-1; }
                            if ( $field_order[$i] == 'character_image_open' ) { $m_character_image_open_addr      = $i-1; }
                            if ( $field_order[$i] == 'reg_date'             ) { $m_reg_date_addr                  = $i-1; }
                            if ( $field_order[$i] == 'acc_date'             ) { $m_acc_date_addr                  = $i-1; }
                        }
                        $data_order  = $m_user_id_addr             . '@';
                        $data_order .= $m_member_level_addr        . '@';
                        $data_order .= $m_password_addr            . '@';
                        $data_order .= $m_name_addr                . '@';
                        $data_order .= $m_sex_addr                 . '@';
                        $data_order .= $m_e_mail_addr              . '@';
                        $data_order .= $m_home_addr                . '@';
                        $data_order .= $m_jumin_addr               . '@';
                        $data_order .= $m_tel_addr                 . '@';
                        $data_order .= $m_address_addr             . '@';
                        $data_order .= $m_post_no_addr             . '@';
                        $data_order .= $m_member_st_addr           . '@';
                        $data_order .= $m_news_yn_addr             . '@';
                        $data_order .= $m_point_addr               . '@';
                        $data_order .= $m_user_id_open_addr        . '@';
                        $data_order .= $m_member_level_open_addr   . '@';
                        $data_order .= $m_name_open_addr           . '@';
                        $data_order .= $m_sex_open_addr            . '@';
                        $data_order .= $m_e_mail_open_addr         . '@';
                        $data_order .= $m_home_open_addr           . '@';
                        $data_order .= $m_tel_open_addr            . '@';
                        $data_order .= $m_address_open_addr        . '@';
                        $data_order .= $m_post_no_open_addr        . '@';
                        $data_order .= $m_point_open_addr          . '@';
                        $data_order .= $m_picture_image_open_addr  . '@';
                        $data_order .= $m_character_image_open_addr. '@';
                        $data_order .= $m_reg_date_addr            . '@';
                        $data_order .= $m_acc_date_addr                 ;
                    }
                    echo "<span id='member_order' style=\"visibility:hidden;position:absolute\">$data_order</span>"; // �ʵ� ����

                    $field_order = '';
                    $data_order  = '';
                    $order_s_pos = strpos($file1_str, $tb_member_kind . "_FIELD_ORDER_START##" ) + strlen( $tb_member_kind . "_FIELD_ORDER_START##" ) + 2;
                    $order_e_pos = strpos($file1_str, $tb_member_kind . "_FIELD_ORDER_END##"   );

                    if ( $order_s_pos == $order_e_pos - 2 || $order_e_pos == false ) { // ȸ�� �ʵ� ���� ����
                        echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                        echo "<!--\r\n";
                        echo "    parent.st_fRead='3';\r\n";
                        echo "    parent.msgObj.innerHTML='ȸ�� ���� �ʵ� ������ ���� ���� �ʽ��ϴ�.';\r\n";
                        echo "//-->\r\n";
                        echo "</SCRIPT>\r\n";
                        exit;
                    } else {
                        $field_order = substr ( $file1_str, $order_s_pos, $order_e_pos - $order_s_pos );

                        $field_order = explode( '��', $field_order ) ;
                        for ( $i=1;$i<sizeof($field_order)-1;$i++ ) {
                            if ( $field_order[$i] == 'member_level') { $k_member_level_addr = $i-1; }
                            if ( $field_order[$i] == 'member_nm'   ) { $k_member_nm_addr    = $i-1; }
                            if ( $field_order[$i] == 'etc'         ) { $k_etc_addr          = $i-1; }
                            if ( $field_order[$i] == 'point'       ) { $k_point_addr        = $i-1; }
                            if ( $field_order[$i] == 'reg_date'    ) { $k_reg_date_addr     = $i-1; }
                        }
                        $data_order  = $k_member_level_addr. '@';
                        $data_order .= $k_member_nm_addr   . '@';
                        $data_order .= $k_etc_addr         . '@';
                        $data_order .= $k_point_addr       . '@';
                        $data_order .= $k_reg_date_addr     ;
                    }

                    echo "<span id='member_kind_order' style=\"visibility:hidden;position:absolute\">$data_order</span>"; // �ʵ� ����

                    $member_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_MEMBER_START##"     ) + 31;
                    $member_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_MEMBER_END##"       )     ;

                    $kind_s_pos     = strpos($file1_str, "##D'B'O'A'R'D'_MEMBER_KIND_START##") + 36;
                    $kind_e_pos     = strpos($file1_str, "##D'B'O'A'R'D'_MEMBER_KIND_END##"  )     ;

                    if ( $member_s_pos == $member_e_pos - 2 || $member_e_pos == false ) {
                        $member_str       = '';
                    } else {
                        $member_str     = substr ( $file1_str, $member_s_pos, $member_e_pos - $member_s_pos );
                    }
                    if ( $kind_s_pos == $kind_e_pos - 2 || $kind_e_pos == false ) {
                        $kind_str       = '';
                    } else {
                        $kind_str       = substr ( $file1_str, $kind_s_pos  , $kind_e_pos - $kind_s_pos );
                    }
                    $member_str = str_replace('�٦�', ""  , $member_str);
                    $kind_str   = str_replace('�צ�', ""  , $kind_str  );

                    $data_str   = $kind_str;
/*
                    echo "      <table width='100%' border='0' cellpadding='5' cellspacing='1' bgcolor='cccccc' class='text_01'>\n";
                        echo "    <tr align='center' bgcolor='eeeeee'>\n";
                        echo "      <td height='30'><strong>��ȣ</strong></td>\n";
                        echo "      <td ><strong>ȸ�� ���� </strong></td>\n";
                        echo "      <td ><strong>ȸ�� ���� �� </strong></td>\n";
                        echo "      <td ><strong>��� </strong></td>\n";
                        echo "      <td ><strong>���� ���� </strong></td>\n";
                        echo "    </tr>\n";
*/
                        $mp = true;
                        $cnt= 0   ;
                        while ( $mp != false ) {
                            $mp        = strpos ( $data_str , '�צ�'  );
                            $line      = substr ( $data_str , 0, $mp  );
                            $val       = explode( '�צ�'      , $line   );
                            $data_str  = substr ( $data_str , $mp  + 6); // ���⼭ 6 �� '�צ�'(4) + \r\n(2) ��
                            if ( sizeof( $val ) > 4 ) {
                            $cnt++;
/*
                            echo "  <tr>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$cnt.                "</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$k_member_level_addr]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$k_member_nm_addr   ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$k_etc_addr         ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$k_reg_date_addr    ]."</td>\n";
                            echo "  </tr>\n";
*/
                            }
                        }
//                    echo "</TABLE>";
                    echo "<span id='member_kind_tot' style=\"visibility:hidden;position:absolute\">$cnt</span>"; // �� �ڷ��
                    $kind_str = "##DATA_CNT_START##" . "\r\n" . $cnt . "\r\n" . "##DATA_CNT_END##" . "\r\n" . $kind_str;
                    f_writeFile('../data/'. $file_name . '_member_kind.sql', $kind_str   );

                    $data_str   = $member_str;
//                  echo"    <br>\n";
/*
                    echo "      <table width='100%' border='0' cellpadding='5' cellspacing='1' bgcolor='cccccc' class='text_01'>\n";
                        echo "    <tr align='center' bgcolor='eeeeee'>\n";
                        echo "      <td height='30'><strong>��ȣ</strong></td>\n";
                        echo "      <td ><strong>���̵�        </strong></td>\n";
                        echo "      <td ><strong>ȸ�� ����     </strong></td>\n";
                        echo "      <td ><strong>��й�ȣ      </strong></td>\n";
                        echo "      <td ><strong>�̸�          </strong></td>\n";
//                      echo "      <td ><strong>����          </strong></td>\n";
//                      echo "      <td ><strong>E-mail        </strong></td>\n";
//                      echo "      <td ><strong>Ȩ������ �ּ� </strong></td>\n";
//                      echo "      <td ><strong>��ȭ��ȣ1     </strong></td>\n";
//                      echo "      <td ><strong>�����ȣ      </strong></td>\n";
//                      echo "      <td ><strong>�ּ�          </strong></td>\n";
//                      echo "      <td ><strong>ȸ�� ����     </strong></td>\n";
//                      echo "      <td ><strong>���� ���� ����</strong></td>\n";
                        echo "      <td ><strong>���� ����     </strong></td>\n";
//                      echo "      <td ><strong>���� ����     </strong></td>\n";
                        echo "    </tr>\n";
*/
                        $mp = true;
                        $cnt= 0   ;
                        while ( $mp != false ) {
                            $mp        = strpos ( $data_str , '�٦�'  );
                            $line      = substr ( $data_str , 0, $mp  );
                            $val       = explode( '�٦�'      , $line   );
                            $data_str  = substr ( $data_str , $mp  + 6); // ���⼭ 6 �� '�٦�'(4) + \r\n(2) ��
                            if ( sizeof( $val ) > 15 ) {
                            $cnt++;
/*
                            echo "  <tr>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$cnt.                "</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_user_id_addr     ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_member_level_addr]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_password_addr    ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_name_addr        ]."</td>\n";
//                          echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_sex_addr         ]."</td>\n";
//                          echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_e_mail_addr      ]."</td>\n";
//                          echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_home_addr        ]."</td>\n";
//                          echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_tel_addr         ]."</td>\n";
//                          echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_post_no_addr     ]."</td>\n";
//                          echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_address_addr     ]."</td>\n";
//                          echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_member_st_addr   ]."</td>\n";
//                          echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_news_yn_addr     ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_reg_date_addr    ]."</td>\n";
//                          echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$m_acc_date_addr    ]."</td>\n";
                            echo "  </tr>\n";
*/
                            }
                        }
//                  echo "</TABLE>";

                    echo "<span id='member_tot' style=\"visibility:hidden;position:absolute\">$cnt</span>"; // �� �ڷ��

                    $member_str = "##DATA_CNT_START##" . "\r\n" . $cnt . "\r\n" . "##DATA_CNT_END##" . "\r\n" . $member_str;
                    f_writeFile('../data/'. $file_name . '_member.sql'     , $member_str );

                    echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                    echo "<!--\r\n";
                    echo "    parent.st_fRead='2';\r\n";
                    echo "    parent.msgObj.innerHTML='ȸ�� ��������� ��� �о� �鿴���ϴ�.';\r\n";
                    echo "//-->\r\n";
                    echo "</SCRIPT>\r\n";

                } else if ( $kind_data == 'board' ) {
/* �Խ��� */
                    $f = fopen($tmp_file1,"r");
                    $file1_str = fread($f, filesize($tmp_file1));
                    fclose($f);
                    $id          = '';
                    $field_order = '';
                    $data_order  = '';

                    $id_s_pos = strpos($file1_str, "##D'B'O'A'R'D'_ID_START##" ) + strlen( "##D'B'O'A'R'D'_ID_START##" ) + 2;
                    $id_e_pos = strpos($file1_str, "##D'B'O'A'R'D'_ID_END##"   );

                    if ( $id_s_pos == $id_e_pos - 2 || $id_e_pos == false ) { // ȸ�� �ʵ� ���� ����
                        echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                        echo "<!--\r\n";
                        echo "    parent.st_fRead='3';\r\n";
                        echo "    parent.msgObj.innerHTML='�Խ��� ���̵� ������ ���� ���� �ʽ��ϴ�.';\r\n";
                        echo "//-->\r\n";
                        echo "</SCRIPT>\r\n";
                        exit;
                    } else {
                        $id = substr ( $file1_str, $id_s_pos, $id_e_pos - $id_s_pos - 2);
                        echo "<span id='bbs_id' style=\"visibility:hidden;position:absolute\">$id</span>"; // �Խ��� ���̵�
                    }
/* �Խ��� ���� */
                    echo "##" . $tb_bbs_infor . "_FIELD_ORDER_START##";
                    $order_s_pos = strpos($file1_str, "##" . $tb_bbs_infor . "_FIELD_ORDER_START##" ) + strlen( "##" . $tb_bbs_infor . "_FIELD_ORDER_START##" ) + 2;
                    $order_e_pos = strpos($file1_str, "##" . $tb_bbs_infor . "_FIELD_ORDER_END##"   );

                    if ( $order_s_pos == $order_e_pos - 2 || $order_e_pos == false ) { // �Խ��� ���� ���̺� �ʵ� ���� ����
                        echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                        echo "<!--\r\n";
                        echo "    parent.st_fRead='3';\r\n";
                        echo "    parent.msgObj.innerHTML='�Խ��� ���� �ʵ� ������ ���� ���� �ʽ��ϴ�.';\r\n";
                        echo "//-->\r\n";
                        echo "</SCRIPT>\r\n";
                        exit;
                    } else {
                        $field_order = substr ( $file1_str, $order_s_pos, $order_e_pos - $order_s_pos );
                        $field_order = explode( '��', $field_order ) ;
                        for ( $i=1;$i<sizeof($field_order)-1;$i++ ) {
                            if ( $field_order[$i] == 'no'                       ) { $i_no_addr                      = $i-1; }
                            if ( $field_order[$i] == 'bbs_id'                   ) { $i_bbs_id_addr                  = $i-1; }
                            if ( $field_order[$i] == 'skin_no'                  ) { $i_skin_no_addr                 = $i-1; }
                            if ( $field_order[$i] == 'skin_name'                ) { $i_skin_name_addr               = $i-1; }
                            if ( $field_order[$i] == 'use_category'             ) { $i_use_category_addr            = $i-1; }
                            if ( $field_order[$i] == 'table_width_unit'         ) { $i_table_width_unit_addr        = $i-1; }
                            if ( $field_order[$i] == 'table_width'              ) { $i_table_width_addr             = $i-1; }
                            if ( $field_order[$i] == 'how_many'                 ) { $i_how_many_addr                = $i-1; }
                            if ( $field_order[$i] == 'more_many'                ) { $i_more_many_addr               = $i-1; }
                            if ( $field_order[$i] == 'page_many'                ) { $i_page_many_addr               = $i-1; }
                            if ( $field_order[$i] == 'title_limit'              ) { $i_title_limit_addr             = $i-1; }
                            if ( $field_order[$i] == 'max_capacity'             ) { $i_max_capacity_addr            = $i-1; }
                            if ( $field_order[$i] == 'mail_send_method'         ) { $i_mail_send_method_addr        = $i-1; }
                            if ( $field_order[$i] == 'display_list'             ) { $i_display_list_addr            = $i-1; }
                            if ( $field_order[$i] == 'display_write'            ) { $i_display_write_addr           = $i-1; }
                            if ( $field_order[$i] == 'display_view'             ) { $i_display_view_addr            = $i-1; }
                            if ( $field_order[$i] == 'header'                   ) { $i_header_addr                  = $i-1; }
                            if ( $field_order[$i] == 'footer'                   ) { $i_footer_addr                  = $i-1; }
                            if ( $field_order[$i] == 'base_path'                ) { $i_base_path_addr               = $i-1; }
                            if ( $field_order[$i] == 'operator_id'              ) { $i_operator_id_addr             = $i-1; }
                            if ( $field_order[$i] == 'grant_character_image'    ) { $i_grant_character_image_addr   = $i-1; }
                            if ( $field_order[$i] == 'reg_date'                 ) { $i_reg_date_addr                = $i-1; }
                            if ( $field_order[$i] == 'upd_date'                 ) { $i_upd_date_addr                = $i-1; }
                        }

                        $data_order   = $i_no_addr                   . '@';
                        $data_order  .= $i_bbs_id_addr               . '@';
                        $data_order  .= $i_skin_no_addr              . '@';
                        $data_order  .= $i_skin_name_addr            . '@';
                        $data_order  .= $i_use_category_addr         . '@';
                        $data_order  .= $i_table_width_unit_addr     . '@';
                        $data_order  .= $i_table_width_addr          . '@';
                        $data_order  .= $i_how_many_addr             . '@';
                        $data_order  .= $i_more_many_addr            . '@';
                        $data_order  .= $i_page_many_addr            . '@';
                        $data_order  .= $i_title_limit_addr          . '@';
                        $data_order  .= $i_max_capacity_addr         . '@';
                        $data_order  .= $i_mail_send_method_addr     . '@';
                        $data_order  .= $i_display_list_addr         . '@';
                        $data_order  .= $i_display_write_addr        . '@';
                        $data_order  .= $i_display_view_addr         . '@';
                        $data_order  .= $i_header_addr               . '@';
                        $data_order  .= $i_footer_addr               . '@';
                        $data_order  .= $i_base_path_addr            . '@';
                        $data_order  .= $i_operator_id_addr          . '@';
                        $data_order  .= $i_grant_character_image_addr. '@';
                        $data_order  .= $i_reg_date_addr             . '@';
                        $data_order  .= $i_upd_date_addr                  ;
                    }

                    echo "<span id='infor_order' style=\"visibility:hidden;position:absolute\">$data_order</span>"; // �ʵ� ����

                    $infor_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_INFOR_START##"     ) + 30;
                    $infor_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_INFOR_END##"       )     ;

                    if ( $infor_s_pos == $infor_e_pos - 2 || $infor_e_pos == false ) {
                        $infor_str       = '';
                    } else {
                        $infor_str     = substr ( $file1_str, $infor_s_pos, $infor_e_pos - $infor_s_pos );
                    }

                    $infor_str  = str_replace('�զ�', ""  , $infor_str);
                    $data_str   = $infor_str;
                        $mp = true;
                        $cnt= 0   ;
                        while ( $mp != false ) {
                            $mp        = strpos ( $data_str , '�զ�'  );
                            $line      = substr ( $data_str , 0, $mp  );
                            $val       = explode( '�զ�'      , $line   );
                            $data_str  = substr ( $data_str , $mp  + 6); // ���⼭ 6 �� '�զ�'(4) + \r\n(2) ��
                            if ( sizeof( $val ) > 4 ) {
                            $cnt++;
                            }
                        }
//                  echo "</table>";
                    echo "<span id='infor_tot' style=\"visibility:hidden;position:absolute\">$cnt</span>"; // �� �ڷ��
                    $infor_str = "##DATA_CNT_START##" . "\r\n" . $cnt . "\r\n" . "##DATA_CNT_END##" . "\r\n" . $infor_str;
                    f_writeFile('../data/'. $file_name . '_bbs_infor.sql', $infor_str   );

                    echo "##" . $tb_bbs_data . '_' . $id . "_FIELD_ORDER_START##";
                    $order_s_pos = strpos($file1_str, "##" . $tb_bbs_data . '_' . $id . "_FIELD_ORDER_START##" ) + strlen( "##" . $tb_bbs_data . '_' . $id . "_FIELD_ORDER_START##" ) + 2;
                    $order_e_pos = strpos($file1_str, "##" . $tb_bbs_data . '_' . $id . "_FIELD_ORDER_END##"   );

                    if ( $order_s_pos == $order_e_pos - 2 || $order_e_pos == false ) { // �Խ��� �ʵ� ���� ����
                        echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                        echo "<!--\r\n";
                        echo "    parent.st_fRead='3';\r\n";
                        echo "    parent.msgObj.innerHTML='�Խ��� �ʵ� ������ ���� ���� �ʽ��ϴ�.';\r\n";
                        echo "//-->\r\n";
                        echo "</SCRIPT>\r\n";
                        exit;
                    } else {
                        $field_order = substr ( $file1_str, $order_s_pos, $order_e_pos - $order_s_pos );
                        $field_order = explode( '��', $field_order ) ;
                        for ( $i=1;$i<sizeof($field_order)-1;$i++ ) {
                            if ( $field_order[$i] == 'no'               ) { $d_no_addr           = $i-1; }
                            if ( $field_order[$i] == 'cat_no'           ) { $d_cat_no_addr       = $i-1; }
                            if ( $field_order[$i] == 'g_no'             ) { $d_g_no_addr         = $i-1; }
                            if ( $field_order[$i] == 'depth'            ) { $d_depth_addr        = $i-1; }
                            if ( $field_order[$i] == 'o_seq'            ) { $d_o_seq_addr        = $i-1; }
                            if ( $field_order[$i] == 'pre_no'           ) { $d_pre_no_addr       = $i-1; }
                            if ( $field_order[$i] == 'next_no'          ) { $d_next_no_addr      = $i-1; }
                            if ( $field_order[$i] == 'member_level'     ) { $d_member_level_addr = $i-1; }
                            if ( $field_order[$i] == 'user_id'          ) { $d_user_id_addr      = $i-1; }
                            if ( $field_order[$i] == 'name'             ) { $d_name_addr         = $i-1; }
                            if ( $field_order[$i] == 'password'         ) { $d_password_addr     = $i-1; }
                            if ( $field_order[$i] == 'title'            ) { $d_title_addr        = $i-1; }
                            if ( $field_order[$i] == 'content'          ) { $d_content_addr      = $i-1; }
                            if ( $field_order[$i] == 'e_mail'           ) { $d_e_mail_addr       = $i-1; }
                            if ( $field_order[$i] == 'home'             ) { $d_home_addr         = $i-1; }
                            if ( $field_order[$i] == 'f_path1'          ) { $d_f_path1_addr      = $i-1; }
                            if ( $field_order[$i] == 'f_name1'          ) { $d_f_name1_addr      = $i-1; }
                            if ( $field_order[$i] == 'f_ext1'           ) { $d_f_ext1_addr       = $i-1; }
                            if ( $field_order[$i] == 'f_size1'          ) { $d_f_size1_addr      = $i-1; }
                            if ( $field_order[$i] == 'f_date1'          ) { $d_f_date1_addr      = $i-1; }
                            if ( $field_order[$i] == 'f_path2'          ) { $d_f_path2_addr      = $i-1; }
                            if ( $field_order[$i] == 'f_name2'          ) { $d_f_name2_addr      = $i-1; }
                            if ( $field_order[$i] == 'f_ext2'           ) { $d_f_ext2_addr       = $i-1; }
                            if ( $field_order[$i] == 'f_size2'          ) { $d_f_size2_addr      = $i-1; }
                            if ( $field_order[$i] == 'f_date2'          ) { $d_f_date2_addr      = $i-1; }
                            if ( $field_order[$i] == 'reg_date'         ) { $d_reg_date_addr     = $i-1; }
                            if ( $field_order[$i] == 'html_yn'          ) { $d_html_yn_addr      = $i-1; }
                            if ( $field_order[$i] == 'mail_yn'          ) { $d_mail_yn_addr      = $i-1; }
                            if ( $field_order[$i] == 'use_st'           ) { $d_use_st_addr       = $i-1; }
                            if ( $field_order[$i] == 'recom_hit'        ) { $d_recom_hit_addr    = $i-1; }
                            if ( $field_order[$i] == 'hit'              ) { $d_hit_addr          = $i-1; }
                            if ( $field_order[$i] == 'down_hit1'        ) { $d_down_hit1_addr    = $i-1; }
                            if ( $field_order[$i] == 'down_hit2'        ) { $d_down_hit2_addr    = $i-1; }
                            if ( $field_order[$i] == 'total_comment'    ) { $d_total_comment_addr= $i-1; }
                            if ( $field_order[$i] == 'comment_date'     ) { $d_comment_date_addr = $i-1; }
                            if ( $field_order[$i] == 'ip'               ) { $d_ip_addr           = $i-1; }
                        }
                        $data_order   = $d_no_addr           . '@';
                        $data_order  .= $d_cat_no_addr       . '@';
                        $data_order  .= $d_g_no_addr         . '@';
                        $data_order  .= $d_depth_addr        . '@';
                        $data_order  .= $d_o_seq_addr        . '@';
                        $data_order  .= $d_pre_no_addr       . '@';
                        $data_order  .= $d_next_no_addr      . '@';
                        $data_order  .= $d_member_level_addr . '@';
                        $data_order  .= $d_user_id_addr      . '@';
                        $data_order  .= $d_name_addr         . '@';
                        $data_order  .= $d_password_addr     . '@';
                        $data_order  .= $d_title_addr        . '@';
                        $data_order  .= $d_content_addr      . '@';
                        $data_order  .= $d_e_mail_addr       . '@';
                        $data_order  .= $d_home_addr         . '@';
                        $data_order  .= $d_f_path1_addr      . '@';
                        $data_order  .= $d_f_name1_addr      . '@';
                        $data_order  .= $d_f_ext1_addr       . '@';
                        $data_order  .= $d_f_size1_addr      . '@';
                        $data_order  .= $d_f_date1_addr      . '@';
                        $data_order  .= $d_f_path2_addr      . '@';
                        $data_order  .= $d_f_name2_addr      . '@';
                        $data_order  .= $d_f_ext2_addr       . '@';
                        $data_order  .= $d_f_size2_addr      . '@';
                        $data_order  .= $d_f_date2_addr      . '@';
                        $data_order  .= $d_reg_date_addr     . '@';
                        $data_order  .= $d_html_yn_addr      . '@';
                        $data_order  .= $d_mail_yn_addr      . '@';
                        $data_order  .= $d_use_st_addr       . '@';
                        $data_order  .= $d_recom_hit_addr    . '@';
                        $data_order  .= $d_hit_addr          . '@';
                        $data_order  .= $d_down_hit1_addr    . '@';
                        $data_order  .= $d_down_hit2_addr    . '@';
                        $data_order  .= $d_total_comment_addr. '@';
                        $data_order  .= $d_comment_date_addr . '@';
                        $data_order  .= $d_ip_addr                ;
                    }
                    echo "<span id='board_order' style=\"visibility:hidden;position:absolute\">$data_order</span>"; // �ʵ� ����

                    $board_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_DATA_START##"     ) + 33;
                    $board_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_DATA_END##"       )     ;

                    if ( $board_s_pos == $board_e_pos - 2 || $board_e_pos == false ) {
                        $board_str       = '';
                    } else {
                        $board_str     = substr ( $file1_str, $board_s_pos, $board_e_pos - $board_s_pos );
                    }

                    $board_str  = str_replace('�Ц�', ""  , $board_str);
                    $data_str   = $board_str;
/*
                    echo "      <table width='100%' border='0' cellpadding='5' cellspacing='1' bgcolor='cccccc' class='text_01'>\n";
                        echo "    <tr align='center' bgcolor='eeeeee'>\n";
                        echo "      <td width='30' height='30'><strong>��ȣ</strong></td>\n";
                        echo "      <td width='80'><strong>�Խù���ȣ </strong></td>\n";
                        echo "      <td><strong>���� </strong></td>\n";
                        echo "      <td width='100'><strong>���̵� </strong></td>\n";
                        echo "      <td width='70'><strong>�̸� </strong></td>\n";
                        echo "      <td width='200'> <strong> �̸���</strong></td>\n";
                        echo "    </tr>\n";
*/
                        $mp = true;
                        $cnt= 0   ;
                        while ( $mp != false ) {
                            $mp        = strpos ( $data_str , '�Ц�'  );
                            $line      = substr ( $data_str , 0, $mp  );
                            $val       = explode( '�Ц�'      , $line   );
                            $data_str  = substr ( $data_str , $mp  + 6); // ���⼭ 6 �� '�צ�'(4) + \r\n(2) ��
                            if ( sizeof( $val ) > 4 ) {
                            $cnt++;
/*
                            echo "  <tr>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$cnt.                       "</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$d_no_addr           ]."</td>\n";
                            echo "    <td bgcolor='#FFFFFF'               >".$val[$d_title_addr        ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$d_user_id_addr      ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$d_name_addr         ]."</td>\n";
                            echo "    <td bgcolor='#FFFFFF'               >".$val[$d_e_mail_addr       ]."</td>\n";
                            echo "  </tr>\n";
*/
                            }
                        }
//                  echo "</table>";
                    echo "<span id='board_tot' style=\"visibility:hidden;position:absolute\">$cnt</span>"; // �� �ڷ��
                    $board_str = "##DATA_CNT_START##" . "\r\n" . $cnt . "\r\n" . "##DATA_CNT_END##" . "\r\n" . $board_str;
                    f_writeFile('../data/'. $file_name . '_bbs_data.sql', $board_str   );

/* �Խ��� ī�װ� �� */
                    $order_s_pos = strpos($file1_str, "##" . $tb_bbs_category . '_' . $id . "_FIELD_ORDER_START##" ) + strlen( "##" . $tb_bbs_category . '_' . $id . "_FIELD_ORDER_START##" ) + 2;
                    $order_e_pos = strpos($file1_str, "##" . $tb_bbs_category . '_' . $id . "_FIELD_ORDER_END##"   );

                    if ( $order_s_pos == $order_e_pos - 2 || $order_e_pos == false ) { // �Խ��� ī�װ� �ʵ� ���� ����
                        echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                        echo "<!--\r\n";
                        echo "    parent.st_fRead='3';\r\n";
                        echo "    parent.msgObj.innerHTML='�Խ��� ī�װ� �ʵ� ������ ���� ���� �ʽ��ϴ�.';\r\n";
                        echo "//-->\r\n";
                        echo "</SCRIPT>\r\n";
                        exit;
                    } else {
                        $field_order = substr ( $file1_str, $order_s_pos, $order_e_pos - $order_s_pos );
                        $field_order = explode( '��', $field_order );
                        for ( $i=1;$i<sizeof($field_order)-1;$i++ ) {
                            if ( $field_order[$i] == 'no'    ) { $y_no_addr   = $i-1; }
                            if ( $field_order[$i] == 'o_seq' ) { $y_o_seq_addr= $i-1; }
                            if ( $field_order[$i] == 'name'  ) { $y_name_addr = $i-1; }
                            if ( $field_order[$i] == 'etc'   ) { $y_etc_addr  = $i-1; }
                        }
                        $data_order   = $y_no_addr     . '@';
                        $data_order  .= $y_o_seq_addr  . '@';
                        $data_order  .= $y_name_addr   . '@';
                        $data_order  .= $y_etc_addr         ;
                    }
                    echo "<span id='category_order' style=\"visibility:hidden;position:absolute\">$data_order</span>"; // �ʵ� ����

                    $category_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_CATEGORY_START##"     ) + 37;
                    $category_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_CATEGORY_END##"       )     ;

                    if ( $category_s_pos == $category_e_pos - 2 || $category_e_pos == false ) {
                        $category_str       = '';
                    } else {
                        $category_str     = substr ( $file1_str, $category_s_pos, $category_e_pos - $category_s_pos );
                    }

                    $category_str  = str_replace('�妢', ""  , $category_str);
                    $data_str   = $category_str;
//                  echo"    <br>\n";
/*
                    echo "      <table width='100%' border='0' cellpadding='5' cellspacing='1' bgcolor='cccccc' class='text_01'>\n";
                        echo "    <tr align='center' bgcolor='eeeeee'>\n";
                        echo "      <td align='center' height='30'><strong>��ȣ</strong></td>\n";
                        echo "      <td align='center'><strong>ī�װ� ��ȣ  </strong></td>\n";
                        echo "      <td align='center'><strong>���� ���� </strong></td>\n";
                        echo "      <td align='center'><strong>ī�װ� �� </strong></td>\n";
                        echo "      <td align='center'><strong>��� </strong></td>\n";
                        echo "    </tr>\n";
*/
                        $mp = true;
                        $cnt= 0   ;
                        while ( $mp != false ) {
                            $mp        = strpos ( $data_str , '���'  );
                            $line      = substr ( $data_str , 0, $mp  );
                            $val       = explode( '���'      , $line   );
                            $data_str  = substr ( $data_str , $mp  + 6); // ���⼭ 6 �� '���'(4) + \r\n(2) ��
                            if ( sizeof( $val ) > 4 ) {
                            $cnt++;
/*
                            echo "  <tr>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$cnt.                "</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$y_no_addr    ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$y_o_seq_addr ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$y_name_addr  ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$y_etc_addr   ]."</td>\n";
                            echo "  </tr>\n";
*/
                            }
                        }
//                  echo "</table>";
                    echo "<span id='category_tot' style=\"visibility:hidden;position:absolute\">$cnt</span>"; // �� �ڷ��
                    $category_str = "##DATA_CNT_START##" . "\r\n" . $cnt . "\r\n" . "##DATA_CNT_END##" . "\r\n" . $category_str;
                    f_writeFile('../data/'. $file_name . '_bbs_category.sql', $category_str   );

/* �Խ��� �ǰ߱� */
                    $order_s_pos = strpos($file1_str, "##" . $tb_bbs_comment . '_' . $id . "_FIELD_ORDER_START##" ) + strlen( "##" . $tb_bbs_comment . '_' . $id . "_FIELD_ORDER_START##" ) + 2;
                    $order_e_pos = strpos($file1_str, "##" . $tb_bbs_comment . '_' . $id . "_FIELD_ORDER_END##"   );

                    if ( $order_s_pos == $order_e_pos - 2 || $order_e_pos == false ) { // �Խ��� �ǰ߱� �ʵ� ���� ����
                        echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                        echo "<!--\r\n";
                        echo "    parent.st_fRead='3';\r\n";
                        echo "    parent.msgObj.innerHTML='�Խ��� �ǰ߱� �ʵ� ������ ���� ���� �ʽ��ϴ�.';\r\n";
                        echo "//-->\r\n";
                        echo "</SCRIPT>\r\n";
                        exit;
                    } else {
                        $field_order = substr ( $file1_str, $order_s_pos, $order_e_pos - $order_s_pos );
                        $field_order = explode( '��', $field_order );
                        for ( $i=1;$i<sizeof($field_order)-1;$i++ ) {
                            if ( $field_order[$i] == 'no'          ) { $c_no_addr      = $i-1; }
                            if ( $field_order[$i] == 'p_no'        ) { $c_p_no_addr    = $i-1; }
                            if ( $field_order[$i] == 'user_id'     ) { $c_user_id_addr = $i-1; }
                            if ( $field_order[$i] == 'name'        ) { $c_name_addr    = $i-1; }
                            if ( $field_order[$i] == 'password'    ) { $c_password_addr= $i-1; }
                            if ( $field_order[$i] == 'memo'        ) { $c_memo_addr    = $i-1; }
                            if ( $field_order[$i] == 'ip'          ) { $c_ip_addr      = $i-1; }
                            if ( $field_order[$i] == 'reg_date'    ) { $c_reg_date_addr= $i-1; }
                        }
                        $data_order   = $c_no_addr           . '@';
                        $data_order  .= $c_p_no_addr         . '@';
                        $data_order  .= $c_user_id_addr      . '@';
                        $data_order  .= $c_name_addr         . '@';
                        $data_order  .= $c_password_addr     . '@';
                        $data_order  .= $c_memo_addr         . '@';
                        $data_order  .= $c_ip_addr           . '@';
                        $data_order  .= $c_reg_date_addr          ;
                    }
                    echo "<span id='comment_order' style=\"visibility:hidden;position:absolute\">$data_order</span>"; // �ʵ� ����

                    $comment_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_COMMENT_START##"     ) + 36;
                    $comment_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_COMMENT_END##"       )     ;

                    if ( $comment_s_pos == $comment_e_pos - 2 || $comment_e_pos == false ) {
                        $comment_str       = '';
                    } else {
                        $comment_str     = substr ( $file1_str, $comment_s_pos, $comment_e_pos - $comment_s_pos );
                    }

                    $comment_str= str_replace('�Ϧ�', ""  , $comment_str);
                    $data_str   = $comment_str;
/*
//                  echo"    <br>\n";
                    echo "      <table width='100%' border='0' cellpadding='5' cellspacing='1' bgcolor='cccccc' class='text_01'>\n";
                        echo "    <tr align='center' bgcolor='eeeeee'>\n";
                        echo "      <td width='30' height='30'><strong>��ȣ</strong></td>\n";
                        echo "      <td width='80' ><strong>�Խù� ��ȣ </strong></td>\n";
                        echo "      <td width='80' ><strong>�Խù���ȣ </strong></td>\n";
                        echo "      <td width='100'><strong>���̵� </strong></td>\n";
                        echo "      <td width='70' ><strong>�̸� </strong></td>\n";
                        echo "      <td width='200'><strong>��й�ȣ</strong></td>\n";
                        echo "      <td            ><strong>IP �ּ�</strong></td>\n";
                        echo "      <td            ><strong>�ۼ�����</strong></td>\n";
                        echo "    </tr>\n";
*/
                        $mp = true;
                        $cnt= 0   ;
                        while ( $mp != false ) {
                            $mp        = strpos ( $data_str , '�Ϧ�'  );
                            $line      = substr ( $data_str , 0, $mp  );
                            $val       = explode( '�Ϧ�'      , $line   );
                            $data_str  = substr ( $data_str , $mp  + 6); // ���⼭ 6 �� '�צ�'(4) + \r\n(2) ��
                            if ( sizeof( $val ) > 4 ) {
                            $cnt++;
/*
                            echo "  <TR>";
                            echo "  <TD align='center' bgcolor='#FFFFFF'>".$cnt.                      "</TD>";
                            echo "  <TD align='center' bgcolor='#FFFFFF'>".$val[$c_no_addr          ]."</TD>";
                            echo "  <TD align='center' bgcolor='#FFFFFF'>".$val[$c_p_no_addr        ]."</TD>";
                            echo "  <TD align='center' bgcolor='#FFFFFF'>".$val[$c_user_id_addr     ]."</TD>";
                            echo "  <TD align='center' bgcolor='#FFFFFF'>".$val[$c_name_addr        ]."</TD>";
                            echo "  <TD align='center' bgcolor='#FFFFFF'>".$val[$c_password_addr    ]."</TD>";
//                          echo "  <TD align='center' bgcolor='#FFFFFF'>".$val[$c_memo_addr        ]."</TD>";
                            echo "  <TD align='center' bgcolor='#FFFFFF'>".$val[$c_ip_addr          ]."</TD>";
                            echo "  <TD align='center' bgcolor='#FFFFFF'>".$val[$c_reg_date_addr    ]."</TD>";
                            echo "  </TR>\n";
*/
                            }
                        }
//                  echo "</TABLE>";
                    echo "<span id='comment_tot' style=\"visibility:hidden;position:absolute\">$cnt</span>"; // �� �ڷ��
                    $comment_str = "##DATA_CNT_START##" . "\r\n" . $cnt . "\r\n" . "##DATA_CNT_END##" . "\r\n" . $comment_str;
                    f_writeFile('../data/'. $file_name . '_bbs_comment.sql', $comment_str   );

/* �Խ��� ���� */
                    $order_s_pos = strpos($file1_str, "##" . $tb_bbs_grant . "_FIELD_ORDER_START##" ) + strlen( "##" . $tb_bbs_grant . "_FIELD_ORDER_START##" ) + 2;
                    $order_e_pos = strpos($file1_str, "##" . $tb_bbs_grant . "_FIELD_ORDER_END##"   );

                    if ( $order_s_pos == $order_e_pos - 2 || $order_e_pos == false ) { // �Խ��� ���� �ʵ� ���� ����
                        echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                        echo "<!--\r\n";
                        echo "    parent.st_fRead='3';\r\n";
                        echo "    parent.msgObj.innerHTML='�Խ��� ���� �ʵ� ������ ���� ���� �ʽ��ϴ�.';\r\n";
                        echo "//-->\r\n";
                        echo "</SCRIPT>\r\n";
                        exit;
                    } else {
                        $field_order = substr ( $file1_str, $order_s_pos, $order_e_pos - $order_s_pos );
                        $field_order = explode( '��', $field_order );
                        for ( $i=1;$i<sizeof($field_order)-1;$i++ ) {
                            if ( $field_order[$i] == 'no'           ) { $g_no_addr           = $i-1; }
                            if ( $field_order[$i] == 'bbs_id'       ) { $g_bbs_id_addr       = $i-1; }
                            if ( $field_order[$i] == 'member_level' ) { $g_member_level_addr = $i-1; }
                            if ( $field_order[$i] == 'grant_list'   ) { $g_grant_list_addr   = $i-1; }
                            if ( $field_order[$i] == 'grant_view'   ) { $g_grant_view_addr   = $i-1; }
                            if ( $field_order[$i] == 'grant_write'  ) { $g_grant_write_addr  = $i-1; }
                            if ( $field_order[$i] == 'grant_answer' ) { $g_grant_answer_addr = $i-1; }
                            if ( $field_order[$i] == 'grant_comment') { $g_grant_comment_addr= $i-1; }
                            if ( $field_order[$i] == 'grant_down'   ) { $g_grant_down_addr   = $i-1; }
                        }
                        $data_order   = $g_no_addr            . '@';
                        $data_order  .= $g_bbs_id_addr        . '@';
                        $data_order  .= $g_member_level_addr  . '@';
                        $data_order  .= $g_grant_list_addr    . '@';
                        $data_order  .= $g_grant_view_addr    . '@';
                        $data_order  .= $g_grant_write_addr   . '@';
                        $data_order  .= $g_grant_answer_addr  . '@';
                        $data_order  .= $g_grant_comment_addr . '@';
                        $data_order  .= $g_grant_down_addr         ;
                    }
                    echo "<span id='grant_order' style=\"visibility:hidden;position:absolute\">$data_order</span>"; // �ʵ� ����

                    $grant_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_GRANT_START##"     ) + 34;
                    $grant_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_GRANT_END##"       )     ;

                    if ( $grant_s_pos == $grant_e_pos - 2 || $grant_e_pos == false ) {
                        $grant_str       = '';
                    } else {
                        $grant_str     = substr ( $file1_str, $grant_s_pos, $grant_e_pos - $grant_s_pos );
                    }

                    $grant_str  = str_replace('�Ӧ�', ""  , $grant_str);
                    $data_str   = $grant_str;
/*
//                  echo"    <br>\n";
                    echo "      <table width='100%' border='0' cellpadding='5' cellspacing='1' bgcolor='cccccc' class='text_01'>\n";
                        echo "    <tr align='center' bgcolor='eeeeee'>\n";
                        echo "      <td height='30'><strong>��ȣ</strong></td>\n";
                        echo "      <td><strong>�Խ��� ��ȣ </strong></td>\n";
                        echo "      <td><strong>�Խ��� ���̵� </strong></td>\n";
                        echo "      <td><strong>ȸ�� ���� </strong></td>\n";
                        echo "      <td><strong>�������� </strong></td>\n";
                        echo "      <td><strong> �б�����</strong></td>\n";
                        echo "      <td><strong> ��������</strong></td>\n";
                        echo "      <td><strong> �亯����</strong></td>\n";
                        echo "      <td><strong> �ǰ߱�����</strong></td>\n";
                        echo "      <td><strong> �ٿ�����</strong></td>\n";
                        echo "    </tr>\n";
*/
                        $mp = true;
                        $cnt= 0   ;
                        while ( $mp != false ) {
                            $mp        = strpos ( $data_str , '�Ӧ�'  );
                            $line      = substr ( $data_str , 0, $mp  );
                            $val       = explode( '�Ӧ�'      , $line   );
                            $data_str  = substr ( $data_str , $mp  + 6); // ���⼭ 6 �� '�צ�'(4) + \r\n(2) ��
                            if ( sizeof( $val ) > 4 ) {
                            $cnt++;
/*
                            echo "  <tr>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$cnt.                "</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$g_no_addr             ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$g_bbs_id_addr         ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$g_member_level_addr   ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$g_grant_list_addr     ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$g_grant_view_addr     ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$g_grant_write_addr    ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$g_grant_answer_addr   ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$g_grant_comment_addr  ]."</td>\n";
                            echo "    <td align='center' bgcolor='#FFFFFF'>".$val[$g_grant_down_addr     ]."</td>\n";
                            echo "  </tr>\n";
*/
                            }
                        }
//                  echo "</TABLE>";
                    echo "<span id='grant_tot' style=\"visibility:hidden;position:absolute\">$cnt</span>"; // �� �ڷ��
                    $grant_str = "##DATA_CNT_START##" . "\r\n" . $cnt . "\r\n" . "##DATA_CNT_END##" . "\r\n" . $grant_str;
                    f_writeFile('../data/'. $file_name . '_bbs_grant.sql', $grant_str   );

/* �Խ��� ����Ʈ ���� */
                    $order_s_pos = strpos($file1_str, "##" . $tb_point_infor . "_FIELD_ORDER_START##" ) + strlen( "##" . $tb_point_infor . "_FIELD_ORDER_START##" ) + 2;
                    $order_e_pos = strpos($file1_str, "##" . $tb_point_infor . "_FIELD_ORDER_END##"   );

                    if ( $order_s_pos == $order_e_pos - 2 || $order_e_pos == false ) { // �Խ��� ����Ʈ ���� �ʵ� ���� ����
                        echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                        echo "<!--\r\n";
                        echo "    parent.st_fRead='3';\r\n";
                        echo "    parent.msgObj.innerHTML='�Խ��� ����Ʈ ���� �ʵ� ������ ���� ���� �ʽ��ϴ�.';\r\n";
                        echo "//-->\r\n";
                        echo "</SCRIPT>\r\n";
                        exit;
                    } else {
                        $field_order = substr ( $file1_str, $order_s_pos, $order_e_pos - $order_s_pos );
                        $field_order = explode( '��', $field_order );
                        for ( $i=1;$i<sizeof($field_order)-1;$i++ ) {
                            if ( $field_order[$i] == 'no'           ) { $p_no_addr          = $i-1; }
                            if ( $field_order[$i] == 'bbs_id'       ) { $p_bbs_id_addr      = $i-1; }
                            if ( $field_order[$i] == 'member_level' ) { $p_member_level_addr= $i-1; }
                            if ( $field_order[$i] == 'use_st'       ) { $p_use_st_addr      = $i-1; }
                            if ( $field_order[$i] == 'point'        ) { $p_point_addr       = $i-1; }
                            if ( $field_order[$i] == 'etc'          ) { $p_etc_addr         = $i-1; }
                            if ( $field_order[$i] == 'reg_date'     ) { $p_reg_date_addr    = $i-1; }
                        }
                        $data_order   = $p_no_addr           . '@';
                        $data_order  .= $p_bbs_id_addr       . '@';
                        $data_order  .= $p_member_level_addr . '@';
                        $data_order  .= $p_use_st_addr       . '@';
                        $data_order  .= $p_point_addr        . '@';
                        $data_order  .= $p_etc_addr          . '@';
                        $data_order  .= $p_reg_date_addr		  ;
                    }
                    echo "<span id='point_order' style=\"visibility:hidden;position:absolute\">$data_order</span>"; // �ʵ� ����

                    $point_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_POINT_START##"     ) + 34;
                    $point_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_POINT_END##"       )     ;

                    if ( $point_s_pos == $point_e_pos - 2 || $point_e_pos == false ) {
                        $point_str       = '';
                    } else {
                        $point_str     = substr ( $file1_str, $point_s_pos, $point_e_pos - $point_s_pos );
                    }

                    $point_str  = str_replace('�ܦ�', ""  , $point_str);
                    $data_str   = $point_str;
                        $mp = true;
                        $cnt= 0   ;
                        while ( $mp != false ) {
                            $mp        = strpos ( $data_str , '�ܦ�'  );
                            $line      = substr ( $data_str , 0, $mp  );
                            $val       = explode( '�ܦ�'      , $line   );
                            $data_str  = substr ( $data_str , $mp  + 6); // ���⼭ 6 �� '�ܦ�'(4) + \r\n(2) ��
                            if ( sizeof( $val ) > 4 ) {
                            $cnt++;
                            }
                        }
//                  echo "</TABLE>";
                    echo "<span id='point_tot' style=\"visibility:hidden;position:absolute\">$cnt</span>"; // �� �ڷ��
                    $point_str = "##DATA_CNT_START##" . "\r\n" . $cnt . "\r\n" . "##DATA_CNT_END##" . "\r\n" . $point_str;
                    f_writeFile('../data/'. $file_name . '_bbs_point.sql', $point_str   );

/* �Խ��� ��� */
                    $header_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_HEADER_START##"     ) + 35;
                    $header_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_HEADER_END##"       )     ;
                    if ( $header_s_pos == $header_e_pos - 2 || $header_e_pos == false ) {
                        $header_str     = '';
                    } else {
                        $header_str     = substr ( $file1_str, $header_s_pos, $header_e_pos - $header_s_pos );
                    }
//
                    f_writeFile('../data/'. $file_name . "_dboard_header_"  . $id . ".php", $header_str   );

/* �Խ��� ǲ�� */
                    $footer_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_FOOTER_START##"     ) + 35;
                    $footer_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_FOOTER_END##"       )     ;
                    if ( $footer_s_pos == $footer_e_pos - 2 || $footer_e_pos == false ) {
                        $footer_str       = '';
                    } else {
                        $footer_str     = substr ( $file1_str, $footer_s_pos, $footer_e_pos - $footer_s_pos );
                    }
//
                    f_writeFile('../data/'. $file_name . "_dboard_footer_"  . $id . ".php", $footer_str   );

/* �Խ��� ���� ��� */
                    $notice_header_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_NOTICE_HEADER_START##"     ) + 42;
                    $notice_header_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_NOTICE_HEADER_END##"       )     ;

                    if ( $notice_header_s_pos == $notice_header_e_pos - 2 || $notice_header_e_pos == false ) {
                        $notice_header_str       = '';
                    } else {
                        $notice_header_str     = substr ( $file1_str, $notice_header_s_pos, $notice_header_e_pos - $notice_header_s_pos );
                    }
//
                    f_writeFile('../data/'. $file_name . "_dboard_notice_header_"  . $id . ".php", $notice_header_str   );

/* �Խ��� ���� ǲ�� */
                    $notice_footer_s_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_NOTICE_FOOTER_START##"     ) + 42;
                    $notice_footer_e_pos   = strpos($file1_str, "##D'B'O'A'R'D'_BBS_NOTICE_FOOTER_END##"       )     ;
                    if ( $notice_footer_s_pos == $notice_footer_e_pos - 2 || $notice_footer_e_pos == false ) {
                        $notice_footer_str       = '';
                    } else {
                        $notice_footer_str     = substr ( $file1_str, $notice_footer_s_pos, $notice_footer_e_pos - $notice_footer_s_pos );
                    }

//
                    f_writeFile('../data/'. $file_name . "_dboard_notice_footer_"  . $id . ".php", $notice_footer_str   );
//                  echo"    <br>\n";


                    echo "\r\n<SCRIPT LANGUAGE='JavaScript'>\r\n";
                    echo "<!--\r\n";
                    echo "    parent.st_fRead='2';\r\n";
                    echo "    parent.msgObj.innerHTML='�Խ��� ��������� ��� �о� �鿴���ϴ�.';\r\n";
                    echo "//-->\r\n";
                    echo "</SCRIPT>\r\n";
                }

        } else if ( $kind_board == 'zboard' ) {

        }
    }
}
?>
