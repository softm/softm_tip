<?
/*
* include �Ǿ������� �˻�
**/
if( defined("_dboard_page_tab_included") ) return;
	define ("_dboard_page_tab_included", true);

/*
* �Լ���: _currentPage
* ����  : ���� �������� ��� �մϴ�.
* Argus : start	: ���� ��ġ
*		: howMany  : ù  ��������   ������ �ڷ��
*		: moreMany : ù  ���������� ������ �ڷ�
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

	if( $start == 1 ) { // ������ġ Default Set
		$_rtn = 1;
	} else { // ���� ��ġ ����
		$curstart   = $start - $interval;   // ���� ��ġ
		$_rtn = ( ( $curstart - 1 ) / $moreMany ) + 1;  // ���� ���� ��ġ
	}
	return $_rtn;
}

/*
* �Լ���: _totalPage
* ����  : �� �������� ��� �մϴ�.
* Argus : totcount : �� ��ȸ��
*		: howMany  : ù  ��������   ������ �ڷ��
*		: moreMany : ù  ���������� ������ �ڷ�
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

/** ������ Tab�� �����մϴ�.
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
	$curpage	 = 0; // ���� ��ġ
	$li_curpage  = 0; // ���� ���� ��ġ
	$li_HowMany  = 0; // ù��° ��	  ���� ȭ�鿡 ������ �ڷ��� ����
	$li_MoreMany = 0; // �ι�° �� ���� ���� ȭ�鿡 ������ �ڷ��� ����
	$li_Totcount = 0; // �� ��ȸ��
	$li_totpage  = 0; // �� ���� ����
	$li_limit	= $P_PageMany;
	$li_interval = 0;

	$li_HowMany  = $P_HowMany ;
	$li_Totcount = $P_Totcount;
		if ( $li_Totcount > $P_HowMany && $P_HowMany != 0 ) {

			if ( $P_MoreMany != 0 )   {   // ù �������� ������ �ڷ��
				$li_MoreMany = $P_MoreMany;
			} else					{   // ù ������ Default Set
				$li_MoreMany = 10;
			}

			$li_Totcount = $li_Totcount - $li_HowMany + $li_MoreMany;

// ---- Start ------ HowMany��ŭ���� ù��° ���� �����մϴ�.----------------------- //
/*  �� �� ������ ù �������� ������ ���� �� $li_HowMany �� �� �� ���� ����մϴ�.
// ���� �� 100 ���� �ڷ� ( $li_Totcount ) �� �ְ�
// ù �������� ������ �ڷ�� ( $P_HowMany ) �� 11 ��
// �ι�° ������ ���� ������ �ڷ���� ( $P_MoreMany) �� ���� �Ѵٸ�.
// $li_Totcount - $P_HowMany ���� �� ��ȸ���� ����Ͽ� ������ Tab�� �����ϰ�
// ù��° �׷��� ����ϴ� ���
//	  ������ + 1 ~ ������ ���� ��� �մϴ�.
//	  ������			 �� start : ������ 1
//	  ������ + 1 ~ �������� start : start + $li_interval
// �ι��� ������ �׷��� ���
//	  ������	 ~ ������
//	  ������	 ~ �������� start : start + $li_interval
// li_interval����
// �Ʒ��� ���� ���� �˴ϴ�.
-----------------------------------------------------------
				$li_HowMany  $li_MoreMany  $li_interval
-----------------------------------------------------------
					10			5					5
-----------------------------------------------------------
					3			5					3
					3			5					-2
-----------------------------------------------------------
ù�������� ������ �ڷ�� �� ���� �������� �ڷ���� Ʋ���� �����Ǿ� ���� �ʴٸ�
���� ��ġ�� 1 , 6 , 11 , 16 , 21 ... �Դϴ�. ( ���� ���� ��ġ )
������
		1 , 11 , 16 , 21 , 26 ...		( ����� ���� ��ġ )
		1 ,  4 ,  9 , 14 , 19 ...		( ����� ���� ��ġ )
�� ������ �Ǿ�� �մϴ�.
���⼭ �߻��Ǵ� 5 �� -2 �̶�� ���̰� �߻��մϴ�. ( $li_interval )

�� ���� ������ġ�� �Ѿ���� ���� ������ġ + $li_interval start�� ( $curpage )�� �������ϸ� �˴ϴ�.
*/
			$li_interval = $li_HowMany - $li_MoreMany;


