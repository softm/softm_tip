<?
include_once ( 'common/lib.inc'          ); // ���� ���̺귯��
include_once ( 'common/message.inc'      ); // ���� ������ ó��
include_once ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
include_once ( 'common/_service.inc'     ); // ���� ȭ�� ����
include_once ( 'common/file.inc'         ); // ���� �ý��� ����
include_once ( 'common/lib/var/table.inc'); // ���̺� ���� ����

function fieldCheck($tableName,$fieldName) {
    global $db;
    $exist = true;
    if ( isTable($tableName) ) {
        $stmt = multiRowSQLQuery("show fields from $tableName;");
        while ( $row = multiRowFetch  ($stmt) ) {
            $field   = $row['Field'   ];
            if ( strtolower ($field) == $fieldName ) {
                $exist = true ;
                break;
            } else {
                $exist = false;
            }
        }
    }
    return $exist;
}

function indexCheck($tableName,$fieldName) {
    global $db;
    $exist = true;
    if ( isTable($tableName) ) {
        $stmt = multiRowSQLQuery("show index from $tableName;");
        while ( $row = multiRowFetch  ($stmt) ) {
            $field   = $row['Key_name'   ];
            if ( strtolower ($field) == $fieldName ) {
                $exist = true ;
                break;
            } else {
                $exist = false;
            }
        }
    }
    return $exist;
}

