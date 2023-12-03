package com.kogas.dms.rest;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.ws.rs.Consumes;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;

import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.Base;
import com.kogas.dms.common.DBUtil;

import com.kogas.dms.dao.*;

@Path("info")
public class DmsMember extends Base {
    @Context
    private HttpServletRequest request;
    @Context
    private HttpServletResponse response;

    
	public DmsMember(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
	}


	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("members")
	public JSONObject members() throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
	        	// 상임/비상임 이사회 위원 조회
	        	DmsMemberDAO member_dao = new DmsMemberDAO();
	            JSONArray list1 = member_dao.getMemberList("BD", "10");
	            JSONArray list2 = member_dao.getMemberList("BD", "20");
	            
	            if(list1 != null || list2 != null) {
	            	jsr.put("list1", list1); 	// 상임위원회 위원 DATA
	                jsr.put("list2", list2); 	// 비상임위원회 위원 DATA
	                jsr.put("return" , "200"); // 성공
	                jsr.put("message" , "조회되었습니다."); // error message	
	            } else {
	                jsr.put("return" , "500"); // 성공
	                jsr.put("message" , "조회 데이터가 없습니다."); // error message	
	            }
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
	@Path("group_members")
	public JSONObject group_members() throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
	        	// 상임/비상임 이사회 위원 조회
	        	DmsMemberDAO member_dao = new DmsMemberDAO();
	            JSONArray list1 = member_dao.getMemberList("GROUP", "1000");
	            JSONArray list2 = member_dao.getMemberList("GROUP", "2000");
	            JSONArray list3 = member_dao.getMemberList("GROUP", "3000");

	            if(list1 != null || list2 != null || list3 != null) {
	            	jsr.put("list1", list1); 	// 상임위원회 위원 DATA
	                jsr.put("list2", list2); 	// 비상임위원회 위원 DATA
	                jsr.put("list3", list3); 	// 비상임위원회 위원 DATA
	                jsr.put("return" , "200"); // 성공
	                jsr.put("message" , "조회되었습니다."); // error message	
	            } else {
	                jsr.put("return" , "500"); // 성공
	                jsr.put("message" , "조회 데이터가 없습니다."); // error message	
	            }
        	} catch(Exception ex){
        		ex.printStackTrace();
        		jsr.put("return" , "500"); // 성공
                jsr.put("message" , ex.toString()); // error message
      		}
        }
		return jsr;
	}


}