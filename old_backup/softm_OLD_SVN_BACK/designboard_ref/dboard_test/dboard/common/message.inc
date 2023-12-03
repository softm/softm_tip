<?
include_once ("message_class.inc");
if ( function_exists('head') ) {
    /*
    * include �Ǿ������� �˻�
    **/
    if( defined("_message_included") ) return;
        define ("_message_included", true);

    define("DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION"           ,1); // Message 	                     message
    define("DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT"      ,2); // MessageExit                   message        ,footer    -> exit;
    define("DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT_HEAD" ,3); // MessageExitHead header(html), message        ,footer    -> exit;
    define("DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT_INNER",4); // MessageExitInner[MessageF]    message        , dboard,dnotice footer -> exit;
    define("DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_CONTINUE"  ,5); // MessageC 	                 message
    define("DBOARD_MESSAGE_DISPLAY_TYPE_JAVASCRIPT"            ,6); // MessageJavascript[MessageJ]   js alert-message,

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
    * ����1 : Msg ('U', '0003', 'JAVASCRIPT:ALERT("�ٺ�"):���ư���');
    * ����2 : Msg ('U', '0003', 'MOVE:admin.php:���ư���');
    * ����3 : Msg ('U', '0003', 'CLOSE:�ݱ�');
    */
    function Msg ($errType, $errNo, $errPage="", $skinDir='',$displayType) {
    	global $errMsgTable;// �޽��� ���̺�
    	global $err;		// ���� ��ü
    	global $baseDir, $loginSkinDir;
    	global $id, $exec, $baseDir, $npop, $package, $design_method;
    	global $_dboard_head_included;
    	if ( !defined ($package . "_addon") ) {
            include $baseDir . 'common/message_table' . (DBOARD_USE_UTF8_RESOURCE?"_utf8":"") .'.inc'; // �޽���
    	} else {
    		include $baseDir . 'addon/d' . $package . '/common/d' . $package . '_message_table.inc'; // �޽���
    	}

    	if ( $displayType == DBOARD_MESSAGE_DISPLAY_ERROR_TYPE ) {
	    	if ( DBOARD_PAGE_DIRECT_ACCESS || defined("NOT_INCLUDE_HTML_HEAD")) {
	    		echo "</head>\n";
	    		echo "<body>\n";
	    	}
    	}
    	$errMsg = $errMsgTable[$errType.$errNo];

    	if ( !$errMsg ) $errMsg = $errPage;

    	$err = new Message($errType, $errNo, $errMsg, $errPage);

    	if ( $displayType == DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT
    	  || $displayType == DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT_HEAD
    	  || $displayType == DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT_INNER
    	  || $displayType == DBOARD_MESSAGE_DISPLAY_TYPE_JAVASCRIPT
		) {
	    	if ( function_exists('closeDBConnection') ) {
	    		closeDBConnection ();
	    	}
    	}

		if ( $displayType == DBOARD_MESSAGE_DISPLAY_TYPE_JAVASCRIPT ) {
			echo "<SCRIPT LANGUAGE='JavaScript'>\n";
			echo "<!--\n";
			echo "	  alert ( '" . $errMsg ."');\n";
			echo $err->errAction . "\n";
			echo "//-->\n";
			echo "</SCRIPT>\n";
		} else{
			if ( $displayType == DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT_INNER ) {
				if ( strpos($exec, "_exec") == false ) {
					if ( $npop == 'Y' ) { // ���� ǲ��
						include ( $baseDir . "data/html/_dnotice_footer_" . $id . ".php" );
					} else {
						if ( $design_method == '1' ) {
							include ( $baseDir . "data/html/_dboard_footer_" . $id . ".php" );
						}
					}
				}
			}
			include (!$skinDir?$baseDir:$skinDir) . "message.php";
		}

    }

    function Message($errType, $errNo, $errPage="", $skinDir='') {
    	Msg ($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION);
    }

    // �޽��� ����� exit ���� ������� ó��
    function MessageC($errType, $errNo, $errPage="", $skinDir='') {
    	Msg ($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_CONTINUE);
    }

    function MessageExit($errType, $errNo, $errPage="", $skinDir='') {
    	Msg ($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT);
   		footer (); // Footer ���
        exit;
    }

    function MessageHead($errType, $errNo, $errPage="", $skinDir='') {
    	global $baseDir;
    	head("�����κ���");
    	css(!$skinDir?$baseDir:$skinDir);
    	Msg($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT_HEAD);
    	footer();
    	exit;
    }

    // �Խ����̳� ���� ���α׷� ������ �޽��� ����� �Խ��� ǲ�� ���� ���
    function MessageExitInner($errType, $errNo, $errPage="", $skinDir='') {
    	Msg($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT_INNER);

        if ( strpos($exec, "_exec") == false ) {
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

    function MessageJavascript($errType, $errNo, $errPage="", $skinDir='') {
//     	head("�����κ���");
//     	css();
    	Msg($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_JAVASCRIPT);
//     	footer();
        exit;
    }
}
?>