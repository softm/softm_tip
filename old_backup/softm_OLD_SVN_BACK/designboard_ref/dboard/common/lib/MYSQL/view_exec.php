<?
if ( function_exists('_head') ) {

    if ( $id && $grant == 'Y' && !ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(view_exec.php)$", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] )
                              && ( ( $REQUEST_METHOD == 'POST'  ) || $exec == 'view_check_exec' ) ) {

        if(!eregi($HTTP_HOST,$HTTP_REFERER)) Message ('S', '0003',"", $skinDir); // ���� �ź�

        if ( $bbsInfor )  { // �Խ��� ���� ����
            if ( $use_st ==  1 ) { // �������
                if ( $exec == 'view_check_exec' ) {
                    $sql  = "select COUNT(no) from $tb_bbs_data" . "_" . $id . " where no = $no ";
                    $sql .= "and password = PASSWORD('$chk_password');";
                    $viewChk = simpleSQLQuery($sql);
                    if ( $viewChk ) {
                        $sercurity_cotent_chk = '%' . $id .'_' . $no . $sercurity_cotent_chk;
                        @session_register('sercurity_cotent_chk');
						$_SESSION['sercurity_cotent_chk'] = $sercurity_cotent_chk;  // 4.10 ���� ó��.
                    } else {
                        Message ('S', '0039',"", $skinDir)   ; // ��� ��ȣ�� Ʋ������~ < ������� >
                    }
                    $url = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
                    $url .= '?exec=view';
                    if ( $exec == 'view_check_exec' ) {
                        $key_name  = array_keys  ($HTTP_GET_VARS);
                        $key_value = array_values($HTTP_GET_VARS);
                        for($i = 0 ;$i <count($HTTP_GET_VARS);$i++) {
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