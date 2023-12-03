<?
if ( function_exists('_head') ) {
    if ( $id || $gubun == 'ALL_PLAY' || $gubun == 'RANDOM_PLAY' || $gubun == 'SINGLE_PLAY' || $gubun == 'SA' || $gubun == 'MA' ) {

    /* --------- 개인 앨범 정보 --------- */
    // album_no : 앨범 아이디
    // name     : 앨범 명
    // id       : 게시판 번호
    // no       : 음악 번호 ( 게시물 번호 )
    // o_seq    : 정렬 순서
    // reg_date : 앨범 생성일

        $cartCnt = 0 ;

        $tmpPlayId  = ''; // 임시 보관용
        $playId     = ''; // 게시판 아이디
        $playNo     = ''; // 게시물 번호
        $sql        = ''; // sql문
        $where      = ''; // where문
        $makeSql    = 'Y'; // 'Y' : sql문 생성 , 'N' : where 조건 추가
    //  ECHO "alert ( 'play_album_retrive.php3 \\n tmp_cart:   " . $HTTP_SESSION_VARS['tmp_cart'    ] . "\\n media_cart: " . $HTTP_SESSION_VARS['media_cart'  ] . "');";
        if ( $gubun == 'ALL_PLAY' || $gubun == 'RANDOM_PLAY' || $gubun == 'SINGLE_PLAY' ) {
            if ( isset($HTTP_SESSION_VARS['tmp_cart']) ) {
    //            echo $HTTP_SESSION_VARS['tmp_cart'] . '<BR>';
                $media_cart1 = $HTTP_SESSION_VARS['tmp_cart'];
    //            echo $media_cart . '<BR>';
            }
        } else if ( $gubun == 'CART_PLAY' ) {
            if ( isset($HTTP_SESSION_VARS['media_cart']) ) {
                $media_cart1 = $HTTP_SESSION_VARS['media_cart'];
            }
        } else if ( $gubun == 'SA' || $gubun == 'MA' ) {
            $media_cart1 = $media_cart; // Parameter 값
        }
    //  ECHO "alert ( 'play_album_retrive.php4 \\n tmp_cart:   " . $HTTP_SESSION_VARS['tmp_cart'    ] . "\\n media_cart: " . $HTTP_SESSION_VARS['media_cart'  ] . "');";
        $sqlArray = "";
        $tmp_media_cart = explode ( '%', $media_cart1);
        asort ($tmp_media_cart); // 정렬
        reset ($tmp_media_cart);
    //  ECHO "alert ( 'play_album_retrive.php5 \\n tmp_cart:   " . $HTTP_SESSION_VARS['tmp_cart'    ] . "\\n media_cart: " . $HTTP_SESSION_VARS['media_cart'  ] . "');";
        while ( list ($key, $val) = each ($tmp_media_cart) ) {
            if ( $val ) {
                $tmp_key = explode ( '*', $val );
                $playId  = $tmp_key [0];

                $tmp_key = explode ( '_', $tmp_key [1]);
                $playNo = $tmp_key[1];

                if ( $playId != $tmpPlayId) {
                    $makeSql = 'Y';
                } else {
                    $makeSql = 'N';
                }

                if ( $makeSql == 'Y' && $sql ) {
                    $sqlArray[$playId] = $sql . $where . ")";
                    $sql    = '';
                    $where  = '';
                }
                if ( $makeSql == 'Y' ) {
                    $sql   = "select * from $tb_bbs_data" . "_" . $playId;
                    $where = " where no in ('" . $playNo ."'";
                } else {
                    $where .= ",'" . $playNo ."'";
                    $makeSql = 'N';
                }

                $tmpPlayId = $playId;
              //echo $playId . "<BR>\n";
              //echo $playNo . "<BR>\n";
            }
        }

        if ( $sql ) {
            $sqlArray[$playId] = $sql . $where . ")";
        }

    //  ECHO "alert ( 'media_cart: " . $media_cart1 . "');";
        if ( $media_cart1 ) {
            if ( $gubun == 'SA' || $gubun == 'MA' ) {
                echo "if ( parent.DP_W_playPopup != null && typeof(parent.DP_W_playPopup.document) == 'object') {\n";
            }
            while ( list ($playId, $sql) = each ($sqlArray) ) {
    //          echo $sql . '<BR>';
                $stmt = multiRowSQLQuery ($sql);

                while ( $data = multiRowFetch  ($stmt) ) {
                    $title = str_replace("'"   , "\'"  , $data['title']);
                    if ( $data['f_date1'] ) {
                        if ( $gubun == 'ALL_PLAY' || $gubun == 'RANDOM_PLAY' || $gubun == 'CART_PLAY' || $gubun == 'SINGLE_PLAY' ) {
                            echo "DP_DBOARD_Add_PlayInfor('" . $playId . "','" . $data['no']. "','" . $title. "','" . $data['name']. "','');\n";
                        } else if ( $gubun == 'SA' || $gubun == 'MA' ) {
                            echo "parent.DP_W_playPopup.DP_DBOARD_Add_PlayInfor('" . $playId . "','" . $data['no']. "','" . $title. "','" . $data['name']. "','');\n";
                        }
                    }
    //				echo $data [content];
                    $contentArray = split ("[\r\n]", $data [content]);
                    $cnt = sizeof( $contentArray );
    //				echo 'gubun : ' . $gubun . '<BR>';

                    for ($i=0;$i<$cnt;$i++) {
                        list($title, $artist, $url, $lyrics_url)  = explode ('*', $contentArray[$i]);
                        $title = str_replace("'"   , "\'"  , $title);
    //					echo $title . ' / ' . $artist . ' / ' . $url . "\n";
                        if ( $title && $url ) {
                            if ( $gubun == 'ALL_PLAY' || $gubun == 'RANDOM_PLAY' || $gubun == 'CART_PLAY' || $gubun == 'SINGLE_PLAY' ) {
                                echo "DP_Add_PlayInfor('" . $url . "','" . $title . "','" . $artist. "','". $lyrics_url ."');\n";
                            } else if ( $gubun == 'SA' || $gubun == 'MA' ) {
                                echo "parent.DP_W_playPopup.DP_Add_PlayInfor('" . $url . "','" . $title . "','" . $artist. "','". $lyrics_url ."');\n";
                            }
                        }
                    }
                }
            }
            if ( $gubun == 'SA' || $gubun == 'MA' ) {
                echo "    parent.DP_W_playPopup.DP_PLAY_LIST_MAKE();\n";
                echo "    parent.DP_W_playPopup.focus();\n";
                echo "}\n";
            }
        } else if ( $gubun == 'BBS_ONE_PLAY' ) {
            $sql = "select * from $tb_bbs_data" . "_" . $id;
            if ( $play_no ) $sql .= " where no = '$play_no'";
            else $sql .= ' order by g_no';

            $stmt = multiRowSQLQuery ($sql);
            while ( $data = multiRowFetch  ($stmt) ) {
                if ( $data['f_date1'] ) {
                    $title = str_replace("'"   , "\'"  , $data['title']);
                    echo "DP_DBOARD_Add_PlayInfor('" . $id . "','" . $data['no']. "','" . $title. "','" . $data['name']. "','');\n";
                }
                $contentArray = split ("[\r\n]", $data [content]);
                $cnt = sizeof( $contentArray );
                for ($i=0;$i<$cnt;$i++) {
                    list($title, $artist, $url, $lyrics_url)  = explode ('*', $contentArray[$i]);
                    $title = str_replace("'"   , "\'"  , $title);
                    if ( $title && $url ) {
                        echo "DP_Add_PlayInfor('" . $url . "','" . $title . "','" . $artist. "','". $lyrics_url ."');\n";
                    }
                }
            }
        } else { // 선택된 음악이 없을경우.
            include 'common/message_table.inc'; // 메시지 테이블
            echo "alert ( '".$errMsgTable['S0067']."' );\n";
        }
    //  ECHO "alert ( 'play_album_retrive.php끝 \\n tmp_cart:   " . $HTTP_SESSION_VARS['tmp_cart'    ] . "\\n media_cart: " . $HTTP_SESSION_VARS['media_cart'  ] . "');";
    }
}
?>