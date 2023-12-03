<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
if ( DEBUG ) {
   require_once '../../lib/common.lib.inc' ; // 라이브러리
   require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션 
}
require_once SERVICE_DIR . '/classes/GridDataBase.php'; // 기본 DataBase 클래스
/**
 * @author softm
 * 샘플 클래스
 */
class Sample extends GridDataBase
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
        $this->table = $this->dbm->newTable(TBL_MEMBER);
        $this->table->setType(Table::TABLE_TYPE);
        $col1 = $this->table->newColumn('USER_NO'   ,'번호'    ,1)->setWidth(100)->setAlign("center")->setEditable(true);
        $col2 = $this->table->newColumn('USER_EMAIL','아이디'  ,2)->setWidth(150)->setAlign("right")->setEditable(true);
        $col3 = $this->table->newColumn('USER_LEVEL','레벨'    ,3)->setWidth(100)->setEditable(true)->setType(Column::LISTBOX_TYPE);
        $col3 = $this->table->newColumn('PASSWD'    ,'비밀번호' ,4)->setWidth(100)->setEditable(true)->setType(Column::TEXT_TYPE);
        $col3 = $this->table->newColumn('STATE'     ,'상태'    ,5)->setWidth(150)->setEditable(true)->setType(Column::LISTBOX_TYPE);
        $col3 = $this->table->newColumn('USER_NAME' ,'이름'    ,6)->setWidth(150)->setEditable(true);

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
     * exec
     */
    public function exec() {
    	echo "a";
    }
    
    /**
     * code를 array화한다.
     */
    public function getCodeData() {
    	// CODE DATA 정의
    	$this->dbm->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->dbm->addCodeData("SEX"       , self::$CODE_SEX       );
    	$this->dbm->addCodeData("STATE"     , self::$CODE_USER_STATE);
    	$this->dbm->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    }           
}

if ( DEBUG ) {
	$test = new Sample();

	/* test */
	$argus = array();
	$argus[user_email] = "test01";
	$test->get($argus);
}
?>