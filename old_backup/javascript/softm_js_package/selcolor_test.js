<!--
GRAY_COLOR=100;
RGB_COLOR=101;
RED = 1011;
GREEN = 1012;
BLUE = 1013;

var px=4;
var py=23;
var s2X = 7;
var s2Y = 126;      //  항상 젤 위 (b=100)
var drag ;
GLAY = new Array("F", "C", "C", "9", "9", "6", "6", "3",  "0");  /*첫번재 칸의 세로*/
COLOR = new Array("FF", "CC", "99", "66", "33", "00"); /*web color*/

function init()
{
	array = new Array();

	document.onmouseup = endDrag;
	oldX = oldY = newX = newY = 0;
	drag = null;
}

function gethtmlCode() {
    var htmlCode = document.RGBH.htmlCode.value;
    return htmlCode;
}

function reflection() {

    var oMyObject = window.dialogArguments;
    var myWindow = oMyObject.Window;
//  alert ( myWindow + " / " + myWindow.contentSelected );

    if ( oMyObject.attribute == 'backgroundColor') {
        getObject( "color_mesage" ).innerHTML = "◎ 배경색 변경 ";
    } else if ( oMyObject.attribute == 'color') {
        getObject( "color_mesage" ).innerHTML = "◎ 글자색 변경 ";
    }

    if ( myWindow.contentSelected == '1' ) {
    //  alert ( oMyObject.designDocument + " / " + oMyObject.attribute);
        if ( oMyObject.attribute == 'backgroundColor') {
            oMyObject.designDocument.execCommand("BackColor", 0, gethtmlCode());
        } else if ( oMyObject.attribute == 'color') {
            oMyObject.designDocument.execCommand("ForeColor", 0, gethtmlCode());
        }
    } else if ( myWindow.contentSelected == '0' ) {
        var obj = null;

        if ( myWindow.objectGB == "1" ) {
            obj = myWindow.currentObj;
        } else if ( myWindow.objectGB == "2" ) {
            obj = myWindow.selectObj;
            obj = myWindow.getObject( obj.id.substring(2), myWindow.designtier );
        }
        eval( "obj.style." + oMyObject.attribute + "='" + gethtmlCode() + "'");
    }
}

function confirm() {
    reflection();
    window.close();
}

function endDrag()
{
	drag = null;
	return;
}
function browserCheck() {
    var ie  = ( document.all ) ? 1 : 0;
    var ns6 = document.getElementById && !document.all ? 1 : 0;
    if ( ie  )      { return 1; }   // IE
    else if ( ns6 ) { return 2; }   // NS
}

function getObject( objStr ) {
    if ( browserCheck() == 1 )        {// IE
        return eval( "document.all['" + objStr + "']");
    } else if ( browserCheck() == 2 ) {// NS
        return eval( "document.getElementById('" + objStr + "');");
    }
}

function clickp1(objStr1,objStr4)
{
	obj1 = getObject( objStr1 );
	obj4 = getObject( objStr4 );
	value = "#" + selcolor("P1");
	
	rgbtos2XY(value,"D2","D3");
	obj1.innerHTML = value;
	realView(value,"RGBH","viewCol");
	drag = obj4;
	return;
}

function dragimg(objStr2,objStr3)
{
	obj2 = getObject( objStr2 );
	obj3 = getObject( objStr3 );
	var returnX = Math.floor( (event.clientX-px)/8 + 1 ) * 8 + px - 9;
	var returnY = Math.floor( (event.clientY-py)/8 + 1 ) * 8 + py - 9;

	if ( 0 < (returnX-px+9)/8 && (returnX-px+9)/8 < 32 )
		obj3.style.posLeft = returnX;

	if ( 0 < (returnY-py+9)/8 && (returnY-py+9)/8 < 196 )
		obj3.style.posTop = returnY;

	value="#" + selcolor("P1");
	obj2.innerHTML = value;
    reflection();
}

function clickS2(objStr1,objStr4)
{
	obj1 = getObject( objStr1 );
	obj4 = getObject( objStr4 );

	if(drag != obj4)
	  {
	    return;
	  }
	if(event.clientY < 130 || event.clientY > 246 || event.clientX <8 || event.clientX >296)
	{
	  return;
	}
	else{
	newX = event.clientX;
	newY = event.clientY;
	
	var distanceX = (newX - oldX);
	var distanceY = (newY - oldY);
	
	oldX=newX;
	oldY=newY;

	obj4.style.posLeft += distanceX;
	obj4.style.posTop += distanceY;
	
	var returnX = obj4.style.posLeft + 4;
	var returnY = obj4.style.posTop + 4;
	
	value = s2rgbColor(returnX,returnY);
	realView(value,"RGBH","viewCol");
	obj1.innerHTML = value;
	}
    reflection();
    event.returnValue = false;
}

