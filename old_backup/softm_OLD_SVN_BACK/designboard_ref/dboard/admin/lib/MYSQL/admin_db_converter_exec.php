<?
$baseDir = '../../../';
include $baseDir . 'common/lib.inc'          ; // 공통 라이브러리

include $baseDir . 'common/board_lib.inc'    ; // 게시판 라이브러리
include $baseDir . 'common/poll_lib.inc'     ; // 설문 라이브러리
include $baseDir . 'common/event_lib.inc'    ; // 이벤트 라이브러리
include $baseDir . 'common/member_lib.inc'   ; // 멤버 라이브러리

include $baseDir . 'common/message.inc'      ; // 에러 페이지 처리

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

if ( $memInfor['admin_yn'] == "Y" ) {
set_time_limit ( 0 );

include ( '../../../common/db_connect.inc'   ); // Data Base 연결 클래스
include ( '../../../common/_service.inc'     ); // 서비스 화면 관련
include ( '../../../common/file.inc'         ); // 파일 관련
echo "<body onLoad=\"parent.dataConverEnd();\" onClick='return false;'>";
// onContextMenu='return false;'
$db = initDBConnection ();             // 데이터베이스 접속
$tot_progress= 0   ;
if ( $c_file ) {
    if ( $kind_data == 'member' ) {

        if( file_exists('../../../data/'. $c_file . '_member.sql') ) {
            $f = file ('../../../data/'. $c_file . '_member.sql');
            $member_order = explode( '@', $member_order ) ;
            $user_id_addr             = $member_order[0 ];
            $member_level_addr        = $member_order[1 ];
            $password_addr            = $member_order[2 ];
            $name_addr                = $member_order[3 ];
            $sex_addr                 = $member_order[4 ];
            $e_mail_addr              = $member_order[5 ];
            $home_addr                = $member_order[6 ];
            $jumin_addr               = $member_order[7 ];
            $tel_addr                 = $member_order[8 ];
            $address_addr             = $member_order[9 ];
            $post_no_addr             = $member_order[10];
            $member_st_addr           = $member_order[11];
            $news_yn_addr             = $member_order[12];
            $point_addr               = $member_order[13];
            $user_id_open_addr        = $member_order[14];
            $member_level_open_addr   = $member_order[15];
            $name_open_addr           = $member_order[16];
            $sex_open_addr            = $member_order[17];
            $e_mail_open_addr         = $member_order[18];
            $home_open_addr           = $member_order[19];
            $tel_open_addr            = $member_order[20];
            $address_open_addr        = $member_order[21];
            $post_no_open_addr        = $member_order[22];
            $point_open_addr          = $member_order[23];
            $picture_image_open_addr  = $member_order[24];
            $character_image_open_addr= $member_order[25];
            $reg_date_addr            = $member_order[26];
            $acc_date_addr            = $member_order[27];

            $sql  = "insert into $tb_member ( ";
            $sql .= "    user_id             ,member_level        ,password            ,name                ,";
            $sql .= "    sex                 ,e_mail              ,home                ,jumin               ,";
            $sql .= "    tel                 ,address             ,post_no             ,member_st           ,";
            $sql .= "    news_yn             ,point               ,user_id_open        ,member_level_open   ,";
            $sql .= "    name_open           ,sex_open            ,e_mail_open         ,home_open           ,";
            $sql .= "    tel_open            ,address_open        ,post_no_open        ,point_open          ,";
            $sql .= "    picture_image_open  ,character_image_open,reg_date            ,acc_date             ";
            $sql .= "    ) values ( ";
            $cnt = 0;
            while (list ($line_num, $line) = each ($f)) {
                if ( $line_num > 2 ) {
                    $tot_progress++;
                    $cnt++;
                    $val = explode( 'ⓜ┟', $line ) ;
                    $tmp_sql  = "'" . $val [$user_id_addr             ] . "',";
                    $tmp_sql .= "'" . $val [$member_level_addr        ] . "',";
                    $tmp_sql .= "'" . $val [$password_addr            ] . "',";
                    $tmp_sql .= "'" . $val [$name_addr                ] . "',";
                    $tmp_sql .= "'" . $val [$sex_addr                 ] . "',";
                    $tmp_sql .= "'" . $val [$e_mail_addr              ] . "',";
                    $tmp_sql .= "'" . $val [$home_addr                ] . "',";
                    $tmp_sql .= "'" . $val [$jumin_addr               ] . "',";
                    $tmp_sql .= "'" . $val [$tel_addr                 ] . "',";
                    $tmp_sql .= "'" . $val [$address_addr             ] . "',";
                    $tmp_sql .= "'" . $val [$post_no_addr             ] . "',";
                    $tmp_sql .= "'" . $val [$member_st_addr           ] . "',";
                    $tmp_sql .= "'" . $val [$news_yn_addr             ] . "',";
                    $tmp_sql .= "'" . $val [$point_addr               ] . "',";
                    $tmp_sql .= "'" . $val [$user_id_open_addr        ] . "',";
                    $tmp_sql .= "'" . $val [$member_level_open_addr   ] . "',";
                    $tmp_sql .= "'" . $val [$name_open_addr           ] . "',";
                    $tmp_sql .= "'" . $val [$sex_open_addr            ] . "',";
                    $tmp_sql .= "'" . $val [$e_mail_open_addr         ] . "',";
                    $tmp_sql .= "'" . $val [$home_open_addr           ] . "',";
                    $tmp_sql .= "'" . $val [$tel_open_addr            ] . "',";
                    $tmp_sql .= "'" . $val [$address_open_addr        ] . "',";
                    $tmp_sql .= "'" . $val [$post_no_open_addr        ] . "',";
                    $tmp_sql .= "'" . $val [$point_open_addr          ] . "',";
                    $tmp_sql .= "'" . $val [$picture_image_open_addr  ] . "',";
                    $tmp_sql .= "'" . $val [$character_image_open_addr] . "',";
                    $tmp_sql .= "'" . $val [$reg_date_addr            ] . "',";
                    $tmp_sql .= "'" . $val [$acc_date_addr            ] . "');" ;
        //          logs ( '$sql : '. $sql . $tmp_sql . '<BR>' , true);
                    @mysql_query($sql. $tmp_sql);
                    echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                    echo "<!--\r\n";
                    echo "    parent.progress('member',$tot_progress,$cnt);\r\n";
                    echo "//-->\r\n";
                    echo "</SCRIPT>\r\n";
                }
            }
        }

        if( file_exists('../../../data/'. $c_file . '_member_kind.sql') ) {
            $f = file ('../../../data/'. $c_file  . '_member_kind.sql');
            $member_kind_order = explode( '@', $member_kind_order ) ;
            $member_level_addr = $member_kind_order[0 ];
            $member_nm_addr    = $member_kind_order[1 ];
            $etc_addr          = $member_kind_order[2 ];
            $point_addr        = $member_kind_order[3 ];
            $reg_date_addr     = $member_kind_order[4 ];

            $sql  = "insert into $tb_member_kind ";
            $sql .= "( member_level, member_nm, etc, point, reg_date ) ";
            $sql .= " values ( ";
            $cnt = 0;
            while (list ($line_num, $line) = each ($f)) {
                if ( $line_num > 2 ) {
                    $tot_progress++;
                    $cnt++;
                    $val = explode( 'ⓚ┟', $line ) ;
                    $tmp_sql  = "'" . $val [$member_level_addr] . "',";
                    $tmp_sql .= "'" . $val [$member_nm_addr   ] . "',";
                    $tmp_sql .= "'" . $val [$etc_addr         ] . "',";
                    $tmp_sql .= "'" . $val [$point_addr       ] . "',";
                    $tmp_sql .= "'" . $val [$reg_date_addr    ] . "');" ;
    //                logs ( '$sql : '. $sql . $tmp_sql . '<BR>' , true);
                    @mysql_query($sql. $tmp_sql);
                    echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                    echo "<!--\r\n";
                    echo "    parent.progress('member_kind', $tot_progress, $cnt);\r\n";
                    echo "//-->\r\n";
                    echo "</SCRIPT>\r\n";
                }
            }
        }
        f_unlink('../../../data/'. $c_file . '_member.sql');
        f_unlink('../../../data/'. $c_file . '_member_kind.sql');
    } else if ( $kind_data == 'board' ) {
        echo '$bbs_id : ' . $bbs_id . '<BR>';
        include ( "../../../schema.sql"               ); // 스키마
        if( file_exists('../../../data/'. $c_file . '_bbs_data.sql') ) {
            if ( $bbs_id ) {
                $filePath = "../../../data/file/" . $bbs_id;
                if ( !@is_dir( $filePath ) ) { 
                    @mkdir($filePath,0707);
                    @chmod($filePath,0707);
                }
                $newNo = simpleSQLQuery("select no from $tb_bbs_infor where bbs_id = '$bbs_id'");
                echo '$newNo : ' . $newNo . '<BR>';
                if ( !$newNo ) {
                    $newNo = simpleSQLQuery("select MAX(no) + 1 from $tb_bbs_infor");
                    if ( !$newNo ) $newNo = 1;
                    $infor_order = explode( '@', $infor_order ) ;
                    $i_no_addr                           = $infor_order[0 ];
                    $i_bbs_id_addr                       = $infor_order[1 ];
                    $i_skin_no_addr                      = $infor_order[2 ];
                    $i_skin_name_addr                    = $infor_order[3 ];
                    $i_use_category_addr                 = $infor_order[4 ];
                    $i_table_width_unit_addr             = $infor_order[5 ];
                    $i_table_width_addr                  = $infor_order[6 ];
                    $i_how_many_addr                     = $infor_order[7 ];
                    $i_more_many_addr                    = $infor_order[8 ];
                    $i_page_many_addr                    = $infor_order[9 ];
                    $i_title_limit_addr                  = $infor_order[10];
                    $i_max_capacity_addr                 = $infor_order[11];
                    $i_mail_send_method_addr             = $infor_order[12];
                    $i_display_list_addr                 = $infor_order[13];
                    $i_display_write_addr                = $infor_order[14];
                    $i_display_view_addr                 = $infor_order[15];
                    $i_header_addr                       = $infor_order[16];
                    $i_footer_addr                       = $infor_order[17];
                    $i_base_path_addr                    = $infor_order[18];
                    $i_operator_id_addr                  = $infor_order[19];
                    $i_grant_character_image_addr        = $infor_order[20];
                    $i_reg_date_addr                     = $infor_order[21];
                    $i_upd_date_addr                     = $infor_order[22];

                    $f = fopen('../../../data/'. $c_file  . '_bbs_infor.sql',"r");
                    $file1_str = fread($f, filesize('../../../data/'. $c_file  . '_bbs_infor.sql'));
                    $data_str = $file1_str;
                    fclose($f);
                    f_unlink('../../../data/'. $c_file  . '_bbs_infor.sql');

                    $cnt_s_pos   = strpos($data_str, '##DATA_CNT_START##'     ) + 20;
                    $cnt_e_pos   = strpos($data_str, '##DATA_CNT_END##'       )     ;

                    if ( $cnt_s_pos == $cnt_e_pos ) {
                        $cnt_str    = '';
                    } else {
                        $cnt_str    = substr ( $data_str, $cnt_s_pos, $cnt_e_pos - $cnt_s_pos );
                    }
                    echo $cnt_str . '<BR>';
                    echo $cnt_s_pos . ' / ' . $cnt_e_pos;
                    if ( $cnt_s_pos == $cnt_e_pos || $cnt_e_pos == false ) {
                        echo "\r\n<SCRIPT LANGUAGE='JavaScript'>\r\n";
                        echo "<!--\r\n";
                        echo "    parent.st_fRead='6';\r\n";
                        echo "    parent.msgObj.innerHTML='게시판 백업 파일이 유효하지 않습니다.';\r\n";
                        echo "//-->\r\n";
                        echo "</SCRIPT>\r\n";
                        exit;
                    } else {
                        $data_str    = substr ( $data_str, $cnt_e_pos + 18 );
                    }

                    $mp        = strpos ( $data_str , 'ⓘ┩'  );
                    $line      = substr ( $data_str , 0, $mp  );
                    $val       = explode( 'ⓘ┟'      , $line );
                    $data_str  = substr ( $data_str , $mp  + 6); // 여기서 6 는 'ⓚ┩'(4) + \r\n(2) 값
                    // 게시판 설정 입력
                    if ( sizeof( $val ) > 4 ) {
                        $sql  = "insert into $tb_bbs_infor ( ";
                        $sql .= "no                   ,bbs_id               ,skin_no              ,";
                        $sql .= "skin_name            ,use_category         ,table_width_unit     ,";
                        $sql .= "table_width          ,how_many             ,more_many            ,";
                        $sql .= "page_many            ,title_limit          ,max_capacity         ,";
                        $sql .= "mail_send_method     ,display_list         ,display_write        ,";
                        $sql .= "display_view         ,header               ,footer               ,";
                        $sql .= "base_path            ,operator_id          ,grant_character_image,";
                        $sql .= "reg_date             ,upd_date                                    ";
                        $sql .= ") values ( ";
                        $sql .= "'" . $newNo                                . "',";
                        $sql .= "'" . $val [$i_bbs_id_addr                ] . "',";
                        $sql .= "'" . $val [$i_skin_no_addr               ] . "',";
                        $sql .= "'" . $val [$i_skin_name_addr             ] . "',";
                        $sql .= "'" . $val [$i_use_category_addr          ] . "',";
                        $sql .= "'" . $val [$i_table_width_unit_addr      ] . "',";
                        $sql .= "'" . $val [$i_table_width_addr           ] . "',";
                        $sql .= "'" . $val [$i_how_many_addr              ] . "',";
                        $sql .= "'" . $val [$i_more_many_addr             ] . "',";
                        $sql .= "'" . $val [$i_page_many_addr             ] . "',";
                        $sql .= "'" . $val [$i_title_limit_addr           ] . "',";
                        $sql .= "'" . $val [$i_max_capacity_addr          ] . "',";
                        $sql .= "'" . $val [$i_mail_send_method_addr      ] . "',";
                        $sql .= "'" . $val [$i_display_list_addr          ] . "',";
                        $sql .= "'" . $val [$i_display_write_addr         ] . "',";
                        $sql .= "'" . $val [$i_display_view_addr          ] . "',";
                        $sql .= "'" . $val [$i_header_addr                ] . "',";
                        $sql .= "'" . $val [$i_footer_addr                ] . "',";
                        $sql .= "'" . $val [$i_base_path_addr             ] . "',";
                        $sql .= "'" . $val [$i_operator_id_addr           ] . "',";
                        $sql .= "'" . $val [$i_grant_character_image_addr ] . "',";
                        $sql .= "'" . $val [$i_reg_date_addr              ] . "',";
                        $sql .= "'" . $val [$i_upd_date_addr              ] . "' );";
                        simpleSQLExecute($sql);
                    }

                    /* 게시물 추출 정보     */
                    $sql  = "insert into $tb_bbs_abstract ( no, bbs_id, skin_no, skin_name, reg_date ) values ";
                    $sql .= "($newNo, '$bbs_id', 0, 'dnotice_list_2_0', " . getYearToSecond() . ");";
                    simpleSQLExecute($sql);

                    if ( !isTable($tb_bbs_data   . '_' . $bbs_id) ) { /* 게시판 */
                        simpleSQLExecute($tb_bbs_data_schm);
                    }

                    if ( !isTable($tb_bbs_comment   . '_' . $bbs_id) ) { /* 의견글 */
                        simpleSQLExecute($tb_bbs_comment_schm);
                    }

                    if ( !isTable($tb_bbs_category   . '_' . $bbs_id) ) { /* 게시판 카테고리 */
                        simpleSQLExecute($tb_bbs_category_schm);
                    }

                } else {
                }

                if ( !file_exists("../../../data/html/_dboard_header_"  . $bbs_id . ".php") ) {
                    f_writeFile ("../../../data/html/_dboard_header_"  . $bbs_id . ".php", '');
                }
                if ( !file_exists("../../../data/html/_dboard_footer_"  . $bbs_id . ".php") ) {
                    f_writeFile ("../../../data/html/_dboard_footer_"  . $bbs_id . ".php", '');
                }
                if ( !file_exists("../../../data/html/_dnotice_header_"  . $bbs_id . ".php") ) {
                    f_writeFile ("../../../data/html/_dnotice_header_" . $bbs_id . ".php", '');
                }
                if ( !file_exists("../../../data/html/_dnotice_footer_"  . $bbs_id . ".php") ) {
                    f_writeFile ("../../../data/html/_dnotice_footer_" . $bbs_id . ".php", '');
                }
            }

            $board_order = explode( '@', $board_order ) ;
                                                 
            $d_no_addr            = $board_order[0 ];
            $d_cat_no_addr        = $board_order[1 ];
            $d_g_no_addr          = $board_order[2 ];
            $d_depth_addr         = $board_order[3 ];
            $d_o_seq_addr         = $board_order[4 ];
            $d_pre_no_addr        = $board_order[5 ];
            $d_next_no_addr       = $board_order[6 ];
            $d_member_level_addr  = $board_order[7 ];
            $d_user_id_addr       = $board_order[8 ];
            $d_name_addr          = $board_order[9 ];
            $d_password_addr      = $board_order[10];
            $d_title_addr         = $board_order[11];
            $d_content_addr       = $board_order[12];
            $d_e_mail_addr        = $board_order[13];
            $d_home_addr          = $board_order[14];
            $d_f_path1_addr       = $board_order[15];
            $d_f_name1_addr       = $board_order[16];
            $d_f_ext1_addr        = $board_order[17];
            $d_f_size1_addr       = $board_order[18];
            $d_f_date1_addr       = $board_order[19];
            $d_f_path2_addr       = $board_order[20];
            $d_f_name2_addr       = $board_order[21];
            $d_f_ext2_addr        = $board_order[22];
            $d_f_size2_addr       = $board_order[23];
            $d_f_date2_addr       = $board_order[24];
            $d_reg_date_addr      = $board_order[25];
            $d_html_yn_addr       = $board_order[26];
            $d_mail_yn_addr       = $board_order[27];
            $d_use_st_addr        = $board_order[28];
            $d_recom_hit_addr     = $board_order[29];
            $d_hit_addr           = $board_order[30];
            $d_down_hit1_addr     = $board_order[31];
            $d_down_hit2_addr     = $board_order[32];
            $d_total_comment_addr = $board_order[33];
            $d_comment_date_addr  = $board_order[34];
            $d_ip_addr            = $board_order[35];

            $sql  = "insert into " . $tb_bbs_data   . '_' . $bbs_id . " ( ";
            $sql .= "no           ,cat_no       ,g_no         ,depth        ,o_seq        ,pre_no       ,";
            $sql .= "next_no      ,member_level ,";
            $sql .= "user_id      ,name         ,password     ,title        ,content      ,";
            $sql .= "e_mail       ,home         ,f_path1      ,f_name1      ,f_ext1       ,f_size1      ,";
            $sql .= "f_date1      ,f_path2      ,f_name2      ,f_ext2       ,f_size2      ,f_date2      ,";
            $sql .= "reg_date     ,html_yn      ,mail_yn      ,use_st       ,recom_hit    ,hit          ,";
            $sql .= "down_hit1    ,down_hit2    ,total_comment,comment_date ,ip                          ";
            $sql .= " ) values ( ";

            $f = fopen('../../../data/'. $c_file  . '_bbs_data.sql',"r");
            $file1_str = fread($f, filesize('../../../data/'. $c_file  . '_bbs_data.sql'));
            $data_str = $file1_str;
            fclose($f);
            f_unlink('../../../data/'. $c_file  . '_bbs_data.sql');

            $cnt_s_pos   = strpos($data_str, '##DATA_CNT_START##'     ) + 20;
            $cnt_e_pos   = strpos($data_str, '##DATA_CNT_END##'       )     ;

            if ( $cnt_s_pos == $cnt_e_pos ) {
                $cnt_str    = '';
            } else {
                $cnt_str    = substr ( $data_str, $cnt_s_pos, $cnt_e_pos - $cnt_s_pos );
            }
            echo $cnt_str . '<BR>';
            echo $cnt_s_pos . ' / ' . $cnt_e_pos;
            if ( $cnt_s_pos == $cnt_e_pos || $cnt_e_pos == false ) { // 게시물 조회수 정보
                echo "\r\n<SCRIPT LANGUAGE='JavaScript'>\r\n";
                echo "<!--\r\n";
                echo "    parent.st_fRead='6';\r\n";
                echo "    parent.msgObj.innerHTML='게시판 백업 파일이 유효하지 않습니다.';\r\n";
                echo "//-->\r\n";
                echo "</SCRIPT>\r\n";
                exit;
            } else {
                $data_str    = substr ( $data_str, $cnt_e_pos + 18 );
            }

            $mp = true;
            $cnt         = 0   ;
            while ( $mp != false ) {
                $mp        = strpos ( $data_str , 'ⓓ┩'  );
                $line      = substr ( $data_str , 0, $mp  );
                $val       = explode( 'ⓓ┟'      , $line );
                $data_str  = substr ( $data_str , $mp  + 6); // 여기서 6 는 'ⓚ┩'(4) + \r\n(2) 값
                if ( sizeof( $val ) > 4 ) {
                    $tot_progress++;
                    $cnt++;
                    $tmp_sql  = "'" . $val [$d_no_addr           ] . "',";
                    $tmp_sql .= "'" . $val [$d_cat_no_addr       ] . "',";
                    $tmp_sql .= "'" . $val [$d_g_no_addr         ] . "',";
                    $tmp_sql .= "'" . $val [$d_depth_addr        ] . "',";
                    $tmp_sql .= "'" . $val [$d_o_seq_addr        ] . "',";
                    $tmp_sql .= "'" . $val [$d_pre_no_addr       ] . "',";
                    $tmp_sql .= "'" . $val [$d_next_no_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_member_level_addr ] . "',";
                    $tmp_sql .= "'" . $val [$d_user_id_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_name_addr         ] . "',";
                    $tmp_sql .= "'" . $val [$d_password_addr     ] . "',";
                    $tmp_sql .= "'" . $val [$d_title_addr        ] . "',";
                    $tmp_sql .= "'" . $val [$d_content_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_e_mail_addr       ] . "',";
                    $tmp_sql .= "'" . $val [$d_home_addr         ] . "',";
                    $tmp_sql .= "'" . $val [$d_f_path1_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_f_name1_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_f_ext1_addr       ] . "',";
                    $tmp_sql .= "'" . $val [$d_f_size1_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_f_date1_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_f_path2_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_f_name2_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_f_ext2_addr       ] . "',";
                    $tmp_sql .= "'" . $val [$d_f_size2_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_f_date2_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_reg_date_addr     ] . "',";
                    $tmp_sql .= "'" . $val [$d_html_yn_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_mail_yn_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$d_use_st_addr       ] . "',";
                    $tmp_sql .= "'" . $val [$d_recom_hit_addr    ] . "',";
                    $tmp_sql .= "'" . $val [$d_hit_addr          ] . "',";
                    $tmp_sql .= "'" . $val [$d_down_hit1_addr    ] . "',";
                    $tmp_sql .= "'" . $val [$d_down_hit2_addr    ] . "',";
                    $tmp_sql .= "'" . $val [$d_total_comment_addr] . "',";
                    $tmp_sql .= "'" . $val [$d_comment_date_addr ] . "',";
                    $tmp_sql .= "'" . $val [$d_ip_addr           ] . "' ";
                    $tmp_sql .= ");" ;
//                  logs ( '$sql : '. $sql . $tmp_sql . '<BR>' , true);
                    @mysql_query($sql. $tmp_sql);
                    echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                    echo "<!--\r\n";
                    echo "    parent.progress('board',$tot_progress,$cnt);\r\n";
                    echo "//-->\r\n";
                    echo "</SCRIPT>\r\n";
                }
            }
        }

//////////////////////////////////////////////////////

        if( file_exists('../../../data/'. $c_file . '_bbs_category.sql') ) {

            $category_order = explode( '@', $category_order ) ;
                                                 
            $y_no_addr    = $category_order[0 ];
            $y_o_seq_addr = $category_order[1 ];
            $y_name_addr  = $category_order[2 ];
            $y_etc_addr   = $category_order[3 ];

            $sql  = "insert into " . $tb_bbs_category   . '_' . $bbs_id . " ( ";
            $sql .= "no   ,o_seq,name ,etc  ";
            $sql .= " ) values ( ";

            $f = fopen('../../../data/'. $c_file  . '_bbs_category.sql',"r");
            $file1_str = fread($f, filesize('../../../data/'. $c_file  . '_bbs_category.sql'));
            $data_str = $file1_str;
            fclose($f);
            f_unlink('../../../data/'. $c_file  . '_bbs_category.sql');

            $cnt_s_pos   = strpos($data_str, '##DATA_CNT_START##'     ) + 20;
            $cnt_e_pos   = strpos($data_str, '##DATA_CNT_END##'       )     ;

            if ( $cnt_s_pos == $cnt_e_pos ) {
                $cnt_str    = '';
            } else {
                $cnt_str    = substr ( $data_str, $cnt_s_pos, $cnt_e_pos - $cnt_s_pos );
            }
            echo $cnt_str . '<BR>';
            echo $cnt_s_pos . ' / ' . $cnt_e_pos;
            if ( $cnt_s_pos == $cnt_e_pos || $cnt_e_pos == false ) { // 게시물 조회수 정보
                echo "\r\n<SCRIPT LANGUAGE='JavaScript'>\r\n";
                echo "<!--\r\n";
                echo "    parent.st_fRead='6';\r\n";
                echo "    parent.msgObj.innerHTML='게시판 백업 파일이 유효하지 않습니다.';\r\n";
                echo "//-->\r\n";
                echo "</SCRIPT>\r\n";
                exit;
            } else {
                $data_str    = substr ( $data_str, $cnt_e_pos + 18 );
            }

            $mp = true;
            $cnt= 0   ;
            while ( $mp != false ) {
                $mp        = strpos ( $data_str , 'ⓨ┩'  );
                $line      = substr ( $data_str , 0, $mp  );
                $val       = explode( 'ⓨ┟'      , $line );
                $data_str  = substr ( $data_str , $mp  + 6); // 여기서 6 는 'ⓨ┩'(4) + \r\n(2) 값
                if ( sizeof( $val ) > 4 ) {
                    $tot_progress++;
                    $cnt++;
                    $tmp_sql  = "'" . $val [$y_no_addr   ] . "',";
                    $tmp_sql .= "'" . $val [$y_o_seq_addr] . "',";
                    $tmp_sql .= "'" . $val [$y_name_addr ] . "',";
                    $tmp_sql .= "'" . $val [$y_etc_addr  ] . "' ";
                    $tmp_sql .= ");" ;
//                  logs ( '$sql : '. $sql . $tmp_sql . '<BR>' , true);
                    @mysql_query($sql. $tmp_sql);

                    echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                    echo "<!--\r\n";
                    echo "    parent.progress('category',$tot_progress,$cnt);\r\n";
                    echo "//-->\r\n";
                    echo "</SCRIPT>\r\n";
                }
            }
        }

//////////////////////////////////////////////////////

        if( file_exists('../../../data/'. $c_file . '_bbs_comment.sql') ) {
            if ( $bbs_id ) {
                if ( !isTable($tb_bbs_comment   . '_' . $bbs_id) ) { /* 의견글 */
                    simpleSQLExecute($tb_bbs_comment_schm);
                }
            }

            $comment_order = explode( '@', $comment_order ) ;
                                                 
            $c_no_addr       = $comment_order[0 ];
            $c_p_no_addr     = $comment_order[1 ];
            $c_user_id_addr  = $comment_order[2 ];
            $c_name_addr     = $comment_order[3 ];
            $c_password_addr = $comment_order[4 ];
            $c_memo_addr     = $comment_order[5 ];
            $c_ip_addr       = $comment_order[6 ];
            $c_reg_date_addr = $comment_order[7 ];

            $sql  = "insert into " . $tb_bbs_comment   . '_' . $bbs_id . " ( ";
            $sql .= "no      ,p_no    ,user_id ,";
            $sql .= "name    ,password,memo    ,";
            $sql .= "ip      ,reg_date          ";
            $sql .= " ) values ( ";

            $f = fopen('../../../data/'. $c_file  . '_bbs_comment.sql',"r");
            $file1_str = fread($f, filesize('../../../data/'. $c_file  . '_bbs_comment.sql'));
            $data_str = $file1_str;
            fclose($f);
            f_unlink('../../../data/'. $c_file  . '_bbs_comment.sql');

            $cnt_s_pos   = strpos($data_str, '##DATA_CNT_START##'     ) + 20;
            $cnt_e_pos   = strpos($data_str, '##DATA_CNT_END##'       )     ;

            if ( $cnt_s_pos == $cnt_e_pos ) {
                $cnt_str    = '';
            } else {
                $cnt_str    = substr ( $data_str, $cnt_s_pos, $cnt_e_pos - $cnt_s_pos );
            }
            echo $cnt_str . '<BR>';
            echo $cnt_s_pos . ' / ' . $cnt_e_pos;
            if ( $cnt_s_pos == $cnt_e_pos || $cnt_e_pos == false ) { // 게시물 조회수 정보
                echo "\r\n<SCRIPT LANGUAGE='JavaScript'>\r\n";
                echo "<!--\r\n";
                echo "    parent.st_fRead='6';\r\n";
                echo "    parent.msgObj.innerHTML='의견글 백업 파일이 유효하지 않습니다.';\r\n";
                echo "//-->\r\n";
                echo "</SCRIPT>\r\n";
                exit;
            } else {
                $data_str    = substr ( $data_str, $cnt_e_pos + 18 );
            }

            $mp = true;
            $cnt= 0   ;
            while ( $mp != false ) {
                $mp        = strpos ( $data_str , 'ⓒ┩'  );
                $line      = substr ( $data_str , 0, $mp  );
                $val       = explode( 'ⓒ┟'      , $line );
                $data_str  = substr ( $data_str , $mp  + 6); // 여기서 6 는 'ⓚ┩'(4) + \r\n(2) 값
                if ( sizeof( $val ) > 4 ) {
                    $tot_progress++;
                    $cnt++;
                    $tmp_sql  = "'" . $val [$c_no_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$c_p_no_addr    ] . "',";
                    $tmp_sql .= "'" . $val [$c_user_id_addr ] . "',";
                    $tmp_sql .= "'" . $val [$c_name_addr    ] . "',";
                    $tmp_sql .= "'" . $val [$c_password_addr] . "',";
                    $tmp_sql .= "'" . $val [$c_memo_addr    ] . "',";
                    $tmp_sql .= "'" . $val [$c_ip_addr      ] . "',";
                    $tmp_sql .= "'" . $val [$c_reg_date_addr] . "' ";
                    $tmp_sql .= ");" ;
//                  logs ( '$sql : '. $sql . $tmp_sql . '<BR>' , true);
                    @mysql_query($sql. $tmp_sql);
                    echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                    echo "<!--\r\n";
                    echo "    parent.progress('comment',$tot_progress,$cnt);\r\n";
                    echo "//-->\r\n";
                    echo "</SCRIPT>\r\n";
                }
            }
        }
/////////////////////////////////////

        if( file_exists('../../../data/'. $c_file . '_bbs_grant.sql') ) {
            if ( $bbs_id ) {
                $newNo = simpleSQLQuery("select no from $tb_bbs_infor where bbs_id = '$bbs_id'");

            }

            $grant_order = explode( '@', $grant_order ) ;
                                                 
            $g_no_addr            = $grant_order[0 ];
            $g_bbs_id_addr        = $grant_order[1 ];
            $g_member_level_addr  = $grant_order[2 ];
            $g_grant_list_addr    = $grant_order[3 ];
            $g_grant_view_addr    = $grant_order[4 ];
            $g_grant_write_addr   = $grant_order[5 ];
            $g_grant_answer_addr  = $grant_order[6 ];
            $g_grant_comment_addr = $grant_order[7 ];
            $g_grant_down_addr    = $grant_order[8 ];

            $sql  = "insert into " . $tb_bbs_grant . " ( ";
            $sql .= "no           ,bbs_id       ,member_level ,";
            $sql .= "grant_list   ,grant_view   ,grant_write  ,";
            $sql .= "grant_answer ,grant_comment,grant_down    ";
            $sql .= " ) values ( ";

            $f = fopen('../../../data/'. $c_file  . '_bbs_grant.sql',"r");
            $file1_str = fread($f, filesize('../../../data/'. $c_file  . '_bbs_grant.sql'));
            $data_str = $file1_str;
            fclose($f);
            f_unlink('../../../data/'. $c_file  . '_bbs_grant.sql');

            $cnt_s_pos   = strpos($data_str, '##DATA_CNT_START##'     ) + 20;
            $cnt_e_pos   = strpos($data_str, '##DATA_CNT_END##'       )     ;

            if ( $cnt_s_pos == $cnt_e_pos ) {
                $cnt_str    = '';
            } else {
                $cnt_str    = substr ( $data_str, $cnt_s_pos, $cnt_e_pos - $cnt_s_pos );
            }
            echo $cnt_str . '<BR>';
            echo $cnt_s_pos . ' / ' . $cnt_e_pos;
            if ( $cnt_s_pos == $cnt_e_pos || $cnt_e_pos == false ) { // 게시물 조회수 정보
                echo "\r\n<SCRIPT LANGUAGE='JavaScript'>\r\n";
                echo "<!--\r\n";
                echo "    parent.st_fRead='6';\r\n";
                echo "    parent.msgObj.innerHTML='게시판 권한 파일이 유효하지 않습니다.';\r\n";
                echo "//-->\r\n";
                echo "</SCRIPT>\r\n";
                exit;
            } else {
                $data_str    = substr ( $data_str, $cnt_e_pos + 18 );
            }

            $mp = true;
            $cnt= 0   ;
            while ( $mp != false ) {
                $mp        = strpos ( $data_str , 'ⓖ┩'  );
                $line      = substr ( $data_str , 0, $mp  );
                $val       = explode( 'ⓖ┟'      , $line );
                $data_str  = substr ( $data_str , $mp  + 6); // 여기서 6 는 'ⓖ┩'(4) + \r\n(2) 값
                if ( sizeof( $val ) > 4 ) {
                    $tot_progress++;
                    $cnt++;
                    $tmp_sql  = "'" . $newNo                       . "',";
                    $tmp_sql .= "'" . $val [$g_bbs_id_addr       ] . "',";
                    $tmp_sql .= "'" . $val [$g_member_level_addr ] . "',";
                    $tmp_sql .= "'" . $val [$g_grant_list_addr   ] . "',";
                    $tmp_sql .= "'" . $val [$g_grant_view_addr   ] . "',";
                    $tmp_sql .= "'" . $val [$g_grant_write_addr  ] . "',";
                    $tmp_sql .= "'" . $val [$g_grant_answer_addr ] . "',";
                    $tmp_sql .= "'" . $val [$g_grant_comment_addr] . "',";
                    $tmp_sql .= "'" . $val [$g_grant_down_addr   ] . "' ";
                    $tmp_sql .= ");" ;
//                  logs ( '$sql : '. $sql . $tmp_sql . '<BR>' , true);
                    @mysql_query($sql. $tmp_sql);
                    echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                    echo "<!--\r\n";
                    echo "    parent.progress('grant',$tot_progress,$cnt);\r\n";
                    echo "//-->\r\n";
                    echo "</SCRIPT>\r\n";
                }
            }
        }

/////////////////////////////////////

        if( file_exists('../../../data/'. $c_file . '_bbs_point.sql') ) {
            $point_order = explode( '@', $point_order ) ;

            $p_no_addr           = $point_order[0 ];
            $p_bbs_id_addr       = $point_order[1 ];
            $p_member_level_addr = $point_order[2 ];
            $p_use_st_addr       = $point_order[3 ];
            $p_point_addr        = $point_order[4 ];
            $p_etc_addr          = $point_order[5 ];
            $p_reg_date_addr	 = $point_order[6 ];

            $sql  = "insert into " . $tb_point_infor . " ( ";
            $sql .= "no          ,bbs_id      ,member_level,use_st      ,";
            $sql .= "point       ,etc         ,reg_date                  ";
            $sql .= " ) values ( ";

            $f = fopen('../../../data/'. $c_file  . '_bbs_point.sql',"r");
            $file1_str = fread($f, filesize('../../../data/'. $c_file  . '_bbs_point.sql'));
            $data_str = $file1_str;
            fclose($f);
            f_unlink('../../../data/'. $c_file  . '_bbs_point.sql');

            $cnt_s_pos   = strpos($data_str, '##DATA_CNT_START##'     ) + 20;
            $cnt_e_pos   = strpos($data_str, '##DATA_CNT_END##'       )     ;

            if ( $cnt_s_pos == $cnt_e_pos ) {
                $cnt_str    = '';
            } else {
                $cnt_str    = substr ( $data_str, $cnt_s_pos, $cnt_e_pos - $cnt_s_pos );
            }
            echo $cnt_str . '<BR>';
            echo $cnt_s_pos . ' / ' . $cnt_e_pos;
            if ( $cnt_s_pos == $cnt_e_pos || $cnt_e_pos == false ) { // 게시물 조회수 정보
                echo "\r\n<SCRIPT LANGUAGE='JavaScript'>\r\n";
                echo "<!--\r\n";
                echo "    parent.st_fRead='6';\r\n";
                echo "    parent.msgObj.innerHTML='게시판 포인트 권한 파일이 유효하지 않습니다.';\r\n";
                echo "//-->\r\n";
                echo "</SCRIPT>\r\n";
                exit;
            } else {
                $data_str    = substr ( $data_str, $cnt_e_pos + 18 );
            }

            $mp = true;
            while ( $mp != false ) {
                $mp        = strpos ( $data_str , 'ⓟ┩'  );
                $line      = substr ( $data_str , 0, $mp  );
                $val       = explode( 'ⓟ┟'      , $line );
                $data_str  = substr ( $data_str , $mp  + 6); // 여기서 6 는 'ⓟ┩'(4) + \r\n(2) 값
                if ( sizeof( $val ) > 4 ) {
                    $tot_progress++;
                    $cnt++;
                    $existChk = simpleSQLQuery("select count(member_level) from $tb_member_kind where member_level = '" . $val [$p_member_level_addr] . "'");
                    if ( $existChk ) {
                        $tmp_sql  = "'" . $val [$p_no_addr          ] . "',";
                        $tmp_sql .= "'" . $val [$p_bbs_id_addr      ] . "',";
                        $tmp_sql .= "'" . $val [$p_member_level_addr] . "',";
                        $tmp_sql .= "'" . $val [$p_use_st_addr      ] . "',";
                        $tmp_sql .= "'" . $val [$p_point_addr       ] . "',";
                        $tmp_sql .= "'" . $val [$p_etc_addr         ] . "',";
                        $tmp_sql .= "'" . $val [$p_reg_date_addr	] . "' ";
                        $tmp_sql .= ");" ;
    //                  logs ( '$sql : '. $sql . $tmp_sql . '<BR>' , true);
                        @mysql_query($sql. $tmp_sql);
                    }
                    echo "<SCRIPT LANGUAGE='JavaScript'>\r\n";
                    echo "<!--\r\n";
                    echo "    parent.progress('grant',$tot_progress,$cnt);\r\n";
                    echo "//-->\r\n";
                    echo "</SCRIPT>\r\n";
                }
            }
        }

        copy ('../../../data/'. $c_file . "_dboard_header_"        . $bbs_id . ".php", "../../../data/html/_dboard_header_"       . $bbs_id . ".php" );
        copy ('../../../data/'. $c_file . "_dboard_footer_"        . $bbs_id . ".php", "../../../data/html/_dboard_footer_"       . $bbs_id . ".php" );
        copy ('../../../data/'. $c_file . "_dboard_notice_header_" . $bbs_id . ".php", "../../../data/html/_dboard_notice_header_". $bbs_id . ".php" );
        copy ('../../../data/'. $c_file . "_dboard_notice_footer_" . $bbs_id . ".php", "../../../data/html/_dboard_notice_footer_". $bbs_id . ".php" );

        f_unlink('../../../data/'. $c_file . "_dboard_header_"           . $bbs_id . ".php");
        f_unlink('../../../data/'. $c_file . "_dboard_footer_"           . $bbs_id . ".php");
        f_unlink('../../../data/'. $c_file . "_dboard_notice_header_"    . $bbs_id . ".php");
        f_unlink('../../../data/'. $c_file . "_dboard_notice_footer_"    . $bbs_id . ".php");

    }
}
closeDBConnection (); // 데이터베이스 연결 설정 해제
echo "</body>";
}
?>