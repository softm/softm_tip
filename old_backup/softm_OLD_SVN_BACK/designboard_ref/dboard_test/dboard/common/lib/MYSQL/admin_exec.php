<?
if ( function_exists('head') ) {
    $p_exec = getUrlParamValue($HTTP_REFERER, 'exec');
    $s      = getUrlParamValue($HTTP_REFERER, 's'   );

    if (
        $id && $admin_yn == 'Y' && $grant == 'Y' &&
        ( $exec == 'admin_data_copy' || $exec == 'admin_data_move' || $exec == 'admin_data_delete' ) &&
        preg_match("/${HTTP_HOST}/", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' &&
        !preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(admin_exec.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] )
    )
    {
        if ( $bbsInfor )  { // �Խ��� ���� ����
            $m_no = explode ( ',', $a_no );
            if ( $exec == 'admin_data_move' ) { // ���� �׷� ���̵� �ѱ�� ������ ���� �Ϸ�Ǿ��ֽ��ϴ�.==;
                for($i=0;$i<sizeof ($m_no);$i++) {
                    $newNo = simpleSQLQuery("select MAX(no) from $tb_bbs_data" . "_" . $a_id);
                    if ( !$newNo ) { $newNo = 0; }   // �Խù� ��ȣ ����
                    $newNo = $newNo + 1;

                    // ���� �� ��ȣ
                    $sql = "select no from $tb_bbs_data" . "_" . $a_id . " where pre_no = 0;";
                    $nextNo = simpleSQLQuery($sql);
                    if ( !$nextNo ) { $nextNo = 0; }
                    $preNo= 0;

                    $sql  = "insert into $tb_bbs_data" . "_" . $a_id;
                    $sql .= "(";
                    $sql .= "no         , g_no       ,depth        , o_seq      ,";
                    $sql .= "pre_no     , next_no    ,";
                    $sql .= "member_level,";
                    $sql .= "user_id    , name       ,password     , title      ,";
                    $sql .= "content    , e_mail     ,home         ,             ";
                    $sql .= "f_path1    , f_name1    ,f_ext1       , f_size1    ,";
                    $sql .= "f_date1    , ";
                    $sql .= "f_path2    , f_name2    ,f_ext2       , f_size2    ,";
                    $sql .= "f_date2    , ";
                    $sql .= "reg_date   , html_yn    ,mail_yn      , use_st     ,";
                    $sql .= "recom_hit  , hit        ,total_comment,ip           ";
                    $sql .= ") select ";
                    $sql .= "$newNo     , $newNo     , 0           , 0          ,";
                    $sql .= "$preNo     , $nextNo    ,";
                    $sql .= "member_level,";
                    $sql .= "user_id    , name       , password    , title      ,";
                    $sql .= "content    , e_mail     , home        , ";
                    $sql .= "f_path1    , f_name1    ,f_ext1       , f_size1    ,";
                    $sql .= "f_date1    , ";
                    $sql .= "f_path2    , f_name2    ,f_ext2       , f_size2    ,";
                    $sql .= "f_date2    , ";
                    $sql .= "reg_date   , html_yn    ,mail_yn      , use_st     ,";
                    $sql .= "recom_hit  , hit        ,total_comment, ip          ";
                    $sql .= "from $tb_bbs_data" . "_" . $id;
                    $sql .= " where g_no =" . $m_no[$i];

                    simpleSQLExecute($sql);

                    $sql  = "update $tb_bbs_data" . "_" . $a_id;
                    $sql .= " set pre_no = $newNo where no = $nextNo;";
                    simpleSQLExecute($sql);
                }
            } if ( $exec == 'admin_data_copy' ) {
                for($i=0;$i<sizeof ($m_no);$i++) {
                    $newNo = simpleSQLQuery("select MAX(no) from $tb_bbs_data" . "_" . $a_id);
                    if ( !$newNo ) { $newNo = 0; }   // �Խù� ��ȣ ����
                    $newNo = $newNo + 1;

                    // ���� �� ��ȣ
                    $sql = "select no from $tb_bbs_data" . "_" . $a_id . " where pre_no = 0;";
                    $nextNo = simpleSQLQuery($sql);

                    if ( !$nextNo ) { $nextNo = 0; }
                    $preNo= 0;

                    $sql  = "select f_path1, f_ext1, f_date1, f_path2, f_ext2, f_date2 from $tb_bbs_data" . "_" . $id;
                    $sql .= " where no =" . $m_no[$i];

                    $data = singleRowSQLQuery($sql);

                    $f_path1  = $data["f_path1" ];              // ���� ���1
                    $f_ext1   = $data["f_ext1"  ];              // Ȯ���� ��1
                    $f_date1  = $data["f_date1" ];              // ���� ���ϸ�1

                    $f_path2  = $data["f_path2" ];              // ���� ���2
                    $f_ext2   = $data["f_ext2"  ];              // Ȯ���� ��2
                    $f_date2  = $data["f_date2" ];              // ���� ���ϸ�2

                    $file1    = $baseDir . "data/file/" . $id. "/$f_date1.$f_ext1";
                    $file2    = $baseDir . "data/file/" . $id. "/$f_date2.$f_ext2";

                    if ( $f_path1 ) { $f_path1  = "data/file/" . $a_id  . '/'; } else { $f_path1 = ''; }
                    if ( $f_path2 ) { $f_path1  = "data/file/" . $a_id  . '/'; } else { $f_path2 = ''; }

                    $sql  = "insert into $tb_bbs_data" . "_" . $a_id;
                    $sql .= "(";
                    $sql .= "no         , g_no       ,depth        , o_seq      ,";
                    $sql .= "pre_no     , next_no    ,";
                    $sql .= "member_level,";
                    $sql .= "user_id    , name       ,password     , title      ,";
                    $sql .= "content    , e_mail     ,home         ,             ";
                    $sql .= "f_path1    , f_name1    ,f_ext1       , f_size1    ,";
                    $sql .= "f_date1    , ";
                    $sql .= "f_path2    , f_name2    ,f_ext2       , f_size2    ,";
                    $sql .= "f_date2    , ";
                    $sql .= "reg_date   , html_yn    ,mail_yn      , use_st     ,";
                    $sql .= "recom_hit  , hit        ,ip           ,";
                    $sql .= "total_comment,comment_date ";
                    $sql .= ") select ";
                    $sql .= "$newNo     , -" . "$newNo     , 0           , 0          ,";
                    $sql .= "$preNo     , $nextNo    ,";
                    $sql .= "member_level,";
                    $sql .= "user_id    , name       , password    , title      ,";
                    $sql .= "content    , e_mail     , home        , ";
                    $sql .= "'$f_path1' , f_name1    ,f_ext1       , f_size1    ,";
                    $sql .= "f_date1    , ";
                    $sql .= "'$f_path2' , f_name2    ,f_ext2       , f_size2    ,";
                    $sql .= "f_date2    , ";
                    $sql .= "'" . getYearToMicro() . "', html_yn    ,mail_yn      , use_st,";
                    $sql .= "0          , 0          ,ip           ,";
                    $sql .= "total_comment,comment_date ";
                    $sql .= "from $tb_bbs_data" . "_" . $id;
                    $sql .= " where no =" . $m_no[$i];
                    simpleSQLExecute($sql);


                    $sql  = "update $tb_bbs_data" . "_" . $a_id;
                    $sql .= " set pre_no = $newNo where no = $nextNo;";
                    simpleSQLExecute($sql);

                    $sql  = "insert into $tb_bbs_comment" . "_" . $a_id;
                    $sql .= "(";
                    $sql .= "no      ,p_no    ,user_id ,";
                    $sql .= "name    ,password,memo    ,";
                    $sql .= "ip      ,reg_date          ";
                    $sql .= ") select ";
                    $sql .= "no      ,$newNo  ,user_id ,";
                    $sql .= "name    ,password,memo    ,";
                    $sql .= "ip      ,reg_date          ";
                    $sql .= "from $tb_bbs_comment" . "_" . $id;
                    $sql .= " where p_no =" . $m_no[$i];
                    simpleSQLExecute($sql);

                    $httpUrl1 = $baseDir . "data/file/" . $a_id  . '/';
                    if ( !@is_dir( $baseDir . $httpUrl1 ) ) {
                        @mkdir($baseDir . $httpUrl1,0707);
                        @chmod($baseDir . $httpUrl1,0707);
                    }
                    @copy ( $file1, $httpUrl1 . $f_date1 . '.' . $f_ext1 );

                    $httpUrl2 = $baseDir . "data/file/" . $a_id  . '/';
                    if ( !@is_dir( $baseDir . $httpUrl2 ) ) {
                        @mkdir($baseDir . $httpUrl2,0707);
                        @chmod($baseDir . $httpUrl2,0707);
                    }
                    @copy ( $file2, $httpUrl2 . $f_date2 . '.' . $f_ext2 );
                }
            } else if ( $exec == 'admin_data_delete' ) {

                for($i=0;$i<sizeof ($m_no);$i++) {
                    $sql0  = "select COUNT(no) from $tb_bbs_data" . "_" . $id;
                    $sql0 .= " where no = $m_no[$i];";
                    $existChk = simpleSQLQuery($sql0);

                    if ( $existChk ) {
                        $sql  = "select no, g_no, o_seq, depth,pre_no, next_no, f_path1, f_name1, f_ext1, f_size1, f_date1, f_path2, f_name2, f_ext2, f_size2, f_date2 from $tb_bbs_data" . "_" . $id . " where no = $m_no[$i];";
                        $data = singleRowSQLQuery($sql);
                        $g_no  = $data['g_no' ];
                        $o_seq = $data['o_seq'];
                        $depth = $data['depth'];
                        $preNo = $data['pre_no'];
                        $nextNo= $data['next_no'];

                        $f_path1  = $data["f_path1" ];              // ���� ���1
                        $f_name1  = addslashes($data["f_name1" ]);  // ���� ��1
                        $f_ext1   = $data["f_ext1"  ];              // Ȯ���� ��1
                        $f_size1  = $data["f_size1" ];              // ���� ũ��1
                        $f_date1  = $data["f_date1" ];              // ���� ���ϸ�1

                        $f_path2  = $data["f_path2" ];              // ���� ���2
                        $f_name2  = addslashes($data["f_name2" ]);  // ���� ��2
                        $f_ext2   = $data["f_ext2"  ];              // Ȯ���� ��2
                        $f_size2  = $data["f_size2" ];              // ���� ũ��2
                        $f_date2  = $data["f_date2" ];              // ���� ���ϸ�2

						$file1    = $baseDir . "data/file/" . $id. "/$f_date1.$f_ext1";
						$file2    = $baseDir . "data/file/" . $id. "/$f_date2.$f_ext2";

                        $sql  = "select COUNT(no) from $tb_bbs_data" . "_" . $id;
                        $sql .= " where g_no = $g_no and o_seq = $o_seq + 1 and depth = $depth + 1;";
                        $subChk= simpleSQLQuery($sql);
                        if ( $subChk ) {                  // ���� �ڷᰡ ����� �����ϴ� ���
                            $sql  = "update $tb_bbs_data" . "_" . $id;
                            $sql .= " set   ip     = '$ip',";
                            $sql .= " use_st = 9    "; // �����ڿ� ���� ����
                            $sql .= " where no  = $m_no[$i]";
                            simpleSQLExecute($sql);

                            $sql  = "update $tb_bbs_data" . "_" . $id;
                            $sql .= " set   pre_no = $preNo";
                            $sql .= " where no = $nextNo";
                            simpleSQLExecute($sql);

                            $sql  = "update $tb_bbs_data" . "_" . $id;
                            $sql .= " set   next_no = $nextNo";
                            $sql .= " where no = $preNo";
                            simpleSQLExecute($sql);

                        } else {
                            $sql  = "delete from $tb_bbs_data" . "_" . $id . " where no = $m_no[$i];";
                            simpleSQLExecute($sql);

                            $sql  = "update $tb_bbs_data" . "_" . $id;
                            $sql .= " set   pre_no = $preNo";
                            $sql .= " where no = $nextNo";
                            simpleSQLExecute($sql);

                            $sql  = "update $tb_bbs_data" . "_" . $id;
                            $sql .= " set   next_no = $nextNo";
                            $sql .= " where no = $preNo";
                            simpleSQLExecute($sql);

                            $sql  = "delete from $tb_bbs_comment" . "_" . $id;
                            $sql .= " where p_no = $m_no[$i]";
                            simpleSQLExecute($sql);

                            if ( @is_file("$file1") ) {
                                @unlink ( "$file1" ) or MessageExit("S", "0023","", $skinDir); // ���� ������ ����.
                            }
                            if ( @is_file("$file2") ) {
                                @unlink ( "$file2" ) or MessageExit("S", "0023","", $skinDir); // ���� ������ ����.
                            }
                        }
                    } else {
                            MessageExit('S', '0040'); // ������ ����
                    }
                }
            }

            $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
            $retunPage .= '?id='   . $id    ;
            redirectPage($retunPage);
        } // if END

    }
}
?>