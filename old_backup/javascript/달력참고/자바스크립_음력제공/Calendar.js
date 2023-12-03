//by Albeniz.com
//modify by sourcenara.com
var LunarTable = new Array(
		"1212122322121", "1212121221220", "1121121222120", "2112132122122", "2112112121220", 
		"2121211212120", "2212321121212", "2122121121210", "2122121212120", "1232122121212", 
		"1212121221220", "1121123221222", "1121121212220", "1212112121220", "2121231212121", 
		"2221211212120", "1221212121210", "2123221212121", "2121212212120", "1211212232212", 
		"1211212122210", "2121121212220", "1212132112212", "2212112112210", "2212211212120", 
		"1221412121212", "1212122121210", "2112212122120", "1231212122212", "1211212122210", 
		"2121123122122", "2121121122120", "2212112112120", "2212231212112", "2122121212120", 
		"1212122121210", "2132122122121", "2112121222120", "1211212322122", "1211211221220", 
		"2121121121220", "2122132112122", "1221212121120", "2121221212110", "2122321221212", 
		"1121212212210", "2112121221220", "1231211221222", "1211211212220", "1221123121221", 
		"2221121121210", "2221212112120", "1221241212112", "1212212212120", "1121212212210", 
		"2114121212221", "2112112122210", "2211211412212", "2211211212120", "2212121121210", 
		"2212214112121", "2122122121120", "1212122122120", "1121412122122", "1121121222120", 
		"2112112122120", "2231211212122", "2121211212120", "2212121321212", "2122121121210", 
		"2122121212120", "1212142121212", "1211221221220", "1121121221220", "2114112121222", 
		"1212112121220", "2121211232122", "1221211212120", "1221212121210", "2121223212121", 
		"2121212212120", "1211212212210", "2121321212221", "2121121212220", "1212112112210", 
		"2223211211221", "2212211212120", "1221212321212", "1212122121210", "2112212122120", 
		"1211232122212", "1211212122210", "2121121122210", "2212312112212", "2212112112120", 
		"2212121232112", "2122121212110", "2212122121210", "2112124122121", "2112121221220", 
		"1211211221220", "2121321122122", "2121121121220", "2122112112322", "1221212112120", 
		"1221221212110", "2122123221212", "1121212212210", "2112121221220", "1211231212222", 
		"1211211212220", "1221121121220", "1223212112121", "2221212112120", "1221221232112", 
		"1212212122120", "1121212212210", "2112132212221", "2112112122210", "2211211212210", 
		"2221321121212", "2212121121210", "2212212112120", "1232212122112", "1212122122120", 
		"1121212322122", "1121121222120", "2112112122120", "2211231212122", "2121211212120", 
		"2122121121210", "2124212112121", "2122121212120", "1212121223212", "1211212221220", 
		"1121121221220", "2112132121222", "1212112121220", "2121211212120", "2122321121212", 
		"1221212121210", "2121221212120", "1232121221212", "1211212212210", "2121123212221", 
		"2121121212220", "1212112112220", "1221231211221", "2212211211220", "1212212121210", 
		"2123212212121", "2112122122120", "1211212322212", "1211212122210", "2121121122120", 
		"2212114112122", "2212112112120", "2212121211210", "2212232121211", "2122122121210", 
		"2112122122120", "1231212122212", "1211211221220", "2121121321222", "2121121121220", 
		"2122112112120", "2122141211212", "1221221212110", "2121221221210", "2114121221221"
		);
var MonthTable = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var currentDate = new Date();
function LunarDate() {
	this.year = 1;
	this.month = 0;
	this.day = 1;
	this.isYunMonth = false;
}
function nDaysYear(year) {
	var i, sum;
	
	sum = 0;
	for (i=0;i<13;i++) {
		if (parseInt(LunarTable[year-1881].charAt(i))) {
			sum += 29 + (parseInt(LunarTable[year - 1881].charAt(i)) + 1) % 2;
		}
	}
	
	return sum;
}
function nDaysMonth(lunar_date) {
	var nDays;

	if (lunar_date.month <= YunMonth(lunar_date.year) && !lunar_date.isYunMonth) yun = 0;
	else yun = 1;
	
	nDays = 29 + (parseInt(LunarTable[lunar_date.year - 1881].charAt(lunar_date.month + yun)) + 1) % 2;

	return nDays;
}
function YunMonth(year) {
	var yun;
	
	yun = 0;
	do {
		if (LunarTable[year-1881].charAt(yun) > 2) {
			break;
		}
		yun++;
	} while (yun <= 12);
	
	return yun - 1;
}
function totalDays(solar_date) {
	var i, sum, tdays, nYears366;
	
	if (((solar_date.year % 4 == 0) && (solar_date.year % 100 != 0)) || (solar_date.year % 400 == 0)) MonthTable[1] = 29;
	else MonthTable[1] = 28;
	
	sum = 0;
	for (i=0;i<solar_date.month;i++) {
		sum = sum + MonthTable[i];
	}
	
	nYears366 = parseInt((solar_date.year - 1) / 4) - parseInt((solar_date.year - 1) / 100) + parseInt((solar_date.year - 1) / 400);

	tdays = (solar_date.year - 1) * 365 + sum + nYears366 + solar_date.day - 1;

	return tdays;
}
function SolarToLunar(solar_date) {
	var i, nDays, tmp;
	var FIRST_DAY;					
	
	FIRST_DAY = 686685;
	nDays = totalDays(solar_date) - FIRST_DAY;	
	
	var lunar_date = new LunarDate();		
	lunar_date.year = 1881;
	lunar_date.month = 0;
	lunar_date.day = 1;
	lunar_date.isYunMonth = false;	
	do {
		tmp = nDays;
		nDays -= nDaysYear(lunar_date.year);
		if (nDays < 0) {
			nDays = tmp;
			break;
		}
		lunar_date.year++;
	} while (true);	
	do {
		tmp = nDays;
		nDays -= nDaysMonth(lunar_date);;
		if (nDays < 0) {
			nDays = tmp;
			break;
		}
		
		if (lunar_date.month == YunMonth(lunar_date.year)&&!lunar_date.isYunMonth) {
			lunar_date.isYunMonth = true;
		}
		else {
			lunar_date.month++;
			lunar_date.isYunMonth = false;
		}
	} while (true);	
	lunar_date.day = nDays + 1;
	
	return lunar_date;
}


