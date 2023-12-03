<? header("content-type:text/html; charset=utf-8");?><?php
define ('SERVICE_DIR', '../service');
//require_once '../inc/header.inc';
require_once SERVICE_DIR . '/common/lib/DatabaseManager.class.php';
require_once SERVICE_DIR . '/common/lib/Database.class.php';
require_once SERVICE_DIR . '/common/lib/var_database.inc';
require_once SERVICE_DIR . '/common/lib/var.inc';

        $page_tab['js_function' ] = $_POST["p_navi_function"];
        $page_tab['s'           ] = !$_POST[s]?1:(int)$_POST[s];
        if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

        $dbm = DataBaseManager::getInstance();
        $dbm->start();

        $table1 = $dbm->newTable("tbl_calko_country");
        $table1->setType(Table::TABLE_TYPE);

        $col1 = $table1->setColumn('USER_NO'   ,'국가코드'    ,2)->setWidth(100);
        $col2 = $table1->setColumn('USER_ID'   ,'국가명(영문)',3)->setWidth(100);
        $col3 = $table1->setColumn('USER_LEVEL','국가명(국문)',1)->setWidth(100);

        $where = array();
        $query[] = "SELECT";
        $query[] = " USER_NO    USER_NO   ,";
        $query[] = " USER_ID    USER_ID   ,";
        $query[] = " USER_LEVEL USER_LEVEL,";
        $query[] = " PASSWD     PASSWD    ,";
        $query[] = " USER_NAME  USER_NAME ,";
        $query[] = " SEX        SEX       ,";
        $query[] = " STATE      STATE     ,";
        $query[] = " EMAIL_YN   EMAIL_YN   ";
        $query[] = " FROM " . TB_MEMBER;
        $query[] = " WHERE 1=1 " . ( sizeof($where)>0?" AND " . join($where,' AND '):'' );
        $query[] =  ( $dbm->getQuerySort()?" ORDER BY ".$dbm->getQuerySort():'' );
        $query[] =  " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many;
        $dbm->setQuery(join("\n", $query));
        //ECHO join("\n", $query);

        $query   = array();
        $query[] = "SELECT";
        $query[] = " COUNT(*) TOTAL";
        $query[] = " FROM " . TB_MEMBER;
        $tot = $dbm->db->get(join("\n", $query))->TOTAL;
        $page_tab['tot'] = $tot;

        // CODE DATA 정의
        $dbm->addCodeData("USER_LEVEL", CODE_USER_LEVEL);
        $dbm->addCodeData("SEX"       , CODE_SEX       );
        $dbm->addCodeData("STATE"     , CODE_USER_STATE);
        $dbm->addCodeData("EMAIL_YN"  , CODE_USE_YN    );
        
        $xmlString = $dbm->makeGridXML();
        
        //throw new Exception("A");
        echo $xmlString;

        $dbm->end();
?>

