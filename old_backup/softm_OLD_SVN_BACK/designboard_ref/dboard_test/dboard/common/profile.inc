<?
if ( function_exists('head') ) {
    /*
    * include �Ǿ������� �˻�
    **/
    if( defined("_dboard_profile_included") ) return;
        define ("_dboard_profile_included", true);

    function setKey ( $Profile, $PKeyName, $PKeyVal ) {
        global $baseDir;
        $all	= array();
        $index  = 0;
        $append = 'Y';
        $Profile = $baseDir . $Profile;
        if ( file_exists($Profile) && filesize($Profile) > 0 ) {
            $fp	 = fopen($Profile, "r"); // �б� ����̸鼭 �����Ͱ� �� ó���� ��ġ �մϴ�.
            while (!feof($fp)) {
                $curLine=fgets($fp,4096);
                $curLine=preg_replace("/\n/","",$curLine);
                $line	= preg_split("/=/",$curLine);
                $KeyName = $line[0];
        // ������ ���� �����ϴ� ���.
                if ( $PKeyName == $KeyName ) {
                    $all[$index] = "$KeyName=$PKeyVal";
                    $append = 'N';
        // ������ ���� �����ϴ� ���.
                }else {
                    $all[$index] = $curLine;
                }
                $index++;
            }
        // ���ο� ���� �߰� ���� ���.
            if ( $append == 'Y' ) {
                $all[$index] = "$PKeyName=$PKeyVal\n";
            }
            $writeStr = join("\n",$all);
            fclose($fp);
        } else {
            $writeStr = "$PKeyName=$PKeyVal\n";
        }

        // ���� ���ϴ�.
        $fp=@fopen($Profile,"w+");
        @fwrite($fp,$writeStr);
        @fclose($fp);
        $writeStr = preg_replace("/\n/","<BR>",$writeStr);
    //   echo "���� :<font color='red'>" .$writeStr ."</font>";
    }

    function getKey ( $Profile, $PKeyName ) {
        global $baseDir;
        $Profile = $baseDir . $Profile;
        if ( file_exists($Profile) && filesize($Profile) > 0 ) {
            $fp	 = fopen($Profile, "r"); // �б� ���� ����̸鼭 �����Ͱ� �� ó���� ��ġ �մϴ�.
            while ($curLine=fgets($fp,4096)) {
                $line	= preg_split("/=/",$curLine);
                if ( $PKeyName == $line[0] ) {
                    $KeyVal  = $line[1];
                    break;
                }
            }
            fclose($fp);
        }
        return trim($KeyVal);
    }

    function getKeys( $Profile ) {
        $fp	 = fopen($Profile, "r"); // �б� ���� ����̸鼭 �����Ͱ� �� ó���� ��ġ �մϴ�.
        $result=array();
        while ($curLine=fgets($fp,4096)) {
            $line	= preg_split("/=/",$curLine);
            $result[$line[0]]=$line[1];
        }
        fclose($fp);
        return $result;
    }

    function removeKey ( $Profile, $PKeyName ) {
        $all	= array();
        $fp	 = fopen($Profile, "r+"); // �б� ���� ����̸鼭 �����Ͱ� �� ó���� ��ġ �մϴ�.
        $index  = 0;
        while ($curLine=fgets($fp,4096)) {
            $curLine=preg_replace("/\n/","",$curLine);
            $line	= preg_split("/=/",$curLine);
            $KeyName = $line[0];
            $KeyVal  = $line[1];
    // ������� ���� ������ �� ���� �迭�� �ֱ� ���� �����Դϴ�.
            if ( $PKeyName != $KeyName ) {
                $all[$index] = $curLine;
                $index++;
            }
        }
        $writeStr = join("\n",$all);
        fclose($fp);
    // ���� ���ϴ�.
        $fp=fopen($Profile,"w");
        fwrite($fp,$writeStr);
        fclose($fp);
    }
}
?>