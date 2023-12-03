@montharray = (0,21355,42843,64498,86335,108366,130578,152958,
                        175471,198077,220728,243370,265955,288432,310767,332928,
                        354903,376685,398290,419736,441060,462295,483493,504693,525949);

@monthst = ("ÀÔÃá","¿ì¼ö","°æÄ¨","ÃáºĞ","Ã»¸í","°î¿ì",
            "ÀÔÇÏ","¼Ò¸¸","¸ÁÁ¾","ÇÏÁö","¼Ò¼­","´ë¼­",
            "ÀÔÃß","Ã³¼­","¹é·Î","ÃßºĞ","ÇÑ·Î","»ó°­",
            "ÀÔµ¿","¼Ò¼³","´ë¼³","µ¿Áö","¼ÒÇÑ","´ëÇÑ","ÀÔÃá");

@gan = ("Ë£","ëà","Ü°","ïË","Ùæ","Ğù","ÌÒ","ãô","ìó","Í¤");
@ji =  ("í­","õä","ìÙ","ÙÖ","òã","ŞÓ","çí","Ú±","ãé","ë·","âù","ú¤");

@ganji =  ('Ë£í­','ëàõä','Ü°ìÙ','ïËÙÖ','Ùæòã','ĞùŞÓ','ÌÒçí','ãôÚ±','ìóãé','Í¤ë·','Ë£âù','ëàú¤',
           'Ü°í­','ïËõä','ÙæìÙ','ĞùÙÖ','ÌÒòã','ãôŞÓ','ìóçí','Í¤Ú±','Ë£ãé','ëàë·','Ü°âù','ïËú¤',
           'Ùæí­','Ğùõä','ÌÒìÙ','ãôÙÖ','ìóòã','Í¤ŞÓ','Ë£çí','ëàÚ±','Ü°ãé','ïËë·','Ùæâù','Ğùú¤',
           'ÌÒí­','ãôõä','ìóìÙ','Í¤ÙÖ','Ë£òã','ëàŞÓ','Ü°çí','ïËÚ±','Ùæãé','Ğùë·','ÌÒâù','ãôú¤',
           'ìóí­','Í¤õä','Ë£ìÙ','ëàÙÖ','Ü°òã','ïËŞÓ','Ùæçí','ĞùÚ±','ÌÒãé','ãôë·','ìóâù','Í¤ú¤');

@weekday = ('ÀÏ¿äÀÏ','¿ù¿äÀÏ','È­¿äÀÏ','¼ö¿äÀÏ','¸ñ¿äÀÏ','±İ¿äÀÏ','Åä¿äÀÏ');

@s28day =  ('ÊÇ','ùñ','Àú','Û®','ãı','Ú­','Ñ¹',
                    'Ôà','éÚ','åü','úÈ','êË','ãø','Ûú',
                    'Ğ¥','´©','êÖ','ÙÛ','ù´','ÀÚ','ß³',
                    'ïÌ','Ğ¡','ê÷','àø','íå','ìÏ','Áø');

$unityear=1996;$unitmonth=2;$unitday=4;$unithour=22;$unitmin=8;$unitsec=0;  #ÀÔÃá

$uygan=2;$uyji=0;$uysu=12; #º´ÀÚ³â
$umgan=6;$umji=2;$umsu=26; #°æÀÎ¿ù
$udgan=7;$udji=7;$udsu=7; #½Å¹ÌÀÏ
$uhgan=5;$uhji=11;$uhsu=35; #±âÇØ½Ã

$unitmyear  =1996;  # Á¤¿ùÃÊÇÏ·ç ÇÕ»è½Ã°£
$unitmmonth =2;
$unitmday =19;
$unitmhour =8;
$unitmmin =30;
$unitmsec =0;
$moonlength = 42524 ;