// ---- Start ------ �� �������� ���� ------------------------------------------ //

			if( $P_start == 1 )	  {   // ������ġ Default Set
				$li_curpage=1;
			} else				  {   // ���� ��ġ ����
				$curpage   = $P_start - $li_interval;   // ���� ��ġ
				$li_curpage = ( ( $curpage - 1 ) / $li_MoreMany ) + 1;  // ���� ���� ��ġ
			}

// ---- Start ------ �� �������� ���� ------------------------------------------ //
			$li_totpage = floor ( $li_Totcount / $li_MoreMany );
			// ���̼��߿� ������ ���ڵ���� ����ϱ�����  ���������� ���������� ����
			if ( $li_totpage * $li_MoreMany < $li_Totcount ) {		  // �� ���� ����
				$li_totpage = $li_totpage + 1;
			}
// ---- End   ------ �� �������� ���� ------------------------------------------ /

			$Tstart  = 0;
// ---- Start ------ ���� Group�� ��� ----------------------------------------- //
			$tmp	 = $li_curpage;

			$tmp = ceil( $tmp / $li_limit );

			$li_curarea = (int) $tmp;

			if  ( $li_curarea == 0 ) $li_curarea = 1;

// ---- End   ------ ���� Group�� ��� ----------------------------------------- //
			$tmpTot = $li_Totcount - $li_HowMany;

			$spage =  ( $li_limit * ( $li_curarea - 1 ) ) + 1; // ���� �� ��ġ

			if ( ( $li_limit * $li_curarea ) >= $li_totpage ) {
				$epage = $li_totpage				; // ���� �� ��ġ
			} else {
				$epage = ( $li_limit * $li_curarea ); // ���� �� ��ġ
			}

/* ���� ������, ������ ������... */
			$last_stat   = ( ( $li_MoreMany * ( $li_totpage - 1 ) ) + 1 );
			$last_stat  += $li_interval;
			if ( $page_tab['page_start_first'] && $spage > 1 ) {
				$first_tab  = $page_tab['page_start_first'] . "<a href='#' onclick='" . jsFuncName() . "(" . 1			. "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". '1' . "</a>" . $page_tab['page_end_first'];
			}
			if ( $page_tab['page_start_last'] && $epage != $li_totpage ) {
				$last_tab   = $page_tab['page_start_last' ] . "<a href='#' onclick='" . jsFuncName() . "(" . $last_stat  . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $li_totpage . "</a>". $page_tab['page_end_last'];
			}