function dragimgS2(objStr1,objStr4)
{
	obj1 = getObject( objStr1 );
	obj4 = getObject( objStr4 );
	drag = obj4;
	var	return2X = event.clientX - s2X;
	var	return2Y = event.clientY - s2Y;

	if ( return2X > 0 && return2X < 291 )
		obj4.style.posLeft = event.clientX - 9;
	if ( return2Y > 0 && return2Y < 233 )
		obj4.style.posTop = event.clientY - 9;

	if ( event.clientX > 8 && event.clientX < 296 && event.clientY > 120 && event.clientY < 246 )
	{
		value = s2rgbColor(obj4.style.posLeft,obj4.style.posTop);
		obj1.innerHTML = value;
		oldX = event.clientX;
	    oldY = event.clientY;
		realView(value,"RGBH","viewCol");
	    return;
	}
}

function clickS3(objStr5,objStr7)
{
	obj5 = getObject( objStr5 );
	obj7 = getObject( objStr7 );
	var resultY = event.clientY - 126;

	if ( resultY > 1  && resultY < 120 )
	{
		obj5.style.posTop = event.clientY - 6;
		realView(obj7.style.backgroundColor,"RGBH","viewCol");
	}
    reflection();
}
function makeColorTable()  /* 높이가 16 */
{
	var i = 0;

	while ( i < 16 ) {

		var col = num10to16(Math.round((16 - i) * (255/16)));
		var allColor = "#" + col + col + col;

		document.write("<tr><td id=t" + i 
		+ " width=8 height=7 style=\"font-size:0; letter-spacing:0; text-indent:0; "
		+ "; padding:0px; border-width:0; border-color:black; background-color:" + allColor  +"; maroon; border-style:none;\"></td></tr>");
		i++;
	}

}

/* B가 100인 색상값을 받아서 명도를 처리한 후에 보여주는 함수 */
function realView(value,objStr8,objStr6)
{
	obj8 = getObject( objStr8 );
	obj6 = getObject( objStr6 );
	newmakeTable(value);
	setCode = convertRGB(value,"D3")

	obj6.style.backgroundColor = setCode;

	obj8.htmlCode.value = setCode;
	obj8.redCol.value = num16to10(showRGB(RED, setCode));
	obj8.greenCol.value = num16to10(showRGB(GREEN, setCode));
	obj8.blueCol.value = num16to10(showRGB(BLUE, setCode));
}


function selcolor(objStr3){
	obj3 = getObject( objStr3 );

	var selectx = (obj3.style.posLeft-px+9)/8;
	var selecty = (obj3.style.posTop-py+9)/8;

	if ( selectx<2)
		return gray_color(selecty);
	if ( selectx>1 && selectx<32)
		return rgb_color(selectx,selecty);
}

function gray_color(y){
	var i=0;
	var rtnval="";

	while (i<6){
		rtnval += GLAY[y-1];
		i++;
	}return rtnval;
}

function rgb_color(x,y){
	var resultY = y - 5;
	var upnum = 5 - Math.abs(resultY);
	var downnum = resultY;
	var a0 = 0, a1 = 0, a2 = 0;

	rtnNum = findRGB(x).split(",");

	if ( resultY == 0 )
	{
		return COLOR[rtnNum[0]] + COLOR[rtnNum[1]] + COLOR[rtnNum[2]];
	}
	if ( resultY < 0 )
	{
		a0 = numCheck("up",rtnNum[0],upnum);
		a1 = numCheck("up",rtnNum[1],upnum);
		a2 = numCheck("up",rtnNum[2],upnum);

		return COLOR[a0] + COLOR[a1] + COLOR[a2];
	}
	else if ( resultY > 0 )
	{
		a0 = numCheck("down",rtnNum[0],downnum);
		a1 = numCheck("down",rtnNum[1],downnum);
		a2 = numCheck("down",rtnNum[2],downnum);

		return COLOR[a0] + COLOR[a1] + COLOR[a2];
	}
}

/* 색상이 변경될 때 마다 s3 파레트 구성을 변경시켜주는 함수 */
function newmakeTable(value)
{

	var Red = num16to10(showRGB(RED, value));
	var Green = num16to10(showRGB(GREEN, value));
	var Blue = num16to10(showRGB(BLUE, value));

	var i = 0;

	while ( i < 16 ) {   //16가지의 색으로

		var col1 = num10to16(Math.round((16 - i) * (Red/16)));
		var col2 = num10to16(Math.round((16 - i) * (Green/16)));
		var col3 = num10to16(Math.round((16 - i) * (Blue/16)));
		var allColor = "#" + col1 + col2 + col3;

		eval("t"+i+".style.backgroundColor = allColor"); 

		i++;

	}
}