function drawCalendar(solar_date) {
	var i, week;
	
	solar_date.year = txtYear.value;
	solar_date.month = selMonth.value - 1;
	solar_date.day = 1;
	
	curYear.innerHTML = solar_date.year;
	curMonth.innerHTML = solar_date.month + 1;
	
	week = (totalDays(solar_date) + 1) % 7;			
	
	for (i=0;i<week;i++) {
		eval("s" + i + ".innerHTML='-'");
		eval("l" + i + ".innerHTML=''");
	}
	
		do {
		if ((solar_date.day + week - 1) % 7 == 0) {
		eval("s" + (week + solar_date.day - 1) + ".innerHTML='<b><font color=#FF0000>" + solar_date.day + "</font></b><br>'");
		}
		else if ((solar_date.day + week - 1) % 7 == 6) {
		eval("s" + (solar_date.day + week - 1) + ".innerHTML='<b><font color=#0000FF>" + solar_date.day + "</font></b><br>'");
		}
		else {
		eval("s" + (solar_date.day + week - 1) + ".innerHTML='<b>" + solar_date.day + "</b><br>'");
		}
	} while(++solar_date.day <= MonthTable[solar_date.month]);
	
		for (i=week+MonthTable[solar_date.month];i<37;i++) {
		eval("s" + i + ".innerHTML='-'");
		eval("l" + i + ".innerHTML=''");
	}

	solar_date.day = 1;
	
		if((solar_date.year < 1881) || (solar_date.year > 2051) || ((solar_date.year == 2051) && (solar_date.month > 1))) {
		for (i=0;i<37;i++) eval("l" + i + ".innerHTML=''");
		return;
	}
	
	if((solar_date.year == 1881) && (solar_date.month == 0)) {
		for (i=0;i<35;i++) eval("l" + i + ".innerHTML=''");
		eval("l35.innerHTML='<font size=2 color=#808080>1/1</font>'");
		eval("l36.innerHTML='<font size=2 color=#808080>1/2</font>'");
		return;
	}
	
	if((solar_date.year == 2051) && (solar_date.month == 1)) {
		for (i=3;i<13;i++) eval("l" + i + ".innerHTML='<font size=2 color=#808080>12/" + (i + 17) + "</font>'");
		for (i=13;i<37;i++) eval("l" + i + ".innerHTML=''");
		return;
	}
	
	var lunar_date = new LunarDate();
	lunar_date = SolarToLunar(solar_date);
	
	do {
		if (lunar_date.isYunMonth) {
		eval("l" + (solar_date.day + week - 1) + ".innerHTML='<font size=2 color=#006699>1" + (lunar_date.month + 1) + "/" + lunar_date.day + "</font><br>';");
		}
		else {
		eval("l" + (solar_date.day + week - 1) + ".innerHTML='<font size=2 color=#006699>" + (lunar_date.month + 1) + "/" + lunar_date.day + "</font><br>';");
		}
		
		if (lunar_date.day >= nDaysMonth(lunar_date)) {
			if (lunar_date.month < 11) {
				if ((lunar_date.month == YunMonth(lunar_date.year)) && !lunar_date.isYunMonth) {
					lunar_date.isYunMonth = true;
					lunar_date.day = 1;
				}
				else {
					lunar_date.month++;
					lunar_date.isYunMonth = false;
					lunar_date.day = 1;
				}
			}
			else {
				lunar_date.year++;
				lunar_date.month = 0;
				lunar_date.day = 1;
			}
		}
		else lunar_date.day++;
	} while(++solar_date.day <= MonthTable[solar_date.month]);
}