// ---- Start ------ �� ���� �� �� Tab ----------------------------------------- //
			if ( $spage - 1 < 1)		 {
				$_rtn .= $page_tab['pre'];
			} else					  {
				$Tstart  = ( ( $li_MoreMany * ( $spage - $li_limit - 1 ) ) + 1 );
				$Tstart += $li_interval;
				if  ( $li_curarea == 2 ) {
//					  out.print("<a href='" + $P_target + "?$P_start=1'>�� ����&nbsp;</a>");
						$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(1," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['pre'] ."</a>";
//					  out.print("<a href='#' onclick='pageTab(1," + $P_Totcount + ",\"" + $P_target + "\");return false;'>�� &nbsp;</a>");
				} else {
//					  out.print("<a href='" + $P_target + "?$P_start=" + $Tstart + "'>�� ����&nbsp;</a>");
						$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['pre'] ."</a>";
//					  out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>�� &nbsp;</a>");
				}
			}
// ---- End   ------ �� ���� �� �� Tab ----------------------------------------- //

		 $_rtn .= $first_tab;

		 $_rtn .= " ";
// ---- Start ------ �� �� Tab �� �̵� ----------------------------------------- //
			// <!-- ������ʹ� ������������ ������������ �ѳ�������ؼ�................... -->
			if ( $li_curpage > 1 ) {
				$Tstart = ( ( $li_MoreMany * ( $li_curpage - 2 ) ) + 1 );
				$Tstart += $li_interval;
				if  ( $li_curarea == 1 ) {
					if ( $li_curpage == 2 ) {
						$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(1," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['pre_1'] ."</a>";
//					  out.print("<a href='#' onclick='pageTab(1," + $P_Totcount + ",\"" + $P_target + "\");return false;'>��&nbsp;</a>");
					} else {
						$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['pre_1'] ."</a>";
//					  out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>��&nbsp;</a>");
					}
				} else {
					$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['pre_1'] ."</a>";
//				  out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>��&nbsp;</a>");
				}
			}
			else {
				$_rtn .= $page_tab['pre_1'];
//			  out.print("��&nbsp;");
			}
// ---- End   ------ �� �� Tab �� �̵� ---------------------------------------- //
		 $_rtn .= " ";
// ---- Start ------ -------------- ------------------------------------------- //
// ù��° Group�� ù��° ���� ���
// ���� ����ġ�� 1��ŭ ���� ��Ű��
// ȭ��󿡴� ������ 1�� ��� ��ŵ�ϴ�.
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

// ---- Start ------ ���� Display Tab ----------------------------------------- //
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
// ---- End   ------ ���� Display Tab ----------------------------------------- //
			$_rtn .= $page_tab['page_sep'];
			$_rtn .= " ";
// ---- Start ------ �� �� Tab �� �̵� ---------------------------------------- //
			if ( $li_totpage > $li_curpage ) {
				$Tstart = ( ( $li_MoreMany * $li_curpage ) + 1);
				$Tstart += $li_interval;
				$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['next_1'] ."</a>";
//			  out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>&nbsp;��</a>");
			}
			else{
				$_rtn .= $page_tab['next_1'];
//					 out.print("&nbsp;��");
			}
// ---- End   ------ �� �� Tab �� �̵� ---------------------------------------- //
		 $_rtn .= " ";
		 $_rtn .= $last_tab;
// ---- Start ------ �� ���� �� �� Tab ---------------------------------------- //
// echo 'epage	  : ' . $epage		. '<BR>';
			if ( $epage == $li_totpage ) {
//			  out.print("[���� " + $li_limit + " ��]&nbsp;");
				$_rtn .= $page_tab['next'];
//			  out.print("&nbsp;��");
			}
			else {
				$Tstart  = ( ( $li_MoreMany * ( $epage + 1 - 1 ) ) + 1 );
				$Tstart += $li_interval;
//					 out.print("<a href='" + $P_target + "?$P_start=" + $Tstart + "'>����&nbsp;��</a>");
				$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $page_tab['next'] ."</a>";
//			  out.print("<a href='#' onclick='pageTab(" + $Tstart + "," + $P_Totcount + ",\"" + $P_target + "\");return false;'>&nbsp;��</a>");
			}
// ---- End   ------ �� ���� �� �� Tab ---------------------------------------- //
		}
	if ( !$_rtn ) $_rtn = '&nbsp;';
	return $_rtn;
}