if ( $config ) {
    $memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
    if ( $memInfor['member_level'] == 99 ) {
        if ( $execute_yn == 'Y' ) {
            set_time_limit ( 0 );
            $boardMemberLevelUpdate = false; // �Խ��� ȸ�� ���� �ݿ�

            // �����ͺ��̽��� �����մϴ�.
            $db = initDBConnection (); // �����ͺ��̽��� �����մϴ�.

/* 1.01 ���� ------------------------------------------------ ���� */
			if ( (float) $_dboard_ver_str <= 1.01 ) {
				// bbs_id
				$exist = fieldCheck($tb_bbs_grant,'bbs_id');
				if ( !$exist ) {
					echo '<font color="red">�Խ��� ���� �ʵ� ������ (�Խ��� ���̵�) �߰��Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_grant . " add (bbs_id VARCHAR (40) NOT NULL);");   /* �Խ��� ���̵�*/
				}
				// grant_answer
				$exist = fieldCheck($tb_bbs_grant,'grant_answer');
				if ( !$exist ) {
					echo '<font color="red">�Խ��� ���� �ʵ� ������ (�亯 ����) �߰��Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_grant . " add (grant_answer CHAR (1));");   /* �亯����     */
				}

				// grant_comment
				$exist = fieldCheck($tb_bbs_grant,'grant_comment');
				if ( !$exist ) {
					echo '<font color="red">�Խ��� ���� �ʵ� ������ (�ǰ߱� ����) �߰��Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_grant . " add (grant_comment CHAR (1));");   /* �ǰ߱�����     */
				}

				// grant_down
				$exist = fieldCheck($tb_bbs_grant,'grant_down');
				if ( !$exist ) {
					echo '<font color="red">�Խ��� ���� �ʵ� ������ (�ٿ� ����) �߰��Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_grant . " add (grant_down CHAR (1));");   /* �ٿ�����     */
				}

				// operator_id
				$exist = fieldCheck($tb_bbs_infor,'operator_id');
				if ( !$exist ) {
					echo '<font color="red">�Խ��� ������ (��ھ��̵�) �߰� �Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_infor . " add (operator_id VARCHAR (255));");   /* ī�װ� ���� */
				}
			}
/* 1.01 ���� ------------------------------------------------ �� */

/* 2.09 ���� ------------------------------------------------ ���� */
			if ( (float) $_dboard_ver_str <= 2.09 ) {
				// use_category
				$exist = fieldCheck($tb_bbs_infor,'use_category');
				if ( !$exist ) {
					echo '<font color="red">�Խ��� ����(ī�װ�) ����Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_infor . " add (use_category CHAR (1) DEFAULT 'N');");   /* ī�װ� ���� */
				}

				// cat_no
				$exist = fieldCheck($tb_bbs_abstract,'cat_no');
				if ( !$exist ) {
					echo '<font color="red">�Խ��� ���� ������(ī�װ�) ����Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_abstract . " add (use_category CHAR(1) DEFAULT 'N');");   /* ī�װ� ��� ���� */
					simpleSQLExecute('alter table ' . $tb_bbs_abstract . " add (cat_no       INT (4) DEFAULT '0');");   /* ī�װ� ��ȣ      */
				}

				// ȸ�� ���� �׸� ������ ���� home
				$exist = fieldCheck($tb_member, 'home');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (home VARCHAR (255) );");   /* ī�װ� ���� */
				}

				// ȸ�� ������ ������ ���� home
				$exist = fieldCheck($tb_member_config, 'home');

				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ���� ����Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (home CHAR (1) NOT NULL);");   /* ī�װ� ���� */
				}
			}
/* 2.09 ���� ------------------------------------------------ �� */

/* 3.01 ���� ------------------------------------------------ ���� */
			if ( (float) $_dboard_ver_str <= 3.01 ) {
				// �Խ��� ����Ʈ ���� ���̺�
				$tb_point_infor  = 'kyh_point_infor'  ; /* ����Ʈ ����          */
				if ( !isTable($tb_point_infor) ) {
					echo '<font color="red">�Խ��� ����Ʈ ���� ���̺��� �����Ǿ����ϴ�.</font><BR>';
					/* �Խ��� ����Ʈ ���� */
					$tb_point_infor_schm  = "CREATE  TABLE  $tb_point_infor (";
					$tb_point_infor_schm .= "    no              INT     (10 )       NOT NULL    , /* ����Ʈ ��ȣ  */";
					$tb_point_infor_schm .= "    bbs_id          VARCHAR (40 )       NOT NULL    , /* �Խ��� ���̵�*/";
					$tb_point_infor_schm .= "    member_level    INT     (2  )       NOT NULL    , /* ȸ�� ����    */";
					$tb_point_infor_schm .= "    use_st          INT     (1  )       NOT NULL    , /* ��� ����    */";
					$tb_point_infor_schm .= "    point           INT     (10 )       DEFAULT '0' , /* ����Ʈ ����  */";
					$tb_point_infor_schm .= "    etc             VARCHAR (255)                   , /* ���         */";
					$tb_point_infor_schm .= "    reg_date        CHAR    (14 )       NOT NULL    , /* ���� ����    */";
					$tb_point_infor_schm .= "    primary key (no, bbs_id, member_level)          ,";
					$tb_point_infor_schm .= "  KEY idx_point_infor (use_st) /* �ε��� ���� */";
					$tb_point_infor_schm .= ") ;";
					simpleSQLExecute($tb_point_infor_schm);   /* ����Ʈ ���� */
				}
				// ���� ����Ʈ ���� ���̺�
				$tb_poll_point_infor  = 'kyh_poll_point_infor'  ; /* ����Ʈ ����          */
				if ( !isTable($tb_poll_point_infor) ) {
					echo '<font color="red">���� ����Ʈ ���� ���̺��� �����Ǿ����ϴ�.</font><BR>';
					/* ���� ����Ʈ ���� */
					$tb_poll_point_infor_schm  = "CREATE  TABLE  $tb_poll_point_infor (";
					$tb_poll_point_infor_schm .= "    no              INT     (10 )       NOT NULL    , /* ����Ʈ ��ȣ  */";
					$tb_poll_point_infor_schm .= "    poll_no         INT     (10 )       NOT NULL    , /* ���� ��ȣ    */";
					$tb_poll_point_infor_schm .= "    member_level    INT     (2  )       NOT NULL    , /* ȸ�� ����    */";
					$tb_poll_point_infor_schm .= "    use_st          INT     (1  )       NOT NULL    , /* ��� ����    */";
					$tb_poll_point_infor_schm .= "    point           INT     (10 )       DEFAULT '0' , /* ����Ʈ ����  */";
					$tb_poll_point_infor_schm .= "    etc             VARCHAR (255)                   , /* ���         */";
					$tb_poll_point_infor_schm .= "    reg_date        CHAR    (14 )       NOT NULL    , /* ���� ����    */";
					$tb_poll_point_infor_schm .= "    primary key (no, poll_no, member_level)          ,";
					$tb_poll_point_infor_schm .= "  KEY idx_poll_point_infor (use_st) /* �ε��� ���� */";
					$tb_poll_point_infor_schm .= ") ;";
					simpleSQLExecute($tb_poll_point_infor_schm);   /* ����Ʈ ���� */
				}
				if ( !is_dir ( "./data/member" ) ) {
					@mkdir("./data/member"    ,0707);
					@chmod("./data/member"    ,0707);
					echo '<font color="red">ȸ�� ������ ���丮�� ���� �Ǿ����ϴ�.[ /data/member ]</font><BR>';

				}

				if ( !is_dir ( "./data/member/picture" ) ) {
					@mkdir("./data/member/picture"    ,0707);
					@chmod("./data/member/picture"    ,0707);
					echo '<font color="red">ȸ�� ���� ���丮�� ���� �Ǿ����ϴ�.[ /data/member/picture ]</font><BR>';
				}

				if ( !is_dir ( "./data/member/character" ) ) {
					@mkdir("./data/member/character"    ,0707);
					@chmod("./data/member/character"    ,0707);
					echo '<font color="red">ȸ�� ĳ���� ���丮�� ���� �Ǿ����ϴ�.[ /data/member/character ]</font><BR>';
				}

				$exist = fieldCheck($tb_bbs_infor, 'grant_character_image');
				if ( !$exist ) {
					echo '<font color="red">�Խ��� ������ �߰� �Ǿ����ϴ�.[ grant_character_image ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_infor . " add ( grant_character_image VARCHAR (255) DEFAULT '0111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111' );");   /* ȸ�� ������ */
				}

				$exist = fieldCheck($tb_member, 'point');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�. [ point ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (point               INT     (11)    DEFAULT '0');");   /* ����Ʈ ���� */
				}

				$exist = fieldCheck($tb_member, 'user_id_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ user_id_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (user_id_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* ���̵�  ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'member_level_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ member_level_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (member_level_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* ȸ�� ����  ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'name_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ name_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (name_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* �̸�       ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'sex_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ sex_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (sex_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* ����       ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'e_mail_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ e_mail_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (e_mail_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* �̸���     ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'home_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ home_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (home_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* Ȩ������   ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'tel_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ tel_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (tel_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* ��ȭ��ȣ   ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'address_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ address_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (address_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* �ּ�       ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'post_no_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ post_no_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (post_no_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* �����ȣ   ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'point_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ point_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (point_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* ����Ʈ     ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'picture_image_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ picture_image_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (picture_image_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* ����   ����     : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'character_image_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�.[ character_image_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (character_image_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* ������ ����  : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member_kind, 'point');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ���� ���� ����Ǿ����ϴ�. [ point ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_kind . " add (point               INT     (10)       DEFAULT 1 );");   /* ����Ʈ ���� */
				}

				$exist = fieldCheck($tb_member_config, 'news_point');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ���� ����Ǿ����ϴ�. [ news_point ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (news_point        INT     (10)    DEFAULT 500 );");   /* �������� ���� ������ ���� */
				}


				$exist = fieldCheck($tb_member_config, 'point_yn');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ���� ����Ǿ����ϴ�. [ point_yn ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (point_yn               CHAR    (1)     NOT NULL DEFAULT 'Y');");   /* ������ ǥ�� */
				}

				$exist = fieldCheck($tb_member_config, 'point');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ���� ����Ǿ����ϴ�. [ point ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (point               INT     (10)    DEFAULT 1000 );");   /* ������ ���� */
				}

				$exist = fieldCheck($tb_member_config, 'picture_image');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ���� ����Ǿ����ϴ�.[ picture_image ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (picture_image           CHAR    (1)     NOT NULL DEFAULT 'Y');");   /* ���� ǥ�� */
				}

				$exist = fieldCheck($tb_member_config, 'character_image');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ���� ����Ǿ����ϴ�.[ character_image ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (character_image         CHAR    (1)     NOT NULL DEFAULT 'Y');");   /* ĳ���� ǥ�� */
				}

				// ���� ���� ���̺� ���� �� ����
				$sql = "select no, title from $tb_poll_master;";
				$stmt = multiRowSQLQuery($sql);
				while ( $row = multiRowFetch  ($stmt) ) {
					$stmt_kind = multiRowSQLQuery("select member_level, member_nm from $tb_member_kind;");
					while ( $row_kind = multiRowFetch  ($stmt_kind) ) {
						$memberLevel = $row_kind['member_level'];
						$memberNm    = $row_kind['member_nm'   ];
						$exist = simpleSQLQuery("select count(no) from $tb_poll_grant where no = " . $row['no'] . " and member_level = '$memberLevel'");
						if ( !$exist ) {
							$sql  = "insert into $tb_poll_grant ( no, member_level, grant_poll, grant_poll_result, grant_write ) ";
							if ( $memberLevel == 0 || $memberLevel == 1 || $memberLevel == 99 ) { // [ �⺻ ȸ�� ���� ] ��ȸ��, �Ϲ�ȸ��, ������
								$sql .= "values (" . $row['no'] . " , $memberLevel, 'Y', 'Y', 'Y' );";
							} else {
								/* ---- ��ϱ��� �б���� ������� ��۱��� �ǰ߱۱��� �ٿ���� ---- */
								$sql .= "values (" . $row['no'] . " , $memberLevel, 'Y', 'Y', 'Y' );";
							}
							simpleSQLExecute($sql);
						}
						if ( $memberLevel > 0 ) { // ��ȸ���� �ƴϸ�.
							// ����
							// $pointInfor = array("","������ǥ", "�ǰ߱�");
							$existChk = true;
							for ( $i=1; $i <= 2;$i++) {
								$chkSql  = "select count(no) from $tb_poll_point_infor ";
								$chkSql .= " where  no           = '" . $i             . "'";
								$chkSql .= " and    poll_no      = '" . $row['no']     . "'";
								$chkSql .= " and    member_level = '" . $memberLevel   . "'";
								$existChk = simpleSQLQuery($chkSql);
								if ( !$existChk ) {
									/* ����Ʈ ����     */
									$sql  = "insert into $tb_poll_point_infor ( ";
									$sql .= " no, poll_no, member_level, use_st, point, etc, reg_date";
									$sql .= " ) values ( ";
									$sql .= "'" . $i                . "',";
									$sql .= "'" . $row['no']        . "',";
									$sql .= "'" . $memberLevel      . "',";
									$sql .= "'1'                        ,"; // ��� : 1, �̻�� : 2
									$sql .= " 1                         ,"; // ����Ʈ
									$sql .= "''                         ,";
									$sql .= "'" . getYearToSecond() . "'" ;
									$sql .= ");";
									simpleSQLExecute($sql);
								}
							}
							if ( !$existChk ) {
								echo '<font color="black">' . $row['title'] .' ���� ' . $memberNm . ' ����Ʈ ������ �����Ǿ����ϴ�..</font><BR>';
							}
						}
					}
				}

				$exist = fieldCheck($tb_poll_master, 'use_top');
				if ( !$exist ) {
					echo '<font color="red">���� ���� ��������Ǿ����ϴ�.[ use_top ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_poll_master . " add (use_top             CHAR    (1)     DEFAULT 'Y');");   /* �׻� �ֱ� �������� ���� */
				}

				$exist = fieldCheck($tb_poll_master, 'poll_process');
				if ( !$exist ) {
					echo '<font color="red">���� ���� ��������Ǿ����ϴ�.[ poll_process ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_poll_master . " add (poll_process	     CHAR	 (1  )	 DEFAULT '1');");   /* ��ǥ�� ó�� ������ : '1' : ���������, '2' : ��������������, '3' : url�Է� */
				}

				$exist = fieldCheck($tb_poll_master, 'suc_url');
				if ( !$exist ) {
					echo '<font color="red">���� ���� ��������Ǿ����ϴ�.[ suc_url ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_poll_master . " add (suc_url             VARCHAR (255));");   /* ���� �̵� ������ */
				}

				if ( (float) $_dboard_ver_str <= 3.01 ) {
					$exist = fieldCheck($tb_poll_master, 'display_mode');
					if ( $exist ) {
						echo '<font color="red">���� ���� ��������Ǿ����ϴ�.[ display_mode ]</font><BR>';
						simpleSQLExecute('alter table ' . $tb_poll_master . " modify display_mode        CHAR    (1  )   DEFAULT '2';");   /* ���� �̵� ������ */
					}
				}

				$exist = fieldCheck($tb_poll_master, 'grant_character_image');
				if ( !$exist ) {
					echo '<font color="red">���� ���� ��������Ǿ����ϴ�.[ grant_character_image ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_poll_master . " add ( grant_character_image VARCHAR (255) DEFAULT '0111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111' );");   /* ȸ�� ������ */
				}

				// �̺�Ʈ ���� ���̺� ���� �� ����
				$tb_event      = 'kyh_event'        ;
				$tb_event_item = 'kyh_event_item'   ; /* �̺�Ʈ �׸�          */
				$exist = fieldCheck($tb_event,'display_mode');
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ ���� �ʵ尡 �߰� �Ǿ����ϴ�. [ display_mode ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (display_mode    CHAR    (1  )       DEFAULT '1' );");   /* �̺�Ʈ ǥ������    */
				}

				$exist = fieldCheck($tb_event,'use_top');
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ ���� �ʵ尡 �߰� �Ǿ����ϴ�. [ use_top ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (use_top         CHAR    (1  )       DEFAULT 'N' );");   /* �׻� �ֱ� �̺�Ʈ�� ���� */
				}

				$exist = fieldCheck($tb_event,'scroll_yn');
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ ���� �ʵ尡 �߰� �Ǿ����ϴ�. [ scroll_yn ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (scroll_yn       CHAR    (1  )       DEFAULT 'Y' );");   /* �˾� ��ũ�� ���� */
				}

			}
/* 3.01 ���� ------------------------------------------------ �� */

/* 3.22 ���� ------------------------------------------------ ���� */
			if ( (float) $_dboard_ver_str <= 3.22 ) {
				// �̺�Ʈ ����
				if ( !is_dir ( "./data/event" ) ) {
					@mkdir("./data/event"    ,0707);
					@chmod("./data/event"    ,0707);
					echo '<font color="red">�̺�Ʈ ������ ���丮�� ���� �Ǿ����ϴ�.[ /data/event ]</font><BR>';
				}

				// �Խ��� ���� title_limit [ 3.22 ���� ���� ����� ]
				$exist = fieldCheck($tb_event,'title_limit');
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ ������ �߰��Ǿ����ϴ�.[ title_limit ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (title_limit          INT     (3  )       DEFAULT 30);");
				}

				// �Խ��� ���� suc_url [ 3.22 ���� ���� ����� ]
				$exist = fieldCheck($tb_event,'suc_url');
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ ������ �߰��Ǿ����ϴ�.[ suc_url ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (suc_url              VARCHAR (255));");
				}

				// �Խ��� ���� scroll_yn [ 3.22 ���� ���� ����� ]
				$exist = fieldCheck($tb_event,'scroll_yn');
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ ������ �߰��Ǿ����ϴ�.[ scroll_yn ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (scroll_yn            CHAR    (1  )       DEFAULT 'Y');");
				}

				// �Խ��� ���� base_path [ 3.22 ���� ���� ����� ]
				$exist = fieldCheck($tb_event,'base_path');
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ ������ �߰��Ǿ����ϴ�.[ base_path ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (base_path            VARCHAR (255));");
				}

				// �Խ��� ���� login_skin_name [ 3.22 ���� ���� ����� ]
				$exist = fieldCheck($tb_event,'login_skin_name');
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ ������ �߰��Ǿ����ϴ�.[ login_skin_name ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (login_skin_name      VARCHAR (40 )       NOT NULL);");
				}

				// �Խ��� ���� use_default_login [ 3.22 ���� ���� ����� ]
				$exist = fieldCheck($tb_event,'use_default_login');
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ ������ �߰��Ǿ����ϴ�.[ use_default_login ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (use_default_login    CHAR    (1  )       DEFAULT 'Y');");
				}

				// �Խ��� ���� reg_date [ 3.22 ���� ���� ����� ]
				$exist = fieldCheck($tb_event,'reg_date');
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ ������ �߰��Ǿ����ϴ�.[ reg_date ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (reg_date             CHAR    (14 )       NOT NULL);");
				}

				// �̺�Ʈ �׸� ���� o_seq
				$exist = fieldCheck($tb_event_item, 'o_seq'  );
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ �׸� ���� ����Ǿ����ϴ�. [ o_seq ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_event_item . " add (o_seq           INT     (4  ));");   /* ���� ���� */
				}
				// �̺�Ʈ �׸� ���� seq
				$exist = fieldCheck($tb_event_item, 'seq'  );
				if ( !$exist ) {
					echo '<font color="red">�̺�Ʈ �׸� ���� ����Ǿ����ϴ�. [ seq ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_event_item . " add (seq             INT     (4  )       NOT NULL);");   /* ���� */
				}
				if ( (float) $_dboard_ver_str <= 3.22 ) {
					if ( isTable($tb_event_item) ) {
						echo '<font color="red">�̺�Ʈ �׸� ���̺� ���� ����Ǿ����ϴ�. [ KEY ���� ] </font><BR>';
						simpleSQLExecute('alter table ' . $tb_event_item . " drop PRIMARY KEY;");   /* ���� ���� */
						echo '<font color="red">�̺�Ʈ �׸� ���̺� ���� ����Ǿ����ϴ�. [ KEY ���� : no, g_no, seq ] </font><BR>';
						simpleSQLExecute('alter table ' . $tb_event_item . " add  PRIMARY KEY (no,g_no,seq);");   /* ���� ���� */
					}
				}
				if ( !isTable($tb_event) ) {
					echo '<font color="red">�̺�Ʈ ���� ���̺��� �����Ǿ����ϴ�.</font><BR>';
					/* �̺�Ʈ ���� */
					$tb_event_schm  = "CREATE  TABLE  $tb_event (";
					$tb_event_schm .= "    no                   INT     (10 )       NOT NULL    , /* �̺�Ʈ ��ȣ             */";
					$tb_event_schm .= "    title                VARCHAR (255)       NOT NULL    , /* �̺�Ʈ ����             */";
					$tb_event_schm .= "    display_mode         CHAR    (1  )       DEFAULT '1' , /* �̺�Ʈ ǥ������         */";
					$tb_event_schm .= "    title_limit          INT     (3  )       DEFAULT 30  , /* ����������� (��)       */";
					$tb_event_schm .= "    suc_url              VARCHAR (255)                   , /* ���� �̵� ������        */";
					$tb_event_schm .= "    use_top              CHAR    (1  )       DEFAULT 'N' , /* �׻� �ֱ� �̺�Ʈ�� ���� */";
					$tb_event_schm .= "    start_date           CHAR    (14 )                   , /* �̺�Ʈ ������           */";
					$tb_event_schm .= "    end_date             CHAR    (14 )                   , /* �̺�Ʈ ������           */";
					$tb_event_schm .= "    window_width         INT     (4  )                   , /* �̺�Ʈ â ����          */";
					$tb_event_schm .= "    window_height        INT     (4  )                   , /* �̺�Ʈ â ����          */";
					$tb_event_schm .= "    left_pos             INT     (4  )                   , /* �̺�Ʈ â X ��ǥ        */";
					$tb_event_schm .= "    top_pos              INT     (4  )                   , /* �̺�Ʈ â Y ��ǥ        */";
					$tb_event_schm .= "    scroll_yn            CHAR    (1  )       DEFAULT 'Y' , /* �˾� ��ũ�� ����        */";
					$tb_event_schm .= "    base_path            VARCHAR (255)                   , /* ��� ���丮           */";
					$tb_event_schm .= "    login_skin_name      VARCHAR (40 )       NOT NULL    , /* �α��� ��Ų ��          */";
					$tb_event_schm .= "    use_default_login    CHAR    (1  )       DEFAULT 'Y' , /* �⺻ �α��� ��뿩��    */";
					$tb_event_schm .= "    reg_date             CHAR    (14 )       NOT NULL    , /* �̺�Ʈ ���� ����        */";
					$tb_event_schm .= "    primary key (no)";
					$tb_event_schm .= ") ;";
					simpleSQLExecute($tb_event_schm);   /* �̺�Ʈ ���� */
				}

				$tb_event_grant  = 'kyh_event_grant'  ; /* �̺�Ʈ ����          */
				if ( !isTable($tb_event_grant) ) {
					echo '<font color="red">�̺�Ʈ ���� ���̺��� �����Ǿ����ϴ�.</font><BR>';
					/* �̺�Ʈ ���� */
						$tb_event_grant_schm  = "CREATE  TABLE  $tb_event_grant (";
						$tb_event_grant_schm .= "    no              INT     (10 )       NOT NULL    , /* �̺�Ʈ ��ȣ    */";
						$tb_event_grant_schm .= "    member_level    INT     (2  )       NOT NULL    , /* ȸ�� ����      */";
						$tb_event_grant_schm .= "    grant_join      CHAR    (1  )                   , /* ����           */";
						$tb_event_grant_schm .= "    join_point      INT     (10 )                   , /* ����Ʈ ����    */";
						$tb_event_grant_schm .= "    primary key (no ,member_level)";
						$tb_event_grant_schm .= ") ;";
					simpleSQLExecute($tb_event_grant_schm);   /* �̺�Ʈ ���� */
				}

				if ( !isTable($tb_event_item) ) {
					echo '<font color="red">�̺�Ʈ �׸� ���̺��� �����Ǿ����ϴ�.</font><BR>';
					/* �̺�Ʈ �׸� */
					$tb_event_item_schm  = "CREATE  TABLE  $tb_event_item(";
					$tb_event_item_schm .= "    no              INT     (10 )       NOT NULL    , /* �̺�Ʈ ��ȣ        */";
					$tb_event_item_schm .= "    g_no            INT     (4  )       NOT NULL    , /* �̺�Ʈ �׷� ��ȣ   */";
					$tb_event_item_schm .= "    seq             INT     (4  )       NOT NULL    , /* �׸� ����          */";
					$tb_event_item_schm .= "    o_seq           INT     (4  )                   , /* ���� ����          */";
					$tb_event_item_schm .= "    item            CHAR    (1  )                   , /* �׸�� ����        */";
					$tb_event_item_schm .= "    item_name       VARCHAR (255)                   , /* �׸� ��            */";
					$tb_event_item_schm .= "    primary key (no, g_no, seq)";
					$tb_event_item_schm .= ") ;";
					simpleSQLExecute($tb_event_item_schm);   /* �̺�Ʈ �׸� */
				}

				$tb_event_result_master = "kyh_event_result_master"; /* �̺�Ʈ ��� ���� */
				if ( !isTable($tb_event_result_master) ) {
					echo '<font color="red">�̺�Ʈ ��� ���� ���̺��� �����Ǿ����ϴ�.</font><BR>';
					/* �̺�Ʈ ��� ���� */
					$tb_event_result_master_schm  = "CREATE  TABLE  $tb_event_result_master(";
					$tb_event_result_master_schm .= "    no              INT     (10 )       NOT NULL    , /* �̺�Ʈ ��ȣ    */";
					$tb_event_result_master_schm .= "    user_id         VARCHAR (20 )       NOT NULL    , /* ����� ID      */";
					$tb_event_result_master_schm .= "    prize_yn        CHAR    (1  )                   , /* ��÷ ����      */";
					$tb_event_result_master_schm .= "    prize_point     INT     (10 )                   , /* ��÷ ����Ʈ    */";
					$tb_event_result_master_schm .= "    join_date       CHAR    (14 )       NOT NULL    , /* ���� ����      */";
					$tb_event_result_master_schm .= "    primary key (no ,user_id )";
					$tb_event_result_master_schm .= ") ;";
					simpleSQLExecute($tb_event_result_master_schm);   /* �̺�Ʈ ��� ���� */
				}

				$tb_event_result_detail = "kyh_event_result_detail"; /* �̺�Ʈ ��� �� */
				if ( !isTable($tb_event_result_detail) ) {
					echo '<font color="red">�̺�Ʈ ��� �� ���̺��� �����Ǿ����ϴ�.</font><BR>';
					/* �̺�Ʈ ��� �� */
					$tb_event_result_detail_schm  = "CREATE  TABLE  $tb_event_result_detail(";
					$tb_event_result_detail_schm .= "    no              INT     (10 )       NOT NULL    , /* �̺�Ʈ ��ȣ       */";
					$tb_event_result_detail_schm .= "    user_id         VARCHAR (20 )       NOT NULL    , /* ����� ID         */";
					$tb_event_result_detail_schm .= "    g_no            INT     (4  )       NOT NULL    , /* �̺�Ʈ �׷� ��ȣ  */";
					$tb_event_result_detail_schm .= "    key_seq         INT     (4  )       NOT NULL    , /* ����              */";
					$tb_event_result_detail_schm .= "    choice_data     TEXT                            , /* ���õ� ��         */";
					$tb_event_result_detail_schm .= "    primary key (no, user_id, g_no, key_seq)";
					$tb_event_result_detail_schm .= ") ;";
					simpleSQLExecute($tb_event_result_detail_schm);   /* �̺�Ʈ ��� ���� */
				}

				$tb_login_abstract = "kyh_login_abstract"; /* �α��� ���� */
				if ( !isTable($tb_login_abstract) ) {
					echo '<font color="red">�α��� ���� ���̺��� �����Ǿ����ϴ�.</font><BR>';
					/* �α��� ���� */
					$tb_login_abstract_schm  = "CREATE  TABLE  $tb_login_abstract (";
					$tb_login_abstract_schm .= "    skin_no          INT     (10)                    , /* ��Ų ��ȣ         */";
					$tb_login_abstract_schm .= "    skin_name        VARCHAR (40)    NOT NULL        , /* ��Ų ��           */";
					$tb_login_abstract_schm .= "    display_mode     CHAR    (1)     DEFAULT '1'     , /* ȭ�� ����         */";
					$tb_login_abstract_schm .= "    window_width     INT     (4  )                   , /* �˾� â ����      */";
					$tb_login_abstract_schm .= "    window_height    INT     (4  )                   , /* �˾� â ����      */";
					$tb_login_abstract_schm .= "    left_pos         INT     (4  )                   , /* �˾� â X ��ǥ    */";
					$tb_login_abstract_schm .= "    top_pos          INT     (4  )                   , /* �˾� â Y ��ǥ    */";
					$tb_login_abstract_schm .= "    scroll_yn        CHAR    (1)     DEFAULT 'Y'     , /* �˾� ��ũ�� ����  */";
					$tb_login_abstract_schm .= "    suc_mode         CHAR    (1)     DEFAULT '1'     , /* ���� ���� ����    */";
					$tb_login_abstract_schm .= "    suc_url          VARCHAR (255)                   , /* ���� �̵� ������  */";
					$tb_login_abstract_schm .= "    message          VARCHAR (255)                   , /* �˸����� �޼���   */";
					$tb_login_abstract_schm .= "    base_path        VARCHAR (255)                   , /* ��� ���丮     */";
					$tb_login_abstract_schm .= "    upd_date         CHAR    (14)    NOT NULL          /* ���� ����         */";
					$tb_login_abstract_schm .= ") ;";
					simpleSQLExecute($tb_login_abstract_schm);   /* �α��� ���� */
					$sql  = "insert into $tb_login_abstract ( skin_no, skin_name, display_mode, window_width, window_height, left_pos, top_pos, scroll_yn, suc_mode, suc_url, message, base_path, upd_date ) values ( ";
					$sql .= "'0', 'dlogin_standard', '1', '800', '600', '0', '0', 'Y', '1', '', '', '', '' );";
					simpleSQLExecute($sql);   /* �α��� ���� �Է� */
				}

				if ( @is_dir ( 'skin/out_login' ) ) {
					@rename ( 'skin/out_login', 'skin/login' );
					echo '<font color="red">�α��� ��Ų ���丮���� ����Ǿ����ϴ�. out_login ==> login</font><BR>';
				}

				if ( @is_file ( 'doutlogin.php' ) ) {
					@rename ( 'doutlogin.php', 'dlogin.php' );
					echo '<font color="red">�α��� ���α׷����� ����Ǿ����ϴ�. doutlogin.php ==> dlogin.php</font><BR>';
				}

				if ( @is_file ( 'common/outlogin_setup_default.inc' ) ) {
					@rename ( 'common/outlogin_setup_default.inc', 'common/login_setup_default.inc' );
					echo '<font color="red">�α��� �¾� ���α׷����� ����Ǿ����ϴ�. outlogin_setup_default.inc ==> login_setup_default.inc</font><BR>';
				}

				$f=@file($baseDir . "config.php");
				$driver     = trim(str_replace("\n","",$f[1]));
				$host_nm    = trim(str_replace("\n","",$f[2]));
				$db_nm      = trim(str_replace("\n","",$f[3]));
				$id         = trim(str_replace("\n","",$f[4]));
				$password   = trim(str_replace("\n","",$f[5]));
				$base_dir   = trim(str_replace("\n","",$f[6]));
				$setup_dir  = trim(str_replace("\n","",$f[7]));
				$login_skin = 'dlogin_standard';
				if ( $f[8] == "?>" ) {
					echo '<font color="red">���� ������ �߰��Ǿ����ϴ�. config.php <<== dlogin_standard</font><BR>';
					/* �����ͺ��̽� ���� ���� ���� */
					$setupInfor  = "<?\n";
					$setupInfor .= $driver      . "\n"; // ����̹�
					$setupInfor .= $host_nm     . "\n"; // host ��
					$setupInfor .= $db_nm       . "\n"; // db ��
					$setupInfor .= $id          . "\n"; // ����� ���̵�
					$setupInfor .= $password    . "\n"; // ����� ��й�ȣ
					$setupInfor .= $base_dir    . "\n"; // ��� ���丮
					$setupInfor .= $setup_dir   . "\n"; // ��ġ ��Ʈ
					$setupInfor .= $login_skin  . "\n"; // ���� ��Ų
					$setupInfor .= "?>";
					$fp = @fopen ( "config.php", "w") Or MessageExit('U', '0006',"");
					fwrite ( $fp, $setupInfor,strlen($setupInfor) );
					@chmod("config.php"     ,0707);
				}

				// �Խ��� ���� login_skin_name [ 3.22 ���� ���� ����� ]
				$exist = fieldCheck($tb_bbs_infor,'login_skin_name');
				if ( !$exist ) {
					echo '<font color="red">�Խ��� ������ (�α��ν�Ų) �߰��Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_infor . " add (login_skin_name VARCHAR (40)    NOT NULL );");   /* �α��� ��Ų ���� */
				}

				// �Խ��� ���� use_default_login [ 3.22 ���� ���� ����� ]
				$exist = fieldCheck($tb_bbs_infor,'use_default_login');
				if ( !$exist ) {
					echo '<font color="red">�Խ��� ������ (�⺻ �α��� ���) �߰��Ǿ����ϴ�.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_infor . " add (use_default_login CHAR    (1)     DEFAULT 'Y' );");   /* �⺻ �α��� ��뿩�� */
				}

			}
/* 3.22 ���� ------------------------------------------------ �� */

/* 3.38 ���� ------------------------------------------------ ���� */
			if ( (float) $_dboard_ver_str <= 3.38 ) {
				$exist = fieldCheck($tb_member, 'birth');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ����Ǿ����ϴ�.[ birth ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (birth                VARCHAR (14));");   /* �������   */
				}

				$exist = fieldCheck($tb_member, 'age');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ����Ǿ����ϴ�.[ age ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (age                  INT     (3 ));");   /* ����       */
				}

				$exist = fieldCheck($tb_member, 'birth_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ����Ǿ����ϴ�.[ birth_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (birth_open           CHAR    (1 )    DEFAULT 'N' NOT NULL);");   /* �������   ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'age_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ����Ǿ����ϴ�.[ age_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (age_open           CHAR    (1 )    DEFAULT 'N' NOT NULL);");   /* ����       ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member_config, 'birth');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ������ ����Ǿ����ϴ�.[ birth ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (birth               CHAR    (1)     DEFAULT 'Y' NOT NULL);");   /* ������� ǥ��      */
				}

				$exist = fieldCheck($tb_member_config, 'age');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ������ ����Ǿ����ϴ�.[ age ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (age               CHAR    (1)     DEFAULT 'Y' NOT NULL);");   /* ����     ǥ��      */
				}

				$exist = fieldCheck($tb_member_config, 'hint');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ������ ����Ǿ����ϴ�.[ hint ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (hint                CHAR    (1)     DEFAULT  'Y');");   /* ��Ʈ ǥ�� */
				}

				$exist = fieldCheck($tb_member, 'access');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ����Ǿ����ϴ�.[ access ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (access               INT     (10)    DEFAULT 0);");   /* ���� Ƚ�� */
				}

				$exist = fieldCheck($tb_member, 'access_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ����Ǿ����ϴ�.[ access_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (access_open          CHAR    (1 )    DEFAULT 'Y' NOT NULL);");   /* ���Ӽ�     ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member, 'hint');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ����Ǿ����ϴ�.[ hint ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (hint                 INT     (3 ));");   /* ��Ʈ        */
				}

				$exist = fieldCheck($tb_member, 'answer');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ����Ǿ����ϴ�.[ answer ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (answer               VARCHAR (255));");   /* ��          */
				}
			}
/* 3.38 ���� ------------------------------------------------ �� */

/* 3.41 ���� ------------------------------------------------ ���� */
			if ( (float) $_dboard_ver_str <= 3.41 ) {
				$tb_dic_member_statistic  = 'kyh_dic_member_statistic'  ; /* ȸ�� ��� */
					if ( !isTable($tb_dic_member_statistic) ) {
						echo '<font color="red">�� ȸ���� ���̺��� �����Ǿ����ϴ�.</font><BR>';
                        $tb_dic_member_statistic_schm  = "CREATE TABLE $tb_dic_member_statistic ( ";
                        $tb_dic_member_statistic_schm .= "    cnt INT     (10) /* �� ȸ���� */";
                        $tb_dic_member_statistic_schm .= ");";
						simpleSQLExecute($tb_dic_member_statistic_schm); /* ȸ�� ��� */
						simpleSQLExecute("insert into $tb_dic_member_statistic ( cnt ) values ( 0 );"); /* �� ȸ���� �ʱ�ȭ */
					}

				if ( !is_dir ( "./data/tmp" ) ) {
					@mkdir("./data/tmp"    ,0707);
					@chmod("./data/tmp"    ,0707);
					echo '<font color="red">�ӽ� ���丮�� ���� �Ǿ����ϴ�.[ /data/tmp ]</font><BR>';
				}

				$exist = fieldCheck($tb_member, 'nick_name');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ����Ǿ����ϴ�.[ nick_name ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (nick_name  VARCHAR (20));");   /* ����       */
				}

				$exist = fieldCheck($tb_member, 'nick_name_open');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ����Ǿ����ϴ�.[ nick_name_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (nick_name_open          CHAR    (1 )    DEFAULT 'Y' NOT NULL);");   /* ����   ���� : 'Y' , �������� : 'N' */
				}

				$exist = fieldCheck($tb_member_config, 'nick_name');
				if ( !$exist ) {
					echo '<font color="red">ȸ�� ������ ������ ����Ǿ����ϴ�.[ nick_name ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (nick_name          CHAR    (1)     DEFAULT 'Y' NOT NULL);");   /* ���� ǥ��      */
				}
            }
/* 3.41 ���� ------------------------------------------------ �� */

/* �Խ��� ���� ��ȯ ���� --------------------------------------------------------- ����*/
			$sql = "select no, bbs_id from $tb_bbs_infor;";
			$stmt = multiRowSQLQuery($sql);
			while ( $row = multiRowFetch  ($stmt) ) {
	/* 1.01 ���� ------------------------------------------------ ���� */
				if ( (float) $_dboard_ver_str <= 1.01 ) {
					// f_path1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_path1');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (���� ���� ���1) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_path1 VARCHAR (255));");   /* ���� ���� ���1 */
					}
					// f_name1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_name1');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (���� ���� ��1) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_name1 VARCHAR (255));");   /* ���� ���� ��1 */
					}
					// f_ext1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_ext1');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (���� Ȯ����1) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_ext1 VARCHAR (10));");   /* ���� Ȯ����1     */
					}

					// f_size1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_size1');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (���� ũ��1) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_size1 VARCHAR (10));");   /* ���� ũ��1      */
					}
					// f_date1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_date1');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (���� ���ϸ�1) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_date1 VARCHAR (10));");   /* ���� ���ϸ�1    */
					}
					// f_path2
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_path2');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (���� ���� ���2) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_path2 VARCHAR (255));");   /* ���� ���� ���2 */
					}

					// f_name2
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_name2');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (���� ���� ��2) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_name2 VARCHAR (255));");   /* ���� ���� ��2 */
					}

					// f_ext2
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_ext2');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (���� Ȯ����2) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_ext2 VARCHAR (10));");   /* ���� Ȯ����2     */
					}

					// f_size2
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_size2');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (���� ũ��2) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_size2 VARCHAR (10));");   /* ���� ũ��2      */
					}

					// f_date2
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_date2');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (���� ���ϸ�2) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_date2 VARCHAR (10));");   /* ���� ���ϸ�2    */
					}

					// down_hit1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'down_hit1');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (�ٿ�ε��1) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (down_hit1 INT (6) DEFAULT 0);");   /* �ٿ�ε��1    */
					}

					// down_hit2 [ 1.01 ���� ���� ����� ]
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'down_hit2');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (�ٿ�ε��2) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (down_hit2 INT (6) DEFAULT 0);");   /* �ٿ�ε��2    */
					}
				}
	/* 1.01 ���� ------------------------------------------------ �� */

	/* 2.09 ���� ------------------------------------------------ ���� */
				if ( (float) $_dboard_ver_str <= 2.09 ) {
					// cat_no
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'], 'cat_no');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (ī�װ�) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add ( cat_no INT (4) );");   /* ī�װ� ���� */
					}

					if ( !isTable($tb_bbs_category . "_" . $row['bbs_id']) ) {
						echo '<font color="red">�Խ��� ī�װ� ���̺��� �����Ǿ����ϴ�.</font><BR>';
						$tb_bbs_category_schm  = "CREATE TABLE $tb_bbs_category" . "_" . $row['bbs_id'] . "(";
						$tb_bbs_category_schm .= "    no                   INT         (4 )        NOT NULL    , /* ī�װ� ��ȣ      */";
						$tb_bbs_category_schm .= "    o_seq                INT         (4)                     , /* ���� ����          */";
						$tb_bbs_category_schm .= "    name                 VARCHAR     (255)                   , /* ��� ���� ���     */";
						$tb_bbs_category_schm .= "    etc                  VARCHAR     (255)                   , /* ���               */";
						$tb_bbs_category_schm .= "    primary key (no )";
						$tb_bbs_category_schm .= ") ;";
						simpleSQLExecute($tb_bbs_category_schm);   /* ī�װ� ���� */
					}
				}
	/* 2.09 ���� ------------------------------------------------ �� */

	/* 3.01 ���� ------------------------------------------------ ���� */
				if ( (float) $_dboard_ver_str <= 3.01 ) {
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'], 'member_level');
					if ( !$exist ) {
						$boardMemberLevelUpdate = false; // �ѹ��̶� ���� 3.01 ���� ����
						echo $row['bbs_id'] . ' <font color="red">�Խ��� ������ (ȸ������) �߰� �Ǿ����ϴ�. [ member_level ] </font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add ( member_level        INT     (2)     NOT NULL default 0 );");   /* ȸ�� ����          */
					} else {
						$boardMemberLevelUpdate = true ; // �ѹ��̶� ���� 3.01 ���� ����
					}
					// �Խ��� ����Ʈ ���� ���̺�
					$stmt_kind = multiRowSQLQuery("select member_level, member_nm from $tb_member_kind;");
					while ( $row_kind = multiRowFetch  ($stmt_kind) ) {
						$memberLevel = $row_kind['member_level'];
						$memberNm    = $row_kind['member_nm'   ];
						$exist = simpleSQLQuery("select count(no) from $tb_bbs_grant where no = " . $row['no'] . " and member_level = '$memberLevel'");
						if ( !$exist ) {
							$sql  = "insert into $tb_bbs_grant ( no, bbs_id, member_level, grant_list, grant_view, grant_write, grant_answer, grant_comment, grant_down ) ";
							if ( $memberLevel == 0 || $memberLevel == 1 || $memberLevel == 99 ) { // [ �⺻ ȸ�� ���� ] ��ȸ��, �Ϲ�ȸ��, ������
								$sql .= "values (" . $row['no'] . ", '$bbs_id', $memberLevel, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');";
							} else {
								/* ---- ��ϱ��� �б���� ������� ��۱��� �ǰ߱۱��� �ٿ���� ---- */
								$sql .= "values (" . $row['no'] . ", '$bbs_id', $memberLevel, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');";
							}
							simpleSQLExecute($sql);
						}

						if ( $memberLevel > 0 ) { // ��ȸ���� �ƴϸ�.
							// ����
							// $pointInfor = array("","�Խù� �ۼ�", "�ǰ߱� �ۼ�", "���� ���ε�", "�ٿ�ε�", "����ۼ�");
							$existChk = true;
							for ( $i=1; $i <= 5;$i++) {
								$chkSql  = "select count(no) from $tb_point_infor ";
								$chkSql .= " where  no           = '" . $i             . "'";
								$chkSql .= " and    bbs_id       = '" . $row['bbs_id'] . "'";
								$chkSql .= " and    member_level = '" . $memberLevel   . "'";
								$existChk = simpleSQLQuery($chkSql);
								if ( !$existChk ) {
									/* ����Ʈ ����     */
									$sql  = "insert into $tb_point_infor ( ";
									$sql .= " no, bbs_id, member_level, use_st, point, etc, reg_date";
									$sql .= " ) values ( ";
									$sql .= "'" . $i                . "',";
									$sql .= "'" . $row['bbs_id']    . "',";
									$sql .= "'" . $memberLevel      . "',";
									$sql .= "'1'                        ,"; // ��� : 1, �̻�� : 2
									$sql .= " 1                         ,"; // ����Ʈ
									$sql .= "''                         ,";
									$sql .= "'" . getYearToSecond() . "'" ;
									$sql .= ");";
									simpleSQLExecute($sql);
								}
							}
							if ( !$existChk ) {
								echo '<font color="black">' . $row['bbs_id'] .' �Խ��� ' . $memberNm . ' ����Ʈ ������ �����Ǿ����ϴ�..</font><BR>';
							}
						}
					}
					// �Խ��ǵ����� ���̺� ȸ�� ���� �ݿ�
					if ( !$boardMemberLevelUpdate ) {
						$sql = "select distinct user_id from $tb_bbs_data" . "_" . $row['bbs_id'];
						$bbs_data_stmt = multiRowSQLQuery($sql);
						while ( $bbs_data_row = multiRowFetch  ($bbs_data_stmt) ) {
							$sql_member = "select member_level from $tb_member where user_id = '" . $bbs_data_row['user_id'] . "'" ;
							$memberLevel = simpleSQLQuery($sql_member);
							if ( $bbs_data_row['user_id'] ) {
								$updateSql  = "update kyh_bbs_data_" . $row['bbs_id'];
								$updateSql .= " set member_level = '" . $memberLevel . "'";
								$updateSql .= " where user_id = '" . $bbs_data_row['user_id'] . "';";
								simpleSQLExecute($updateSql);
							}
						}
						echo '<font color="black">' . $row['bbs_id'] .' �Խ��� ȸ�� ������ ���ŵǾ����ϴ�.</font><BR>';
					}
				}
	/* 3.01 ���� ------------------------------------------------ �� */

	/* 3.38 ���� ------------------------------------------------ ���� */
				if ( (float) $_dboard_ver_str <= 3.38 ) {
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'], 'link1');
					if ( !$exist ) {
						$boardMemberLevelUpdate = false; // �ѹ��̶� ���� 3.38 ���� ����
						echo $row['bbs_id'] . ' <font color="red">�Խ��� ������ (��ũ1) �߰� �Ǿ����ϴ�. [ link1 ] </font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add ( link1               VARCHAR (255));");   /* ��ũ1 */
					}
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'], 'link2');
					if ( !$exist ) {
						$boardMemberLevelUpdate = false;
						echo $row['bbs_id'] . ' <font color="red">�Խ��� ������ (��ũ1) �߰� �Ǿ����ϴ�. [ link2 ] </font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add ( link2               VARCHAR (255));");   /* ��ũ2 */
					}
					$exist = simpleSQLQuery("select count(*) from " . $tb_bbs_data . '_' . $row['bbs_id'] . " where g_no > 0;");
					if ( $exist ) {
						simpleSQLExecute('update ' . $tb_bbs_data . '_' . $row['bbs_id'] . " set g_no = concat('-',g_no) where g_no > 0;");
						echo $row['bbs_id'] . ' <font color="red">�Խ��� ������ ���� �Ǿ����ϴ�. [ g_no ] </font><BR>';
					}
					$exist = simpleSQLQuery("select count(*) from " . $tb_bbs_data . '_' . $row['bbs_id'] . " where use_st = 0 and g_no > -2147480000;");
					if ( $exist ) {
						simpleSQLExecute('update ' . $tb_bbs_data . '_' . $row['bbs_id'] . " set g_no = -2147480000 where use_st = 0;");
						echo $row['bbs_id'] . ' <font color="red">�Խ��� ������ ���� �Ǿ����ϴ�. [ use_st ] </font><BR>';
					}
                    $exist = indexCheck($tb_bbs_data . '_' . $row['bbs_id'], 'idx_bbsd_0');
                    if ( $exist ) {
                        simpleSQLExecute("drop index idx_bbsd_0 on " . $tb_bbs_data . '_' . $row['bbs_id'] . ";" );
                        echo $row['bbs_id'] . ' <font color="red">�Խ��� ���� ���� �Ǿ����ϴ�. [ drop idx_bbsd_0 ] </font><BR>';
                    }
                    $exist = indexCheck($tb_bbs_data . '_' . $row['bbs_id'], 'idx_bbsd_2');
                    if ( $exist ) {
                        simpleSQLExecute("drop index idx_bbsd_2 on " . $tb_bbs_data . '_' . $row['bbs_id'] . ";" );
                        echo $row['bbs_id'] . ' <font color="red">�Խ��� ���� ���� �Ǿ����ϴ�. [ drop idx_bbsd_2 ] </font><BR>';
                    }
                    $exist = indexCheck($tb_bbs_data . '_' . $row['bbs_id'], 'idx_bbsd_0');
                    if ( !$exist ) {
                        simpleSQLExecute("create index idx_bbsd_0 on " . $tb_bbs_data . '_' . $row['bbs_id'] . "(g_no, o_seq);" );
                        echo $row['bbs_id'] . ' <font color="red">�Խ��� ���� ���� �Ǿ����ϴ�. [ create idx_bbsd_0 ] </font><BR>';
                    }
                    $exist = indexCheck($tb_bbs_data . '_' . $row['bbs_id'], 'idx_bbsd_2');
                    if ( !$exist ) {
                        simpleSQLExecute("create index idx_bbsd_2 on " . $tb_bbs_data . '_' . $row['bbs_id'] . "(cat_no);" );
                        echo $row['bbs_id'] . ' <font color="red">�Խ��� ���� ���� �Ǿ����ϴ�. [ create idx_bbsd_2 ] </font><BR>';
                    }
                }
	/* 3.38 ���� ------------------------------------------------ �� */

	/* 3.40 ���� ------------------------------------------------ ���� */
				if ( (float) $_dboard_ver_str <= 3.40 ) {
					@mkdir("./files"     ,0707);
					@chmod("./files"     ,0707);
					if ( !@is_file ('files/' . $row['bbs_id'] . '.php') ) {
						$filesData  = "<?\n";
						$filesData .= '$baseDir = "../";' . "\n";
						$filesData .= '$id = \'' . $row['bbs_id'] . '\';' . "\n";
						$filesData .= 'include $baseDir . "dboard.php"' . "\n";
						$filesData .= "?>";
						$fp = @fopen ( 'files/' . $row['bbs_id'] . '.php', 'w');
						fwrite ( $fp, $filesData,strlen($filesData) );
						@chmod('files/' . $row['bbs_id'] . '.php',0707);

						echo '<font color="red">files/' . $row['bbs_id'] . '.php' . ' ������ ���� �Ǿ����ϴ�.</font><BR>';
					}
					// design_method
					$exist = fieldCheck($tb_bbs_infor,'design_method');
					if ( !$exist ) {
						echo '<font color="red">�Խ��� ������ (������ ���) �߰� �Ǿ����ϴ�.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_infor . " add (design_method            CHAR    (1)     DEFAULT '1');");   /* ������ ��� */
					}
				}
	/* 3.40 ���� ------------------------------------------------ �� */
            }
