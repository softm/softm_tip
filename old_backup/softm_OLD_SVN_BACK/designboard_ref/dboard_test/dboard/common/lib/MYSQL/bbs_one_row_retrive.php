<?
if ( function_exists('head') && $no ) {
    /* 게시물 한건 조회 */
    $sql = "select * from $tb_bbs_data" . "_" . $id . " where no = '$no'";

    $data = singleRowSQLQuery ($sql);
    if ( $data ) {
        $use_st     = $data['use_st'   ];   /* 글 상태          */
        if ( ( $use_st != 8 && $use_st != 9 ) || $admin_yn == 'Y' ) {
            /* ----- 값 설정 ------------------------------------ */
            $no         = $data['no'       ];   /* 게시물 번호      */
            $cat_no     = $data['cat_no'   ];   /* 카테고리 번호    */
            $cat_name   = $category ['name'][$cat_no];   /* 카테고리 명 */

    //      $a_view    .= $a_view_tmp . '&no=' .$no . "'>";
            $a_view    .= $a_view_tmp . $no . "');return false;\">";
            $g_no       = $data['g_no'     ];   /* 그룹아이디       */
            $depth      = $data['depth'    ];   /* 답변레벨         */
            $o_seq      = $data['o_seq'    ];   /* 정렬 순서        */
            $pre_no     = $data['pre_no'   ];   /* 이전 게시물 번호 */
            $next_no    = $data['next_no'  ];   /* 이후 게시물 번호 */
            $w_member_level = $data['member_level']; /* 회원 레벨   */
            $w_user_id  = $data['user_id'  ];   /* 사용자 ID        */
            $name       = $data['name'     ];   /* 이름             */
            $password   = $data['password' ];   /* 비밀번호         */
            $title      = $data['title'    ];   /* 제목             */

            $html_yn    = $data['html_yn'  ];   /* Html 사용여부    */
            $mail_yn    = $data['mail_yn'  ];   /* 답변 확인 메일   */

            $content    = $data['content'  ];   /* 내용             */
            $e_mail     = $data['e_mail'   ];   /* E-mail           */
            $home       = $data['home'     ];   /* Homepage         */

            $f_path1    = $data['f_path1'  ];   /* 파일 실제 경로1   */
            $f_name1    = $data['f_name1'  ];   /* 파일 명1          */
            $f_ext1     = $data['f_ext1'   ];   /* 파일 확장자1      */
            $f_size1    = $data['f_size1'  ];   /* 파일 크기1        */
            $f_date1    = $data['f_date1'  ];   /* 저장 파일명1      */

            $f_path2    = $data['f_path2'  ];   /* 파일 실제 경로2   */
            $f_name2    = $data['f_name2'  ];   /* 파일 명2          */
            $f_ext2     = $data['f_ext2'   ];   /* 파일 확장자2      */
            $f_size2    = $data['f_size2'  ];   /* 파일 크기2        */
            $f_date2    = $data['f_date2'  ];   /* 저장 파일명2      */

            $reg_date   = $data['reg_date' ];   /* 작성 및 변경일자 */
            $reg_year   = substr($reg_date, 0 ,4);
            $reg_month  = substr($reg_date, 4 ,2);
            $reg_day    = substr($reg_date, 6 ,2);
            $reg_hour   = substr($reg_date, 8 ,2);
            $reg_min    = substr($reg_date, 10,2);
            $reg_sec    = substr($reg_date, 12,2);
            $reg_date   = substr($reg_date, 0,4) . '.' . substr($reg_date, 4,2) . '.' . substr($reg_date, 6,2);

            $recom_hit  = $data['recom_hit'];   /* 추천 수          */
            $hit        = $data['hit'      ];   /* 조회수           */
            $down_hit1  = $data['down_hit1'];   /* 다운수1          */
            $down_hit2  = $data['down_hit2'];   /* 다운수2          */
            $link1      = $data['link1'    ];   /* 링크1            */
            $link2      = $data['link2'    ];   /* 링크2            */
            $ip         = $data['ip'       ];   /* 작성 IP 주소     */
        }
    } else {
        $no         = '';   /* 게시물 번호      */
    }
    
    if ( $exec == 'update' || $exec == 'answer' ) {
    	$content = str_replace("<!--?", "<?", $content);
    	$content = str_replace("?-->" , "?>", $content);
    }    
}
?>