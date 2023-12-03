#TITLE=jsp-gs
#INFO
New Cliptext library
#SORT=n

#T=Base64.base64Encode, Encoder
    out.println("appendParam : " + appendParam + "<BR>");
    out.println("eventUri : " + eventUri + "<BR>");
    out.println("Base64.encode : introducerId : " + Base64.base64Encode(ecuserid) + "<BR>");
    out.println("Base64.decode : introducerId : " + Base64.base64Decode(Base64.base64Encode(ecuserid)) + "<BR>");
    out.println("introducerId : " + ecuserid + "<BR>");
    out.println("Encoder : introducerId : " + Encoder.encode(ecuserid) + "<BR>");
    out.println("Decoder : introducerId : " + Decoder.decode(Encoder.encode(ecuserid)) + "<BR>");

#T=콕_공유_증가처리_로그인필수
<%@page contentType="text/html; charset=EUC-KR" pageEncoding="EUC-KR" %>
<%@page import="gseshop.common.AppCheckCookieUtil"%>
<%@page import="gseshop.framework.utils.StringUtils"%>
<%@page import="gseshop.services.modules.LoginModule"%>
<%@page import="gshs.eshop.common.ESPCurrTime"%>
<%@page import="java.sql.Timestamp"%>
<%@page import="com.lgeshop.ec.Base64"%>

<jsp:useBean id="goods"         class="com.lgeshop.ec.bneip_mainDisplay"            scope="page" />
<jsp:useBean id="apply"         class="com.lgeshop.ec.promo.PromotionUserDAO"       scope="page" />
<jsp:useBean id="promoShare"    class="com.lgeshop.ec.promo.PromotionUser"          scope="page" />

<%@ include file="/event/common/confCheck.jsp" %>
<%!
public String katokDecode(String str) {
    str = Base64.base64Decode(str);
    str = str.substring(2);
    str = Base64.base64Decode(str);
    return str;
}
%>
<%
    response.setHeader("Content-Control", "no-cache");
    response.setHeader("Cache-Control", "max-age=0");
    response.setHeader("Pragma", "no-cache");
    String introducerId = StringUtils.getString(request.getParameter("introducerId"), "");

    int promoNum2 = 459253; // 공유 프로모션

    if (isApp){
        Timestamp forTime = ESPCurrTime.getDBTimestamp();
        String forDate = (forTime.getYear()+1900)+(forTime.getMonth()<9?"0":"")+(forTime.getMonth()+1)+(forTime.getDate()<10?"0":"")+forTime.getDate();
        try {
            introducerId = katokDecode(introducerId);
        } catch(Exception e) {
            introducerId = "";
        }

        String appendParam  = "";
        if (request.getServerName().indexOf("mt") != -1 || request.getServerName().indexOf("sm") != -1 || request.getServerName().indexOf("local") != -1) { // 로컬이나 스테이지 서버의 경우 테스트 파람을 받을 수 있다
            if("Y".equals(StringUtils.NVL(request.getParameter("testYn"), ""))) { // appDn 파람이 Y일경우
                addParam("testYn", "Y");
                appendParam = ("".equals(getTestParam())?"":"?"+getTestParam());
            }
        }

        returnurl = LoginModule.getUrlLogin(request, response,
                                            request.getRequestURI()
                                          + appendParam
                                          + (appendParam.indexOf("?")==-1?"?":"&")
                                          + "introducerId=" + StringUtils.getString(request.getParameter("introducerId"), "")
                    );

        if (!isLogin) {
            response.sendRedirect(returnurl);
        } else {
            if ( !"".equals(introducerId) && !introducerId.equals(ecuserid) ) { // valid
                int cnt = apply.getUserPromotionChoieCount(promoNum2, introducerId, "콕콕콕 이벤트" , ecuserid, forDate, forDate, "A");
                if ( cnt == 0 ) { // 중복아닌경우.
                    promoShare.processRequest(request);
                    promoShare.setEcuserid(introducerId     ); // 공유자 ecuserid
                    promoShare.setPromoNum(promoNum2        );
                    promoShare.setAnswer1("콕콕콕 이벤트"   );
                    promoShare.setAnswer2(ecuserid          );
                    promoShare.setAnswer3("공유하기"        );
                    apply.save(promoShare);
                }
            }
            String redirectUrl = Constant.getString("server.uri") + "/event/2014_04/apply_cok.jsp"
                               + appendParam
            ;
            response.sendRedirect(redirectUrl);
        }
    }
%>
#T=단건 프로모션 조회
boolean isEntered = false;
if ( true ) {
    //msg  = "pPromoNum     : " + pPromoNum       +"\n";
    //msg += "movieTitle  : " + movieTitle    +"\n";
    //out.println("msg  : " + msg + "<BR>" );
    ArrayList<PromotionUser> myPromoList;
    myPromoList = apply.getApplyList(promoNum, 0
            , null
            , null
            , null
            , "USER_ANSWER2"
            , String.valueOf(pPromoNum)
            , 0
            , "USER_NUM"
            , "ASC"
    );
    if ( myPromoList.size() > 0 ) {
        isEntered = true;
    }
}
#T=조회_저장 샘플
<%@ page pageEncoding="utf-8" %>
<%@page import="java.util.ArrayList"%>
<%@page import="com.lgeshop.ec.promo.PromotionUser"%>
<%@page import="com.lgeshop.ec.promo.Promotion" %>
<%@page import="gseshop.common.AppCheckCookieUtil" %>
<%@page import="gseshop.framework.handler.Constant" %>
<%@page import="gseshop.framework.utils.NumberUtils"%>
<%@page import="gseshop.framework.utils.StringUtils"%>
<%@page import="gseshop.services.modules.LoginModule"%>
<%@page import="gshs.eshop.common.ESPCurrTime" %>
<%@page import="java.sql.Timestamp" %>
<jsp:useBean id="goods"         class="com.lgeshop.ec.bneip_mainDisplay"            scope="page" />
<jsp:useBean id="apply"         class="com.lgeshop.ec.promo.PromotionUserDAO"       scope="page" />
<jsp:useBean id="chkcookie" class="com.lgeshop.ec.cbeans.CookieMgr" scope="page">
    <jsp:setProperty name="chkcookie" property="*" />
</jsp:useBean>
<jsp:useBean id="limitChk"      class="com.lgeshop.ec.bneip_mainDisplay"            scope="page" />

<xmp>
<%
    chkcookie.processRequest(request);

    int promoNum1 = 458842; // 콕 프로모션
    int promoNum2 = 458843; // 공유 프로모션
    int promoNum3 = 458844; // 구매 프로모션

    String ecuserid = "0";
    ecuserid = chkcookie.getEcUser();

                int locSeq = 396346;
                if (request.getServerName().indexOf("mt") != -1 || request.getServerName().indexOf("sm") != -1 || request.getServerName().indexOf("local") != -1) { // 로컬이나 스테이지 서버의 경우 테스트 파람을 받을 수 있다
                    if("Y".equals(StringUtils.NVL(request.getParameter("testYn"), ""))) { // testYn 파람이 Y일경우
                        locSeq = 396369;
                    }
                }
                goods.setLocSeq(locSeq);
                goods.processRequest(request);

                int promoCnt = 0;
                int cokGoalCnt = 0;
                boolean saleFlag = false;
                boolean endFlag = false;
                boolean myCokFlag = false;
/*
WHERE PROMO_NUM  = 458844 -- 구매 프로모션 ID
AND DBSTS        = 'A'
AND USER_ANSWER2 = '12996415' -- [콕] 프라다 여성용 중지갑 1M1225 SAFFIANO METAL IBISCO,AND ECUSERID = '487267294',;           AND USER_ANSWER2 = '12996415' -- [콕] 프라다 여성용 중지갑 1M1225 SAFFIANO METAL IBISCO
AND ECUSERID     = '2002522723'
*/
ecuserid = "200397"; // test fix
ecuserid = "2001347732"; // test fix

                out.println("locSeq     : " + locSeq    );
                out.println("ecuserid   : " + ecuserid  );
                out.println("------------------------------------" );
                out.println("------------------------------------" );
                out.println("goods.getSize() : " + goods.getSize() );

                for(int i = 0; i < goods.getSize(); i++) {
                    String prdCode = String.valueOf(goods.getLinkNum(i));

// ------------------------------------- 구매제한 체크 - 2014-03-27
                // 구매제한 조회
                int limitLocSeq = 396363; // 구매제한 LOC SEQ [ 이벤트 구매제한 체크 ]
                if (request.getServerName().indexOf("mt") != -1 || request.getServerName().indexOf("sm") != -1 || request.getServerName().indexOf("local") != -1) { // 로컬이나 스테이지 서버의 경우 테스트 파람을 받을 수 있다
                    if("Y".equals(StringUtils.NVL(request.getParameter("testYn"), ""))) { // testYn 파람이 Y일경우
                        limitLocSeq = 396369; // 테스트 구매제한 체크를 위해. 콕콕콕 이벤트 - 테스트
                    }
                }
                limitChk.setLocSeq(limitLocSeq);
                limitChk.processRequest(request);
// ------------------------------------- 구매제한 체크 - 2014-03-27

// ------------------------------------- 구매제한 체크 - 2014-03-27
                    int limitPrdCnt = 0;
                    for(int j = 0; j < limitChk.getSize(); j++) {
                        String chkPrdCode = String.valueOf(limitChk.getLinkNum(j));
                        /*
                        com.lgeshop.ec.common.Log.info( "prdCode / chkPrdCode / limitChk.getRemark6(" + j + ") : "
                                                     + StringUtils.getString(prdCode)   + " / "
                                                     + StringUtils.getString(chkPrdCode)   + " / "
                                                     + limitChk.getRemark6(j)
                        );
                        */
                        if(StringUtils.getString(prdCode).equals(chkPrdCode)) { // 구매 제한 수량을 얻기위해.
                            try {
                                com.lgeshop.ec.common.Log.info( "limitChk.getRemark6(j) : " + chkPrdCode );
                                limitPrdCnt = Integer.parseInt(StringUtils.getString(limitChk.getRemark6(j),"0"));
                            } catch(Exception e) {}
                            break;
                        } else {
                        }
                    }

                    limitPrdCnt = 17; // test fix

                    out.println("제한 수량 : " + prdCode + " : " + limitPrdCnt );
                    ArrayList<PromotionUser> buyPromoList;

                    if (request.getServerName().indexOf("mt") != -1 || request.getServerName().indexOf("sm") != -1 || request.getServerName().indexOf("local") != -1) { // 로컬이나 스테이지 서버의 경우 테스트 파람을 받을 수 있다
                        buyPromoList = apply.getApplyList(promoNum3, 0
                                , null
                                , null
                                , null
                                , "USER_ANSWER2"
                                , String.valueOf(goods.getRemark7(i))
                                , 0
                                , "USER_NUM"
                                , "ASC"
                        );
                        out.println("기준 상품 코드 : " + String.valueOf(goods.getRemark7(i)) );
                    } else {
                        buyPromoList = apply.getApplyList(promoNum3, 0
                                , null
                                , null
                                , null
                                , "USER_ANSWER2"
                                , prdCode
                                , 0
                                , "USER_NUM"
                                , "ASC"
                        );
                        out.println("기준 상품 코드 : " + prdCode );
                    }
                    boolean buyingAble = false;
                    int idx = 0;
                    int myPos = -1;
                    for (PromotionUser s : buyPromoList) {
                        if ( limitPrdCnt < idx + 1 ) {
                            break;
                        }
                        com.lgeshop.ec.common.Log.info( "idx / ecuserid : " + idx + " / " + s.getEcuserid());
                        String lEcuserId = String.valueOf(s.getEcuserid());
                        if ( lEcuserId.equals(ecuserid) ) {
                            buyingAble = true;
                            myPos = idx + 1;
                            break;
                        }
                        idx++;
                    }
                    ArrayList<PromotionUser> minePromoList;
                    out.println("buyingAble / myPos : " + buyingAble + " / " + myPos);

                    if ( !buyingAble ) { // 구매불가
                        if (request.getServerName().indexOf("mt") != -1 || request.getServerName().indexOf("sm") != -1 || request.getServerName().indexOf("local") != -1) { // 로컬이나 스테이지 서버의 경우 테스트 파람을 받을 수 있다
                            minePromoList = apply.getApplyList(promoNum3, StringUtils.getInt(ecuserid)
                                        , null
                                        , null
                                        , null
                                        , "USER_ANSWER2"
                                        , String.valueOf(goods.getRemark7(i))
                                        , limitPrdCnt
                                        , "USER_NUM"
                                        , "ASC"
                            );
                        } else {
                            minePromoList = apply.getApplyList(promoNum3, StringUtils.getInt(ecuserid)
                                        , null
                                        , null
                                        , null
                                        , "USER_ANSWER2"
                                        , prdCode
                                        , limitPrdCnt
                                        , "USER_NUM"
                                        , "ASC"
                            );
                        }
/*
*/
                        if(minePromoList != null && minePromoList.size() > 0){
                            PromotionUser updatePromotionUser = (PromotionUser)minePromoList.get(0);
                            updatePromotionUser.setDbsts("D"); // 삭제
                            out.println("execute update : " + updatePromotionUser);
                            //apply.updateByUserNum(updatePromotionUser);
                        }
                    }
// ---------------------------------------- 구매제한 체크 - 2014-03-27
out.println("-----------------------------------" + "\n" );
                }
%>
</xmp>
#T=if (request.getServerName().indexOf("mt") != -1 || request.getServerName().indexOf("local") != -1) {
    if (request.getServerName().indexOf("mt") != -1 || request.getServerName().indexOf("local") != -1) { // 로컬이나 스테이지 서버의 경우 테스트 파람을 받을 수 있다
        pageTitle = "모바일 핫딜 이벤트!";
        newStDate = "2014-04-01";
        newEnDate = "2014-04-03";
        oldStDate = "2010-01-01";
        oldEnDate = "2014-03-31";
        promoNum   = 458997;
    }
//out.println("promoNum  : " + promoNum+ "<BR>" );

#T=gseshop.framework.utils.StringUtils
<%@page import="gseshop.framework.utils.StringUtils"%>
StringUtils.getString(^!);
#T=com.lgeshop.ec.cbeans.Decoder.decode(returnurl)
com.lgeshop.ec.cbeans.Decoder.decode(returnurl)
#T=com.lgeshop.ec.common.Log.info( "key / val : " + key + " / "  + val );
com.lgeshop.ec.common.Log.info( "key : " + ^! );

#T=scrollTop
	self.location.hash='forLayer';
	$(window).scrollTop(0);
#T==================================================
=================================================
#T=임베드 플레이어
            <%
            String Agent=request.getHeader("USER-AGENT");   //브라우져의 버젼을 알 수있다 흐흐
            if(Agent.indexOf("MSIE")>=0) {
            %>
            <OBJECT ID="MPlayer" width="0" height="0"
              CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" type='application/x-oleobject' >
                <PARAM name="autoStart" value="0">
                <param name="EnableContextMenu " value="1">
                <PARAM name="volume" value="90">
            </OBJECT>
            <%
            } else {
            %>
            <OBJECT id="MPlayer"
            type="application/x-ms-wmp"
            width="0" height="0" >
                <PARAM name="autoStart" value="0">
                <param name="EnableContextMenu " value="1">
                <PARAM name="volume" value="90">
            </OBJECT>
            <%
            }
            %>
#T==== JAVA ==============================================
=================================================
#T=LOGIN_CHECK = false;
<%
LOGIN_CHECK = false;
%>

#T=out.println(" : " + );
out.println("^!  : " + + "<BR>" );
#T=String p_grade = SUtil.empty(request.getParameter("p_grade"));
String p_grade = SUtil.empty(request.getParameter("p_grade"));

#T=jsp페이지 헤더
<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@ include file = "/include/initiate_xhr.inc" %>
<%
String s_sub = SUtil.empty(request.getParameter("id"));
       s_sub = s_sub.equals("")?"green_01":s_sub;
