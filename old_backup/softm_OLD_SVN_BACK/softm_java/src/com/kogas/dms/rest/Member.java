package com.kogas.dms.rest;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.FormParam;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;

import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.Base;
import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;
import com.kogas.dms.dao.*;

@Path("member")
public class Member extends Base {
    public Member (@Context HttpServletRequest req, @Context HttpServletResponse res) throws Exception {
		super(req, res);
    }

    @POST
	@Produces("application/json")
    @Path("login")
    public JSONObject login(@DefaultValue("") @FormParam("p_user_id") String p_user_id) throws Exception {
        JSONObject jsr = new JSONObject();

        if ( p_user_id.equals("") )  {
            jsr.put("return" , "404");
            jsr.put("message" , "사용자아이디가 없습니다."); // error message	 
        } else {
        	try{
        		DBUtil.init();
        		DmsLoginDAO dao = new DmsLoginDAO();
        		JSONObject jso = dao.login(p_user_id);
        		if(jso.getString("return").equals("200")) {
        			setSession ( "EMP_NO", jso.getString("emp_no"));              
                    setSession ( "EMP_NM", jso.getString("emp_nm"));              
                    setSession ( "AUTH_DIVIDE" , jso.getString("auth_divide"));              
                    setSession ( "LOGIN_YN" , Util.fixNull("Y"));              
                    setSession ( "ADMIN_YN" , jso.getString("admin_yn"));
                    jsr.put("return" , "200");
      	          	jsr.put("message" , "로그인에 성공하였습니다."); // error message	
        		} else if(jso.getString("return").equals("404")) {
        			jsr.put("return" , "404");
    				jsr.put("message" , "로그인정보가 틀립니다.");
        		} else {
        			jsr.put("return" , "500");
    				jsr.put("message" , "사용자 정보 조회 실패.");
        		}
        	} catch(Exception ex){
        		ex.printStackTrace();
        		jsr.put("return" , "500"); // 성공
                jsr.put("message" , ex.toString()); // error message
      		}
        }
        return jsr;
    }

    // Session 변수를 할당 합니다.
    public void setSession ( String nm, String value  ) {
        if ( value != null && !value.equals("") )
        {
            session.setAttribute( nm, value );
        }
    }

    @POST
	@Produces("application/json")
    @Path("logout")
    public JSONObject logout() throws Exception {
        session.invalidate ();                      // Session을 무효화 함.
        JSONObject jsr = new JSONObject();        	
        jsr.put("return" , "200");
        jsr.put("message" , "로그아웃되었습니다."); // error message	
        return jsr;
    }

    @GET
	@Produces("text/html")
    @Path("session_js_var")
    public String sessionJsVar() throws Exception {
    	String EMP_NO      = session.getAttribute("EMP_NO"      )==null?"" :(String)session.getAttribute("EMP_NO"  );
    	String EMP_NM      = session.getAttribute("EMP_NM"      )==null?"" :(String)session.getAttribute("EMP_NM"   );
    	String AUTH_DIVIDE = session.getAttribute("AUTH_DIVIDE" )==null?"" :(String)session.getAttribute("AUTH_DIVIDE" );
    	String LOGIN_YN    = session.getAttribute("LOGIN_YN"    )==null?"N":(String)session.getAttribute("LOGIN_YN"  );
    	String ADMIN_YN    = session.getAttribute("ADMIN_YN"    )==null?"N":(String)session.getAttribute("ADMIN_YN"  );

    	JSONObject jsr = new JSONObject();        	
    	jsr.put("EMP_NO" , EMP_NO);
    	jsr.put("EMP_NM" , EMP_NM);
    	jsr.put("AUTH_DIVIDE" , AUTH_DIVIDE);
    	jsr.put("LOGIN_YN" , LOGIN_YN);
    	jsr.put("ADMIN_YN" , ADMIN_YN);
    	return "var dms = " + jsr.toString();
    }    
 }