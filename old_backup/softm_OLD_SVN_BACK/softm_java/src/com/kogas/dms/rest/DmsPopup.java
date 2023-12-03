package com.kogas.dms.rest;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.ws.rs.Consumes;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.FormParam;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.Base;
import com.kogas.dms.common.DBUtil;

import com.kogas.dms.dao.*;

@Path("popup")
public class DmsPopup extends Base {
    @Context
    private HttpServletRequest request;
    @Context
    private HttpServletResponse response;

	public DmsPopup(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
	}


	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("cost_center")
	public JSONObject cose_center(
			@DefaultValue("") @FormParam("s_mode") String s_mode,
			@DefaultValue("") @FormParam("s_context") String s_context) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
        		Log.debug("s_mode : " + s_mode);
        		Log.debug("s_context : " + s_context);
        		DmsIfBudgetDAO dao = new DmsIfBudgetDAO();
        		JSONArray list = dao.list(s_mode, s_context);
        		jsr.put("data",list);
        		JSONObject jso = new JSONObject();
        		jso.put(StringUtils.defaultString("CODE"),StringUtils.defaultString("귀속부속코드"));
        		jso.put(StringUtils.defaultString("CONTEXT"),StringUtils.defaultString("귀속부서명"));
        		jsr.put("s_mode", jso);
        		
                jsr.put("return" , "200"); // 성공
                jsr.put("message" , "조회되었습니다."); // error message	
        	} catch(Exception ex){
        		ex.printStackTrace();
        		jsr.put("return" , "500"); // 성공
                jsr.put("message" , ex.toString()); // error message
      		}
        }
		return jsr;
	}
	
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("cost_iz_code")
	public JSONObject cost_iz_code(
			@DefaultValue("") @FormParam("s_mode") String s_mode,
			@DefaultValue("") @FormParam("s_context") String s_context) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
        		Log.debug("s_mode : " + s_mode);
        		Log.debug("s_context : " + s_context);
        		DmsIfMeasureDAO dao = new DmsIfMeasureDAO();
        		JSONArray list = dao.list(s_mode, s_context);
        		jsr.put("data",list);
        		JSONObject jso = new JSONObject();
        		jso.put(StringUtils.defaultString("CONTEXT"),StringUtils.defaultString("자금운영사업명"));
        		jsr.put("s_mode", jso);
        		
                jsr.put("return" , "200"); // 성공
                jsr.put("message" , "조회되었습니다."); // error message	
        	} catch(Exception ex){
        		ex.printStackTrace();
        		jsr.put("return" , "500"); // 성공
                jsr.put("message" , ex.toString()); // error message
      		}
        }
		return jsr;
	}
	
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("approval_request")
	public JSONObject approval_request(
			@DefaultValue("") @FormParam("s_mode") String s_mode,
			@DefaultValue("") @FormParam("s_context") String s_context) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
        		Log.debug("s_mode : " + s_mode);
        		Log.debug("s_context : " + s_context);
        		
        		//인터페이스 후 데이터 가져 오기로 추후 변경
        		JSONArray list = new JSONArray();
        		for(int i = 0; i < 10; i++) {
        			JSONObject jso = new JSONObject();
    				jso.put("approval_no", "도시가스영업팀"+i);
    				jso.put("approval_name", "도시가스 과오납 관련 민원 처리 " + i);
    				jso.put("writer", "홍길동"+i);
    				list.put(jso);
        		}
        		
        		/////////////////////////////////////
        		jsr.put("data",list);
        		JSONObject jso = new JSONObject();
        		jso.put(StringUtils.defaultString("2012"),StringUtils.defaultString("2011"));
        		jso.put(StringUtils.defaultString("2012"),StringUtils.defaultString("2012"));
        		jsr.put("s_mode", jso);
        		
                jsr.put("return" , "200"); // 성공
                jsr.put("message" , "조회되었습니다."); // error message	
        	} catch(Exception ex){
        		ex.printStackTrace();
        		jsr.put("return" , "500"); // 성공
                jsr.put("message" , ex.toString()); // error message
      		}
        }
		return jsr;
	}
	
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("manager")
	public JSONObject manager(
			@DefaultValue("") @FormParam("s_mode") String s_mode,
			@DefaultValue("") @FormParam("s_context") String s_context) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
        		Log.debug("s_mode : " + s_mode);
        		Log.debug("s_context : " + s_context);
        		DmsIfBudgetDAO dao = new DmsIfBudgetDAO();
        		JSONArray list = dao.list(s_mode, s_context);
        		jsr.put("data",list);
        		JSONObject jso = new JSONObject();
        		jso.put(StringUtils.defaultString("EMP_NM"),StringUtils.defaultString("이름"));
        		jso.put(StringUtils.defaultString("DEP_NM"),StringUtils.defaultString("부서명"));
        		jsr.put("s_mode", jso);
        		
                jsr.put("return" , "200"); // 성공
                jsr.put("message" , "조회되었습니다."); // error message	
        	} catch(Exception ex){
        		ex.printStackTrace();
        		jsr.put("return" , "500"); // 성공
                jsr.put("message" , ex.toString()); // error message
      		}
        }
		return jsr;
	}
}