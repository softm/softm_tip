<?
if ( function_exists('_head') ) {
    $baseWall = "^http^ftp^https"; // �� ���ƾ� �ұ.
    $IJTSEC = false;
    if ( ( $IJTERROR = strpos ( $libDir, "://") ) > 0 ) {
        if ( strpos ( $baseWall, substr ( $libDir, 0 , $IJTERROR ) ) < 1 ) { $IJTSEC = true; }
    } else { $IJTSEC = true; }

    if ( $IJTSEC ) {
        if ( ( $package == 'board' && $displayView[2] && $bbsGrant['grant_comment'] == 'Y' ) || ( $package == 'poll' && $opiniony_yn == 'Y' && $pollGrant['grant_write'] == 'Y' ) )
        {
            $name          = $memInfor['name' ]; // �̸�
            // �ǰ߱� ��
            if ( $login_yn == 'Y' ) { // �α��� �ѳ��� ��й�ȣ �� ������
               $hide_password_s = "<!--"; $hide_password_e = "-->";
    //         if ( $admin_yn == 'Y' ) { // �̸��� ���θ� ������ �� �־��..
                    $hide_name_s     = ""; $hide_name_e     = "";
    //         } else {
    //              $hide_name_s     = "<!--"; $hide_name_e     = "-->";
    //         }
            } else { // �α��� �� �ѳ� �� �̸��̶� �н������ �ٹ����
                $hide_password_s = ""; $hide_password_e = "";
                $hide_name_s     = ""; $hide_name_e     = "";
            }

            if ( $package == 'board' ) {
                $displayCharacter = $displayList[9]       ;
            } else if ( $package == 'poll' ) {
                $displayCharacter = '1'                   ; // �������� ȸ���̹����� ��Ų ���������� �ݿ���
            }

            $character = '';    // ȸ�� ������
            $character = printMemberIcon($memInfor['member_level'], $user_id, $displayCharacter ); // ȸ�� ������

            if ( file_exists($skinDir ."view_write_comment.php" ) ) {
                include $skinDir ."view_write_comment.php"; //  �ǰ߱� �Է� ��Ų
            }
        }
    }
}
?>