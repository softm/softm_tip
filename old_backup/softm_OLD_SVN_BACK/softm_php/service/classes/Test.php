<?php
define("DEBUG",preg_match("/\/service\/classes/", $_SERVER[PHP_SELF]));
if ( DEBUG ) {
	require_once '../lib/common.lib.inc' ; // 라이브러리
	require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션
}
require_once SERVICE_DIR . '/classes/BaseDataBase.php'; // 기본 DataBase 클래스
require_once SERVICE_DIR . '/classes/common/Util.php'; // Util클래스
require_once SERVICE_DIR . '/classes/common/Common.php'; // Common클래스
require_once SERVICE_DIR . '/classes/common/FileUpload.php'; // 파일업로드클래스
/**
 * @author softm
 * 테스트 / Test.php
 */
class Test extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        define("web_debugging",true);
        $this->start();
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
//     	$this->debug = true;
    	$p_user_id   = $argus[user_email  ];

    	$this->testJsCall($argus);
    	$this->startHeader();
    	try {

    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_PROC);
    }

    public function testJsDatabaseInfor($argus) {
    	//     	$this->debug = true;
    	$p_user_id   = $argus[user_email  ];

    	$this->testJsCall($argus);
    	$this->startHeader();
    	try {
    		$databaseInfors = array();
    		$stmt = $this->db->multiRowSQLQuery ("show databases");
    		while ( $rs = $this->db->multiRowFetch  ($stmt) ) {
    			$databaseInfors[] = '' . $rs->Database . ':"' . $rs->Database . '"';
    		}

    		$this->message->setObject("infors",
    				"{" . join(",", $databaseInfors) . "}"
    		);
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_PROC);
    }

    public function testJsTableInfor($argus) {
    	//     	$this->debug = true;
    	$p_user_id   = $argus[user_email  ];

    	$this->testJsCall($argus);
    	$this->startHeader();
    	try {
    		$tableInfors = array();
    		$stmt = $this->db->multiRowSQLQuery ("SELECT A.TABLE_NAME TABLE_NAME, A.TABLE_COMMENT TABLE_COMMENT FROM information_schema.TABLES A WHERE A.TABLE_SCHEMA = '" . $argus[database] . "'");
    		while ( $rs = $this->db->multiRowFetch  ($stmt) ) {
    			$commentInfor = explode(";",$rs->TABLE_COMMENT);
    			$tableInfors[] = '' . $rs->TABLE_NAME . ':"' . $rs->TABLE_NAME . ( !$commentInfor[0]?"":"->" . $commentInfor[0] ) . '"';
    		}

    		$this->message->setObject("infors",
    				"{" . join(",", $tableInfors) . "}"
    		);
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_PROC);
    }
    /**
     * 실행결과 xml을 반환합니다.
     * @param string $mode
     * @return string xmlString
     */
    public function testJsCall($argus) {
    	//     	echo '$this->debug : ' . $this->getDebug();
    	//     	echo '$argus[class_name] : ' . $argus[class_name];
    	if ( $this->debug ) {
    		if ( $argus[class_table] ) {
    			$this->setTableName($argus[class_table]);
    		}

    		if ( $argus[debugging] ) {
    			define("debugging",true);
    		}
    		$datbaseName = $argus[datbase_name]?$argus[datbase_name]:$this->db->getDbNm();
    		$tblName = $this->getTableName();
    		$tblNameInfor = explode("_",$tblName);
    		$className = "";
    		//     		var_dump($tblNameInfor);
    		if ( !$argus[class_name] ) {
    			if (sizeof($tblNameInfor) > 0 ) {
    				$loop = 0;
    				foreach ($tblNameInfor as $key => $value) {
    					$loop++;
    					if ( $loop != 1 || strtolower($value) != 'tbl') {
    						$className .= ucfirst(strtolower($value));
    					}
    				}
    			} else {
    				$className = ucfirst($tblName);
    			}
    		}
    		//     		echo '$className : ' . $className;

    		$list_html= array();
    		$list_js  = array();

    		$write_html   = array();
    		$write_html[] = "<form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>";
    		$write_html[] = "<!-- <form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 파일업로드();'> -->";
    		$write_html[] = "<!-- <input name='MAX_FILE_SIZE1' type='hidden' value='3' /> -->";
    		$write_html[] = "<!-- <input type='submit' value='전송'><BR> -->";
    		$write_html[] = "<!-- <input name='test1' type='text' value='test1'><BR> -->";
    		$write_html[] = "<!-- <input type='file' name='test_file' id='test_file' style='width:450px'/><BR> -->";

    		$write_html[] = '<div id="bd_btn">';
    		$write_html[] = '<input type=image src="'.SERVICE_BASE.'/images/btn_modify.jpg" style="vertical-align:middle"/>';
    		$write_html[] = '<a href="#" title="삭제하기" onclick="return 삭제();"><img src="'.SERVICE_BASE.'/images/btn_del.jpg" /></a>';
    		$write_html[] = '<a href="#" title="목록보기" onclick="return 목록();"><img src="'.SERVICE_BASE.'/images/btn_list.jpg" /></a>';
    		$write_html[] = '</div>';

    		$default_css= array();
    		$default_css []= "* { font-family:굴림,돋움;font-size:10pt; color:#000; }      ";
    		$default_css []= "a:link { text-decoration:none; color:#444444; }      ";
    		$default_css []= "a:visited { text-decoration:none; color:#444444;}    ";
    		$default_css []= "a:active { text-decoration:none; color:#b09372; }    ";
    		$default_css []= "a:hover { text-decoration:underline; color:#b09372; }";

    		$list_css = array();
    		$list_css []= "";

    		$write_css = array();
    		$write_css []= "";

    		$write_js = array();
    		$write_js_valid   = array();
    		$write_js_valid2   = array();

    		$class_select_columns = array();
    		$class_insert_columns = array();
    		$class_insert_values  = array();
    		$class_update_columns = array();
    		$class_update_wheres  = array();

    		$class_insert_argus   = array();
    		$class_update_argus   = array();
    		$sql_key_argus      = array();

    		$write_js_form_valid_argus_insert = array();
    		$write_js_form_valid_argus_update = array(); //사용안함.. 혹시 몰라사.

    		$select_new_column = array();

    		$list_js_argus1 = array();
    		$list_js_argus2 = array();

    		$write_js_argus1  = array();
    		$write_js_argus2  = array();
    		$write_js_argus3  = array();
    		$write_js_argus4  = array();
    		$write_js_argus5  = array();
    		$write_js_argus6  = array();
    		$write_js_argus7  = array();

    		$class_key_argus = array();

    		$autoIncreament = false;
    		$dateFieldInclude = false;
    		$pk_names = array();
    		foreach ($argus as $field => $value) {
    			$write_js_valid []= "                    " . $field . ":" . "f." . $field . ".value.trim()";
    		}
    		//     		echo "desc " . $datbaseName . "." . $tblName;
    		// table schema 조회
    		$stmt = $this->db->multiRowSQLQuery ("desc " . $datbaseName . "." . $tblName);
    		// 		    echo "desc " . $tblName;
    		$fIndex = 0;
    		while ( $rs = $this->db->multiRowFetch  ($stmt) ) {
    			$field = strtolower($rs->Field);
    			$key   = $rs->Key; // PRI, MUL, UNI
    			$null  = $rs->Null; // YES,NO
    			$key   = $rs->Key; // PRI, MUL, UNI
    			$extra = $rs->Extra;
    			$int   = false;
    			$required = false;
    			if ( $key == "PRI" || $key == "MUL" || $key == "UNI" || $null == "NO" ) {
    				$required = true;
    			}

    			$digit = preg_replace("/[[:alpha:]|\(|)|\s]/", "", $rs->Type);
    			/** numeric type
    			 tinyint, smallint, mediumint, int, bigint
    			 float, double, decimal
    			 */
    			$type  = preg_replace("/[[:digit:]|\(|)|\s|]/", "", $rs->Type);
    			$type  = str_replace(array("unsigned"), (""), $type);
    			// echo $digit;
    			// $write_html[] = $field . " " . $type . " . " . $digit . " . " . $key ;
    			// echo '$field : ' . $field . ' / $type : ' . $type . ' / $key : ' . $key . ' / $null : ' . $null . ' / $digit : ' . $digit . ' / $required : ' . $required. '<BR>';

    			if ( $type == 'tinyint' || $type == 'smallint' || $type == 'int' || $type == 'bigint' ) {
    				$write_js_argus2[] = "f." . $field . ".onfocus = Form.numeberOnly";
    				$int   = true;
    			} else if ( $type == 'float' || $type == 'double' || $type == 'decimal' ) {
    				$write_js_argus2[] = "f." . $field . ".onfocus = function(e) { Form.numeberOnly(e,true); }";
    			}

    			$innerQuery = "SELECT"
    			. "   column_comment  AS comment"
    			. " , column_name     AS column_name"
    			. " FROM information_schema.columns"
    			. " WHERE table_schema = '" . $datbaseName . "'"
    			. " and table_name = '" . $tblName. "'"
    			. " and column_name = '" . $field . "'"
    			;
    			// 	    	    					ECHO $innerQuery;
    			$innerRs = $this->db->get($innerQuery);

    			$innerRsTable = $this->db->getOne("SHOW TABLE STATUS FROM `" . $datbaseName . "` where name = '" . $tblName . "'");
    			$tableCommentInfor = explode(';',$innerRsTable->comment);
    			$tableComment = $tableCommentInfor[0];

                $columnComment = $innerRs->comment;
                if ( !$columnComment ) $columnComment = $field;

    			//var_dump($innerRs);
    			$str = array();
    			$str[] = $columnComment . " : <input type='text'";
    			$str[] = " name='" . $field . "'";
    			$str[] = ($digit?" size=" .$digit:"");
    			if ( $type == 'date' || $type == 'datetime' ) {

    			}
    			if ( $type == 'date' ) {
    				$str[] = " value='" . date("Y-m-d") . "' readonly ";
    				$str[] = " style='width:63px'";
    			} else if ( $type == 'datetime' ) {
    				$str[] = " value='" . date("Y-m-d H:i") . "' readonly ";
    				$str[] = " style='width:100px'";
    			} else {
    				$str[] = " value=''";
    				$str[] = " style='width:" . (int)($digit*2.5) . "px'";
    			}
    			$str[] = ($required?" class='required trim focus alert"
    					. ( $type == ' date' ? $type:"" )
    					. "'":"");
    			$str[] = " maxlength=" .$digit;
    			$str[] = ($required?" minlength=0":"");
    			$str[] = ($required?" message='" . $columnComment . "를 입력해주세요.'":"");
    			$str[] = " />";

    			if ( $type == 'date' || $type == 'datetime' ) {
    				$dateFieldInclude = true;
    				$str[] = "&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form." . $field . ",\"yyyy-mm-dd hh:ii\",this,true)'>";
    			}
    			$str[] = "<BR>";

    			$write_html[] = join('',$str);
    			$write_js_valid2 []= "                    " . $field . ":" . "f." . $field . ".value.trim()";

    			if ( $required && $key != "PRI" ) {
    				$write_js_form_valid_argus_update [] = "        " . $field . ":function(){ Effect.twinkle(f." . $field. ");}";
    			} else {
    				$write_js_form_valid_argus_insert [] = "        " . $field . ":function(){ Effect.twinkle(f." . $field. ");}";
    			}
    			if ( $type == 'datetime' ) {
    				$class_select_columns[] = "    		\$query [] = \" DATE_FORMAT(" . strtoupper($field) . ",'%Y-%m-%d %H:%i') " . strtoupper($field);
    			} else {
    				$class_select_columns[] = "    		\$query [] = \" " . strtoupper($field) . "";
    			}

    			if ( $extra == "auto_increment" ) $autoIncreament = true;
    			if ( $key != "PRI" || !$autoIncreament ) {
    				$class_insert_columns[] = "    		\$query [] = \" " . strtoupper($field) . "";
    				$class_insert_values[] = "    		\$query [] = \" '" . "\" . \$argus[" . strtolower($field) . "] . \"" . "'";
    			} else {
    			}

    			$class_update_columns[] = "            \$query [] = " . "\" " . strtoupper($field) . " = '" . "\" . \$argus[" . strtolower($field) . "] . \"" . "'";
    			if ( $key == "PRI" ) {
    				$pk_names[] = $field;
    				$class_update_wheres[] = "            \$query [] = " . "\" " . strtoupper($field) . " = '" . "\" . \$p_" . strtolower($field) . " . \"" . "'";
    				$sql_key_argus[] = "   \$argus[" . strtolower($field) . "] " . " = 'key';";
    				$class_key_argus[] = '        $p_' . $field . ' = $argus[' . $field . '];';

    				$list_js_argus1[] = 'p_' . $field . ':GRID.getValue($S("tbl_list"),tr.rowIndex,"' . $field . '")';
    				$list_js_argus2[] = 'p_' . $field . ':GRID.getValue(o.tId,o.tr.rowIndex,"' . $field . '")';

    				$write_js_argus1[] = 'p_' . $field . ':argus.p_' . $field;
    				$write_js_argus6[] = 'p_' . $field . ':item.' . $field;
    				$write_js_argus7[] = 'argus.p_' . $field;

    				$write_js_argus3[] = 'SOFTMARGUMENT.p_' . $field . '';
    				if ( $autoIncreament ) {
    					$write_js_argus4[] = 'removeClass(f.' . $field . ',"required")';
    				}
    				$write_js_argus5[] = 'p_' . $field . ':SOFTMARGUMENT.p_' . $field . '';
    			} else {
    				$class_update_argus[] = "   \$argus[" . strtolower($field) . "] " . " = 'data';";
    			}
    			$class_insert_argus[] = "   \$argus[" . strtolower($field) . "] " . " = 'data';";
    			if ( $required ) {
    			    $fIndex++;
    				$select_new_column[] = "    		\$tbl1->newColumn('" . strtoupper($field) . "','"
    				. $columnComment . "',"
//     				. $fIndex . ")->setWidth(".($key == "PRI"||$key == "UNI"?"50":"100").")->setEditable(".($key == "PRI"?"false":"true").")"
    				. '++$seq'.")->setWidth(".($key == "PRI"||$key == "UNI"?"50":"100").")->setEditable(".($key == "PRI"?"false":"true").")"
    				. ";"
    				;
    			} else {
    				$select_new_column[] = "//" . "    		\$tbl1->newColumn('" . strtoupper($field) . "','"
    				. $columnComment . "',"
//     				. $fIndex . ")->setWidth(100)->setEditable(true)"
    				. '++$seq'.")->setWidth(100)->setEditable(true)"
    				. ";"
    				;
    			}

    		}
    		$write_html[] = "</form>";

    		$list_html[] = '<table border="0" cellspacing="0" cellpadding="0" width="700"  id="tbl_list">';
    		$list_html[] = '    <thead></thead>';
    		$list_html[] = '    <tbody></tbody>';
    		$list_html[] = '    <tfoot style="height:100px"></tfoot>';
    		$list_html[] = '</table>';
    		$list_html[] = '';
    		$list_html[] = '<form id="sForm" name="sForm" method="POST" onsubmit="return 조회(1);">';
    		$list_html[] = '<div id="list_search">';
    		$list_html[] = '  <table width="700" border="0" cellspacing="0" cellpadding="0">';
    		$list_html[] = '    <tr>';
    		$list_html[] = '      <td width="140" align="center">';
    		$list_html[] = '      <a href=# onclick="return 입력();">입력</a>';
    		$list_html[] = '      </td>';
    		$list_html[] = '      <td height="40" align="center" style="vertical-align:middle"><select id="s_gubun"><option value="USER_EMAIL">아이디</option><option value="USER_NAME">회원명</option></select> <input type="text" name="s_search" id="s_search" /> <input type="image" src="'.SERVICE_BASE.'/images/btn_search.jpg" width="41" height="18" border="0" titie="검색" style="vertical-align:middle" align=absmiddle></td>';
    		$list_html[] = '      <td width="140" align="center">';
    		$list_html[] = '      <img src="'.SERVICE_BASE.'/images/btn_excel.jpg" width="85" height="18" title="검색결과저장" style="cursor:hand" onclick="파일다운로드();"/>';
    		$list_html[] = '      </td>';
    		$list_html[] = '    </tr>';
    		$list_html[] = '  </table>';
    		$list_html[] = '</div>';
    		$list_html[] = '</form>';

    		$list_js[] = 'function onInit(argus) {';
    		$list_js[] = '    Util.Load.script({src:serviceBase+"/ui/css/grid.css",type:"css"});';
    		$list_js[] = '    GRID.init({';
    		$list_js[] = '        requestDataType : "POST"        , // JSON, POST';
    		$list_js[] = '        responseDataType: "xml"         , // JSON, XML, TEXT';
    		$list_js[] = '        table_id    : "tbl_list"    , // Table Id';
    		$list_js[] = '        editevent   : "onclick"  , // onfocus, onclick, ondblclick : onclick과 onfous는 다르게 동작됨.';
    		$list_js[] = '        confirm     : false         ,';
    		$list_js[] = '        setting     : {';
    		$list_js[] = '            "delete": false,';
    		$list_js[] = '            "insert": false';
    		$list_js[] = '        },';
    		$list_js[] = '        service_infor:{';
    		$list_js[] = '            className  : "test.' . strtolower($className) . '.' . $className . '",';
    		$list_js[] = '            method     : { "list":"test.' . strtolower($className) . '.' . $className . '.select", "save":"save" },';
    		$list_js[] = '            argus      : {';
    		$list_js[] = '                p_navi_function:"조회"';
    		$list_js[] = '            }';
    		$list_js[] = '        },';
    		$list_js[] = '        onload:function(o) { // o.mode : I/U/D/M/R/SORT';
    		$list_js[] = '            // log(["onload mode : " + o.mode,o]);';
    		$list_js[] = '            if ( o.data.return == "200" ) {';
    		$list_js[] = '                if ( o.mode == "U" || o.mode == "D" ) alert(o.data.message);';
    		$list_js[] = '            }';
    		$list_js[] = '            onLoad(o,argus);';
    		$list_js[] = '        }';
    		$list_js[] = '';
    		$list_js[] = '//,        row:{';
    		$list_js[] = '//        	onclick:function(o) {';
    		$list_js[] = '//        		//        		console.debug(o);';
    		$list_js[] = '//        		getUI("test/'. strtolower($className) . '","write",{';
    		$list_js[] = '//        			method:"POST",';
    		$list_js[] = '//        			argus : {';
    		$list_js[] = '//        				' . join(",".PHP_EOL."//        				", $list_js_argus2) ."";
    		$list_js[] = '//        				//p_company_no:GRID.getValue(o.tId,o.tr.rowIndex,"company_no"),';
    		$list_js[] = '//        			},';
    		$list_js[] = '//        			target:"#contents",';
    		$list_js[] = '//        			loadui:false';
    		$list_js[] = '//        		});';
    		$list_js[] = '//        	}';
    		$list_js[] = '//        }';
    		$list_js[] = '';
    		$list_js[] = '    });';
    		$list_js[] = '    조회(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);';
    		$list_js[] = '}';
    		$list_js[] = '';
    		$list_js[] = 'function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT';
    		$list_js[] = '    $(".btn_modify").unbind("click");';
    		$list_js[] = '    $(".btn_modify").click(function(e) {';
    		$list_js[] = '        var tbl = $S("tbl_list");';
    		$list_js[] = '        if ( tbl == null ) return;';
    		$list_js[] = '        var td = GRID.cell.getTd($(this).get(0).parentNode);';
    		$list_js[] = '        var tr = td.parentNode;';
    		$list_js[] = '        //var userNo = tr.cells[0].innerText;';
    		$list_js[] = '        //companyNo = GRID.getValue(tbl,tr.rowIndex,"company_no");';
    		$list_js[] = '        // alert(tbl + " / " + companyNo );';
    		$list_js[] = '        //if ( SOFTMARGUMENT.p_user_level == 2 ) {';
    		$list_js[] = '        //}';
    		$list_js[] = '        getUI("test/' . strtolower($className) . '","write",{';
    		$list_js[] = '            method:"POST",';
    		$list_js[] = '            argus : {';
    		$list_js[] = '              ' . join(",".PHP_EOL."              ", $list_js_argus1) ."";
    		$list_js[] = '              //p_company_no:GRID.getValue(tbl,tr.rowIndex,"company_no"),';
    		$list_js[] = '            },';
    		$list_js[] = '            target:"#contents"';
    		$list_js[] = '            ,loadui:false';
    		$list_js[] = '        });';
    		$list_js[] = '        e.preventDefault();';
    		$list_js[] = '    });';
    		$list_js[] = '';
    		$list_js[] = '    $(".btn_delete").unbind("click");';
    		$list_js[] = '    $(".btn_delete").click(function(e) {';
    		$list_js[] = '      //              console.debug($(this));';
    		$list_js[] = '      var td = GRID.cell.getTd($(this).get(0).parentNode);';
    		$list_js[] = '      var tr = td.parentNode;';
    		$list_js[] = '      // console.debug(td);';
    		$list_js[] = '      // console.debug(tr.cells[0].innerText);';
    		$list_js[] = '      if( confirm("삭제하시겠습니까?") ) {';
    		$list_js[] = '      GRID.submit({';
    		$list_js[] = '          td:td,mode:"D"});';
    		$list_js[] = '          조회(1);';
    		$list_js[] = '          //onInit(SOFTMARGUMENT);';
    		$list_js[] = '      }';
    		$list_js[] = '      e.preventDefault();';
    		$list_js[] = '    });';
    		$list_js[] = '}';
    		$list_js[] = '';
    		$list_js[] = 'function 조회(s) {';
    		$list_js[] = '    var f = document.sForm;';
    		$list_js[] = '    //GRID["tbl_list"].setArgus("s_search"         ,f.s_search.value);';
    		$list_js[] = '    //GRID["tbl_list"].setCondition( "USER_LEVEL", ARGUS.p_user_level).setEqual();';
    		$list_js[] = '    //GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();';
    		$list_js[] = '    //GRID["tbl_list"].setArgus("s_search",f.s_search.value);';
    		$list_js[] = '';
    		$list_js[] = '    //setRestore("s_l_cat",f.s_l_cat.value);';
    		$list_js[] = '    setRestore("p_navi_start",s,true);';
    		$list_js[] = '    GRID["tbl_list"].load({pagenavi_pos:s});';
    		$list_js[] = '    return false;';
    		$list_js[] = '}';
    		$list_js[] = '';
    		$list_js[] = 'function 입력() {';
    		$list_js[] = '    getUI("test/' . strtolower($className) . '","write",{';
    		$list_js[] = '        method:"POST",';
    		$list_js[] = '        target:"#contents",';
    		$list_js[] = '        argus:{';
    		$pkSize = sizeof($pk_names);
    		foreach ($pk_names as $idx => $pk_name) {
    			//     			echo $idx . " / " . $pkSize . "<BR>";
    			$list_js[] = "        p_" .$pk_name .":''".($pkSize!=1 && $idx < $pkSize-1? ",":"");
    		}
    		$list_js[] = '        }';
    		$list_js[] = '    });';
    		$list_js[] = '    return false;';
    		$list_js[] = '';
    		$list_js[] = '}';
    		$list_js[] = 'function 파일다운로드() {';
    		$list_js[] = '	call("FORM","common.Common","saveDownload", ';
    		$list_js[] = '		{';
    		$list_js[] = '		p_file_nm:"\"' . ($argus[class_comment]?$argus[class_comment]:($tableComment?$tableComment:$className)) . '.xls\"",';
    		$list_js[] = '		p_data:';
    		$list_js[] = '		"<table>" +';
    		$list_js[] = '			$S("tbl_list").tHead.outerHTML +';
    		$list_js[] = '			$S("tbl_list").tBodies[0].outerHTML+';
    		$list_js[] = '		"</table>"';
    		$list_js[] = '		}';
    		$list_js[] = '	);';
    		$list_js[] = '}';
    		if ( $dateFieldInclude ) {
    			$write_js[] = 'if ( typeof(languageCode) == "undefined" ) {';
    			$write_js[] = '    Util.Load.script({src:serviceBase+"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});';
    			$write_js[] = '    Util.Load.script({src:serviceBase+"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});';
    			$write_js[] = '}';
    		}
    		$write_js[] = '';
    		$write_js[] = 'function onInit(argus) {';
    		$write_js[] = '    var f = $S("wForm");';
    		$write_js[] = '    if (jQuery.browser.msie) {}';
    		$write_js[] = '    if ( ' . join(" && ", $write_js_argus7) .") {";

    		$write_js[] = '    call("JSON","test.' . strtolower($className) . '.' . $className . '","get",';
    		$write_js[] = '        {';
    		$write_js[] = '			' . join(",".PHP_EOL."        				", $write_js_argus1) ."";
    		$write_js[] = '        },';
    		$write_js[] = '        function(xmlDoc){';
    		$write_js[] = '            var json  = Util.xml2json(xmlDoc);';
    		$write_js[] = '            var item = json.item;';
    		$write_js[] = '            if ( item ) {';
    		$write_js[] = '                if ( json["return"] == "200" ) { // success';
    		$write_js[] = '                    // alert(json.message); // success';
    		$write_js[] = '                    getPhp("test/' . strtolower($className) . '","write",{';
    		$write_js[] = '                        argus : {' . join(",".PHP_EOL."", $write_js_argus6) . '}';
    		$write_js[] = '                    });';
    		$write_js[] = '                    onDataLoad(json,argus);';
    		$write_js[] = '                } else if (json["return"] == "500") {';
    		$write_js[] = '                    alert(json.message); // error';
    		$write_js[] = '                }';
    		$write_js[] = '            } else {';
    		$write_js[] = '                alert("수정할 자료가 없습니다.");';
    		$write_js[] = '                목록();';
    		$write_js[] = '            }';
    		$write_js[] = '        }';

    		$write_js[] = '    );';
    		$write_js[] = '    } else {';
    		$write_js[] = '        onDataLoad(null,argus);';
    		//$write_js[] = '        ' . join(";" . PHP_EOL . "        ", $write_js_argus2) .";";
    		$write_js[] = '    // form.tel1.onfocus = Form.numeberOnly;';
    		$write_js[] = '    }';
    		$write_js[] = '';
    		$write_js[] = '}';
    		$write_js[] = '';
    		$write_js[] = 'function onDataLoad(json,argus) {';
    		$write_js[] = '    var f = document.wForm;';
    		$write_js[] = '    if(json) {';
    		$write_js[] = '        Form.bind(json.item,f,{';
    		$write_js[] = '//    company_code:function(f,vv) {';
    		$write_js[] = '//       if ( vv ) {';
    		$write_js[] = '//       f.company_code3.value = vv.substring(5);  ';
    		$write_js[] = '//       }';
    		$write_js[] = '//       }';
    		$write_js[] = '        });';
    		$write_js[] = '    }';
    		$write_js[] = '}';
    		$write_js[] = '';
    		$write_js[] = "function 실행() {";
    		$write_js[] = "    var f = \$S('wForm');";
    		if ( !empty($write_js_argus4) ) {
    			$write_js[] = '    if ( !(' . join('&&',$write_js_argus3) . ') ) { // 입력';
    			$write_js[] = '        ' . join(';'.PHP_EOL,$write_js_argus4) . PHP_EOL  . ';';
    			$write_js[] = '    } else {';
    			$write_js[] = '    }';
    		}
    		$write_js[] = "    var exec = false;";

    		//$write_js[] = "    var validation = ". join('&&',$write_js_argus3) . PHP_EOL . "?{" . PHP_EOL . join(",\n", $write_js_form_valid_argus_update)  . "}" . PHP_EOL . ":{" . PHP_EOL . join(",\n", $write_js_form_valid_argus_insert)  . "};";
    		$write_js[] = "    var invalidCb = {" . PHP_EOL . join(",".PHP_EOL."", $write_js_form_valid_argus_update)  . PHP_EOL ."};";
    		$write_js[] = "";
    		$write_js[] = "    if ( Form.validate(f ,invalidCb) ) {";
    		$write_js[] = '        if ( confirm("저장하시겠습니까?") ) {';
    		$write_js[] = '            exec = true;';
    		$write_js[] = '        }';
    		$write_js[] = '';
    		$write_js[] = "        if ( exec ) {";
    		$write_js[] = "        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE";
    		$write_js[] = "        //  call(requestType,className,method,argus,cb,form)";
    		if ( !empty($write_js_argus3) ) {
    			$write_js[] = "        //  call('FORM.FILE','test." . strtolower($className) . "." . $className . "'," . join('&&',$write_js_argus3). "?'update':'insert',";
    			$write_js[] = "            call('JSON','test." . strtolower($className) . "." . $className . "'," . join('&&',$write_js_argus3). "?'update':'insert',";
    		} else {
    			$write_js[] = "        alert('update/insert 조건 확인하세요.');";
    			$write_js[] = "        //  call('FORM.FILE','test." . strtolower($className) . "." . $className . "',true?'update':'insert',";
    			$write_js[] = "            call('JSON','test." . strtolower($className) . "." . $className . "',true?'update':'insert',";

    			$write_js[] = "        //  call('FORM.FILE','test." . strtolower($className) . "." . $className . "'," . join('&&',$write_js_argus3). "?'update':'insert',";
    			$write_js[] = "        //  call('JSON','test." . strtolower($className) . "." . $className . "'," . join('&&',$write_js_argus3). "?'update':'insert',";
    		}
    		$write_js[] = "                // 선택1";
    		$write_js[] = "//                {";
    		$write_js[] = "//" . join(",".PHP_EOL."//", $write_js_valid);
    		$write_js[] = "//                },";

    		$write_js[] = "                // 선택2";
    		$write_js[] = "                //{";
    		$write_js[] = "//" . join(",".PHP_EOL."//", $write_js_valid2);
    		$write_js[] = "                //},";
    		$write_js[] = "                Form.json(f),";
    		$write_js[] = "                function(xmlDoc){";
    		$write_js[] = "                    var json  = Util.xml2json(xmlDoc);";
    		$write_js[] = "                    if ( json['return'] == '200' ) { // success      ";
    		$write_js[] = "                        //console.debug(json.insert_id);";

    		if ( $autoIncreament ) {
    			$write_js[] = "                        if ( json.mode == 'I' ) {";
    			$write_js[] = "                            SOFTMARGUMENT.p_" .$pk_names[0] ." = json.insert_id;";
    			$write_js[] = "                        }";
    		} else {
    			$write_js[] = "                        if ( json.mode == 'I' ) {";
    			foreach ($pk_names as $idx => $pk_name) {
    				$write_js[] = "                            SOFTMARGUMENT.p_" .$pk_name ." = json.p_" .$pk_name .";";
    			}
    			$write_js[] = "                        }";
    		}
    		$write_js[] = "                        //\$S('btn_list').click();";
    		$write_js[] = "                        onInit(SOFTMARGUMENT);";
    		$write_js[] = "                        alert(json.message); // success";
    		$write_js[] = "                        목록();";
    		$write_js[] = "                    } else if (json['return'] == '500') {";
    		$write_js[] = "                        alert(json.message); // error";
    		$write_js[] = "                    }";
    		$write_js[] = "                }";
    		$write_js[] = "                // requestType이 FORM, FORM.FILE의 경우 ";
    		$write_js[] = "                //,f";
    		$write_js[] = "            );";
    		$write_js[] = "        }";
    		$write_js[] = "    }";
    		$write_js[] = "    return false;";
    		$write_js[] = "}";
    		$write_js[] = "";
    		$write_js[] = 'function 목록() {';
    		if ( $dateFieldInclude ) {
    			$write_js[] = '	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";';
    		}
    		$write_js[] = '	document.body.scrollTop = 0;';
    		$write_js[] = '	getUI("test/' . strtolower($className) . '","list");';
    		$write_js[] = '	return false;';
    		$write_js[] = '}';
    		$write_js[] = '';
    		$write_js[] = 'function 삭제() {';
    		$write_js[] = "    var f = \$S('wForm');";
    		$write_js[] = '    if( confirm("삭제하시겠습니까?") ) {';
    		$write_js[] = '        call("JSON","test.' . strtolower($className) . '.' . $className . '","delete",';
    		$write_js[] = '        {';
    		$write_js[] = '            ' . join(",".PHP_EOL."            ", $write_js_argus5) ."";
    		$write_js[] = '        },';
    		$write_js[] = '        function(xmlDoc){';
    		$write_js[] = '             var json  = Util.xml2json(xmlDoc);';
    		$write_js[] = '             if ( json["return"] == "200" ) { // success';
    		$write_js[] = '                 alert(json.message); // success';
    		$write_js[] = '                 목록();';
    		$write_js[] = '             } else if (json["return"] == "500") {';
    		$write_js[] = '                 alert(json.message); // error';
    		$write_js[] = '             }';
    		$write_js[] = '         }';
    		$write_js[] = '         );';
    		$write_js[] = '    }';
    		$write_js[] = 'return false;';
    		$write_js[] = '}';
    		$write_js[] = '';

    		$write_js[] = 'function fileDownload(fNo,fNm) {';
    		$write_js[] = '    alert(fNo + " / " + fNm);';
    		$write_js[] = '    call(\'FORM\',\'common.Common\',\'fileDownload\',';
    		$write_js[] = '        {';
    		$write_js[] = '        p_file_no:fNo,';
    		$write_js[] = '        p_file_nm:fNm,';
    		$write_js[] = '        p_sub_dir:"[디렉토리명]"';
    		$write_js[] = '     }';
    		$write_js[] = '    );';
    		$write_js[] = '} ';
    		$write_js[] = '';

    		$this->message->setObject("list_js"  ,join(PHP_EOL, $list_js  ));
    		$this->message->setObject("list_html",join(PHP_EOL, $list_html));

    		$this->message->setObject("write_js"  ,join(PHP_EOL, $write_js  ));
    		$this->message->setObject("write_html",join(PHP_EOL, $write_html));

    		if ( defined("debugging" ) ) {

    			$class_select = '    /**'.PHP_EOL
    			.'     * 조회-그리드'.PHP_EOL
    			.'     * @param array $argus'.PHP_EOL
    			.'     * @return DOMDocument'.PHP_EOL
    			.'     */'.PHP_EOL
    			.'    public function select($argus) {'.PHP_EOL
    			.'    	global $page_tab;'.PHP_EOL
    			.'    	//     $this->testJsCall($argus);'.PHP_EOL
    			.'//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);'.PHP_EOL
    			.'    	$this->getCodeData(); // code xml 생성'.PHP_EOL
    			.'    	$this->startHeader();'.PHP_EOL
    			.'    	$this->setType(BaseDataBase::GRID_TYPE);'.PHP_EOL
    			.'    	try {'.PHP_EOL
    			.'    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");'.PHP_EOL
    			.'//    		var_dump($argus);'.PHP_EOL
    			.'    		$page_tab[\'js_function\' ] = $argus["p_navi_function"];'.PHP_EOL
    			.'    		$page_tab[\'s\'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];'.PHP_EOL
    			.'    		if ( $page_tab[\'s\'] >= $page_tab[\'how_many\' ] + 1 ) $cur_many = $page_tab[\'more_many\']; else $cur_many = $page_tab[\'how_many\'];'.PHP_EOL
    			.''.PHP_EOL
    			.'    		// where 문장생성'.PHP_EOL
    			.'    		$make_where = $this->makeWhere($argus);'.PHP_EOL
    			.'    		$where = $make_where;'.PHP_EOL
    			.''.PHP_EOL
    			.'    		// row 갯수'.PHP_EOL
    			.'    		$page_tab[\'tot\'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_' . strtoupper($tblName) . ' . ( $where ? " WHERE " . $where:"" ) );'.PHP_EOL
    			.'    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());'.PHP_EOL
    			.''.PHP_EOL
    			.'    		$query = array();'.PHP_EOL
    			.'    		    		'.PHP_EOL
    			.'    		$query [] = " SELECT "' .';'.PHP_EOL
    			.  join(",\";".PHP_EOL."", $class_select_columns) ."\";".PHP_EOL
    			.'    		$query [] = " FROM " . TBL_' . strtoupper($tblName) . ';'.PHP_EOL
    			.''.PHP_EOL
    			.'    		// where 문장생성'.PHP_EOL
    			.'    		if ( $where ) $query[] = ( " WHERE " . $where );'.PHP_EOL
    			.''.PHP_EOL
    			.'    		$query[] =  ( $this->getQuerySort()?" ORDER BY ". $this->getQuerySort():\'\' );'.PHP_EOL
    			.'    		$query[] =  " LIMIT " . ( $page_tab[\'s\'] - 1 ) . ", " . $cur_many;'.PHP_EOL
    			.''.PHP_EOL
    			.'    		$this->setQuery(join(PHP_EOL, $query));'.PHP_EOL
    			.'//         out.print($this->getQuery());'.PHP_EOL
    			.''.PHP_EOL
    			.'    		$this->makeItemXML($this->getQuery(),"item","fieldinfo");'.PHP_EOL
    			.'    		//         out.print($this->db->getAffectedRows());'.PHP_EOL
    			.'    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.'.PHP_EOL
    			.'    	} catch (Exception $e) {'.PHP_EOL
    			.'    		$this->addErrMessage($e->getMessage());'.PHP_EOL
    			.'    	}'.PHP_EOL
    			.'    	$this->printXML(C_DB_PROCESS_MODE_SELECT);'.PHP_EOL
    			.'    }'.PHP_EOL
    			;

    			$this->message->setObject("sql_select", $class_select);

    			$class_get = '    /**'.PHP_EOL
    			.'     * 조회'.PHP_EOL
    			.'     * @param array $argus'.PHP_EOL
    			.'     * @return DOMDocument'.PHP_EOL
    			.'     */'.PHP_EOL
    			.'    public function get($argus) {'.PHP_EOL
    			.'        //$p_user_id   = $argus[user_email  ];'.PHP_EOL
    			.  join(PHP_EOL, $class_key_argus) .PHP_EOL
    			.'    '.PHP_EOL
    			.'        $this->testJsCall($argus);'.PHP_EOL
    			.'        $this->startHeader();'.PHP_EOL
    			.'        try {'.PHP_EOL
    			.'            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");'.PHP_EOL
    			.'            $query = array();'.PHP_EOL
    			.'            $query [] = "SELECT ";'.PHP_EOL
    			.  join(",\";".PHP_EOL."", $class_select_columns) ."\";".PHP_EOL
    			.'            $query [] = " FROM " . TBL_' . strtoupper($tblName) . ';'.PHP_EOL
    			.'            $query [] = " WHERE ";'.PHP_EOL
    			.  (!empty($class_update_wheres)?'' . join(" AND \";".PHP_EOL."", $class_update_wheres) ."\";".PHP_EOL:'')
    			.'            $this->setQuery(join(PHP_EOL, $query));'.PHP_EOL
    			.'    //         out.print($this->getQuery());'.PHP_EOL
    			.'            $this->makeItemXML($this->getQuery(),"item","fi");'.PHP_EOL
    			.'    //         	out.print($this->db->getAffectedRows());'.PHP_EOL
    			.'    //         	out.print($this->db->getErrMsg());'.PHP_EOL
    			.'            $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.'.PHP_EOL
    			.'        } catch (Exception $e) {'.PHP_EOL
    			.'            $this->addErrMessage($e->getMessage());'.PHP_EOL
    			.'        }'.PHP_EOL
    			.'        $this->printXML(C_DB_PROCESS_MODE_SELECT);'.PHP_EOL
    			.'    }'.PHP_EOL
    			;
    			$this->message->setObject("sql_get", $class_get);

    			$class_insert = '    /**'.PHP_EOL
    			.'     * 입력'.PHP_EOL
    			.'     * @param array $argus'.PHP_EOL
    			.'     * @return int'.PHP_EOL
    			.'     */'.PHP_EOL
    			.'    public function insert($argus) {'.PHP_EOL
    			.  join(PHP_EOL, $class_key_argus) .PHP_EOL
    			.'    '.PHP_EOL
    			.'        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_' . strtoupper($tblName) . ' ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );'.PHP_EOL
    			.'        //     	echo $cnt . "<BR>";'.PHP_EOL
    			.'        //$reg_code =sprintf(\'%s%s%04d\',\'KC\',date("Ymd"),$cnt);'.PHP_EOL
    			.'    '.PHP_EOL
    			.'        $this->testJsCall($argus);'.PHP_EOL
    			.'        $this->startHeader();'.PHP_EOL
    			.'        try {'.PHP_EOL
    			.'            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");'.PHP_EOL
    			.'            $query = array();'.PHP_EOL
    			.'            $query [] = "INSERT INTO " . TBL_' . strtoupper($tblName) . ';'.PHP_EOL
    			.'            $query [] = "(";'.PHP_EOL
    			.  join(",\";".PHP_EOL, $class_insert_columns) ."\";".PHP_EOL
    			.'            //$query [] = " REG_DATE ";'.PHP_EOL
    			.'            $query [] = " ) VALUES (";'.PHP_EOL
    			.  join(",\";".PHP_EOL, $class_insert_values) ."\";".PHP_EOL
    			.'            //$query [] = " now() ";'.PHP_EOL
    			.'            $query [] = " );";'.PHP_EOL
    			.'            $this->setQuery(join(PHP_EOL, $query));'.PHP_EOL
    			.'//            out.print($this->getQuery());'.PHP_EOL
    			.'            $this->db->setAutoCommit(false);'.PHP_EOL
    			.'            if ( $this->db->exec($this->getQuery()) ) {'.PHP_EOL

    			;

    			if ( $autoIncreament ) {
    				$class_insert .='                $insert_id = $this->db->getInsertId(); // insert id '.PHP_EOL
    				.'                $this->appendNode("insert_id", $insert_id);'.PHP_EOL
    				;
    			} else {
    				foreach ($pk_names as $idx => $pk_name) {
    					$class_insert .='                $this->appendNode("p_' . $pk_name.'",$argus['.$pk_name.']); // insert key value '.PHP_EOL
    					;
    				}
    			}
    			$class_insert .=
    			'//                out.print($this->db->getAffectedRows());'.PHP_EOL
    			.'            if ( !$this->db->commit() ) throw new Exception("입력처리중 에러가 발생하였습니다.");'.PHP_EOL

    			.'//                else {'.PHP_EOL
    			.'//                	$file_no1 = 0;'.PHP_EOL
    			.'////                 	echo DATA_DIR . DIRECTORY_SEPARATOR . '.$className.'::$SAVE_SUB_DIR;'.PHP_EOL
    			.'//                	$uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . '.$className.'::$SAVE_SUB_DIR); // 업로드 인스턴스 생성'.PHP_EOL
    			.'////                 	var_dump($uploader);'.PHP_EOL
    			.'//                	$uploader->getItem(\'file1\')->setSaveName("f1_".$no."_");'.PHP_EOL
    			.'//                	$uploader->upload(); '.PHP_EOL
    			.'//                	$f1 = $uploader->getItem(\'file1\');'.PHP_EOL
    			.'//// 					echo $f1->getErrorCode() . \'<BR>\';'.PHP_EOL
    			.'//                	if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {'.PHP_EOL
    			.'//                		$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_BBSNOTICE, USER_NO, $f1->getName(), $f1->getExt(), $f1->getSize());'.PHP_EOL
    			.'//                	}'.PHP_EOL
    			.'//                	if ( $file_no1 !=0 ) $updateInfor[] = " FILE_NO1 = \'" . $file_no1 . "\'";'.PHP_EOL
    			.'//                	if ( !empty($updateInfor) ) {'.PHP_EOL
    			.'//                		$this->db->setAutoCommit(false);'.PHP_EOL
    			.'//                		$this->exec('.PHP_EOL
    			.'//                				"UPDATE " .TBL_TBL_BBS_DATA_NOTICE . " SET"'.PHP_EOL
    			.'//                				. join(",\n", $updateInfor)'.PHP_EOL
    			.'//                				. " WHERE NO = \'" .$no . "\'"'.PHP_EOL
    			.'//                		);'.PHP_EOL
    			.'//                	'.PHP_EOL
    			.'//                		$this->db->commit();'.PHP_EOL
    			.'//                	}'.PHP_EOL
    			.'//                }'.PHP_EOL


    			.'            } else {'.PHP_EOL
    			.'//                out.print($this->db->getErrMsg());'.PHP_EOL
    			.'                throw new Exception($this->db->getErrMsg());'.PHP_EOL
    			.'//               throw new Exception("입력처리중 에러가 발생하였습니다.");'.PHP_EOL
    			.'            }'.PHP_EOL
    			.'        } catch (Exception $e) {'.PHP_EOL
    			.'            $this->addErrMessage($e->getMessage());'.PHP_EOL
    			.'            $this->db->rollback();'.PHP_EOL
    			.'        }'.PHP_EOL
    			.'        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_INSERT)); // 성공시 출력 메시지.'.PHP_EOL
    			.'        $this->printXML(C_DB_PROCESS_MODE_INSERT);'.PHP_EOL
    			.'    }'.PHP_EOL
    			;
    			$this->message->setObject("sql_insert",$class_insert);

    			$class_update = '    /**'.PHP_EOL
    			.'     * 수정'.PHP_EOL
    			.'     * @param array $argus'.PHP_EOL
    			.'     * @return boolean'.PHP_EOL
    			.'     */'.PHP_EOL
    			.'    public function update($argus) {'.PHP_EOL
    			.  join(PHP_EOL, $class_key_argus) .PHP_EOL
    			.'    '.PHP_EOL
    			.'        $this->testJsCall($argus);'.PHP_EOL
    			.'        $this->startHeader();'.PHP_EOL
    			.'        try {'.PHP_EOL
    			.'            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");'.PHP_EOL
    			.'            $query = array();'.PHP_EOL
    			.'            $query [] = "UPDATE " . TBL_' . strtoupper($tblName) . ';'.PHP_EOL
    			.'            $query [] = " SET";'.PHP_EOL
    			.  join(",\";".PHP_EOL, $class_update_columns) ."\";".PHP_EOL
    			.'            //$query [] = " MOD_DATE = now()";'.PHP_EOL
    			.'            $query [] = " WHERE ";'.PHP_EOL
    			.  (!empty($class_update_wheres)?'' . join(" AND \";".PHP_EOL, $class_update_wheres) ."\";".PHP_EOL:'')
    			.'            $this->setQuery(join(PHP_EOL, $query));'.PHP_EOL
    			.'//            out.print($this->getQuery());'.PHP_EOL
    			.'            $this->db->setAutoCommit(false);'.PHP_EOL
    			.'            if ( $this->db->exec($this->getQuery()) ) {'.PHP_EOL
    			.'//                out.print($this->db->getAffectedRows());'.PHP_EOL

    			.'//                    $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . '.$className.'::$SAVE_SUB_DIR;'.PHP_EOL
    			.'//                    $uploader  = new FileUpload(true,$saveDir); // 업로드 인스턴스 생성'.PHP_EOL
    			.'//'.PHP_EOL
    			.'//                    $f1 = $uploader->getItem(\'file1\')->setSaveName("f1_".$p_no."_");'.PHP_EOL
    			.'//                    if ( $argus[file1_delete] == \'Y\' ) {'.PHP_EOL
    			.'//                        @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );'.PHP_EOL
    			.'//                        Common::deleteFileInfor($this->db, $file_no1);'.PHP_EOL
    			.'//                        $file_no1 = 0;'.PHP_EOL
    			.'//                    }'.PHP_EOL
    			.'//                    /* @var BizConsult Table file no 갱신 */'.PHP_EOL
    			.'//                    $fileInforUpdate = array();'.PHP_EOL
    			.'//                    if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {'.PHP_EOL
    			.'//                        if ( !$file_no1 ) {'.PHP_EOL
    			.'//                            $file_no1 = Common::insertFileInfor($this->db, $proc_type, USER_NO, $f1->getName(), $f1->getExt(), $f1->getSize());'.PHP_EOL
    			.'//                            $fileInforUpdate[] = " FILE_NO1 = \'" . $file_no1 . "\'";'.PHP_EOL
    			.'//                        } else {'.PHP_EOL
    			.'//                            @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );'.PHP_EOL
    			.'//                            $file_no1 = Common::updateFileInfor($this->db, $file_no1, $f1->getName(), $f1->getExt(), $f1->getSize());'.PHP_EOL
    			.'//                        }'.PHP_EOL
    			.'//                        $f1->upload();'.PHP_EOL
    			.'//                    }'.PHP_EOL
    			.'//                    if ( !empty($fileInforUpdate) ) {'.PHP_EOL
    			.'//                        $this->exec('.PHP_EOL
    			.'//                                "UPDATE " .TBL_TBL_BBS_DATA_NOTICE . " SET"'.PHP_EOL
    			.'//                                . join(",\n", $fileInforUpdate)'.PHP_EOL
    			.'//                                . " WHERE NO = \'" .$p_no . "\'"'.PHP_EOL
    			.'//                        );'.PHP_EOL
    			.'//                    }'.PHP_EOL

    			.'                if ( !$this->db->commit() ) throw new Exception("수정처리중 에러가 발생하였습니다.");'.PHP_EOL
    			.'            } else {'.PHP_EOL
    			.'//                out.print($this->db->getErrMsg());'.PHP_EOL
    			.'                throw new Exception($this->db->getErrMsg());'.PHP_EOL
    			.'//               throw new Exception("수정처리중 에러가 발생하였습니다.");'.PHP_EOL
    			.'            }'.PHP_EOL
    			.'        } catch (Exception $e) {'.PHP_EOL
    			.'            $this->addErrMessage($e->getMessage());'.PHP_EOL
    			.'            $this->db->rollback();'.PHP_EOL
    			.'        }'.PHP_EOL
    			.'        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_UPDATE)); // 성공시 출력 메시지.'.PHP_EOL
    			.'        $this->printXML(C_DB_PROCESS_MODE_UPDATE);'.PHP_EOL
    			.'    }'.PHP_EOL
    			.''.PHP_EOL

    			.'    /**'.PHP_EOL
    			.'     * 저장'.PHP_EOL
    			.'     * @param array $argus'.PHP_EOL
    			.'     * @return string'.PHP_EOL
    			.'     */'.PHP_EOL
    			.'    public function save($argus) {'.PHP_EOL
    			.'        $p_mode  = $argus[\'mode\'][0];'.PHP_EOL
    			.  join(PHP_EOL, $class_key_argus) .PHP_EOL
    			.'//        if ( $p_mode == C_DB_PROCESS_MODE_DELETE ) {'.PHP_EOL
    			.'//            // 파일정보'.PHP_EOL
    			.'//            $query = array();'.PHP_EOL
    			.'//            $query [] = "SELECT ";'.PHP_EOL
    			.'//            $query [] = " FILE_NO1 ";'.PHP_EOL
    			.'//            $query [] = " FROM ". TBL_' . strtoupper($tblName) . ';'.PHP_EOL
    			.'//            $query [] = " WHERE ";'.PHP_EOL
    			.''. (!empty($class_update_wheres)?'//' . join("// AND \";".PHP_EOL, $class_update_wheres) ."\";".PHP_EOL:'')
    			.'//            $infor = $this->db->get(join(PHP_EOL, $query));'.PHP_EOL
    			.'//'.PHP_EOL
    			.'//            $file_no1 = $infor->FILE_NO1;'.PHP_EOL
    			.'//        }'.PHP_EOL
    			.'//        if ( $p_mode == C_DB_PROCESS_MODE_DELETE ) {'.PHP_EOL
    			.'//            if (parent::save($argus,false)) {'.PHP_EOL
    			.'//                $oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no1),"FILE_NO,FILE_EXT");'.PHP_EOL
    			.'//                $oldFile1Ext = $oldFileInfor[\'FILE_NO1\']->FILE_EXT;'.PHP_EOL
    			.'//'.PHP_EOL
    			.'//                // 파일 삭제.'.PHP_EOL
    			.'//                $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . '.$className.'::$SAVE_SUB_DIR;'.PHP_EOL
    			.'//                @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );'.PHP_EOL
    			.'//                Common::deleteFileInfor($this->db, $file_no1);'.PHP_EOL
    			.'//                $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.'.PHP_EOL
    			.'//'.PHP_EOL
    			.'//            } else {'.PHP_EOL
    			.'//                $this->addErrMessage("저장중 오류발생 : 확인하세요.");'.PHP_EOL
    			.'//            }'.PHP_EOL
    			.'//            $this->printXML(C_DB_PROCESS_MODE_PROC);'.PHP_EOL
    			.'//'.PHP_EOL
    			.'//        } else {'.PHP_EOL
    			.'            parent::save($argus);'.PHP_EOL
    			.'//        }'.PHP_EOL
    			.'    } '.PHP_EOL

    			.'//    /**'.PHP_EOL
    			.'//     * 저장'.PHP_EOL
    			.'//     * @param array $argus'.PHP_EOL
    			.'//     * @return string'.PHP_EOL
    			.'//     */'.PHP_EOL
    			.'//    public function save($argus) {'.PHP_EOL
    			.'//    	$p_mode       = $argus[\'mode\'][0];'.PHP_EOL
    			.'//'.   join(PHP_EOL.'//', $class_key_argus) .PHP_EOL    			
    			.'//    	if (parent::save($argus,false)) {'.PHP_EOL
    			.'//    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.'.PHP_EOL
    			.'//    	} else {'.PHP_EOL
    			.'//    		$this->addErrMessage("저장중 오류가발생하였습니다.");'.PHP_EOL
    			.'//    	}'.PHP_EOL
    			.'//    	$this->printXML(C_DB_PROCESS_MODE_PROC);'.PHP_EOL
    			.'//    }'.PHP_EOL
    			;
    			$this->message->setObject("sql_update",$class_update);

    			$class_delete = '    /**'.PHP_EOL
    			.'     * 삭제'.PHP_EOL
    			.'     * @param array $argus'.PHP_EOL
    			.'     * @return boolean'.PHP_EOL
    			.'     */'.PHP_EOL
    			.'    public function delete($argus) {'.PHP_EOL
    			.  join(PHP_EOL, $class_key_argus) .PHP_EOL
    			.'    '.PHP_EOL
    			.'        $this->testJsCall($argus);'.PHP_EOL
    			.'        $this->startHeader();'.PHP_EOL
    			.'        try {'.PHP_EOL
    			.'            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");'.PHP_EOL

    			.'            // 파일정보'.PHP_EOL
    			.'            $query = array();'.PHP_EOL
    			.'            $query [] = "SELECT ";'.PHP_EOL
    			.'            $query [] = " FILE_NO1 ";'.PHP_EOL
    			.'            $query [] = " FROM ". TBL_' . strtoupper($tblName) . ';'.PHP_EOL
    			.'            $query [] = " WHERE ";'.PHP_EOL
    			.  (!empty($class_update_wheres)?'' . join(" AND \";".PHP_EOL, $class_update_wheres) ."\";".PHP_EOL:'')
    			.'            $infor = $this->db->get(join(PHP_EOL, $query));'.PHP_EOL
    			.''.PHP_EOL
    			.'            $file_no1 = $infor->FILE_NO1;'.PHP_EOL

    			.'            $query = array();'.PHP_EOL
    			.'            $query [] = "DELETE FROM " . TBL_' . strtoupper($tblName) . ';'.PHP_EOL
    			.'            $query [] = " WHERE ";'.PHP_EOL
    			.  (!empty($class_update_wheres)?'' . join(" AND \";".PHP_EOL, $class_update_wheres) ."\";".PHP_EOL:'')
    			.'            $this->setQuery(join(PHP_EOL, $query));'.PHP_EOL
    			.'//            out.print($this->getQuery());'.PHP_EOL

    			.'            $this->db->setAutoCommit(false);'.PHP_EOL
    			.'            if ( $this->db->exec($this->getQuery()) ) {'.PHP_EOL
    			.'//                out.print($this->db->getAffectedRows());'.PHP_EOL
    			.''.PHP_EOL
    			.'                // 담당자정보 삭제.'.PHP_EOL
    			.'                // if ( !Worker::externalDelete($this->db, array(p_worker_no=>$p_worker_no)) ) throw new Exception($this->db->getErrMsg());'.PHP_EOL
    			.''.PHP_EOL
    			.'                $oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no1),"FILE_NO,FILE_EXT");'.PHP_EOL
    			.'                $oldFile1Ext = $oldFileInfor[\'FILE_NO1\']->FILE_EXT;'.PHP_EOL
    			.''.PHP_EOL
    			.'                // 파일 삭제.'.PHP_EOL
    			.'                $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . '.$className.'::$SAVE_SUB_DIR;'.PHP_EOL
    			.'                @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );'.PHP_EOL
    			.'                Common::deleteFileInfor($this->db, $file_no1);'.PHP_EOL

    			.'                if ( !$this->db->commit() ) throw new Exception("삭제처리중 에러가 발생하였습니다.");'.PHP_EOL
    			.'            } else {'.PHP_EOL
    			.'                throw new Exception($this->db->getErrMsg());'.PHP_EOL
    			.'//               throw new Exception("삭제처리중 에러가 발생하였습니다.");'.PHP_EOL
    			.'            }'.PHP_EOL
    			.''.PHP_EOL

                .'        } catch (Exception $e) {'.PHP_EOL
    			.'            $this->addErrMessage($e->getMessage());'.PHP_EOL
    			.'            $this->db->rollback();'.PHP_EOL
    			.'        }'.PHP_EOL
    			.'        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_DELETE)); // 성공시 출력 메시지.'.PHP_EOL
    			.'        $this->printXML(C_DB_PROCESS_MODE_DELETE);'.PHP_EOL
    			.'    }'.PHP_EOL
    			;
    			$this->message->setObject("sql_delete",$class_delete);

    			$class_all_source = '<?php' . PHP_EOL
    			. 'define("DEBUG",preg_match("/\/service\/classes/", $_SERVER[PHP_SELF]));' . PHP_EOL
    			. 'define("TBL_'.strtoupper($tblName).'","'.$datbaseName.'.'.$tblName.'");' . PHP_EOL

    			. 'if ( DEBUG ) {' . PHP_EOL
    			. '   require_once \'../../../lib/common.lib.inc\' ; // 라이브러리' . PHP_EOL
    			. '   require_once SERVICE_DIR . \'/classes/common/Session.php\'          ; // 세션 ' . PHP_EOL
    			. '}' . PHP_EOL
    			. 'require_once SERVICE_DIR . \'/classes/BaseDataBase.php\'; // 기본 DataBase 클래스' . PHP_EOL
    			. 'require_once SERVICE_DIR . \'/classes/common/Util.php\'; // Util클래스' . PHP_EOL
    			. 'require_once SERVICE_DIR . \'/classes/common/Common.php\'; // Common클래스' . PHP_EOL
    			. 'require_once SERVICE_DIR . \'/classes/common/FileUpload.php\'; // 파일업로드클래스' . PHP_EOL
    			. '/**' . PHP_EOL
    			. ' * @author softm' . PHP_EOL
    			. ' * ' . ($argus[class_comment]?$argus[class_comment]:$tableComment) . ' / ' . $className  . '.php' . PHP_EOL
    			. ' */' . PHP_EOL
    			. 'class ' . $className . ' extends BaseDataBase' . PHP_EOL
    			. '{' . PHP_EOL
    			. '    public function __construct() {' . PHP_EOL
    			. '        parent::__construct();' . PHP_EOL
    			. '        $this->debug = true;' . PHP_EOL
    			. '        $this->start();' . PHP_EOL
    			. '        if ( METHOD == "select" || METHOD == "save"  ) {' . PHP_EOL
    			. '			$tbl1 = $this->newTable(TBL_' . strtoupper($tblName) . ');' . PHP_EOL
    			. '			$seq = 0;' . PHP_EOL
    			. join(PHP_EOL, $select_new_column) . PHP_EOL
    			. "//	        \$tbl1->newColumn('USER_NO'   ,'번호'       ,".('++$seq').")->setAlign('center');" . PHP_EOL
    			. "//	        \$tbl1->newColumn('USER_NO'   ,'회원명'     ,".('++$seq').")->setEditable(true);" . PHP_EOL
    			. "//	        \$tbl1->newColumn('USER_LEVEL','레벨'       ,".('++$seq').")->setType(Column::LISTBOX_TYPE)->setEditable(true);" . PHP_EOL
    			. "//	        \$tbl1->newColumn('USER_NO'   ,'번호'       ,".('++$seq').")->setAlign('center');" . PHP_EOL
    			. "//	        \$tbl1->newColumn('REG_DATE'  ,'가입일'     ,".('++$seq').")->setKey(false);" . PHP_EOL
    			. '//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);' . PHP_EOL
    			. "//			\$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);" . PHP_EOL
//     			. "			\$tbl1->newColumn(\"<img src='".SERVICE_BASE."/images/btn_ico_modify.jpg' class=btn_modify><img src='".SERVICE_BASE."/images/btn_ico_del.jpg' class=btn_delete>\",'수정/삭제'  ,".($fIndex+1).")" . PHP_EOL
//     			. "			\$tbl1->newColumn(\"<img src='".SERVICE_BASE."/images/btn_ico_modify.jpg' class=btn_modify><img src='".SERVICE_BASE."/images/btn_ico_del.jpg' class=btn_delete>\",'수정/삭제'  ,".('++$seq').")" . PHP_EOL
//     			. "				 ->setDbColumn(false)->setWidth(100)->setHtml(true)->setAlias('BTN')->setType(Column::TEXT_TYPE);" . PHP_EOL

    			. "			\$tbl1->newColumn(\"BTN1\"     ,'수정'  ,++\$seq)->setWidth(\"100\")->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)" . PHP_EOL
    			. "			->setValue(\"<a class='btn_edit btn_modify' >수정</a>\");" . PHP_EOL
    			. "			\$tbl1->newColumn(\"BTN2\"     ,'삭제'  ,++\$seq)->setWidth(\"100\")->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)" . PHP_EOL
    			. "			->setValue(\"<a class='btn_edit btn_delete' >삭제</a>\");" . PHP_EOL

    			. '        }' . PHP_EOL
    			. '    }' . PHP_EOL

    			. '' . PHP_EOL
    			. '    public function __destruct() {' . PHP_EOL
    			. '        parent::__destruct();' . PHP_EOL
    			. '        $this->end();' . PHP_EOL
    			. '    }' . PHP_EOL
    			. '    ' . PHP_EOL
    			. '    /**' . PHP_EOL
    			. '     * test' . PHP_EOL
    			. '     * @param array $argus' . PHP_EOL
    			. '     */' . PHP_EOL
    			. '    function test(array $argus) {' . PHP_EOL
    			. '//       $p_user_id   = $argus[user_email  ];' . PHP_EOL
    			. '    ' . PHP_EOL
    			. '       $this->testJsCall($argus);' . PHP_EOL
    			. '       $this->startHeader();' . PHP_EOL
    			. '       try {' . PHP_EOL
    			. '' . PHP_EOL
    			. '       } catch (Exception $e) {' . PHP_EOL
    			. '           $this->addErrMessage($e->getMessage());' . PHP_EOL
    			. '       }' . PHP_EOL
    			. '       $this->printXML(C_DB_PROCESS_MODE_PROC);' . PHP_EOL
    			. '    }' . PHP_EOL
    			. '    ' . PHP_EOL
    			. $class_select  . PHP_EOL
    			. '    ' . PHP_EOL
    			. $class_get  . PHP_EOL
    			. '    ' . PHP_EOL
    			. $class_insert  . PHP_EOL
    			. '    ' . PHP_EOL
    			. $class_update  . PHP_EOL
    			. '    ' . PHP_EOL
    			. $class_delete  . PHP_EOL
    			. '    ' . PHP_EOL
    			. '    /**' . PHP_EOL
    			. '     * code를 array화한다.' . PHP_EOL
    			. '     */' . PHP_EOL
    			. '    public function getCodeData() {' . PHP_EOL
    			. '       // CODE DATA 정의' . PHP_EOL
    			. '//         $this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);' . PHP_EOL
    			. '//         $this->addCodeData("SEX"       , self::$CODE_SEX       );' . PHP_EOL
    			. '//         $this->addCodeData("STATE"     , self::$CODE_USER_STATE);' . PHP_EOL
    			. '//         $this->addCodeData("EMAIL_YN"  , self::$CODE_YN    );' . PHP_EOL
    			. '    }' . PHP_EOL
    			. '}' . PHP_EOL
    			. 'if ( DEBUG ) {' . PHP_EOL
    			. '   // # test path : ' . HTTP_URL . $argus[class_base] . '/' . $className . '.php' . PHP_EOL
    			. '   $test = new ' . $className . '();' . PHP_EOL
    			. '   $argus = array();' . PHP_EOL
    			. '' . PHP_EOL
    			. '   // test ' . PHP_EOL
    			. '   $argus[user_email] = "test01";' . PHP_EOL
    			. '   $test->setTableName(TBL_' . strtoupper($tblName). ' );' . PHP_EOL
    			. '   $test->test($argus);' . PHP_EOL
    			. '/*' . PHP_EOL
    			. '' . PHP_EOL
    			. '   // insert ' . PHP_EOL
    			. join(PHP_EOL, $class_insert_argus) . PHP_EOL
    			. '   $insert_id = $test->insert($argus);' . PHP_EOL
    			. "   out.print('\$insert_id : ' . \$insert_id . '<BR>');" . PHP_EOL
    			. '' . PHP_EOL
    			. '   // update ' . PHP_EOL
    			. '   // key field ' . PHP_EOL
    			. join(PHP_EOL, $sql_key_argus) . PHP_EOL
    			. '   // data field ' . PHP_EOL
    			. join(PHP_EOL, $class_update_argus) . PHP_EOL
    			. "   out.print(\$test->update(\$argus)); " . PHP_EOL
    			. '' . PHP_EOL
    			. '   // delete' . PHP_EOL
    			. join(PHP_EOL, $sql_key_argus) . PHP_EOL
    			. "   out.print(\$test->delete(\$argus)); " . PHP_EOL
    			. '' . PHP_EOL
    			. '   select' . PHP_EOL
    			. join(PHP_EOL, $sql_key_argus) . PHP_EOL
    			. "   \$test->select(\$argus); " . PHP_EOL
    			. '' . PHP_EOL
    			. '*/' . PHP_EOL
    			. '}' . PHP_EOL
    			. '?>' . PHP_EOL
    			;
    			$this->message->setObject("class_all_source",$class_all_source);
    			//     			echo $argus[save_file];
    			if ( $argus[save_file] =='Y' ) {
    				$class_dir = SERVICE_DIR . DIR_SEP . "classes" . DIR_SEP . "test" . DIR_SEP . strtolower($className);
    				@mkdir($class_dir);

    				// 					Util::writeUTF8File($class_dir . DIR_SEP . $className. ".php",$class_all_source);
    				Util::writeFile($class_dir . DIR_SEP . $className. ".php",$class_all_source);

    				$ui_dir = SERVICE_DIR . DIR_SEP . "ui" . DIR_SEP . "test" . DIR_SEP . strtolower($className);
    				@mkdir($ui_dir);
    				@mkdir($ui_dir . DIR_SEP . "js"  );
    				@mkdir($ui_dir . DIR_SEP . "css" );

    				Util::writeUTF8File($ui_dir . DIR_SEP . "list.php",join(PHP_EOL, $list_html  ));
    				Util::writeUTF8File($ui_dir . DIR_SEP . "js". DIR_SEP . "list.js",join(PHP_EOL, $list_js  ));

    				Util::writeUTF8File($ui_dir . DIR_SEP . "write.php",join(PHP_EOL, $write_html  ));
    				Util::writeUTF8File($ui_dir . DIR_SEP . "js". DIR_SEP . "write.js",join(PHP_EOL, $write_js  ));

    				Util::writeUTF8File($ui_dir . DIR_SEP . "css". DIR_SEP . "default.css"  ,join(PHP_EOL, $default_css ));
    				Util::writeUTF8File($ui_dir . DIR_SEP . "css". DIR_SEP . "list.css"     ,join(PHP_EOL, $list_css    ));
    				Util::writeUTF8File($ui_dir . DIR_SEP . "css". DIR_SEP . "write.css"    ,join(PHP_EOL, $write_css   ));
    			}
    		}
    	}

    }
    /**
     * code를 array화한다.
     */
    public function getCodeData() {
    	// CODE DATA 정의
//     	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
//     	$this->addCodeData("SEX"       , self::$CODE_SEX       );
//     	$this->addCodeData("STATE"     , self::$CODE_USER_STATE);
//     	$this->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    }
}
if ( DEBUG ) {
	define("debugging",true);
	$test = new Test();

	/* test */
	$argus = array();
	$argus[class_base] = "/service/classes/front";

	/* Biz - 비지니스상담/매칭 */
// 	$argus[class_name] = "Biz";
// 	$argus[class_comment] = "비지니스상담/매칭";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_BIZ_CONSULT);

	/* CompanyProduct - 기업정보 - 생산제품 및 취급품목 */
// 	$argus[class_name] = "CompanyProduct";
// 	$argus[class_comment] = "기업정보 - 생산제품 및 취급품목";
// 	$argus[class_base] = "/service/classes/front";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_COMPANY_PRODUCT);

	/* InterestCompany - 관심기업 */
// 	$argus[class_name] = "InterestCompany";
// 	$argus[class_comment] = "관심기업";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_INTEREST_COMPANY);

	/* Worker - 담당자정보 */
// 	$argus[class_name] = "Worker";
// 	$argus[class_comment] = "담당자정보";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_WORKER);

	/* Engineer - 기술자 정보 */
// 	$argus[class_name] = "Engineer";
// 	$argus[class_comment] = "기술자 정보";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_ENGINEER);

	/* EngineerCareer - 기술자 경력사항 */
// 	$argus[class_name] = "EngineerCareer";
// 	$argus[class_comment] = "기술자 경력사항";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_ENGINEER_CAREER);

	/* EngineerAdviser - 지도 실적 및 경험 */
// 	$argus[class_name] = "EngineerAdviser";
// 	$argus[class_comment] = "지도 실적 및 경험";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_ENGINEER_ADVISER);

	/* EngineerAdviserField - 지도가능분야 */
// 	$argus[class_name] = "EngineerAdviserField";
// 	$argus[class_comment] = "지도가능분야";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_ENGINEER_ADVISER_FIELD);

	/* InterestEngineer - 관심기술자 */
// 	$argus[class_name] = "InterestEngineer";
// 	$argus[class_comment] = "관심기술자";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_INTEREST_ENGINEER);

	/* EngineerConsult - 기술자매칭 */
// 	$argus[class_name] = "EngineerConsult";
// 	$argus[class_comment] = "기술자매칭";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_ENGINEER_CONSULT);

	/* EngineerConsultEngineer - 기술자 선택정보 */
// 	$argus[class_name] = "EngineerConsultEngineer";
// 	$argus[class_comment] = "기술자 선택정보";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_ENGINEER_CONSULT_ENGINEER);

	/* EngineerConsultAdminComment - 기술자 매칭 관리자 */
// 	$argus[class_name] = "EngineerConsultAdminComment";
// 	$argus[class_comment] = "기술자 매칭 관리자";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_ENGINEER_CONSULT_ADMIN_COMMENT);

	/* EngineerConsultMonthlyUseplan - 일본기술자 활용 월별 계획 */
// 	$argus[class_name] = "EngineerConsultMonthlyUseplan";
// 	$argus[class_comment] = "일본기술자 활용 월별 계획";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_ENGINEER_CONSULT_MONTHLY_USEPLAN);

	/* TechConsult - 기술니즈신청 & 기술시드매칭신청 */
// 	$argus[class_name] = "TechConsult";
// 	$argus[class_comment] = "기술니즈신청 & 기술시드매칭신청";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_TECH_CONSULT);

	/* TechSeed - 기술시드 */
// 	$argus[class_name] = "TechSeed";
// 	$argus[class_comment] = "기술시드";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_TECH_SEED);

	/* TechCategory - 기술분류 */
// 	$argus[class_name] = "TechCategory";
// 	$argus[class_comment] = "기술분류";
// 	$argus[user_email] = "test01";
// 	$test->setTableName(TBL_TECH_CATEGORY);

	$test->test($argus);
}
?>