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
    BoxMenu   (explorerDocument, "menu_panel", 'explorerWindow')      ; // 메뉴 초기화
    Menu ();
}

function Menu() {
    var menu0 = newMenu();// Menu Group 1
    menu0.appendValue( "delete"     , new MENU_ITEM( '삭제'  , 'DELETE'      , 0, "required"));
    createMenu(panel, menu0);
}

function BoxMenuCommand(key, val){
    switch(key) {
        case "DELETE":
            if ( confirm("정말 삭제 하시겠습니까.") ) {
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
