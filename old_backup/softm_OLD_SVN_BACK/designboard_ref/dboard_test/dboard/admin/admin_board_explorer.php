<script type="text/javascript">
<!--
var explorerWindow   ; // WINDOW   OBJECT
var explorerDocument ; // DOCUMENT OBJECT
function exploerInitial () {
    var explorerObj      = getObject("explorer")      ; // IFRAME   OBJECT
        explorerWindow   = explorerObj.contentWindow  ; // WINDOW   OBJECT
        explorerDocument = explorerWindow.document    ; // DOCUMENT OBJECT
}

function menuInitial () {
    BoxMenu   (explorerDocument, "menu_panel", 'explorerWindow')      ; // �޴� �ʱ�ȭ
    Menu ();
}

function Menu() {
    var menu0 = newMenu();// Menu Group 1
    menu0.appendValue( "delete"     , new MENU_ITEM( '����'  , 'DELETE'      , 0, "required"));
    createMenu(panel, menu0);
}

function BoxMenuCommand(key, val){
    switch(key) {
        case "DELETE":
            if ( confirm("���� ���� �Ͻðڽ��ϱ�.") ) {
                explorerWindow.deleteFolder()
            }
            break;
        default:break;
    }
    HideMenu();
    return false;
}
//-->
</SCRIPT>
<?
function makeExplorer ($width=400,$height=300) {
    echo "<iframe marginHeight='0' marginWidth='0' frameborder='0' width='$width' height='$height' name='explorer' id='explorer' src='admin/admin_board_explorer_iframe.php?no=$no&base_path=$base_path'></iframe></iframe>";
}
makeExplorer ('630', '250');
?>
