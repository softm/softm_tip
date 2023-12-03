<?
/*
 Filename        : /admin/init_setup1.php
 Fuction         : DB 초기화
 Comment         :
 시작 일자       : 2009-03-08,
 수정 일자       : 2009-04-08, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
 @author         : Copyright (c) npec.co.kr. All Rights Reserved.
*/
require_once './lib/common.lib.inc' ; // 라이브러리
require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션

require_once SERVICE_DIR .'/lib/var_database.define.inc'     ; // DataBase 변수
require_once SERVICE_DIR .'/classes/common/Database.class.php'       ; // DB Connection

$memInfor = Session::getSession();

define('DB_KIND','MYSQL'); // db kind
$db = new DataBase ();
$db->getConnect();
$db->exec("set names utf8;");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$db = new DataBase ();
$db->getConnect();
//if ( $memInfor[admin_yn] == 'Y' ) {
    set_time_limit ( 0 );
/*
drop table hd_area_01;
drop table hd_area_02;
drop table hd_area_03;
drop table hd_area_04;

drop table hd_member;

drop table hd_comment;
drop table hd_image;
drop table hd_payment;
drop table hd_product;
drop table hd_product_history;
drop table hd_product_tmp;

*/
if ( DB_KIND == 'MYSQL' ) {
    /* 회원 정보 */
    $tb_member_schm         = "CREATE  TABLE  " . TBL_MEMBER . " (";
    $tb_member_schm        .= "    USER_NO              MEDIUMINT UNSIGNED          NOT NULL AUTO_INCREMENT             COMMENT '회원번호'              ,";
    $tb_member_schm        .= "    USER_ID              VARCHAR (100 )              NOT NULL                            COMMENT '아이디'                ,";
    $tb_member_schm        .= "    USER_LEVEL           CHAR    (1  )               NOT NULL                            COMMENT '회원 레벨 0 : 비회원, 1 : 일반회원, 2: 중개회원 , 9 : 관리자',";
    $tb_member_schm        .= "    PASSWD               VARCHAR (50 )               NOT NULL                            COMMENT '비밀번호'              ,";
    $tb_member_schm        .= "    USER_NAME            VARCHAR (20 )                                                   COMMENT '이름'                  ,";
    $tb_member_schm        .= "    NICK_NAME            VARCHAR (20 )                                                   COMMENT '별명'                  ,";
    $tb_member_schm        .= "    COMPANY_NAME         VARCHAR (100)                                                   COMMENT '부동산업체명'          ,";
    $tb_member_schm        .= "    SEX                  CHAR    (1  )                                                   COMMENT '성별'                  ,";
    $tb_member_schm        .= "    E_MAIL               VARCHAR (100)                                                   COMMENT 'E-mail'                ,";
    $tb_member_schm        .= "    JUMIN_NO             VARCHAR (13 )                                                   COMMENT '주민번호'              ,";
    $tb_member_schm        .= "    COMPANY_NO           VARCHAR (20 )                                                   COMMENT '사업자번호'            ,";
    $tb_member_schm        .= "    TEL1                 VARCHAR (20 )                                                   COMMENT '핸드폰'                ,";
    $tb_member_schm        .= "    TEL2                 VARCHAR (20 )                                                   COMMENT '전화1'                 ,";
    $tb_member_schm        .= "    TEL3                 VARCHAR (20 )                                                   COMMENT '전화2'                 ,";
    $tb_member_schm        .= "    TEL4                 VARCHAR (20 )                                                   COMMENT '전화3'                 ,";
    $tb_member_schm        .= "    ADDRESS1             VARCHAR (100)                                                   COMMENT '주소'                  ,";
    $tb_member_schm        .= "    ADDRESS2             VARCHAR (100)                                                   COMMENT '나머지 주소'           ,";
    $tb_member_schm        .= "    POST_NO              VARCHAR (7  )                                                   COMMENT '우편번호'              ,";
    $tb_member_schm        .= "    EMAIL_YN             CHAR    (1  )               DEFAULT 'Y'                         COMMENT '이메일 수신 여부'      ,";
    $tb_member_schm        .= "    ACCESS               MEDIUMINT UNSIGNED          DEFAULT 0                           COMMENT '접속 횟수'             ,";
    $tb_member_schm        .= "    REG_DATE             DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '가입 일자'             ,";
    $tb_member_schm        .= "    ACC_DATE             DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '최근 접근일'           ,";
    $tb_member_schm        .= "    STATE                CHAR    (1  )               NOT NULL                            COMMENT '회원 상태'             ,";
    $tb_member_schm        .= "    CONSTRAINT " . TBL_MEMBER . "_PK PRIMARY KEY (USER_NO),";
    $tb_member_schm        .= "    CONSTRAINT " . TBL_MEMBER . "_UK UNIQUE KEY  (USER_ID),";
    $tb_member_schm        .= "    KEY IDX_" . TBL_MEMBER . "_0 ( USER_ID,PASSWD), ";
    $tb_member_schm        .= "    KEY IDX_" . TBL_MEMBER . "_1 ( USER_LEVEL    ), ";
    $tb_member_schm        .= "    KEY IDX_" . TBL_MEMBER . "_2 ( USER_NAME     ), ";
    $tb_member_schm        .= "    KEY IDX_" . TBL_MEMBER . "_3 ( COMPANY_NAME  )  ";
    $tb_member_schm        .= ") ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='회원정보' ;";

    /* 우편번호 */
    $tb_post_schm            = "CREATE  TABLE  " . TBL_POST . " (";
    $tb_post_schm           .= "    POST_SEQ            MEDIUMINT UNSIGNED          NOT NULL AUTO_INCREMENT     COMMENT '우편순서'          ,   ";
    $tb_post_schm           .= "    ZIPCODE             CHAR    (7  )       NOT NULL                            COMMENT '우편번호'          ,   ";
    $tb_post_schm           .= "    SIDO                VARCHAR (4  )       NOT NULL                            COMMENT '시도'              ,   ";
    $tb_post_schm           .= "    GUGUN               VARCHAR (15 )       NOT NULL                            COMMENT '구군'              ,   ";
    $tb_post_schm           .= "    DONG                VARCHAR (52 )       NOT NULL                            COMMENT '동'                ,   ";
    $tb_post_schm           .= "    BUNJI               VARCHAR (17 )       DEFAULT NULL                        COMMENT '번지'              ,   ";
    $tb_post_schm           .= "    X1                  MEDIUMINT UNSIGNED  DEFAULT 0                           COMMENT 'x1좌표'            ,   ";
    $tb_post_schm           .= "    Y1                  MEDIUMINT UNSIGNED  DEFAULT 0                           COMMENT 'y1좌표'            ,   ";
    $tb_post_schm           .= "    X2                  MEDIUMINT UNSIGNED  DEFAULT 0                           COMMENT 'x2좌표'            ,   ";
    $tb_post_schm           .= "    Y2                  MEDIUMINT UNSIGNED  DEFAULT 0                           COMMENT 'y2좌표'            ,   ";
    $tb_post_schm           .= "    CONSTRAINT " . TBL_POST . "_PK PRIMARY KEY ( POST_SEQ ),";
    $tb_post_schm           .= "    KEY IDX_" . TBL_POST . "_0 ( ZIPCODE   ), ";
    $tb_post_schm           .= "    KEY IDX_" . TBL_POST . "_1 ( SIDO,GUGUN), ";
    $tb_post_schm           .= "    KEY IDX_" . TBL_POST . "_2 ( DONG      )  ";
    $tb_post_schm           .= ") ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='우편번호';";

    //echo $tb_payment_schm;
    //echo simpleSQLQuery('show tables');
    echo "<DIV align='left' style='width:100%;height:100%;margin-top:10;margin-left:10;'>";
    echo "=================================================시작=================================================<BR>";
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ( !$db->isTable(TBL_MEMBER            )   ) { $db->simpleSQLExecute($tb_member_schm           ,true); echo 'table 생성===> ' . TBL_MEMBER          . ' <BR>';}
    if ( !$db->isTable(TBL_POST              )   ) { $db->simpleSQLExecute($tb_post_schm             ,true); echo 'table 생성===> ' . TBL_POST            . ' <BR>';}
    echo "=================================================완료=================================================<BR>";

    //$db->simpleSQLExecute("insert into test (a) values ('김지훈');");

    $sql  = "INSERT INTO " . TBL_MEMBER
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
          . " '" . strtolower('admin') . "','9','1',"
          . " '관리자' ,'관리자','티센엘리베이터','1',"
          . " 'rete73@nate.com' ,"
          . " 'xxxxxxxxxxxxx' ,'xxxxxxxxxx',"
          . " '02-2682-7211' ,'011-9071-7218','','',"
          . " '경기도 광명시 광명3동' ,'159-42','423-013',"
          . " 'Y' ,'0',"
          . " now(),null,'U'"
          . " )";
    if ( !$db->simpleSQLExecute($sql) ) {
        //echo 'ERROR|' . $db->getErrMsg();
    } else {
        //echo 'SUCCESS';
    }
    echo "</DIV>";
} else if( DB_KIND == 'ORACLE' ) {
    /* 회원 정보 */
    $db->simpleSQLExecute("drop table " . TBL_MEMBER,true);

    $tb_member_schm         = "CREATE  TABLE  " . TBL_MEMBER . " (\n";
    $tb_member_schm        .= "        USER_NO              int                         NOT NULL       ,\n";
    $tb_member_schm        .= "        USER_ID              VARCHAR (100 )              NOT NULL       ,\n";
    $tb_member_schm        .= "        USER_LEVEL           CHAR    (1  )               NOT NULL       ,\n";
    $tb_member_schm        .= "        PASSWD               VARCHAR (50 )               NOT NULL       ,\n";
    $tb_member_schm        .= "        USER_NAME            VARCHAR (20 )                              ,\n";
    $tb_member_schm        .= "        NICK_NAME            VARCHAR (20 )                              ,\n";
    $tb_member_schm        .= "        COMPANY_NAME         VARCHAR (100)                              ,\n";
    $tb_member_schm        .= "        SEX                  CHAR    (1  )                              ,\n";
    $tb_member_schm        .= "        E_MAIL               VARCHAR (100)                              ,\n";
    $tb_member_schm        .= "        JUMIN_NO             VARCHAR (13 )                              ,\n";
    $tb_member_schm        .= "        COMPANY_NO           VARCHAR (20 )                              ,\n";
    $tb_member_schm        .= "        TEL1                 VARCHAR (20 )                              ,\n";
    $tb_member_schm        .= "        TEL2                 VARCHAR (20 )                              ,\n";
    $tb_member_schm        .= "        TEL3                 VARCHAR (20 )                              ,\n";
    $tb_member_schm        .= "        TEL4                 VARCHAR (20 )                              ,\n";
    $tb_member_schm        .= "        ADDRESS1             VARCHAR (100)                              ,\n";
    $tb_member_schm        .= "        ADDRESS2             VARCHAR (100)                              ,\n";
    $tb_member_schm        .= "        POST_NO              VARCHAR (7  )                              ,\n";
    $tb_member_schm        .= "        EMAIL_YN             CHAR    (1  )               DEFAULT 'Y'    ,\n";
    $tb_member_schm        .= "        ACCESS_CNT           int                         DEFAULT 0      ,\n";
    $tb_member_schm        .= "        REG_DATE             TIMESTAMP                   DEFAULT sysdate,\n";
    $tb_member_schm        .= "        ACC_DATE             TIMESTAMP                                  ,\n";
    $tb_member_schm        .= "        STATE                CHAR    (1  )               NOT NULL       ,\n";
    $tb_member_schm        .= "        CONSTRAINT  " . TBL_MEMBER . "_PK PRIMARY KEY (USER_NO),      \n";
    $tb_member_schm        .= "        CONSTRAINT  " . TBL_MEMBER . "_UK UNIQUE (USER_ID)            \n";
    $tb_member_schm        .= "    ) \n";
  //$tb_member_schm        .= "    KEY IDX_" . TBL_MEMBER . "_0 ( USER_ID,PASSWD), \n";
  //$tb_member_schm        .= "    KEY IDX_" . TBL_MEMBER . "_1 ( USER_LEVEL    ), \n";
  //$tb_member_schm        .= "    KEY IDX_" . TBL_MEMBER . "_2 ( USER_NAME     ), \n";
  //$tb_member_schm        .= "    KEY IDX_" . TBL_MEMBER . "_3 ( COMPANY_NAME  )  \n";
echo "<textarea>" . $tb_member_schm. "</textarea>";
    /* 우편번호 */
    $tb_post_schm            = "CREATE  TABLE  " . TBL_POST . " (";
    $tb_post_schm           .= "    POST_SEQ            MEDIUMINT UNSIGNED          NOT NULL AUTO_INCREMENT     COMMENT '우편순서'          ,   ";
    $tb_post_schm           .= "    ZIPCODE             CHAR    (7  )       NOT NULL                            COMMENT '우편번호'          ,   ";
    $tb_post_schm           .= "    SIDO                VARCHAR (4  )       NOT NULL                            COMMENT '시도'              ,   ";
    $tb_post_schm           .= "    GUGUN               VARCHAR (15 )       NOT NULL                            COMMENT '구군'              ,   ";
    $tb_post_schm           .= "    DONG                VARCHAR (52 )       NOT NULL                            COMMENT '동'                ,   ";
    $tb_post_schm           .= "    BUNJI               VARCHAR (17 )       DEFAULT NULL                        COMMENT '번지'              ,   ";
    $tb_post_schm           .= "    X1                  MEDIUMINT UNSIGNED  DEFAULT 0                           COMMENT 'x1좌표'            ,   ";
    $tb_post_schm           .= "    Y1                  MEDIUMINT UNSIGNED  DEFAULT 0                           COMMENT 'y1좌표'            ,   ";
    $tb_post_schm           .= "    X2                  MEDIUMINT UNSIGNED  DEFAULT 0                           COMMENT 'x2좌표'            ,   ";
    $tb_post_schm           .= "    Y2                  MEDIUMINT UNSIGNED  DEFAULT 0                           COMMENT 'y2좌표'            ,   ";
    $tb_post_schm           .= "    CONSTRAINT " . TBL_POST . "_PK PRIMARY KEY ( POST_SEQ ),";
    $tb_post_schm           .= "    KEY IDX_" . TBL_POST . "_0 ( ZIPCODE   ), ";
    $tb_post_schm           .= "    KEY IDX_" . TBL_POST . "_1 ( SIDO,GUGUN), ";
    $tb_post_schm           .= "    KEY IDX_" . TBL_POST . "_2 ( DONG      )  ";
    $tb_post_schm           .= ")";

    //echo $tb_payment_schm;
    //echo simpleSQLQuery('show tables');
    echo "<DIV align='left' style='width:100%;height:100%;margin-top:10;margin-left:10;'>";
    echo "=================================================시작=================================================<BR>";
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ( !$db->isTable(TBL_MEMBER            )   ) {
        $err = $db->simpleSQLExecute($tb_member_schm ,true);
        if ( empty($err) ){
            $db->simpleSQLExecute("drop SEQUENCE USER_NO",true);
            echo '<BR>table 생성===> ' . TBL_MEMBER . ' <BR>'; 
            $err = $db->simpleSQLExecute("CREATE SEQUENCE USER_NO START WITH 1 INCREMENT BY 1 MAXVALUE 100000",true);
            if ( !empty($err) ) echo 'SEQUENCE 생성 Error ===> ' . TBL_MEMBER . join($err,'<BR>') . ' <BR>';
        } else {
            echo 'table 생성 Error ===> ' . TBL_MEMBER . join($err,'<BR>') . ' <BR>';
        }

    }

    //if ( !$db->isTable(TBL_POST              )   ) { $err = $db->simpleSQLExecute($tb_post_schm             ,true); echo 'table 생성===> ' . TBL_POST            . join($err,'<BR>') . ' <BR>';}
    echo "=================================================완료=================================================<BR>";

    //$db->simpleSQLExecute("insert into test (a) values ('김지훈');");

    
    $sql  = "INSERT INTO " . TBL_MEMBER
          . " ( \n"
          . " USER_NO,\n"
          . " USER_ID     ,USER_LEVEL  ,PASSWD      ,\n"
          . " USER_NAME   ,NICK_NAME   ,COMPANY_NAME,SEX         ,\n"
          . " E_MAIL      ,\n"
          . " JUMIN_NO    ,COMPANY_NO  ,\n"
          . " TEL1        ,TEL2        ,TEL3        ,TEL4        ,\n"
          . " ADDRESS1    ,ADDRESS2    ,POST_NO     ,\n"
          . " EMAIL_YN    ,ACCESS_CNT  ,\n"
          . " REG_DATE    ,ACC_DATE    ,STATE\n"
          . " ) VALUES (\n"
          . " '" . $db->getInsertId('USER_NO'). "',\n"
          . " '" . strtolower('admin') . "','9','1',\n"
          . " '관리자' ,'관리자','티센엘리베이터','1',\n"
          . " 'rete73@nate.com' ,\n"
          . " 'xxxxxxxxxxxxx' ,'xxxxxxxxxx',\n"
          . " '02-2682-7211' ,'011-9071-7218','','',\n"
          . " '경기도 광명시 광명3동' ,'159-42','423-013',\n"
          . " 'Y' ,'0',\n"
          . " sysdate,null,'U'\n"
          . " )";
    //echo "<textarea>" . $sql. "</textarea>";
    $err = $db->simpleSQLExecute($sql);
    if ( !empty($err) ) {
        echo 'ERROR|' . $err["code"] . ' / '. $err["message"];
    } else {
        echo 'SUCCESS';
    }
    echo "</DIV>";
}
//}
$db->release();
//}
?>