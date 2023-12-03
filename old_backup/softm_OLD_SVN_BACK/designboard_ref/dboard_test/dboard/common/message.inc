<?
include_once ("message_class.inc");
if ( function_exists('head') ) {
    /*
    * include 되었는지를 검사
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
     * 함수명: Message
    * Argus : errType   : D : 데이터 베이스,
    P : 사용자 정의 데이터 베이스,
    U : 사용자 정의 메시지,
    S : 시스템 에러
    *	   : errNo	 : 메시지 번호
    *	   : errPage   : JAVASCRIPT:자바스크립트:버튼명 :: 버튼명을 클릭했을때 자바 스크립을 실행합니다.
    MOVE:$URL:버튼명			   :: 버튼명을 클릭했을때 $URL로 이동합니다.
    CLOSE:버튼명				   :: 버튼명을 클릭했을때 현재페이지를 닫습니다
    *	   : skinDir   : 서비스 화면에서 메시지를 출력할 경우에만 dir값이 존재합니다.
    * 예제1 : Msg ('U', '0003', 'JAVASCRIPT:ALERT("바보"):돌아가기');
    * 예제2 : Msg ('U', '0003', 'MOVE:admin.php:돌아가기');
    * 예제3 : Msg ('U', '0003', 'CLOSE:닫기');
    */
    function Msg ($errType, $errNo, $errPage="", $skinDir='',$displayType) {
    	global $errMsgTable;// 메시지 테이블
    	global $err;		// 에러 객체
    	global $baseDir, $loginSkinDir;
    	global $id, $exec, $baseDir, $npop, $package, $design_method;
    	global $_dboard_head_included;
    	if ( !defined ($package . "_addon") ) {
            include $baseDir . 'common/message_table' . (DBOARD_USE_UTF8_RESOURCE?"_utf8":"") .'.inc'; // 메시지
    	} else {
    		include $baseDir . 'addon/d' . $package . '/common/d' . $package . '_message_table.inc'; // 메시지
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
					if ( $npop == 'Y' ) { // 공지 풋터
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

    // 메시지 출력후 exit 없이 계속적인 처리
    function MessageC($errType, $errNo, $errPage="", $skinDir='') {
    	Msg ($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_CONTINUE);
    }

    function MessageExit($errType, $errNo, $errPage="", $skinDir='') {
    	Msg ($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT);
   		footer (); // Footer 출력
        exit;
    }

    function MessageHead($errType, $errNo, $errPage="", $skinDir='') {
    	global $baseDir;
    	head("디자인보드");
    	css(!$skinDir?$baseDir:$skinDir);
    	Msg($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT_HEAD);
    	footer();
    	exit;
    }

    // 게시판이나 공지 프로그램 내에서 메시지 출력후 게시판 풋터 내용 출력
    function MessageExitInner($errType, $errNo, $errPage="", $skinDir='') {
    	Msg($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_INFORMATION_EXIT_INNER);

        if ( strpos($exec, "_exec") == false ) {
            if ( $npop == 'Y' ) { // 공지 풋터
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
//     	head("디자인보드");
//     	css();
    	Msg($errType, $errNo, $errPage, $skinDir,DBOARD_MESSAGE_DISPLAY_TYPE_JAVASCRIPT);
//     	footer();
        exit;
    }
}
?>