#1¿ù 1ÀÏºÎÅÍ ÇØ´ç ÀÏÂ¥±îÁöÀÇ ³¯Â¥¼ö : ¹İÈ¯°ª-³¯Â¥
sub disptimeday {
  my($year,$month,$day)=@_ ;
  my($e,$i)=0;
  $e=0;
  for ($i=1;$i<$month;$i++) 
  {
    $e = $e + 31;
    if ( $i==2 || $i==4 || $i==6 || $i==9 || $i==11) { $e-- };
    if ( $i==2 ) 
    {
      $e = $e - 2 ;
      if ( $year % 4 == 0 ) { $e++ } ;
      if ( $year % 100 == 0 ) { $e-- } ;
      if ( $year % 400 == 0 ) { $e++ } ;
      if ( $year % 4000 == 0 ) { $e-- } ;
    };
  };
  $e = $e + $day ;
  return($e);
}


# {y1,m1,d1ÀÏºÎÅÍ y2,m2,d2±îÁöÀÇ ÀÏ¼ö °è»ê } ¹İÈ¯°ª-³¯Â¥
sub disp2days {
my($y1,$m1,$d1,$y2,$m2,$d2) = @_ ;
my($p2,$p1,$p1n,$pp1,$pp2,$pr,$dis,$ppp1,$ppp2,$k)=0;

  if ( $y2 > $y1 ) 
  {
    $p2 = &disptimeday($y2,$m2,$d2);
    $p1 = &disptimeday($y1,$m1,$d1);
    $p1n = &disptimeday($y1,12,31);
    $pp1 = $y1 ; $pp2 = $y2 ;
    $pr = -1 ;
  } 
  else 
  {
    $p1 = &disptimeday($y2,$m2,$d2);
    $p1n = &disptimeday($y2,12,31);
    $p2 = &disptimeday($y1,$m1,$d1);
    $pp1 = $y2 ; $pp2 = $y1;
    $pr = 1 ;
  };

  if ($y2 == $y1) 
  { $dis = $p2 - $p1; } 
  else
  {
    $dis = $p1n - $p1 ;
    $ppp1 = $pp1 + 1 ;
    $ppp2 = $pp2 - 1 ;
    for ($k = $ppp1; $k <= $ppp2 ; $k++ ) 
    {
      if (($k==-2000) && ($ppp2>1990))
      {
        $dis=$dis+1457682;
        $k=1991;
      }
      if (($k==-1750) && ($ppp2>1990))
      {
        $dis=$dis+1366371;
        $k=1991;
      }
      if (($k==-1500) && ($ppp2>1990))
      {
        $dis=$dis+1275060;
        $k=1991;
      }
      if (($k==-1250) && ($ppp2>1990))
      {
        $dis=$dis+1183750;
        $k=1991;
      }
      if (($k==-1000) && ($ppp2>1990))
      {
        $dis=$dis+1092439;
        $k=1991;
      }
      if (($k==-750) && ($ppp2>1990))
      {
        $dis=$dis+1001128;
        $k=1991;
      }
      if (($k==-500) && ($ppp2>1990))
      {
        $dis=$dis+909818;
        $k=1991;
      }
      if (($k==-250) && ($ppp2>1990))
      {
        $dis=$dis+818507;
        $k=1991;
      }
      if (($k==0) && ($ppp2>1990))
      {
        $dis=$dis+727197;
        $k=1991;
      }
      if (($k==250) && ($ppp2>1990))
      {
        $dis=$dis+635887;
        $k=1991;
      }
      if (($k==500) && ($ppp2>1990))
      {
        $dis=$dis+544576;
        $k=1991;
      }
      if (($k==750) && ($ppp2>1990))
      {
        $dis=$dis+453266;
        $k=1991;
      }
      if (($k==1000) && ($ppp2>1990))
      {
        $dis=$dis+361955;
        $k=1991;
      }
      if (($k==1250) && ($ppp2>1990))
      {
        $dis=$dis+270644;
        $k=1991;
      }
      if (($k==1500) && ($ppp2>1990))
      {
        $dis=$dis+179334;
        $k=1991;
      }
      if (($k==1750) && ($ppp2>1990))
      {
        $dis=$dis+88023;
        $k=1991;
      }

      $dis = $dis + &disptimeday($k,12,31);
    };
    $dis = $dis + $p2 ;
    $dis = $dis * $pr ;
  };
   return($dis);
};

