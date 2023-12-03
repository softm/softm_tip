<?php
require_once SERVICE_DIR . '/common/lib/var_database.inc' ; // 변수
require_once SERVICE_DIR . '/common/Session.php' ; // 변수

class Member
{

    function Member() {
    }

    /*
    * 함수명: getList
    * 조회리스트
    **/
    function getList($argus) {
        $s        = $argus[s ];
        $s_gubun  = $argus[s_gubun ];
        $s_search = $argus[s_search];
        $db = new DB();
        $db->getConnect();
        //echo '$s_gubun : ' . $s_gubun . '<br>';
        //echo '$s_search : ' . $s_search . '<br>';
        include UI_DIR . '/member_list.php';
        $db->release();
    }

    /*
    * 함수명: getRealConfirmWrite
    * 실명확인 화면
    **/
    function getRealConfirmWrite($argus) {
        $mode  = $argus[mode];
        $p_user_no  = $argus[p_user_no];

        //echo '$mode : ' . $mode . '<br>';
        //echo '$p_user_no : ' . $p_user_no . '<br>';
        if ( $mode == 'U' ) {
            $db = new DB();
            $db->getConnect();
        }
        include UI_DIR . '/member_real_name_confirm.php';

        if ( $mode == 'U' ) $db->release();
    }

    /*
    * 함수명: getWrite
    * 회원가입 화면
    **/
    function getWrite($argus) {
        $mode       = $argus[mode];

        //echo '$mode : ' . $mode . '<br>';
        //echo '$p_user_no : ' . $p_user_no . '<br>';
        if ( $mode == 'U' ) {
            $db = new DB();
            $db->getConnect();
        } else {
            $jumin_no1  = $argus[jumin_no1];
            $jumin_no2  = $argus[jumin_no2];
            $user_name  = $argus[user_name];
            if ( $jumin_no1 && $jumin_no2 && $user_name) {
                Session::setSession('tmp_jumin_no1' ,$jumin_no1 );
                Session::setSession('tmp_jumin_no2' ,$jumin_no2 );
                Session::setSession('tmp_user_name' ,$user_name );
            }
        }
        include UI_DIR . '/member_register.php';
//echo 'jumin_no1 : ' . $jumin_no1 . ' /<BR>';
//echo 'jumin_no2 : ' . $jumin_no2 . ' /<BR>';
//echo 'user_name : ' . $user_name . ' /<BR>';
        if ( $mode == 'U' ) $db->release();
    }

