<?
/*
 Filename        : /admin.php
 Fuction         : 관리자
 Comment         :
 시작 일자       : 2012-04-08,
 수정 일자       : 2012-04-08, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?
require_once 'lib/common.lib.inc'; // 공통인클루드.
require_once SERVICE_DIR . '/classes/common/Session.php';
require_once SERVICE_DIR . '/classes/common/Util.php';
if ( !LOGIN ) {
    Session::setSession("backurl", $_SERVER[PHP_SELF]);
    $ui_dir = "front/member";
    $ui_name = "login";
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<title>MYONGJI UNIVERSITY</title>
	<script type="text/javascript">
	<!--
	var p_hash   = '<?=md5('rlawlgns' . date ("Y-m-d"))?>';
	var LOGIN     = <?=LOGIN?"true":"false"?>;
	var ADMIN     = <?=ADMIN?"true":"false"?>;
	var USER_LEVEL= "<?=USER_LEVEL?>";
	var USER_NO   = "<?=USER_NO?>";
	var USER_ID   = "<?=USER_ID?>";
	var COMPANY_NO= "<?=COMPANY_NO?>";
	var SERVICE_BASE = "<?=SERVICE_BASE?>";
	//-->
	</script>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/jquery-1.7.1.js"></script><script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/softm.jquery.js"></script>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/softm.grid.js"></script>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/json2.js"></script>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/jquery.zclip.js"></script>
</HEAD>

<BODY>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/session.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
var di = null;
var ti = null;

$(document).ready(function(){
<?if ( !LOGIN ) {?>
    getUI("front/member","login",{
        params:"<?=$params?>",
        method:'POST',
        target:"#contents",
        lib_include:true,
        loadjs:true,
        loadcss:true,
        cb:function() {
        },
        test:true
    });
<?} else {?>
    document.title = "makeClass-Tester";
    $S("test_btn").onclick = function() {
    	$N("save_file")[0].value = "N";
    	exec();
    };

    callJSONSync('Test','testJsDatabaseInfor',
            // 선택1
            {
            },
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                // console.debug(json);
                var data = eval("(" + json.infors + ")");
                var o = {'':'전체'};
                o = json_merge(o,data);
					di = Create.listBox({name:'database_infors',value:data});
                	$S("database_infors_area").appendChild(
                			di
					);

                	di.onchange = function() {
    					if ($N("table_infors")[0]) $S("table_infors_area").removeChild($N("table_infors")[0]);
    					callJSONSync('Test','testJsTableInfor',
			                    // 선택1
			                    {
			            			database:this.value
			                    },
			                    function(xmlDoc){
			                        var json  = Util.xml2json(xmlDoc);
			                        var data = eval("(" + json.infors + ")");
			                        var o = {'':'전체'};
			                        o = json_merge(o,data);
			                        ti = Create.listBox({name:'table_infors',value:data});
			                    	$S("table_infors_area").appendChild(
			                    			ti
			    					);
			        	    		//ti = $N("table_infors")[0];
			        	    		ti.onchange = function() {
			    	    	    		$S("test_btn").onclick();
			        	    		}
			                    }
			                );
			            ti.onchange();
					}
    	    		di.onchange();
            }
        );

    $("#makefile_btn").click( function() {
        if ( confirm("파일을 생성하시겠습니까?") ) {
	    	$N("save_file")[0].value = "Y";
	    	if ( $S("file_gb").value == "1" ) {
		    	if ( $N("table_infors") ) {
	    			exec();
		    	} else {
		    	}
				alert("파일이 생성되었습니다");
	    	} else if ( $S("file_gb").value == "2" ) {
		    	var l = ti.options.length;
				for ( var i=0;i<l;i++) {
					//alert("i:" + i );
					ti.selectedIndex = i;
					exec();
				}
				alert("총 " + l + "파일이 생성되었습니다");
	    	}
        }
    });
<?}?>
});
<?if ( LOGIN ) {?>
    function exec() {
	// console.debug(ti.options);
		callJSONSync('Test','test',
            // 선택1
            {
            //class_name:"InterestCompany",
            class_comment:ti.options[ti.selectedIndex].text.split('->')[1],
            class_table:$N("table_infors")[0].value,
            datbase_name:$N("database_infors")[0].value,
            save_file:$N("save_file")[0].value,
            debugging:true
            },
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                //console.debug(json);
                //alert(json.return);
                //var database_infors = eval("new Array(" + json.database_infors + ")");
                //alert(database_infors);
                //alert( json.database_infors );
                var d = eval("(" + json.database_infors + ")");
                    $S("list_js"  ).value = toValue(json.list_js);
                    $S("list_html").value = toValue(json.list_html);
                    $S("write_js"  ).value = toValue(json.write_js);
                    $S("write_html").value = toValue(json.write_html);
                    $S("sql_select"     ).value = toValue(json.sql_select     );
                    $S("sql_get"        ).value = toValue(json.sql_get        );
                    $S("sql_insert"     ).value = toValue(json.sql_insert     );
                    $S("sql_update"     ).value = toValue(json.sql_update     );
                    $S("sql_delete"     ).value = toValue(json.sql_delete     );
                    $S("class_all_source" ).value = toValue(json.class_all_source );
                if ( json["return"] == '200' ) { // success
                	//alert(json.message); // success
                } else if (json["return"] == '500') {
                    //alert(json.message); // error
                }
            }
        );
    }
<?}?>
//-->
</script>
<style>
#_logger { position:fixed; _position:absolute; left:1000px; top:200px; width:700px; height:200px; background:#CCC;}
</style>
 </head>
 <body>
    <div id="contents" style="text-align:left">
<?if ( LOGIN ) {?>
    <table border=1 style="width:100%;display:none1">
      <tr>
        <td colspan=4>
        <span id='database_infors_area'>
        </span>
        <span id='table_infors_area'>
        </span>
        <input type=hidden name="save_file" value="N">
        <button id="test_btn">테스트</button>
    / 구분
    <select id="file_gb">
        <option value=1>선택테이블</option>
        <option value=2>디비 전체</option>
    </select>
            <button id="makefile_btn">파일생성</button>
<?php
echo "<B><a href='".LOGOUT_URL."'>" . (LOGIN?"로그아웃":"") . "</a></B>";
?>
        </td>
      </tr>
      <tr>
        <td>
        <textarea id="list_js" style="width:100%;height:200px"></textarea>
        </td>
        <td>
        <textarea id="list_html" style="width:100%;height:200px"></textarea>
        </td>
        <td>
        <textarea id="write_js" style="width:100%;height:200px"></textarea>
        </td>
        <td colspan=2>
        <textarea id="write_html" style="width:100%;height:200px"></textarea>
        </td>
      </tr>

      <tr>
        <td>
        <textarea id="sql_select"      style="width:100%;height:200px"></textarea>
        </td>
        <td>
        <textarea id="sql_get"         style="width:100%;height:200px"></textarea>
        </td>
        <td>
        <textarea id="sql_insert"      style="width:100%;height:200px"></textarea>
        </td>
        <td>
        <textarea id="sql_update"      style="width:100%;height:200px"></textarea>
        </td>
        <td>
        <textarea id="sql_delete"      style="width:100%;height:200px"></textarea>
        </td>
      </tr>

      <tr>
        <td colspan=5>
       <textarea id="class_all_source"  style="width:100%;height:200px"></textarea>
        </td>
      </tr>
      </table>
<?}?>
    </div>
<?
require(SERVICE_DIR . "/inc/footer.inc"); // footer
?>
</body>
</html>