#  {Æ¯Á¡½ÃÁ¡¿¡¼­ Æ¯Á¤½ÃÁ¡±îÁöÀÇ ºĞ }
sub getminbytime 
{
  my($uy,$umm,$ud,$uh,$umin,$y1,$mo1,$d1,$h1,$mm1) = @_ ;
  my($t)=0;
  $dispday = &disp2days($uy,$umm,$ud,$y1,$mo1,$d1);
  $t = $dispday * 24 * 60 + ($uh-$h1) * 60 + ($umin-$mm1) ;
  return($t);
};

sub div {
  my($a,$b)=@_;
  my($c);
  $c=$a/$b;
  $div=int($c);
  return($div);
};


#{1996³â 2¿ù 4ÀÏ 22½Ã 8ºĞºÎÅÍ tminºĞ ¶³¾îÁø ³¯ÀÚ¿Í ½Ã°£À» ±¸ÇÏ´Â ÇÁ·Î½ÃÁ®}
sub getdatebymin {
  my($tmin,$uyear,$umonth,$uday,$uhour,$umin)=@_;
  my($y1,$mo1,$d1,$h1,$mi1,$t)=0;

  $y1 = $uyear - &div($tmin,525949);
  if ($tmin > 0) 
  {
    $y1 = $y1 + 2 ;
    do 
    {
      $y1 = $y1 - 1 ;
      $t = &getminbytime($uyear,$umonth,$uday,$uhour,$umin,$y1,1,1,0,0);
     } until ( $t >= $tmin ) ;
    $mo1 = 13 ;
    do 
    {
      $mo1 = $mo1 - 1 ;
      $t = &getminbytime($uyear,$umonth,$uday,$uhour,$umin,$y1,$mo1,1,0,0);
    } until ($t >= $tmin) ;
    $d1 = 32;
    do 
    {
      $d1 = $d1 - 1 ;
      $t = &getminbytime($uyear,$umonth,$uday,$uhour,$umin,$y1,$mo1,$d1,0,0);
     } until ($t >= $tmin) ;
    $h1 = 24 ;
    do 
    {
      $h1 = $h1 - 1 ;
      $t = &getminbytime($uyear,$umonth,$uday,$uhour,$umin,$y1,$mo1,$d1,$h1,0);
    } until ($t >= $tmin) ;
    $t = &getminbytime($uyear,$umonth,$uday,$uhour,$umin,$y1,$mo1,$d1,$h1,0);
    $mi1 =  $t - $tmin
  }
  else
  { 
    $y1 = $y1 - 2 ;
    do 
    {
      $y1 = $y1 + 1;
      $t = &getminbytime($uyear,$umonth,$uday,$uhour,$umin,$y1,1,1,0,0);
    } until ($t < $tmin);
    $y1 = $y1 - 1 ;
    $mo1 = 0;
    do 
    {
      $mo1 = $mo1 + 1;
      $t = &getminbytime($uyear,$umonth,$uday,$uhour,$umin,$y1,$mo1,1,0,0);
    } until ( $t < $tmin) ;
    $mo1 = $mo1 - 1;
    $d1 = 0;
    do 
    {
      $d1 = $d1 + 1;
      $t = &getminbytime($uyear,$umonth,$uday,$uhour,$umin,$y1,$mo1,$d1,0,0);
    } until ($t < $tmin) ;
    $d1 = $d1 - 1 ;
    $h1 = -1 ;
    do 
    {
      $h1 = $h1 + 1;
      $t = &getminbytime($uyear,$umonth,$uday,$uhour,$umin,$y1,$mo1,$d1,$h1,0);
    } until ($t < $tmin) ;
    $h1 = $h1 - 1;
    $t = &getminbytime($uyear,$umonth,$uday,$uhour,$umin,$y1,$mo1,$d1,$h1,0) ;
    $mi1 = $t - $tmin ;
  };
  return($y1,$mo1,$d1,$h1,$mi1);
};

