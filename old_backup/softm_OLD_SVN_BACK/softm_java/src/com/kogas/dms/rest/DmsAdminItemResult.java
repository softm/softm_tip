package com.kogas.dms.rest;

import java.io.File;
import java.sql.SQLException;
import java.util.List;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.ws.rs.Consumes;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.FormParam;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.Response;
import javax.ws.rs.core.Response.ResponseBuilder;

import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.FileItemFactory;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;
import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.Base;
import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Sql;
import com.kogas.dms.common.Util;

import com.kogas.dms.dao.*;
import com.kogas.dms.var.UPLOAD;

@Path("admin/itemresult")
public class DmsAdminItemResult extends Base {
    @Context
    private HttpServletRequest request;
    @Context
    private HttpServletResponse response;

	public DmsAdminItemResult(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
	}

	private final String UPLOAD_PATH = UPLOAD.UPLOAD_ADMIN;
	
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("list")
	public JSONObject list(
			@DefaultValue("0") @FormParam("s_schedule_no") int s_schedule_no
	) 	throws Exception {
		Log.debug("s_schedule_no ===> " + s_schedule_no);
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
				 DBUtil.init();
				 DmsProceedingsDAO dao = new DmsProceedingsDAO();
				 jsr = dao.list(s_schedule_no);
	                
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
	

	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("search_list")
	public JSONObject list(@DefaultValue("0") @FormParam("p_start") int p_start,
			@DefaultValue("") @FormParam("s_bd_start_day_from") String s_bd_start_day_from,
			@DefaultValue("") @FormParam("s_bd_start_day_to") String s_bd_start_day_to,
			@DefaultValue("T") @FormParam("s_proceed_status") String s_proceed_status,
			@DefaultValue("") @FormParam("s_bd_no") String s_bd_no,
			@DefaultValue("") @FormParam("s_name_code") String s_name_code) throws Exception {
		
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
        		
        		int page_navi_how_many   = 4;
        		int page_navi_more_many  = 4;
        		int page_navi_limit = 10;
        		
        		DmsBdItemResultDAO dao = new DmsBdItemResultDAO();
        		int p_page_many  = ( p_start >= page_navi_how_many + 1 ) ? page_navi_more_many : page_navi_how_many ;
        		jsr = dao.searchList(p_start, p_page_many, s_bd_start_day_from.replaceAll("-", ""), s_bd_start_day_to.replaceAll("-", ""), s_proceed_status, s_bd_no, s_name_code);

        		jsr.put("name_code_list", new DmsBdNameCodeDAO().listCode("10"));
        		
        		JSONObject jso = new JSONObject();
        		jso.put(StringUtils.defaultString("Y"),StringUtils.defaultString("등록"));
        		jso.put(StringUtils.defaultString("N"),StringUtils.defaultString("미등록"));
        		
        		jsr.put("s_proceed_status", jso);
        		
        		int totCnt = jsr.getInt("total");
            	jsr.put("page_navi", Sql.pageTab(p_start, totCnt, page_navi_how_many, page_navi_more_many, page_navi_limit, "fList") );
        		
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
	@Path("search_list2")
	public JSONObject list2(@DefaultValue("0") @FormParam("p_start") int p_start,
			@DefaultValue("") @FormParam("s_bd_start_day_from") String s_bd_start_day_from,
			@DefaultValue("") @FormParam("s_bd_start_day_to") String s_bd_start_day_to,
			@DefaultValue("") @FormParam("s_bd_no") String s_bd_no,
			@DefaultValue("") @FormParam("s_name_code") String s_name_code) throws Exception {
		
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
        		
        		int page_navi_how_many   = 4;
        		int page_navi_more_many  = 4;
        		int page_navi_limit = 10;
        		
        		DmsBdItemResultDAO dao = new DmsBdItemResultDAO();
        		int p_page_many  = ( p_start >= page_navi_how_many + 1 ) ? page_navi_more_many : page_navi_how_many ;
        		jsr = dao.searchList2(p_start, p_page_many, s_bd_start_day_from.replaceAll("-", ""), s_bd_start_day_to.replaceAll("-", ""), s_bd_no, s_name_code);

        		jsr.put("name_code_list", new DmsBdNameCodeDAO().listCode("10"));
        		
        		int totCnt = jsr.getInt("total");
            	jsr.put("page_navi", Sql.pageTab(p_start, totCnt, page_navi_how_many, page_navi_more_many, page_navi_limit, "fList") );
        		
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
    @Produces("text/html")
    @Path("write")
    public String write(@Context HttpServletRequest req) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
             jsr.put("return" , "404"); // 로그인되있지 않음
             jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
                DBUtil.init();
                Log.debug("WRITE");
                if (ServletFileUpload.isMultipartContent(req)) {
    				dbInit();	
    				FileItemFactory factory = new DiskFileItemFactory();
    				ServletFileUpload upload = new ServletFileUpload(factory);
    				List<FileItem> items = upload.parseRequest(req);

    				if (items != null) {
    					for (FileItem item : items) {
    						if (item.isFormField()) {
    							String fElementName = item.getFieldName();
    							String value = item.getString("UTF-8");
    							System.out.println("====> Got a form field: " + fElementName  + " " +value);
    							//jso.put(fElementName, value);
        					} 
    					}
        				
    					for (FileItem item : items) {
    						if (!item.isFormField()) {
    							String fElementName = item.getFieldName();								
    							System.out.println("----> Got a form field: " + fElementName );
//    							if ( "att_file".equals(fElementName) ) {
//    								display_att_file = processFileName(item.getName());
//    								String extraName = Util.getExtraName(display_att_file);
//    								real_att_file    = Util.getDateFormatString("yyyyMMddHHmmssS") + (extraName.equals("")?"":"."+extraName);
//    								jso.put("display_att_file", display_att_file);
//    								jso.put("real_att_file", real_att_file);
//    								try {
//    									item.write(new File(UPLOAD_PATH + File.separator + real_att_file));
//    								} catch (Exception e) {
//    									e.printStackTrace();
//    								}
//    							}
    						}
    					}
    					
//    					DmsBoardBasicDAO bbs_dao = new DmsBoardBasicDAO();
//    					if(!bbs_dao.insertBoardBasic(jso)) {
//    						jsr.put("return" , "500"); // 실패
//    						jsr.put("message" , "입력중 에러가 발생하였습니다."); // error message
//    						return jsr.toString();
//    					}
    					jsr.put("return" , "200"); // 성공
                        jsr.put("message" , "저장되었습니다."); // error message
    	             }
    				jsr.put("return" , "200"); // 성공
    	            jsr.put("message" , "저장되었습니다."); // error message
                } else {
    				throw new Exception("올바르지 않은 접근입니다.");
    			}	
             } catch (Exception e) {
                 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
                 jsr.put("return" , "500"); // 실패
                 jsr.put("message" , e.toString()); // error message
                 e.printStackTrace();
             } finally {
                 DBUtil.end();
             }
        }
        return jsr.toString();
    }

	
	/**
	 * 파일 다운로드
	 * @param no
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("text/html")
	@Path("file_download")
	public Response download(@DefaultValue("0") @FormParam("p_schedule_no") int no , 
			                 @DefaultValue("") @FormParam("p_real_file_name") String p_real_file_name,
			                 @DefaultValue("") @FormParam("p_display_file_name") String p_display_file_name) throws Exception {
		String displayName = "";
		String realName = "";
		ResponseBuilder response = null;
		
		try {
			realName = p_real_file_name;
			displayName = p_display_file_name;
			displayName = displayName.replaceAll("\\s", "_");
		} catch ( Exception e) {
			Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
			e.printStackTrace();
		} finally {
			dbFinal();
			if ( !realName.equals("") && !displayName.equals("") ) {
				Util.logger.error("download - realName :" + realName + "<BR>");
				Util.logger.error("download - displayName :" + displayName + "<BR>");
				File file = new File(UPLOAD_PATH + File.separator + realName);
				response = Response.ok((Object) file);
				response.header("Content-Disposition","attachment; filename="+Util.getFileNameByBrowser(displayName, Util.getBrowser(request)));
			} else {
				response = Response.status(404);
			}
		}
		return response.build();	
	}	
	
	
}