#TITLE=JSTL
#INFO
New Cliptext library
#SORT=n

#T=<c:set var="rowCnt"    value="${rowCnt+1}"/>
<c:set var="^!"    value="${rowCnt+1}"/>
#T=<c:out value="${input.targetRow+status.index}" />
<c:out value="${input.targetRow+status.index}" />
#T=<c:out value="${result.title}"/>
<c:out value="${result.^!}"/>
#T=<c:out value="${r.paystatus}" default=""/>
<c:out value="${r.paystatus}" default=""/>
#T=<c:out value="${input.fromTime}" default="00" />
<c:out value="${input.fromTime}" default="00" />
#T=<c:out value="^!"/>
<c:out value="^!"/>
#T=<c:out value="${pagingUI.rows}"/>
<c:out value="${pagingUI.rows}"/>
#T=<spring:message code='sample.common.label.search'/>
<spring:message code='sample.common.label.search'/>
<spring:message code="dev.cfm.com.delete"/>
#T=<c:if
<c:if test='${hrd_cashreceipt=="1"}'>
^!
</c:if>
#T=<c:if else
<c:if test='${orderid_sub != null && orderid_sub != ""}'>
</c:if>
<c:if test='${orderid_sub == null || orderid_sub == ""}'>
</c:if>
#T=<c:if - inline
 <c:if test="${result.rejectauthuseyn == 'N'}">checked=true</c:if>
#T=<c:if test='${input.admin =="group"}'>
<c:if test='${input.admin =="group"}'>
                <th>상점ID</th>
                <td><div class="form_wrap_input">
                  <form:input path="mertid" class="Ltext" readonly="readonly"/><a class="Lbtn" href="#" onclick="fncMertSelect();"><span>검색</span></a>
                </div></td>
</c:if
#T=<c:choose>
<c:choose>
    <c:when test='${blpgauth && "SC0010"== servicecode}'>
        <span class="btn03"><a href="#"><c:out value="${result.status}"/></a></span>
    </c:when>
    <c:otherwise>
        <span class="btn09"><a href="#"><c:out value="${result.status}"/></a></span>
    </c:otherwise>
</c:choose>
#T=<c:choose> <c:when test='${"SC0010"== servicecode}'>
<c:choose>
    <c:when test='${"SC0010"== servicecode}'>

    </c:when>

    <c:otherwise>
    </c:otherwise>
</c:choose>


#T=<form:input
								<form:input path="address" id="address" cssClass="Ltext" /><br>
								<form:errors path="address" />

#T=<form:select
								<form:select path="p_adjustdvd" id="p_adjustdvd"> 
								    <form:option value="">_정산구분선택</form:option>										
							        <form:options items="${adjustdvdlist}" itemValue="code" itemLabel="name"/> 
								</form:select>	

#T=<c:forEach
<c:forEach begin="2" end="12" varStatus="loop">
</c:forEach>
#T=<Tag:mask mask="####-##-## ##:##:##"><c:out value="${result.^!}" /></Tag:mask>
<Tag:mask mask="####-##-## ##:##:##"><c:out value="${result.^!}" /></Tag:mask>
#T=<Tag:mask mask="####-##-##"><c:out value="${result.sdate}" /></Tag:mask>
<Tag:mask mask="####-##-##"><c:out value="${result.sdate}" /></Tag:mask>
#T=<Tag:decimal format="###,###"><c:out value="${result.^!}"/></Tag:decimal>
<Tag:decimal format="###,###"><c:out value="${result.^!}"/></Tag:decimal>
#T=<Tag:saymessage/>
<Tag:saymessage/>
#T=${fn:length(resultList)}
${fn:length(resultList)}
#T=${fn:substring(r.buyer,0,fn:length(r.buyer)/3)}
${fn:substring(r.buyer,0,fn:length(r.buyer)/3)}
#T=<c:out value="${fn:substring(r.productid,2,fn:length(r.productid)-1)}" default=""/>
<c:out value="${fn:substring(r.productid,2,fn:length(r.productid)-1)}" default=""/>
#T=<fmt:parseNumber var="istart" type="number" value="${input.installstart}"/>
<fmt:parseNumber var="istart" type="number" value="${input.installstart}"/>
<c:out value="{istart}" />
#T=Round - <fmt:formatNumber var="roundRate1" value="${rate1}" maxFractionDigits="0"/>
<fmt:formatNumber var="roundRate1" value="${rate1}" maxFractionDigits="0"/>
#T=<Tag:paging
        <Tag:paging resultList='${resultList}'>
            <Tag:pagingAddHiddenParam  />
            <Tag:pagingOut value="showJavaScript" />

        </Tag:paging>

