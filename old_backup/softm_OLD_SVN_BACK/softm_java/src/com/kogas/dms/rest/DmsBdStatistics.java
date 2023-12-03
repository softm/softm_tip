/**
 * 통계
 * @version : 1.0
 * @author  : Kim Dae-Kwon
 */
package com.kogas.dms.rest;

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

import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.Base;
import com.kogas.dms.common.DBUtil;
//import com.kogas.dms.common.SendMail;
import com.kogas.dms.common.Util;
import com.kogas.dms.dao.DmsBdStBusinessDAO;
import com.kogas.dms.dao.DmsBdStManageResultDAO;

@Path("dms_stat/bd_statistics")
public class DmsBdStatistics extends Base {
	public DmsBdStatistics(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
	}
	
	/**
	 * 이사회 개최 횟수 조회
	 * @param stdYear(기준년)
	 * @return JSONObject
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("mtNum")
	public JSONObject mtNum(
			@DefaultValue("0") @FormParam("stdYear") String stdYear
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); 							// 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); 	// error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdStManageResultDAO dao = new DmsBdStManageResultDAO();
				 jsr.put("data", dao.getMeetingHoldNumber(stdYear));
				 
//				 SendMail sendMail = new SendMail();
//				 sendMail.sendMailReturn(180, "그냥");
//				 sendMail.sendMailItemSubmission(180);
//				 sendMail.sendMailDataRequest(180, "00100008");
//				 sendMail.sendMailDataRequestSubmission(180);
//				 sendMail.sendMailPropelPresentRequest(180, "00100008");
//				 sendMail.sendMailPropelPresentSubmission(180);
//				 sendMail.sendMailItemResult(180);
				 
                 jsr.put("return" , "200"); 						// 성공
                 jsr.put("message" , "조회되었습니다."); 	// error message
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); 						// 실패
	   			 jsr.put("message" , e.toString());			 // error message
	   			 e.printStackTrace();
            } finally {
				 DBUtil.end();
            }
        }
		return jsr;
	}
	
	/**
	 * 안건 비중 조회
	 * @param stdYear(기준년)
	 * @return JSONObject
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("itemRt")
	public JSONObject itemRt(
			@DefaultValue("0") @FormParam("stdYear") String stdYear
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); 								// 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); 		// error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdStManageResultDAO dao = new DmsBdStManageResultDAO();
				 jsr.put("data", dao.getItemRate(stdYear));	// 안건 비중 (JSONArray)
                 jsr.put("return" , "200"); 							// 성공
                 jsr.put("message" , "조회되었습니다."); 		// error message
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); 							// 실패
	   			 jsr.put("message" , e.toString());			 	// error message
	   			 e.printStackTrace();
            } finally {
				 DBUtil.end();
            }
        }
		return jsr;
	}
	
	/**
	 * 참석률 조회
	 * @param stdYear(기준년)
	 * @return JSONObject
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("attRt")
	public JSONObject attRt(
			@DefaultValue("0") @FormParam("stdYear") String stdYear
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); 												// 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); 						// error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdStManageResultDAO dao = new DmsBdStManageResultDAO();
				 jsr.put("data", dao.getAttendanceRate(stdYear));			// 참석률 (JSONArray)
                 jsr.put("return" , "200"); 											// 성공
                 jsr.put("message" , "조회되었습니다."); 						// error message
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); 											// 실패
	   			 jsr.put("message" , e.toString());			 					// error message
	   			 e.printStackTrace();
            } finally {
				 DBUtil.end();
            }
        }
		return jsr;
	}
	
	/**
	 * 발언 비중 조회
	 * @param stdYear(기준년)
	 * @return JSONObject
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("stmRt")
	public JSONObject stmRt(
			@DefaultValue("0") @FormParam("stdYear") String stdYear
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); 												// 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); 						// error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdStManageResultDAO dao = new DmsBdStManageResultDAO();
				 jsr.put("data", dao.getStatementRate(stdYear));			// 발언 비중 (JSONArray)
                 jsr.put("return" , "200"); 											// 성공
                 jsr.put("message" , "조회되었습니다."); 						// error message
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); 											// 실패
	   			 jsr.put("message" , e.toString());			 					// error message
	   			 e.printStackTrace();
            } finally {
				 DBUtil.end();
            }
        }
		return jsr;
	}
	
	/**
	 * 사업 별 안건 수 조회
	 * @param stdYear(기준년)
	 * @param businessType(사업유형)
	 * @param fieldName(분야명)
	 * @return JSONObject
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("itemNum")
	public JSONObject itemNum(
			@DefaultValue("0") @FormParam("stdYear") String stdYear,
			@DefaultValue("0") @FormParam("businessType") String businessType,
			@DefaultValue("0") @FormParam("fieldName") String fieldName
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); 												// 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); 						// error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdStBusinessDAO dao = new DmsBdStBusinessDAO();
				 jsr.put("data", dao.getBusinseeItemNumber(stdYear, businessType, fieldName));			// 사업별 안건 수 (JSONObject)
                 jsr.put("return" , "200"); 											// 성공
                 jsr.put("message" , "조회되었습니다."); 						// error message
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); 											// 실패
	   			 jsr.put("message" , e.toString());			 					// error message
	   			 e.printStackTrace();
            } finally {
				 DBUtil.end();
            }
        }
		return jsr;
	}
	
	/**
	 * 이사별 요청자료 건수 조회
	 * @param stdYear(기준년)
	 * @param businessType(사업유형)
	 * @param fieldName(분야명)
	 * @return JSONObject
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("reqNum")
	public JSONObject reqNum(
			@DefaultValue("0") @FormParam("stdYear") String stdYear,
			@DefaultValue("0") @FormParam("businessType") String businessType,
			@DefaultValue("0") @FormParam("fieldName") String fieldName
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); 												// 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); 						// error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdStBusinessDAO dao = new DmsBdStBusinessDAO();
				 jsr.put("data", dao.getRequestNumberList(stdYear, businessType, fieldName));			// 이사별 요청자료 건수 (JSONArray)
                 jsr.put("return" , "200"); 											// 성공
                 jsr.put("message" , "조회되었습니다."); 						// error message
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); 											// 실패
	   			 jsr.put("message" , e.toString());			 					// error message
	   			 e.printStackTrace();
            } finally {
				 DBUtil.end();
            }
        }
		return jsr;
	}
}