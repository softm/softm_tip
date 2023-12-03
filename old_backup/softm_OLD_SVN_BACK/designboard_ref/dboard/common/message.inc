<?
include ("message_class.inc");
if ( function_exists('_head') ) {
    /*
    * include 되었는지를 검사
    **/
    if( defined("_message_included") ) return;
        define ("_message_included", true);

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
    * 예제1 : Message ('U', '0003', 'JAVASCRIPT:ALERT("바보"):돌아가기');
    * 예제2 : Message ('U', '0003', 'MOVE:admin.php:돌아가기');
    * 예제3 : Message ('U', '0003', 'CLOSE:닫기');
    */
    function Message ($errType, $errNo, $errPage="", $skinDir='') {
        global $errMsgTable;// 메시지 테이블
        global $err;		// 에러 객체
        global $baseDir, $loginSkinDir;
        global $package;
        global $_dboard_head_included;
        if ( !defined ($package . "_addon") ) {
            include $baseDir . 'common/message_table.inc'; // 메시지
        } else {
            include $baseDir . 'addon/d' . $package . '/common/d' . $package . '_message_table.inc'; // 메시지
        }
        if ( !$skinDir ) { // Header 출력
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

        if ( !$skinDir ) { // Footer 출력
            include $baseDir . "message.php";
            if ( function_exists('footer') ) { footer ();  }
        } else {
            include $skinDir . "message.php";
            if ( function_exists('_footer') ) { _footer ();  }
        }
        exit;
    }

    // 메시지 출력후 exit 없이 계속적인 처리
    function MessageC ($errType, $errNo, $errPage="", $skinDir='') {
        global $errMsgTable;// 메시지 테이블
        global $err;		// 에러 객체
        global $baseDir, $loginSkinDir;
        global $package;
        global $_dboard_head_included;
        if ( !defined ($package . "_addon") ) {
            include $baseDir . 'common/message_table.inc'; // 메시지
        } else {
            include $baseDir . 'addon/d' . $package . '/common/d' . $package . '_message_table.inc'; // 메시지
        }
        if ( !$_dboard_head_included ) { head (); }

        $errMsg = $errMsgTable[$errType.$errNo];

        if ( !$errMsg ) { $errMsg = $errPage; }

        $err = new Message ($errType, $errNo, $errMsg, $errPage);

        if ( !$skinDir ) { // Footer 출력
            include $baseDir . "message.php";
        } else {
            include $skinDir . "message.php";
        }
    }

    // 메시지 출력후 게시판 푸터 출력
    function MessageF ($errType, $errNo, $errPage="", $skinDir='') {
        global $errMsgTable;// 메시지 테이블
        global $err;		// 에러 객체
        global $baseDir, $loginSkinDir;
        global $id, $exec, $baseDir, $npop, $package, $design_method;
        global $_dboard_head_included;
        if ( !defined ($package . "_addon") ) {
            include $baseDir . 'common/message_table.inc'; // 메시지
        } else {
            include $baseDir . 'addon/d' . $package . '/common/d' . $package . '_message_table.inc'; // 메시지
        }
    //  if ( !$_dboard_head_included ) { head (); }

        $errMsg = $errMsgTable[$errType.$errNo];

        if ( !$errMsg ) { $errMsg = $errPage; }

        $err = new Message ($errType, $errNo, $errMsg, $errPage);

        if ( function_exists('closeDBConnection') ) {
            closeDBConnection ();
        }

        if ( !$skinDir ) { // Footer 출력
            include $baseDir . "message.php";
            if ( function_exists('footer') ) { footer ();  }
        } else {
            include $skinDir . "message.php";
            if ( function_exists('_footer') ) { _footer ();  }
        }

        if ( strpos($exec, "_exec") == false ) {
    //	  echo '<font color="red">MessageF</font>';
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

    function MessageJ ($errType, $errNo, $errPage="", $skinDir='') {
        global $errMsgTable;// 메시지 테이블
        global $err;		// 에러 객체
        global $baseDir, $loginSkinDir;
        global $package;
        global $_dboard_head_included;
        if ( !defined ($package . "_addon") ) {
            include $baseDir . 'common/message_table.inc'; // 메시지
        } else {
            include $baseDir . 'addon/d' . $package . '/common/d' . $package . '_message_table.inc'; // 메시지
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

        if ( !$skinDir ) { // Footer 출력
            if ( function_exists('footer') ) { footer ();  }
        } else {
            if ( function_exists('_footer') ) { _footer ();  }
        }
        exit;
    }
}
?>