<?
if ( function_exists('_head') ) {
    /*
    * include 되었는지를 검사
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
            $fp	 = fopen($Profile, "r"); // 읽기 모드이면서 포인터가 맨 처음에 위치 합니다.
            while (!feof($fp)) {
                $curLine=fgets($fp,4096);
                $curLine=ereg_replace("\n","",$curLine);
                $line	= split("=",$curLine);
                $KeyName = $line[0];
        // 기존의 값을 갱신하는 경우.
                if ( $PKeyName == $KeyName ) {
                    $all[$index] = "$KeyName=$PKeyVal";
                    $append = 'N';
        // 기존의 값을 갱신하는 경우.
                }else {
                    $all[$index] = $curLine;
                }
                $index++;
            }
        // 새로운 값을 추가 했을 경우.
            if ( $append == 'Y' ) {
                $all[$index] = "$PKeyName=$PKeyVal\n";
            }
            $writeStr = join("\n",$all);
            fclose($fp);
        } else {
            $writeStr = "$PKeyName=$PKeyVal\n";
        }

        // 새로 씁니다.
        $fp=@fopen($Profile,"w+");
        @fwrite($fp,$writeStr);
        @fclose($fp);
        $writeStr = ereg_replace("\n","<BR>",$writeStr);
    //   echo "보기 :<font color='red'>" .$writeStr ."</font>";
    }

    function getKey ( $Profile, $PKeyName ) {
        global $baseDir;
        $Profile = $baseDir . $Profile;
        if ( file_exists($Profile) && filesize($Profile) > 0 ) {
            $fp	 = fopen($Profile, "r"); // 읽기 쓰기 모드이면서 포인터가 맨 처음에 위치 합니다.
            while ($curLine=fgets($fp,4096)) {
                $line	= split("=",$curLine);
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
        $fp	 = fopen($Profile, "r"); // 읽기 쓰기 모드이면서 포인터가 맨 처음에 위치 합니다.
        $result=array();
        while ($curLine=fgets($fp,4096)) {
            $line	= split("=",$curLine);
            $result[$line[0]]=$line[1];
        }
        fclose($fp);
        return $result;
    }

    function removeKey ( $Profile, $PKeyName ) {
        $all	= array();
        $fp	 = fopen($Profile, "r+"); // 읽기 쓰기 모드이면서 포인터가 맨 처음에 위치 합니다.
        $index  = 0;
        while ($curLine=fgets($fp,4096)) {
            $curLine=ereg_replace("\n","",$curLine);
            $line	= split("=",$curLine);
            $KeyName = $line[0];
            $KeyVal  = $line[1];
    // 지우려는 값을 제외한 값 만을 배열에 넣기 위한 조건입니다.
            if ( $PKeyName != $KeyName ) {
                $all[$index] = $curLine;
                $index++;
            }
        }
        $writeStr = join("\n",$all);
        fclose($fp);
    // 새로 씁니다.
        $fp=fopen($Profile,"w");
        fwrite($fp,$writeStr);
        fclose($fp);
    }
}
?>