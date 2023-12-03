#!/usr/bin/perl -U
##########################################################################3
#	제작자 : 가는세월
#	디자인 : 보보
#	제작자 이메일 : cheng6527@yahoo.co.kr
#	수정 및 재배포는 자유입니다 단 수정후 재배포는 위 메일로 연락 주세요
#	


&parse;
&get_time;

$This_file_name	= 'Time_diary.cgi';		# 이화일의 cgi 이름
$select_y_start		= '2000';			# 셀렉션 시작연도
$select_y_end		= '2020';			# 셀렉션 마지막연도




if($FORM{'CMD'} eq 'search_diary'){&calendar($FORM{'ym_select'},$FORM{'select_y'},$FORM{'select_m'});}
else{&calendar;}
exit;




sub calendar{
local($ym_select,$select_y,$select_m)=@_;
if($ym_select){
	if($ym_select eq 'pri_year'){$year=$select_y-1;$month=$select_m;}
	elsif($ym_select eq 'post_year'){$year=$select_y+1;$month=$select_m;}
	elsif($ym_select eq 'pri_mon'){$year=$select_y;$month=$select_m-1;if($month eq 0){$month = 12;$year = $select_y- 1;}}
	elsif($ym_select eq 'post_mon'){$year=$select_y;$month=$select_m+1;if($month eq 13){$month = 1;$year = $select_y+ 1;}}
	elsif($ym_select eq 'select_my'){$year=$select_y;$month=$select_m;}
}

&diary_days_make;
&html_head;

print <<HTML;
<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="250" BGCOLOR="#999999" ALIGN="center">
<TR>
	<TD WIDTH="10"></TD>
	<TD>
	<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
	<TR>
		<TD WIDTH="100%">
<!--------------------------- 상단 이미지 ------------------------>
		<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
		<TR>
			<TD WIDTH="19">
				<P><IMG SRC="spring.gif" WIDTH="19" HEIGHT="5" BORDER="0" ALIGN="absmiddle" VSPACE="0" HSPACE="0"></P>
			</TD>
			<TD ALIGN="center">
				<P><IMG SRC="spring.gif" WIDTH="19" HEIGHT="5" BORDER="0" ALIGN="absmiddle" VSPACE="0" HSPACE="0"></P>
			</TD>
			<TD WIDTH="19">
				<P><IMG SRC="spring.gif" WIDTH="19" HEIGHT="5" BORDER="0" ALIGN="absmiddle" VSPACE="0" HSPACE="0"></P>
			</TD>
		</TR>
		</TABLE>
<!--------------------------- // 상단 이미지 ------------------------>
		</TD>
	</TR>
	<TR>
		<TD WIDTH="100%" HEIGHT="40" ALIGN="center">
		<FORM NAME="form_calendar" method="get" ENCTYPE="multipart/form-data" ACTION="$This_file_name" STYLE="margin:0; padding:0; border-width:0; border-style:none;">
		<INPUT TYPE="hidden" NAME="CMD" VALUE="search_diary">
HTML
		print "<A HREF=\"$This_file_name?CMD=search_diary&ym_select=pri_year&select_y=$year&select_m=$month\"><span style=font-size:10pt;><img SRC='./p_year.gif' ALIGN='absmiddle' BORDER='0' VSPACE='0' HSPACE='0' STYLE='margin-top:0;'></span></A>\n";
		print "<A HREF=\"$This_file_name?CMD=search_diary&ym_select=pri_mon&select_y=$year&select_m=$month\"><span style=font-size:10pt;><img SRC='./p_mon.gif' ALIGN='absmiddle' BORDER='0' VSPACE='0' HSPACE='0' STYLE='margin-top:0;'></span></A>&nbsp;\n";
		print "&nbsp; <A HREF=\"$This_file_name?CMD=search_diary&ym_select=post_mon&select_y=$year&select_m=$month\"><span style=font-size:10pt;><img SRC='./n_mon.gif' ALIGN='absmiddle' BORDER='0' VSPACE='0' HSPACE='0' STYLE='margin-top:0;'></span></A>\n";
		print "<A HREF=\"$This_file_name?CMD=search_diary&ym_select=post_year&select_y=$year&select_m=$month\"><span style=font-size:10pt;><img SRC='./n_year.gif' ALIGN='absmiddle' BORDER='0' VSPACE='0' HSPACE='0' STYLE='margin-top:0;'></span></A>\n";
		print "<SPAN STYLE=\"font-size:9pt; color:#ffffff;\"><B>$year년&nbsp;$month월</B></SPAN>\n";
print <<HTML;
		</FORM>
		</TD>
	</TR>
	<TR>
		<TD WIDTH="100%" ALIGN="center">
		<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="100%" BGCOLOR="#ffffff">
HTML

for(1..7){
	print "<TR>\n\n" if($_ eq 1);
	if($_ eq 1){$font_color = 'red';}elsif($_ eq 7){$font_color = 'blue';}else{$font_color = 'black';}

	print "<TD HEIGHT='25' ALIGN='center' VALIGN='middle'>\n";
	print "<span style='font-size:10pt;'><FONT COLOR='$font_color'>$weekline[$_ - 1]</FONT></span>\n";
	print "</TD>\n";

	print "</TR>\n\n" if($_ eq 7);
}

$var_mon_year = (($M_mon_t[$month] + $Y_year_t[$year_t])%7);
$div_days = (42 - ($M_days[$month] + $var_mon_year));

for(0..$var_mon_year){@D_weeky = (@D_weeky,'');}for(1..$M_days[$month]){@D_weeky = (@D_weeky,$_);}for(1..$div_days){@D_weeky = (@D_weeky,'');}
if($D_weeky[29] eq ''){$end_days=28;}elsif($D_weeky[36] eq ''){$end_days=35;}else{$end_days=42;}

$weeky_i = 1;
for(1..$end_days){
	$D_weeky[$_]=sprintf( "%02s", $D_weeky[$_]);
	print "<TR>\n" if($weeky_i eq 1);
	if($weeky_i eq 1){$font_color = 'red';}elsif($weeky_i eq 7){$font_color = 'blue';}else{$font_color = 'black';}

	if(($pr_year eq $year) && ($pr_month eq $month) && ($D_weeky[$_] eq $t_mday)){$td_bgcolor = 'red'; $font_color = '#ffffff';}
	else{$td_bgcolor = '#ffcc00';}

	print "<TD HEIGHT='25' BGCOLOR='$td_bgcolor' ALIGN='center' VALIGN='middle'>\n";
	print "<span style='font-size:10pt;'><FONT COLOR='$font_color'>$D_weeky[$_]</FONT></span>\n" if($D_weeky[$_] ne '00');
	print "</TD>\n";

	print "</TR>\n\n" if($weeky_i eq 7);
	$weeky_i = $weeky_i + 1;
	if($weeky_i gt 7){$weeky_i = 1;}
}
print "</TABLE>\n\n";

print <<HTML;
		</TD>
	</TR>
            <TR>
	<FORM NAME="form_calendar" method="get" ENCTYPE="multipart/form-data" ACTION="$This_file_name" STYLE="margin:0; padding:0; border-width:0; border-style:none;">
	<INPUT TYPE="hidden" NAME="CMD" VALUE="search_diary">
	<INPUT TYPE="hidden" NAME="ym_select" VALUE="select_my">
		<TD WIDTH="100%" HEIGHT="40" ALIGN="center">
HTML
			print "<SELECT NAME='select_y' size='1'>";
			$select_year{$year}="selected";
			for($select_y_start..$select_y_end){print "<option value=\"$_\" $select_year{$_}>$_</option>";}
			print "</select> <select name='select_m' size=1>";
			$select_mon{$month}="selected";
			for(1..12){print "<option value=\"$_\" $select_mon{$_}>$_</option>";}
			print "</select> <input type='image' SRC='./button.gif' ALIGN='absmiddle' BORDER='0' VSPACE='0' HSPACE='0' STYLE='margin-top:1;'> ";
			print "<A HREF=\"$This_file_name?CMD=search_diary&ym_select=select_my&select_y=$pr_year&select_m=$pr_month\"><span style=font-size:10pt;><img SRC='./today.gif' ALIGN='absmiddle' BORDER='0' VSPACE='0' HSPACE='0' STYLE='margin-top:1;'></span></A>&nbsp; \n";
			print "<A HREF=\"http://www.sourceclub.net\" target='_blank'><span style=font-size:10pt;><img SRC='./home.gif' ALIGN='absmiddle' BORDER='0' VSPACE='0' HSPACE='0' STYLE='margin-top:1;'></span></A>&nbsp; \n";
print <<HTML;
		</TD>
	</FORM>
	</TR>
	</TABLE>
	</TD>
	<TD WIDTH="10"></TD>
</TR>
</TABLE>
HTML

&html_end;
}