/* �Խ��� ���� ��ȯ ���� --------------------------------------------------------- ����*/

            echo '<BR><B><font color="black">�Ϸ�Ǿ����ϴ�.</font></B><BR><BR>';
            echo '<B><font color="red"><font color="black">dboard_patch.php</font> ������ �� �������ּ���.</font></B>';
            closeDBConnection (); // �����ͺ��̽� ���� ���� ����
        } else {
            echo "<FORM METHOD=POST ACTION='' onSubmit='return setupForm_Sumbit();'>
            <input type='hidden' name='execute_yn' value='Y'>
            <input type='submit' value='���� ��ġ ����'>
            </FORM>
            <img id='progress_bar' style='visibility:hidden;position:absolute;left:0px;top:0px;z-index:1' src='images/install_progress.gif'>
            <script type='text/javascript'>
            <!--
            var doubleTrans = false; // �ι� ���� ���۵��� �ʵ��� ó��.

                function setupForm_Sumbit() {
                    if ( doubleTrans ) return false;
                    else doubleTrans = true;
                    return true;
                }
            //-->
            </SCRIPT>
            ";
        }
    } else {
        echo '<a href="admin.php?succ_url=category_install.php">�����ڷ� �α����Ͻ��� �������ּ���.</a>';
    }
}
?>