<?
/*------- ��ȯ���� ���� -------------------------------------------------------*/
/*------- rtnvalue��� ũ�� 2�� �迭�� ��ȯ�մϴ�. ----------------------------*/
/*------- rtnvalue[0] ������ ���ϸ� -------------------------------------------*/
/*------- rtnvalue[1] �����޽���    -------------------------------------------*/

function fileUpload($savedir,$userfile, $userfile_name, $extension) {
    if( strcmp ( $userfile,"none") ) {
        echo "Ȯ���ڸ� : $extension <BR>";
        echo "userfile : $userfile";
        echo "savedir�� : $savedir <BR>";
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
            echo "������ ������ ���ε尡 ���� �Ǿ� �ֽ��ϴ�.";
            $errortext = "������ ������ ���ε尡 ���� �Ǿ� �ֽ��ϴ�.";
            $rtnvalue[0] = "";
            $rtnvalue[1] = $errortext;
            return $rtnvalue;
        }
//        $userfile_name = ereg_replace(" ","",$userfile_name);
//        $userfile_name = ereg_replace("\(","_",$userfile_name);
//        $userfile_name = ereg_replace("\)","_",$userfile_name);

        $exist = file_exists("$savedir/".DateToMirco()."$extension");
        while ( $exist = file_exists("$savedir/$userfile_name.$extension") ) {
            echo " ������ ���ϰ� ������ �̸��� ������ �����մϴ�.";
            $userfile_name = DateToMirco();
        }

        echo  "���ϸ� : " . "$savedir/$userfile_name.$extension";

        echo "<BR>";
        echo "������丮 : " . $savedir;
        if ( !$exist ) {
            if ( !copy($userfile,"$savedir/$userfile_name.$extension") ) {
//                echo " �������� �����ϴ�.";
                $errortext = "�������� �����ϴ�.";
//    exit;
                $rtnvalue[0] = "";
                $rtnvalue[1] = $errortext;
                return $rtnvalue;
            }
            if ( !unlink ( $userfile) ) {
//                echo "�ӽ������� �����ϴµ� �����߽��ϴ�.";
                $errortext = "�ӽ������� �����ϴµ� �����߽��ϴ�.";
//    exit;
                $rtnvalue[0] = "";
                $rtnvalue[1] = $errortext;
                return $rtnvalue;
            }
        }
    }else {
//        echo "����~~~~";
        $errortext = "������ �������� �ʽ��ϴ�.";
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