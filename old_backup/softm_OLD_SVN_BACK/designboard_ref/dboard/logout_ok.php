<?
    include ( "common/lib.inc"      ); // 공통 라이브러리
    @session_destroy();

    if ( !$back ) {
        $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
    } else {
        $retunPage = $back;
    }
//    logs ( "흠먄 : " . $retunPage         .'<BR>', true);
//  $retunPage .= '?id='    . getUrlParamValue($HTTP_REFERER, 'id'  );
//  $retunPage .= '&exec='  . getUrlParamValue($HTTP_REFERER, 'exec');
//  $retunPage .= '&no='    . getUrlParamValue($HTTP_REFERER, 'no'  );

    $id         = ( getUrlParamValue($HTTP_REFERER, 'id'        ) ) ? getUrlParamValue($HTTP_REFERER, 'id'          ) : $id         ;
    $poll_id    = ( getUrlParamValue($HTTP_REFERER, 'poll_id'   ) ) ? getUrlParamValue($HTTP_REFERER, 'poll_id'     ) : $poll_id    ;
    $exec       = ( getUrlParamValue($HTTP_REFERER, 'exec'      ) ) ? getUrlParamValue($HTTP_REFERER, 'exec'        ) : $exec       ;
    $poll_exec  = ( getUrlParamValue($HTTP_REFERER, 'poll_exec' ) ) ? getUrlParamValue($HTTP_REFERER, 'poll_exec'   ) : $poll_exec  ;
    $npop       = ( getUrlParamValue($HTTP_REFERER, 'npop'      ) ) ? getUrlParamValue($HTTP_REFERER, 'npop'        ) : $npop       ;
    $no         = ( getUrlParamValue($HTTP_REFERER, 'no'        ) ) ? getUrlParamValue($HTTP_REFERER, 'no'          ) : $no         ;
    $s          = ( getUrlParamValue($HTTP_REFERER, 's'         ) ) ? getUrlParamValue($HTTP_REFERER, 's'           ) : $s          ;

    if ( !$login_skin_name ) { $login_skin_name = getUrlParamValue($HTTP_REFERER, 'login_skin_name' ); }
    if ( !$suc_mode        ) { $suc_mode        = getUrlParamValue($HTTP_REFERER, 'suc_mode'        ); }

    // 링크 설정
    $query_str = '';
    appendParam ($query_str,'id',$id);
    appendParam ($query_str,'exec',$exec);
    appendParam ($query_str,'no',$no);
    appendParam ($query_str,'s',$s);
    appendParam ($query_str,'npop',$npop);
    appendParam ($query_str,'poll_id',$poll_id);
    appendParam ($query_str,'poll_exec',$poll_exec);
    appendParam ($query_str,'login_skin_name',$login_skin_name);
    appendParam ($query_str,'suc_mode',$suc_mode);

    if ( $suc_mode == '2' ) { // 메시지화면
        appendParam ($query_str,'message',$message);
        appendParam ($query_str,'succ_url',$succ_url);
    } else if ( $suc_mode == '3' ) { // 지정URL로 이동 && $succ_url
        appendParam ($query_str,'succ_url',$succ_url);
    } else if ( $suc_mode == '4' ) { // 윈도우 닫기
        appendParam ($query_str,'message',$message);
    }

    $retunPage .= $query_str;

//  logs ( "흠먄 : " . $retunPage         .'<BR>', true);
    echo ( "<SCRIPT LANGUAGE='JavaScript'>\n");
    echo ( "<!--\n");
    echo ( "function getOnlyURL(_url) {\n");
    echo ( "	var url = _url;\n");
    echo ( "	var e = url.indexOf ( '?' );\n");
    echo ( "	if ( e > 0 ) url = url.substring(0,e);\n");
    echo ( "	return url;\n");
    echo ( "}\n");
    echo ( "    var opener_url = '';\n");
	echo ( "    var first = '';\n");
    echo ( "    if ( typeof(opener     ) != 'undefined' && typeof(opener.document) == 'object' ) {\n");
    echo ( "        opener_url = getOnlyURL(opener.document.location.href);\n");
    echo ( "        if ( typeof(opener.id  ) != 'undefined' ) { if ( first ) { opener_url += '?id='   + opener.id     ; first = false; } else { opener_url += '&id='   + opener.id     ; } }\n");
    echo ( "        if ( typeof(opener.exec) != 'undefined' ) { if ( first ) { opener_url += '?exec=' + opener.exec   ; first = false; } else { opener_url += '&exec=' + opener.exec   ; } }\n");
    echo ( "        if ( typeof(opener.no  ) != 'undefined' ) { if ( first ) { opener_url += '?no='   + opener.no     ; first = false; } else { opener_url += '&no='   + opener.no     ; } }\n");
    echo ( "        if ( typeof(opener.s   ) != 'undefined' ) { if ( first ) { opener_url += '?s='    + opener.s      ; first = false; } else { opener_url += '&s='    + opener.s      ; } }\n");
    echo ( "        if ( typeof(opener.npop) != 'undefined' ) { if ( first ) { opener_url += '?npop=' + opener.npop   ; first = false; } else { opener_url += '&npop=' + opener.npop   ; } }\n");
    if ( $poll_id   ) echo "if ( first ) { opener_url += '?poll_id=$poll_id'   ; first = false; } else { opener_url += '&poll_id=$poll_id'   ; }";
    if ( $poll_exec ) echo "if ( first ) { opener_url += '?poll_exec=$poll_exec'   ; first = false; } else { opener_url += '&poll_exec=$poll_exec'   ; }";
    echo ( "        opener.document.location.replace(opener_url);\n");
    echo ( "    }\n");
    echo ( "//-->\n");
    echo ( "</SCRIPT>\n");

    redirectPage( $retunPage );
?>