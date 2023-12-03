<?
include ( '../common/lib.inc'          ); // 공통 라이브러리
include ( '../common/message.inc'      ); // 에러 페이지 처리
$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

if ( $memInfor['admin_yn'] == "Y" ) {
    if ( $gubun ) {
    //  echo "<BODY onLoad=\"parent.FrameResize ( 500, 150, '" . $gubun . "Pannel');\" leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>";
        echo "<BODY leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>";
        echo "<link rel=stylesheet href='../style.css' type='text/css'>";
    } else {
        echo "<BODY leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>";
        echo "<link rel=stylesheet href='../style.css' type='text/css'>";
    }

    if($gubun == 'header' ) {
        if ( $HTTP_POST_FILES['header_file'] ) {
            $file1           = $HTTP_POST_FILES['header_file'][tmp_name ];
            $full_file1_name = $HTTP_POST_FILES['header_file'][name     ];
            $file1_size      = $HTTP_POST_FILES['header_file'][size     ];
            $file1_type      = $HTTP_POST_FILES['header_file'][type     ];

            $file_infor = explode(".","$full_file1_name");
            $file_name = $file_infor[0];                    // 파일 명
            $file_ext  = $file_infor[sizeof($file_infor)-1];// 확장 명
            $file_ext  = strtolower( $file_ext );
            if($file1 && file_exists($file1) ) {
    //      if($file1 && file_exists($file1) && ( $file_ext == 'txt' || $file_ext == 'html' || $file_ext == 'htm' ) ) {
                $f = fopen($file1,"r");
                $file1_str = fread($f, filesize($file1));
                fclose($f);
            }

            echo "<form name='setupForm'><textarea name='header' cols='90' rows='12'>". htmlspecialchars ( $file1_str, ENT_QUOTES ). "</textarea></form>";

        } else {
            echo "<form name='setupForm'><textarea name='header' cols='90' rows='12'></textarea></form>";
        }
    }

    if($gubun == 'footer' ) {
        if ( $HTTP_POST_FILES['footer_file'] ) {
            $file1           = $HTTP_POST_FILES['footer_file'][tmp_name ];
            $full_file1_name = $HTTP_POST_FILES['footer_file'][name     ];
            $file1_size      = $HTTP_POST_FILES['footer_file'][size     ];
            $file1_type      = $HTTP_POST_FILES['footer_file'][type     ];

            $file_infor = explode(".","$full_file1_name");
            $file_name = $file_infor[0];                    // 파일 명
            $file_ext  = $file_infor[sizeof($file_infor)-1];// 확장 명
            $file_ext  = strtolower( $file_ext );

            if($file1 && file_exists($file1) ) {
                $f = fopen($file1,"r");
                $file1_str = fread($f, filesize($file1));
                fclose($f);
            }

            echo "<form name='setupForm'><textarea name='footer' cols='90' rows='12'>". htmlspecialchars ( $file1_str, ENT_QUOTES ) . "</textarea></form>";

        } else {
            echo "<form name='setupForm'><textarea name='footer' cols='90' rows='12'></textarea></form>";
        }
    }
}
?>
</BODY>
