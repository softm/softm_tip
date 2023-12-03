<!--
var treeMenuDocument;       // Document Object의 할당
var treeMenuIndex;
    function TreeMenuItem ( text, url, target, icon ){
      this.text = text;
    //	alert ( this.text );
      if (url)
        this.url = url;
      else
        this.url = "";
      if (target)
        this.target = target;
      else
        this.target = "";
      if (icon)
        this.icon = icon;
      else
        this.icon = "";

      this.submenu = null;
      this.subopen = false;
      this.index = treeMenuIndex++;
      this.makeSubmenu = TreeMenuMakeSubmenu;
    }

    function TreeMenuMakeSubmenu(menu) {
        this.submenu = menu;
    }

/// 1 .
    function TreeMenu () {
        this.item1 = new Array();
        this.addItem = treeMenuAddItem;
    }

    function treeMenuAddItem (item) {
        this.item1[this.item1.length] = item;
        this.babo = "되라";
    }

    var Test1 =  new TreeMenu();
    Test1.addItem( new TreeMenuItem( "김지훈Test1","Test1") );
    Test1.addItem( new TreeMenuItem( "김지선Test1","Test1") );
    Test1.addItem( new TreeMenuItem( "김영욱Test1","Test1") );

    var sub1 = new TreeMenu();

    sub1.addItem( new TreeMenuItem( "김지훈 sub1", "http://www.softmind.ce.ro") );
    sub1.addItem( new TreeMenuItem( "김지선 sub1", "http://www.softmind.ce.ro") );
    sub1.addItem( new TreeMenuItem( "김영욱 sub1", "http://www.softmind.ce.ro") );
    sub1.addItem( new TreeMenuItem( "박종각 sub1", "http://www.softmind.ce.ro") );

    Test1.item1[0].makeSubmenu(sub1);

    var sub2 = new TreeMenu();

    sub2.addItem( new TreeMenuItem( "김지훈 sub2", "http://www.softmind.ce.ro") );
    sub2.addItem( new TreeMenuItem( "김지선 sub2", "http://www.softmind.ce.ro") );
    sub2.addItem( new TreeMenuItem( "김영욱 sub2", "http://www.softmind.ce.ro") );

    sub1.item1[0].makeSubmenu(sub2);

//    Test1.item1[1].makeSubmenu(sub1);
//    alert( "sub1.length : " + sub1.item1.length );
var treeMenuImgDir     = "graphics/"      // Image Dir 경로.
var treeMenuBackground = "";              // Menu Frame의 backGround IMAGE
var treeMenuBgColor    = "#ffffff";       // Menu Frame의 backGround Color
var treeMenuFgColor    = "#000000";       // Menu Item의 글자색
var treeMenuHiBg       = "#008080";       // 선택된 Item의 backGround Color
var treeMenuHiFg       = "#ffffff";       // 선택된 Item의 Text Color
var treeMenuFont       = "MS Sans Serif,Arial,Helvetica";    // 글씨체
var treeMenuFontSize   = 1;               // 글씨 크기
var treeMenuRoot       = "Site Menu";     // Meun의 Root Name
var treeMenuFolders    = 0;               // + , - 아이콘의 display를 설정합니다.
var treeMenuAltText    = true;            // Item 의 아이콘 이미지에 ALT Text를 사용합니다.

var treeMenuDocument;       // Handle to the menu frame treeMenuDocument.
var treeMenuFrame      = "menuFrame";     // Name of the menu frame.
//    alert (Test1.babo);
//    alert ( Test1.item1[0].text );
//    alert ( Test1.item1[1].text );
//    alert ( Test1.item1[2].text );
//    alert ( sub2.item1[2].index );
//    alert ( treeMenuIndex );
    function StartDraw() {
        treeMenuDocument = window.frames[treeMenuFrame].document;
        treeMenuDocument.writeln("<TABLE cellpadding='0' cellspacing='0'>");
        treeMenuDocument.writeln("    <TR>");
        treeMenuDocument.writeln("    <TD>");
        treeMenuDocument.writeln("<img src='" + treeMenuImgDir + "menu_root.gif' align=left border=0 vspace=0 hspace=0>시작");
        treeMenuDocument.writeln("    </TD>");
        treeMenuDocument.writeln("    </TR>");
        MenuDisplay(Test1);
    }

    function EndDraw() {
        treeMenuDocument.writeln("</TABLE>");
    }

    function MenuDisplay(menu) {
//        alert ( menu.item1.length );

//      메뉴에 포함된 Item의 수를 가지고 있습니다.

        var li_mainMenuLength = menu.item1.length;
        var ls_PreItemImage   = "";
        var ls_subopen        = "";

        for ( i=0; i < li_mainMenuLength; i++) {
//            alert( menu.item1[i].submenu );
                menu.item1[i].subopen
            if ( menu.item1[i].submenu ) { 
                if ( li_mainMenuLength == i + 1 ) {
                    if ( ls_subopen == false )
                        PreItemImage = "menu_corner_plus.gif";
                    else
                        PreItemImage = "menu_corner_minus.gif";
                } else {
                    if ( ls_subopen == false )
                        PreItemImage = "menu_tee_plus.gif";
                    else
                        PreItemImage = "menu_tee_minus.gif";
                }
            }
            else if ( !menu.item1[i].submenu ) { 
                if ( li_mainMenuLength == i + 1 ) {
                    PreItemImage = "menu_corner.gif";
                } else {
                    PreItemImage = "menu_tee.gif";
                }
            }
            treeMenuDocument.writeln("    <TR>");
            treeMenuDocument.writeln("    <TD>");
            treeMenuDocument.writeln("    <a href='#' OnClick='parent.VisiableToggle(\"Test1\"," + i + ");return false;'>");
            treeMenuDocument.writeln("    <IMG src='" + treeMenuImgDir + PreItemImage + "' align=left border=0 vspace=0 hspace=0>");
            treeMenuDocument.writeln("    <FONT face='굴림체' size='2'>" + menu.item1[i].text + "</FONT>");
            treeMenuDocument.writeln("    </TD>");
            treeMenuDocument.writeln("    </TR>");
        }
//        MenuDisplay(Test1);
        alert ( "Menu : " + menu.item1[0].subopen );
    }
    function VisiableToggle ( menu, index ) {
        this.menu = eval( menu );
        if ( this.menu.item1[index].subopen == true ) {
            alert ('1');
            this.menu.item1[index].subopen  =  false;
        } else {
            alert ('2');
            this.menu.item1[index].subopen  =  true;
        }
        alert ('11');
         alert ( this.menu.item1[index].subopen );
    }
//-->