sub sydtoso24yd  {
  my($soloryear,$solormonth,$solorday,$solorhour,$solormin)=@_;
  my($displ2min,$displ2day,$monthmin100,$i,$j,$t,
     $so24,$so24year,$so24month,$so24day,$so24hour)=0;


  #$unityear=1996;$unitmonth=2;$unitday=4;$unithour=22;$unitmin=8;$unitsec=0;  #ÀÔÃá
  $displ2min =&getminbytime($unityear,$unitmonth,$unitday,$unithour,$unitmin,
                            $soloryear,$solormonth,$solorday,$solorhour,$solormin);
  $displ2day =&disp2days($unityear,$unitmonth,$unitday,$soloryear,$solormonth,$solorday);

  $so24=&div($displ2min,525949);

  if ($displ2min >= 0 ) { $so24 =$so24+1;};
  $so24year = -1*($so24 % 60);
  $so24year = $so24year + 12 ;
  if ($so24year < 0) {$so24year=$so24year+60;};
  if ($so24year>59) {$so24year=$so24year-60;};

  $monthmin100=$displ2min % 525949 ;
  $monthmin100=525949-$monthmin100;

  if ($monthmin100<0) { $monthmin100 = $monthmin100+525949;};
  if ($monthmin100>=525949) {$monthmin100=$monthmin100-525949;};

  for ($i=0;$i<=11;$i++) {
     $j=$i*2;
     if (($montharray[$j]<=$monthmin100) && ($monthmin100<$montharray[$j+2]))
        { $so24month=$i; }
    };

  $i=$so24month;
  $t=$so24year % 10 ;
  $t=$t % 5 ;
  $t=$t*12+2+$i;
  $so24month = $t ;
  if ($so24month>59) { $so24month=$so24month-60; };

  $so24day=$displ2day % 60 ;

  $so24day = -1*$so24day;
  $so24day = $so24day+7;
  if ($so24day<0) {$so24day= $so24day+60;}
  if ($so24day>59) {$so24day=$so24day-60;};

  if ((($solorhour==0) || ($solorhour==1)) && ($solormin<30))
     { $i=0;};

  if ((($solorhour==1) && ($solormin>=30))||($solorhour==2)||
     (($solorhour==3) && ($solormin<30))) { $i=1; };
 
  if ((($solorhour==3) && ($solormin>=30))||($solorhour==4)||
     (($solorhour==5) && ($solormin<30))) { $i=2; };

  if ((($solorhour==5) && ($solormin>=30))||($solorhour==6)||
     (($solorhour==7) && ($solormin<30))) { $i=3; };

  if ((($solorhour==7) && ($solormin>=30))||($solorhour==8)||
     (($solorhour==9) && ($solormin<30))) { $i=4; };

  if((($solorhour==9) && ($solormin>=30))||($solorhour==10)||
     (($solorhour==11) && ($solormin<30))) { $i=5; };

  if((($solorhour==11)  && ($solormin>=30))||($solorhour==12)||
     (($solorhour==13) && ($solormin<30))) { $i=6; };

  if((($solorhour==13) && ($solormin>=30))||($solorhour==14)||
     (($solorhour==15) && ($solormin<30))) { $i=7; };

  if((($solorhour==15) && ($solormin>=30))||($solorhour==16)||
     (($solorhour==17) && ($solormin<30))) { $i=8; };

  if((($solorhour==17) && ($solormin>=30))||($solorhour==18)||
     (($solorhour==19) && ($solormin<30))) { $i=9; };

  if((($solorhour==19) && ($solormin>=30))||($solorhour==20)||
     (($solorhour==21) && ($solormin<30))) { $i=10; };

  if((($solorhour==21) && ($solormin>=30))||($solorhour==22)||
     (($solorhour==23) && ($solormin<30))) { $i=11; };

  if (($solorhour==23) && ($solormin>=30))
     {
        $so24day = $so24day + 1;
        if ($so24day==60){$so24day=0};
        $i=0;
     }

  $t=$so24day % 10;
  $t=$t % 5;
  $t=$t*12 + $i;
  $so24hour=$t;


  return($so24,$so24year,$so24month,$so24day,$so24hour)

};

