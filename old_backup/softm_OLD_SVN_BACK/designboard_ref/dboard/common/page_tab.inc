<?
/*
* include 되었는지를 검사
**/
if( defined("_dboard_page_tab_included") ) return;
	define ("_dboard_page_tab_included", true);

/*
* 함수명: _currentPage
* 설명  : 현재 페이지를 계산 합니다.
* Argus : start	: 시작 위치
*		: howMany  : 첫  페이지에   보여질 자료수
*		: moreMany : 첫  페이지이후 보여질 자료
**/
function jsFuncName() {
    global $package;
    if ( $package ) return $package . "PageTab";
    else return "pageTab";
}

function _currentPage ( $start, $howMany, $moreMany ) {
	$_rtn	 = 0;
	$curstart = 0;
	$interval = $howMany - $moreMany;

	if( $start == 1 ) { // 시작위치 Default Set
		$_rtn = 1;
	} else { // 시작 위치 지정
		$curstart   = $start - $interval;   // 현재 위치
		$_rtn = ( ( $curstart - 1 ) / $moreMany ) + 1;  // 현재 탭의 위치
	}
	return $_rtn;
}

/*
* 함수명: _totalPage
* 설명  : 총 페이지를 계산 합니다.
* Argus : totcount : 총 조회수
*		: howMany  : 첫  페이지에   보여질 자료수
*		: moreMany : 첫  페이지이후 보여질 자료
**/
function _totalPage ( $totcount, $howMany, $moreMany ) {
	$_rtn = 1;
	if ( $totcount <= $howMany || $howMany == 0 || $moreMany == 0 ) {
		$_rtn = 1;
	} else {
		$tmpTotcnt	 = $totcount - $howMany + $moreMany;
		$dbvalue = ( $tmpTotcnt / $howMany ) + 0.9;
		$_rtn = (int) $dbvalue;
	}
	return $_rtn;
}

