<?php
define("DEBUG",preg_match("/\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_TB_GOODS","micronics.tb_goods");
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
 *  / TbGoods.php
 */
class TbGoods extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_TB_GOODS);
			$seq = 0;
    		$tbl1->newColumn('GID','gid',++$seq)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('SELLER_ID','seller_id',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('CATEGORY','category',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('VIEWN','viewn',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('SALE_TYPE','sale_type',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('SALE_ING','전시여부: 	판매중:1 승인대기:2 판매종료 :3',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('GSTATUS','새제품 :1 중고제품 :2',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('UPLOAD_PIC','upload_pic',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('USE_OPTION','use_option',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('GNAME','gname',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('MODEL','model',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('BRAND','brand',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('MAKEC','makec',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('PRICE','price',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('SALE_PRICE','sale_price',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('DEALER_PRICE','dealer_price',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('ASV','asv',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('SIZE','size',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('USED','used',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('HDD','hdd',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('PAY_TYPE','pay_type',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('CARD_NM','card_nm',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('QUNT','qunt',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('QUNT_CONTROL','qunt_control',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('STORE_IN_DAY','store_in_day',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('POINT','point',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('FREEBIE','freebie',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('DELIV_PRICE','deliv_price',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('SPECIAL','special',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('COMMENT','comment',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('DATE','date',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('CLICK','click',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ETC','etc',++$seq)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,++$seq)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,++$seq)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,++$seq)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,++$seq)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,++$seq)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("BTN1"     ,'수정'  ,++$seq)->setWidth("100")->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)
			->setValue("<a class='btn_edit btn_modify' >수정</a>");
			$tbl1->newColumn("BTN2"     ,'삭제'  ,++$seq)->setWidth("100")->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)
			->setValue("<a class='btn_edit btn_delete' >삭제</a>");
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
//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->getCodeData(); // code xml 생성
    	$this->startHeader();
    	$this->setType(BaseDataBase::GRID_TYPE);
    	try {
    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		$where = $make_where;

    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_TB_GOODS . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " GID,";
    		$query [] = " SELLER_ID,";
    		$query [] = " CATEGORY,";
    		$query [] = " VIEWN,";
    		$query [] = " SALE_TYPE,";
    		$query [] = " SALE_ING,";
    		$query [] = " GSTATUS,";
    		$query [] = " UPLOAD_PIC,";
    		$query [] = " USE_OPTION,";
    		$query [] = " GNAME,";
    		$query [] = " MODEL,";
    		$query [] = " BRAND,";
    		$query [] = " MAKEC,";
    		$query [] = " PRICE,";
    		$query [] = " SALE_PRICE,";
    		$query [] = " DEALER_PRICE,";
    		$query [] = " ASV,";
    		$query [] = " SIZE,";
    		$query [] = " USED,";
    		$query [] = " HDD,";
    		$query [] = " PAY_TYPE,";
    		$query [] = " CARD_NM,";
    		$query [] = " QUNT,";
    		$query [] = " QUNT_CONTROL,";
    		$query [] = " STORE_IN_DAY,";
    		$query [] = " POINT,";
    		$query [] = " FREEBIE,";
    		$query [] = " DELIV_PRICE,";
    		$query [] = " SPECIAL,";
    		$query [] = " COMMENT,";
    		$query [] = " DATE_FORMAT(DATE,'%Y-%m-%d %H:%i') DATE,";
    		$query [] = " CLICK,";
    		$query [] = " ETC";
    		$query [] = " FROM " . TBL_TB_GOODS;

    		// where 문장생성
    		if ( $where ) $query[] = ( " WHERE " . $where );

    		$query[] =  ( $this->getQuerySort()?" ORDER BY ". $this->getQuerySort():'' );
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
        $p_gid = $argus[gid];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " GID,";
    		$query [] = " SELLER_ID,";
    		$query [] = " CATEGORY,";
    		$query [] = " VIEWN,";
    		$query [] = " SALE_TYPE,";
    		$query [] = " SALE_ING,";
    		$query [] = " GSTATUS,";
    		$query [] = " UPLOAD_PIC,";
    		$query [] = " USE_OPTION,";
    		$query [] = " GNAME,";
    		$query [] = " MODEL,";
    		$query [] = " BRAND,";
    		$query [] = " MAKEC,";
    		$query [] = " PRICE,";
    		$query [] = " SALE_PRICE,";
    		$query [] = " DEALER_PRICE,";
    		$query [] = " ASV,";
    		$query [] = " SIZE,";
    		$query [] = " USED,";
    		$query [] = " HDD,";
    		$query [] = " PAY_TYPE,";
    		$query [] = " CARD_NM,";
    		$query [] = " QUNT,";
    		$query [] = " QUNT_CONTROL,";
    		$query [] = " STORE_IN_DAY,";
    		$query [] = " POINT,";
    		$query [] = " FREEBIE,";
    		$query [] = " DELIV_PRICE,";
    		$query [] = " SPECIAL,";
    		$query [] = " COMMENT,";
    		$query [] = " DATE_FORMAT(DATE,'%Y-%m-%d %H:%i') DATE,";
    		$query [] = " CLICK,";
    		$query [] = " ETC";
            $query [] = " FROM " . TBL_TB_GOODS;
            $query [] = " WHERE ";
            $query [] = " GID = '" . $p_gid . "'";
            $this->setQuery(join(PHP_EOL, $query));
    //         out.print($this->getQuery());
            $this->makeItemXML($this->getQuery(),"item","fi");
    //         	out.print($this->db->getAffectedRows());
    //         	out.print($this->db->getErrMsg());
            $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
        }
        $this->printXML(C_DB_PROCESS_MODE_SELECT);
    }

    
    /**
     * 입력
     * @param array $argus
     * @return int
     */
    public function insert($argus) {
        $p_gid = $argus[gid];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_TB_GOODS ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_TB_GOODS;
            $query [] = "(";
    		$query [] = " GID,";
    		$query [] = " SELLER_ID,";
    		$query [] = " CATEGORY,";
    		$query [] = " VIEWN,";
    		$query [] = " SALE_TYPE,";
    		$query [] = " SALE_ING,";
    		$query [] = " GSTATUS,";
    		$query [] = " UPLOAD_PIC,";
    		$query [] = " USE_OPTION,";
    		$query [] = " GNAME,";
    		$query [] = " MODEL,";
    		$query [] = " BRAND,";
    		$query [] = " MAKEC,";
    		$query [] = " PRICE,";
    		$query [] = " SALE_PRICE,";
    		$query [] = " DEALER_PRICE,";
    		$query [] = " ASV,";
    		$query [] = " SIZE,";
    		$query [] = " USED,";
    		$query [] = " HDD,";
    		$query [] = " PAY_TYPE,";
    		$query [] = " CARD_NM,";
    		$query [] = " QUNT,";
    		$query [] = " QUNT_CONTROL,";
    		$query [] = " STORE_IN_DAY,";
    		$query [] = " POINT,";
    		$query [] = " FREEBIE,";
    		$query [] = " DELIV_PRICE,";
    		$query [] = " SPECIAL,";
    		$query [] = " COMMENT,";
    		$query [] = " DATE,";
    		$query [] = " CLICK,";
    		$query [] = " ETC";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[gid] . "',";
    		$query [] = " '" . $argus[seller_id] . "',";
    		$query [] = " '" . $argus[category] . "',";
    		$query [] = " '" . $argus[viewn] . "',";
    		$query [] = " '" . $argus[sale_type] . "',";
    		$query [] = " '" . $argus[sale_ing] . "',";
    		$query [] = " '" . $argus[gstatus] . "',";
    		$query [] = " '" . $argus[upload_pic] . "',";
    		$query [] = " '" . $argus[use_option] . "',";
    		$query [] = " '" . $argus[gname] . "',";
    		$query [] = " '" . $argus[model] . "',";
    		$query [] = " '" . $argus[brand] . "',";
    		$query [] = " '" . $argus[makec] . "',";
    		$query [] = " '" . $argus[price] . "',";
    		$query [] = " '" . $argus[sale_price] . "',";
    		$query [] = " '" . $argus[dealer_price] . "',";
    		$query [] = " '" . $argus[asv] . "',";
    		$query [] = " '" . $argus[size] . "',";
    		$query [] = " '" . $argus[used] . "',";
    		$query [] = " '" . $argus[hdd] . "',";
    		$query [] = " '" . $argus[pay_type] . "',";
    		$query [] = " '" . $argus[card_nm] . "',";
    		$query [] = " '" . $argus[qunt] . "',";
    		$query [] = " '" . $argus[qunt_control] . "',";
    		$query [] = " '" . $argus[store_in_day] . "',";
    		$query [] = " '" . $argus[point] . "',";
    		$query [] = " '" . $argus[freebie] . "',";
    		$query [] = " '" . $argus[deliv_price] . "',";
    		$query [] = " '" . $argus[special] . "',";
    		$query [] = " '" . $argus[comment] . "',";
    		$query [] = " '" . $argus[date] . "',";
    		$query [] = " '" . $argus[click] . "',";
    		$query [] = " '" . $argus[etc] . "'";
            //$query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $this->appendNode("p_gid",$argus[gid]); // insert key value 
//                out.print($this->db->getAffectedRows());
            if ( !$this->db->commit() ) throw new Exception("입력처리중 에러가 발생하였습니다.");
//                else {
//                	$file_no1 = 0;
////                 	echo DATA_DIR . DIRECTORY_SEPARATOR . TbGoods::$SAVE_SUB_DIR;
//                	$uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . TbGoods::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
////                 	var_dump($uploader);
//                	$uploader->getItem('file1')->setSaveName("f1_".$no."_");
//                	$uploader->upload(); 
//                	$f1 = $uploader->getItem('file1');
//// 					echo $f1->getErrorCode() . '<BR>';
//                	if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
//                		$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_BBSNOTICE, USER_NO, $f1->getName(), $f1->getExt(), $f1->getSize());
//                	}
//                	if ( $file_no1 !=0 ) $updateInfor[] = " FILE_NO1 = '" . $file_no1 . "'";
//                	if ( !empty($updateInfor) ) {
//                		$this->db->setAutoCommit(false);
//                		$this->exec(
//                				"UPDATE " .TBL_TBL_BBS_DATA_NOTICE . " SET"
//                				. join(",\n", $updateInfor)
//                				. " WHERE NO = '" .$no . "'"
//                		);
//                	
//                		$this->db->commit();
//                	}
//                }
            } else {
//                out.print($this->db->getErrMsg());
                throw new Exception($this->db->getErrMsg());
//               throw new Exception("입력처리중 에러가 발생하였습니다.");
            }
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
            $this->db->rollback();
        }
        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_INSERT)); // 성공시 출력 메시지.
        $this->printXML(C_DB_PROCESS_MODE_INSERT);
    }

    
    /**
     * 수정
     * @param array $argus
     * @return boolean
     */
    public function update($argus) {
        $p_gid = $argus[gid];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_TB_GOODS;
            $query [] = " SET";
            $query [] = " GID = '" . $argus[gid] . "',";
            $query [] = " SELLER_ID = '" . $argus[seller_id] . "',";
            $query [] = " CATEGORY = '" . $argus[category] . "',";
            $query [] = " VIEWN = '" . $argus[viewn] . "',";
            $query [] = " SALE_TYPE = '" . $argus[sale_type] . "',";
            $query [] = " SALE_ING = '" . $argus[sale_ing] . "',";
            $query [] = " GSTATUS = '" . $argus[gstatus] . "',";
            $query [] = " UPLOAD_PIC = '" . $argus[upload_pic] . "',";
            $query [] = " USE_OPTION = '" . $argus[use_option] . "',";
            $query [] = " GNAME = '" . $argus[gname] . "',";
            $query [] = " MODEL = '" . $argus[model] . "',";
            $query [] = " BRAND = '" . $argus[brand] . "',";
            $query [] = " MAKEC = '" . $argus[makec] . "',";
            $query [] = " PRICE = '" . $argus[price] . "',";
            $query [] = " SALE_PRICE = '" . $argus[sale_price] . "',";
            $query [] = " DEALER_PRICE = '" . $argus[dealer_price] . "',";
            $query [] = " ASV = '" . $argus[asv] . "',";
            $query [] = " SIZE = '" . $argus[size] . "',";
            $query [] = " USED = '" . $argus[used] . "',";
            $query [] = " HDD = '" . $argus[hdd] . "',";
            $query [] = " PAY_TYPE = '" . $argus[pay_type] . "',";
            $query [] = " CARD_NM = '" . $argus[card_nm] . "',";
            $query [] = " QUNT = '" . $argus[qunt] . "',";
            $query [] = " QUNT_CONTROL = '" . $argus[qunt_control] . "',";
            $query [] = " STORE_IN_DAY = '" . $argus[store_in_day] . "',";
            $query [] = " POINT = '" . $argus[point] . "',";
            $query [] = " FREEBIE = '" . $argus[freebie] . "',";
            $query [] = " DELIV_PRICE = '" . $argus[deliv_price] . "',";
            $query [] = " SPECIAL = '" . $argus[special] . "',";
            $query [] = " COMMENT = '" . $argus[comment] . "',";
            $query [] = " DATE = '" . $argus[date] . "',";
            $query [] = " CLICK = '" . $argus[click] . "',";
            $query [] = " ETC = '" . $argus[etc] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " GID = '" . $p_gid . "'";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
//                out.print($this->db->getAffectedRows());
//                    $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . TbGoods::$SAVE_SUB_DIR;
//                    $uploader  = new FileUpload(true,$saveDir); // 업로드 인스턴스 생성
//
//                    $f1 = $uploader->getItem('file1')->setSaveName("f1_".$p_no."_");
//                    if ( $argus[file1_delete] == 'Y' ) {
//                        @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
//                        Common::deleteFileInfor($this->db, $file_no1);
//                        $file_no1 = 0;
//                    }
//                    /* @var BizConsult Table file no 갱신 */
//                    $fileInforUpdate = array();
//                    if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
//                        if ( !$file_no1 ) {
//                            $file_no1 = Common::insertFileInfor($this->db, $proc_type, USER_NO, $f1->getName(), $f1->getExt(), $f1->getSize());
//                            $fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
//                        } else {
//                            @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
//                            $file_no1 = Common::updateFileInfor($this->db, $file_no1, $f1->getName(), $f1->getExt(), $f1->getSize());
//                        }
//                        $f1->upload();
//                    }
//                    if ( !empty($fileInforUpdate) ) {
//                        $this->exec(
//                                "UPDATE " .TBL_TBL_BBS_DATA_NOTICE . " SET"
//                                . join(",\n", $fileInforUpdate)
//                                . " WHERE NO = '" .$p_no . "'"
//                        );
//                    }
                if ( !$this->db->commit() ) throw new Exception("수정처리중 에러가 발생하였습니다.");
            } else {
//                out.print($this->db->getErrMsg());
                throw new Exception($this->db->getErrMsg());
//               throw new Exception("수정처리중 에러가 발생하였습니다.");
            }
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
            $this->db->rollback();
        }
        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_UPDATE)); // 성공시 출력 메시지.
        $this->printXML(C_DB_PROCESS_MODE_UPDATE);
    }

    /**
     * 저장
     * @param array $argus
     * @return string
     */
    public function save($argus) {
        $p_mode  = $argus['mode'][0];
        $p_gid = $argus[gid];
//        if ( $p_mode == C_DB_PROCESS_MODE_DELETE ) {
//            // 파일정보
//            $query = array();
//            $query [] = "SELECT ";
//            $query [] = " FILE_NO1 ";
//            $query [] = " FROM ". TBL_TB_GOODS;
//            $query [] = " WHERE ";
//            $query [] = " GID = '" . $p_gid . "'";
//            $infor = $this->db->get(join(PHP_EOL, $query));
//
//            $file_no1 = $infor->FILE_NO1;
//        }
//        if ( $p_mode == C_DB_PROCESS_MODE_DELETE ) {
//            if (parent::save($argus,false)) {
//                $oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no1),"FILE_NO,FILE_EXT");
//                $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
//
//                // 파일 삭제.
//                $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . TbGoods::$SAVE_SUB_DIR;
//                @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
//                Common::deleteFileInfor($this->db, $file_no1);
//                $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
//
//            } else {
//                $this->addErrMessage("저장중 오류발생 : 확인하세요.");
//            }
//            $this->printXML(C_DB_PROCESS_MODE_PROC);
//
//        } else {
            parent::save($argus);
//        }
    } 
//    /**
//     * 저장
//     * @param array $argus
//     * @return string
//     */
//    public function save($argus) {
//    	$p_mode       = $argus['mode'][0];
//        $p_gid = $argus[gid];
//    	if (parent::save($argus,false)) {
//    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
//    	} else {
//    		$this->addErrMessage("저장중 오류가발생하였습니다.");
//    	}
//    	$this->printXML(C_DB_PROCESS_MODE_PROC);
//    }

    
    /**
     * 삭제
     * @param array $argus
     * @return boolean
     */
    public function delete($argus) {
        $p_gid = $argus[gid];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            // 파일정보
            $query = array();
            $query [] = "SELECT ";
            $query [] = " FILE_NO1 ";
            $query [] = " FROM ". TBL_TB_GOODS;
            $query [] = " WHERE ";
            $query [] = " GID = '" . $p_gid . "'";
            $infor = $this->db->get(join(PHP_EOL, $query));

            $file_no1 = $infor->FILE_NO1;
            $query = array();
            $query [] = "DELETE FROM " . TBL_TB_GOODS;
            $query [] = " WHERE ";
            $query [] = " GID = '" . $p_gid . "'";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
//                out.print($this->db->getAffectedRows());

                // 담당자정보 삭제.
                // if ( !Worker::externalDelete($this->db, array(p_worker_no=>$p_worker_no)) ) throw new Exception($this->db->getErrMsg());

                $oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no1),"FILE_NO,FILE_EXT");
                $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;

                // 파일 삭제.
                $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . TbGoods::$SAVE_SUB_DIR;
                @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
                Common::deleteFileInfor($this->db, $file_no1);
                if ( !$this->db->commit() ) throw new Exception("삭제처리중 에러가 발생하였습니다.");
            } else {
                throw new Exception($this->db->getErrMsg());
//               throw new Exception("삭제처리중 에러가 발생하였습니다.");
            }

        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
            $this->db->rollback();
        }
        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_DELETE)); // 성공시 출력 메시지.
        $this->printXML(C_DB_PROCESS_MODE_DELETE);
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
   // # test path : http://local-framework.com/TbGoods.php
   $test = new TbGoods();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_TB_GOODS );
   $test->test($argus);
/*

   // insert 
   $argus[gid]  = 'data';
   $argus[seller_id]  = 'data';
   $argus[category]  = 'data';
   $argus[viewn]  = 'data';
   $argus[sale_type]  = 'data';
   $argus[sale_ing]  = 'data';
   $argus[gstatus]  = 'data';
   $argus[upload_pic]  = 'data';
   $argus[use_option]  = 'data';
   $argus[gname]  = 'data';
   $argus[model]  = 'data';
   $argus[brand]  = 'data';
   $argus[makec]  = 'data';
   $argus[price]  = 'data';
   $argus[sale_price]  = 'data';
   $argus[dealer_price]  = 'data';
   $argus[asv]  = 'data';
   $argus[size]  = 'data';
   $argus[used]  = 'data';
   $argus[hdd]  = 'data';
   $argus[pay_type]  = 'data';
   $argus[card_nm]  = 'data';
   $argus[qunt]  = 'data';
   $argus[qunt_control]  = 'data';
   $argus[store_in_day]  = 'data';
   $argus[point]  = 'data';
   $argus[freebie]  = 'data';
   $argus[deliv_price]  = 'data';
   $argus[special]  = 'data';
   $argus[comment]  = 'data';
   $argus[date]  = 'data';
   $argus[click]  = 'data';
   $argus[etc]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[gid]  = 'key';
   // data field 
   $argus[seller_id]  = 'data';
   $argus[category]  = 'data';
   $argus[viewn]  = 'data';
   $argus[sale_type]  = 'data';
   $argus[sale_ing]  = 'data';
   $argus[gstatus]  = 'data';
   $argus[upload_pic]  = 'data';
   $argus[use_option]  = 'data';
   $argus[gname]  = 'data';
   $argus[model]  = 'data';
   $argus[brand]  = 'data';
   $argus[makec]  = 'data';
   $argus[price]  = 'data';
   $argus[sale_price]  = 'data';
   $argus[dealer_price]  = 'data';
   $argus[asv]  = 'data';
   $argus[size]  = 'data';
   $argus[used]  = 'data';
   $argus[hdd]  = 'data';
   $argus[pay_type]  = 'data';
   $argus[card_nm]  = 'data';
   $argus[qunt]  = 'data';
   $argus[qunt_control]  = 'data';
   $argus[store_in_day]  = 'data';
   $argus[point]  = 'data';
   $argus[freebie]  = 'data';
   $argus[deliv_price]  = 'data';
   $argus[special]  = 'data';
   $argus[comment]  = 'data';
   $argus[date]  = 'data';
   $argus[click]  = 'data';
   $argus[etc]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[gid]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[gid]  = 'key';
   $test->select($argus); 

*/
}
?>
