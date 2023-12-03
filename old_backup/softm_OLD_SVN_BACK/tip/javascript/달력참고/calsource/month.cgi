#!/usr/local/bin/perl
$input=$ENV{'QUERY_STRING'};
print "Content-type: text/html\n\n";
require "./datetime.pl";

($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime();

$year='19'.$year;
$month=$mon+1;

$i=index $input,"&";
$st1=substr $input,0,$i;
$st2=substr $input,$i+1;

$i=index $st1,"=";
$inputyear=substr $st1,$i+1;

$i=index $st2,"=";
$inputmonth=substr $st2,$i+1;


if ($input ne "") {
  if (($inputyear<2299) && ($inputyear>-2086) && ($inputmonth>0) && ($inputmonth<13)) {
    $year=$inputyear;
    $month=$inputmonth;
  }
  else
  {
    if ($inputyear<-2085){
      $year=-2085;
      $month=1;
    }
    if ($inputyear>2298){
      $year=2298;
      $month=12;   
    }
  }
}

print " <META name=\"description\" content=\"This Calenar is made by Korean Language, There are solor calendar, moon calendar, solor\n";
print "    eclipse, lunar eclipse, 24 Jul-Gi(=season divide), 28 Su(=daily stars latitude), 60 Gan-Ji, full moon and conjunction time from -2085 year to 2298 year.  \">\n";
print " <META name=\"keywords\" content=\"Korean Calendar conjunction eclipse solor lunar\">\n";
print " <META name=\"title\" content=\"Korean Calendar\">\n ";


print "<HTML>\n<HEAD><TITLE>��¥������ 0.92 ������ - $year�� $month�� </TITLE></HEAD>\n";

print "<BODY><br>\n";

$pyear=$year;
$pmonth=$month-1;
if ($pmonth==0) {
  $pmonth=12;
  $pyear=$pyear-1;
  if ($pyear==-2086) {
    $pyear=-2085;
    $pmonth=1;
  }
}
$nyear=$year;
$nmonth=$month+1;
if ($nmonth==13) {
  $nmonth=1;
  $nyear=$nyear+1;
  if ($nyear=2299) {
    $nyear=2298;
    $nmonth=12;
  }
}

print "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
print "<a href=month.cgi?year=$pyear&month=$pmonth>$pyear��$pmonth��</a>";
print "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
print "<font size=7>$year�� $month��</font>\n";
print "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
print "<a href=month.cgi?year=$nyear&month=$nmonth>$nyear��$nmonth��</a>";
print "<p>";


$fday=&getweekday($year,$month,1);
$s28dayvalue=&get28sday($year,$month,1);

$nextyear=$year;
$nextmonth=$month+1;
if ($nextmonth==13) { 
  $nextmonth=1;
  $nextyear=$nextyear+1;
}

$monthdayvalue=&disp2days($nextyear,$nextmonth,1,$year,$month,1);


($lyear,$lmonth,$lday,$lmoonyun,$largemonth)=&solortolunar($year,$month,1);

($y1,$mo1,$d1,$h1,$mi1,
 $ym,$mom,$dm,$hm,$mim,
 $y2,$mo2,$d2,$h2,$mi2)=&getlunarfirst($year,$month,1);

($so24,$so24year,$so24month,$so24day,$so24hour)=&sydtoso24yd($year,$month,1,1,0);

($inginame,$ingiyear,$imgimonth,$ingiday,$ingihour,$ingimin,
$midname,$midyear,$midmonth,$midday,$midhour,$midmin,
$outginame,$outgiyear,$outgimonth,$outgiday,$outgihour,$outgimin)=&solortoso24($year,$month,20,1,0);

$julgiandmoonmonth="�̹��� ���� : $monthst[$inginame] $ingiyear�� $imgimonth�� $ingiday�� $ingihour�� $ingimin�� <br>\n";
$julgiandmoonmonth.="�̹��� �߱� : $monthst[$midname] $midyear�� $midmonth�� $midday�� $midhour�� $midmin��<br>\n";
$julgiandmoonmonth.="������ ���� : $monthst[$outginame] $outgiyear�� $outgimonth�� $outgiday�� $outgihour�� $outgimin��<p>\n";
$julgiandmoonmonth.="�ջ� : $y1�� $mo1�� $d1�� $h1�� $mi1�� ";
$julgiandmoonmonth.="<br>\n";
$julgiandmoonmonth.="&nbsp �� : $ym�� $mom�� $dm�� $hm�� $mim�� ";

$julgiandmoonmonth.="<br>\n";

$tempweek=0;
$sday=-1;
for($i=0;$i<42;$i++){
  #��³�¥
  if ($i==$fday) { 
    $tempweek=1;
    $sday=1;
  };
  if ($tempweek==1) {

    $st="size=6 ";
    if (($i==0) || ($i==7) ||($i==14) || ($i==21) || ($i==28) || ($i==35)) {
      $st.="color=red";
    }

    if ($s28dayvalue==0) {
      $boxsday[$i]="<font color=Green>".$s28day[$s28dayvalue]."</font>";
    }
    else
    {
      $boxsday[$i]=$s28day[$s28dayvalue];
    };
    $boxsday[$i].="<font ".$st.">";
    if ($sday<10){
      $boxsday[$i].="&nbsp&nbsp ".$sday."</font>";
      $box[$i]=$sday;
    }
    else
    {
      $boxsday[$i].="&nbsp ".$sday."</font>";
      $box[$i]=$sday;
    }

	$s28dayvalue++;
    if ($s28dayvalue==28) { $s28dayvalue=0;}
  }
  else
  {
    $boxsday[$i]="0";
    $box[$i]=0;
  };

  #���³�¥
  if (($sday)==$d2) {
    ($lyear,$lmonth,$lday,$lmoonyun,$largemonth)=&solortolunar($year,$month,$sday);    
    ($y1,$mo1,$d1,$h1,$mi1,
     $ym,$mom,$dm,$hm,$mim,
     $y2,$mo2,$d2,$h2,$mi2)=&getlunarfirst($year,$month,$sday);

     $julgiandmoonmonth.="�ջ� : $y1�� $mo1�� $d1�� $h1�� $mi1�� ";
     $julgiandmoonmonth.="<br>\n";
     $julgiandmoonmonth.="&nbsp �� : $ym�� $mom�� $dm�� $hm�� $mim�� ";
     $julgiandmoonmonth.="<br>\n";

  }

  if ($boxsday[$i] ne "0") {

    if (($lday==1) || ($sday==1)) {
      if ($lmoonyun==1) { 
        $boxlday[$i]="<font color=blue>��".$lmonth.".".$lday."</font>"; 
      }
      else { $boxlday[$i]="<font color=blue>".$lmonth.".".$lday."</font>"; };


    }
    else
    { $boxlday[$i]=$lday; };

    if ($sday==$dm) { 
      $boxlday[$i].='<font color=blue> ��'; 
      $boxlday[$i].="</font>";
    }

    $lday++;
    $sday++;
  }

  #����
  if ($tempweek==1) {
    if ($so24day==0) {
      $boxs60day[$i]="<font color=green>".$ganji[$so24day]."</font>";
    }
    else
    {
      $boxs60day[$i]=$ganji[$so24day];
    }
    $so24day++;
    if ($so24day>59) { $so24day=$so24day-60; }
  }

  #����
  if ($ingiday==($sday-1)) { 
    $boxs60day[$i].=" <font color=#E81AD8>".$monthst[$inginame]."</font>";
  };
  if ($midday==($sday-1)) { 
    $boxs60day[$i].=" <font color=#E81AD8>".$monthst[$midname]."</font>";
  };

  if (($sday-1)==$monthdayvalue) {
    $tempweek=0;
    $sday=-1;
  }
 
}; #//for

print "<table border=1>\n";
for($i=0;$i<42;$i++){
  if ($i==0) {
    print "<tr>";
    for ($j=0;$j<7;$j++){
      print "<td align=center>$weekday[$j]</td>";
    }
    print "</tr>\n";
  }
  if (($i==0) || ($i==7) ||($i==14) || ($i==21) || ($i==28) || ($i==35)) {
    if ($i != 0 ) { print "</tr>\n"; }
    print "<tr> ";    
  }
  print "<td>";

  # ��� ����
  if ($boxsday[$i] ne "0"){
    print "$boxsday[$i]";
  }
  else
  {
    print "&nbsp";
  };
  print "<br>";

  # ���� ����
  if ($boxsday[$i] ne "0"){
    print "$boxlday[$i]";
  }
  else
  {
    print "&nbsp";
  };
  print "<br>";

  # ���� ����
  if ($boxsday[$i] ne "0"){
    print "$boxs60day[$i]";
  }
  else
  {
    print "&nbsp";
  };

  print "</td>  ";

  if ($i==34) {
    if ($box[35]==0) {      
      $i=41; 
    }
  }
}
print "</tr>\n</table><p>\n";
print "�� �޷��� <a href=\"http://user.chollian.net/~kohyc/calendar/\">��â�� Ȩ������</a>���� �����°��Դϴ�<br>\n";
print "<p>\n";

print "$julgiandmoonmonth<p>\n";

print "<form action=month.cgi method=GET>\n";
print "  <input type=text Name=year size=6 value=$year>��\n";
print "  <input type=text Name=month size=3 value=$month>��\n";
print "  <input type=SUBMIT value=����>\n";
print "<br>��ȿ�Ⱓ -2085~2298��\n";
print "</form>\n";
print "<p>\n ";

print "</BODY>\n";
	
	
	
	
	
	
	
	
	