sub diary_days_make{
local($v_1,$v_2,$v_3);
@M_days=('',31,28,31,30,31,30,31,31,30,31,30,31);
$v_1=($year % 400);$v_2=($year % 100);$v_3=($year % 4);
if(($v_1 eq 0) || (($v_2 ne 0) && ($v_3 eq 0))){$M_days[2]=29;}

@M_mon_t=('',1,4,4,0,2,5,0,3,6,1,4,6);@Y_year_t=(4,6,0,1,2,4,5,6,0,2,3,4,5,0,1,2,3,5,6,0,1,3,4,5,6,1,2,3);
$year_t=(($year%28));if((($v_1 eq 0) || ($v_2 ne 0) && ($v_3 eq 0)) && ($month gt 2)){$Y_year_t[$year_t] = $Y_year_t[$year_t] + 1;}
}


sub get_time{
($t_sec,$t_min,$t_hour,$t_mday,$t_mon,$t_year,$t_wday,$t_yday,$t_isdst) = localtime(time);
$month=($t_mon+1);@weekline=('일','월','화','수','목','금','토');
$year = $t_year+1900;
$weekis=$weekline[$t_wday];
$pr_month=$month;$pr_year=$year;

$month=sprintf( "%02s", $month);$t_mday=sprintf( "%02s", $t_mday);
$WRhour=sprintf( "%02s", $t_hour);$WRmin=sprintf( "%02s", $t_min);

$readdate="$year/$month/$t_mday";
$writedate="$year/$month/$t_mday/$WRhour/$WRmin";
}