    /*
    * 함수명: simpleWriteExec
    * 입력/수정실행
    **/
    function simpleWriteExec($argus) {

        $db             = $argus[db]?$argus[db]:null;
        if ( !$argus[db] ) {
            $db = new DataBase();
            $db->getConnect();
        }

        $errors = array();
        //$mode  = $argus[mode];
        $p_user_name = $argus[user_name   ];
        $p_user_id   = $argus[p_user_id   ];
        $p_user_level= "P";
        $passwd      = $argus[p_passwd    ];
        $state       = "U"; // 사용

        if ( $db->starttransaction() ) {
            $sql  = "INSERT INTO " . TB_MEMBER
                  . " ( "
                  . " USER_ID     ,USER_LEVEL  ,PASSWD      ,"
                  . " USER_NAME   ,"
                  . " REG_DATE    ,STATE"
                  . " ) VALUES ("
                  . " '" . strtolower($p_user_id) . "','" . $p_user_level . "','" . $passwd . "',"
                  . " '" . $p_user_name . "',"
                  . " now(), '" . $state . "'"
                  . " )";
            if ( !$db->exec($sql) ) {
                $errors[] = $db->getErrMsg();
            }
        } else {
            $errors[] = '트랜잭션을 시작할 수 없습니다.';
        }

        if ( empty($errors) ) $db->commit();

        toResultXML(array("code"=>(empty($errors)?"SUCCESS":"ERROR"),"sql"=>$db?$db->getLastSql():"", "p_mode"=>$p_mode,"message"=>(empty($errors)?"Saved":implode($errors, "', '"))));

        if ( !$argus[db] ) $db->release();
    }
    /*
    * 함수명: writeExec
    * 입력/수정실행
    **/
    function writeExec($argus) {
        $mode  = $argus[mode];
        $db = new DB();
        $db->getConnect();

        $p_user_no   = $argus[user_no     ];
        $p_user_id   = $argus[user_id     ];
        $p_user_level= $argus[user_level  ];
        $passwd      = $argus[passwd      ];
        $change_pwd  = $argus[change_pwd  ];
        $p_user_name = $argus[user_name   ];
        $nick_name   = $argus[nick_name   ];
        $company_name= $argus[company_name];
        $sex         = $argus[sex         ];
        $e_mail      = $argus[e_mail      ];
        $jumin_no    = $argus[jumin_no    ];
        $company_no  = $argus[company_no  ];
        $tel1        = $argus[tel1        ];
        $tel2        = $argus[tel2        ];
        $tel3        = $argus[tel3        ];
        $tel4        = $argus[tel4        ];
        $address1    = $argus[address1    ];
        $address2    = $argus[address2    ];
        $post_no     = $argus[post_no     ];
        $email_yn    = $argus[email_yn    ];
        $access      = $argus[access      ];
        $reg_date    = $argus[reg_date    ];
        $acc_date    = $argus[acc_date    ];
/*
        echo '$mode : ' . $mode . '<br>';
        echo 'p_user_no    : ' . $p_user_no    . '<br>';
        echo 'p_user_id    : ' . $p_user_id    . '<br>';
        echo 'p_user_level : ' . $p_user_level . '<br>';
        echo 'passwd       : ' . $passwd       . '<br>';
        echo 'p_user_name  : ' . $p_user_name  . '<br>';
        echo 'nick_name    : ' . $nick_name    . '<br>';
        echo 'company_name : ' . $company_name . '<br>';
        echo 'sex          : ' . $sex          . '<br>';
        echo 'e_mail       : ' . $e_mail       . '<br>';
        echo 'jumin_no     : ' . $jumin_no     . '<br>';
        echo 'company_no   : ' . $company_no   . '<br>';
        echo 'tel1         : ' . $tel1         . '<br>';
        echo 'tel2         : ' . $tel2         . '<br>';
        echo 'tel3         : ' . $tel3         . '<br>';
        echo 'tel4         : ' . $tel4         . '<br>';
        echo 'address1     : ' . $address1     . '<br>';
        echo 'address2     : ' . $address2     . '<br>';
        echo 'post_no      : ' . $post_no      . '<br>';
        echo 'email_yn     : ' . $email_yn     . '<br>';
        echo 'access       : ' . $access       . '<br>';
        echo 'reg_date     : ' . $reg_date     . '<br>';
        echo 'acc_date     : ' . $acc_date     . '<br>';
////////////////////////////////
*/

        $tel1 = preg_replace('/[^0-9]/','',$tel1);
        $tel1_1 = substr($tel1,0,3);
        $tel1_2 = strlen( $tel1 )>10?substr($tel1,3,4):substr($tel1,3,3);
        $tel1_3 = strlen( $tel1 )>10?substr($tel1,7):substr($tel1,6);
        $tel1 = $tel1_1 . '-' . $tel1_2 . '-' . $tel1_3;

        $tel2 = preg_replace('/[^0-9]/','',$tel2);
        if ( substr($tel2,0,2)=='02' ) {
            $tel2_1 = '02';
            $tel2_2 = strlen( substr($tel2,2) )>7?substr($tel2,2,4):substr($tel2,2,3);
            $tel2_3 = strlen( substr($tel2,2) )>7?substr($tel2,6  ):substr($tel2,5);
        } else {
            $tel2_1 = substr($tel2,0,3);
            $tel2_2 = strlen( substr($tel2,3) )>7?substr($tel2,3,4):substr($tel2,3,3);
            $tel2_3 = strlen( substr($tel2,3) )>7?substr($tel2,7  ):substr($tel2,6)  ;
        }
        $tel2 = $tel2_1 . '-' . $tel2_2 . '-' . $tel2_3;

        if ( $mode == 'I' ) {
            $sql  = "INSERT INTO " . TB_MEMBER
                  . " ( "
                  . " USER_ID     ,USER_LEVEL  ,PASSWD      ,"
                  . " USER_NAME   ,NICK_NAME   ,COMPANY_NAME,SEX         ,"
                  . " E_MAIL      ,"
                  . " JUMIN_NO    ,COMPANY_NO  ,"
                  . " TEL1        ,TEL2        ,TEL3        ,TEL4        ,"
                  . " ADDRESS1    ,ADDRESS2    ,POST_NO     ,"
                  . " EMAIL_YN    ,ACCESS      ,"
                  . " REG_DATE    ,ACC_DATE    ,STATE"
                  . " ) VALUES ("
                  . " '" . strtolower($p_user_id) . "','" . $p_user_level . "','" . $passwd . "',"
                  . " '" . $p_user_name . "' ,'" . $nick_name . "','" . $company_name . "','" . $sex . "',"
                  . " '" . $e_mail . "' ,"
                  . " '" . $jumin_no . "' ,'" . $company_no . "',"
                  . " '" . $tel1 . "' ,'" . $tel2 . "','" . $tel3 . "','" . $tel4 . "',"
                  . " '" . $address1 . "' ,'" . $address2 . "','" . $post_no . "',"
                  . " '" . $email_yn . "' ,'0',"
                  . " now(),null,'U'"
                  . " )";
            if ( !$db->simpleSQLExecute($sql) ) {
                echo 'ERROR|' . $db->getErrMsg();
            } else {
                echo 'SUCCESS';
            }
            echo '|sql : ' . $sql;
            //$new_user_no = $db->getInsertId();
        } else if ( $mode == 'U' ) {
            require_once SERVICE_DIR . '/common/Session.php' ; // 변수
            $memInfor = Session::getSession();

            $sql  = " UPDATE " . TB_MEMBER . " SET"
                  . ($passwd && $change_pwd == 'Y'?" PASSWD      = '" . $passwd       . "'  ,":'')
                  . " USER_NAME   = '" . $p_user_name  . "'  ,"
                  . ($nick_name?" NICK_NAME   = '" . $nick_name    . "'  ,":'')
                  . ($company_name?" COMPANY_NAME= '" . $company_name . "'  ,":'')
                  . " SEX         = '" . $sex          . "'  ,"
                  . " E_MAIL      = '" . $e_mail       . "'  ,"
                  . ($jumin_no  ?" JUMIN_NO     = '" . $jumin_no      . "'  ,":'')
                  . ($company_no?" COMPANY_NO   = '" . $company_no    . "'  ,":'')
                  . " TEL1        = '" . $tel1         . "'  ,"
                  . " TEL2        = '" . $tel2         . "'  ,"
                //. " TEL3        = '" . $tel3         . "'  ,"
                //. " TEL4        = '" . $tel4         . "'  ,"
                  . " ADDRESS1    = '" . $address1     . "'  ,"
                  . " ADDRESS2    = '" . $address2     . "'  ,"
                  . " POST_NO     = '" . $post_no      . "'  ,"
                  . " EMAIL_YN    = '" . $email_yn     . "'   "
                //. " ACCESS      = '" . $access       . "'  ,"
                //. " REG_DATE    = '" . $reg_date     . "'  ,"
                //. " ACC_DATE    = '" . $acc_date     . "'  ,"
                //. " STATE       = '" . $state        . "'   "
                  . " WHERE USER_NO = '" . $memInfor[user_no] . "'";
            if ( !$db->simpleSQLExecute($sql) ) {
                echo 'ERROR|' . $db->getErrMsg();
            } else {
                echo 'SUCCESS';
            }
            echo '|sql : ' . $sql;
        }
        $db->release();
    }
    /*
    * 함수명: deleteExec
    * 삭제실행
    **/
    function deleteExec($argus) {
        $mode  = $argus[mode];
        $user_nos  = $argus[user_nos];
        $db = new DB();
        $db->getConnect();
        $l = sizeof($user_nos);
        $inStr = '';
        foreach ($user_nos as $k => $v) {
            $inStr .= (($k==0)?'':',') . $v ;
        }
        if ( $mode == 'D' && $inStr ) {
            $sql  = " DELETE FROM " . TB_MEMBER . ""
                  . " WHERE USER_NO IN(" . $inStr. ")"
                  . " AND   USER_LEVEL = 1";
            //echo 'sql : ' . $sql . ' / ' . $val;
            if ( !$db->simpleSQLExecute($sql) ) {
                echo 'ERROR|' . $db->getErrMsg();
            } else {
                echo 'SUCCESS';
            }
            echo '|sql : ' . $sql;
        }
        $db->release();
    }
}

//MemberService::getList($s_user_id);
//echo 'ss';
?>