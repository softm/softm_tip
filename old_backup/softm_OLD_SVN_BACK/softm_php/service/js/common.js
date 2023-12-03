$(document).ready(function(){
    $("#topSForm").submit( 
        function(e) {
            if ( !$("#s_top_search").val() ) {
                $("#s_top_search").focus()
                alert("검색어를 입력하세요.");
                return false;
            } else {
                //return true;
            }
        }
    );
    $("#btn_top_search").click( function(e){
        $("#topSForm").trigger("submit");
    });
    
    $("#topSForm").attr("action","reginfo.php?sub=reginfo&mode=search");

	//skip nav
    $("a[href^='#']").click(function(evt) {
        var anchortarget = $(this).attr("href");
        $(anchortarget).attr("tabindex", -1).focus();
    });
    if (window.location.hash) {
        $(window.location.hash).attr("tabindex", -1).focus();
    };

	//gnb
	var $gnb_btn = $("#gnb > ul > li > a"),
		$gnb_view = $gnb_btn.parent().find(".gnb_sub")

		$gnb_view.css({display:"none"})

		$gnb_btn.on({
			mouseover: function(){
				$gnb_btn.parent().find(".gnb_sub").css({display:"none"})
				$(this).parent().find(".gnb_sub").css({display:"block"})
			},

			focusin: function(){
				$(this).parent().find(".gnb_sub").css({display:"block"})
			}
		})

		$gnb_btn.parent().on({
			mouseleave: function(){
				$gnb_btn.parent().find(".gnb_sub").css({display:"none"})
			}
		})

		$gnb_btn.parent().find(".gnb_sub ul li:last-child").on({
			focusout: function(){
				$(this).parent().parent().css({display:"none"})
			}
		});

	/*메인 슬라이드
	$(function() {
		var noticeSlide = $('.slide_box .slide_hidden'),
			moveUl = noticeSlide.find('ul'),
			eachLi = moveUl.find('li'),
			control = $('.btn_area'),
			prevButton = control.find('.btn_prev'),
			nextButton = control.find('.btn_next'),
			booleanChk = true,
			slideLen = eachLi.length;

		function init() { //init 초기화, width,height
			$('.slide_box .slide_hidden ul li').css({
				width: $('.slide_box .slide_hidden ul li').width()
			});
			$('.slide_box .slide_hidden ul').css({
				width: $('.slide_box .slide_hidden ul li').width() * slideLen
			});
		}

		function slideMove(arrow){
			if(booleanChk){
				if(arrow == 'prev'){
					booleanChk = false;
					moveUl.find('li').last().prependTo(moveUl);
					moveUl.css({
							left: -eachLi.width()
						});
						moveUl.stop().animate({
							left: 0
						}, {
							complete: function() {
								booleanChk = true;
							}
						});
				}else{
					moveUl.stop().animate({
							left: -eachLi.width()
						}, {
							duration: 400,
							complete: function() { // 에니메이트가 완료된후에 다음의 기능을 실행.
								moveUl.css({
									left: 0
								});
								moveUl.find('li').first().appendTo(moveUl);
								booleanChk = true;
							}
						});
				}
			}
		}

		prevButton.on({
			click: function(e) {
				e.preventDefault();
				slideMove('prev');
			}
		});
		nextButton.on({
			click: function(e) {
				e.preventDefault();
				slideMove('next');
			}
		});


	})
	*/
	 // 레이어팝업
	$(".popup_close").click(function(e){
        alert("xx");
        e.preventDefault();
		$(".layer_popup , .bg_popup").fadeOut();
		// $(this).parent().hide();
	});

	$(".guidance .layer_popup, .pop_content .layer_popup").hide()

	$(".data_tb01.pop table tr td a").click(function(e){
		e.preventDefault();
		$(".layer_popup , .bg_popup").fadeIn();
	})

	// 디자인 셀렉트
  	var selectWrap = $('.select_design, .select_design_type01, .select_design_gray'),
        selectLabel = $('.select_label'),
        selectList = $('.select_wrap'),
        selectListUl = selectList.find('ul'),
        selectListValue = selectList.find('ul li');
    
	selectList.hide();

	selectLabel.click(function(e){
		 e.preventDefault();

		 if(selectList.css("display") == "block"){
			selectList.hide();
		 }else{
			$(this).next(selectList).show();
		 }
	})

	selectList.find("li:last-child a").on({
		focusout: function(){
			selectList.hide()
		}
	})

    selectListValue.on({
        click: function(e) {
            e.preventDefault();
            var thisValue = $(this).text();
            var thisHiddenValue = $(this).find('input[type="hidden"]').val();

            $(this).parents('.select_wrap').hide();
            $(this).parents('.select_wrap').siblings('.select_label').find('>a').text(thisValue);
            $(this).parents('.select_wrap').siblings('.select_label').find('input[type="hidden"]').val(thisHiddenValue);
            $(this).parents('.select_wrap').siblings('.select_label').removeClass('on');
        }
    });
    selectWrap.on({
        mouseleave: function() {
            selectList.hide();
            selectList.siblings('.select_label').removeClass('on');
        }
    });

	//텝
	var $info_search_area = $(".tab_style > ul > li"),
		$btn_tab = $info_search_area.find("> a")
		$info_search_box = $info_search_area.find(".tab_box")

	$info_search_box.not(":eq(0)").hide();

	$btn_tab.on("click focusin",function(e){
		 e.preventDefault();
		$btn_tab.removeClass("active").parent().find(".tab_box").hide();
		$(this).addClass("active").parent().find(".tab_box").show();
	});

	//팝업
	$(".form_box .btn_add01").click(function(){
		$(".form_box #add01[disabled='disabled']").removeAttr('disabled');
	});
	$(".form_box .btn_add01").siblings().click(function(){
		$(".form_box #add01").attr('disabled', 'disabled');
	});
	$(".form_box .btn_add02").click(function(){
		$(".form_box #add02[disabled='disabled']").removeAttr('disabled');
	});
	$(".form_box .btn_add02").siblings().click(function(){
		$(".form_box #add02").attr('disabled', 'disabled');
	});
})