/* RGB의 위치 체크 */
function numCheck(st,x,y){
	var x = x * 1;
	var y = y * 1;

	if (st=="up")
	{
		if (x>=y)
			return y;
		if (x<y)
			return x;
	}
	if (st=="down")
	{
		if ( y <= x )
			return x;
		if ( y > x )
			return y;
	}
	return;
}

function findRGB(x)
{
	var resultX = 0;
	var rtnVal = "";

	if ( x > 1 && x < 12 ) /* 3부류의 색으로*/
	{
		resultX = x - 6;

		if ( resultX <= 0 ) 
		{
			resultX += 5;
			rtnVal = "0,5,"+resultX;
		}
		else if ( resultX > 0 ) 
		{
			resultX = 5 - resultX;
			rtnVal = "0,"+resultX+",5"
		}
	}
	if ( x > 11 && x < 22 )
	{
		resultX = x - 16;

		if ( resultX <= 0 ) 
		{
			resultX += 5;
			rtnVal = resultX+",0,5";
		}
		else if ( resultX > 0 ) 
		{
			resultX = 5 - resultX;
			rtnVal = "5,0,"+resultX;
		}
	}
	if ( x > 21 && x < 32 )
	{
		resultX = x - 26;

		if ( resultX <= 0 ) 
		{
			resultX += 5;
			rtnVal = "5,"+resultX+",0";
		}
		else if ( resultX > 0 ) 
		{
			resultX = 5 - resultX;
			rtnVal = resultX+",5,0";
		}
	}

	return rtnVal;
}

function rgbtos2XY(value,objStr4,objStr5){
	obj4 = getObject( objStr4 );
	obj5 = getObject( objStr5 );
	var array = new Array();
	var Red = num16to10(showRGB(RED, value));
	var Green = num16to10(showRGB(GREEN, value));
	var Blue = num16to10(showRGB(BLUE, value));
	array = RGBtoHSB(Red,Green,Blue);
	
	xH = array["H"];
	xS = array["S"];
	xB = array["B"];

	var array=HStoXY(xH,xS);
	x = array["X"];
	y = array["Y"];

	obj4.style.posLeft = x +s2X - 6;
	obj4.style.posTop = y +s2Y - 6;
	obj5.style.posTop = 123;
	
}


function s2rgbColor(x,y)
{
	var array = new Array();

	array = XYtoHS(x,y);

	xH = array["H"];
	xS = array["S"];
	xB = 100;
	
	array = HSBtoRGB(xH,xS,xB);

	aa = num10to16(array["RE"]);
	bb = num10to16(array["GR"]);
	cc = num10to16(array["BL"]);

	return "#" + aa + bb + cc;
}

function showRGB(target, value)
{
	if ( target == RED )
		return value.substring(1,3);
	if ( target == GREEN )
		return value.substring(3,5);
	if ( target == BLUE )
		return value.substring(5,7);
}

/* RGB 값을 받아서 HSB로 바꾼다음 B(Bright)값을 설정값으로 조정한 후에 RGB로 리턴한다.  */
function convertRGB(value,objStr5)
{
	obj5 = getObject( objStr5 );
	var array = new Array();

	var Red = num16to10(showRGB(RED, value));
	var Green = num16to10(showRGB(GREEN, value));
	var Blue = num16to10(showRGB(BLUE, value));

	x2 = obj5.style.posTop - 123;

	array = RGBtoHSB(Red,Green,Blue);

	xH = array["H"];
	xS = array["S"];
	xB = array["B"];

	xB = Math.floor(  xB - ((xB*x2) / 116) );    //????

	array = HSBtoRGB(xH,xS,xB);

	aa = num10to16(array["RE"]);
	bb = num10to16(array["GR"]);
	cc = num10to16(array["BL"]);

	return "#" + aa + bb + cc;
}

/* 16진수를 10진수로 바꾸는 함수 */
function num16to10(value)
{
	var rtnVal = 0;

	rtnVal = (Char2Num(value.substring(0,1)) * 16) + (Char2Num(value.substring(1,2)) * 1);

	return rtnVal;
}

/* 16진수의 문자열을 숫자로 바꿔주는 함수 */
function Char2Num(str)
{
	if ( str == "A" || str == "a" )
		return 10;
	else if ( str == "B" || str == "b" )
		return 11;
	else if ( str == "C" || str == "c" )
		return 12;
	else if ( str == "D" || str == "d" )
		return 13;
	else if ( str == "E" || str == "e" )
		return 14;
	else if ( str == "F" || str == "f" )
		return 15;
	else
		return str;
}

