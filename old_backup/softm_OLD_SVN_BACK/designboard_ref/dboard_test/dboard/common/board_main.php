<?
if ( function_exists('head') ) {
    if ( $lg != 'Y' && $login_yn == 'N' && $grant == 'N' ) { // ���� ���� (�α��� ������ �䱸)
        Message('S', $msgNo,"MOVE:" . getReqPageName () . "$a_params&lg=Y&exec=$exec:�α��� ..",$loginSkinDir);
    } else { // ���� ���� (���� ������)
        if ( $login_yn == 'Y' && $grant == 'N' ) {
            Message('S', $msgNo,"", $skinDir);
        } else if ( $lg == 'Y' ) { // �α���
            include 'js/login_js.php'; // �α��� javascript

            echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST onSubmit=\"return loginFormSubmit(this);\"><input name='suc_mode' type='hidden' value='$suc_mode'><input name='message' type='hidden' value='$message'><input name='succ_url' type='hidden' value='$succ_url'><input name='login_skin_name' type='hidden' value='$login_skin_name'></TABLE>\n";
            $save_id  = $_COOKIE["_d_save_id"]; // �ڵ� �α��� ����
            if ( $save_id == 'Y' ) {
                $user_id = $_COOKIE["_d_user_id"   ]; // ����� ���̵�
            } else {
                $user_id = ''; // ����� ���̵�
            }
            include $loginSkinDir .'login.php'; // �α��� ��Ų
            echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
            if ( $save_id == 'Y' ) {
    ?>
            <script type="text/javascript">
            <!--
                if ( typeof(getObject ('save_id')) == 'object' ) getObject ('save_id').checked=true;
            //-->
            </script>
    <?
            }
        } else {
            if ( $exec == 'list' ) { // ����Ʈ
                if ( $admin_yn == 'Y' ) include 'js/admin_js.php'; // ���� javascript
                include 'js/board_list_js.php'; // ����Ʈ javascript
                include $baseDir.'list.php'; // ����Ʈ ������
            } else if ( $exec == 'view_check_exec' ) { // �б�
                $sercurity_cotent_chk = $_SESSION['sercurity_cotent_chk'];
                $sercurity_stats = preg_match("/%${id}_${no}/", $sercurity_cotent_chk);
                include $libDir . 'view_exec.php'; // ��ȸ�� ���� ����
            } else if ( $exec == 'view' ) { // �б�
                include 'js/board_view_js.php'; // �� ���� javascript
                include 'js/board_list_js.php'; // ����Ʈ  javascript
    //			include $baseDir.'common/js/board_write_js.php'; // �� ���� javascript
                $sercurity_stats = false; // ��б� ���� ����
                if ( $use_st == 1 ) { // ������� �̰�  ..
                    // ��������� ��� ���� ���� �о����.
                    $sercurity_cotent_chk = $_SESSION['sercurity_cotent_chk'];
                    $sercurity_stats = preg_match("/%${id}_${no}/", $sercurity_cotent_chk);
                    if ( !$sercurity_stats ) { // ��б� ������ �ȵ� ����
                        if ( $admin_yn == 'Y' ) { // �������̸�
                            $sercurity_stats = true;
                            include $baseDir . 'view.php'; // �б� ������
                        } else {
                            if ( !$w_user_id ) { // ��ȸ���� �ۼ��� ���ϰ��
                                $exec = 'view_check'; // ���� üũ�� ����.
                                $title = '��й�ȣ�� �Է����ּ���.';
                                include $baseDir . 'js/board_ask_password_js.php'; // �� ���� javascript
                                include $baseDir . 'ask_password.php'; // ��й�ȣ �Է� �䱸
                            } else { // ȸ���� �ۼ��� ����
                                if ( $login_yn == 'Y' ) {
                                    if ( $w_user_id == $user_id || $user_id == firstWriteUserId($id, $g_no) ) {
                                        $sercurity_cotent_chk = '%' . $id .'_' . $no . $sercurity_cotent_chk;
                                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
                                            @session_register('sercurity_cotent_chk');
                                        } else {
                                            $_SESSION['sercurity_cotent_chk'] = $sercurity_cotent_chk;  // 4.10 ���� ó��.
                                        }
                                        $sercurity_stats = true;
                                        include $baseDir . 'view.php'; // �б� ������
                                    } else {
                                        Message('S', '0039','', $skinDir); // �������
                                    }
                                } else {
                                    Message('S', '0039','', $skinDir); // �������
                                }
                            }
                        }
                    } else { // ��б� �����ȱ�
                        include $baseDir . 'view.php'; // �б� ������
                    }
                } else {
                    $sercurity_stats = true;
                    include $baseDir . 'view.php'; // �б� ������
                }
            } else if ( $exec == 'insert' || $exec == 'update' || $exec == 'answer' ) { // �Է�, ���� , �亯ȭ��
                include 'js/board_write_js.php'; // �� ���� javascript
                include $baseDir .'write.php'; // ����Ʈ ������
            } else if ( $exec == 'delete' ) { // ���� [��й�ȣ �䱸]
                include 'js/board_ask_password_js.php'; // �� ���� javascript
                $title = '���� �Ͻðڽ��ϱ�?';
                include $baseDir .'ask_password.php'; // �н����� �䱸
            } else if ( $exec == 'delete_exec' ) {  // ���� ����
                include $libDir . 'delete_exec.php'; // ���� ����
            } else if ( $exec == 'insert_exec' || $exec == 'update_exec' || $exec == 'answer_exec') { // �Է�, ����, �亯 ����
                $sercurity_cotent_chk = $_SESSION['sercurity_cotent_chk'];
                include $libDir . 'write_exec.php'; // �Է� ����
            } else if ( $exec_gubun == 'board' && $exec == 'insert_comment_exec' ) { // �ǰ� �ޱ� �Է� ����
                include $libDir . 'write_comment_exec.php'; // �Է� ����
            } else if ( $exec == 'delete_comment' ) { // �ǰ� �ޱ� ���� [��й�ȣ �䱸]
                include 'js/board_ask_password_js.php'; // �� ���� javascript
                $title = '���� �Ͻðڽ��ϱ�?';
                include $baseDir .'ask_password.php'; // �н����� �䱸
            } else if ( $exec == 'delete_comment_exec' ) { // �ǰ� �ޱ� ���� ����
                include $libDir . 'write_comment_exec.php'; // �Է� ����
            } else if ( $exec == 'admin_data_copy' || $exec == 'admin_data_move' || $exec == 'admin_data_delete' ) {
                if ( $admin_yn == 'Y' ) {
                    include $libDir . 'admin_exec.php'; // �ڷ� �̵�, ����
                }
            }
            if ( strpos($exec, '_exec') == false ) {
                include $baseDir . 'exterior_copyright.txt'; // �ܺ� ī�Ƕ����� ���� �κ�
            }
        }
    }
}
?>