//var Common = {
//	/**
//	 * # using
//	    Util.Load.script({src:"/service/js/common.js",type:'js',callback:function(){
//	        var L = new Common.createELTechCat("select","L","s_l_cat","1차카테고리").make("43").append($S("area_tech_l_cat"));
//	        var M = new Common.createELTechCat("select","M","s_m_cat","2차카테고리").make("43","50").append($S("area_tech_m_cat"));
//	        var S = new Common.createELTechCat("select","S","s_s_cat","3차카테고리").make("43","50","06").append($S("area_tech_s_cat"));
//	        L.setNextObject(M);
//	        M.setNextObject(S);
//	    }});
//	 */
//    createELTechCat:function (type,s_gubun,elName,elTitle) {
//        this.type   = type.toLowerCase();
//        this.lang = "KR" ;
//        this.s_gubun= s_gubun;
//        this.elName = elName;
//        this.elTitle= elTitle;
//        this.element = null;
//        this.elements= Array();
//
//        this.selectValue = "";
//        this.nextObject  = null;
//        this.prevObject  = null;
//        	
//        this.appendArea = null;
//        
//        this.append=function (areaEl){
//            //console.debug(areaEl,this.element);
//            if ( areaEl ) this.appendArea = areaEl;
//            var lAreaEl = this.appendArea;
//            if ( lAreaEl ) {
//                if ( lAreaEl.firstChild ) {
//                   // console.debug("append",this.element, lAreaEl.firstChild);
//                    lAreaEl.replaceChild( this.element, lAreaEl.firstChild );
//                } else {
//                    lAreaEl.appendChild( this.element );
//                }
//            }
//            return this;
//        }
//        this.setNextObject=function (instance){
//            this.nextObject = instance;
//            this.nextObject.prevObject = this;
//            return this;
//        }
//        this.change=function() {
//            var next = this.nextObject;
//            var prev = this.prevObject;
////            console.debug("next:",next);
//            if ( next ) {
//                if ( this.type == "select" ) {
//                    if (this.s_gubun=="L") {
//                        next.make(this.element.value,"","").append();
//                        if (  next.nextObject ) {
//    //                        console.debug("next.nextObject",next.nextObject);
//                            next.change();
//                        }
//                    } else if (this.s_gubun=="M") {
//                        next.make(prev.element.value,this.element.value,"").append();
//                        if (  next.nextObject ) {
//    //                        console.debug("next.nextObject",next.nextObject);
//                            next.change();
//                        }
//                    }
//                } else if ( this.type == "radio" ) {
//                    if (this.s_gubun=="L") {
//                        next.make(Form.value($N(this.elName)),"","").append();
//                        if (  next.nextObject ) {
//    //                        console.debug("next.nextObject",next.nextObject);
//                            next.change();
//                        }
//                    } else if (this.s_gubun=="M") {
//                        next.make(Form.value($N(prev.elName)),Form.value($N(this.elName)),"").append();
//                        if (  next.nextObject ) {
//    //                        console.debug("next.nextObject",next.nextObject);
//                            next.change();
//                        }
//                    }
//                }
//            }
//        }
//        
//        this.setLang=function(lang){
//        	this.lang = lang;
//        	return this;
//        }
//                
//        this.make=function(sLCat,sMCat,sSCat) {
//            this.argus = {};
//            this.argus['s_gubun'] = this.s_gubun;
//
//            this.sLCat  = sLCat?sLCat:"";
//            this.sMCat  = sMCat?sMCat:"";
//            this.sSCat  = sSCat?sSCat:"";
//            var dbCall = false;
//            if      ( this.s_gubun == 'L'                   ) {
//                dbCall = true;
//                this.selectValue = this.sLCat;
//            } else if ( this.s_gubun == 'M' && this.sLCat   ) {
//                this.argus['s_l_cat'] = this.sLCat;
//                dbCall = true;
//                this.selectValue = this.sMCat;
//            } else if ( this.s_gubun == 'S' && this.sLCat  && this.sMCat ) {
//                this.argus['s_l_cat'] = this.sLCat;
//                this.argus['s_m_cat'] = this.sMCat;
//                this.selectValue = this.sSCat;
//                dbCall = true;
//            }
//            this.argus['s_lang'] = this.lang;
//
//            var me = this;
//            if ( dbCall ) {
//                callJSONSyncToJson('common.Common','getTechCategory',
//                    this.argus,
//                    function (json) {
//                        var data = eval("(" + json+ ")");
////                        alert( json );
////                        console.debug("data ", data);
//                        if ( me.type == "select" ) {
//                            me.element = Create.listBox({name:me.elName,value:json_merge({'':me.elTitle},data),selected:me.selectValue});
//                            me.element.onchange = (function(me){
//                                return function(){
//    //                                console.debug("onchange",me);
//                                    me.change();
//                                };
//                            })(me);
//                        } else if ( me.type == "radio" ) {
//                            //console.debug("radio data ", data);
//                            me.element = Create.radio({name:me.elName,value:json_merge(data),checked:me.selectValue});
//                            var l = me.element.childNodes.length;
//                            //console.debug(me.element.childNodes);
//                            for(var i=0;i<=l; i++ ) {
//                                if ( me.element.childNodes[i] && me.element.childNodes[i].type == 'radio' ) {
//                                    me.element.childNodes[i].onclick = (function(me){
//                                        return function(){
//            //                                console.debug("onchange",me);
//                                            me.change();
//                                        };
//                                    })(me);
//                                    me.elements.push(me.element.childNodes[i]);
//                                }
//                            }
//                            
//                        }
//                    }
//                );
//                //this = me;
//                if ( this.type == "select" ) {
//                    //if ( this.selectValue ) this.element.value = this.selectValue;
//                } else if ( this.type == "radio" ) { // Create.radio 에서 생성.
//                }
//            } else {
//                if ( this.type == "select" ) {
//                    this.element = Create.listBox({name:this.elName,value:{'':this.elTitle}});
//                } else if ( this.type == "radio" ) {
//                    this.element = Create.radio({name:this.elName});
//                }
//            }
//            return this;
//        }
//
//        return this;
//    }
//};