#T=define array 

<c:set var="spanCnt1">0,0</c:set>
<c:set var="spanCnt2">0,0,0,0</c:set>


<c:set var="spanCnt1" value="<%=new int[] {0,0}%>"/>
<c:set var="spanCnt2" value="<%=new int[] {0,0,0,0}%>"/>

#T=<c:url value="/resource/mertadmin/images/pay/logo_naver.gif"/>
<c:url value="/resource/mertadmin/images/pay/logo_naver.gif"/>
#T=<script src="<c:url value="/resource/mertadmin/js/sha512.js"/>"></script>
<script src="<c:url value="/resource/mertadmin/js/sha512.js"/>"></script>
#T=총0건
        <div class="list_wrap mt25">
          <div class="list_head">
            <ul class="list_sort">
              <li class="result">총 <span class="point_txt1"><strong>
<c:choose>
    <c:when test='${!empty pagingUI.rows}'>
        <Tag:decimal format="###,###"><c:out value="${pagingUI.rows}"/></Tag:decimal>
    </c:when>
    <c:otherwise>0</c:otherwise>
</c:choose>
              </strong></span> 건</li>
            </ul>
          </div>
        </div>
#T=〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
#T=<![CDATA[^!]]>
<![CDATA[
^!
]]>
#T=sql-<if>

            <if test="groupid != null and groupid != ''" >
              <![CDATA[
              ^!and seq < #{seq}
              ]]>
            </if>
#T=sql-<choose>

    <choose>
        <when test='servicetype == "cas"'>

        </when>
        <when test='servicetype == "bank"'>

        </when>
        <when test='servicetype == "card"'>
        </when>
        <otherwise>
        </otherwise>
    </choose>

              <choose>
                <when test='osgubun == "2"'><!-- // 안드로이드 -->
                  <![CDATA[
                   AND TRD_TYPE = '02' 
                  ]]>
                </when>
                <when test='osgubun == "3"'><!-- // IOS -->
                  <![CDATA[
                   AND TRD_TYPE = '03' 
                  ]]>
                </when>
                <when test='osgubun == "4"'><!-- // PC거래 -->
                  <![CDATA[
                   AND TRD_TYPE = '01' 
                  ]]>
                </when>
                <otherwise>
                  <![CDATA[
                  ]]>
                </otherwise>
              </choose>


#T=<include refid="^!"/>
<include refid="^!"/>
#T=<select resultType="int"

<select id="retrieveCoenterpriseGetLevelIndexLen" resultType="int">
    <![CDATA[
        SELECT /* totaltransact.retrieveCoenterpriseGetLevelIndexLen - softm - 김지훈 */
               length(levelindex)   as len
        from coenterprise
        where cooperativecode = #{groupid}
    ]]>
</select>


      Integer len = totaltransactService.retrieveCoenterpriseGetLevelIndexLen(input);


        input.setLen(len==null?-1:len.intValue());



	/** 통합결제내역-(그룹,상점)전송실패내역조회 - 그룹레벨 */
	@Override
	public Integer retrieveCoenterpriseGetLevelIndexLen(
			TotalTransactNoteUrlListModel model) {
		return commonSvcDAO.select("totaltransact.retrieveCoenterpriseGetLevelIndexLen",model);
	}

#T=<select
<select id="retrieveHRDTradeDetailByRefund" resultType="lguplus.npg.online.ms.totaltransact.model.TotalTransactHRDTradeDetailRefundModel">
^!
</select>

#T=〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
#T=LOGGER.debug("test-softm : " + input);
LOGGER.debug("test-softm : " + input);
#T=PGSessionModel
@SessionAttributes("PGSessionModel")
public class CasController {

