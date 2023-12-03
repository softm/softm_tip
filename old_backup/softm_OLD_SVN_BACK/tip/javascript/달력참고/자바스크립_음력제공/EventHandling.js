//by Albeniz.com
//modify by sourcenara.com

function window_onload() {
	var today = new Date();
	
	txtYear.value = today.getYear();
	selMonth.value = today.getMonth() + 1;
	
	today.year = txtYear.value;
	today.month = selMonth.value - 1;
	
	drawCalendar(currentDate);
}

function btOK_onclick() {
	var i, j, code, hit;
	
	code = "0123456789";
	
	var str = txtYear.value;
	
	for (i=1;i<str.length;i++) {
		hit = 0;
		for (j=0;j<code.length;j++) {
			if(str.charAt(i) == code.charAt(j)) {
				hit = 1;
				break;
			}
		}
		if (!hit) {
			alert("년도의 자릿수는 4자리 이하입니다.");
			txtYear.value = "";
			txtYear.focus();
			return;
		}
	}
	
	if (str.length > 4) {
		alert("9999년 이하의 년도만 입력가능합니다.");
		txtYear.value = "";
		txtYear.focus();
		return;
	}
	
	currentDate.year = txtYear.value;
	currentDate.month = selMonth.value - 1;
	
	drawCalendar(currentDate);	
}

function btNextMonth_onclick() {
	if (currentDate.month < 11) selMonth.value = ++currentDate.month + 1;
	else {
		txtYear.value = ++currentDate.year;
		currentDate.month = 0;
		selMonth.value = currentDate.month + 1;
	}
	
	drawCalendar(currentDate);
}

function btNextYear_onclick() {
	txtYear.value = ++currentDate.year;
	
	drawCalendar(currentDate);
}

function btPrevMonth_onclick() {
	if (currentDate.month > 0) selMonth.value = --currentDate.month + 1;
	else {
		txtYear.value = --currentDate.year;
		currentDate.month = 11;
		selMonth.value = currentDate.month + 1;
	}
	drawCalendar(currentDate);
}

function btPrevYear_onclick() {
	txtYear.value = --currentDate.year;
	
	drawCalendar(currentDate);
}