String[] sInfo = s_sub.split("_");
if ( sInfo.length == 2 ) {
    out.println(" sInfo : " + sInfo.length + "<BR>" );
%>

#T=SUtil.make(request.getParameter("pageNum"),1);
SUtil.make(request.getParameter("pageNum"),1^!);
#T=String subject = SUtil.empty(request.getParameter("subject"));// 제목
String subject = SUtil.empty(request.getParameter("subject"));// 제목

#T=String sp = File.separator;
String sp = File.separator;

#T=String reqURL = request.getRequestURL().toString();
String reqURL = request.getRequestURL().toString();
#T=StringUtils.defaultString(multi.getParameter("title"       ));
String title        = StringUtils.defaultString(multi.getParameter("title"       ));
#T=<%@ page import="java.io.*"%>
<%@ page import="java.io.*"%>

#T=<%@ include file = "/include/html_study_top_menu.inc" %>
<%@ include file = "/include/html_study_top_menu.inc" %>
#T=<%@ include file 
<%@ include file = "/include/html_qs_search_box.inc" %>

#T=<%@ include file = "/include/html_ac_study_top_link.inc" %>
<%@ include file = "/include/html_ac_study_top_link.inc" %>

#T=<jsp:include
<jsp:include page="/bbs/edu_ac_gongji_view.jsp" flush="true">
<jsp:param name="pageNum" value="<%=pageNum%>" />
<jsp:param name="pageNum" value="<%=pageNum%>" />
<jsp:param name="num" value="<%=num%>" />
<jsp:param name="list_gb" value="<%=list_gb%>" />
</jsp:include>
#T=public jsp method
<%!
    public String getStrSelected(String sData,String data) {
        sData = sData == null?"":sData;
        data = data == null?"":data;
        return sData.equals(data) ? "selected" : "";
    }
    public String fixedNull(String data) {
        return data != null? data: "" ;
    }
%>

#T=public method - width db
public int getLimitStdCnt (String acId) {
    int rtn = 0;
    //System.out.println("SELECT MAX(AC_ID) AC_ID, IF(MAX(YYMM)=YYMM,PAY_MAN_CNT,0) PAY_MAN_CNT FROM payment WHERE AC_ID = " + acId + "<BR>" );
    try {
        db.CreatePstmt( "SELECT MAX(AC_ID) AC_ID, IF(MAX(YYMM)=YYMM,PAY_MAN_CNT,0) PAY_MAN_CNT FROM payment WHERE AC_ID= ?" );
        db.SetPstmtString( 1, acId);
        rs = db.ExecQuery();
        while (rs.next()) {
            //System.out.println("_rtn  : " + _rtn+ "<BR>" );
            rtn = SUtil.make(rs.getString("PAY_MAN_CNT"),1);
        }
    } catch(Exception e) {
        return(-1);
    }
    return rtn;
}
#T=message_box1
<jsp:include page="/include/message_box1.jsp" flush="true">
<jsp:param name="p_message" value="검색된 문제가 없습니다." />
<jsp:param name="p_ok" value="Effect.twinkle(document.qsSearchForm.qs_id);document.qsSearchForm.qs_id.focus();" />
</jsp:include>
#T=Hashtable hashMinDt = new Hashtable();
Hashtable hashMinDt = new Hashtable();
hashMinDt.put(rs3.getString("ST_ID"),rs3.getLong("MIN_DT"));

long min_dt = hashMinDt.get(rs.getString("ST_ID"))!=null?(Long)hashMinDt.get(rs.getString("ST_ID")):0;

#T=List = ArrayList Join
    List<String> inBans = new ArrayList<String>();
.
.
.

    while (rs.next()) {
        String[] data = new String[2];
        data[ 0] = rs.getString("BAN_ID"   ); //  0
        data[ 1] = rs.getString("BAN_NAME" ); //  1
        dataList2.add(data);
        inBans.add(data[ 0]);
    }

    String inBan[] = inBans.toArray(new String[0]);
.
.
.

    where.append(" AND a.BAN_ID in (" + StringUtil.join(",", inBan) + ")");
#T=DecimalFormat f1 = new DecimalFormat("0.0"); 
<%@ page import="java.text.*" %>

DecimalFormat f1 = new DecimalFormat("0.0"); 
DecimalFormat f2 = new DecimalFormat("0"); 

#T=String.format("%04d", 1)
String.format("%04d", 1)
#T=bestScore = Math.round(
        bestScore = Math.round( Float.parseFloat(list.get(j)[8]) / 6 * 1000 )/10f;
#T=오늘날짜
<%
Calendar calS = Calendar.getInstance( );
calS.add(Calendar.DAY_OF_MONTH,-10);
String s_s_date = String.format("%d-%02d-%02d", calS.get(Calendar.YEAR),calS.get(Calendar.MONTH) + 1,calS.get(Calendar.DAY_OF_MONTH));
Calendar calE = Calendar.getInstance( );
//calE.add(Calendar.DAY_OF_MONTH,10);
String s_e_date = String.format("%d-%02d-%02d", calE.get(Calendar.YEAR),calE.get(Calendar.MONTH) + 1,calE.get(Calendar.DAY_OF_MONTH));
%>
#T=totalCnt2 = db.ExecOneFieldInt( gsbSQL.toString() );
	/** 전체 학원수 */
	gsbSQL.append("SELECT count(*) AS cnt FROM ACADEMY WHERE JOIN_GB=1 ");
	gsbSQL.append("  AND BRCH_ID != " + JUST10_BRCH_ID); // just10 지사 제외
	if( !brch.equals("") ) gsbSQL.append("   AND BRCH_ID='").append( brch ).append("' ");
	totalCnt2 = db.ExecOneFieldInt( gsbSQL.toString() );
#T=조회
<%
//*************************************************************************************************/
//
//      파 일 명    : result_list.jsp
//
//      작 성 자    : 김 지 훈(softm@nate.com)
//
//      작 성 일    : 2011-05-06
//
//      수 정 일    : 2011-05-06
//
//      설    명     : 내신문법특강 학습결과
//
//                                                  Copyright(C) 2011  해브영어 Co., Ltd.
//*************************************************************************************************/
%>

<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@ include file = "/include/initiate_xhr.inc" %>
<%@ page import="com.have.var.*" %>
<%@ page import="java.util.Calendar" %>
<%
String msg = "";
String s_sub_list = SUtil.empty(request.getParameter("s_sub_list"   ));
String s_exam_gb  = SUtil.empty(request.getParameter("s_exam_gb"    ));
String s_ban_id   = SUtil.empty(request.getParameter("s_ban_id"     ));
String s_kind     = SUtil.empty(request.getParameter("s_kind"       ));
String s_search   = SUtil.empty(request.getParameter("s_search"     ));

String s_lcd        = SUtil.empty(request.getParameter("s_lcd"));
String s_mcd        = SUtil.empty(request.getParameter("s_mcd"));
String s_scd        = SUtil.empty(request.getParameter("s_scd"));
String s_ctype_cd   = SUtil.empty(request.getParameter("s_ctype_cd"));
String s_level_cd   = SUtil.empty(request.getParameter("s_level_cd"));

String s_s_date = SUtil.empty(request.getParameter("s_s_date"));
String s_e_date = SUtil.empty(request.getParameter("s_e_date"));

Calendar calS = Calendar.getInstance( );
calS.add(Calendar.DAY_OF_MONTH,-30);
Calendar calE = Calendar.getInstance( );
//calE.add(Calendar.DAY_OF_MONTH,10);

s_s_date = s_s_date.equals("")?String.format("%d-%02d-%02d", calS.get(Calendar.YEAR),calS.get(Calendar.MONTH) + 1,calS.get(Calendar.DAY_OF_MONTH)):s_s_date;
s_e_date = s_e_date.equals("")?String.format("%d-%02d-%02d", calE.get(Calendar.YEAR),calE.get(Calendar.MONTH) + 1,calE.get(Calendar.DAY_OF_MONTH)):s_e_date;

// 페이지 사이즈 설정
int pageSize =SUtil.make(request.getParameter("pageSize"), 2);
int pageNum = SUtil.make(request.getParameter("pageNum"), 1);
int startNum = (pageNum-1) * pageSize;
int totalSize = 0;

List<String[]> dataList = new ArrayList<String[]>();
List<String[]> dataList2 = new ArrayList<String[]>();

try {
    if ( !ss_mem_gb.equals("2") && !ss_mem_gb.equals("3") ) throw new Exception("권한이 없습니다");

    db = new DBM(true);
    //db.Connect();
    gsbSQL = new StringBuffer();
    StringBuffer where = new StringBuffer();

    /* 반조회 --------------------------------------------------------------------- */
    List<String> inBans = new ArrayList<String>();
    gsbSQL.setLength(0);
    gsbSQL.append(" SELECT ");
    gsbSQL.append("  BAN_ID  ,");
    gsbSQL.append("  BAN_NAME ");
    gsbSQL.append(" FROM " + TABLE.BAN);
    gsbSQL.append(" WHERE AC_ID = '" + ss_ac_id + "'");
    gsbSQL.append(" AND STATE = 1 ");
    gsbSQL.append(ss_mem_gb.equals("3")?" AND TCH_ID = '" + ss_mem_id + "'":"");

    rs = db.ExecQuery(gsbSQL.toString());
    while (rs.next()) {
        String[] data = new String[2];
        data[ 0] = rs.getString("BAN_ID"   ); //  0
        data[ 1] = rs.getString("BAN_NAME" ); //  1
        dataList2.add(data);
        inBans.add(data[ 0]);
    }
    String inBan[] = inBans.toArray(new String[0]);
    if ( ss_mem_gb.equals("3") ) { // 교사
	    if ( inBan.length>0 ) {
	        where.append(" AND a.BAN_ID in (" + StringUtil.join(",", inBan) + ")");
	    } else {
	        where.append(" AND a.BAN_ID = 'XX' ");
	    }
    }
    /* --------------------------------------------------------------------- 반조회 */

    where.append(!s_exam_gb.equals("")?" AND   a.EXAM_GB = '" + s_exam_gb +"'":""); // 시험구분
    where.append(!s_ban_id.equals("")?" AND   a.ban_id = '" + s_ban_id +"'":""); // 반
    where.append(!s_lcd.equals("")?" AND   SUBSTRING(a.LECT_CD, 3, 1) = '" + s_lcd.substring(1) +"'":""); // 학년
    where.append(!s_mcd.equals("")?" AND   SUBSTRING(a.LESSON_CD, 4, 2) = '" + s_mcd +"'":""); // 출판사
    where.append(!s_scd.equals("")?" AND   SUBSTRING(a.LESSON_CD, 6, 2) = '" + s_scd +"'":""); // Lesson
    where.append(" AND   a.REG_DATE BETWEEN '" + s_s_date + " 00:00:00" + "' AND '" + s_e_date + " 23:59:59" + "'" );
    if ( !s_kind.equals("") && !s_search.trim().equals("") ) {
        where.append(" AND   " + s_kind + " LIKE '" + s_search +"%'" );
    }


    gsbSQL.setLength(0);
    gsbSQL.append("SELECT ");
    gsbSQL.append("     c1.CODE_NAME                    CODE_NM1    ,"); //  0
    gsbSQL.append("     SUBSTRING(a.LECT_CD, 3, 1)      GRADE_GB    ,"); //  1
    gsbSQL.append("     c2.CODE_NAME                    CODE_NM2    ,"); //  2
    gsbSQL.append("     c3.CODE_NAME                    CODE_NM3    ,"); //  3
    gsbSQL.append("     c4.LECT_NAME                    LECT_NAME   ,"); //  4
    gsbSQL.append("     a.MEM_ID                        MEM_ID      ,"); //  5
    gsbSQL.append("     a.LECT_CD                       LECT_CD     ,"); //  6
    gsbSQL.append("     a.SEQ                           SEQ         ,"); //  7
    gsbSQL.append("     a.LESSON_CD                     LESSON_CD   ,"); //  8
    gsbSQL.append("     a.EXAM_GB                       EXAM_GB     ,"); //  9
    gsbSQL.append("     a.TOT_QST_CNT                   TOT_QST_CNT ,"); // 10
    gsbSQL.append("     a.CORRECT_CNT                   CORRECT_CNT ,"); // 11
    gsbSQL.append("     a.SCORE                         SCORE       ,"); // 12
    gsbSQL.append("     a.AC_ID                         AC_ID       ,"); // 13
    gsbSQL.append("     a.AC_NAME                       AC_NAME     ,"); // 14
    gsbSQL.append("     a.MEM_NAME                      MEM_NAME    ,"); // 15
    gsbSQL.append("     a.MEM_GB                        MEM_GB      ,"); // 16
    gsbSQL.append("     a.BAN_ID                        BAN_ID      ,"); // 17
    gsbSQL.append("     a.BAN_NAME                      BAN_NAME    ,"); // 18
    gsbSQL.append("     date_format(a.REG_DATE,'%m/%d %H:%i')                      REG_DATE     "); // 19
    gsbSQL.append(" FROM naesin_grammar_lesson_answer_result a       ");
    gsbSQL.append(" LEFT OUTER JOIN CODE c1 ON (SUBSTRING(a.LESSON_CD, 1, 1) = c1.KIND AND SUBSTRING(a.LESSON_CD, 2, 2) = c1.LCD AND c1.MCD = '00' AND c1.SCD = '00' ) ");
    gsbSQL.append(" LEFT OUTER JOIN CODE c2 ON (SUBSTRING(a.LESSON_CD, 1, 1) = c2.KIND AND SUBSTRING(a.LESSON_CD, 2, 2) = c2.LCD AND SUBSTRING(a.LESSON_CD, 4, 2) = c2.MCD AND c2.SCD = '00' ) ");
    gsbSQL.append(" LEFT OUTER JOIN CODE c3 ON (SUBSTRING(a.LESSON_CD, 1, 1) = c3.KIND AND SUBSTRING(a.LESSON_CD, 2, 2) = c3.LCD AND SUBSTRING(a.LESSON_CD, 4, 2) = c3.MCD AND SUBSTRING(a.LESSON_CD, 6, 2) = c3.SCD )");
    gsbSQL.append(" LEFT OUTER JOIN NAESIN_GRAMMAR_LECT_MAST c4  ON (a.LECT_CD = c4.LECT_CD)");
    gsbSQL.append(" WHERE AC_ID = ?");
    gsbSQL.append(where);
    gsbSQL.append(" ORDER BY a.REG_DATE DESC");
    gsbSQL.append(" LIMIT ?,?");

    db.CreatePstmt( gsbSQL.toString() );
    db.SetPstmtString(1,ss_ac_id);
    db.SetPstmtInt(2,startNum);
    db.SetPstmtInt(3,pageSize);
    rs = db.ExecQuery();
    while (rs.next()) {
        String[] data = new String[20];
        data[ 0] = rs.getString("CODE_NM1"   ); //  0
        data[ 1] = rs.getString("GRADE_GB"   ); //  1
        data[ 2] = rs.getString("CODE_NM2"   ); //  2
        data[ 3] = rs.getString("CODE_NM3"   ); //  3
        data[ 4] = rs.getString("LECT_NAME"  ); //  4
        data[ 5] = rs.getString("MEM_ID"     ); //  5
        data[ 6] = rs.getString("LECT_CD"    ); //  6
        data[ 7] = rs.getString("SEQ"        ); //  7
        data[ 8] = rs.getString("LESSON_CD"  ); //  8
        data[ 9] = rs.getString("EXAM_GB"    ); //  9
        data[10] = rs.getString("TOT_QST_CNT"); // 10
        data[11] = rs.getString("CORRECT_CNT"); // 11
        data[12] = rs.getString("SCORE"      ); // 12
        data[13] = rs.getString("AC_ID"      ); // 13
        data[14] = rs.getString("AC_NAME"    ); // 14
        data[15] = rs.getString("MEM_NAME"   ); // 15
        data[16] = rs.getString("MEM_GB"     ); // 16
        data[17] = rs.getString("BAN_ID"     ); // 17
        data[18] = rs.getString("BAN_NAME"   ); // 18
        data[19] = rs.getString("REG_DATE"   ); // 19
        dataList.add(data);
    }

    gsbSQL.setLength(0);
    gsbSQL.append(" SELECT ");
    gsbSQL.append(" COUNT(*) ");
    gsbSQL.append(" FROM naesin_grammar_lesson_answer_result a");
    gsbSQL.append(" WHERE a.AC_ID = '" + ss_ac_id + "'" );
    gsbSQL.append( where );
    totalSize = db.ExecOneFieldInt( gsbSQL.toString() );
//out.println(" gsbSQL.toString() : " + gsbSQL.toString() + "<BR>" );
//out.println("totalSize  : " + totalSize + "<BR>" );

} catch( Exception e){
    msg = e.getMessage();
} finally{
    ClearDB();
}
%>
<%
if ( msg.equals("") ) {
    if ( !s_sub_list.equals("1") ) {
%>
<table class=prog_title border="0" cellspacing=0 cellpadding=0><tr><td>내신문법 문제풀이</td></tr></table>
<form name="sform" method="post" onSubmit="return fSearch(0);">
    <input type="hidden" name="pageNum" value="<%=pageNum %>">

<table border=1 cellpadding=0 cellspacing=0 class='tbl_3'>
<colgroup>
<col width='85'/>
<col width='100'/>
<col width=''/>
</colgroup>
        <tr>
        <td colspan=2>
        <select name=s_exam_gb onchange="goPage(1);">
            <option value=''>-시험구분-</option>
            <option value='1'>출판사별</option>
            <option value='2'>문법교재별</option>
        </select>
        </td>
        <td >
        <select name=s_ban_id onchange="goPage(1);">
            <option value=''>-반명-</option>
<%
for(int i=0,l = dataList2.size(); i<l; i++){
    String ban_id    = SUtil.empty(dataList2.get(i)[ 0]);
    String ban_name  = SUtil.empty(dataList2.get(i)[ 1]);
%>
            <option value='<%=ban_id%>'><%=ban_name %></option>
<%
}
%>
        </select>
        <select name=s_kind onchange="goPage(1)">
            <option value='a.MEM_NAME'>이름</option>
            <option value='a.MEM_ID'  >아이디</option>
        </select>
        <input type=text name=s_search size=13 onkeyup="goPage(1)">
<input type="text" readonly name="s_s_date" id="s_s_date" value="<%=s_s_date%>" size=9 onclick="displayCalendar(this,'yyyy-mm-dd',this)"><IMG align=absmiddle alt=시작일자 src="/images/btn/btn_admin_cal.jpg" width=20 height=19 onclick="displayCalendar(this.previousSibling,'yyyy-mm-dd',this)">
~
<input type="text" readonly name="s_e_date" id="s_e_date" value="<%=s_e_date%>" size=9 onclick="displayCalendar(this,'yyyy-mm-dd',this)"><IMG align=absmiddle alt=종료일자 src="/images/btn/btn_admin_cal.jpg" width=20 height=19 onclick="displayCalendar(this.previousSibling,'yyyy-mm-dd',this)">
<input type="button" onclick="goPage(1);" value="검색">
        </td>
        </tr>

        <tr>
        <td>
        <span id=span_lcd></span>
        </td>
        <td>
        <span id=span_mcd></span>
        </td>
        <td>
        <span id=span_scd></span>
        </td>
    </tr>

</table>

<%
    }
%>
<span id=sub_list>
<table border="0" cellspacing=0 cellpadding=0 class=tbl_list>
<colgroup>
    <col width="70">
    <col width="55">
    <col width="40">
    <col width="70">
    <col width="60">
    <col width="">
    <col width="40">
    <col width="70">
    <col width="65">
</colgroup>
<thead>
    <tr height="27" align="center" bgcolor="#B1D8DE">
        <td>반명</td>
        <td>이름</td>
        <td>학년</td>
        <td>출판사</td>
        <td>Lesson</td>
        <td>내신문법강좌</td>
        <td>정답</td>
        <td>학습일</td>
        <td>결과보기</td>
    </tr>
</thead>
<tbody>
<%
try {
    if(dataList.size() < 1) {
        out.println("<tr>");
        out.println("<td colspan=\"9\" height=\"90\" align=\"center\" valign=\"middle\">");
        out.println("찾으시는 결과가 없습니다.");
        out.println("</td>");
        out.println("</tr>");

    } else {

        for(int i=0,l = dataList.size(); i<l; i++){
            String code_nm1    = SUtil.empty(dataList.get(i)[ 0]);
            String grade_gb    = SUtil.empty(dataList.get(i)[ 1]);
            String code_nm2    = SUtil.empty(dataList.get(i)[ 2]);
            String code_nm3    = SUtil.empty(dataList.get(i)[ 3]);
            String lect_name   = SUtil.empty(dataList.get(i)[ 4]);
            String mem_id      = SUtil.empty(dataList.get(i)[ 5]);
            String lect_cd     = SUtil.empty(dataList.get(i)[ 6]);
            String seq         = SUtil.empty(dataList.get(i)[ 7]);
            String lesson_cd   = SUtil.empty(dataList.get(i)[ 8]);
            String exam_gb     = SUtil.empty(dataList.get(i)[ 9]);
            String tot_qst_cnt = SUtil.empty(dataList.get(i)[10]);
            String correct_cnt = SUtil.empty(dataList.get(i)[11]);
            String score       = SUtil.empty(dataList.get(i)[12]);
            String ac_id       = SUtil.empty(dataList.get(i)[13]);
            String ac_name     = SUtil.empty(dataList.get(i)[14]);
            String mem_name    = SUtil.empty(dataList.get(i)[15]);
            String mem_gb      = SUtil.empty(dataList.get(i)[16]);
            String ban_id      = SUtil.empty(dataList.get(i)[17]);
            String ban_name    = SUtil.empty(dataList.get(i)[18]);
            String reg_date    = SUtil.empty(dataList.get(i)[19]);
%>
     <TR <%=(i%2 == 1)?"bgcolor=\"#f5f5f5\"":""%> title='<%=lect_name%>'>
        <td align="center"><%=ban_name%></td>
        <td align="center" title="<%=mem_id%>"><%=mem_name%></td>
        <td align="center"><%=grade_gb%>학년</td>
        <td align="center"><%=code_nm2%></td>
        <td align="center"><%=code_nm3%></td>
        <td align="center">
        <div style='width:200px;overflow:hidden' class='textOf'><nobr><%=lect_name%></nobr></div>
        </td>
        <td align="center"><%=correct_cnt%>/<%=tot_qst_cnt%></td>
        <td align="center"><%=reg_date%></td>
        <td align="center"><button onclick="fResult('<%=mem_id%>','<%=lect_cd%>','<%=seq%>');" style="width:60px">결과보기</button></td>
     </TR>
<%
        }
    }

}catch(Exception e){ out.println(e); }
%>
</tbody>
</table>

<table border="0" cellpadding="0" cellspacing="0" class="tbl_4">
    <tr>
        <td style='text-align:center'>
            <%= SUtil.PageNav(pageNum, pageSize, totalSize, "goPage") %>
        </td>
    </tr>
</table>
</span>
<%
} else {
%>
<jsp:include page="/include/message_box1.jsp" flush="true">
    <jsp:param name="p_message" value="<%=msg%>" />
    <jsp:param name="p_ok" value="self.close();" />
</jsp:include>
<%
}
%>
#T=처리
<%
//*************************************************************************************************/
//      파 일 명    : voca_paper_main.jsp
//      작 성 자    : 김 지 훈(softm@nate.com)
//      작 성 일    : 2011-07-28
//      수 정 일    : 2011-07-28
//      설    명    : 단어TEST지 만들기
//                                                  Copyright(C) 2011  해브영어 Co., Ltd.
//*************************************************************************************************/
%>
<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@ include file = "/include/initiate.inc" %>

<%
//=================================================================================================
String ac_id    = StringUtils.defaultString(request.getParameter("ac_id"));
String ban_name = StringUtils.defaultString(request.getParameter("ban_name"));
String tch_id   = StringUtils.defaultString(request.getParameter("tch_id"));
String sogae    = StringUtils.defaultString(request.getParameter("sogae"));
//=================================================================================================

try {
    db = new DBM(true);

    // 트랜잭션 시작! /////// 
    db.SetAutoCommit(false);
    /////////////////////////

    //-------------------------------------------
    // 1. 반 생성
    //-------------------------------------------
    String ban_id = db.ExecOneFieldStr("SELECT IFNULL(MAX(BAN_ID)+1,1) FROM BAN WHERE AC_ID=" + ac_id);
    if (ban_id.equals("")) throw new Exception("반 ID 생성 실패!");

    gsbSQL = new StringBuffer();
    gsbSQL.append("INSERT INTO BAN ( ");
    gsbSQL.append("     AC_ID           , ");   //1
    gsbSQL.append("     BAN_ID          , ");   //2
    gsbSQL.append("     BAN_NAME        , ");   //3
    gsbSQL.append("     TCH_ID          , ");   //4
    gsbSQL.append("     SOGAE           , ");   //5
    gsbSQL.append("     STATE           , ");   //6
    gsbSQL.append("     BAN_LISTEN_GB   , ");   //7
    gsbSQL.append("     REG_DATE        , ");   //8
    gsbSQL.append("     MOD_DATE          ");   //9
    gsbSQL.append(") VALUES (   ");
    gsbSQL.append("     ?,      ");
    gsbSQL.append("     ?,      ");
    gsbSQL.append("     ?,      ");
    gsbSQL.append("     ?,      ");
    gsbSQL.append("     ?,      ");
    gsbSQL.append("     1,      ");
    gsbSQL.append("     '5',    ");     // 3회 (정상-정상-정상) --> 3회 [속청+빠르게+정상] softm 2010년 11월 15일 월요일 오후 7:43:11
    gsbSQL.append("     NOW(),  ");
    gsbSQL.append("     NOW()   ");
    gsbSQL.append(")            ");

    db.CreatePstmt(gsbSQL.toString());
    db.SetPstmtString(1, ac_id);
    db.SetPstmtString(2, ban_id);
    db.SetPstmtString(3, ban_name.replace("\'","＇"));
    db.SetPstmtString(4, tch_id);
    db.SetPstmtString(5, sogae);
    
    if (db.ExecUpdate() < 0) {
        throw new Exception("반생성 실패 : " + db.GetErrMessage());
    }   
    //out.print("<br>ban_id=" + ban_id);


    //-------------------------------------------
    // 2. 숙제설정 기본생성 ^ 
    //-------------------------------------------
    gsbSQL = new StringBuffer();
    gsbSQL.append("INSERT INTO SET_HW (AC_ID, BAN_ID, BEGIN_SET_DT, END_SET_DT, ");
    gsbSQL.append(" SET_TIME, HOW_OFTEN, EXP_TERM, SEL_GB, UNI_GB, DIC_GB, DIC_PASS_POINT, LISTEN_GB, KO_ANS_GB, ");
    gsbSQL.append(" STATE, USE_GB, REG_DATE, MOD_DATE ");
    gsbSQL.append(") VALUES (");
    gsbSQL.append(ac_id).append(",").append(ban_id).append(", DATE_FORMAT(NOW(),'%Y-%m-%d'), DATE_FORMAT(NOW(),'%Y-%m-%d'), ");
    //gsbSQL.append(" '01', '', '1', '0', '0', '0', 0, '3', '0', ");
    gsbSQL.append(" '01', '', '1', '0', '0', '0', 0, '5', '0', "); // 3 -> 5 softm 2010년 11월 15일 월요일 오후 7:47:30
    gsbSQL.append(" '0', '0', NOW(), NOW())");
    if (db.ExecUpdate(gsbSQL.toString()) < 0) {
        throw new Exception("숙제설정 실패 : " + db.GetErrMessage());
    }
    String set_id = db.ExecOneFieldStr("SELECT MAX(SET_ID) MAX_SET_ID FROM SET_HW");
    //out.print("<br>set_id=" + set_id);


    //-------------------------------------------
    // 3. 숙제설정 과목 기본생성 ^ 
    //-------------------------------------------
    gsbSQL = new StringBuffer();
    gsbSQL.append("INSERT INTO SET_HW_SUBJ (SET_ID, LCD, SUBJECT_CD, HW_CNT, CURR_QSID, CHK_FG, USE_FG, REG_DATE, MOD_DATE) ");
    gsbSQL.append(" VALUES(?, ?, '', 0, 0, '0', '1', NOW(), NOW())");
    db.CreatePstmt(gsbSQL.toString());
    for(int i = 0; i < gaSetHwSubject.length ; i++) {
        db.SetPstmtString(1, set_id);
        db.SetPstmtString(2, gaSetHwSubject[i]);
        if (db.ExecUpdate() < 0){throw new Exception("숙제설정 과목생성 실패 : " + db.GetErrMessage());}
    }

    ////////////////
    db.Commit();
    ////////////////

} catch (Exception e) {
    if (db !=null) {db.Rollback();}
    out.println(e.getMessage());
} finally {
    if (db !=null) {db.SetAutoCommit(true);}
    ClearDB();
}
//=================================================================================================
%>

<SCRIPT language="Javascript">

    alert("반이 생성 되었습니다.");
    location.href= "./list.jsp";

</SCRIPT>
#T=SELECT - 리스트
    gsbSQL.setLength(0);
    gsbSQL.append(" SELECT ");
    gsbSQL.append("  MEM_ID   ,");
    gsbSQL.append("  LECT_CD  ,");
    gsbSQL.append("  SEQ      ,");
    gsbSQL.append("  LESSON_CD,");
    gsbSQL.append("  I_NUM    ,");
    gsbSQL.append("  O_ANSWER ,");
    gsbSQL.append("  S_ANSWER ,");
    gsbSQL.append("  OX       ,");
    gsbSQL.append("  POINT     ");
    gsbSQL.append(" FROM naesin_grammar_lesson_answer_result");
    gsbSQL.append(" WHERE MEM_ID = '" + ss_mem_id+ "'");
    gsbSQL.append(" AND   LECT_CD= '" + p_lect_cd+ "'");
    gsbSQL.append(" AND   SEQ    = '" + p_seq    + "'");

    rs = db.ExecQuery(gsbSQL.toString());
    while (rs.next()) {
        String[] data = new String[9];
        data[ 0] = rs.getString("MEM_ID"    ); //  0
        data[ 1] = rs.getString("LECT_CD"   ); //  1
        data[ 2] = rs.getString("SEQ"       ); //  2
        data[ 3] = rs.getString("LESSON_CD" ); //  3
        data[ 4] = rs.getString("I_NUM"     ); //  4
        data[ 5] = rs.getString("O_ANSWER"  ); //  5
        data[ 6] = rs.getString("S_ANSWER"  ); //  6
        data[ 7] = rs.getString("OX"        ); //  7
        data[ 8] = rs.getString("POINT"     ); //  8
        dataList.add(data);
    }
--------------------------- ---------------------------------- 

<table border="0" cellspacing=0 cellpadding=0 class=tbl_list>
<colgroup>
    <col width="70">
    <col width="55">
    <col width="40">
    <col width="70">
    <col width="">
</colgroup>
<thead>
    <tr height="27" align="center" bgcolor="#B1D8DE">
        <td>반명</td>
        <td>이름</td>
        <td>학년</td>
        <td>출판사</td>
        <td>~</td>
    </tr>
</thead>
<tbody>
<%
    if(dataList.size() < 1) {
        out.println("<tr>");
        out.println("<td colspan=\"9\" height=\"90\" align=\"center\" valign=\"middle\">");
        out.println("찾으시는 결과가 없습니다.");
        out.println("</td>");
        out.println("</tr>");
    } else {
        for(int i=0,l = dataList.size(); i<l; i++){
            String code_nm1    = SUtil.empty(dataList.get(i)[ 0]);
            String grade_gb    = SUtil.empty(dataList.get(i)[ 1]);
            String code_nm2    = SUtil.empty(dataList.get(i)[ 2]);
            String code_nm3    = SUtil.empty(dataList.get(i)[ 3]);
            String lect_name   = SUtil.empty(dataList.get(i)[ 4]);
%>
     <TR <%=(i%2 == 1)?"bgcolor=\"#f5f5f5\"":""%> title='<%=lect_name%>'>
        <td align="center"><%=ban_name%></td>
        <td align="center" title="<%=mem_id%>"><%=mem_name%></td>
        <td align="center"><%=grade_gb%>학년</td>
        <td align="center"><%=code_nm2%></td>
        <td align="center"><%=code_nm3%></td>
        <td align="center">
        <div style='width:200px;overflow:hidden' class='textOf'><nobr><%=lect_name%></nobr></div>
        </td>
        <td align="center"><%=correct_cnt%>/<%=tot_qst_cnt%></td>
        <td align="center"><%=reg_date%></td>
        <td align="center"><button onclick="fResult('<%=mem_id%>','<%=lect_cd%>','<%=seq%>');" style="width:60px">결과보기</button></td>
     </TR>
<%
        }
    }
%>
</table>

#T=pageTab

int pageSize =SUtil.make(request.getParameter("pageSize"), 10);
int totalSize = 0;
int p_start = SUtil.make(request.getParameter("p_start"), 1);

db.SetPstmtInt(1,p_start-1);
db.SetPstmtInt(2,pageSize);

    <input type="hidden" name="p_start" value="<%=p_start%>">


<%= Sql.pageTab(p_start, totalSize, pageSize, pageSize, Sql.page_navi_limit, "goPage")%>

function goPage(event,p) {
    document.sForm.p_start.value = p;
    var params = Form.queryString(document.sForm);
    getContent2('board/common/list',{params:params,method:'POST'});
}
#T=SELECT LAST_INSERT_ID()
        gsbSQL.append("SELECT LAST_INSERT_ID() ");
        q_id = db.ExecOneFieldInt( gsbSQL.toString() );

#T==== JAVASCRIPT ==============================================
=================================================
#T=alert();
alert(^!);
#T=<script src="<%=JS_SERVER%>/service/common/js/have.js" language="javascript"></script>
<script src="<%=JS_SERVER%>/service/common/js/have.js" language="javascript"></script>

#T=<script src="/js/asyncConnector.js" language="javascript"></script>
<script src="/js/asyncConnector.js" language="javascript"></script>

#T=openWindow("del_ok.jsp?ban_id="+id+"&"+"pageNum="+num, 810, 500,"ifrm_temp",{scrollbars:'no'})
openWindow("del_ok.jsp?ban_id="+id+"&"+"pageNum="+num, 810, 500,"ifrm_temp",{scrollbars:'no'})
#T=Util.domReady
    Util.domReady( function() {
    });

#T=Effect.twinkle
var twinkleInfo = {cssText:'background-color:#BFE2FF;border:1px dotted #CC0000',during:800,callback:function(){Alert.hide({id:'message_box'});$('message_box.ok').onclick();}};
Effect.twinkle(f.esti_no,twinkleInfo);

#T=xhr.httpOpen
            xhr.openCallBack= function (str) {
            }
            xhr.httpOpen(o.method, url, false,params,ar);
            xhr.dataArea.innerHTML = xhr.responseText();


            xhr.openCallBack= function (str) {
                xhr.dataArea.innerHTML = xhr.responseText();
            }
            xhr.httpOpen(o.method, url, true,params,ar);
#T=xmlhttprequest

            var xhr = new asyncConnector('xmlhttp');
            xhr.form = document.tForm;
            params += "&" + xhr.getQueryString();
            alert( params );
            xhr.openCallBack= function (str) {
                //if (loading) loading.hide();
                eval("var rtn = " + xhr.responseText().trim() )
                alert( rtn.msg );
                xhr.dataArea.innerHTML = xhr.responseText();
            }

            xhr.httpOpen("POST", "/ac/board_view/mp3/pop_naesin_grammar_LMWViwer_exec.jsp", false,params);

#T=var xhr = new asyncConnector('xmlhttp');
        var xhr = new asyncConnector('xmlhttp');
        xhr.openCallBack= function (str) {
            //if (loading) loading.hide();
            xhr.dataArea.innerHTML = xhr.responseText();
        }
        xhr.httpOpen("POST", "/ac/board_view/mp3/pop_naesin_grammar_LMWViwer_exec.jsp", false,params);
        //loading.show();

#T=getContent2 - Form.submit-POST
    var params = Form.queryString(document.sendmeform);
    getContent2('std/list_reading_renew',{params:params,method:'POST'});

#T=Form.queryString(document.stuForm)
Form.queryString(document.stuForm)
#T=tmp 프레임 처리후 얼럿 및 초기화
<script type="text/javascript">
<!--
    document.location.replace("about:blank");
    alert('저장되었습니다.');
    parent.getContent2('board/gongji/list',{params:'pageNum=1&kind=' + k + '&search=' + s,method:'POST'});
//-->
</script>
#T=Util.Load.script({src:"/css/image_file_attach.css",type:'css',callback:function(){}});
Util.Load.script({src:"/css/image_file_attach.css",type:'css',callback:function(){}});
#T=Util.Load.script({src:"/service/common/js/xquared_client/javascripts/plugin/ExtendColorPickerPlugin.js",type:'js',callback:function(){}});
Util.Load.script({src:"/service/common/js/xquared_client/javascripts/plugin/ExtendColorPickerPlugin.js",type:'js',callback:function(){}});
#T=function onComplete()
    function onComplete() {
         ^!
    }
#T=pageNavi
<table class=tbl_4>
    <tr>
        <td height="30" style='text-align:center'><%= SUtil.PageNav(pageNum,pageSize,totalCnt,"goPage") %></td>
    </tr>
</table>

#T=html 에디터
        xed = new xq.Editor("sogae");
        xed.config.contentCssList = ["/service/common/js/xquared_client/stylesheets/xq_contents.css"];
        xed.config.lang = 'ko';
        xed.config.imagePathForDefaultToolbar = '/service/common/js/xquared_client/images/toolbar/ko/';

        xed.isSingleFileUpload = true; 
        xed.addPlugin('FileUpload');
        xed.setFileUploadTarget('/service/common/editor_fileupload.jsp', '/examples/upload.php');

        xed.config.autoFocusOnInit = true;
        xed.config.urlValidationMode = 'host_relative';
        xed.config.changeCursorOnLink = true;
        xed.config.enableLinkClick = true;

        //xed.config.enablePreventExit = true;
        //xed.config.PreventExitMessage = "수정되었습니다.";
        xed.addPlugin('ExtendColorPicker');

        xed.setEditMode('wysiwyg');
        xed.setWidth("100%");
        xed.setHeight("200px");
--------------------- ------------------------ --------------------------------

<link rel="stylesheet" type="text/css" href="/service/common/js/xquared_client/stylesheets/xq_ui.css" />
<script type="text/javascript" src="/service/common/js/xquared_client/javascripts/XQuared.js?load_others=1"></script>
<script type="text/javascript" src="/service/common/js/xquared_client/javascripts/plugin/FileUploadPlugin.js"></script>
<script type="text/javascript" src="/service/common/js/xquared_client/javascripts/plugin/ExtendColorPickerPlugin.js"></script>

#T=onfocus="Form.numeberOnly(event);"
onfocus="Form.numeberOnly(event);"
#T=loop function-element
aa = (function(a){
    return function(a){

    };
})(a)

#T=filter
            img.style.filter = "alpha(opacity=50)";
            img.style.opacity =0.5;
#T=getTable
    var tbl = GRID.getObject(o.offsetParent);
    var th = tbl.head;
    var tb = tbl.body;
    var tf = tbl.foot;
    for (var i=0; i<th.rows.length;i++){
        for (var j=0; j<th.rows[i].cells.length;j++ ) {
        }
    }

#T=handleError
function handleError(err, url, line) {
    alert ( '오류 : ' + err + '\nURL : ' + url + '\nLine : ' + line);
    return true;
}
window.onerror = handleError;

#T==== Tag ==============================================
=================================================
#T=테스트 템플릿 [HTML]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Havⓔnglish - 온라인 영어학습의 절대강자!</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-Control" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
<meta http-equiv="Pragma" content="no-cache"/>
<!-- <link rel="stylesheet" href="css/base.css" type="text/css"> -->
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<link href="http://local-just10.com:8080/service/common/css/style.css" rel="stylesheet" type="text/css" />

<script src="/js/base.js" language="javascript"></script>
<!-- <script src="/js/common.js" language="javascript"></script> -->
<script src="http://local-just10.com:8080/service/common/js/css_browser_selector.js" language="javascript"></script>

<script src="http://local-just10.com:8080/service/common/js/asyncConnector.js" language="javascript"></script>
<script src="http://local-just10.com:8080/service/common/js/have.js" language="javascript"></script>

<script type="text/javascript">
<!--
    var SITE_ID = 'haveenglish';
    var IMG_SAVE = false;
    var REST_ROOT = "/rest/";
    var JS_SERVER = "http://local-just10.com:8080";
//-->
</script>
<!--[if IE]>
<style type="text/css">
    .textOf {overflow:hidden;text-overflow:ellipsis;}
</style>
<![endif]-->
</head>

<!--[if IE]>
<style type="text/css">
    .textOf {overflow:hidden;text-overflow:ellipsis;}
</style>
<![endif]-->
<link rel="stylesheet" type="text/css" href="http://just10.co.kr/service/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" />
<script type="text/javascript" src="http://just10.co.kr/service/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js"></script>
<body >
<script type="text/javascript">
<!--
    function ff() {
        var params = Form.queryString(document.f);
        alert( params );
    }
//-->
</script>
<form name=f>
<input type=text name=p_1 value=1><input type=checkbox name=p_2 value=Y checked>
<input type=text name=p_1 value=2><input type=checkbox name=p_2 value=Y checked>
<!-- <input type=text name=p_1 value=3><input type=checkbox name=p_2 value=Y checked> -->
</form>
<button onclick="ff();"></button>

<iframe name="ifrm_temp" id="ifrm_temp" src="about:blank" frameborder="1" scrolling="auto" width="100" height="100" style='position:absolute;left:1100px;top:10px'></iframe>
<iframe name="ifrm_login" id="ifrm_login" src="about:blank" frameborder="0" width="0" height="0"></iframe>
</BODY>
</HTML>

#T=style='text-align:left'
style='text-align:left'
#T=target="ifrm_temp"
target="ifrm_temp"
#T=style='border:0px'
style='border:0px'
#T=style='text-align:center'
style='text-align:center'
#T=style='height:25px'
style='height:25px'
#T=style='width:500px'
style='width:500px'
#T=style='vertical-align:middle'
style='vertical-align:middle'
#T=align=absmiddle
align=absmiddle
#T=textOf
                            <div style='width:324px;overflow:hidden' class='textOf'><nobr>^!
                            </nobr>
                            </div>
#T=업무일지
---------- ---------- 2009년03월19일<목> ---------- ----------
▣ 출퇴근시간
  - 출근 : 09:00
  - 퇴근 : 18:30

▣ 업무
    1. 실무자
        ■

        ■

        ■

    2. 강사
        ■
         

        ■
         

        ■
         
#T======= HTML/JS ==============================
====== HTML/JS ==============================
#T=Lib.fixNull(request.getParameter("p_title"  ));
String p_message = ipac.common.Lib.fixNull(request.getParameter("p_title"  ));
#T=<%=%>
<%=^!%>
#T=Lib.fixNullToValue(request.getParameter("p_title"  ), "");
String p_message = ipac.common.Lib.fixNullToValue(request.getParameter("p_title"  ), "");
#T=<%@ page language="java" contentType="text/html; charset=UTF-8" session="true" %>
<%@ page language="java" contentType="text/html; charset=UTF-8" session="true" %>

#T=<%@ page errorPage="/common/error.jsp" %>
<%@ page errorPage="/common/error.jsp" %>

#T=<%@include file="../common/common.inc" %>
<%@include file="../common/common.inc" %>

#T=<jsp:include message_box.jsp flush="true" >
<!-- Message Box -->
    <jsp:include page="../common/message_box.jsp"  flush="true" >
        <jsp:param name="p_title"   value="● 로그인" />
        <jsp:param name="p_message" value="이미 로그인되어있습니다." />
    </jsp:include>
<!-- Message Box  -->
#T=if (loginYn.equals("Y") )
<%
if (loginYn.equals("Y") ) {
%>
^!
<%
} else {
%>
<%
}
%>
#T=<a href=# onclick='Member.login($("llForm"));return false;'>^!</a>
<a href=# onclick='Member.login($("llForm"));return false;'>^!</a>
#T=기본_자바스크립트
<script language="javascript" src='common/js/string.js'></script>
<script language="javascript" src='common/js/asyncConnector.js'></script>
#T=<pre>^!</pre>
<pre>^!</pre>
#T=<span id=jumin_msg>^!</span>
<span id=jumin_msg>^!</span>
#T=loading = new UI.Loading.display
<SCRIPT LANGUAGE="JavaScript">
<!--
var loading = new UI.Loading.display('../common/js/ajax-loader.gif','image');
//loading.show();
loading.setTarget(document.documentElement);
loading.setSize('80px','12px');
//-->
</SCRIPT>
#T=<textarea id=js_onload>Member.write_onload()</textarea>
<textarea id=js_onload>Member.write_onload()</textarea>

#T=style=버튼
<style>
    .bg_trans { background-color:transparent }
    .btn_gb   { border:0;background-Position:center;background:url(../images/btn/btn_bg.gif);background-repeat:no-repeat;padding:3 0 0 10;font-size:8pt;font-weight:bold;color:#ff6c00;font-family:바탕체;width:74;height:25;vertical-align:top }
</style>
#T=닫기 이미지버튼
                     <a href="javascript:self.close()"><img src="../images/btn/btn_colse.gif" alt="닫기" width="74" height="25" border="0"></a></div>

#T=<div class='textOf' style="width:150;"><nobr>^!</nobr></div>
<div class='textOf' style="width:150;"><nobr>^!</nobr></div>
#T=style="word-wrap:break-word;word-break:break-all;width:380"
style="word-wrap:break-word;word-break:break-all;width:380"
#T=onpropertychange='enforceNumber()'
onpropertychange='enforceNumber()'
#T=달력입력
        <input type="text" name="Ltr_OpSdate" style="width:61px " value="" readonly>
        <img src="../images/icon_calender.gif" style='cursor:hand' alt="달력" width="23" height="16" border="0" align="absmiddle" onClick="javascript:popupCalendar(document.wForm,document.wForm.Ltr_OpSdate);">
#T======= JSP/JAVA ==============================
====== JSP/JAVA ==============================
#T=상단주석
<%
/** 
 * <pre>
 *  설  명 :  대표가맹점리스트 조회 ( data json )
 *  작성자 :  KMSLAB 개발팀
 *  작성일 :  2012-02-06
 *
 *  기타사항 :
 *  
 * Copyrights 2011 by GS ITM. All right reserved.
 * </pre>
*/
%>
#T=JSP inline Method
<%!
    public String getStrSelected(String sData,String data) {
        sData = sData == null?"":sData;
        data = data == null?"":data;
        return sData.equals(data) ? "selected" : "";
    }
    public String fixedNull(String data) {
        return data != null? data: "" ;
    }
%>

#T=fixNull(String data)
fixNull(^!)
#T=java.net.URLDecoder.decode(uname,"utf-8");
^# Script
  encodeURIComponent(uname)

^# java
  java.net.URLDecoder.decode(uname,"utf-8");
#T=java.net.URLEncoder.encode(Sta_BanNm, "utf-8");
java.net.URLEncoder.encode(Sta_BanNm, "utf-8");
#T=년도 distinct selectbox
<%
try {
	sSql  = "SELECT * FROM ( SELECT DISTINCT Left(You_InDate,4) YYYY FROM Staff_004 WHERE You_InDate <> '' ) a ORDER BY a.YYYY desc;";
	rs = stmt.executeQuery(sSql);
    // out.println("fndYear : " + fndYear + "<BR>");

	String strYear = null;
	out.println ( "<select name='fndYear'>" );
	for(int k=0;rs.next();k++) {
		strYear = rs.getString("YYYY");
		out.println( "<option value='" + strYear + "' " + checkFndYear(strYear) + ">" + strYear + "</option>");
	}
	out.println ( "</select>" );
	rs.close();
}catch(SQLException e) {
	out.println(e.getMessage());
}
%>
#T=public String checkFndYear
    String  fndYear = "";
	public String checkFndYear(String data) {
		return fndYear.equals(data) ? "selected" : "";
	}
	    fndYear = request.getParameter("fndYear") != null? request.getParameter("fndYear"): ""+Y;

#T=yy+"-"+String.format("%02d",mm)+"-"+String.format("%02d",dd)
yy+"-"+String.format("%02d",mm)+"-"+String.format("%02d",dd)
#T=NumberFormat.getInstance().format()
NumberFormat.getInstance().format(^!)
#T=    out.println("error : " + e.toString() + "<BR>");
    out.println("error : " + e.toString() + "<BR>");

#T=KoreanDecoding  kd = new KoreanDecoding();
    KoreanDecoding  kd = new KoreanDecoding();
#T=    kd.decoding()
kd.decoding(^!)
#T=.replace("\'","&#39;")
.replace("\'","&#39;")
#T=.replace("\"","&quot;")
.replace("\"","&quot;")
#T=Hashtable hashMinDt = new Hashtable();
Hashtable hashMinDt = new Hashtable();
hashMinDt.put(rs3.getString("ST_ID"),rs3.getLong("MIN_DT"));

long min_dt = hashMinDt.get(rs.getString("ST_ID"))!=null?(Long)hashMinDt.get(rs.getString("ST_ID")):0;

#T=String cool[] = new String[10];
String cool[] = new String[10];


  // s 라는 문자열 배열 선언과 초기화
    String s[] = { "Google", "Yahoo", "MSN", "땡칠이" };

    // 배열의 모든 요소 화면에 출력
    for (int i = 0; i < s.length; i++)
      System.out.println(s[i]);


#T=JSP-getCookie
<%!
public String getCookie (HttpServletRequest request,String nm) {
  //Getting Cookie from Client
  Cookie[] cookies = request.getCookies();
  //Cookie 에서 값을 처리할 String 변수 선언
  String rtn ="";

  //Cookie값  유무확인
  if(cookies != null) {
   //array 로 return 하므로 array 갯수만큼 반복문 수행
   for(int i=0;i<cookies.length;i++){
    //name=value 형식의 저장값중 name 추출
    String cookieName = cookies[i].getName();
    String cookieValue = java.net.URLDecoder.decode(cookies[i].getValue());
    System.out.println("client로 부터 전송된 cookie : "+cookieName+"="+cookieValue);
    
    if(cookieName.equals(nm)){
        rtn = cookieValue;
    }
   }
  }else{

  }
  return rtn;
}
%>

#T=JSP-setCookie
<%!
public void setCookie (HttpServletResponse response,String nm, String val) {
    Cookie cookie = new Cookie(nm,val);  // 쿠키명, 쿠키값
    cookie.setMaxAge(60*60*24*1); //유효기간 
    cookie.setPath("/"); //경로 
    //cookie.setDomain(".mobis.co.kr"); //도메인 특정 도메인에서만 사용가능하게 해주는 부분
    response.addCookie(cookie); //쿠키추가 
    //request.out.println(nm + " / " + val+ "<BR>" );
}
%>
#T======= 공통  ==============================
====== 공통  ==============================
#T=commonLib.strToHtmlStr()
commonLib.strToHtmlStr(^!)
#T=CommonLib.getNumberFormat()
CommonLib.getNumberFormat(^!)
#T=CommonLib.filterFloat(String ar)
CommonLib.filterFloat(^!)
#T=CommonLib.filterInt(String ar)
CommonLib.filterInt(^!)
#T=SQLLib.getBanOfYouthComboBox(siselNo,"-선택-","s_ban",s_ban,"",stmt);
SQLLib.getBanOfYouthComboBox(siselNo,"-선택-","s_ban",s_ban,"",stmt);
#T=SQLLib.getProgNameComboBox(siselNo,"","","","s_prog",s_prog,"onchange='fSearch();'", stmt)
SQLLib.getProgNameComboBox(siselNo,"","","","s_prog",s_prog,"onchange='fSearch();'", stmt)
#T=과정-<%=SQLLib.getCommon01ComboBox("'0002' ,'0003'","1","-선택-", "s_Ltr_CourCode",s_Ltr_CourCode,"style='width:150px'", stmt)%>
<%=SQLLib.getCommon01ComboBox("'0002' ,'0003'","1","-선택-", "s_Ltr_CourCode",s_Ltr_CourCode,"style='width:150px'", stmt)%>
#T=        <%=SQLLib.getCommon02ComboBox("0002","","","","Sta_Gucode","","style='width:95%'",stmt)%>
<%=SQLLib.getCommon02ComboBox("0002","","","","Sta_Gucode","","style='width:95%'",stmt)%>
#T=프로그램-<%=SQLLib.getProgNameComboBox(siselNo,String.format("%04d-01-01",yy),String.format("%04d-%02d-%02d",yy,mm,dd),"-선택-","s_Ltr_Prog",s_Ltr_Prog,"", stmt)%>
<%=SQLLib.getProgNameComboBox(siselNo,String.format("%04d-01-01",yy),String.format("%04d-%02d-%02d",yy,mm,dd),"-선택-","s_Ltr_Prog",s_Ltr_Prog,"", stmt)%>
#T======= SQL ==============================
====== SQL ==============================
#T=단순값 조회
String s_ltr_no = fixNull(request.getParameter("s_ltr_no"));
sSql = " SELECT "
    + " Ltr_No"
    + " FROM Lecturer_001"
    + " WHERE Ltr_No        = '" + s_ltr_no + "'"
    + " AND   Ltr_KwanCode  = '" + siselNo  + "'"
    ;
//out.println("sSql : " + sSql + "<BR>");
rs = stmt.executeQuery(sSql);
rs.next();
s_ltr_no = fixNull(rs.getString(1));

#T=max
        int newProgNum = 1;
        sSql = " SELECT "
            + " MAX(Ltr_ProgNum) + 1 CNT"
            + " FROM Lecturer_015"
            + " WHERE Ltr_No = '" + p_Ltr_No + "'"
            ;
        out.println("sSql : " + sSql + "<BR>");
        rs = stmt.executeQuery(sSql);
        if ( rs.next() ) newProgNum = (rs.getInt(1)==0?1:rs.getInt(1));

#T=sql_delete
        sSql = " DELETE FROM Staff_004 "
             + " WHERE You_No       = '" + p_you_no      + "'";
        //out.println(sSql + "<br>");
        stmt.executeUpdate(sSql);

#T======= 템플릿 ==============================
====== 템플릿 ==============================
#T=        - 입력/수정
<%@ page contentType="text/html;charset=UTF-8" %>
<%@ page language="java" import="java.sql.*, java.util.*, java.text.*, afs.member.*, afs.database.*" %>
<%@ page language="java" import="org.apache.log4j.Logger, org.apache.log4j.BasicConfigurator" %>
<%@ include file="../common/common.inc"%>
<%
/* 변수 */
String msg = "";
boolean error = false;
/* 클래스 */
KoreanDecoding  kd = new KoreanDecoding();
/* Database */
Connection          conn    = null;
PreparedStatement   pstmt   = null;
Statement           stmt    = null;
ResultSet           rs      = null;
String              sSql    = ""  ;
try {
/* 파라메터 */
String mode = fixNull(request.getParameter("mode")); // 모드
String p_Ltr_ProgNum    = fixNull(request.getParameter("p_Ltr_ProgNum"));
String p_Ltr_SubSeq     = fixNull(request.getParameter("p_Ltr_SubSeq"));

/* 변수 */

if ( request.getMethod().equals("POST") && ( mode.equals("I") || mode.equals("U") || mode.equals("D") )
    && !p_Ltr_ProgNum.equals("") && !p_Ltr_ProgNum.equals("")
   )
{
%>
<%@ include file="../common/conn.inc"%>
<%
    stmt = conn.createStatement(); // stmt 생성

    sSql = " SELECT "
        + " Ltr_ProgNum "
        + " FROM Lecturer_017"
        + " WHERE Ltr_ProgNum   = '" + p_Ltr_ProgNum + "'"
        + " AND   Ltr_No        = '" + staffNo       + "'"
        + " AND   Ltr_SubSeq    = '" + p_Ltr_SubSeq  + "'"
        ;
    //out.println("sSql : " + sSql + "<BR>");
    rs = stmt.executeQuery(sSql);
    rs.next();
    p_Ltr_ProgNum = fixNull(rs.getString(1));

    if ( !p_Ltr_ProgNum.equals("") ) {
        /* 파라메터 */
        //String Ltr_ProgNum    = fixNull(request.getParameter("Ltr_ProgNum"     )); // Lecturer_016.Ltr_ProgNum
        //String Ltr_No         = fixNull(request.getParameter("Ltr_No"          )); // 강사번호
        //String Ltr_SubSeq     = fixNull(request.getParameter("Ltr_SubSeq"      )); // 서브 Seq
        String Ltr_DateTime_D = fixNull(request.getParameter("Ltr_DateTime_D"));
        String Ltr_DateTime_H = fixNull(request.getParameter("Ltr_DateTime_H"));
        String Ltr_DateTime_M = fixNull(request.getParameter("Ltr_DateTime_M"));
        String Ltr_DateTime   = Ltr_DateTime_D + " " + Ltr_DateTime_H + ":" + Ltr_DateTime_M;; // 활동 일시

        int Ltr_WeekNum  = 0; // 작성주
        if ( Ltr_DateTime_D.length() == 10 ) {
            Calendar cal = Calendar.getInstance();
            cal.set(Calendar.YEAR ,Integer.parseInt(Ltr_DateTime_D.substring(0, 4)));
            cal.set(Calendar.MONTH,Integer.parseInt(Ltr_DateTime_D.substring(5, 7)) - 1);
            cal.set(Calendar.DATE ,Integer.parseInt(Ltr_DateTime_D.substring(8, 10)));
            Ltr_WeekNum = cal.get(Calendar.WEEK_OF_YEAR); // 작성주
        }

        String Ltr_EduCont    = kd.decoding(fixNull(request.getParameter("Ltr_EduCont"     ))).replace("\"","&quot;"); // 내용
        String Ltr_Place      = kd.decoding(fixNull(request.getParameter("Ltr_Place"       ))).replace("\"","&quot;"); // 장소
        String Ltr_Goal       = kd.decoding(fixNull(request.getParameter("Ltr_Goal"        ))).replace("\"","&quot;"); // 목적 및 목표
        String Ltr_TeahcerName= kd.decoding(fixNull(request.getParameter("Ltr_TeahcerName" ))).replace("\"","&quot;"); // 지도자/강사명
        String Ltr_Material   = kd.decoding(fixNull(request.getParameter("Ltr_Material"    ))).replace("\"","&quot;"); // 과제 및 준비물 안내

        String Ltr_StTime     = afs.common.CommonLib.getNumberFormat(fixNull(request.getParameter("Ltr_StTime"      ))); // 도입시간
        String Ltr_StCont1    = kd.decoding(fixNull(request.getParameter("Ltr_StCont1"     ))).replace("\"","&quot;"); // 도입내용1
        String Ltr_StCont2    = kd.decoding(fixNull(request.getParameter("Ltr_StCont2"     ))).replace("\"","&quot;"); // 도입내용2
          
        String Ltr_ExpTime    = afs.common.CommonLib.getNumberFormat(fixNull(request.getParameter("Ltr_ExpTime"     ))); // 전개시간
        String Ltr_ExpCont1   = kd.decoding(fixNull(request.getParameter("Ltr_ExpCont1"    ))).replace("\"","&quot;"); // 전개내용1
        String Ltr_ExpCont2   = kd.decoding(fixNull(request.getParameter("Ltr_ExpCont2"    ))).replace("\"","&quot;"); // 전개내용2

        String Ltr_ArrTime    = afs.common.CommonLib.getNumberFormat(fixNull(request.getParameter("Ltr_ArrTime"     ))); // 정리시간
        String Ltr_ArrCont1   = kd.decoding(fixNull(request.getParameter("Ltr_ArrCont1"    ))).replace("\"","&quot;"); // 정리내용1
        String Ltr_ArrCont2   = kd.decoding(fixNull(request.getParameter("Ltr_ArrCont2"    ))).replace("\"","&quot;"); // 정리내용2

        String Ltr_Prep       = kd.decoding(fixNull(request.getParameter("Ltr_Prep"        ))).replace("\"","&quot;"); // 운영관리 - 준비물
        String Ltr_Estimate   = afs.common.CommonLib.getNumberFormat(fixNull(request.getParameter("Ltr_Estimate"    ))); // 운영관리 - 소요예산
        String Ltr_Evaluate   = kd.decoding(fixNull(request.getParameter("Ltr_Evaluate"    ))).replace("\"","&quot;"); // 운영관리 - 평가방법
        String Ltr_Attend     = kd.decoding(fixNull(request.getParameter("Ltr_Attend"      ))).replace("\"","&quot;"); // 지도상 유의사항
        String Ltr_Effect     = kd.decoding(fixNull(request.getParameter("Ltr_Effect"      ))).replace("\"","&quot;"); // 기대효과

        if ( mode.equals("I") ) {
            /**** START - 입력을 위한 SQL문장을 조립합니다. --------------------- */
            StringBuffer sbo_query = new StringBuffer();
            sbo_query.append(" INSERT INTO Lecturer_018" );
            sbo_query.append(" ( ");
            sbo_query.append(" Ltr_ProgNum    ,");
            sbo_query.append(" Ltr_No         ,");
            sbo_query.append(" Ltr_SubSeq     ,");

            sbo_query.append(" Ltr_WeekNum    ,");

            sbo_query.append(" Ltr_DateTime   ,");
            sbo_query.append(" Ltr_EduCont    ,");
            sbo_query.append(" Ltr_Place      ,");
            sbo_query.append(" Ltr_Goal       ,");
            sbo_query.append(" Ltr_TeahcerName,");
            sbo_query.append(" Ltr_Material   ,");

            sbo_query.append(" Ltr_StTime     ,");
            sbo_query.append(" Ltr_StCont1    ,");
            sbo_query.append(" Ltr_StCont2    ,");

            sbo_query.append(" Ltr_ExpTime    ,");
            sbo_query.append(" Ltr_ExpCont1   ,");
            sbo_query.append(" Ltr_ExpCont2   ,");

            sbo_query.append(" Ltr_ArrTime    ,");
            sbo_query.append(" Ltr_ArrCont1   ,");
            sbo_query.append(" Ltr_ArrCont2   ,");

            sbo_query.append(" Ltr_Prep       ,");
            sbo_query.append(" Ltr_Estimate   ,");
            sbo_query.append(" Ltr_Evaluate   ,");
            sbo_query.append(" Ltr_Attend     ,");
            sbo_query.append(" Ltr_Effect     ,");

            sbo_query.append(" Ltr_RegDate    ,");
          //sbo_query.append(" Ltr_ModDate    ,");
            sbo_query.append(" Ltr_KwanNo      ");
            sbo_query.append(" )");
            sbo_query.append(" VALUES ");
            sbo_query.append(" (");
            sbo_query.append(" ?,?,?,?,?,");
            sbo_query.append(" ?,?,?,?,?,");
            sbo_query.append(" ?,?,?,?,?,");
            sbo_query.append(" ?,?,?,?,?,");
            sbo_query.append(" ?,?,?,?,?,");
            sbo_query.append(" ?         ");
            sbo_query.append(" );");
            //out.println("sbo_query.toString( : " + sbo_query.toString() + "<BR>");

            pstmt = conn.prepareStatement( sbo_query.toString() );

            int setSeq = 1;
            pstmt.setInt    ( setSeq, Integer.parseInt(p_Ltr_ProgNum)    ); setSeq++;

            pstmt.setString ( setSeq, staffNo           ); setSeq++;
            pstmt.setString ( setSeq, p_Ltr_SubSeq      ); setSeq++;

            pstmt.setInt    ( setSeq, Ltr_WeekNum       ); setSeq++;
            pstmt.setString ( setSeq, Ltr_DateTime      ); setSeq++;

            pstmt.setString ( setSeq, Ltr_EduCont       ); setSeq++;
            pstmt.setString ( setSeq, Ltr_Place         ); setSeq++;
            pstmt.setString ( setSeq, Ltr_Goal          ); setSeq++;
            pstmt.setString ( setSeq, Ltr_TeahcerName   ); setSeq++;
            pstmt.setString ( setSeq, Ltr_Material      ); setSeq++;

            pstmt.setFloat  ( setSeq, Integer.parseInt(Ltr_StTime)); setSeq++;
            pstmt.setString ( setSeq, Ltr_StCont1       ); setSeq++;
            pstmt.setString ( setSeq, Ltr_StCont2       ); setSeq++;

            pstmt.setFloat  ( setSeq, Integer.parseInt(Ltr_ExpTime)); setSeq++;
            pstmt.setString ( setSeq, Ltr_ExpCont1      ); setSeq++;
            pstmt.setString ( setSeq, Ltr_ExpCont2      ); setSeq++;

            pstmt.setFloat  ( setSeq, Integer.parseInt(Ltr_ArrTime) ); setSeq++;
            pstmt.setString ( setSeq, Ltr_ArrCont1      ); setSeq++;
            pstmt.setString ( setSeq, Ltr_ArrCont2      ); setSeq++;

            pstmt.setString ( setSeq, Ltr_Prep          ); setSeq++;
            pstmt.setInt    ( setSeq, Integer.parseInt(Ltr_Estimate)); setSeq++;
            pstmt.setString ( setSeq, Ltr_Evaluate      ); setSeq++;
            pstmt.setString ( setSeq, Ltr_Attend        ); setSeq++;
            pstmt.setString ( setSeq, Ltr_Effect        ); setSeq++;

            pstmt.setTimestamp (setSeq,new Timestamp(System.currentTimeMillis()));setSeq++;
          //pstmt.setTimestamp (setSeq,null                                );
            pstmt.setString ( setSeq, siselNo           ); setSeq++;
    /**/
            /**** End - 입력을 위한 SQL문장을 조립합니다. --------------------- */
            pstmt.executeUpdate();
            msg = "저장되었습니다.";
        } else if ( mode.equals("U") ) {
            /**** START - 입력을 위한 SQL문장을 조립합니다. --------------------- */
            StringBuffer sbo_query = new StringBuffer();
            sbo_query.append(" UPDATE Lecturer_018" );
            sbo_query.append(" SET ");
          //sbo_query.append(" Ltr_ProgNum    = ? ,");
          //sbo_query.append(" Ltr_No         = ? ,");
          //sbo_query.append(" Ltr_SubSeq     = ? ,");

            sbo_query.append(" Ltr_WeekNum    = ? ,");

            sbo_query.append(" Ltr_DateTime   = ? ,");
            sbo_query.append(" Ltr_EduCont    = ? ,");
            sbo_query.append(" Ltr_Place      = ? ,");
            sbo_query.append(" Ltr_Goal       = ? ,");
            sbo_query.append(" Ltr_TeahcerName= ? ,");
            sbo_query.append(" Ltr_Material   = ? ,");

            sbo_query.append(" Ltr_StTime     = ? ,");
            sbo_query.append(" Ltr_StCont1    = ? ,");
            sbo_query.append(" Ltr_StCont2    = ? ,");

            sbo_query.append(" Ltr_ExpTime    = ? ,");
            sbo_query.append(" Ltr_ExpCont1   = ? ,");
            sbo_query.append(" Ltr_ExpCont2   = ? ,");

            sbo_query.append(" Ltr_ArrTime    = ? ,");
            sbo_query.append(" Ltr_ArrCont1   = ? ,");
            sbo_query.append(" Ltr_ArrCont2   = ? ,");

            sbo_query.append(" Ltr_Prep       = ? ,");
            sbo_query.append(" Ltr_Estimate   = ? ,");
            sbo_query.append(" Ltr_Evaluate   = ? ,");
            sbo_query.append(" Ltr_Attend     = ? ,");
            sbo_query.append(" Ltr_Effect     = ? ,");

          //sbo_query.append(" Ltr_RegDate    = ? ,");
            sbo_query.append(" Ltr_ModDate    = ?  ");
          //sbo_query.append(" Ltr_KwanNo     = ?  ");

            sbo_query.append(" WHERE Ltr_ProgNum   = '" + p_Ltr_ProgNum + "'" );
            sbo_query.append(" AND   Ltr_No        = '" + staffNo       + "'" );
            sbo_query.append(" AND   Ltr_SubSeq    = '" + p_Ltr_SubSeq  + "'" );
            sbo_query.append(" AND   Ltr_KwanNo    = '" + siselNo       + "'" );
            pstmt = conn.prepareStatement( sbo_query.toString() );
            //out.println("sbo_query.toString() : " + sbo_query.toString() + "<BR>");

            int setSeq = 1;
          //pstmt.setInt    ( setSeq, Integer.parseInt(p_Ltr_ProgNum)    ); setSeq++;
          //pstmt.setString ( setSeq, staffNo           ); setSeq++;
          //pstmt.setString ( setSeq, p_Ltr_SubSeq      ); setSeq++;

            pstmt.setInt    ( setSeq, Ltr_WeekNum       ); setSeq++;
            pstmt.setString ( setSeq, Ltr_DateTime      ); setSeq++;

            pstmt.setString ( setSeq, Ltr_EduCont       ); setSeq++;
            pstmt.setString ( setSeq, Ltr_Place         ); setSeq++;
            pstmt.setString ( setSeq, Ltr_Goal          ); setSeq++;
            pstmt.setString ( setSeq, Ltr_TeahcerName   ); setSeq++;
            pstmt.setString ( setSeq, Ltr_Material      ); setSeq++;

            pstmt.setFloat  ( setSeq, Integer.parseInt(Ltr_StTime)); setSeq++;
            pstmt.setString ( setSeq, Ltr_StCont1       ); setSeq++;
            pstmt.setString ( setSeq, Ltr_StCont2       ); setSeq++;

            pstmt.setFloat  ( setSeq, Integer.parseInt(Ltr_ExpTime)); setSeq++;
            pstmt.setString ( setSeq, Ltr_ExpCont1      ); setSeq++;
            pstmt.setString ( setSeq, Ltr_ExpCont2      ); setSeq++;

            pstmt.setFloat  ( setSeq, Integer.parseInt(Ltr_ArrTime) ); setSeq++;
            pstmt.setString ( setSeq, Ltr_ArrCont1      ); setSeq++;
            pstmt.setString ( setSeq, Ltr_ArrCont2      ); setSeq++;

            pstmt.setString ( setSeq, Ltr_Prep          ); setSeq++;
            pstmt.setInt    ( setSeq, Integer.parseInt(Ltr_Estimate)); setSeq++;
            pstmt.setString ( setSeq, Ltr_Evaluate      ); setSeq++;
            pstmt.setString ( setSeq, Ltr_Attend        ); setSeq++;
            pstmt.setString ( setSeq, Ltr_Effect        ); setSeq++;

            pstmt.setTimestamp (setSeq,new Timestamp(System.currentTimeMillis()));setSeq++;

            /**** End - 입력을 위한 SQL문장을 조립합니다. --------------------- */
            pstmt.executeUpdate();
            msg = "수정되었습니다.";
        } else if ( mode.equals("D") ) {
            //out.println("sSql : " + sSql + "<BR>");
            sSql = " DELETE FROM Lecturer_018 "
                 + " WHERE Ltr_ProgNum  = '" + p_Ltr_ProgNum    + "'"
                 + " AND   Ltr_No       = '" + staffNo          + "'"
                 + " AND   Ltr_SubSeq   = '" + p_Ltr_SubSeq     + "'"
                 + " AND   Ltr_KwanNo   = '" + siselNo          + "'"
            ;
            stmt.executeUpdate(sSql);
            msg = "삭제되었습니다";
        }
    //out.println ( "sSql : " + sSql );
        //throw new SQLException("ss");
    } // end if
} // end if
} catch(java.lang.NullPointerException e) {
    out.println("error : " + e.toString() + "<BR>");
    msg = e.toString();
    error = true;
%>
    <%@ include file="../common/trace_NullPointerException.inc"%>
<%
} catch(SQLException e) {
    out.println("error : " + e.toString() + "<BR>");
    msg = e.toString();
    error = true;
%>
    <%@ include file="../common/trace_SQLException.inc"%>
<%
} catch(Exception e) {
    out.println("error : " + e.toString() + "<BR>");
    msg = e.toString();
    error = true;
%>
    <%@ include file="../common/trace_Exception.inc"%>
<%
} finally {
    if ( conn   != null ) conn.close();
    if ( pstmt  != null ) pstmt.close();
    if ( stmt   != null ) stmt.close();
    if ( rs     != null ) rs.close  ();
  //out.println ("finally");
}
%>
<script language="JavaScript" type="text/JavaScript">
    var msg = '<%=msg.replace("'","\"")%>';
    if ( msg ) {
        alert(msg);
    }
<%if (!error) {%>
    var param  = "";
    parent.document.location.reload();
<%}%>
</script>
#T=        - 조회
<%@ page contentType="text/html;charset=UTF-8" %>
<%@ page language="java" import="java.sql.*, java.util.*, java.text.*, afs.member.*, afs.common.*" %>
<%@ include file="../common/common.inc"%>
<%!
/*메소드 / 전역변수 선언 */
%>
<%
    /* 클래스 */
    KoreanDecoding  kd = new KoreanDecoding();

    /* Database */
    Connection  conn    = null;
    Statement   stmt    = null;
    ResultSet   rs      = null;
    String      sSql    = ""  ;

    /* 파라메터 */
    String s_frDate = fixNull(request.getParameter("s_frDate"));
    String s_toDate = fixNull(request.getParameter("s_toDate"));
    //out.println("s_frDate : " + s_frDate + "<BR>");
    //out.println("s_toDate : " + s_toDate + "<BR>");

    /* 변수 */
    String strParams = "";
%>
<%
try {
%>
<%@ include file="../common/header.inc"%>
<script language="javascript" type="text/JavaScript" src='../common/js/asyncConnector.js'></script>
<script language="JavaScript" type="text/JavaScript" src="../common/js/hashTable.js"></script>
<script language="JavaScript" type="text/JavaScript">
    function fCourseSearch(ltrNo) {
        var ajax = new asyncConnector('xmlhttp');

        var url = 'program_course_inner.jsp'
                + '?s_ltr_no=' + ltrNo;
        //alert(url1);
        ajax.openCallBack= function () {
            if ( ajax.readyState() == 4 ) {
                var str = ajax.responseText().trim();
                if (str)
                {
                    //alert( str );
                    ajax.dataArea.innerHTML = str;
                    //reSelectGwaJung(codeNum,sObj,sVal);
                }
            }
        }

        //alert( url );
        ajax.open(url,$("data_area_02"),'GET',true);
    }

    function init() {
        fCourseSearch($('tbl1').rows[1].cells[0].innerText);
        //$("Ltr_CourCode").value = "";
        //$("Ltr_Week").value     = "";

        //$("F1timeH").value  = "";$("F1timeM").value = "";
        //$("T1timeH").value  = "";$("T1timeM").value = "";
        selectedRow($('tbl1').rows[1]);
    }
</Script>
<%@ include file="../common/conn.inc"%>
<%
    stmt = conn.createStatement(); // stmt 생성
%>
<SCRIPT LANGUAGE="JavaScript">
<!--
    var gwaJungHt = new hashTable();
    function common02(comNum,comNumDet,comName,comUse) {
        this.comNum     = comNum    ;
        this.comNumDet  = comNumDet ;
        this.comName    = comName   ;
        this.comUse     = comUse    ;
    }
<%
    Vector v1 = CommonLib.getCommon02("0002","", "", stmt);

    int s1 = v1.size();
    for( int j=0;j<s1;j++) {
        Common02 cV = (Common02) v1.elementAt(j);
        //out.println("gwaJungHt.putValue('" + cV.getComNum() + "_" + cV.getComNumDet() + "', new common02( '" + cV.getComNum() + "','" + cV.getComNumDet() + "','" + cV.getComName() + "') );");
        out.println("gwaJungHt.putValue('0002_" + cV.getComNumDet() + "', new common02( '" + cV.getComNum() + "','" + cV.getComNumDet() + "','" + cV.getComName() + "') );");
        //out.println("getComNum : " + cV.getComNum()     + "<BR>");
        //out.println("getComName : " + cV.getComName()   + "<BR>");
    }

    Vector v2 = CommonLib.getCommon02("0003","", "", stmt);

    int s2 = v2.size();
    for( int j=0;j<s2;j++) {
        Common02 cV = (Common02) v2.elementAt(j);
        out.println("gwaJungHt.putValue('0003_" + cV.getComNumDet() + "', new common02( '" + cV.getComNum() + "','" + cV.getComNumDet() + "','" + cV.getComName() + "') );");
        //out.println("getComNum : " + cV.getComNum()     + "<BR>");
        //out.println("getComName : " + cV.getComName()   + "<BR>");
    }
%>
function reSelectGwaJung(codeNum,sObj,sVal) {
    //alert( gwaJungHt.getSize() );
    //alert( codeNum + " / " +  sObj.id + " / " +  sVal );
    while (sObj.firstChild) {
        sObj.removeChild(sObj.firstChild);
    }
    for( var i=0;i<gwaJungHt.getSize();i++) {
        //alert( codeNum + " / " + gwaJungHt.v[i].key.split("_")[1]);
        if (codeNum == gwaJungHt.v[i].key.split("_")[0]) {
            sObj.options[sObj.options.length] = new Option(gwaJungHt.v[i].value.comName, gwaJungHt.v[i].value.comNumDet)
            //alert ( sVal + " / " + parseInt(gwaJungHt.v[i].value.comNumDet,10) +  " / " + gwaJungHt.v[i].value.comName);
            if (parseInt(sVal,10) == parseInt(gwaJungHt.v[i].value.comNumDet,10) ) {
                sObj.options[sObj.options.length-1].selected = true;
            }
        }
    }
}

function f_Save() {
    var Ltr_OpSdate = parseInt(document.wForm.Ltr_OpSdate.value.replace(/-/g,''),10);
    var Ltr_OpEdate = parseInt(document.wForm.Ltr_OpEdate.value.replace(/-/g,''),10);
    var mode = document.wForm.mode.value;
    var ltrCourCode = '';
    var ltrActCode  = '';
    if ( mode == 'I' ) {
        ltrCourCode = document.wForm.Ltr_CourCode.value     ;
        ltrActCode  = document.wForm.Ltr_ActCode.value      ;

        document.wForm.p_Ltr_CourCode.value = ltrCourCode   ;
        document.wForm.p_Ltr_ActCode.value  = ltrActCode    ;
    } else {
        ltrCourCode = document.wForm.p_Ltr_CourCode.value   ;
        ltrActCode  = document.wForm.p_Ltr_ActCode.value    ;
    }

    if ( 
        ( mode == 'I' || mode == 'U' ) && ltrCourCode && ltrActCode
       ) {
        if (!document.wForm.Ltr_Prog.value.trim()) {
            alert('프로그램명을 입력해주세요');
            document.wForm.Ltr_Prog.focus();
            return;
        }

        if (!document.wForm.Ltr_OpSdate.value) {
            alert('운영시작일자를 입력해주세요');
            document.wForm.Ltr_OpSdate.focus();
            return;
        }
        if (!document.wForm.Ltr_OpEdate.value) {
            alert('운영종료일자 입력해주세요');
            document.wForm.Ltr_OpEdate.focus();
            return;
        }

        if (Ltr_OpSdate > Ltr_OpEdate) {
            alert('시작일자가 종료일자보다 크게 입력되었습니다.');
            document.wForm.Ltr_OpSdate.focus();
            return;
        }

        if (!document.wForm.Ltr_Ban.value) {
            alert('담당반을 입력해주세요');
            document.wForm.Ltr_Ban.focus();
            return;
        }
 
        document.wForm.Ltr_CourCode.disabled = false;
        document.wForm.Ltr_ActCode.disabled = false;
        document.wForm.submit();
    } else {
        alert('과정/담당영역을 선택해주세요.');
        if (!ltrCourCode) document.wForm.Ltr_CourCode.focus();
        else if (!ltrActCode ) document.wForm.Ltr_ActCode.focus();
    }
}

function f_Delete(rowIdx) {
    if (confirm(" 삭제하시겠습니까? ")){
        var info = $('tbl_course').rows[rowIdx+1].cells[0].innerText.split('|');
        document.wForm.p_Ltr_ProgNum.value  = info[0];
        document.wForm.p_Ltr_No.value       = info[1];

        document.wForm.p_Ltr_CourCode.value = info[2];
        document.wForm.p_Ltr_ActCode.value  = info[3];

        document.wForm.Ltr_CourCode.value   = info[2];

        document.wForm.mode.value = 'D';
        document.wForm.submit();
    }
}

function f_Update(rowIdx){
    var info = $('tbl_course').rows[rowIdx+1].cells[0].innerText.split('|');
    // Ltr_ProgNum|Ltr_No|Ltr_CourCode|Ltr_ActCode|Ltr_OpSdate|Ltr_OpEdate|Ltr_WeekNum|Ltr_FrTime|Ltr_ToTime|Ltr_Ban|
    //document.getElementById('cal_s_img').style.visibility = 'hidden';
    //document.getElementById('cal_e_img').style.visibility = 'hidden';
    document.wForm.p_Ltr_ProgNum.value  = info[0];
    document.wForm.p_Ltr_No.value       = info[1];

    document.wForm.p_Ltr_CourCode.value = info[2];
    document.wForm.p_Ltr_ActCode.value  = info[3];

    document.wForm.Ltr_CourCode.value   = info[2];

    reSelectGwaJung(info[2],document.wForm.Ltr_ActCode,info[3]);

    document.wForm.Ltr_Prog.value      = info[4];
    document.wForm.Ltr_OpSdate.value   = info[5];
    document.wForm.Ltr_OpEdate.value   = info[6];
    document.wForm.Ltr_WeekNum.value   = info[7];
    if (info[8].length == 5) {
        fTimeInfo = info[8].split(':');
        document.wForm.Ltr_FrTime_H.value    = fTimeInfo[0];
        document.wForm.Ltr_FrTime_M.value    = fTimeInfo[1];
    }
    if (info[9].length == 5) {
        tTimeInfo = info[9].split(':');
        document.wForm.Ltr_ToTime_H.value    = tTimeInfo[0];
        document.wForm.Ltr_ToTime_M.value    = tTimeInfo[1];
    }
    //alert( info[10] );
    document.wForm.Ltr_Ban.value    = info[10];
    document.wForm.mode.value = 'U';
}

var oldRow = null;
function selectedRow(o){
    if (oldRow ==null || o.rowIndex != oldRow.rowIndex) {
        o.className = 'selectedRow';
        if (oldRow) {
            oldRow.className = oldRow.className.replace(/selectedRow/g,'');
        }
        o.cells[1].setActive();
        fCourseSearch(o.cells[0].innerText);
    }
    oldRow = o;
    //alert( o);
}

function selectedUpDnRow(o){
    var code = event.keyCode;
//[trap = 38] 상
//[trap = 40] 하
    if ( code == 38 ) {
        o.setActive();
        var rIdx = o.rowIndex - 1;
        if ( rIdx > 0 ) {
            selectedRow($('tbl1').rows[rIdx]);
            //scrollRow(rIdx);
        }
    } else if ( code == 40 ) {
        //alert ( o.rowIndex );
        var rIdx = o.rowIndex + 1;
        if ( $('tbl1').rows.length > rIdx ) {
            selectedRow($('tbl1').rows[rIdx]);
            //scrollRow(rIdx);
        }
    }
}

function scrollRow(rowIdx){
    var rowIndex  = rowIdx;
    try {
        if ( $('tbl1').rows[rowIndex].offsetTop + $('tbl1').rows[rowIndex].offsetHeight  > $('data_area_01').clientHeight ) {
            $('data_area_01').scrollTop = $('tbl1').rows[rowIndex].offsetTop + $('tbl1').rows[rowIndex].offsetHeight  - $('data_area_01').clientHeight;
        } else {
            $('data_area_01').scrollTop = 0;
        }
    }
    catch (e) {
    }
}

//-->
</SCRIPT>
<style>
    .selectedRow {background-color:#66FF99;color:#000000}
</style>
<body onload='init();'>
<table id="bg">
  <tr>
    <td width="15" valign="top" style="padding:99px 0 0 0"><img src="../images/menu_bar_bg.gif" width="15" height="30"></td>
    <td width="199" align="center" valign="top">
        <div style="height:86; padding:12px 0 0 0"><img src="../images/logo.gif" alt="방과후 청소년 아카데미 logo" width="125" height="59"></div>
        <div><img src="../images/menu_box_top.gif" width="199" height="13"></div>
        <jsp:include page="../staff/staff_menu.jsp"/>
    </td>


    <input type=hidden name="mode" value="I">
    <td align="center" valign="top">
          <div><img src="../images/main_visual_staff.gif" alt="실무자관리를 위한 인트라넷" width="776" height="99"></div>
          <table width="776" background="../images/menu_bar_bg.gif">
            <tr>
              <td class="info"><%=toDayStr%> * 안녕하세요. <span class="info_name"><%=staffName%> 님</span>. </td>
              <td width="109"><a href="../logout.jsp"><img src="../images/menu_bar_logout.gif" alt="로그아웃" width="108" height="30" border="0"></a></td>
            </tr>
          </table>

        <div id="contents">
        <table width="100%" class="con_title">
            <tr>
                <td width="400"><img src="../images/t_title/t_b_01.gif" alt="프로그램운영계획서"  width="160" height="28"></td>
                <td class="route"><img src="../images/route_arrow.gif"  width="5" height="5" align="absmiddle"> 실무자관리 <img src="../images/route_arrow2.gif"  width="8" height="9" align="absmiddle"> 강사과정관리 </td>
            </tr>
        </table>

        <div class="button"><Button onclick="javascript:getExcelView('청소년 면담종합기록',['tbl1','tbl2','tbl3'],true)" class='btn_gb' title='워드파일로 저장합니다.'>워드</Button> <a href="#"><img src="../images/btn/btn_save.gif" alt="저장하기" width="74" height="25" border="0"onClick="f_Save()"></a></div>

        <div id='data_area_01' style='width:760;height:130;overflow-x:hidden;overflow-y:scroll;'>
        <table class="board" id='tbl1'>
            <colgroup>
            <col width="40"/>
            <col width="120"/>
            <col width=""/>
            <col width="100"/>
            <col width="160"/>
            <col width=""/>
            </colgroup>
            <tr class='lock_head'>
            <th>NO.</th>
            <th>강사명</th>
            <th>주민번호</th>
            <th>전화번호</th>
            <th>계약기간</th>
            <th></th>
            </tr>
        <%
                String Ltr_No    ="";
                String Ltr_Name  ="";
                String Ltr_Jumin ="";
                String Ltr_Tel   ="";
                String Ltr_FrDate="";
                String Ltr_ToDate="";

                sSql  = "SELECT "
                      + " a.* "
                      + " FROM Lecturer_001 a"
                      + " WHERE Ltr_KwanCode = '" + siselNo + "'"
                      + " ORDER BY Ltr_Name  "
                    ;
                //out.println("sSql : " + sSql + "<BR>");
                rs = stmt.executeQuery(sSql);

                for(int i=0;rs.next();i++) {
                    Ltr_No      = rs.getString("Ltr_No"     );
                    Ltr_Name    = rs.getString("Ltr_Name"   );
                    Ltr_Jumin   = rs.getString("Ltr_Jumin"  );
                    Ltr_Tel     = rs.getString("Ltr_Tel"    );
                    Ltr_FrDate  = rs.getString("Ltr_FrDate" );
                    Ltr_ToDate  = rs.getString("Ltr_ToDate" );
        %>
            <tr style="cursor:hand;" onclick='selectedRow(this);' onkeydown='selectedUpDnRow(this);'>
            <td onClick="" style='display:none'><%=Ltr_No%></td>
            <td onClick="fCourseSearch('<%=Ltr_No%>','<%=i+1%>')"><%=i+1%></td>
            <td onClick="fCourseSearch('<%=Ltr_No%>','<%=i+1%>')"><%=Ltr_Name%></td>
            <td onClick="fCourseSearch('<%=Ltr_No%>','<%=i+1%>')"><%=Ltr_Tel%></td>
            <td onClick="fCourseSearch('<%=Ltr_No%>','<%=i+1%>')"><%=Ltr_Jumin%></td>
            <td onClick="fCourseSearch('<%=Ltr_No%>','<%=i+1%>')"><%=Ltr_FrDate%> ~ <%=Ltr_FrDate%></td>
            <td onClick="fCourseSearch('<%=Ltr_No%>','<%=i+1%>')">&nbsp;</td>
            </tr>
        <%
                }
        %>
        </table>
        </div>

        <div class="con_title_a">과정</div>
        <div id='data_area_02'></div>
        <div id='data_area_03'></div>
        </div>
        <iframe id=tmpIframe name=tmpIframe style='width:100%;height:100;display:none1'></iframe>
    </td>
    <td align="center" valign="top"><%@ include file="../common/right_banner.inc"%></td>

  </tr>
</table>
<!-- copyright -->
<div class="copy"><img src="../images/copyright.gif" alt="카피라이트" width="843" height="47"></div>
<!-- // copyright -->
</html>
<%
    //throw new SQLException("ss");
} catch(java.lang.NullPointerException e) {
%>
    <%@ include file="../common/trace_NullPointerException.inc"%>
<%
} catch(SQLException e) {
%>
    <%@ include file="../common/trace_SQLException.inc"%>
<%
} catch(Exception e) {
%>
    <%@ include file="../common/trace_Exception.inc"%>
<%
} finally {
    if ( conn != null ) conn.close();
    if ( stmt != null ) stmt.close();
    if ( rs   != null ) rs.close  ();
  //out.println ("finally");
}
%>
#T=        - 보기
<%@ page contentType="text/html;charset=UTF-8" %>
<%@ page language="java" import="java.sql.*, java.util.*, java.text.*, afs.member.*, afs.common.*" %>
<%@ include file="../common/common.inc"%>
<%!
/*메소드 / 전역변수 선언 */
%>
<%
/* 파라메터 */
String s_Ltr_ProgNum    = fixNull(request.getParameter("s_Ltr_ProgNum"));
String s_Ltr_SubSeq     = fixNull(request.getParameter("s_Ltr_SubSeq" ));
//out.println("s_Ltr_SubSeq : " + s_Ltr_SubSeq + "<BR>");
//out.println("s_Ltr_SubSeq : " + s_Ltr_SubSeq + "<BR>");

if ( !s_Ltr_ProgNum.equals("") && !s_Ltr_SubSeq.equals("") ) {
    /* Database */
    Connection  conn    = null;
    Statement   stmt    = null;
    ResultSet   rs      = null;
    String      sSql    = ""  ;

    /* 클래스 */
    KoreanDecoding  kd = new KoreanDecoding();

%>
<%@ include file="../common/conn.inc"%>
<%
try {
    stmt = conn.createStatement(); // stmt 생성

    sSql = " SELECT "
        + " Ltr_ProgNum"
        + " FROM Lecturer_017"
        + " WHERE Ltr_ProgNum   = '" + s_Ltr_ProgNum + "'"
        + " AND   Ltr_No        = '" + staffNo       + "'"
        + " AND   Ltr_SubSeq    = '" + s_Ltr_SubSeq  + "'"
        ;
    //out.println("sSql : " + sSql + "<BR>");
    rs = stmt.executeQuery(sSql);
    rs.next();
    s_Ltr_ProgNum = fixNull(rs.getString(1));
    //out.println("s_Ltr_ProgNum : " + s_Ltr_ProgNum   + "<BR>");
    if ( !s_Ltr_ProgNum.equals("") ) {
// --------------- --------------- --------------- --------------- --------------- //
    /* 변수 */
    //String strParams = "";
%>
<%@ include file="../common/header.inc"%>
<script language="javascript" type="text/JavaScript" src='../common/js/asyncConnector.js'></script>
<script language="JavaScript" type="text/JavaScript" src="../common/js/hashTable.js"></script>
<script language="JavaScript" type="text/JavaScript">
    function init() {
        self.focus();
    }

    function f_Save() {
        if ( !document.wForm.Ltr_EduCont.value.trim() ) {
            alert('내용 입력을 확인해주세요.');
            document.wForm.Ltr_EduCont.focus();
            return;
        }
        document.wForm.submit();
    }

    function f_closeWindow() {
        if ( confirm('창을 닫으시겠습니까?') ) {
            self.close();
        }
    }
</Script>
<style>
    .selectedRow {background-color:#66FF99;color:#000000}
    table.popboard textarea {border:0px solid #E4E1DC ;font-size:11px ;padding: 2px ; margin:1px; background-color:#ffffff}
    table.popboard input    {border:0px solid #E4E1DC ;font-size:11px ;padding: 2px ; margin:1px; background-color:#ffffff}
    body { overflow-y:auto; overflow-x:hidden } 
</style>
<body onload='init();' >
<iframe id=tmpIframe name=tmpIframe style='width:100%;height:100;display:none'></iframe>
<%
        sSql = " SELECT "
             + " a.Ltr_WriteDate Ltr_WriteDate      , "
             + " b.Ltr_CourCode  Ltr_CourCode       , "
             + " b.Ltr_ActCode   Ltr_ActCode        , "
             + " b.Ltr_Prog      Ltr_Prog           , "
             + " c.Com_Name      Ltr_CourCodeName   , "
             + " d.Com_Name      Ltr_ActCodeName      "
             + " FROM Lecturer_017 a, Lecturer_015 b, Common_001 c, Common_002 d"
             + " WHERE a.Ltr_ProgNum  = '" + s_Ltr_ProgNum+ "'"
             + " AND   a.Ltr_No       = '" + staffNo      + "'"
             + " AND   a.Ltr_SubSeq   = '" + s_Ltr_SubSeq + "'"
             + " AND   a.Ltr_KwanNo   = '" + siselNo      + "'"
             + " AND   a.Ltr_ProgNum  = b.Ltr_Prognum "
             + " AND   a.Ltr_No       = b.Ltr_No    "
             + " AND   b.Ltr_CourCode = c.Com_Num   "
             + " AND   b.Ltr_CourCode = d.Com_Num   "
             + " AND   b.Ltr_ActCode  = d.Com_NumDet"
             ;
        //out.println("sSql : " + sSql + "<BR>");
        String Ltr_CourCode     = "";
        String Ltr_ActCode      = "";
        String Ltr_CourCodeName = "";
        String Ltr_ActCodeName  = "";
        String Ltr_Prog         = "";
        String Ltr_WriteDate    = "";
        rs = stmt.executeQuery(sSql);
        if ( rs.next() ) {
            Ltr_CourCode    = fixNull(rs.getString("Ltr_CourCode"       ));
            Ltr_ActCode     = fixNull(rs.getString("Ltr_ActCode"        ));
            Ltr_CourCodeName= fixNull(rs.getString("Ltr_CourCodeName"   ));
            Ltr_ActCodeName = fixNull(rs.getString("Ltr_ActCodeName"    ));
            Ltr_Prog        = fixNull(rs.getString("Ltr_Prog"           ));
            Ltr_WriteDate   = fixNull(rs.getString("Ltr_WriteDate"      ));

            sSql = " SELECT "
                + " Ltr_ProgNum    , "  // Lecturer_016.Ltr_ProgNum
                + " Ltr_No         , "  // 강사번호
                + " Ltr_SubSeq     , "  // 서브 Seq

                + " Ltr_WeekNum    , "  // 작성주

                + " Ltr_DateTime   , "  // 활동 일시
                + " Ltr_EduCont    , "  // 내용
                + " Ltr_Place      , "  // 장소
                + " Ltr_Goal       , "  // 목적 및 목표
                + " Ltr_TeahcerName, "  // 지도자/강사명
                + " Ltr_Material   , "  // 과제 및 준비물 안내

                + " Ltr_StTime     , "  // 도입시간
                + " Ltr_StCont1    , "  // 도입내용1
                + " Ltr_StCont2    , "  // 도입내용2

                + " Ltr_ExpTime    , "  // 전개시간
                + " Ltr_ExpCont1   , "  // 전개내용1
                + " Ltr_ExpCont2   , "  // 전개내용2

                + " Ltr_ArrTime    , "  // 정리시간
                + " Ltr_ArrCont1   , "  // 정리내용1
                + " Ltr_ArrCont2   , "  // 정리내용2

                + " Ltr_Prep       , "  // 운영관리 - 준비물
                + " Ltr_Estimate   , "  // 운영관리 - 소요예산
                + " Ltr_Evaluate   , "  // 운영관리 - 평가방법
                + " Ltr_Attend     , "  // 지도상 유의사항
                + " Ltr_Effect     , "  // 기대효과

                + " Ltr_RegDate    , "  // 등록일시
                + " Ltr_ModDate    , "  // 수정일자
                + " Ltr_KwanNo       "  // 기관번호
                + " FROM Lecturer_018 a"
                + " WHERE Ltr_ProgNum   = '" + s_Ltr_ProgNum + "'"
                + " AND   Ltr_No        = '" + staffNo       + "'"
                + " AND   Ltr_SubSeq    = '" + s_Ltr_SubSeq  + "'"
                ;
            //out.println("sSql : " + sSql + "<BR>");
            rs = stmt.executeQuery(sSql);
            String mode           ="";

            String Ltr_ProgNum    ="";
            String Ltr_No         ="";
            String Ltr_SubSeq     ="";

            String Ltr_WeekNum    ="";

            String Ltr_DateTime   ="";
            String Ltr_EduCont    ="";
            String Ltr_Place      ="";
            String Ltr_Goal       ="";
            String Ltr_TeahcerName="";
            String Ltr_Material   ="";

            String Ltr_StTime     ="";
            String Ltr_StCont1    ="";
            String Ltr_StCont2    ="";

            String Ltr_ExpTime    ="";
            String Ltr_ExpCont1   ="";
            String Ltr_ExpCont2   ="";

            String Ltr_ArrTime    ="";
            String Ltr_ArrCont1   ="";
            String Ltr_ArrCont2   ="";

            String Ltr_Prep       ="";
            String Ltr_Estimate   ="";
            String Ltr_Evaluate   ="";
            String Ltr_Attend     ="";
            String Ltr_Effect     ="";

            String Ltr_RegDate    ="";
            String Ltr_ModDate    ="";
            String Ltr_KwanNo     ="";

            String Ltr_DateTime_D = Ltr_WriteDate;
            String Ltr_DateTime_H ="";
            String Ltr_DateTime_M ="";

            if ( rs.next() ) {
                Ltr_ProgNum     = fixNull(rs.getString("Ltr_ProgNum"    ));
                Ltr_No          = fixNull(rs.getString("Ltr_No"         ));
                Ltr_SubSeq      = fixNull(rs.getString("Ltr_SubSeq"     ));

                Ltr_WeekNum     = fixNull(rs.getString("Ltr_WeekNum"    ));

                Ltr_DateTime    = fixNull(rs.getString("Ltr_DateTime"   ));
                Ltr_EduCont     = fixNull(rs.getString("Ltr_EduCont"    ));
                Ltr_Place       = fixNull(rs.getString("Ltr_Place"      ));
                Ltr_Goal        = fixNull(rs.getString("Ltr_Goal"       ));
                Ltr_TeahcerName = fixNull(rs.getString("Ltr_TeahcerName"));
                Ltr_Material    = fixNull(rs.getString("Ltr_Material"   ));

                Ltr_StTime      = fixNull(rs.getString("Ltr_StTime"     ));
                Ltr_StCont1     = fixNull(rs.getString("Ltr_StCont1"    ));
                Ltr_StCont2     = fixNull(rs.getString("Ltr_StCont2"    ));

                Ltr_ExpTime     = fixNull(rs.getString("Ltr_ExpTime"    ));
                Ltr_ExpCont1    = fixNull(rs.getString("Ltr_ExpCont1"   ));
                Ltr_ExpCont2    = fixNull(rs.getString("Ltr_ExpCont2"   ));

                Ltr_ArrTime     = fixNull(rs.getString("Ltr_ArrTime"    ));
                Ltr_ArrCont1    = fixNull(rs.getString("Ltr_ArrCont1"   ));
                Ltr_ArrCont2    = fixNull(rs.getString("Ltr_ArrCont2"   ));

                Ltr_Prep        = fixNull(rs.getString("Ltr_Prep"       ));
                Ltr_Estimate    = fixNull(rs.getString("Ltr_Estimate"   ));
                Ltr_Evaluate    = fixNull(rs.getString("Ltr_Evaluate"   ));
                Ltr_Attend      = fixNull(rs.getString("Ltr_Attend"     ));
                Ltr_Effect      = fixNull(rs.getString("Ltr_Effect"     ));

                Ltr_RegDate     = fixNull(rs.getString("Ltr_RegDate"    ));
                Ltr_ModDate     = fixNull(rs.getString("Ltr_ModDate"    ));
                Ltr_KwanNo      = fixNull(rs.getString("Ltr_KwanNo"     ));

                mode = "U";
                Ltr_DateTime_D =Ltr_DateTime.substring(0,10);
                Ltr_DateTime_H =Ltr_DateTime.substring(11,13);
                Ltr_DateTime_M =Ltr_DateTime.substring(14,16);
                //out.println("Ltr_DateTime   : " + Ltr_DateTime   + "<BR>");
                //out.println("Ltr_DateTime_D : " + Ltr_DateTime_D + "<BR>");
                //out.println("Ltr_DateTime_H : " + Ltr_DateTime_H + "<BR>");
                //out.println("Ltr_DateTime_M : " + Ltr_DateTime_M + "<BR>");

            } else {
                mode = "I";
                Ltr_DateTime_D =Ltr_WriteDate;
                Ltr_DateTime_H ="00";
                Ltr_DateTime_M ="00";
            }
%>
    <!--  topbar -->
    <table width="100%" class="pop_topbar">
        <tr>
            <td><img src="../images/pop_top_bar_a.gif" width="6" height="8"></td>
            <td width="6"><img src="../images/pop_top_bar_b.gif" alt="수업계획서" width="6" height="8"></td>
        </tr>
    </table>
<%
if ( Ltr_CourCode.equals("0002") ) { // 기본공통과정
%>
    <div id="contents" style='overflow:hidden;height:640'>
    <!--  subtitle -->
    <table width="100%" class="con_title">
        <tr>
            <td>
            <H1>운영지도안</H1>
            </td>
            <td class="route"><img src="../images/route_arrow.gif" width="5" height="5" align="absmiddle"> 강사관리 <img src="../images/route_arrow2.gif"width="8" height="9" align="absmiddle"> 프로그램운영계획서<img src="../images/route_arrow2.gif"width="8" height="9" align="absmiddle"> 운영지도안 </td>
        </tr>
    </table>
        <!-- // subtitle -->
        <!-- button -->
<form name="wForm" method="post" target='tmpIframe' action="2_1ProgramPlanActDocReg_act.jsp">
    <input type=hidden name='mode' value='<%=mode%>'>
    <input type=hidden name='p_Ltr_ProgNum' value='<%=s_Ltr_ProgNum%>'>
    <input type=hidden name='p_Ltr_SubSeq'  value='<%=s_Ltr_SubSeq %>'>

    <div class="button"><Button onclick="javascript:getExcelView('프로그램 활동지도안','tbl1',true)" class='btn_gb' title='워드파일로 저장합니다.'>워드</Button><a href="javascript:f_Save()"><img src="../images/btn/btn_save.gif" alt="저장하기" width="74" height="25" border="0"></a><a href="javascript:f_closeWindow()"> <img src="../images/btn/btn_colse.gif" alt="닫기" width="74" height="25" border="0"></a></div>
        <!-- // button -->
            <!--  box2 -->
            <table width="100%" style="margin:0 0 10px 0 " id=tbl1>
          <tr>
            <td width="10"><img src="../images/box_input_a.gif" width="10" height="10"></td>
            <td background="../images/box_input_b.gif"></td>
            <td width="10"><img src="../images/box_input_c.gif" width="10" height="10"></td>
          </tr>
          <tr>
            <td background="../images/box_input_h.gif"></td>
            <td>
                <table cellspacing="1" class="popboard">
                  <colgroup>
                  <col width="100"/>
                  <col width=""/>
                  <col width="80"/>
                  <col width="100"/>
                  <col width="80"/>
                  <col width="100"/>
                  </colgroup>
                  <tr>
                    <th>과 정</th>
                    <td>
                    <%=Ltr_CourCodeName%> ( <%=Ltr_ActCodeName%> )
                    </td>
                    <th>프로그램명</th>
                    <td><%=Ltr_Prog%></td>
                    <th>강사</th>
                    <td><%=staffName%></td>
                  </tr>
                  <tr>
                    <th>내 용</th>
                    <td colspan="5"><input type="text" name="Ltr_EduCont" style="width:100%" value='<%=Ltr_EduCont%>'>
                  </tr>
                  <tr>
                    <th>일 시</th>
                    <td>
                    <input type="text" name="Ltr_DateTime_D" style="width:61px " value="<%=Ltr_DateTime_D%>" readonly>
                   <!--  <img src="../images/icon_calender.gif" style='cursor:hand' alt="달력" width="23" height="16" border="0" align="absmiddle" onClick="javascript:popupCalendar(document.wForm,document.wForm.Ltr_DateTime_D);"> -->
                    <select name='Ltr_DateTime_H' id='Ltr_DateTime_H' style='width:36;display:inline'>
                        <option value='00'>00</option>
                        <option value='01'>01</option>
                        <option value='02'>02</option>
                        <option value='03'>03</option>
                        <option value='04'>04</option>
                        <option value='05'>05</option>
                        <option value='06'>06</option>
                        <option value='07'>07</option>
                        <option value='08'>08</option>
                        <option value='09'>09</option>
                        <option value='10'>10</option>
                        <option value='11'>11</option>
                        <option value='12'>12</option>
                        <option value='13'>13</option>
                        <option value='14'>14</option>
                        <option value='15'>15</option>
                        <option value='16'>16</option>
                        <option value='17'>17</option>
                        <option value='18'>18</option>
                        <option value='19'>19</option>
                        <option value='20'>20</option>
                        <option value='21'>21</option>
                        <option value='22'>22</option>
                        <option value='23'>23</option>
                    </select>:<select name='Ltr_DateTime_M' id='Ltr_DateTime_M' style='width:36;display:inline'>
                        <option value='00'>00</option>
                        <option value='01'>01</option>
                        <option value='02'>02</option>
                        <option value='03'>03</option>
                        <option value='04'>04</option>
                        <option value='05'>05</option>
                        <option value='06'>06</option>
                        <option value='07'>07</option>
                        <option value='08'>08</option>
                        <option value='09'>09</option>
                        <option value='10'>10</option>
                        <option value='11'>11</option>
                        <option value='12'>12</option>
                        <option value='13'>13</option>
                        <option value='14'>14</option>
                        <option value='15'>15</option>
                        <option value='16'>16</option>
                        <option value='17'>17</option>
                        <option value='18'>18</option>
                        <option value='19'>19</option>
                        <option value='20'>20</option>
                        <option value='21'>21</option>
                        <option value='22'>22</option>
                        <option value='23'>23</option>
                        <option value='24'>24</option>
                        <option value='25'>25</option>
                        <option value='26'>26</option>
                        <option value='27'>27</option>
                        <option value='28'>28</option>
                        <option value='29'>29</option>
                        <option value='30'>30</option>
                        <option value='31'>31</option>
                        <option value='32'>32</option>
                        <option value='33'>33</option>
                        <option value='34'>34</option>
                        <option value='35'>35</option>
                        <option value='36'>36</option>
                        <option value='37'>37</option>
                        <option value='38'>38</option>
                        <option value='39'>39</option>
                        <option value='40'>40</option>
                        <option value='41'>41</option>
                        <option value='42'>42</option>
                        <option value='43'>43</option>
                        <option value='44'>44</option>
                        <option value='45'>45</option>
                        <option value='46'>46</option>
                        <option value='47'>47</option>
                        <option value='48'>48</option>
                        <option value='49'>49</option>
                        <option value='50'>50</option>
                        <option value='51'>51</option>
                        <option value='52'>52</option>
                        <option value='53'>53</option>
                        <option value='54'>54</option>
                        <option value='55'>55</option>
                        <option value='56'>56</option>
                        <option value='57'>57</option>
                        <option value='58'>58</option>
                        <option value='59'>59</option>
                    </select>
<SCRIPT LANGUAGE="JavaScript">
<!--
    document.wForm.Ltr_DateTime_H.value = '<%=Ltr_DateTime_H%>';
    document.wForm.Ltr_DateTime_M.value = '<%=Ltr_DateTime_M%>';
//-->
</SCRIPT>

                    </td>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                    <th>장 소</th>
                    <td><input type="text" name="Ltr_Place" style="width:100%" value='<%=Ltr_Place%>'></td>
                  </tr>
                  <tr>
                    <th>목적 및 목표</th>
                    <td colspan="5"><textarea name="Ltr_Goal" rows="2" style="width:100%"><%=Ltr_Goal%></textarea></td>
                  </tr>

                </table>
                <table cellspacing="1" class="popboard tm10">
                  <colgroup>
                  <col width="80"/>
                  <col width="155"/>
                  <col width="80"/>
                  <col width=""/>
                  <col width="80"/>
                  <col width="155"/>
                  </colgroup>

                  <tr>
                    <th>과제 및 준비물 안내</th>
                    <td><textarea name="Ltr_Material" rows="2" style="width:100%"><%=Ltr_Material%></textarea></td>
                  </tr>
                </table>
                <table cellspacing="1" class="popboard tm10">
                  <colgroup>
                  <col width="100"/>
                  <col width=""/>
                  <col width="150"/>
                  </colgroup>
                  <tr>
                    <th>단 계</th>
                    <th>프로그램 내용</th>
                    <th>지도시 유의사항</th>
                  </tr>
                  <tr>
                    <th class="2dth">도 입<br>
                      (
                      <input type="text" name="Ltr_StTime" style="width:50px " value='<%=Ltr_StTime%>' onpropertychange='enforceNumber()'>
                      분)</th>
                    <td><span class="top">
                      <textarea name="Ltr_StCont1" rows="7" style="width:100%; height:90"><%=Ltr_StCont1%></textarea>
                    </span></td>
                    <td><span class="top">
                    <textarea name="Ltr_StCont2" rows="7" style="width:100%; height:90" value=''><%=Ltr_StCont2%></textarea>
                    </span></td>
                  </tr>
                  <tr>
                    <th class="2dth">전 개<br>
                      (<input type="text" name="Ltr_ExpTime" style="width:50px " value='<%=Ltr_ExpTime%>' onpropertychange='enforceNumber()'>분)</th>
                    <td><span class="top">
                        <textarea name="Ltr_ExpCont1" rows="7" style="width:100%; height:90"><%=Ltr_ExpCont1%></textarea>
                        </span></td>
                    <td><span class="top">
                        <textarea name="Ltr_ExpCont2" rows="7" style="width:100%; height:90"><%=Ltr_ExpCont2%></textarea>
                        </span></td>
                  </tr>
                  <tr>
                    <th class="2dth">정 리<br>
                      (<input type="text" name="Ltr_ArrTime" style="width:50px " value='<%=Ltr_ArrTime%>' onpropertychange='enforceNumber()'>분)</th>
                    <td><span class="top">
                      <textarea name="Ltr_ArrCont1" rows="7" style="width:100%; height:90"><%=Ltr_ArrCont1%></textarea>
                        </span></td>
                    <td><span class="top">
                        <textarea name="Ltr_ArrCont2" rows="7" style="width:100%; height:90"><%=Ltr_ArrCont2%></textarea>
                        </span></td>
                  </tr>
                </table>
            </td>
            <td background="../images/box_input_d.gif"></td>
          </tr>
          <tr>
            <td><img src="../images/box_input_g.gif" width="10" height="10"></td>
            <td background="../images/box_input_f.gif"></td>
            <td><img src="../images/box_input_e.gif" width="10" height="10"></td>
          </tr>
        </table>
            <!--  //box2 -->
    </form>
    <!-- // contents -->
    </div>
<%
    } else if ( Ltr_CourCode.equals("0003") ) { // 전문체험과정
%>
    <div id="contents" style='overflow-y:scroll;height:97%'>
    <table width="100%" class="con_title">
        <tr>
            <td>
            <H1>활동지도안</H1>
            </td>
            <td class="route"><img src="../images/route_arrow.gif" width="5" height="5" align="absmiddle"> 강사관리 <img src="../images/route_arrow2.gif"width="8" height="9" align="absmiddle"> 프로그램운영계획서<img src="../images/route_arrow2.gif"width="8" height="9" align="absmiddle"> 활동지도안 </td>
        </tr>
    </table>

<form name="wForm" method="post" target='tmpIframe' action="2_1ProgramPlanActDocReg_act.jsp">
    <input type=hidden name='mode' value='<%=mode%>'>
    <input type=hidden name='p_Ltr_ProgNum' value='<%=s_Ltr_ProgNum%>'>
    <input type=hidden name='p_Ltr_SubSeq'  value='<%=s_Ltr_SubSeq %>'>

    <div class="button"><Button onclick="javascript:getExcelView('프로그램 활동지도안','tbl1',true)" class='btn_gb' title='워드파일로 저장합니다.'>워드</Button><a href="javascript:f_Save()"><img src="../images/btn/btn_save.gif" alt="저장하기" width="74" height="25" border="0"></a><a href="javascript:f_closeWindow()"> <img src="../images/btn/btn_colse.gif" alt="닫기" width="74" height="25" border="0"></a></div>
            <table width="100%" style="margin:0 0 10px 0 " id=tbl1>
                <tr>
                    <td width="10"><img src="../images/box_input_a.gif" width="10" height="10"></td>
                    <td background="../images/box_input_b.gif"></td>
                    <td width="10"><img src="../images/box_input_c.gif" width="10" height="10"></td>
                </tr>
                <tr>
                    <td background="../images/box_input_h.gif"></td>
                    <td>
                        <table cellspacing="1" class="popboard">
                            <colgroup>
                            <col width="100"/>
                            <col width=""/>
                            <col width="80"/>
                            <col width="100"/>
                            <col width="80"/>
                            <col width="100"/>
                            </colgroup>
                                <th>프로그램명</th>
                                <td colspan="5"><%=Ltr_Prog%></td>
                            </tr>
                            <tr>
                                <th>프로그램 목표</th>
                                <td colspan="5"><input type="text" name="Ltr_Goal" style="width:100%" value='<%=Ltr_Goal%>'></td>
                            </tr>
                            <tr>
                                <th>활동개요</th>
                                <td colspan="5"><input type="text" name="Ltr_EduCont" style="width:100%" value='<%=Ltr_EduCont%>'></td>
                            </tr>
                            <tr>
                                <th>활동 일자</th>
                                <td>
                    <input type="text" name="Ltr_DateTime_D" style="width:61px " value="<%=Ltr_DateTime_D%>" readonly>
                    <!-- <img src="../images/icon_calender.gif" style='cursor:hand' alt="달력" width="23" height="16" border="0" align="absmiddle" onClick="javascript:popupCalendar(document.wForm,document.wForm.Ltr_DateTime_D);"> -->
                                </td>
                                <th>활동 시간</th>
                                <td>
                    <select name='Ltr_DateTime_H' id='Ltr_DateTime_H' style='width:36;display:inline'>
                        <option value='00'>00</option>
                        <option value='01'>01</option>
                        <option value='02'>02</option>
                        <option value='03'>03</option>
                        <option value='04'>04</option>
                        <option value='05'>05</option>
                        <option value='06'>06</option>
                        <option value='07'>07</option>
                        <option value='08'>08</option>
                        <option value='09'>09</option>
                        <option value='10'>10</option>
                        <option value='11'>11</option>
                        <option value='12'>12</option>
                        <option value='13'>13</option>
                        <option value='14'>14</option>
                        <option value='15'>15</option>
                        <option value='16'>16</option>
                        <option value='17'>17</option>
                        <option value='18'>18</option>
                        <option value='19'>19</option>
                        <option value='20'>20</option>
                        <option value='21'>21</option>
                        <option value='22'>22</option>
                        <option value='23'>23</option>
                    </select>:<select name='Ltr_DateTime_M' id='Ltr_DateTime_M' style='width:36;display:inline'>
                        <option value='00'>00</option>
                        <option value='01'>01</option>
                        <option value='02'>02</option>
                        <option value='03'>03</option>
                        <option value='04'>04</option>
                        <option value='05'>05</option>
                        <option value='06'>06</option>
                        <option value='07'>07</option>
                        <option value='08'>08</option>
                        <option value='09'>09</option>
                        <option value='10'>10</option>
                        <option value='11'>11</option>
                        <option value='12'>12</option>
                        <option value='13'>13</option>
                        <option value='14'>14</option>
                        <option value='15'>15</option>
                        <option value='16'>16</option>
                        <option value='17'>17</option>
                        <option value='18'>18</option>
                        <option value='19'>19</option>
                        <option value='20'>20</option>
                        <option value='21'>21</option>
                        <option value='22'>22</option>
                        <option value='23'>23</option>
                        <option value='24'>24</option>
                        <option value='25'>25</option>
                        <option value='26'>26</option>
                        <option value='27'>27</option>
                        <option value='28'>28</option>
                        <option value='29'>29</option>
                        <option value='30'>30</option>
                        <option value='31'>31</option>
                        <option value='32'>32</option>
                        <option value='33
#T=        - 이너(Ajavx)
<%@ page contentType="text/html;charset=UTF-8" %>
<%@ page language="java" import="java.sql.*, java.util.*, java.text.*, afs.member.*, afs.common.*" %>
<%@ include file="../common/common.inc"%>
<%!
/*메소드 / 전역변수 선언 */
%>
<%

    /* 클래스 */
    KoreanDecoding  kd = new KoreanDecoding();

    /* Database */
    Connection  conn    = null;
    Statement   stmt    = null;
    ResultSet   rs      = null;
    String      sSql    = ""  ;

    /* 파라메터 */
    //out.println("s_ltr_no : " + s_ltr_no + "<BR>");

    /* 변수 */
    String strParams = "";
%>
<%
try {
%>
<%@ include file="../common/conn.inc"%>
<%
    stmt = conn.createStatement(); // stmt 생성

String s_ltr_no = fixNull(request.getParameter("s_ltr_no"));
sSql = " SELECT "
    + " Ltr_No"
    + " FROM Lecturer_001"
    + " WHERE Ltr_No        = '" + s_ltr_no + "'"
    + " AND   Ltr_KwanCode  = '" + siselNo  + "'"
    ;
//out.println("sSql : " + sSql + "<BR>");
rs = stmt.executeQuery(sSql);
rs.next();
s_ltr_no = fixNull(rs.getString(1));

if ( !s_ltr_no.equals("") ) {
    Hashtable htCour    = new Hashtable();
    Vector v0 = CommonLib.getCommon01("'0002' ,'0003'","", stmt);
    int s0 = v0.size();
    for( int j=0;j<s0;j++) {
        Common01 cV = (Common01) v0.elementAt(j);
        htCour.put(cV.getComNum(), cV.getComName());
    }

    Hashtable htAct     = new Hashtable();
    Vector v1 = CommonLib.getCommon02("0002","", "", stmt);
    int s1 = v1.size();
    for( int j=0;j<s1;j++) {
        Common02 cV = (Common02) v1.elementAt(j);
        htAct.put(cV.getComNum() + "_" + cV.getComNumDet(), cV.getComName());
    }

    Vector v2 = CommonLib.getCommon02("0003","", "", stmt);
    int s12 = v2.size();
    for( int j=0;j<s1;j++) {
        Common02 cV = (Common02) v2.elementAt(j);
        htAct.put(cV.getComNum() + "_" + cV.getComNumDet(), cV.getComName());
    }

    sSql = " SELECT "
         + " Ltr_ProgNum , "
         + " Ltr_No      , "
         + " Ltr_CourCode, "
         + " Ltr_ActCode , "
         + " Ltr_Prog    , "
         + " Ltr_Ban     , "
         + " Ltr_OpSdate , "
         + " Ltr_OpEdate , "
         + " Ltr_WeekNum , "
         + " Ltr_FrTime  , "
         + " Ltr_ToTime  , "
         + "               "
         + " Ltr_RegDate , "
         + " Ltr_ModDate , "
         + " Ltr_KwanNo    "
         + " FROM Lecturer_015 "
         + " WHERE Ltr_No       = '" + s_ltr_no  + "'"
         + " AND   Ltr_KwanNo   = '" + siselNo   + "'";
    //out.println("sSql : " + sSql + "<BR>");

    rs = stmt.executeQuery(sSql);
%>
<form name="wForm" method="post" target='tmpIframe' action='program_course_act.jsp'>
<input name='mode'              type='hidden' value='I'>
<input name='p_Ltr_ProgNum'     type='hidden' value=''>
<input name='p_Ltr_No'          type='hidden' value='<%=s_ltr_no%>'>
<input name='p_Ltr_CourCode'    type='hidden' value=''>
<input name='p_Ltr_ActCode'     type='hidden' value=''>
<div style='width:760;height:180;overflow-x:hidden;overflow-y:scroll;'>
<table class="board" id='tbl_course'>
    <colgroup>
    <col width="115"/>
    <col width="100"/>
    <col width=""/>
    <col width="105"/>
    <col width="40"/>
    <col width="100"/>
    <col width="100"/>
    <col width="50"/>
    </colgroup>

    <tr >
      <th class="center">과정명</th>
      <th class="center">담당영역</th>
      <th class="center">프로그램명</th>
      <th class="center">운영기간</th>
      <th class="center">요일</th>
      <th class="center">시간</th>
      <th class="center">담당반</th>
      <th class="center">담당반</th>
    </tr>
<%
    String upStr    = "";
    String delStr   = "";

    String  Ltr_ProgNum = "";   // 과정번호
    String  Ltr_No      = "";   // 강사번호
    String  Ltr_CourCode= "";   // 과정코드 Common_002.com_Num
    String  Ltr_ActCode = "";   // 과목코드 Common_002.com_NumDet
    String  Ltr_Prog    = "";   // 프로그램명
    String  Ltr_Ban     = "";   // 반명
    String  Ltr_OpSdate = "";   // 운영시작일자
    String  Ltr_OpEdate = "";   // 운영종료일자
    int     Ltr_WeekNum = -1;   // 운영주차
    String  Ltr_FrTime  = "";   // 시작시간
    String  Ltr_ToTime  = "";   // 종료시간

    String  Ltr_RegDate = "";   // 작성일자
    String  Ltr_ModDate = "";   // 수정일자
    String  Ltr_KwanNo  = "";   // 기관번호

    for (int i =0 ; rs.next(); i++ ) {
        Ltr_ProgNum  = fixNull(rs.getString("Ltr_ProgNum"  ));
        Ltr_No       = fixNull(rs.getString("Ltr_No"       ));
        Ltr_CourCode = fixNull(rs.getString("Ltr_CourCode" ));
        Ltr_ActCode  = fixNull(rs.getString("Ltr_ActCode"  ));
        Ltr_Prog     = fixNull(rs.getString("Ltr_Prog"     ));
        Ltr_Ban      = fixNull(rs.getString("Ltr_Ban"      ));
        Ltr_OpSdate  = fixNull(rs.getString("Ltr_OpSdate"  ));
        Ltr_OpEdate  = fixNull(rs.getString("Ltr_OpEdate"  ));
        Ltr_WeekNum  = rs.getInt("Ltr_WeekNum"  );
        Ltr_FrTime   = fixNull(rs.getString("Ltr_FrTime"   ));
        Ltr_ToTime   = fixNull(rs.getString("Ltr_ToTime"   ));

        Ltr_RegDate  = fixNull(rs.getString("Ltr_RegDate"  ));
        Ltr_ModDate  = fixNull(rs.getString("Ltr_ModDate"  ));
        Ltr_KwanNo   = fixNull(rs.getString("Ltr_KwanNo"   ));
        //out.println("Ltr_WeekNum : " + Ltr_WeekNum + "<BR>");

        if ( staffNo.substring(0,1).equals("P") ) {
            upStr   = "style='cursor:hand' onclick=\"f_Update(" + i + ");return false;\"";
            delStr  = "onclick=\"f_Delete(" + i + ");return false;\"";
        } else {
            upStr   = "";
            delStr  = "";
        }
%>
    <tr style='cursor:hand'>
        <td style='display:none'><%=Ltr_ProgNum%>|<%=Ltr_No%>|<%=Ltr_CourCode%>|<%=Ltr_ActCode%>|<%=Ltr_Prog%>|<%=Ltr_OpSdate%>|<%=Ltr_OpEdate%>|<%=Ltr_WeekNum%>|<%=Ltr_FrTime%>|<%=Ltr_ToTime%>|<%=Ltr_Ban%>|</td>
        <td align="center" <%=upStr%>><%=htCour.get(Ltr_CourCode)%></td>
        <td align="center" <%=upStr%>><%=htAct.get(Ltr_CourCode + "_" + Ltr_ActCode)%></td>
        <td align="center" <%=upStr%>><%=Ltr_Prog%></td>
        <td align="center" <%=upStr%> style='text-align:center'><%=Ltr_OpSdate%> ~<BR><%=Ltr_OpEdate%></td>
        <td align="center" <%=upStr%>><%=wStrArray[Ltr_WeekNum]%></td>
        <td align="center" <%=upStr%>><%=Ltr_FrTime%>-<%=Ltr_ToTime%></td>
        <td align="center" <%=upStr%>><%=Ltr_Ban%></td>
        <td align="center" <%=delStr%>>
<%
                if ( staffNo.substring(0,1).equals("P") ) {
%>
            <img src="../images/btn/list_del.GIF" alt="삭제" border="0" align="absmiddle" <%=delStr%> style="cursor:hand">
<%
                } else {
                    out.println("&nbsp;");
                }
%>
        </td>
    </tr>

<%
    }
%>
</table>
</div>
<div style='width:730;height:53;overflow-x:hidden;overflow-y:none;'>
<table class="board" id='tbl_course_insert' border=0>
    <colgroup>
    <col width="115"/>
    <col width="100"/>
    <col width=""/>
    <col width="105"/>
    <col width="40"/>
    <col width="100"/>
    <col width="100"/>
    <col width="50"/>
    </colgroup>
    <tr>
        <td class="center">
<%
out.println ( CommonLib.getCommon01ComboBox("'0002' ,'0003'","1","-선택-", "Ltr_CourCode","","style='width:97%' onchange='reSelectGwaJung(this.value,$(\"Ltr_ActCode\"));'", stmt) );
%>

        </td>
        <td class="center">
        <select name="Ltr_ActCode" id="Ltr_ActCode" style="width:97%">
        </select>
        </td>

        <td class="center"><input type="text" name="Ltr_Prog" style="width:90% " value=""></td>
        <td class="center" style='text-align:left'>
        <input type="text" name="Ltr_OpSdate" style="width:60px " value="" readonly><img src="../images/icon_calender.gif" style='cursor:hand' alt="달력" width="23" height="16" border="0" align="absmiddle" onClick="javascript:popupCalendar(document.wForm,document.wForm.Ltr_OpSdate);" id='cal_s_img'>
~<BR><input type="text" name="Ltr_OpEdate" style="width:60px " value="" readonly><img src="../images/icon_calender.gif" style='cursor:hand' alt="달력" width="23" height="16" border="0" align="absmiddle" onClick="javascript:popupCalendar(document.wForm,document.wForm.Ltr_OpEdate);" id='cal_e_img'>
        </td>
        <td class="center">
            <select name="Ltr_WeekNum" id="Ltr_WeekNum" style='width:40;display:inline'>
            <option value="1">일</option>
            <option value="2">월</option>
            <option value="3">화</option>
            <option value="4">수</option>
            <option value="5">목</option>
            <option value="6">금</option>
            <option value="7">토</option>
            </select>
        </td>
        <td class="center" style='text-align:left'>
            <select name='Ltr_FrTime_H' id='Ltr_FrTime_H' style='width:36;display:inline'>
                <option value='00'>00</option>
                <option value='01'>01</option>
                <option value='02'>02</option>
                <option value='03'>03</option>
                <option value='04'>04</option>
                <option value='05'>05</option>
                <option value='06'>06</option>
                <option value='07'>07</option>
                <option value='08'>08</option>
                <option value='09'>09</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>
                <option value='13'>13</option>
                <option value='14'>14</option>
                <option value='15'>15</option>
                <option value='16'>16</option>
                <option value='17'>17</option>
                <option value='18'>18</option>
                <option value='19'>19</option>
                <option value='20'>20</option>
                <option value='21'>21</option>
                <option value='22'>22</option>
                <option value='23'>23</option>
            </select>:<select name='Ltr_FrTime_M' id='Ltr_FrTime_M' style='width:36;display:inline'>
                <option value='00' selected>00</option>
                <option value='01'>01</option>
                <option value='02'>02</option>
                <option value='03'>03</option>
                <option value='04'>04</option>
                <option value='05'>05</option>
                <option value='06'>06</option>
                <option value='07'>07</option>
                <option value='08'>08</option>
                <option value='09'>09</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>
                <option value='13'>13</option>
                <option value='14'>14</option>
                <option value='15'>15</option>
                <option value='16'>16</option>
                <option value='17'>17</option>
                <option value='18'>18</option>
                <option value='19'>19</option>
                <option value='20'>20</option>
                <option value='21'>21</option>
                <option value='22'>22</option>
                <option value='23'>23</option>
                <option value='24'>24</option>
                <option value='25'>25</option>
                <option value='26'>26</option>
                <option value='27'>27</option>
                <option value='28'>28</option>
                <option value='29'>29</option>
                <option value='30'>30</option>
                <option value='31'>31</option>
                <option value='32'>32</option>
                <option value='33'>33</option>
                <option value='34'>34</option>
                <option value='35'>35</option>
                <option value='36'>36</option>
                <option value='37'>37</option>
                <option value='38'>38</option>
                <option value='39'>39</option>
                <option value='40'>40</option>
                <option value='41'>41</option>
                <option value='42'>42</option>
                <option value='43'>43</option>
                <option value='44'>44</option>
                <option value='45'>45</option>
                <option value='46'>46</option>
                <option value='47'>47</option>
                <option value='48'>48</option>
                <option value='49'>49</option>
                <option value='50'>50</option>
                <option value='51'>51</option>
                <option value='52'>52</option>
                <option value='53'>53</option>
                <option value='54'>54</option>
                <option value='55'>55</option>
                <option value='56'>56</option>
                <option value='57'>57</option>
                <option value='58'>58</option>
                <option value='59'>59</option>
            </select>
-
<BR>
<select name='Ltr_ToTime_H' id='Ltr_ToTime_H' style='width:36;display:inline'>
                <option value='00' selected>00</option>
                <option value='01'>01</option>
                <option value='02'>02</option>
                <option value='03'>03</option>
                <option value='04'>04</option>
                <option value='05'>05</option>
                <option value='06'>06</option>
                <option value='07'>07</option>
                <option value='08'>08</option>
                <option value='09'>09</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>
                <option value='13'>13</option>
                <option value='14'>14</option>
                <option value='15'>15</option>
                <option value='16'>16</option>
                <option value='17'>17</option>
                <option value='18'>18</option>
                <option value='19'>19</option>
                <option value='20'>20</option>
                <option value='21'>21</option>
                <option value='22'>22</option>
                <option value='23'>23</option>
            </select>:<select name='Ltr_ToTime_M' id='Ltr_ToTime_M' style='width:36;display:inline'>
                <option value='00'>00</option>
                <option value='01'>01</option>
                <option value='02'>02</option>
                <option value='03'>03</option>
                <option value='04'>04</option>
                <option value='05'>05</option>
                <option value='06'>06</option>
                <option value='07'>07</option>
                <option value='08'>08</option>
                <option value='09'>09</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>
                <option value='13'>13</option>
                <option value='14'>14</option>
                <option value='15'>15</option>
                <option value='16'>16</option>
                <option value='17'>17</option>
                <option value='18'>18</option>
                <option value='19'>19</option>
                <option value='20'>20</option>
                <option value='21'>21</option>
                <option value='22'>22</option>
                <option value='23'>23</option>
                <option value='24'>24</option>
                <option value='25'>25</option>
                <option value='26'>26</option>
                <option value='27'>27</option>
                <option value='28'>28</option>
                <option value='29'>29</option>
                <option value='30'>30</option>
                <option value='31'>31</option>
                <option value='32'>32</option>
                <option value='33'>33</option>
                <option value='34'>34</option>
                <option value='35'>35</option>
                <option value='36'>36</option>
                <option value='37'>37</option>
                <option value='38'>38</option>
                <option value='39'>39</option>
                <option value='40'>40</option>
                <option value='41'>41</option>
                <option value='42'>42</option>
                <option value='43'>43</option>
                <option value='44'>44</option>
                <option value='45'>45</option>
                <option value='46'>46</option>
                <option value='47'>47</option>
                <option value='48'>48</option>
                <option value='49'>49</option>
                <option value='50'>50</option>
                <option value='51'>51</option>
                <option value='52'>52</option>
                <option value='53'>53</option>
                <option value='54'>54</option>
                <option value='55'>55</option>
                <option value='56'>56</option>
                <option value='57'>57</option>
                <option value='58'>58</option>
                <option value='59'>59</option>
            </select>
            </td>
        <td class="center">
<%=CommonLib.getProgNameComboBox(siselNo,"","","","Ltr_Ban","","", stmt)%>
        </td>
        <td><img src="../images/btn/layer_register.gif" alt="저장" border="0" onClick="f_Save()" style="cursor:hand" > </td>
    </tr>
</table>
</div>
</form>
<%
    //throw new SQLException("ss");
} // end if
} catch(java.lang.NullPointerException e) {
%>
    <%@ include file="../common/trace_NullPointerException.inc"%>
<%
} catch(SQLException e) {
%>
    <%@ include file="../common/trace_SQLException.inc"%>
<%
} catch(Exception e) {
%>
    <%@ include file="../common/trace_Exception.inc"%>
<%
} finally {
    if ( conn != null ) conn.close();
    if ( stmt != null ) stmt.close();
    if ( rs   != null ) rs.close  ();
  //out.println ("finally");
}
%>
#T======= 템플릿 ==============================
====== 템플릿 ==============================
#