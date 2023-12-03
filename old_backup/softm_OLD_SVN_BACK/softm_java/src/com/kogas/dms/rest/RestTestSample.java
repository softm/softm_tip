/**
 * 게시판
 * @version : 1.0
 * @author  : kim ji hun (softm@nate.com)
 */
package com.kogas.dms.rest;

import java.util.ArrayList;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.ws.rs.Consumes;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.FormParam;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;

import kr.go.citis.main.dto.BldChkupWrtDtlDTO;
import kr.go.citis.main.dto.LoginDTO;
import kr.go.citis.main.dto.SampleListDTO;
import kr.go.citis.main.dto.TestChkListDTO;
import kr.go.citis.main.dto.TestChkMainDTO;
import kr.go.citis.main.dto.in.BldChkupWrtDtlDTOIn;
import kr.go.citis.main.dto.in.LoginDTOIn;
import kr.go.citis.main.dto.in.SampleListDTOIn;
import kr.go.citis.main.dto.out.BldChkupWrtDtlDTOOut;
import kr.go.citis.main.dto.out.LoginDTOOut;
import kr.go.citis.main.dto.out.TestChkListDTOOut;
import kr.go.citis.main.dto.out.TestChkMainDTOOut;

import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.google.gson.Gson;
import com.kogas.dms.common.Base;

// POJO, no interface no extends

//Sets the path to base URL + /hello

@Path("test")
public class RestTestSample extends Base {
	public RestTestSample(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
	}
	
	private final String UPLOAD_PATH = "D:\\WEB_APP\\eclipse_workspace\\work\\upload";
	
	/**
	 * 게시판 - 한건조회
	 * @param p_no 게시물번호
	 * @return 조회데이터
	 */
	@POST
	@Produces("application/json")
	@Consumes("application/x-www-form-urlencoded")
	@Path("list")
	public JSONObject getlist(
			  @DefaultValue("") @FormParam("p") String inParams
			) 	throws Exception {
		Gson gson = new Gson();
		SampleListDTOIn in = gson.fromJson(inParams, SampleListDTOIn.class);
		SampleListDTO data = in.getData();
		System.out.println("data.getSample_1() :  " + data.getSample_1());
		JSONObject jsr = new JSONObject();
		JSONArray jsa = new JSONArray();
		for(int i =0;i<20;i++) {
			JSONObject json = new JSONObject();
//			json.put("mode"  ,i%2 != 0 ? "I" : "R");			
			json.put("sample_1", "값1_" + i);
			json.put("sample_2", "값2_" + i);
			jsa.put(json);
		}
		jsr.put("msgCode", "200");
		jsr.put("msg"     , "ok"  );		
		jsr.put("data", jsa);		
		return jsr;
	}
	
