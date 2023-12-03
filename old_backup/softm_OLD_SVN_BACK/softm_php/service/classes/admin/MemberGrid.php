<?php
//require_once '../../lib/common.lib.inc'; // 기본 Lib
require_once SERVICE_DIR . '/classes/GridDataBase.php'; // 기본 DataBase 클래스
/**
 * @author softm
 * 샘플 클래스
 */
class MemberGrid extends GridDataBase
{
    /**
     * @var Table
     */
    public $table2;
    public function __construct() {
        parent::__construct();

// 방법0        
//         $this->table = $this->dbm->newTable(TBL_MEMBER);
//         $this->table->loadAllField();
//         $this->table->removeColumn("USER_NO");
//         $this->table->removeColumn("USER_LEVEL");
//         $this->table->removeColumn("USER_EMAIL");
//         $this->table->removeColumn("PASSWD");
//         $this->table->removeColumn("STATE");
       // var_dump($this->table->getColumn("USER_NO"));
       
// 방법1
//         번호 	아이디 	회원명 	등급 	가입일 	수정/삭제
        
        $this->table = $this->dbm->newTable(TBL_MEMBER);
        $this->table->setType(Table::TABLE_TYPE);
        $col1 = $this->table->newColumn('USER_NO'   ,'번호'       ,1)->setAlign("center");
        $col2 = $this->table->newColumn('USER_EMAIL','아이디'     ,2)->setAlign("right");
        $col3 = $this->table->newColumn('USER_NAME' ,'회원명'     ,3);
        $col3 = $this->table->newColumn('USER_LEVEL','레벨'       ,4)->setType(Column::LISTBOX_TYPE)->setEditable(true);
        $col3 = $this->table->newColumn('REG_DATE'  ,'가입일'     ,5);
        
        $col3 = $this->table->newColumn("<img src='/images/btn_ico_modify.jpg' class=btn_modify><img src='/images/btn_ico_del.jpg' class=btn_delete>" ,'수정/삭제'  ,6)->getDbColumn(false)->setWidth(100)->setHtml(true)->setAlias("BTN")->setType(Column::TEXT_TYPE);

//         $col3 = $this->table->newColumn('STATE'     ,'상태'    ,5)->setWidth(150)->setEditable(true)->setType(Column::LISTBOX_TYPE);
        $col3 = $this->table->newColumn('PASSWD'  ,'비밀번호'     ,222)->setHide(true)->setWidth(0)->setEditable(true)->setType(Column::TEXT_TYPE);

// 방법2
//      $this->table2 = new Table("tbl_calko_country");
//      $this->table2->addColumn(new Column('USER_NO'   , '번호'   ),1)->setEditable(false);
//      $this->table2->addColumn(new Column('USER_ID'   , '아이디' ),1)->setEditable(false);
//      $this->table2->addColumn(new Column('USER_LEVEL', '레벨'   ),1)->setEditable(true)->setType(Column::LISTBOX_TYPE);
//      $this->dbm->addTable($this->table2);

//      $table2 = new Table("tbl_calko_country");
//      $table2->addColumn(new Column('USER_NO1'   , '번호'   ),3)->setEditable(false);
//      $table2->addColumn(new Column('USER_ID2'   , '아이디' ),1)->setEditable(false);
//      $table2->addColumn(new Column('USER_LEVEL3', '레벨'   ),2)->setEditable(false);
//      $this->dbm->addTable($table2);
    }

    public function __destruct() {
        parent::__destruct();
    }
    
    /**
     * code를 array화한다.
     */
    public function getCodeData() {
    	// CODE DATA 정의
    	$this->dbm->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
//     	$this->dbm->addCodeData("SEX"       , self::$CODE_SEX       );
//     	$this->dbm->addCodeData("STATE"     , self::$CODE_USER_STATE);
//     	$this->dbm->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    } 
}
?>