#Àı±â½Ã°£±¸ÇÏ±â
sub solortoso24 {

  my($soloryear,$solormonth,$solorday,$solorhour,$solormin)=@_;

  my($so24,$so24year,$so24month,$so24day,$so24hour,$displ2min,$monthmin100,
     $i,$j,$tmin,$y1,$mo1,$d1,$h1,$mi1,
     $inginame,$ingiyear,$ingimonth,$ingiday,$ingihour,$ingimin,
     $midname,$midyear,$midmonth,$midday,$midhour,$midmin,
     $outginame,$outgiyear,$outgimonth,$outgiday,$outgihour,$outgimin)=0;

  ($so24,$so24year,$so24month,$so24day,$so24hour)=
      &sydtoso24yd($soloryear,$solormonth,$solorday,$solorhour,$solormin);

  $displ2min=&getminbytime($unityear,$unitmonth,$unitday,$unithour,$unitmin,
                    $soloryear,$solormonth,$solorday,$solorhour,$solormin);


  $monthmin100=$displ2min % 525949 ;
  $monthmin100=525949-$monthmin100;
  if ($monthmin100 < 0) { $monthmin100=$monthmin100+525949};
  if ($monthmin100>=525949) { $monthmin100=$monthmin-525949};

  $i=$so24month % 12 - 2 ;
  if ($i==-2) {$i=10};
  if ($i==-1) {$i=11};

  $inginame = $i*2 ;
  $midname = $i*2+1;
  $outginame=$i*2+2;

  $j=$i*2;
  $tmin=$displ2min+($monthmin100-$montharray[$j]);

  ($y1,$mo1,$d1,$h1,$mi1)=&getdatebymin($tmin,$unityear,$unitmonth,$unitday,$unithour,$unitmin);

  $ingiyear=$y1;
  $ingimonth=$mo1;
  $ingiday=$d1;
  $ingihour=$h1;
  $ingimin=$mi1;

 
  $tmin=$displ2min+($monthmin100-$montharray[$j+1]);
  ($y1,$mo1,$d1,$h1,$mi1)=&getdatebymin($tmin,$unityear,$unitmonth,$unitday,$unithour,$unitmin);
                           
  $midyear=$y1;
  $midmonth=$mo1;
  $midday=$d1;
  $midhour=$h1;
  $midmin=$mi1;

  $tmin=$displ2min+($monthmin100-$montharray[$j+2]);
  ($y1,$mo1,$d1,$h1,$mi1)=&getdatebymin($tmin,$unityear,$unitmonth,$unitday,$unithour,$unitmin);
                           
  $outgiyear=$y1;
  $outgimonth=$mo1;
  $outgiday=$d1;
  $outgihour=$h1;
  $outgimin=$mi1;
 
 return(  $inginame,$ingiyear,$ingimonth,$ingiday,$ingihour,$ingimin,
          $midname,$midyear,$midmonth,$midday,$midhour,$midmin,
          $outginame,$outgiyear,$outgimonth,$outgiday,$outgihour,$outgimin);
}

sub degreelow {
   my($d)=@_;
   my($i,$di)=0;
   
   $di=$d;
   $i=int($di);
   $i=&div($i,360);

   $di=$di-($i*360);
   
   while (($di>=360) || ($di<0)) {
         if ($di>0){$di=$di-360;} else {$di=$di+360};
      }
  return($di);
}

sub moonsundegree {
   my ($day) = @_ ;
   my ($sl,$smin,$sminangle,$sd,$sreal,$ml,$mmin,$mminangle,
         $msangle,$msdangle,$md,$mreal,$re);

   $sl=$day*0.98564736+278.956807;
   $smin=282.869498+0.00004708*$day;
   $sminangle=3.14159265358979*($sl-$smin)/180;
   $sd=1.919*sin($sminangle)+0.02*sin(2*$sminangle);
   $sreal=&degreelow($sl+$sd);

   $ml=27.836584+13.17639648*$day;
   $mmin=280.425774+0.11140356*$day;
   $mminangle=3.14159265358979*($ml-$mmin)/180;
   $msangle=202.489407-0.05295377*$day;
   $msdangle=3.14159265358979*($ml-$msangle)/180;
   $md=5.06889*sin($mminangle)+0.146111*sin(2*$mminangle)+0.01*sin(3*$mminangle)
           -0.238056*sin($sminangle)-0.087778*sin($mminangle+$sminangle)
           +0.048889*sin($mminangle-$sminangle)-0.129722*sin(2*$msdangle)
           -0.011111*sin(2*$msdangle-$mminangle)-0.012778*sin(2*$msdangle+$mminangle);
   $mreal=&degreelow($ml+$md);
   $re = &degreelow($mreal-$sreal);
   return($re);
}


