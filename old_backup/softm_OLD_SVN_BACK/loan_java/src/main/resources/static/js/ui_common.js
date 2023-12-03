// 2017-02-02


/***************************	
	변수
***************************/
var pub = {
    winW : $(window).outerWidth(true),
    winH : $(window).outerHeight(true),
};


/***************************	
	Size define
***************************/
var main_size = function (type) {
	this.init(type);	
};
main_size.prototype = { 
	init: function(type) {
		this.setVar();			
		this.type = type;
		this.setSize();
		if ( this.type == 'small' ) {
			this.setSmall();
		} else if ( this.type == 'wide' ) {
			this.setNormal();
		} else {
			this.setDefault();
		}			
	},
	setVar: function() {
        this.winW = $(window).outerWidth(true);
        this.winH = $(window).outerHeight(true);
		this.naviW = $('#navi').outerWidth(true);
		this.headerH = $('.title_wrap').outerHeight(true);
		this.contentsareaW = $('#contentsarea').outerWidth(true);
		this.autoHeight = $('#navi, #contentsarea');
		this.autoWidth = $('#contentsarea');
		this.autoScroll = $('#contents');
	},
	setSize: function() {
		this.autoHeight.css({ 
			'height' : this.winH
		});
		this.autoWidth.css({ 
			'width' : this.winW - this.naviW
		});
		this.autoScroll.css({ 
			'height' : this.winH - this.headerH
		});		
	},
	setSmall: function() {
		$(document).find('div.navi_action').addClass('small').animate({'left':'90px'},200);
		$(document).find('#navi').animate({'width':'80px'},200);	
		setTimeout(function(){
			$(document).find('#navi').addClass('small').removeClass('wide');	
		},100);	
		var aType = $('#contentsarea').attr('class');
		if ( aType != 'bg_main') {
			$(document).find('#contentsarea').animate({'width':this.winW - 80},200);
		} 	
	},	
	setNormal: function() {
		$(document).find('div.navi_action').removeClass('small').animate({'left':'310px'},200)
		$(document).find('#navi').animate({'width':'300px'},200);
		setTimeout(function(){
			$(document).find('#navi').addClass('wide').removeClass('small');	
		},100);
		var aType = $('#contentsarea').attr('class');
		if ( aType != 'bg_main') {
			$(document).find('#contentsarea').animate({'width':this.winW - 300},200);
		} 			
	},
	setDefault: function() {
		$(document).find('#navi').removeClass('small wide').css({'width':'300'}).show();	
		$(document).find('div.navi_action').css({'left':'310px'})
		var aType = $('#contentsarea').attr('class');
		if ( aType != 'bg_main') {
			$(document).find('#contentsarea').css({'width':this.winW - 300});
		} 			
	}
};

$(window).on('resize', function() {
	new main_size();	
});

$(window).on('load', function() {
	// 초기 좌측 LNB 가 작은 경우 80px 및 small / 큰경우 300px 및 wide 전달
//	$(document).find('#navi').css({'width':'80px'})	
//	new main_size('small');		
});

$(document).ready(function(){
	calendar_date();
	login_btnX();
});



/***************************	
	Event function
***************************/
// 약관박스 toggle
$(document).on('click','.agree_box .agree_title h5.title', function(e) {
	var _this = $(e.currentTarget);	
	if( _this.parent().hasClass('active') ) {
		_this.parent().next('.agree_data').stop().slideUp('fast');
		_this.parent().removeClass('active');		
		return false;
	} else {
		_this.parent().next('.agree_data').stop().slideDown('fast');
		_this.parent().addClass('active');
		return false;
	}	
});
// tab UI
$(document).on('click','ul.tabs[data-ui="tabs_UI"] li', function(e) {
	var _this = $(e.currentTarget);	
	var _tabs_no = _this.index();	
	_this.addClass('on').siblings().removeClass('on')
	_this.parents().find('.tabs_wrap').find('div.tabs_in').eq(_tabs_no).show().siblings().hide();
});
// button tab UI
$(document).on('click','div.toggle_wrap[data-ui="toggle_UI"] .btn', function(e) {
	var _this = $(e.currentTarget);	
	_this.addClass('on').siblings().removeClass('on')
});
// LNB small&wide
$(document).on('click','.navi_action', function(e) {
	var _this = $(e.currentTarget);	
	if( _this.hasClass('small') ) {
		new main_size('wide');
		window.localStorage.setItem("lnb","wide");		
		return false;		
	} else {
		new main_size('small');			
		window.localStorage.setItem("lnb","small");		
		return false;
	}
});

