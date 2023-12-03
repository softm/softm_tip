/**
 * 회의일정
 * @version : 1.0
 * @author  : kim ji hun (softm@nate.com)
 */
package com.kogas.dms.rest;

import java.io.File;
import java.sql.SQLException;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.ws.rs.Consumes;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.FormParam;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import javax.ws.rs.core.Response.ResponseBuilder;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.Base;
import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;
import com.kogas.dms.dao.DmsBdGubunCodeDAO;
import com.kogas.dms.dao.DmsBdNameCodeDAO;
import com.kogas.dms.dao.DmsBdScheduleDAO;
import com.kogas.dms.dao.DmsCommonDAO;
import com.kogas.dms.var.TABLE;

@Path("dms_info/bd_schedule")
public class DmsBdSchedule extends Base {
	public DmsBdSchedule(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
	}
	
	/**
	 * 조회
	 * @param s_year 년
	 * @param s_year 월
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("list")
	public JSONObject list(
			@DefaultValue("0") @FormParam("s_year") String s_year,
			@DefaultValue("0") @FormParam("s_month") String s_month
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdScheduleDAO dao = new DmsBdScheduleDAO();
				 jsr.put("data", dao.list(s_year,s_month));
				 
				 DmsBdGubunCodeDAO dao1 = new DmsBdGubunCodeDAO();
				 jsr.put("data_gubun_code", dao1.listCode());
				 
				 DmsBdNameCodeDAO dao2 = new DmsBdNameCodeDAO();
//				 jsr.put("data_name_code", dao2.listCode("ALL"));
				 jsr.put("data_name_code", dao2.listCode("'20','90'"));
	                
                 jsr.put("return" , "200"); // 성공
                 jsr.put("message" , "조회되었습니다."); // error message
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); // 실패
	   			 jsr.put("message" , e.toString()); // error message
	   			 e.printStackTrace();
            } finally {
				 DBUtil.end();
            }
        }
		return jsr;
	}
	/**
	 * 한건조회
	 * @param p_no 게시물번호
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("get")
	public JSONObject get(
			@DefaultValue("") @FormParam("p_schedule_no") String p_schedule_no
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
				DBUtil.init();
				 DmsBdScheduleDAO dao = new DmsBdScheduleDAO();
				 jsr.put("data", dao.view(p_schedule_no));
				 
				 DmsBdGubunCodeDAO dao1 = new DmsBdGubunCodeDAO();
				 jsr.put("data_gubun_code", dao1.listCode());
				 
				 DmsBdNameCodeDAO dao2 = new DmsBdNameCodeDAO();
//				 jsr.put("data_name_code", dao2.listCode("ALL"));
				 jsr.put("data_name_code", dao2.listCode("'20','90'"));
                
                jsr.put("return" , "200"); // 성공
                jsr.put("message" , "조회되었습니다."); // error message	            
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); // 실패
	   			 jsr.put("message" , e.toString()); // error message
	   			 e.printStackTrace();
            } finally {
				DBUtil.end();
            }
        }
		return jsr;
	}
	/**
	 * 저장 
	 * @param p_mode ( 입력 : I, 수정 : U )
	 * @param gubun_code 
	 * @param name_code
	 * @param bd_start_day
	 * @param bd_end_day
	 * @param bd_time_h
	 * @param bd_time_m
	 * @param bd_place
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("text/html")
	@Consumes(MediaType.APPLICATION_FORM_URLENCODED)
	@Path("write")
	public String write(
			@DefaultValue("") @FormParam("p_mode"       ) String p_mode      ,
			@DefaultValue("") @FormParam("gubun_code"   ) String gubun_code  ,
			@DefaultValue("") @FormParam("name_code"    ) String name_code   ,
			@DefaultValue("") @FormParam("bd_start_day" ) String bd_start_day,
			@DefaultValue("") @FormParam("bd_end_day"   ) String bd_end_day  ,
			@DefaultValue("") @FormParam("bd_time_h"    ) String bd_time_h   ,
			@DefaultValue("") @FormParam("bd_time_m"    ) String bd_time_m   ,
			@DefaultValue("") @FormParam("bd_place"     ) String bd_place    ,     
			@DefaultValue("") @FormParam("p_schedule_no") String p_schedule_no
   ) throws Exception {
		JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {		
			 try {
				 if ( bd_start_day.equals("") ) throw new Exception("입력정보가 부족합니다.");
				 DBUtil.init();
				 DmsBdScheduleDAO dao = new DmsBdScheduleDAO();
				 JSONObject       vo  = new JSONObject();
				 
				 if ( p_mode.equals("I") ) 
					 vo.put("BD_NO"       ,dao.getMaxBdNo(gubun_code,name_code));
				 
				 vo.put("GUBUN_CODE"  ,gubun_code  );
				 vo.put("NAME_CODE"   ,name_code   );
				 vo.put("BD_START_DAY",bd_start_day.replaceAll("-", ""));
				 vo.put("BD_END_DAY"  ,bd_end_day.replaceAll("-", "")  );
				 vo.put("BD_TIME"     ,bd_time_h + bd_time_m           );
				 vo.put("BD_PLACE"    ,bd_place                        );
				 
				 vo.put("SCHEDULE_NO" ,p_schedule_no                   ); // key
				 
				 if ( p_mode.equals("I") ) {
					 if ( dao.insert(vo) ) {
		                 jsr.put("return" , "200"); // 성공
		                 jsr.put("message" , "저장되었습니다."); // error message
		 			 } else {
		  				throw new Exception("입력중 에러가 발생하였습니다."); 				 
					 }
				 } else if ( p_mode.equals("U") ) {
					 if ( dao.update(vo) ) {
		                 jsr.put("return" , "200"); // 성공
		                 jsr.put("message" , "저장되었습니다."); // error message
		 			 } else {
		  				throw new Exception("입력중 에러가 발생하였습니다."); 				 
					 }
				 }
			 } catch (Exception e) {
				 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
				 jsr.put("return" , "500"); // 실패
				 jsr.put("message" , e.toString()); // error message
				 e.printStackTrace();
			 } finally {
				 jsr.put("mode" , p_mode); // 입력			 
				 DBUtil.end();
			 }
        }
		return jsr.toString();
	}
	
	/**
	 * 삭제
	 * @param p_schedule_no
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("text/html")
	@Consumes(MediaType.APPLICATION_FORM_URLENCODED)
	@Path("delete")
	public String delete(
			@DefaultValue("0") @FormParam("p_schedule_no"  ) int p_schedule_no
   ) throws Exception {
		JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {		
			 try {
				 if ( p_schedule_no == 0 ) throw new Exception("정보가 부족합니다.");
				 DBUtil.init();
				 DmsBdScheduleDAO dao = new DmsBdScheduleDAO();
				 JSONObject       vo  = new JSONObject();
				 vo.put("SCHEDULE_NO"  ,p_schedule_no  );				 
				 if ( dao.delete(vo) ) {
	                 jsr.put("return" , "200"); // 성공
	                 jsr.put("message" , "삭제되었습니다."); // error message
	 			 } else {
	  				throw new Exception("삭제중 에러가 발생하였습니다."); 				 
				 }
			 } catch (Exception e) {
				 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
				 jsr.put("return" , "500"); // 실패
				 jsr.put("message" , e.toString()); // error message
				 e.printStackTrace();
			 } finally {
				 jsr.put("mode" , "D"); // 삭제			 
				 DBUtil.end();
			 }
        }
		return jsr.toString();
	}	
}