sub getlunarfirst {
  my($syear,$smonth,$sday)=@_;
  my($year,$month,$day,$hour,$min,
     $year1,$month1,$day1,$hour1,$min1,
     $year2,$month2,$day2,$hour2,$min2,
     $d,$de,$pd,$i,$dm,$dem)=0;

  $dm=&disp2days($syear,$smonth,$sday,1995,12,31);
  $dem=&moonsundegree($dm);

  $d=$dm;
  $de=$dem;
  
  while ($de>13.5) {
      $d=$d-1;
      $de=&moonsundegree($d);
    };

  while ($de>1) {
      $d=$d-0.04166666666;
      $de=&moonsundegree($d);
   };
 
  while ($de<359.99) {
      $d=$d-0.000694444;
      $de=&moonsundegree($d);
   };

  $d=$d+0.375;
  $d=$d*1440;
  $i=-1*int($d);
 ($year,$month,$day,$hour,$min)=&getdatebymin($i,1995,12,31,0,0);

  $d=$dm;
  $de=$dem;

  while ($de < 346.5) {
      $d=$d+1;
      $de=&moonsundegree($d);
    };

  while ($de < 359 ) {
      $d=$d+0.04166666666;
      $de=&moonsundegree($d);
    };

  while ($de >0.01 ) {
     $d=$d+0.000694444;
     $de=&moonsundegree($d);
   };
  
  $pd=$d;
  $d=$d+0.375;
  $d=$d*1440;
  $i=-1*int($d);
  ($year2,$month2,$day2,$hour2,$min2)=&getdatebymin($i,1995,12,31,0,0);

  if (($smonth==$month2) && ($sday==$day2)) {
     $year=$year2;
     $month=$month2;
     $day=$day2;
     $hour=$hour2;
     $min=$min2;

     $d=$pd+26;

     $de=&moonsundegree($d);      
     while ($de < 346.5) {
        $d=$d+1;
        $de=&moonsundegree($d);
     };

     while ($de < 359 ) {
        $d=$d+0.04166666666;
        $de=&moonsundegree($d);
     };

     while ($de >0.01 ) {
        $d=$d+0.000694444;
        $de=&moonsundegree($d);
     };

     $d=$d+0.375;
     $d=$d*1440;
     $i=-1*int($d);
     ($year2,$month2,$day2,$hour2,$min2)=&getdatebymin($i,1995,12,31,0,0);
   };

  $d=&disp2days($year,$month,$day,1995,12,31);
  $d=$d+12;

  $de=&moonsundegree($d);
  while ($de<166.5) {
        $d=$d+1;
        $de=&moonsundegree($d);
    };
  while ($de<179) {
        $d=$d+0.04166666666;
        $de=&moonsundegree($d);
    };
  while ($de<179.999) {
        $d=$d+0.000694444;
        $de=&moonsundegree($d);
    };

  $d=$d+0.375;
  $d=$d*1440;
  $i=-1*int($d);
  ($year1,$month1,$day1,$hour1,$min1)=&getdatebymin($i,1995,12,31,0,0);

  return($year,$month,$day,$hour,$min,
         $year1,$month1,$day1,$hour1,$min1,
         $year2,$month2,$day2,$hour2,$min2);
};