	public String retrieveCasNsaerrListForMertAdmin(@PagingPolicy("policy1") CasNsaerrList input
                                                    , ModelMap model
                                                    , @ModelAttribute("PGSessionModel") PGSessionModel session) {

        model.addAttribute("session", session);


#T=CodeService
    @Resource(name = "mscodeService")
    private CodeService codeService;

    List <Code> codeList = codeService.retrieveCodeListByKind("^!AD"); // 코드 조회

    model.codeList("codelist", codeList);

#T=Object toString
    public String toString(){
    	return ToStringBuilder.reflectionToString(this,ToStringStyle.MULTI_LINE_STYLE);
    }
#T=Constroller-method
    /**
      * 에스크로정보 목록조회
      *
      * @name retrieveEscrowInfoList
      * @param input
      * @param model
      * @return 에스크로정보 목록조회 화면
      */
    @RequestMapping(value = "ms/escrow/retrieveEscrowInfoList", method = {RequestMethod.GET, RequestMethod.POST})
    public String retrieveEscrowInfoList(@PagingPolicy("policy1") EscrowInfoListModel input, ModelMap model
                                 , @ModelAttribute("PGSessionModel") PGSessionModel session
    ) {
        String mertid = StringUtils.defaultString(input.getMertid());
        List<EscrowInfoListModel> resultList = null;

        if ( !"".equals(mertid) ) {
            resultList = escrowService.retrieveEscrowInfoList(input);
        } else {
            resultList = escrowService.retrieveEscrowInfoListALL(input);
        }
//      if(!NullUtil.isNull(input.getFrdate())){
//          resultList = casService.retrieveCasTradeListForMertAdmin(input);
//      } else {
//          input.setFrdate("20141231");////DateUtil.getDate("yyyy-MM-dd"));
//          input.setTodate("20141231");//DateUtil.getDate("yyyy-MM-dd"));
//      }

        model.addAttribute("input", input);
        model.addAttribute("resultList", resultList);
        return "ms/escrow/retrieveEscrowInfoList_w";
    }

    /**
      * 에스크로정보 등록/수정 화면
      *
      * @name insertSinglePage
      * @param input
      * @param model
      * @return 에스크로정보 등록/수정 화면
      */
    @RequestMapping(value="ms/escrow/writeEscrowPage",method = {RequestMethod.POST,RequestMethod.GET})
    public String writeEscrowPage(EscrowInfoWriteModel input, ModelMap model) {
        String mode = StringUtils.isEmpty(input.getMode())?"I":input.getMode(); // I,U
        List <Code> escrowtypelist = codeService.retrieveCodeListByKind("ES"); // 코드 조회

        if ( "I".equals(mode)) {
            model.addAttribute("result", input);
        } else if ( "U".equals(mode)) {
            input = escrowService.retrieveEscrowInfoDetail(input);
            input.setMode(mode);
            model.addAttribute("result", input);
        }

        model.addAttribute("escrowtypelist", escrowtypelist); // 에스크로거래유형

        model.addAttribute("paytypecodelist", CodeUtil.makeCode(CodeUtil.payType));//결제유형
        model.addAttribute("escmodellist", CodeUtil.makeCode(CodeUtil.escModel));//에스크로 모델

        return "ms/escrow/writeEscrowInfo_w";
    }

    /**
      * 에스크로정보 등록 실행
      *
      * @name insertEscrowInfo
      * @param input
      * @param ra
      * @return 조회화면 redirect
      */
    @RequestMapping(value="ms/escrow/writeEscrowInfo",method = RequestMethod.POST)
    public String writeEscrowInfo(EscrowInfoWriteModel input, RedirectAttributes ra
                            , @ModelAttribute("PGSessionModel") PGSessionModel session
    ) {
        String mode = StringUtils.isEmpty(input.getMode())?"I":input.getMode(); // I,U
        input.setModifier(session.getModifier());
        LOGGER.debug("test-softm : " + input);
        if ( "I".equals(mode)) {
            escrowService.insertEscrowInfo(input);
        } else if ( "U".equals(mode)) {
            escrowService.updateEscrowInfo(input);
        }

//      ra.addAttribute("num", input.getNum());
        return "redirect:/ms/escrow/retrieveEscrowInfoList.do";
    }

    /**
     *
      * 에스크로정보 삭제 실행
      *
      * @name deleteEscrowInfo
      * @param input
      * @param model
      * @return 조회화면 redirect
     */
    @RequestMapping(value="ms/escrow/deleteEscrowInfo",method = RequestMethod.POST)
    public String deleteEscrowInfo(EscrowInfoWriteModel input, ModelMap model) {
        escrowService.deleteEscrowInfo(input);
        return "redirect:/ms/escrow/retrieveEscrowInfoList.do";
    }

#T=DateUtil.getDate("yyyy-MM-dd");
DateUtil.getDate("yyyy-MM-dd");
#T=// softm ------------------------------------------------------------------------------------------------------------------------------------
// softm ------------------------------------------------------------------------------------------------------------------------------------
 // ------------------------------------------------------------------------------------------------------------------------------------ softm
#T=공통-카드사-리스트
List<Settlement> settlementList = codeService.retrieveCardSettlementList();
#T=List <Code> escrowtypelist = codeService.retrieveCodeListByKind("ES"); // 코드 조회
List <Code> escrowtypelist = codeService.retrieveCodeListByKind("ES"); // 코드 조회
#T=기본모델변수
package lguplus.npg.online.ms.totaltransact.model;

import lguplus.npg.online.frw.com.model.CommonPagedModel;
import lguplus.npg.online.ms.com.utility.CodeUtil;
import lguplus.npg.online.ms.com.utility.MPCrypter;

import org.apache.commons.lang.StringUtils;

import devonframe.util.DateUtil;
/**
 * 
 * <PRE>
 *
 * 통합결제내역-(그룹)산인공거래상세조회 - 서비스별
 *
 * </PRE>
 *
 * @author    softm
 * @version   1.0, 2015. 5. 18.
 * @see       (참조 파일이 있는 경우 기입)
 */
public class TotalTransactHRDTradeDetailServicetypeModel extends CommonPagedModel {
private String test       ;
private String groupid    ;
private String admin      ;
private String modifier   ;
private String mertid     ;
#T=기본 Controler Method
    /**
      * 통합결제내역-(그룹,상점)전송실패내역조회
      *
      * @name retrieveNoteUrlList
      * @param input
      * @param model
      * @return (그룹,상점)전송실패내역조회
      */
    @RequestMapping(value = "ms/totaltransact/retrieveNoteUrlList", method = {RequestMethod.GET, RequestMethod.POST})
    public String retrieveNoteUrlList(@PagingPolicy("tradePolicy") TotalTransactNoteUrlListModel input
                                 , ModelMap model
                                 , @ModelAttribute("PGSessionModel") PGSessionModel session
    ) {
    	//TODO-softm : ASIS와 같은 사이즈로구현. 확인해야함.
    	input.setRowSize(10000);
		input.setTargetRow(1);
		
        List<TotalTransactNoteUrlListModel> resultList = null;

        input.setModifier(StringUtils.defaultString(session.getModifier()));

        String strGroupId       = input.getModifier();
                                  input.setGroupid(strGroupId);

        input.setAdmin(session.getAdmin());

        TotalTransactNoteUrlListModel levelInfo = totaltransactService.retrieveCoenterpriseGetLevelIndexLen(input);
        if ( levelInfo != null ) {
            input.setLen(levelInfo.getLen());
            input.setLevel(levelInfo.getLevel());
        }

        model.addAttribute("paytypecodelist", totaltransactService.serviceInfoByTransact());//결제수단
//        model.addAttribute("servicecodelist", CodeUtil.makeCode(CodeUtil.serviceCode));//결제수단
        model.addAttribute("trxtimecodelist", CodeUtil.makeCode(CodeUtil.trxTime));//거래시간
        model.addAttribute("sendflagcodelist", CodeUtil.makeCode(CodeUtil.sendFlag));//재전송 완료여부

        if(StringUtils.isNotEmpty(input.getTrxfrdate())){
            resultList = totaltransactService.retrieveNoteUrlList(input);
        } else {
            input.setTrxfrdate(DateUtil.getPrevMonthDate(DateUtil.getDate("yyyyMMdd"), 1));
            input.setTrxtodate(DateUtil.getDate("yyyyMMdd"));
        }
        model.addAttribute("sysdate", DateUtil.getDate("yyyyMMdd"));
        model.addAttribute("init_frdate", DateUtil.getDate("yyyyMMdd"));
        model.addAttribute("init_todate", DateUtil.getDate("yyyyMMdd"));

        LOGGER.debug("test-softm~~ len : " + input.getLen());
        LOGGER.debug("test-softm~~ level : " + input.getLevel());
        LOGGER.debug("test-softm~~ : " + input);
        model.addAttribute("input"  , input);
        model.addAttribute("resultList", resultList);

        return "mertadmin/ms/totaltransact/retrieveNoteUrlList_w";
    }
#T=〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
#T=엑셀다운로드_체크_alert
    <c:if test='${fn:length(resultList)==0}'>
        alert("다운로드할 데이터가 존재하지 않습니다.");
        e.preventDefault();
        return false;
    </c:if>
#T=callPostPopup( "<c:url value="/ms/servicemgmt/retrieveEventView.do"/>", "width=1078, height=700", $("#detailForm")[0]);
        var transactionid = $(this).parent().attr("transactionid");
        $("#detailForm [name='transactionid']").val(transactionid);
        $("#detailForm [name='mode']"      ).val("U"         );
        callPostPopup( "<c:url value="/ms/totaltransact/retrieveNoteURLDetail.do"/>", "menubar=1,toolbar=0,scrollbars=yes,width=700,height=480,resize=1,left=252,top=116", $("#detailForm")[0]);
        e.preventDefault();

#T=formSubmit($("#sForm")[0]);
$("#sForm").attr("action","<c:url value="/ms/totaltransact/retrieveAllTrxSum.do"/>")
formSubmit($("#sForm")[0]);


#T=$("body").on("click","#btnReg
    $("body").on("click","#^!",function(e){
        e.preventDefault();
    });
#T=날짜선택
                    <div class="form_wrap_date">
                        <form:input path="fromdate" class="Ltext numbericOnly" style="width:80px;" size="8"/> <a onclick="dui.Calendar.open('fromdate'); return false;" href="#"><img class="Lbtn" alt="날짜" src="${resourcePath}/images/common/ico_date.png" complete="complete"/></a>
                        ~
                        <form:input path="todate" class="Ltext numbericOnly" style="width:80px;" size="8"/> <a onclick="dui.Calendar.open('todate'); return false;" href="#"><img class="Lbtn" alt="날짜" src="${resourcePath}/images/common/ico_date.png" complete="complete"/></a>
                        <span class="btn_normal"> <a class="Lbtn" href="#" onclick="fncSetDateTerm('today',0);return false;">당일</a>
                            <a href="#" onclick="fncSetDateTerm('week',1);return false;">1주</a>
                            <a href="#" onclick="fncSetDateTerm('week',2);return false;">2주</a>
                            <a href="#" onclick="fncSetDateTerm('month',1);return false;">1개월</a>
                            <a href="#" onclick="fncSetDateTerm('month',3);return false;">3개월</a></span>
                    </div>

                    <div class="form_wrap_date">
                                <form:input path="fromdate" class="Ltext numbericOnly" style="width:80px;" size="8"/> <a onclick="dui.Calendar.open('fromdate'); return false;" href="#"><img class="Lbtn" alt="날짜" src="${resourcePath}/images/common/ico_date.png" complete="complete"/></a>
                                <form:select path="authtime1" id="authtime1">
                                    <form:options items="${trxtimevallist}" itemValue="code" itemLabel="name"/>
                                </form:select>
                                ~
                                <form:input path="todate" class="Ltext numbericOnly" style="width:80px;" size="8"/> <a onclick="dui.Calendar.open('todate'); return false;" href="#"><img class="Lbtn" alt="날짜" src="${resourcePath}/images/common/ico_date.png" complete="complete"/></a>
                                <form:select path="authtime2" id="authtime2">
                                    <form:options items="${trxtimevallist}" itemValue="code" itemLabel="name"/>
                                </form:select>
 <span class="btn_normal"> <a class="Lbtn" href="#" onclick="fncSetDateTerm('today',0);return false;">당일</a>
                                    <a href="#" onclick="fncSetDateTerm('week',1);return false;">1주</a>
                                    <a href="#" onclick="fncSetDateTerm('week',2);return false;">2주</a>
                                    <a href="#" onclick="fncSetDateTerm('month',1);return false;">1개월</a>
                                    <a href="#" onclick="fncSetDateTerm('month',3);return false;">3개월</a></span>
                    </div>

#T=상점ID-팝업
	function fncSearchMert (){
		var form = document.sForm;		
		var popupUrl = "<c:url value="/ms/com/retrieveMertIdList.do"/>";
		var popupOption = "width=820, height=600, resizable=no, scrollbars=yes, status=no;";    					
		callPostPopup(popupUrl, popupOption, form);	
	}

                <th>상점ID</th>
                <td><div class="form_wrap_input">
                  <form:input path="mertid" style="width:155px;"/>
                  <span class="btn_normal"> <a onclick="fncSearchMert();return false;" href="#">상점검색</a></span>
                </div>
                </td>

#T=페이지탭
        <!-- pagination -->
        <div class="paginate">
            <Tag:pagingOut value='showMoveFirstPage' />
            <Tag:pagingOut value='showMoveBeforePage' />
            <Tag:pagingOut value='showIndex' />
            <Tag:pagingOut value='showMoveNextPage' />
            <Tag:pagingOut value='showMoveEndPage' />
        </div>
        <!-- //pagination -->


#T=list_table_scroll
<div class="list_table_scroll">
			<table style="width:2000px;" class="list_table">
				<colgroup>
					<col width="50px">
					<col width="100px">
					<col width="150px">
					<col width="90px">
					<col width="100px">
					<col width="50px">
					<col width="90px">
					<col width="140px">
					<col width="100px">
					<col width="100px">
					<col width="75px">
					<col width="90px">
					<col width="90px">
					<col width="90px">
					<col width="100px">
					<col width="100px">
					<col width="150px">
					<col width="90px">
					<col width="150px">								
				</colgroup>
				<thead>
					<tr>
					 	<th scope="col">No</th>
						<th scope="col">상점ID</th>
						<th scope="col">주문번호</th>
						<th scope="col">주문일자</th>
						<th scope="col">금액</th>
						<th scope="col">할부</th>
						<th scope="col">카드종류</th>
						<th scope="col">카드번호</th>
						<th scope="col">구매자</th>
						<th scope="col">상품명</th>
						<th scope="col">승인번호</th>
						<th scope="col">승인일자</th>
						<th scope="col">매입요청일</th>
						<th scope="col">매입완료일</th>
						<th scope="col">처리상태</th>
						<th scope="col">거래구분</th>
						<th scope="col">반송사유</th>
						<th scope="col">정산반영일</th>
						<th scope="col">비고</th>
					</tr>
				</thead>
				<tbody>
					
					
						<tr style="background-color: #FFFFFF" id="empty">
							<td colspan="19">검색된 내용이 없습니다.</td>
						</tr>
					
				</tbody>
			</table>
			</div>
#T=<div class="Lwrapper">
                </div>
                <div class="Lwrapper">
#T=alert("날짜유효성이 맞지 않습니다.");
            alert("날짜유효성이 맞지 않습니다.");

#T=class="btnUpdate">수정</a> 
                                        <span class="btn_Tlist_in"> <a href="#" class="btnUpdate">수정</a> </span>
                                        <span class="btn_Tlist_grey"> <a href="#" class="btnDelete">삭제</a> </span>

#T=엑셀
    $("body").on("click",".btnExcel",function(e){ // 엑셀
    <c:if test='${fn:length(resultListAuthdate)==0}'>
        alert("다운로드할 데이터가 존재하지 않습니다.");
        e.preventDefault();
        return false;
    </c:if>
        if(!fncChkValidation()) return;
        else {
            $("#downloadHiddenForm").attr("action","<c:url value='/ms/totaltransact/retrieveCoupangCardTotalSumExcel.do'/>");
            formSubmit($("#downloadHiddenForm")[0]);
        }
        e.preventDefault();
    });
	// 엑셀다운로드폼 생성
	fncCreateHiddenForm("downloadHiddenForm", "sForm");

#T=checkMonthTerm
    if(!checkMonthTerm(frdate, todate, 1)) {
        alert('검색기간이 1개월을 초과하였습니다.');
        return false;
    }
#T=〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
#T=<!-- //TODO-softm : dispay:제거. -->
<!-- //TODO-softm : dispay:제거. -->
#T=//TODO-softm
//TODO-softm
#T=<%-- --%>
<%--^!--%>
#T=〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
#