/* 10진수를 16진수로 바꾸는 함수 */
function num10to16(value)
{
	var rtnVal = 0;

	rtnVal = Num2Char(Math.floor( value / 16 )) + "" + Num2Char(value - Math.floor( value / 16 ) * 16);

	return rtnVal;
}

/* 10진수 숫자를 16진수 문자열로 바꾸는 함수 */
function Num2Char(num)
{
	if ( num == 10 )
		return "A";
	else if ( num == 11 )
		return "B";
	else if ( num == 12 )
		return "C";
	else if ( num == 13 )
		return "D";
	else if ( num == 14 )
		return "E";
	else if ( num == 15 )
		return "F";
	else if ( num < 10 )
		return num;
}

/* HS 값을 받아서 XY 값을 리턴해주는 함수 */
function HStoXY(H,S)
{
  var array = new Array();

  if (S == 0)
  {
    array["X"] = 0;
    array["Y"] = 120;
  }
  else
  {
    array["X"] = Math.round( 29 * H / 36 );
    array["Y"] = Math.round( 6 * S / 5 );
	array["Y"] = 120 - array["Y"];
  }

  return array;
}

/* XY 값을 받아서 HS 값을 리턴해주는 함수 */
function XYtoHS(X,Y)
{
	var array = new Array();

    Y = 248 - Y;

	if ( X <= 1)
	{
		array["H"] = 0;
	}
	else
	{
		array["H"] = Math.round( 36 * X / 29 );

		if ( array["H"] > 360 )
			array["H"] = 360;

	}

	if ( Y <= 1)
	{
		array["S"] = 100;
	}
	else 
	{
		array["S"] = Math.round( 5 * Y / 6 );

		if ( array["S"] > 100 )
			array["S"] = 100;
	}
	
	return array;
}

/* HSB 를 RGS 로 바꾸어 Array로 리턴해주는 함수 */
function HSBtoRGB(H,S,B)
{
	var array = new Array();
	var x,y,z;
	var h,s,b;
	var re,gr,bl;
	var htmp, i,j;
	if(isNaN(H) == true || isNaN(S) == true || isNaN(B) == true)
		return;
	if(H == 360)
		H = 0;
	h = H;
	s = S/100;
	b = B/100;

	if(s == 0)
	{
		re = b;
		gr = b;
		bl = b;
	}
	else
	{
		if(h == 0)
			htmp = 0;
		else
			htmp = h/60;
		i = Math.floor(htmp);
		j= htmp - i;

		x = b*(1-s);
		y = b*(1-(s*j));
		z = b*(1-(s*(1-j)));

		switch(i)
		{
			case 0:
				re = b;
				gr = z;
				bl = x;
	        break;

			case 1:
				gr = b;
				re = y;
				bl = x;
			break;

			case 2:
				gr = b;
				re = x;
				bl = z;
			break;

			case 3:
				bl = b;
				gr = y;
				re = x;
			break;

			case 4:
				bl = b;
				gr = x;
				re = z;
			break;

			case 5:
				re = b;
				gr = x;
				bl = y;
			break;
		}
	}

	array["RE"] = Math.round(re * 255);
	array["GR"] = Math.round(gr * 255);
	array["BL"] = Math.round(bl * 255);

	return array;
}

/* RGB 를 HSB 로 바꾸어 Array로 리턴해주는 함수 */
function RGBtoHSB(R,G,B)
{
	var array = new Array();
	var re,gr,bl;
	var h,s,b;
	var min, tmp;
	var angcase;

	re = R/255;
	gr = G/255;
	bl = B/255;

	min = Math.min(re,Math.min(gr,bl));
	b = Math.max(re,Math.max(gr,bl));

	tmp = b - min;

	if(tmp == 0)
		s = 0;
	else
		s = tmp/b;

	if(s == 0)
	{
		h = 0;
	}
	else
	{
		if(b == re)
		{
			if((re != gr) && (re != bl))
			h = 60*((gr-bl)/tmp);
		}
		if(b == gr)
		{
			if(gr != bl)
			h = 120 + ((60*(bl-re))/tmp);
		}
		if(b == bl)
		{
			h = 240 + ((60*(re-gr))/tmp);
		}
	}
	if(h < 0)
	{
		h = 360 + h;
	}

	array["H"] = Math.round(h);
	array["S"] = Math.round(s * 100);
	array["B"] = Math.round(b * 100);

	return array;
}
//-->