sub solortolunar {
  my( $solyear,$solmon,$solday)=@_;
  my( $s0,$i,$lnp,$lnp2,

      $inginame,$ingiyear,$ingimonth,$ingiday,$ingihour,$ingimin,
      $midname1,$midyear1,$midmonth1,$midday1,$midhour1,$midmin1,
      $midname2,$midyear2,$midmonth2,$midday2,$midhour2,$midmin2,
      $outginame,$outgiyear,$outgimonth,$outgiday,$outgihour,$outgimin,

      $smoyear,$smomonth,$smoday,$smohour,$smomin,
      $y0,$mo0,$d0,$h0,$mi0,
      $y1,$mo1,$d1,$h1,$mi1,

      $lyear,$lmonth,$lday,$lmoonyun,$largemonth)=0;
 
  ($smoyear,$smomonth,$smoday,$smohour,$smomin,
   $y0,$mo0,$d0,$h0,$mi0,
   $y1,$mo1,$d1,$h1,$mi1) = &getlunarfirst($solyear,$solmon,$solday);

  $lday=&disp2days($solyear,$solmon,$solday,$smoyear,$smomonth,$smoday)+1;

  $i=abs(&disp2days($smoyear,$smomonth,$smoday,$y1,$mo1,$d1));
  if ($i==30) {$largemonth=1;}; # ´ë¿ù
  if ($i==29) {$largemonth=0;}; # ¼Ò¿ù

  ($inginame,$ingiyear,$ingimonth,$ingiday,$ingihour,$ingimin,
   $midname1,$midyear1,$midmonth1,$midday1,$midhour1,$midmin1,
   $outginame,$outgiyear,$outgimonth,$outgiday,$outgihour,$outgimin)
           =&solortoso24($smoyear,$smomonth,$smoday,$smohour,$smomin);

  $midname2=$midname1+2;
  if ($midname2>24) {$midname2=1};
  $s0=$montharray[$midname2]-$montharray[$midname1];
  if ($s0<0) { $s0=$s0+525949 };
  $s0=-1*$s0;

  ($midyear2,$midmonth2,$midday2,$midhour2,$midmin2)
       =&getdatebymin($s0,$midyear1,$midmonth1,$midday1,$midhour1,$midmin1);
 
  if ((($midmonth1==$smomonth)&&($midday1>=$smoday))||(($midmonth1==$mo1)&&($midday1<$d1)))
  {
    $lmonth=($midname1-1) / 2 + 1;
    $lmoonyun=0;
  }
  else 
  {
    if ((($midmonth2==$mo1)&&($midday2<$d1)) || (($midmonth2==$smomonth)&&($midday2>=$smoday)))
    {
      $lmonth=($midname2-1) / 2 + 1;
      $lmoonyun=0;
    }
    else 
    {
      if (($smomonth<$midmonth2)&&($midmonth2<$mo1)) 
      {
        $lmonth=($midname2-1)/2 + 1;
        $lmoonyun=0;
      } 
      else
      {
        $lmonth=($midname1-1)/2+1;
        $lmoonyun=1;
      }
    }
  }


  $lyear=$smoyear;
  if (($lmonth==12)&&($smomonth==1)) {$lyear=$lyear-1};

  if ((($lmonth==11)&&($lmoonyun==1))||($lmonth==12)||($lmonth<6))
  {
    ($midyear1,$midmonth1,$midday1,$midhour1,$midmin1)
               = &getdatebymin(2880,$smoyear,$smomonth,$smoday,$smohour,$smomin);
 
    ($outgiyear,$outgimonth,$outgiday,$lnp,$lnp2)=&solortolunar($midyear1,$midmonth1,$midday1);

    $outgiday=$lmonth-1;
    if ($outgiday==0) {$outgiday=12};
 
    if ($outgiday==$outgimonth)
    {
      if ($lmoonyun==1) { $lmoonyun=0 };
    }
    else
    {
      if ($lmoonyun==1)
      {
        if ($lmonth != $outgimonth ) 
        {
          $lmonth=$lmonth-1;
          if ($lmonth==0) 
          { 
            $lyear=$lyear-1;
            $lmonth=12;
          };
          $lmoonyun=0;
        };
      }
      else
      {
        if ($lmonth==$outgimonth)
        {
          $lmoonyun=1;
        }
        else
        {  
          $lmonth=$lmonth-1;
          if ($lmonth==0) {$lyear=$lyear-1;$lmonth=12};
        }
      }
    }

  }

  return($lyear,$lmonth,$lday,$lmoonyun,$largemonth);
}


