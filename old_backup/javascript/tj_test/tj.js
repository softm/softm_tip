var info = {
//    base_url     :'http://172.20.238.74:7081/'
    base_url     :'http://localhost:8080/LGUPlusPG/'
    , jquery_js_url:this.base_url+'resource/js/jquery/jquery-1.8.3.js'
    ,iframe:null
    ,i:null
};
//alert("b c " + document.location.host);
//info.jquery_js_url='http://localhost:8080/resource/js/jquery/jquery-1.8.3.js';
//alert( document.location.hostname );
//alert( document.location.domain );
if (document.location.hostname =="localhost") {
    info.base_url = "http://localhost:8080/LGUPlusPG/";
	info.jquery_js_url = info.base_url+'resource/js/jquery/jquery-1.8.3.js';
} else if (document.location.hostname =="172.20.238.74") {
    info.base_url = "http://172.20.238.74:7081/";
	info.jquery_js_url = info.base_url+'resource/js/jquery/jquery-1.8.3.js';
} else if (document.location.hostname =="172.20.237.47") {
    info.base_url = "http://172.20.237.47:7081/";
	info.jquery_js_url = info.base_url+'resource/js/jquery/jquery-1.8.3.js';	
} else {
//    info.jquery_js_url = "./jquery-1.8.3.js";
	if ( navigator.userAgent.match("MSIE") ) {
//	    info.base_url = "http://localhost:8080/LGUPlusPG/";
	}

    info.jquery_js_url = "file:///D:/Work/tip/javascript/tj_test/jquery-1.8.3.js";
}

var v = z.src.split("\/");
var  basePath = v.slice(0,v.length-1).join("\/");
log("basePath : " + basePath);
    info.jquery_js_url = basePath + "/jquery-1.8.3.js";

if (!Date.prototype.toISOString) {
    Date.prototype.toISOString = function() {
        function pad(n) { return n < 10 ? '0' + n : n };
        return this.getUTCFullYear() + '-'
            + pad(this.getUTCMonth() + 1) + '-'
            + pad(this.getUTCDate()) + 'T'
            + pad(this.getUTCHours()) + ':'
            + pad(this.getUTCMinutes()) + ':'
            + pad(this.getUTCSeconds()) + 'Z';
    };
}

function log(){
	try {
		if (typeof console !== "undefined") {
			var args = Array.prototype.slice.call(arguments,0);
			if ( navigator.userAgent.match("MSIE") ) {
				console.info(typeof arguments == 'object' ? args.join(","):arguments);
			} else {
				console.info(arguments);
			}
		}
	}
	catch (e) {
	}
}

