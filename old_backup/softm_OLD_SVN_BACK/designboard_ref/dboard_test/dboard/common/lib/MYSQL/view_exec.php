<?
if ( function_exists('head') ) {

    if ( $id && $grant == 'Y' && !preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(view_exec.php)$/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] )
                              && ( ( $REQUEST_METHOD == 'POST'  ) || $exec == 'view_check_exec' ) ) {

        if(!preg_match("/${HTTP_HOST}/i",$HTTP_REFERER)) Message('S', '0003',"", $skinDir); // ���� �ź�

        if ( $bbsInfor )  { // �Խ��� ���� ����
            if ( $use_st ==  1 ) { // �������
                if ( $exec == 'view_check_exec' ) {
                    $sql  = "select COUNT(no) from $tb_bbs_data" . "_" . $id . " where no = $no ";
                    $sql .= "and password = PASSWORD('$chk_password');";
                    $viewChk = simpleSQLQuery($sql);
                    if ( $viewChk ) {
                        $sercurity_cotent_chk = '%' . $id .'_' . $no . $sercurity_cotent_chk;
                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
                            @session_register('sercurity_cotent_chk');
                        } else {
                            $_SESSION['sercurity_cotent_chk'] = $sercurity_cotent_chk;  // 4.10 ���� ó��.
                        }
                    } else {
                        MessageExit('S', '0039',"", $skinDir)   ; // ��� ��ȣ�� Ʋ������~ < ������� >
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