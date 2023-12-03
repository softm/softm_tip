<?
include ("message_class.inc");
if ( function_exists('_head') ) {
    /*
    * include �Ǿ������� �˻�
    **/
    if( defined("_message_included") ) return;
        define ("_message_included", true);

    /*
    * �Լ���: Message
    * Argus : errType   : D : ������ ���̽�,
                          P : ����� ���� ������ ���̽�,
                          U : ����� ���� �޽���,
                          S : �ý��� ����
    *	   : errNo	 : �޽��� ��ȣ
    *	   : errPage   : JAVASCRIPT:�ڹٽ�ũ��Ʈ:��ư�� :: ��ư���� Ŭ�������� �ڹ� ��ũ���� �����մϴ�.
                          MOVE:$URL:��ư��			   :: ��ư���� Ŭ�������� $URL�� �̵��մϴ�.
                          CLOSE:��ư��				   :: ��ư���� Ŭ�������� ������������ �ݽ��ϴ�
    *	   : skinDir   : ���� ȭ�鿡�� �޽����� ����� ��쿡�� dir���� �����մϴ�.
    * ����1 : Message ('U', '0003', 'JAVASCRIPT:ALERT("�ٺ�"):���ư���');
    * ����2 : Message ('U', '0003', 'MOVE:admin.php:���ư���');
    * ����3 : Message ('U', '0003', 'CLOSE:�ݱ�');
    */
    function Message ($errType, $errNo, $errPage="", $skinDir='') {
        global $errMsgTable;// �޽��� ���̺�
        global $err;		// ���� ��ü
        global $baseDir, $loginSkinDir;
        global $package;
        global $_dboard_head_included;
        if ( !defined ($package . "_addon") ) {
            include $baseDir . 'common/message_table.inc'; // �޽���
        } else {
            include $baseDir . 'addon/d' . $package . '/common/d' . $package . '_message_table.inc'; // �޽���
        }
        if ( !$skinDir ) { // Header ���
            if ( function_exists('head') ) {
                head ();
                _css ($baseDir);
            }
        } else {
            if ( function_exists('_head') ) {
                _head ();
                _css ($skinDir);
            }
        }

        $errMsg = $errMsgTable[$errType.$errNo];

        if ( !$errMsg ) $errMsg = $errPage;

        $err = new Message ($errType, $errNo, $errMsg, $errPage);

        if ( function_exists('closeDBConnection') ) {
            closeDBConnection ();
        }

        if ( !$skinDir ) { // Footer ���
            include $baseDir . "message.php";
            if ( function_exists('footer') ) { footer ();  }
        } else {
            include $skinDir . "message.php";
            if ( function_exists('_footer') ) { _footer ();  }
        }
        exit;
    }

    // �޽��� ����� exit ���� ������� ó��
    function MessageC ($errType, $errNo, $errPage="", $skinDir='') {
        global $errMsgTable;// �޽��� ���̺�
        global $err;		// ���� ��ü
        global $baseDir, $loginSkinDir;
        global $package;
        global $_dboard_head_included;
        if ( !defined ($package . "_addon") ) {
            include $baseDir . 'common/message_table.inc'; // �޽���
        } else {
            include $baseDir . 'addon/d' . $package . '/common/d' . $package . '_message_table.inc'; // �޽���
        }
        if ( !$_dboard_head_included ) { head (); }

        $errMsg = $errMsgTable[$errType.$errNo];

        if ( !$errMsg ) { $errMsg = $errPage; }

        $err = new Message ($errType, $errNo, $errMsg, $errPage);

        if ( !$skinDir ) { // Footer ���
            include $baseDir . "message.php";
        } else {
            include $skinDir . "message.php";
        }
    }

    // �޽��� ����� �Խ��� Ǫ�� ���
    function MessageF ($errType, $errNo, $errPage="", $skinDir='') {
        global $errMsgTable;// �޽��� ���̺�
        global $err;		// ���� ��ü
        global $baseDir, $loginSkinDir;
        global $id, $exec, $baseDir, $npop, $package, $design_method;
        global $_dboard_head_included;
        if ( !defined ($package . "_addon") ) {
            include $baseDir . 'common/message_table.inc'; // �޽���
        } else {
            include $baseDir . 'addon/d' . $package . '/common/d' . $package . '_message_table.inc'; // �޽���
        }
    //  if ( !$_dboard_head_included ) { head (); }

        $errMsg = $errMsgTable[$errType.$errNo];

        if ( !$errMsg ) { $errMsg = $errPage; }

        $err = new Message ($errType, $errNo, $errMsg, $errPage);

        if ( function_exists('closeDBConnection') ) {
            closeDBConnection ();
        }

        if ( !$skinDir ) { // Footer ���
            include $baseDir . "message.php";
            if ( function_exists('footer') ) { footer ();  }
        } else {
            include $skinDir . "message.php";
            if ( function_exists('_footer') ) { _footer ();  }
        }

        if ( strpos($exec, "_exec") == false ) {
    //	  echo '<font color="red">MessageF</font>';
            if ( $npop == 'Y' ) { // ���� ǲ��
                include ( $baseDir . "data/html/_dnotice_footer_" . $id . ".php" );
            } else {
                if ( $design_method == '1' ) {
                    include ( $baseDir . "data/html/_dboard_footer_" . $id . ".php" );
                }
            }
        }
        exit;
    }

    function MessageJ ($errType, $errNo, $errPage="", $skinDir='') {
        global $errMsgTable;// �޽��� ���̺�
        global $err;		// ���� ��ü
        global $baseDir, $loginSkinDir;
        global $package;
        global $_dboard_head_included;
        if ( !defined ($package . "_addon") ) {
            include $baseDir . 'common/message_table.inc'; // �޽���
        } else {
            include $baseDir . 'addon/d' . $package . '/common/d' . $package . '_message_table.inc'; // �޽���
        }

        if ( function_exists('head') ) {
            head ();
        }

    //  if ( !$_dboard_head_included ) { }

        $errMsg = $errMsgTable[$errType.$errNo];

        if ( !$errMsg ) { $errMsg = $errPage; }

        $err = new Message ($errType, $errNo, $errMsg, $errPage);

        if ( function_exists('closeDBConnection') ) {
            closeDBConnection ();
        }

        echo "<SCRIPT LANGUAGE='JavaScript'>\n";
        echo "<!--\n";
        echo "	  alert ( '" . $errMsg ."');\n";
        echo $err->errAction . "\n";
        echo "//-->\n";
        echo "</SCRIPT>\n";

        if ( !$skinDir ) { // Footer ���
            if ( function_exists('footer') ) { footer ();  }
        } else {
            if ( function_exists('_footer') ) { _footer ();  }
        }
        exit;
    }
}
?>