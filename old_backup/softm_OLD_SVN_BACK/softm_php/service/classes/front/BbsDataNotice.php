<?php
define("DEBUG",preg_match("/\/service\/classes/", $_SERVER[PHP_SELF]));
//define("TBL_BBS_DATA_NOTICE","mj.tbl_bbs_data_notice");
if ( DEBUG ) {
   require_once '../../../lib/common.lib.inc' ; // 라이브러리
   require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션
}
require_once SERVICE_DIR . '/classes/BaseDataBase.php'; // 기본 DataBase 클래스
require_once SERVICE_DIR . '/classes/common/Util.php'; // Util클래스
require_once SERVICE_DIR . '/classes/common/Common.php'; // Common클래스
require_once SERVICE_DIR . '/classes/common/FileUpload.php'; // 파일업로드클래스
/**
 * @author softm
 * 공지사항 / BbsDataNotice.php
 */
class BbsDataNotice extends BaseDataBase
{
    /** @var upload file directory */ public static $SAVE_SUB_DIR = "bbsnotice";

    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
            $tbl1 = $this->newTable(TBL_BBS_DATA_NOTICE);
            $seq = 0;
            $tbl1->newColumn('NO'       ,'번호'     ,++$seq)->setWidth("10%")->setEditable(false)->setKey(true);
//          $tbl1->newColumn('NO2'      ,'번호2'     ,++$seq)->setWidth("10%")->setEditable(false)->setKey(true)->setBindName("NO");
            $tbl1->newColumn('TITLE'    ,'제목'     ,++$seq)->setWidth("60%")->setAlign("left")->setKey(false);
            $tbl1->newColumn('NAME'     ,'작성자'   ,++$seq)->setWidth("10%")->setKey(false);
            $tbl1->newColumn('REG_DATE' ,'작성일'   ,++$seq)->setWidth("10%")->setKey(false);
            $tbl1->newColumn('FILE_NO1' ,'파일정보' ,++$seq)->setWidth("10%")->setKey(false);
//            <img src="images/contents/ico_file.jpg" alt="첨부파일있음" />
            $tbl1->newColumn('HIT'      ,'조회수',++$seq)->setWidth("10%")->setKey(false);
        }
    }

    public function __destruct() {
        parent::__destruct();
        $this->end();
    }

    /**
     * test
     * @param array $argus
     */
    function test(array $argus) {
//       $p_user_id   = $argus[user_email  ];

       $this->testJsCall($argus);
       $this->startHeader();
       try {

       } catch (Exception $e) {
           $this->addErrMessage($e->getMessage());
       }
       $this->printXML(C_DB_PROCESS_MODE_PROC);
    }

    /**
     * 조회-그리드
     * @param array $argus
     * @return DOMDocument
     */
    public function select($argus) {
        global $page_tab;
        //     $this->testJsCall($argus);
//      $this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
        $this->getCodeData(); // code xml 생성
        $this->startHeader();
        $this->setType(BaseDataBase::GRID_TYPE);
        try {
            //if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
//          var_dump($argus);
            $page_tab['js_function' ] = $argus["p_navi_function"];
            $page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
            if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

            // where 문장생성
            $make_where = $this->makeWhere($argus);
            $where = $make_where;
            $where = " 1 = 1";
            if ( $argus[s_gubun] == "title") {
                if ( $argus[s_search] )
                    $where .= " AND TITLE LIKE '%" . $argus[s_search] . "%'";
            } else if ( $argus[s_gubun] == "content") {
                if ( $argus[s_search] )
                    $where .= " AND CONTENT LIKE '%" . $argus[s_search] . "%'";
            } else {
                if ( $argus[s_search] ) {
                    $where .= " AND TITLE LIKE '%" . $argus[s_search] . "%'";
                    $where .= "  OR CONTENT LIKE '%" . $argus[s_search] . "%'";
                }
            }

            // row 갯수
            $page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_BBS_DATA_NOTICE . ( $where ? " WHERE " . $where:"" ) );
            if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

            $query = array();

            $query [] = " SELECT ";
            $query [] = " NO,";
//          $query [] = " NO NO2,";
            $query [] = " CAT_NO,";
            $query [] = " G_NO,";
            $query [] = " DEPTH,";
            $query [] = " O_SEQ,";
            $query [] = " PRE_NO,";
            $query [] = " NEXT_NO,";
            $query [] = " USER_LEVEL,";
            $query [] = " USER_NO,";
            $query [] = " USER_ID,";
            $query [] = " NAME,";
            $query [] = " PASSWORD,";
            $query [] = " TITLE,";
            $query [] = " CONTENT,";
            $query [] = " E_MAIL,";
            $query [] = " HOME,";
            $query [] = " FILE_NO1,";
            $query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d') REG_DATE,";
            $query [] = " IP,";
            $query [] = " HIT";
            $query [] = " FROM " . TBL_BBS_DATA_NOTICE;

            // where 문장생성
            if ( $where ) $query[] = ( " WHERE " . $where );

            $query[] =  ( $this->getQuerySort()?" ORDER BY ". $this->getQuerySort():' ORDER BY NO DESC' );
            $query[] =  " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many;

            $this->setQuery(join(PHP_EOL, $query));
//         out.print($this->getQuery());

            $this->makeItemXML($this->getQuery(),"item","fieldinfo");
            //         out.print($this->db->getAffectedRows());
            $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
        }
        $this->printXML(C_DB_PROCESS_MODE_SELECT);
    }


    /**
     * 조회
     * @param array $argus
     * @return DOMDocument
     */
    public function get($argus) {
        //$p_user_id   = $argus[user_email  ];
        $p_no = $argus[p_no];

        $this->testJsCall($argus);
        $this->startHeader();
        try {
        	if ( !$_SESSION['__notice_view'][$p_no] ) {
        		$_SESSION['__notice_view'][$p_no]='1';
        		$this->db->exec("UPDATE " . TBL_BBS_DATA_NOTICE 
        				      . " SET HIT = HIT + 1"
        				      . " WHERE NO = '" . $p_no ."'"
            	);
        	}
            //if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
            $query [] = " NO,";
            $query [] = " CAT_NO,";
            $query [] = " G_NO,";
            $query [] = " DEPTH,";
            $query [] = " O_SEQ,";
            $query [] = " PRE_NO,";
            $query [] = " NEXT_NO,";
            $query [] = " USER_LEVEL,";
            $query [] = " USER_NO,";
            $query [] = " USER_ID,";
            $query [] = " NAME,";
            $query [] = " PASSWORD,";
            $query [] = " TITLE,";
            $query [] = " CONTENT,";
            $query [] = " E_MAIL,";
            $query [] = " HOME,";
            $query [] = " FILE_NO1,";
            $query [] = " REG_DATE,";
            $query [] = " IP";
            $query [] = " FROM " . TBL_BBS_DATA_NOTICE;
            $query [] = " WHERE ";
            $query [] = " NO = '" . $p_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
//             out.print($this->getQuery());
            $bbsData = $this->db->get($this->getQuery(),"array");

            $file_no1 = $bbsData[FILE_NO1];
            $fInfor = array ( FILE_NO1=>$file_no1 );

            $oldFileInfor = Common::getFileInfor($this->db,$fInfor,"FILE_NO,FILE_NAME,FILE_EXT,FILE_SIZE");
            $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
            $file1Name = $oldFileInfor['FILE_NO1']->FILE_NAME;
            $file1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
            $this->appendNode('filename1', $file1Name);
            $this->appendNode('fileext1', $file1Ext);
            $this->appendNode('fileno1', $file_no1);
    //          out.print($this->db->getAffectedRows());
    //          out.print($this->db->getErrMsg());
            $this->oneRowToXML($bbsData,"item","fi");

            $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
        }
        $this->printXML(C_DB_PROCESS_MODE_SELECT);
    }


    /**
     * code를 array화한다.
     */
    public function getCodeData() {
       // CODE DATA 정의
//         $this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
//         $this->addCodeData("SEX"       , self::$CODE_SEX       );
//         $this->addCodeData("STATE"     , self::$CODE_USER_STATE);
//         $this->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    }
}
if ( DEBUG ) {
   // # test path : http://local-mj.com/BbsDataNotice.php
   $test = new BbsDataNotice();
   $argus = array();

   // test
   $argus[user_email] = "test01";
   $test->setTableName(TBL_BBS_DATA_NOTICE );
   $test->test($argus);
/*

   // insert
   $argus[no]  = 'data';
   $argus[cat_no]  = 'data';
   $argus[g_no]  = 'data';
   $argus[depth]  = 'data';
   $argus[o_seq]  = 'data';
   $argus[pre_no]  = 'data';
   $argus[next_no]  = 'data';
   $argus[user_level]  = 'data';
   $argus[user_no]  = 'data';
   $argus[user_id]  = 'data';
   $argus[name]  = 'data';
   $argus[password]  = 'data';
   $argus[title]  = 'data';
   $argus[content]  = 'data';
   $argus[e_mail]  = 'data';
   $argus[home]  = 'data';
   $argus[file_no1]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[ip]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update
   // key field
   $argus[no]  = 'key';
   // data field
   $argus[cat_no]  = 'data';
   $argus[g_no]  = 'data';
   $argus[depth]  = 'data';
   $argus[o_seq]  = 'data';
   $argus[pre_no]  = 'data';
   $argus[next_no]  = 'data';
   $argus[user_level]  = 'data';
   $argus[user_no]  = 'data';
   $argus[user_id]  = 'data';
   $argus[name]  = 'data';
   $argus[password]  = 'data';
   $argus[title]  = 'data';
   $argus[content]  = 'data';
   $argus[e_mail]  = 'data';
   $argus[home]  = 'data';
   $argus[file_no1]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[ip]  = 'data';
   out.print($test->update($argus));

   // delete
   $argus[no]  = 'key';
   out.print($test->delete($argus));

   select
   $argus[no]  = 'key';
   $test->select($argus);

*/
}
?>