	/**
	 * 게시판 - 한건조회
	 * @param p_no 게시물번호
	 * @return 조회데이터
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("login")
	public String login(
			  @DefaultValue("") @FormParam("p") String inParams
			, @DefaultValue("") @FormParam("userid") String userid
			, @DefaultValue("") @FormParam("passwd") String passwd
	) 	throws Exception {
//		{return:200,msg:"ok",info:{username:"",userid:""}}
		System.out.println("p : " + inParams );		
		Gson gson = new Gson();
		LoginDTOIn in = gson.fromJson(inParams, LoginDTOIn.class);
		LoginDTO data = in.getData();
		System.out.println("data.getUserid() :  " + data.getUserid());
		System.out.println("data.getPasswd() :  " + data.getPasswd());
		LoginDTOOut jsr = new LoginDTOOut();
			data.setUserid(data.getUserid());
			if ("student01".equals(data.getUserid()))  { // 시공사
				data.setUsernm("학생1");
				data.setSiteType("C");
			} else if ("student02".equals(data.getUserid()))  { // 감리사 
				data.setUsernm("학생2");
				data.setSiteType("S");
			}
		jsr.setData(data);
		jsr.setMsgCode("200");
		jsr.setMsg("ok"  );		
		jsr.setData(data);
		return gson.toJson(jsr);
	}
	
	/**
	 * 게시판 - 한건조회
	 * @param p_no 게시물번호
	 * @return 조회데이터
	 */
	@POST
	@Produces("application/json")
	@Consumes("application/x-www-form-urlencoded")
	@Path("codeCommon")
	public JSONObject code_common(
			  @DefaultValue("") @FormParam("p") String code
			) 	throws Exception {
		System.out.println("p : " + code );		
		JSONObject jsr = new JSONObject();
		JSONArray jsa = new JSONArray();
		for(int i =0;i<10;i++) {
			JSONObject json = new JSONObject();
			json.put("code" , "공통" + i);
			json.put("value", "공통값" + i);
			jsa.put(json);			
		}
		jsr.put("msgCode", "200");
		jsr.put("msg"     , "ok"  );		
		jsr.put("data", jsa);		
		return jsr;
	}
	@POST
	@Produces("application/json")
	@Consumes("application/x-www-form-urlencoded")
	@Path("codeChargeSite")
	public JSONObject code_charge_site(
			@DefaultValue("") @FormParam("p") String code
			) 	throws Exception {
		System.out.println("p : " + code );		
		JSONObject jsr = new JSONObject();
		JSONArray jsa = new JSONArray();
		for(int i =0;i<10;i++) {
			JSONObject json = new JSONObject();
			json.put("code" , "000" + i);
			json.put("value", "값000" + i);
			jsa.put(json);			
		}
		jsr.put("msgCode", "200");
		jsr.put("msg"     , "ok"  );		
		jsr.put("data", jsa);		
		return jsr;
	}
	@POST
	@Produces("application/json")
	@Consumes("application/x-www-form-urlencoded")
	@Path("codeControlSite")
	public JSONObject code_control_site(
			@DefaultValue("") @FormParam("p") String code
			) 	throws Exception {
		System.out.println("p : " + code );		
		JSONObject jsr = new JSONObject();
		JSONArray jsa = new JSONArray();
		for(int i =0;i<10;i++) {
			JSONObject json = new JSONObject();
			json.put("code" , "000" + i);
			json.put("value", "값000" + i);
			jsa.put(json);			
		}
		jsr.put("msgCode", "200");
		jsr.put("msg"     , "ok"  );		
		jsr.put("data", jsa);		
		return jsr;
	}
	@POST
	@Produces("application/json")
	@Consumes("application/x-www-form-urlencoded")
	@Path("codeCnsttypecd")
	public JSONObject code_cnsttypecd(
			@DefaultValue("") @FormParam("p") String code
			) 	throws Exception {
		System.out.println("p : " + code );		
		JSONObject jsr = new JSONObject();
		JSONArray jsa = new JSONArray();
		for(int i =0;i<10;i++) {
			JSONObject json = new JSONObject();
			json.put("code" , "000" + i);
			json.put("value", "값000" + i);
			jsa.put(json);			
		}
		jsr.put("msgCode", "200");
		jsr.put("msg"     , "ok"  );		
		jsr.put("data", jsa);		
		return jsr;
	}
	
	@POST
	@Produces("application/json")
	@Consumes("application/x-www-form-urlencoded")
	@Path("codeDtlcnsttypecd")
	public JSONObject code_dtlcnsttypecd(
			@DefaultValue("") @FormParam("p") String code
			) 	throws Exception {
		System.out.println("p : " + code );		
		JSONObject jsr = new JSONObject();
		JSONArray jsa = new JSONArray();
		for(int i =0;i<10;i++) {
			JSONObject json = new JSONObject();
			json.put("code" , "000" + i);
			json.put("value", "값000" + i);
			jsa.put(json);			
		}
		jsr.put("msgCode", "200");
		jsr.put("msg"     , "ok"  );		
		jsr.put("data", jsa);		
		return jsr;
	}
	
	@POST
	@Produces("application/json")
	@Consumes("application/x-www-form-urlencoded")
	@Path("testChkMain")
	public String test_chk_main(
			@DefaultValue("0") @FormParam("p_no") int p_no
			) 	throws Exception {
		TestChkMainDTOOut jsr = new TestChkMainDTOOut();
		ArrayList jsa = new ArrayList();
		for(int i =0;i<20;i++) {
			TestChkMainDTO json = new TestChkMainDTO();
//			pSiteNo; // 현장번호[담당,관할]
//	        pCnsttypecd; // 공종
//	        pChkDtYyyymm; // 년월
//	        pIspnPrgrs; // 진행상태
	        json.setIspnChkMgntSeq("0001"); // 검측마스터번호
	        json.setDtlcnsttypecd("01"); // 세부공종코드
	        json.setDtlcnsttypenm("세부공종명"+i); // 세부공종명
	        json.setChkDt("2015-12-22"); // 점검일자
	        json.setRqstsDt("2015-12-23"); // 검측요청일
	        json.setIspnDt(""); // 검측일자
	        json.setIspnPrgrs("01"); // 진행상태코드
	        json.setIspnPrgrsNm("진행중"); // 진행상태명
	        json.setRsltStatus("01"); // 검측결과코드
	        json.setRsltStatusNm("검측결과명"); // 검측결과명
			jsa.add(json);
		}
		jsr.setMsgCode("200");
		jsr.setMsg("ok"  );		
		jsr.setData(jsa);
		Gson gson = new Gson();
		return gson.toJson(jsr);
	}
	