/** 페이지 Tab을 구성합니다.
* @param $P_start the String
* @param $P_Totcount the String
* @param $P_HowMany the String
* @param $P_MoreMany the String
* @param $P_PageMany the String
* @param $P_target the String
*/
function _pageTab ()
{
	global $s, $tot;
    global $how_many, $more_many, $page_many, $HTTP_SERVER_VARS, $page_tab, $package;

    $P_start	= $s;
    $P_Totcount = $tot;

	$P_HowMany  = $how_many;
	$P_MoreMany = $more_many;
	$P_PageMany = $page_many;
	$P_target   = $HTTP_SERVER_VARS['PHP_SELF'];

	$_rtn = "";
	$curpage	 = 0; // 현재 위치
	$li_curpage  = 0; // 현재 탭의 위치
	$li_HowMany  = 0; // 첫번째 탭	  에서 화면에 보여질 자료의 갯수
	$li_MoreMany = 0; // 두번째 탭 이후 에서 화면에 보여질 자료의 갯수
	$li_Totcount = 0; // 총 조회수
	$li_totpage  = 0; // 총 탭의 갯수
	$li_limit	= $P_PageMany;
	$li_interval = 0;

	$li_HowMany  = $P_HowMany ;
	$li_Totcount = $P_Totcount;
		if ( $li_Totcount > $P_HowMany && $P_HowMany != 0 ) {

			if ( $P_MoreMany != 0 )   {   // 첫 페이지에 보여질 자료수
				$li_MoreMany = $P_MoreMany;
			} else					{   // 첫 페이지 Default Set
				$li_MoreMany = 10;
			}

			$li_Totcount = $li_Totcount - $li_HowMany + $li_MoreMany;

// ---- Start ------ HowMany만큼으로 첫번째 탭을 구성합니다.----------------------- //
/*  총 잘 갯수는 첫 페이지에 보여질 갯수 즉 $li_HowMany 값 을 뺀 값을 사용합니다.
// 만약 총 100 개의 자료 ( $li_Totcount ) 가 있고
// 첫 페이지에 보여질 자료수 ( $P_HowMany ) 가 11 개
// 두번째 페이지 부터 보여질 자료수가 ( $P_MoreMany) 가 존재 한다면.
// $li_Totcount - $P_HowMany 값을 총 조회수로 사용하여 페이지 Tab을 구성하고
// 첫번째 그룹을 출력하는 경우
//	  시작탭 + 1 ~ 종료탭 까지 출력 합니다.
//	  시작탭			 의 start : 무조건 1
//	  시작탭 + 1 ~ 종료탭의 start : start + $li_interval
// 두번재 이후의 그룹일 경우
//	  시작탭	 ~ 종료탭
//	  시작탭	 ~ 종료탭의 start : start + $li_interval
// li_interval값은
// 아래와 같이 설정 됩니다.
-----------------------------------------------------------
				$li_HowMany  $li_MoreMany  $li_interval
-----------------------------------------------------------
					10			5					5
-----------------------------------------------------------
					3			5					3
					3			5					-2
-----------------------------------------------------------
첫페이지에 보여질 자료와 그 다음 페이지의 자료수가 틀리게 설정되어 있지 않다면
시작 위치는 1 , 6 , 11 , 16 , 21 ... 입니다. ( 실제 시작 위치 )
하지만
		1 , 11 , 16 , 21 , 26 ...		( 재계산된 시작 위치 )
		1 ,  4 ,  9 , 14 , 19 ...		( 재계산된 시작 위치 )
의 구성이 되어야 합니다.
여기서 발생되는 5 와 -2 이라는 차이가 발생합니다. ( $li_interval )

재 계산된 시작위치가 넘어오면 실제 시작위치 + $li_interval start값 ( $curpage )을 재지정하면 됩니다.
*/
			$li_interval = $li_HowMany - $li_MoreMany;


// ---- Start ------ 총 페이지수 산출 ------------------------------------------ //

			if( $P_start == 1 )	  {   // 시작위치 Default Set
				$li_curpage=1;
			} else				  {   // 시작 위치 지정
				$curpage   = $P_start - $li_interval;   // 현재 위치
				$li_curpage = ( ( $curpage - 1 ) / $li_MoreMany ) + 1;  // 현재 탭의 위치
			}

// ---- Start ------ 총 페이지수 산출 ------------------------------------------ //
			$li_totpage = floor ( $li_Totcount / $li_MoreMany );
			// 페이수중에 여분의 레코드들을 출력하기위해  총페이지에 한페이지를 더함
			if ( $li_totpage * $li_MoreMany < $li_Totcount ) {		  // 총 탭의 갯수
				$li_totpage = $li_totpage + 1;
			}
// ---- End   ------ 총 페이지수 산출 ------------------------------------------ /

			$Tstart  = 0;
// ---- Start ------ 현재 Group의 계산 ----------------------------------------- //
			$tmp	 = $li_curpage;

			$tmp = ceil( $tmp / $li_limit );

			$li_curarea = (int) $tmp;

			if  ( $li_curarea == 0 ) $li_curarea = 1;

// ---- End   ------ 현재 Group의 계산 ----------------------------------------- //
			$tmpTot = $li_Totcount - $li_HowMany;

			$spage =  ( $li_limit * ( $li_curarea - 1 ) ) + 1; // 시작 탭 위치

			if ( ( $li_limit * $li_curarea ) >= $li_totpage ) {
				$epage = $li_totpage				; // 종료 탭 위치
			} else {
				$epage = ( $li_limit * $li_curarea ); // 종료 탭 위치
			}

/* 시작 페이지, 마지막 페이지... */
			$last_stat   = ( ( $li_MoreMany * ( $li_totpage - 1 ) ) + 1 );
			$last_stat  += $li_interval;
			if ( $page_tab['page_start_first'] && $spage > 1 ) {
				$first_tab  = $page_tab['page_start_first'] . "<a href='#' onclick='" . jsFuncName() . "(" . 1			. "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". '1' . "</a>" . $page_tab['page_end_first'];
			}
			if ( $page_tab['page_start_last'] && $epage != $li_totpage ) {
				$last_tab   = $page_tab['page_start_last' ] . "<a href='#' onclick='" . jsFuncName() . "(" . $last_stat  . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $li_totpage . "</a>". $page_tab['page_end_last'];
			}

// ---- Start ------ ◀ 이전 몇 개 Tab ----------------------------------------- //
			if ( $spage - 1 < 1)		 {
				$_rtn .= $page_tab['pre'];
			} else					  {
				$Tstart  = ( ( $li_MoreMany * ( $spage - $li_limit - 1 ) ) + 1 );
				$Tstart += $li_interval;
				if  ( $li_curarea == 2 ) {
//					  out.print("<a href='" + $P_target + "?$P_start=1'>◀ 이전&nbsp;</a>");
						$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(1," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['pre'] ."</a>";
//					  out.print("<a href='#' onclick='pageTab(1," + $P_Totcount + ",\"" + $P_target + "\");return false;'>◀ &nbsp;</a>");
				} else {
//					  out.print("<a href='" + $P_target + "?$P_start=" + $Tstart + "'>◀ 이전&nbsp;</a>");
						$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['pre'] ."</a>";
//					  out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>◀ &nbsp;</a>");
				}
			}
// ---- End   ------ ◀ 이전 몇 개 Tab ----------------------------------------- //

		 $_rtn .= $first_tab;

		 $_rtn .= " ";
// ---- Start ------ ◀ 한 Tab 씩 이동 ----------------------------------------- //
			// <!-- 여기부터는 다음페이지와 이전페이지를 넘나들기위해서................... -->
			if ( $li_curpage > 1 ) {
				$Tstart = ( ( $li_MoreMany * ( $li_curpage - 2 ) ) + 1 );
				$Tstart += $li_interval;
				if  ( $li_curarea == 1 ) {
					if ( $li_curpage == 2 ) {
						$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(1," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['pre_1'] ."</a>";
//					  out.print("<a href='#' onclick='pageTab(1," + $P_Totcount + ",\"" + $P_target + "\");return false;'>◀&nbsp;</a>");
					} else {
						$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['pre_1'] ."</a>";
//					  out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>◀&nbsp;</a>");
					}
				} else {
					$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['pre_1'] ."</a>";
//				  out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>◀&nbsp;</a>");
				}
			}
			else {
				$_rtn .= $page_tab['pre_1'];
//			  out.print("◀&nbsp;");
			}
// ---- End   ------ ◀ 한 Tab 씩 이동 ---------------------------------------- //
		 $_rtn .= " ";
// ---- Start ------ -------------- ------------------------------------------- //
// 첫번째 Group의 첫번째 탭일 경우
// 시작 탭위치를 1만큼 증가 시키고
// 화면상에는 무조건 1을 출력 시킵니다.
			if  ( $li_curarea == 1 ) {
				$_rtn .= $page_tab['page_sep'];
//			  out.print(" |");
				$spage++;
				if ( $li_curpage == 1 ) {
					$_rtn .= $page_tab['page_start_active'] . "1".  $page_tab['page_end_active'];
//				  out.print("1");
				} else {
					$_rtn .= $page_tab['page_start' ];
					$_rtn .= $page_tab['page_pre'] . "<a href='#' onclick='" . jsFuncName() . "( 1," . $P_Totcount . ",\"" . $P_target . "\");return false;'>1</a>" . $page_tab['page_next'];
					$_rtn .= $page_tab['page_end' ];
//				  out.print("<a href='#' onclick='pageTab( 1," + $P_Totcount + ",\"" + $P_target + "\");return false;'>1</a>");

				}
			}
// ---- End   ------ -------------- ------------------------------------------- //

// ---- Start ------ 숫자 Display Tab ----------------------------------------- //
			for( $a = $spage ; $a <= $epage; $a++) {
				$_rtn .= $page_tab['page_sep'];
//					out.print(" |");
				if ( $a == $li_curpage ) {
					$_rtn .= $page_tab['page_start_active'] . $a . $page_tab['page_end_active'];
//					out.print(a);
				}
				else {
				$_rtn .= $page_tab['page_start'];
				$Tstart  = ( ( $li_MoreMany * ( $a - 1 ) ) + 1 );
				$Tstart += $li_interval;
					$_rtn .= $page_tab['page_pre'] . "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>" . $a . "</a>" . $page_tab['page_next'];
//						out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>" + a + "</a>");
				$_rtn .= $page_tab['page_end' ];
				}
			}
// ---- End   ------ 숫자 Display Tab ----------------------------------------- //
			$_rtn .= $page_tab['page_sep'];
			$_rtn .= " ";
// ---- Start ------ ▶ 한 Tab 씩 이동 ---------------------------------------- //
			if ( $li_totpage > $li_curpage ) {
				$Tstart = ( ( $li_MoreMany * $li_curpage ) + 1);
				$Tstart += $li_interval;
				$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['next_1'] ."</a>";
//			  out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>&nbsp;▶</a>");
			}
			else{
				$_rtn .= $page_tab['next_1'];
//					 out.print("&nbsp;▶");
			}
// ---- End   ------ ▶ 한 Tab 씩 이동 ---------------------------------------- //
		 $_rtn .= " ";
		 $_rtn .= $last_tab;
// ---- Start ------ ▶ 다음 몇 개 Tab ---------------------------------------- //
// echo 'epage	  : ' . $epage		. '<BR>';
			if ( $epage == $li_totpage ) {
//			  out.print("[다음 " + $li_limit + " 개]&nbsp;");
				$_rtn .= $page_tab['next'];
//			  out.print("&nbsp;▶");
			}
			else {
				$Tstart  = ( ( $li_MoreMany * ( $epage + 1 - 1 ) ) + 1 );
				$Tstart += $li_interval;
//					 out.print("<a href='" + $P_target + "?$P_start=" + $Tstart + "'>다음&nbsp;▶</a>");
				$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['next'] ."</a>";
//			  out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>&nbsp;▶</a>");
			}
// ---- End   ------ ▶ 다음 몇 개 Tab ---------------------------------------- //
		}
	if ( !$_rtn ) $_rtn = '&nbsp;';
	return $_rtn;
}

function _prevPageTab ( $P_start , $P_Totcount, $P_HowMany, $P_MoreMany, $P_PageMany, $P_target, $pre_tag='' ) {
	$_rtn = "";
	$curpage	 = 0; // 현재 위치
	$li_curpage  = 0; // 현재 탭의 위치
	$li_HowMany  = 0; // 첫번째 탭	  에서 화면에 보여질 자료의 갯수
	$li_MoreMany = 0; // 두번째 탭 이후 에서 화면에 보여질 자료의 갯수
	$li_Totcount = 0; // 총 조회수
	$li_totpage  = 0; // 총 탭의 갯수
	$li_limit	= $P_PageMany;
	$li_interval = 0;

	$li_HowMany  = $P_HowMany ;
	$li_Totcount = $P_Totcount;

	if ( $li_Totcount > $P_HowMany && $P_HowMany != 0 ) {

		if ( $P_MoreMany != 0 )   {   // 첫 페이지에 보여질 자료수
			$li_MoreMany = $P_MoreMany;
		} else					{   // 첫 페이지 Default Set
			$li_MoreMany = 10;
		}

		$li_Totcount = $li_Totcount - $li_HowMany + $li_MoreMany;

		$li_interval = $li_HowMany - $li_MoreMany;

// ---- Start ------ 총 페이지수 산출 ------------------------------------------ //

		if( $P_start == 1 )	  {   // 시작위치 Default Set
			$li_curpage=1;
		} else				  {   // 시작 위치 지정
			$curpage   = $P_start - $li_interval;   // 현재 위치
			$li_curpage = ( ( $curpage - 1 ) / $li_MoreMany ) + 1;  // 현재 탭의 위치
		}

// ---- End   ------ 총 페이지수 산출 ------------------------------------------ /
		$Tstart  = 0;
// ---- Start ------ 현재 Group의 계산 ----------------------------------------- //
		$tmp	 = $li_curpage;

		$tmp = ceil( $tmp / $li_limit );

		$li_curarea = (int) $tmp;

		if  ( $li_curarea == 0 ) $li_curarea = 1;

// ---- End   ------ 현재 Group의 계산 ----------------------------------------- //

// ---- Start ------ ◀ 한 Tab 씩 이동 ----------------------------------------- //
		// <!-- 여기부터는 다음페이지와 이전페이지를 넘나들기위해서................... -->
		if ( $li_curpage > 1 ) {
			$Tstart = ( ( $li_MoreMany * ( $li_curpage - 2 ) ) + 1 );
			$Tstart += $li_interval;
			if  ( $li_curarea == 1 ) {
				if ( $li_curpage == 2 ) {
					$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(1," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $pre_tag ."";
				} else {
					$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $pre_tag ."";
				}
			} else {
				$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $pre_tag ."";
			}
		}
		else {
			$_rtn .= "<a>" . $pre_tag;
		}
// ---- End   ------ ◀ 한 Tab 씩 이동 ---------------------------------------- //
	}
	return $_rtn;
}

function _nextPageTab ( $P_start , $P_Totcount, $P_HowMany, $P_MoreMany, $P_PageMany, $P_target, $next_tag='' ) {
	$_rtn = "";
	$curpage	 = 0;	// 현재 위치
	$li_curpage  = 0;	// 현재 탭의 위치
	$li_HowMany  = 0;	// 첫번째 탭	  에서 화면에 보여질 자료의 갯수
	$li_MoreMany = 0;	// 두번째 탭 이후 에서 화면에 보여질 자료의 갯수
	$li_Totcount = 0;	// 총 조회수
	$li_totpage  = 0;	// 총 탭의 갯수
	$li_limit	= $P_PageMany;
	$li_interval = 0;

	$li_HowMany  = $P_HowMany ;
	$li_Totcount = $P_Totcount;

	if ( $li_Totcount > $P_HowMany && $P_HowMany != 0 ) {

		if ( $P_MoreMany != 0 )   {   // 첫 페이지에 보여질 자료수
			$li_MoreMany = $P_MoreMany;
		} else					{   // 첫 페이지 Default Set
			$li_MoreMany = 10;
		}

		$li_Totcount = $li_Totcount - $li_HowMany + $li_MoreMany;

		$li_interval = $li_HowMany - $li_MoreMany;

// ---- Start ------ 총 페이지수 산출 ------------------------------------------ //
		if( $P_start == 1 )	  {   // 시작위치 Default Set
			$li_curpage=1;
		} else				  {   // 시작 위치 지정
			$curpage   = $P_start - $li_interval;   // 현재 위치
			$li_curpage = ( ( $curpage - 1 ) / $li_MoreMany ) + 1;  // 현재 탭의 위치
		}

		$li_totpage = floor ( $li_Totcount / $li_MoreMany );
		// 페이수중에 여분의 레코드들을 출력하기위해  총페이지에 한페이지를 더함
		if ( $li_totpage * $li_MoreMany < $li_Totcount ) {		  // 총 탭의 갯수
			$li_totpage = $li_totpage + 1;
		}
// ---- End   ------ 총 페이지수 산출 ------------------------------------------ /

		$Tstart  = 0;
// ---- Start ------ ▶ 한 Tab 씩 이동 ---------------------------------------- //
			if ( $li_totpage > $li_curpage ) {
				$Tstart = ( ( $li_MoreMany * $li_curpage ) + 1);
				$Tstart += $li_interval;
				$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $next_tag ."";
			}
			else{
				$_rtn .= "<a>" . $next_tag;
//					 out.print("&nbsp;▶");
			}
// ---- End ------ ▶ 한 Tab 씩 이동 ---------------------------------------- //
	}
	return $_rtn;
}
?>