sub lunartosolar {
  my($lyear,$lmonth,$lday,$moonyun)=@_;
  my(
     $inginame,$ingiyear,$ingimonth,$ingiday,$ingihour,$ingimin,
     $midname,$midyear,$midmonth,$midday,$midhour,$midmin,
     $outginame,$outgiyear,$outgimonth,$outgiday,$outgihour,$outgimin,

     $tmin,$hour,$min,
     $yearm,$monthm1,$daym,$hourm,$minm,
     $year1,$month1,$day1,$hour1,$min1,
     $lyear2,$lmonth2,$lday2,$lnp,$lnp2,
     $syear,$smonth,$sday,$hour,$min);

  ($inginame,$ingiyear,$ingimonth,$ingiday,$ingihour,$ingimin,
   $midname,$midyear,$midmonth,$midday,$midhour,$midmin,
   $outginame,$outgiyear,$outgimonth,$outgiday,$outgihour,$outgimin )
                 =    &solortoso24($lyear,2,15,0,0);


   $midname = $lmonth * 2 - 1 ;
   $tmin = -1*$montharray[$midname];
   ( $midyear,$midmonth,$midday,$midhour,$midmin ) 
             = &getdatebymin($tmin,$ingiyear,$ingimonth,$ingiday,$ingihour,$ingimin);
                
   ( $outgiyear,$outgimonth,$outgiday,$hour,$min,
     $yearm,$monthm1,$daym,$hourm,$minm,
     $year1,$month1,$day1,$hour1,$min1 )
                =&getlunarfirst($midyear,$midmonth,$midday);

   ($lyear2,$lmonth2,$lday2,$lnp,$lnp2) 
          =&solortolunar($outgiyear,$outgimonth,$outgiday);

  if (($lyear2==$lyear) && ($lmonth==$lmonth2))
  {
    $tmin =  -1440 * $lday + 10;
    ($syear,$smonth,$sday,$hour,$min)=&getdatebymin($tmin,$outgiyear,$outgimonth,$outgiday,0,0);


    if ($moonyun==1)
    {
      ($lyear2,$lmonth2,$lday2,$lnp,$lnp2)=&solortolunar($year1,$month1,$day1);
      if (($lyear2==$lyear) && ($lmonth==$lmonth2))
      {
        $tmin = -1440 * $lday + 10;
        ($syear,$smonth,$sday,$hour,$min)=&getdatebymin($tmin,$year1,$month1,$day1,0,0);
      };
    };
  }
  else
  {
    ($lyear2,$lmonth2,$lday2,$lnp,$lnp2)=&solortolunar($year1,$month1,$day1);
    if (($lyear2==$lyear) && ($lmonth==$lmonth2))
    {
      $tmin = -1440 * $lday + 10;

      ($syear,$smonth,$sday,$hour,$min)=&getdatebymin($tmin,$year1,$month1,$day1,0,0);
    };
  };
  return($syear,$smonth,$sday);
}

sub getweekday {
  my($syear,$smonth,$sday)=@_;
  my($d,$i);

  $d = &disp2days($syear,$smonth,$sday,$unityear,$unitmonth,$unitday);

  $i=&div($d,7);
  $d = $d - ($i * 7 );

  while (($d > 6) || ($d < 0))
  {
     if ($d > 6) { $d=$d-7 } else { $d=$d+7 };
  }
  if ($d < 0) {$d= $d+7;};
  return($d);
};

sub get28sday  {
   my($syear,$smonth,$sday)=@_;
   my($d,$i);

   $d = &disp2days($syear,$smonth,$sday,$unityear,$unitmonth,$unitday);

   $i=&div($d,28);
   $d = $d - ($ i * 28 );

   while (($d > 27) || ($d < 0))
      {
         if ($d > 27) { $d=$d-28 } else { $d=$d+28 };
      }
   if ($d < 0) {$d= $d+7;};
   $d=$d-11;
   if ($d<0) {$d=$d+28};
   return($d);
};
