<?
$print_no = $tot - $s + 2;

$sql  = "select name, user_id, e_mail, reg_date from $tb_member";
$sql .= $where;

$sql .= ' order by reg_date desc';

$sql .= " limit " . ( $s - 1 ) . ", " . $how_many;
$stmt = multiRowSQLQuery($sql);

while ( $row = multiRowFetch  ($stmt) ) {
    $print_no--;
    $reg_date = $row['reg_date'];
    $name     = $row['name'    ];
    $user_id  = $row['user_id' ];
    $e_mail   = $row['e_mail'  ];
?>
                                  <tr> 
                                    <td bgcolor="F7F7F7" class="text_01" align="center"><?=$print_no?></td>
                                    <td bgcolor="F7F7F7" class="text_03" align="center"><b><a href='#' onClick='setOperatorID("<?=$user_id?>","<?=$name?>");return false;'><?=$name?></a></b></td>
                                    <td bgcolor="F7F7F7" class="text_03" align="center"><b><a href='#' onClick='setOperatorID("<?=$user_id?>","<?=$name?>");return false;'><?=$user_id?></a></b></td>
                                    <td bgcolor="F7F7F7" class="text_03" align="center"><b><a href='#' onClick='setOperatorID("<?=$user_id?>","<?=$name?>");return false;'><?=$e_mail?></a></b></td>
                                    <td bgcolor="F7F7F7" class="text_03" align="center"><a href='#' onClick='setOperatorID("<?=$user_id?>","<?=$name?>");return false;'>»Æ¿Œ</a></td>

<SCRIPT LANGUAGE="JavaScript">
<!--
	var form_name = '<?=$form_name?>';
    function setOperatorID(user_id,name) {
		var formObj = eval ('opener.document.' + form_name);
        var operatorID = formObj.operator_id.value;
        var ID = operatorID.split(",");
        var currentMany = ID.length;
        var appendID   = '';
        var addStr     = '';
        currentMany++;
        if ( operatorID == '' ) {
            appendID = "'" + user_id + "'";
            addStr  += name + '  &nbsp;<span class="text_03">[ <B>' + user_id + '</B> ]</span> ';
        } else {
            appendID = ",'" + user_id + "'";
            if ( ( currentMany % 3 ) == 1 ) {
                addStr += ", <BR> &nbsp;&nbsp;";
            } else {
                addStr += ", ";
            }
            addStr  +=  name + ' <span class="text_03">[ <B>' + user_id + '</B> ]</span> ';
        }

        addStr += "<a href='#' onClick=\"operatorRemove('" + user_id + "');\">" + opener.operator_del_image + "</a> ";

        var opIDS = opener.getObject('operator_ids');
        opIDS.innerHTML += ' ' + addStr;

        formObj.operator_id.value += appendID;
        opener.document.operatorForm.operator_id.value   += appendID;
        self.close();
    }
//-->
</SCRIPT>
                                  </tr>
<?
} // while END
?>