function _prevPageTab ( $P_start , $P_Totcount, $P_HowMany, $P_MoreMany, $P_PageMany, $P_target, $pre_tag='' ) {
	$_rtn = "";
	$curpage	 = 0; // ���� ��ġ
	$li_curpage  = 0; // ���� ���� ��ġ
	$li_HowMany  = 0; // ù��° ��	  ���� ȭ�鿡 ������ �ڷ��� ����
	$li_MoreMany = 0; // �ι�° �� ���� ���� ȭ�鿡 ������ �ڷ��� ����
	$li_Totcount = 0; // �� ��ȸ��
	$li_totpage  = 0; // �� ���� ����
	$li_limit	= $P_PageMany;
	$li_interval = 0;

	$li_HowMany  = $P_HowMany ;
	$li_Totcount = $P_Totcount;

	if ( $li_Totcount > $P_HowMany && $P_HowMany != 0 ) {

		if ( $P_MoreMany != 0 )   {   // ù �������� ������ �ڷ��
			$li_MoreMany = $P_MoreMany;
		} else					{   // ù ������ Default Set
			$li_MoreMany = 10;
		}

		$li_Totcount = $li_Totcount - $li_HowMany + $li_MoreMany;

		$li_interval = $li_HowMany - $li_MoreMany;

// ---- Start ------ �� �������� ���� ------------------------------------------ //

		if( $P_start == 1 )	  {   // ������ġ Default Set
			$li_curpage=1;
		} else				  {   // ���� ��ġ ����
			$curpage   = $P_start - $li_interval;   // ���� ��ġ
			$li_curpage = ( ( $curpage - 1 ) / $li_MoreMany ) + 1;  // ���� ���� ��ġ
		}

// ---- End   ------ �� �������� ���� ------------------------------------------ /
		$Tstart  = 0;
// ---- Start ------ ���� Group�� ��� ----------------------------------------- //
		$tmp	 = $li_curpage;

		$tmp = ceil( $tmp / $li_limit );

		$li_curarea = (int) $tmp;

		if  ( $li_curarea == 0 ) $li_curarea = 1;

// ---- End   ------ ���� Group�� ��� ----------------------------------------- //

// ---- Start ------ �� �� Tab �� �̵� ----------------------------------------- //
		// <!-- ������ʹ� ������������ ������������ �ѳ�������ؼ�................... -->
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
// ---- End   ------ �� �� Tab �� �̵� ---------------------------------------- //
	}
	return $_rtn;
}

function _nextPageTab ( $P_start , $P_Totcount, $P_HowMany, $P_MoreMany, $P_PageMany, $P_target, $next_tag='' ) {
	$_rtn = "";
	$curpage	 = 0;	// ���� ��ġ
	$li_curpage  = 0;	// ���� ���� ��ġ
	$li_HowMany  = 0;	// ù��° ��	  ���� ȭ�鿡 ������ �ڷ��� ����
	$li_MoreMany = 0;	// �ι�° �� ���� ���� ȭ�鿡 ������ �ڷ��� ����
	$li_Totcount = 0;	// �� ��ȸ��
	$li_totpage  = 0;	// �� ���� ����
	$li_limit	= $P_PageMany;
	$li_interval = 0;

	$li_HowMany  = $P_HowMany ;
	$li_Totcount = $P_Totcount;

	if ( $li_Totcount > $P_HowMany && $P_HowMany != 0 ) {

		if ( $P_MoreMany != 0 )   {   // ù �������� ������ �ڷ��
			$li_MoreMany = $P_MoreMany;
		} else					{   // ù ������ Default Set
			$li_MoreMany = 10;
		}

		$li_Totcount = $li_Totcount - $li_HowMany + $li_MoreMany;

		$li_interval = $li_HowMany - $li_MoreMany;

// ---- Start ------ �� �������� ���� ------------------------------------------ //
		if( $P_start == 1 )	  {   // ������ġ Default Set
			$li_curpage=1;
		} else				  {   // ���� ��ġ ����
			$curpage   = $P_start - $li_interval;   // ���� ��ġ
			$li_curpage = ( ( $curpage - 1 ) / $li_MoreMany ) + 1;  // ���� ���� ��ġ
		}

		$li_totpage = floor ( $li_Totcount / $li_MoreMany );
		// ���̼��߿� ������ ���ڵ���� ����ϱ�����  ���������� ���������� ����
		if ( $li_totpage * $li_MoreMany < $li_Totcount ) {		  // �� ���� ����
			$li_totpage = $li_totpage + 1;
		}
// ---- End   ------ �� �������� ���� ------------------------------------------ /

		$Tstart  = 0;
// ---- Start ------ �� �� Tab �� �̵� ---------------------------------------- //
			if ( $li_totpage > $li_curpage ) {
				$Tstart = ( ( $li_MoreMany * $li_curpage ) + 1);
				$Tstart += $li_interval;
				$_rtn .= "<a href='#' onclick='" . jsFuncName() . "(" . $Tstart . "," . $P_Totcount . ",\"" . $P_target . "\");return false;'>". $next_tag ."";
			}
			else{
				$_rtn .= "<a>" . $next_tag;
//					 out.print("&nbsp;��");
			}
// ---- End ------ �� �� Tab �� �̵� ---------------------------------------- //
	}
	return $_rtn;
}
?>