sub html_head{
local($title) = @_;
print "Content-type: text/html\n\n";
print <<END;
<HTML>
<HEAD>
<TITLE>Goingtime & Blue의 만능달력</TITLE>
<META HTTP-EQUIV='Content-Type' CONTENT='text/html'; CHARSET='euc-kr'>
<META HTTP-EQUIV='Cache-Control' CONTENT='no-cache'>
<META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
$Refresh $Htm_in_head
</HEAD>
<STYLE>
BODY,TR,TD{font-size:8pt;font-family:돋움,Tahoma,굴림,굴림체,Verdana,MS Sans Serif,Courier New;}
input,select{font-size:8pt; font-family:돋움,Tahoma,굴림;}A:link {text-decoration:none}
A:visited {text-decoration:none}
A:hover {text-decoration: underline; color: red;}
</STYLE>
<BODY $bgcolor TEXT="#ffcc00" link="#ffcc00" vlink="#ffcc00" alink="red" TOPMARGIN="0" LEFTMARGIN="0">
END
}
sub html_end{print "</BODY>\n</HTML>\n";}


sub parse{
$_ = $ENV{'REQUEST_METHOD'};
if (/POST/) {
	read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	$ENV{'QUERY_STRING'} = $buffer;
}
else {$buffer = $ENV{'QUERY_STRING'};}
@pairs = split(/&/, $buffer);

foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$FORM{$name} = $value;
}
}
1;