/***************************	
	POPUP function
***************************/
//  팝업
var layer_popup = function(popupWidth,popupHeight,popupId){
	$('body').prepend('<div class="dim"></div>');
	// 팝업 출력
	if( $('.dim').length > 1){
		$('.dim').hide();
		$('.dim').eq(0).show().css({
			'z-index':'11'
		});;
		$('[data-ui="popup"]').css({
			'z-index':'10'
		});
		$('#' + popupId  + ' .layer_popup' ).css({
			'z-index':'11'
		});
	}
	$('#' + popupId).show();
	var _this_pop = $('#' + popupId).find('.layer_popup');
	var popupW = popupWidth;
	var popupH = popupHeight;
	var popupHeader = $('.popup_header').height();
	_this_pop.css({'width':popupW,'height':popupH});

	// 팝업 위치
	var layerPopupWidth = _this_pop.outerWidth();
	var layerPopupHeight = _this_pop.outerHeight();

	if(pub.winH < layerPopupHeight){
		_this_pop.css({'width':(popupW*1 + 20) + 'px','height':pub.winH-80});
		var layerPopupHeight = _this_pop.outerHeight();
		$('#' + popupId).find('.scroll_area').css({'overflow-y':'scroll','height':layerPopupHeight-popupHeader});
	}

	// 화면 높이값 작아질 경우 팝업 스크롤 생성
	_this_pop.css({'margin-top': -(layerPopupHeight/2),'margin-left': -(layerPopupWidth/2)});
};

//  팝업 닫기 
var closeLayer = function(popupId){
	$('.dim').hide()
	$('#' + popupId).hide();
	var closeAlert = $('body').find('.layer_popup');
	closeAlert.css({'z-index':'100'});
};



/***************************	
	ALERT function
***************************/
// alert 
var alert_popup = function(alertWidth,alertHeight,alertId){
	$('body').prepend('<div class="dim"></div>');
	// 팝업 출력
	if( $('.dim').length > 1){
		$('.dim').hide();
		$('.dim').eq(0).show().css({
			'z-index':'11'
		});;
		$('[data-ui="popup"]').css({
			'z-index':'10'
		});
		$('#' + alertId  + ' .alert_popup' ).css({
			'z-index':'21'
		});
	}
	// alert 출력
	$('#' + alertId).show();
	var _this_alert = $('#' + alertId).find('.alert_popup');
	var alertW = alertWidth;
	var alertH = alertHeight;
	_this_alert.css({'width':alertW,'height':alertH});

	// alert 위치
	var alertWidth = _this_alert.outerWidth();
	var alertHeight = _this_alert.outerHeight();
	if(pub.winH < alertPopupHeight){
		_this_alert.css({'height':pub.winH-80,'overflow-y':'auto'});
		var alertPopupHeight = _this_pop.outerHeight();
	}

	// 화면 높이값 작아질 경우 alert 스크롤 생성
	_this_alert.css({'margin-top': -(alertHeight/2),'margin-left': -(alertWidth/2)});
};

//  alert 닫기 
var closeAlert = function(alertId){
	if( $('.dim').length > 1){
		$('.dim').css({
			'z-index':'10'
		});;
	} else {
		$('.dim').last().hide()
	}
	$('#' + alertId).hide();
	var closeAlert = $('body').find('.alert_popup');
	closeAlert.css({'z-index':'100'});
};


/***************************	
	date Picker function
***************************/
var calendar_date = function(){

	var inputDate = $(".datepicker")
	inputDate.each(function(){
		var inputDate = $(this)
		inputDate.datepicker({
			buttonImageOnly: true,
			showMonthAfterYear : true,
			dayNamesMin: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
			monthNames:  [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12" ],
			dateFormat: "yy-mm-dd",
		});
		//inputDate.val($.datepicker.formatDate('yy-mm-dd', new Date()));
	});

	var btnDate = $(".btn_datepicker")
	btnDate.each(function(){
		var btnDate = $(this)
		btnDate.datepicker({ 
			buttonImageOnly: true,
			showMonthAfterYear : true,
			dayNamesMin: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
			monthNames:  [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12" ],
			dateFormat: "yy-mm-dd",
			showButtonPanel: true,
			closeText: "Close",
		    onSelect: function() { 				
				var _year = btnDate.datepicker('getDate').getFullYear();  
				var _month = btnDate.datepicker('getDate').getMonth()+1;  
				var _day = btnDate.datepicker('getDate').getDate();  
				$('div.calendar .year').text(_year);
				$('div.calendar .month').text(_month);
				$('div.calendar .day').text(_day);			
			}
		});
	});

	var _now = new Date();
	var _year = _now.getFullYear();
	var _month = _now.getMonth() + 1;
	var _day = _now.getDate();
	$('div.calendar .year').text(_year);
	$('div.calendar .month').text(_month);
	$('div.calendar .day').text(_day);		
	
	$('.calendar').click(function(e){
		btnDate.datepicker("show"); 
	});

}


/***************************	
	loginpage function
***************************/
var login_btnX = function() {
	if ( $('.btnX').length > 0) {
		$('.btnX').remove();
	}
	// input
	$('.loginPage .input_wrap input.themeWhite').each(function(e){
		var _this = $(this);

		if( !$(this).hasClass('width60')) { 
			_this.parent().append('<span class="btnX"></span>');
			// focus
			_this.focus(function(){		
				aCustom();
				_this.on('keypress keydown keyup', function(){
					aCustom();
				});
			});
			var aCustom = function() {
				if ( _this.val().length > 0) {
					_this.parent().find('.btnX').show();
				} else {
					_this.parent().find('.btnX').hide();
				}
			}
		}
	});

	// button
	$(document).on('click', '.btnX', function(e){
		$(this).hide();
		$(this).parent().find('input').val('');
		$(this).parent().find('input').focus();			
	});

	// out focus
	$(document).on("click", function(e) {
		if ( $('.btnX').length > 0) {
			$('.btnX').hide();
		}
	});

}
