<?
if ( function_exists('head') ) {

    if ( $id && $grant == 'Y' && !preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(view_exec.php)$/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] )
                              && ( ( $REQUEST_METHOD == 'POST'  ) || $exec == 'view_check_exec' ) ) {

        if(!preg_match("/${HTTP_HOST}/i",$HTTP_REFERER)) Message('S', '0003',"", $skinDir); // 접근 거부

        if ( $bbsInfor )  { // 게시판 정보 존재
            if ( $use_st ==  1 ) { // 비공개글
                if ( $exec == 'view_check_exec' ) {
                    $sql  = "select COUNT(no) from $tb_bbs_data" . "_" . $id . " where no = $no ";
                    $sql .= "and password = PASSWORD('$chk_password');";
                    $viewChk = simpleSQLQuery($sql);
                    if ( $viewChk ) {
                        $sercurity_cotent_chk = '%' . $id .'_' . $no . $sercurity_cotent_chk;
                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                            @session_register('sercurity_cotent_chk');
                        } else {
                            $_SESSION['sercurity_cotent_chk'] = $sercurity_cotent_chk;  // 4.10 세션 처리.
                        }
                    } else {
                        MessageExit('S', '0039',"", $skinDir)   ; // 비밀 번호가 틀린거죠~ < 비공개글 >
                    }
                    $url = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
                    $url .= '?exec=view';
                    if ( $exec == 'view_check_exec' ) {
                        $key_name  = array_keys  ($_GET);
                        $key_value = array_values($_GET);
                        for($i = 0 ;$i <count($_GET);$i++) {
                            if ( $key_name[$i] != 'exec' && $key_name[$i] != 'tot' ) {
                                $url .= '&'.$key_name[$i].'='.urlencode($key_value[$i]);
                            }
                        }
                    }
                    redirectPage($url);
                }
            }
        } // if END
    }
}
?>