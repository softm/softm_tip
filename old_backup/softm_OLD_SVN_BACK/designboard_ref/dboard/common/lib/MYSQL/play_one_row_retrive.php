<?
if ( function_exists('_head') && $id && $no ) {
    /* 게시물 한건 조회 */
    $sql = "select * from $tb_bbs_data" . "_" . $id . " where no = '$no'";

//  logs ( '$sql : '. $sql . '<BR>' , true);

    $data = singleRowSQLQuery ($sql);
    if ( $data ) {
        $use_st     = $data['use_st'   ];   /* 글 상태          */
        if ( ( $use_st != 8 && $use_st != 9 ) || $admin_yn == 'Y' ) {

            /* ----- 값 설정 ------------------------------------ */
            $no         = $data['no'       ];   /* 게시물 번호       */
            $content    = $data['content'  ];   /* 내용              */
            $f_path1    = $data['f_path1'  ];   /* 파일 실제 경로1   */
            $f_ext1     = $data['f_ext1'   ];   /* 파일 확장자1      */
            $f_date1    = $data['f_date1'  ];   /* 저장 파일명1      */
			$url = 'http://' . $HTTP_SERVER_VARS['HTTP_HOST'] . $sysInfor["base_dir"] . "data/file/" . $id. "/$f_date1.$f_ext1";
//          echo "var playItem = parent.O_playList.DP_getVal( parent.S_point );\n";
//          echo "    alert ( playItem );\n";
//          echo "    playItem.setUrl('" . $url . "');\n";

            echo "var url = '" . $url . "';\n";
            $f_path2    = $data['f_path2'  ];   /* 파일 실제 경로2   */
            $f_ext2     = $data['f_ext2'   ];   /* 파일 확장자2      */
            $f_date2    = $data['f_date2'  ];   /* 저장 파일명2      */
            $lyricsUrl  = "data/file/$id/" .$f_date2 . "." . $f_ext2;
//          echo '가사 경로 : '  . $lyricsUrl;
            $lyricsData = '';

            if ( $f_ext2 && strpos("[txt, htm, html, data, lyrics, lyrs]", strtolower ($f_ext2) ) > 0 ) {
                $lyricsData = f_readFile($lyricsUrl);
                $lyricsData = str_replace("\r\n", "<BR>", $lyricsData);
                $lyricsData = str_replace("\n"  , "<BR>", $lyricsData);
                $lyricsData = str_replace('"'   , '\"'  , $lyricsData);
                $lyricsData = str_replace("'"   , "\'"  , $lyricsData);
            }
            echo "    parent.DP_lyricsData = \"" . $lyricsData . "\";\n";
            echo "    parent.DP_PLAY_CB ('" . $call_proc . "');\n";
        }
    } else {

    }
}
?>