<?
$baseDir = "../";
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
        if ( $_FILES['header_file'] ) {
            $file1           = $_FILES['header_file'][tmp_name ];
            $full_file1_name = $_FILES['header_file'][name     ];
            $file1_size      = $_FILES['header_file'][size     ];
            $file1_type      = $_FILES['header_file'][type     ];

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

            echo "<form name='dataForm'><textarea name='header' cols='90' rows='12'>". _htmlspecialchars ( $file1_str, ENT_QUOTES ). "</textarea></form>";

        } else {
            echo "<form name='dataForm'><textarea name='header' cols='90' rows='12'></textarea></form>";
        }
    } else if($gubun == 'footer' ) {
        if ( $_FILES['footer_file'] ) {
            $file1           = $_FILES['footer_file'][tmp_name ];
            $full_file1_name = $_FILES['footer_file'][name     ];
            $file1_size      = $_FILES['footer_file'][size     ];
            $file1_type      = $_FILES['footer_file'][type     ];

            $file_infor = explode(".","$full_file1_name");
            $file_name = $file_infor[0];                    // 파일 명
            $file_ext  = $file_infor[sizeof($file_infor)-1];// 확장 명
            $file_ext  = strtolower( $file_ext );

            if($file1 && file_exists($file1) ) {
                $f = fopen($file1,"r");
                $file1_str = fread($f, filesize($file1));
                fclose($f);
            }

            echo "<form name='dataForm'><textarea name='footer' cols='90' rows='12'>". _htmlspecialchars ( $file1_str, ENT_QUOTES ) . "</textarea></form>";

        } else {
            echo "<form name='dataForm'><textarea name='footer' cols='90' rows='12'></textarea></form>";
        }
    } else {
        if ( $_FILES[$gubun . '_file'] ) {
            $file1           = $_FILES[$gubun . '_file'][tmp_name ];
            $full_file1_name = $_FILES[$gubun . '_file'][name     ];
            $file1_size      = $_FILES[$gubun . '_file'][size     ];
            $file1_type      = $_FILES[$gubun . '_file'][type     ];

            $file_infor = explode(".","$full_file1_name");
            $file_name = $file_infor[0];                    // 파일 명
            $file_ext  = $file_infor[sizeof($file_infor)-1];// 확장 명
            $file_ext  = strtolower( $file_ext );

            if($file1 && file_exists($file1) ) {
                $f = fopen($file1,"r");
                $file1_str = fread($f, filesize($file1));
                fclose($f);
            }

            echo "<form name='dataForm'><textarea name='$gubun' cols='90' rows='12'>". _htmlspecialchars ( $file1_str, ENT_QUOTES ) . "</textarea></form>";

        } else {
            echo "<form name='dataForm'><textarea name='$gubun' cols='90' rows='12'></textarea></form>";
        }
    }
    ?>
    </BODY>
<?
}
?>