<?
error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice�� ������ ��翡���� �������ض�~ )
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
$IJTSEC = ( $_GET["baseDir"] || $_POST["baseDir"] || $_GET["libDir"] || $_POST["libDir"] ) ? false : true;
if ( $IJTSEC ) {
	include 'common/lib.inc'         ;   // ���� ���̺귯��
    include 'common/message_table.inc';			// �޽��� ���̺�
    include 'common/message.inc'     ;   // ���� ������ ó��

    include 'common/board_lib.inc'   ;   // �Խ��� ���̺귯��

    @session_save_path($baseDir . "data/session");
    @session_set_cookie_params(0, '/');
    @session_cache_limiter('');
    @session_start();
    head();
    echo "\n<script type='text/javascript'>\n";
    echo "<!--\n";
    echo "var DP_W_playPopup = null; // Player Poup\n";

    if ( $gubun == 'ALL_PLAY' || $gubun == 'RANDOM_PLAY' || $gubun == 'SINGLE_PLAY' ) {
//      echo "alert ( '��ü, ����, �̱�' );";
        $tmp_cart = '';
        $_Aadd_no = explode(',',$add_no);
        while (list ($key, $val) = each ($_Aadd_no)) {
            if ( $val ) {
                $tmp_cart = '%' . $id .'*' . $val . $tmp_cart;
            }
        }
//		echo $tmp_cart;
        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
            @session_register('tmp_cart');
        } else {
            $_SESSION['tmp_cart'] = $tmp_cart;  // 4.10 ���� ó��.
        }
        if ( !$tmp_cart ) {
            echo "parent.DP_W_playPopup = null;\n";
            echo "alert ( '".$errMsgTable['S0067']."' );\n";
        } else {
            echo "parent.DP_W_playPopup = window.open('dplayer.php?id=" . $id . "&gubun=" . $gubun . "','_dplayer','scrollbars=no,status=yes,width=0,height=0');\n";
            echo "parent.DP_W_playPopup.focus();\n";
        }
//        echo "document.location.replace('empty.php');\n";
    } else {
//      echo "alert ( '�߰� �� ���� �� īƮ�÷���' );";
        if ( $gubun == 'SA' || $gubun == 'MA' ) {
            include 'common/db_connect.inc';	// Data Base ���� Ŭ����
            $db = initDBConnection ();             // �����ͺ��̽� ����
            $libDir   = "common/lib/" . $sysInfor["driver"] . '/';
        }

        if ( isset($_SESSION['media_cart']) ) {
//          echo '<font color="red">���� ��� : ' . $_SESSION['media_cart'] . '</font><BR>';
            $media_cart = $_SESSION['media_cart'];
        }

        if ( $gubun == 'SA' ) {
            $media_cart_stats = preg_match("/%${id}*${add_no}/", $media_cart);
            if ( !$media_cart_stats ) {
                $media_cart = '%' . $id .'*' . $add_no . $media_cart;
            }
            include $libDir  . "play_album_retrive.php"; // ���õ� �ٹ� ���� ��ȸ

        } else if ( $gubun == 'MA' ) {
            $_Aadd_no = explode(',',$add_no);
            while (list ($key, $val) = each ($_Aadd_no)) {
                if ( $val ) {
                    $media_cart_stats = preg_match("/%${id}*${val}/", $media_cart);
                    if ( !$media_cart_stats && $val ) {
                        $media_cart = '%' . $id .'*' . $val . $media_cart;
                    }
                }
            }
            include $libDir  . "play_album_retrive.php"; // ���õ� �ٹ� ���� ��ȸ
        } else if ( $gubun == 'SD' ) {
            if ( $add_no ) {
                $playNo = explode ( '_', $add_no);
                $playNo = $playNo[1];
                echo "if ( parent.DP_W_playPopup != null && typeof(parent.DP_W_playPopup.document) == 'object') {\n";
                echo "    parent.DP_W_playPopup.DP_SORT_DELETE ('" . $id . '*' . $playNo . "');\n";
                echo "    parent.DP_W_playPopup.focus();\n";
                echo "}\n";
                $media_cart = str_replace ( '%' . $id . '*' . $add_no, '', $media_cart);
            }
//            echo "document.location.replace('empty.php');\n";
        } else if ( $gubun == 'MD' ) {
            echo "if ( parent.DP_W_playPopup != null && typeof(parent.DP_W_playPopup.document) == 'object') {\n";
            $_Aadd_no = explode(',',$add_no);
            while (list ($key, $val) = each ($_Aadd_no)) {
                if ( $val ) {
                    $media_cart = str_replace ( '%' . $id . '*' . $val , '', $media_cart);
                    $playNo = explode ( '_', $val);
                    $playNo = $playNo[1];
                    echo "    parent.DP_W_playPopup.DP_SORT_DELETE ('" . $id . '*' . $playNo . "');\n";
                }
            }
            echo "    parent.DP_W_playPopup.focus();\n";
//            echo "document.location.replace('empty.php');\n";
            echo "}\n";
        } else if ( $gubun == 'CART_PLAY' ) {
            include 'common/message_table.inc'; // �޽��� ���̺�
            if ( !$media_cart ) {
                echo "parent.DP_W_playPopup = null;\n";
                echo "alert ( '".$errMsgTable['S0067']."' );\n";
            } else {
                echo "parent.DP_W_playPopup = window.open('dplayer.php?id=" . $id . "&gubun=" . $gubun . "','_dplayer','scrollbars=no,status=yes,width=0,height=0');\n";
                echo "parent.DP_W_playPopup.focus();\n";
            }
//            echo "document.location.replace('empty.php');\n";
        }

        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
            @session_register('media_cart');
        } else {
            $_SESSION['media_cart'] = $media_cart;  // 4.10 ���� ó��.
        }

        if ( !$exec || $exec == 'list' ) {
            echo "var playCart = new Array();\n";
            echo "var gubun    = '$gubun';\n";
            echo "var id       = '$id'   ;\n";
            $cartCnt = 0;
            $tmp_media_cart = explode ( '%', $media_cart);

            while (list ($key, $val) = each ($tmp_media_cart)) {
                $tmp_key = explode ( '_', $val);
                if ( $val ) {
                    echo "playCart[$cartCnt]= '$val';\n";
                    $cartCnt++;
                }
            //    echo $tmp_key[0] . "\n";
            //    echo $tmp_key[1] . "\n";
            //    echo "$key => $val<br>";
            }
            if ( $gubun ) {
                echo "    var obj = parent.getObject       ('chk');\n";
                echo "    parent.objectCheckedClear ( obj );\n";
                echo "    for ( var i=0;i<playCart.length;i++ ){\n";
                echo "        parent.objectMutiChecked    ( obj, playCart[i].split('*')[1]);\n";
                echo "    }\n";
            } else {
                echo "    var obj = getObject       ('chk');\n";
                echo "    objectCheckedClear ( obj );\n";
                echo "    for ( var i=0;i<playCart.length;i++ ){\n";
                echo "        objectMutiChecked    ( obj, playCart[i].split('*')[1]);\n";
                echo "    }\n";
            }

        }
        if ( $gubun == 'SA' || $gubun == 'MA' ) {
            closeDBConnection (); // �����ͺ��̽� ���� ���� ����
        }
    }

//  ECHO "\n alert ( 'dplay_cart.php�� \\n tmp_cart:   " . $_SESSION['tmp_cart'    ] . "\\n media_cart: " . $_SESSION['media_cart'  ] . "');\n";
    echo "//-->\n";
    echo "</script>\n";
}
?>