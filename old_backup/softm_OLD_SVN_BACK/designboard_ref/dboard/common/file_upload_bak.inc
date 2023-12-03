<?
/*------- 반환값에 대해 -------------------------------------------------------*/
/*------- rtnvalue라는 크기 2의 배열을 반환합니다. ----------------------------*/
/*------- rtnvalue[0] 생성된 파일명 -------------------------------------------*/
/*------- rtnvalue[1] 에러메시지    -------------------------------------------*/

function fileUpload($savedir,$userfile, $userfile_name, $extension) {
    if( strcmp ( $userfile,"none") ) {
        echo "확장자명 : $extension <BR>";
        echo "userfile : $userfile";
        echo "savedir명 : $savedir <BR>";
        if ( !strcmp($extension,"html") ||
             !strcmp($extension,"htm")  ||
             !strcmp($extension,"php")  ||
             !strcmp($extension,"php3") ||
             !strcmp($extension,"phtml")||
             !strcmp($extension,"inc")  ||
             !strcmp($extension,"pl")   ||
             !strcmp($extension,"cgi")  ||
             !strcmp($extension,"txt")  ||
             !strcmp($extension,"asp")  ||
             !strcmp($extension,"") )
        {
            echo "선택한 파일은 업로드가 금지 되어 있습니다.";
            $errortext = "선택한 파일은 업로드가 금지 되어 있습니다.";
            $rtnvalue[0] = "";
            $rtnvalue[1] = $errortext;
            return $rtnvalue;
        }
//        $userfile_name = ereg_replace(" ","",$userfile_name);
//        $userfile_name = ereg_replace("\(","_",$userfile_name);
//        $userfile_name = ereg_replace("\)","_",$userfile_name);

        $exist = file_exists("$savedir/".DateToMirco()."$extension");
        while ( $exist = file_exists("$savedir/$userfile_name.$extension") ) {
            echo " 선택한 파일과 동일한 이름의 파일이 존재합니다.";
            $userfile_name = DateToMirco();
        }

        echo  "파일명 : " . "$savedir/$userfile_name.$extension";

        echo "<BR>";
        echo "저장디렉토리 : " . $savedir;
        if ( !$exist ) {
            if ( !copy($userfile,"$savedir/$userfile_name.$extension") ) {
//                echo " 사용권한이 없습니다.";
                $errortext = "사용권한이 없습니다.";
//    exit;
                $rtnvalue[0] = "";
                $rtnvalue[1] = $errortext;
                return $rtnvalue;
            }
            if ( !unlink ( $userfile) ) {
//                echo "임시파일을 삭제하는데 실패했습니다.";
                $errortext = "임시파일을 삭제하는데 실패했습니다.";
//    exit;
                $rtnvalue[0] = "";
                $rtnvalue[1] = $errortext;
                return $rtnvalue;
            }
        }
    }else {
//        echo "없슈~~~~";
        $errortext = "파일이 존재하지 않습니다.";
        $rtnvalue[0] = "";
        $rtnvalue[1] = $errortext;
        return $rtnvalue;
    }
//    exit;
    $rtnvalue[0] = $userfile_name;
    $rtnvalue[1] = $errortext;
    return $rtnvalue;
    return $rtnvalue;
}