	@POST
	@Produces("application/json")
	@Consumes("application/x-www-form-urlencoded")
	@Path("testChkList")
	public String test_chk_list(
			@DefaultValue("0") @FormParam("p_no") int p_no
			) 	throws Exception {
		TestChkListDTOOut jsr = new TestChkListDTOOut();
		ArrayList jsa = new ArrayList();
		for(int i =0;i<5;i++) {
			TestChkListDTO json = new TestChkListDTO();
//			pSiteNo; // 현장번호[담당,관할]
//	        pCnsttypecd; // 공종
//	        pChkDtYyyymm; // 년월
//	        pIspnPrgrs; // 진행상태
			
//			 {"data":[{"mode":"R","ispnChkSeq":"14","chkDt":"20151218","dtlcnsttypecd":"1504","dtlcnsttypeNm":"기타공.기타2","ispnDt":"","rsltStatus":"9","rsltStatusNm":""}}
			json.setpIspnChkMgntSeq ("4"); // 검측마스터번호    
			json.setIspnChkSeq      ("14"); // 검측체크번호    
			json.setChkDt        ("20151228"); // 점검일자    
			json.setDtlcnsttypecd("1504 "); // 세부공종코드  
			json.setDtlcnsttypenm("기타공.기타2"); // 세부공종명   
			json.setIspnDt       ("20151201"); // 검측일자    
			json.setRsltStatus   ("F"); // 검측결과코드  
			json.setRsltStatusNm ("부적합"); // 검측결과명   
			jsa.add(json);
		}
		jsr.setMsgCode("200");
		jsr.setMsg("ok"  );		
		jsr.setData(jsa);
		Gson gson = new Gson();
		return gson.toJson(jsr);
	}
	
	@POST
	@Produces("application/json")
	@Consumes("application/x-www-form-urlencoded")
	@Path("bldChkupWrtItemList")
	public String bld_chkup_wrt_item_list(
			@DefaultValue("0") @FormParam("p_no") int p_no
			) 	throws Exception {
		TestChkListDTOOut jsr = new TestChkListDTOOut();
		ArrayList jsa = new ArrayList();
		for(int i =0;i<5;i++) {
			TestChkListDTO json = new TestChkListDTO();
//			pSiteNo; // 현장번호[담당,관할]
//	        pCnsttypecd; // 공종
//	        pChkDtYyyymm; // 년월
//	        pIspnPrgrs; // 진행상태
			
//			 {"data":[{"mode":"R","ispnChkSeq":"14","chkDt":"20151218","dtlcnsttypecd":"1504","dtlcnsttypeNm":"기타공.기타2","ispnDt":"","rsltStatus":"9","rsltStatusNm":""}}
			json.setpIspnChkMgntSeq ("4"); // 검측마스터번호    
			json.setIspnChkSeq      ("14"); // 검측체크번호    
			json.setChkDt        ("20151228"); // 점검일자    
			json.setDtlcnsttypecd("1504 "); // 세부공종코드  
			json.setDtlcnsttypenm("기타공.기타2"); // 세부공종명   
			json.setIspnDt       ("20151201"); // 검측일자    
			json.setRsltStatus   ("F"); // 검측결과코드  
			json.setRsltStatusNm ("부적합"); // 검측결과명   
			jsa.add(json);
		}
		jsr.setMsgCode("200");
		jsr.setMsg("ok"  );		
		jsr.setData(jsa);
		Gson gson = new Gson();
		return gson.toJson(jsr);
	}
	

	
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("bldChkupWrtDtl")
	public String bld_chkup_wrt_dtl(
			  @DefaultValue("") @FormParam("p") String inParams
			, @DefaultValue("") @FormParam("userid") String userid
			, @DefaultValue("") @FormParam("passwd") String passwd
	) 	throws Exception {
//		{return:200,msg:"ok",info:{username:"",userid:""}}
		System.out.println("p : " + inParams );		
		Gson gson = new Gson();
		BldChkupWrtDtlDTOIn in = gson.fromJson(inParams, BldChkupWrtDtlDTOIn.class);
		BldChkupWrtDtlDTO data = in.getData();
		System.out.println("data.getwMode() :  " + data.getwMode());
		System.out.println("data.getpIspnChkMgntSeq() :  " + data.getpIspnChkMgntSeq());
		System.out.println("data.getpIspnChkSeq() :  " + data.getpIspnChkSeq());
		BldChkupWrtDtlDTOOut jsr = new BldChkupWrtDtlDTOOut();
			data.setCnsttypecd   ("1504");
			data.setDtlcnsttypecd("1504");
			data.setChkDt        ("20151228");
			data.setPlcPrt       ("Sts00 100....");
			data.setWrkAmnt      ("100 루배....");
			data.setIspnDt       ("20151206");
		jsr.setData(data);
		jsr.setMsgCode("200");
		jsr.setMsg("ok"  );		
		jsr.setData(data);
		return gson.toJson(jsr);
	}
}