function fExecLogin(param,cb) {
     param.push("usrIp=0:0:0:0:0:0:0:1");
     param.push("mode=login");
//     param.push("savedToken.request=717126ff-f43a-4496-b75b-b6556672eec4");
     var url = info.base_url + "ms/mertpotal/retrieveGroupAdminLogin.do";
    if ( window.pg_src.indexOf("7082") > -1 ) {
        info.base_url = info.base_url.replace("7081","7082");
//        info.base_url = 'http://172.20.238.74:7082/';
    }
	var strDate = ( new Date()).toISOString().replace(/[-:TZ\.]/g,"");
	 var pred = new Date();
	 pred.setMonth(pred.getMonth()-1);
//	 log("pred",pred);
	var bemonthdate = pred.toISOString().replace(/[-:TZ\.]/g,"").substring(0,8);

     get_jquery_and_go(function() {
//      log(  $.inArray("type=mert",param) );
//console.info ( info.i );
        if (  self.$.inArray("type=group",param) != -1 ) {
            url = "ms/mertpotal/retrieveGroupAdminLogin.do";
			 param.push("passWord=1111"); // 상점
        } else if (  $.inArray("type=mert",param) != -1 ) {
            url = "ms/mertpotal/retrieveMertAdminLogin.do";
			 param.push("passWord=1111"); // 상점
        } else if (  $.inArray("logintype=uplus",param) != -1 || $.inArray("type=uplus",param) != -1 ) {
            url = "ms/upluspotal/retrieveUplusAdminLogin.do";
			 param.push("password=1111"); // 내부
			 param.push("beforemin=" + strDate); // 내부
//			 param.push("bemonthdate=" + strDate.substring(0,8)); // 내부
//document.writeln('현재 ' + m + "월 " + (term>0?"+":"-") + term + " = " + v +"월");
//console.info('현재 ' + m + "월 " + (term>0?"+":"") + term + "개월" + " = " + v +"월");

			 param.push("bemonthdate=" + bemonthdate); // 내부
			 param.push("cooperativecode="); // 내부
			 param.push("cooperativename="); // 내부
			 param.push("signed_data="); // 내부
			 param.push("type="); // 내부
//beforemin		201510141419
//bemonthdate		20150914
//cooperativecode	
//cooperativename	
//signed_data	
//type	
        } else if (  $.inArray("type=am",param) != -1 ) {
            url = "ms/upluspotal/retrieveAmAdminLogin.do";
			 param.push("password=1111"); // 내부
        }
     log("param : ", param);

        log("info.base_url + url : " + info.base_url + url );
         $.ajax({
            url: info.base_url + url,
            dataType: 'html',
            type: 'POST',
            async: false,
            data: param.join("&"),
//           xhrFields: {
//              withCredentials: true
//           },
            success: function(data) {
//              alert("성공.");
                log( "f" , cb);
                fOnload(info.iframe,cb);
            },
            error: function(req,status,error) {
                log("req error", req );
//                alert(  req) ; 
//                alert(  req.responseText) ; 
                if (!req || req.responseText) {
                    alert("서버 살아있는지 체크.");
                } else {
                    alert(error);
                }
            }
        });
    });
}
function fOnload(w,f) {
    log("fOnload.w:",w);
    window.of = function(){
			log("onload");
//			log(info.i);
//			info.i.f = f;
//			info.i.f();
//            f.call(window.w);
//            f();
//            window.w.f = f;
            var ff = f.bind(info.i);
            ff();
//            window.w.f();
            // desugars to this:
//            hello.call(person, "world");  
            fUnOnload(w);
//          window.w.contentWindow.f = f;
//          window.w.contentWindow.f();
    };
    if (w.addEventListener) {
        w.addEventListener('load',window.of);
    } else if (w.attachEvent) {
        w.attachEvent('onload', window.of);
    } else {
        w.onload=window.of;
    };
    //w.document.location.href = window.pg_src;
    w.src = window.pg_src + (window.pg_src.indexOf("?")>-1?"&":"?") + "t=" + ((new Date()).getTime());
    log("fOnload-w.src",w.src);
}
function fUnOnload(w,f) {
    if (w.removeEventListener) {
        w.removeEventListener('load',window.of);
    } else if (w.attachEvent) {
        w.detachEvent('onload', window.of);
    } else {
        w.onload=null;
    };
}
(function(){
//        window.pg_src = window.tj_pg?window.tj_pg:document.location.pathname;
        window.pg_src = window.tj_pg?window.tj_pg:document.location.href;
        var pgInfo = window.pg_src.split("\/");
        var pi = pgInfo[pgInfo.length-1];
        var p = pi.split(".")[0];
//        alert( pg );
        var d = window.w.document;
			info.iframe = d.body.appendChild(d.createElement('iframe'));
			info.iframe.setAttribute("width","100%");
			info.iframe.setAttribute("height","1024px");
        log("info.base_url : " + info.base_url );
        log("document.location.hostname : " + document.location.hostname );

        log( "window.pg_src" , window.pg_src );
        log( "window.tj_pg" , window.tj_pg );
        log( "window.w" , window.w);
        log( "d" , d);
        log( "p" , p);
        info.i = info.iframe.contentWindow||info.iframe;
        log( "info.iframe" , info.iframe);
        log( "info.i" , info.i);
        var f = null;
        switch (p) {
            case "retrieveEventList": // 상-이벤트관리
                    fExecLogin(["type=mert","userID=dacomst7"],function(){
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveEscrowInfoList": // 내부-에스크로
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveSettleTrxSumRateForGroup": // 통-계좌이체
                    fExecLogin(["type=group","userID=coupang"],function(){
                        this.$("[name='trxfrdate']").val("20140101");
                        this.$("[name='trxtodate']").val("20140101");
                        this.$("[name='servicecode']").filter("[value='SC0010']").attr("checked","checked");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveSettlTrxChgRate": // 통-모바일거래 모니터링
                    fExecLogin(["type=group","userID=coupang"],function(){
                        this.$("[name='trxfrdate']").val("20140101");
                        this.$("[name='trxtodate']").val("20140101");
                        this.$("[name='servicecode']").filter("[value='SC0010']").attr("checked","checked");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveMobileTrxDailyAvgTime": // 통-모바일거래 일평균시간
                    fExecLogin(["type=group","userID=coupang"],function(){
                        this.$("[name='trxdate']").val("20140101");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveNoteUrlList": // 통-전송실패내역조회
                if ( window.userID == "edu20801" ) {
                    fExecLogin(["type=mert","userID=edu20801"],function(){
                        this.$("[name='trxfrdate']").val("20130107");
                        this.$("[name='trxtodate']").val("20130107");
                        this.$(".btnList").trigger("click");
                    });
                } else if ( window.userID == "dacomGroup" ) {
                    fExecLogin(["type=group","userID=dacomGroup"],function(){
                        this.$("[name='trxfrdate']").val("20150326");
                        this.$("[name='trxtodate']").val("20150626");
                        this.$(".btnList").trigger("click");
                    });
                }
                break;
            case "retrieveAllTrxSum": // 통-전체거래내역 조회
                if ( window.userID == "moonyGroup" ) {
                    fExecLogin(["type=group","userID=moonyGroup"],function(){
                        this.$("[name='trxfrdate']").val("20140505");
                        this.$("[name='trxtodate']").val("20140505");
                        this.$(".btnList").trigger("click");
                    });
                } else if ( window.userID == "ty-1102" ) {
                    fExecLogin(["type=group","userID=ty-1102"],function(){
                        this.$("[name='trxfrdate']").val("20140505");
                        this.$("[name='trxtodate']").val("20140505");
                        this.$(".btnList").trigger("click");
                    });
                } else if ( window.userID == "dacomst7" ) {
                    fExecLogin(["type=mert","userID=dacomst7"],function(){
                        this.$("[name='trxfrdate']").val("20140505");
                        this.$("[name='trxtodate']").val("20140505");
                        this.$(".btnList").trigger("click");
                    });
                } else if ( window.userID == "itembay" ) {
                    fExecLogin(["type=mert","userID=itembay"],function(){
                        this.$("[name='trxfrdate']").val("20140505");
                        this.$("[name='trxtodate']").val("20140505");
                        this.$(".btnList").trigger("click");
                    });
                }
                break;
            case "retrieveHRDTradeList": // 통-산인공거래내역조회
                if ( window.userID == "hrdadmin" ) {
                    fExecLogin(["type=group","userID=hrdadmin"],function(){
                        this.$("[name='fromdate']").val("20150416");
                        this.$("[name='todate']").val("20150416");
                        this.$("[name='fromdate']").val("20150922");
                        this.$("[name='todate']").val("20150922");
                        this.$(".btnList").trigger("click");
                    });
                } else if ( window.userID == "hrd_admin" ) {
                    fExecLogin(["type=group","userID=hrd_admin"],function(){
                        this.$("[name='fromdate']").val("20150416");
                        this.$("[name='todate']").val("20150416");
                        this.$("[name='fromdate']").val("20150922");
                        this.$("[name='todate']").val("20150922");
                        this.$(".btnList").trigger("click");
                    });
                }
                break;
            case "retrieveCoupangSectionSpeed": // 통-쿠팡구간별속도내역
                    fExecLogin(["type=group","userID=coupang"],function(){
                        this.$("[name='fromdate']").val("20150331");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveCoupangCardTotalSum": // 통-쿠팡카드사별집계내역
                    fExecLogin(["type=group","userID=coupang"],function(){
                        this.$("[name='fromdate']").val("20150401");
                        this.$("[name='todate']").val("20150401");
                        this.$("[name='capfromdate']").val("20150402");
                        this.$("[name='captodate']").val("20150402");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveCoupangSearch": // 통-쿠팡매출조회
                    fExecLogin(["type=group","userID=coupang"],function(){
                        this.$("[name='fromdate']").val("20150101");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveVmoni": // 통-쿠팡결제현황 모니터링
                    fExecLogin(["type=mert","userID=coupang"],function(){
                        this.$("#p_date").val("20150422");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveOpenMarketTradeList": // 통-오픈마켓거래내역조회
                    fExecLogin(["type=mert","userID=dacomnpg"],function(){
                        this.$("[name='fromdate']").val("20100101");
                        this.$("[name='todate']").val("20140101");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveMertAuthCaptureSum": // 통-승인/매입집계조회
                    fExecLogin(["type=mert","userID=dacomst7"],function(){
                        this.$("#fromdt").val("20150525");
                        this.$("#todt").val("20150625");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveDivideTrxSumForMert": // 통-전체거래내역조회(분할)
                if ( window.userID == "O11208677976" ) {
                    fExecLogin(["type=mert","userID=O11208677976"],function(){
                        this.$("[name='fromdt']").val("20150402");
                        this.$("[name='todt']").val("20150702");
                        this.$(".btnList").trigger("click");
                    });
                } else if ( window.userID == "G11208677976" ) {
                    fExecLogin(["type=group","userID=G11208677976"],function(){
                        this.$("[name='fromdt']").val("20150430");
                        this.$("[name='todt']").val("20150430");
                        this.$(".btnList").trigger("click");
                    });
                }
                break;
            case "retrieveTotalList": // 통-전체거래내역_건별조회
                if ( window.userID == "namuinternet" ) {
                    fExecLogin(["type=mert","userID=namuinternet"],function(){
                        this.$("[name='frdate']").val("20150430");
                        this.$("[name='todate']").val("20150430");
                        this.$("[name='transactionid']").val("namui2015043002580261393");
                        this.$(".btnList").trigger("click");
                    });
                } else if ( window.userID == "wemake" ) {
                    fExecLogin(["type=group","userID=wemake"],function(){
                        this.$("[name='frdate']").val("20150430");
                        this.$("[name='todate']").val("20150430");
                        this.$("[name='transactionid']").val("namui2015043002580261393");
                        this.$(".btnList").trigger("click");
                    });
                }
                break;
            case "retrieveCardList": // 통-전체거래내역조회(카드사별)
                if ( window.userID == "namuinternet" ) {
                    fExecLogin(["type=mert","userID=namuinternet"],function(){
                        this.$("[name='frdate']").val("20150430");
                        this.$("[name='todate']").val("20150430");
                        this.$(".btnList").trigger("click");
                    });
                } else if ( window.userID == "wemake" ) {
                    fExecLogin(["type=group","userID=wemake"],function(){
                        this.$("[name='frdate']").val("20150430");
                        this.$("[name='todate']").val("20150430");
                        this.$(".btnList").trigger("click");
                    });
                }
                break;
            case "retrieveSettleCoupangCard": // 통-쿠팡카드사승인통계
                    fExecLogin(["type=group","userID=coupang_yongd"],function(){
                        this.$("[name='frdt']").val("20150101");
                        this.$("[name='todt']").val("20150101");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveServiceList": // 거래기준 주요 risk 관리 업체현황 
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$("[name='fromdt']").val("20141020");
                        this.$("[name='todt']").val("20141020");
                        this.$("[name='paytype']").val("SC0060");
                        this.$("[name='sumtype']").val("busi");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveAdReport101": // 상점 당기 미수금 내역
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$("[name='fromdt']").val("20150609");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveMertList": // 상점 미수 데이타 조회
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$("[name='mertid']").val("cns_mk1585");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveAdReport102": // 상점 최종 미수금 현황
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveAdReport7": // 상점미지급수동 거래내역
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$("[name='mertid']").val("coupang");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveAdReport12": // 업체별 미수금누계
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveBatchExceptMertList": // 역환상점 입금예정액 조회
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$("[name='mertid']").val("purelati");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveAdReport20": // 은행별 입금내역 
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$("#fromdt").val("20020801");
                        this.$("#todt").val("20020903");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveAdReport8": // 일자별 상점지급 내역
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$("[name='mertid']").val("coupang");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retireveAdStatistics33": // 지급보류 및 한도초과에따른 대금잔액 현황
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveAdReport5": // 지급예정 및 지급리스트 
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$("[name='mertid']").val("coupang");
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveAdReport13": // 한도초과 미지급액 누계 
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$(".btnList").trigger("click");
                    });
                break;
            case "retrieveTrxRefundAdjustList": // 환불정산내역
                    fExecLogin(["logintype=uplus","userid=pgtest01"],function(){
                        this.$(".btnList").trigger("click");
                    });
                break;
            default:
                fExecLogin(["type=group","userID=dacomGroup"],function(){
                    this.$(".btnList").trigger("click");
                });
                break;
        }
})();
// jquery를 로딩하고 로딩완료시 callback 실행
function get_jquery_and_go(callback)
{
    log("info.jquery_js_url : " + info.jquery_js_url);
    // jQuery가 이미 로드되어 있으면 그냥 callback() 실행
    if (typeof window.jQuery != 'undefined') {
        callback();
    }
    // jQuery가 로드되어 있지 않음
    else {
		var d = self.document||info.iframe.document || info.iframe.contentWindow.document;
		info.d = d;
        // <script> element를 하나 생성
        var script =  d.createElement('script');
        script.type = 'text/javascript';
        // jQuery 로딩 완료 후 callback() 실행
        // IE
        if (script.readyState) {
            script.onreadystatechange = function(){
                if (script.readyState=='loaded' || script.readyState=='complete') {
                    log("script.onreadystatechange");
                    script.onreadystatechange = null;
                    callback();
                }
            }
        }
        // 기타 브라우저
        else {
            script.onload = function(){
                log("script.onload");
                callback();
            }
        }
        log( script );
//        script.src = 'http://code.jquery.com/jquery-latest.min.js';
        script.src = info.jquery_js_url;
//        log(info.iframe);
//        log( document.getElementsByTagName('head')[0] );
		log(self.document);
//        d.getElementsByTagName('head')[0].appendChild(script);
		self.document.getElementsByTagName('head')[0].appendChild(script);
    }
};
