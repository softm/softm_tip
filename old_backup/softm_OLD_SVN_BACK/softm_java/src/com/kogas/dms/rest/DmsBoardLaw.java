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
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.Base;
import com.kogas.dms.common.Sql;
import com.kogas.dms.common.Util;
import com.kogas.dms.var.UPLOAD;

import com.kogas.dms.dao.*;

@Path("board/law")
public class DmsBoardLaw extends Base {
    @Context
    private HttpServletRequest request;
    @Context
    private HttpServletResponse response;

	public DmsBoardLaw(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
	}

	private final String UPLOAD_PATH = UPLOAD.UPLOAD_LAW;
	
	/**
	 * 게시판 리스트 조회
	 * @param p_start
	 * @param s_code
	 * @param s_subject
	 * @param s_context
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("law_list")
	public JSONObject list(
			@DefaultValue("0") @FormParam("p_start") int p_start,
			@DefaultValue("") @FormParam("s_code") String s_code,
			@DefaultValue("") @FormParam("s_subject") String s_subject,
			@DefaultValue("") @FormParam("s_context") String s_context
	) 	throws Exception {
        
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
            try {
            	dbInit();
            	DmsBoardCodeDAO code_dao = new DmsBoardCodeDAO();
            	JSONObject code_list = code_dao.getBoardCodeList("30");
            	
            	int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;
            	
            	DmsBoardLawDAO bbs_dao = new DmsBoardLawDAO();
            	jsr = bbs_dao.getBoardLawList(p_start, p_page_many, s_code, s_subject, s_context);

            	if(jsr == null) {
            		jsr.put("return" , "500"); // 실패, 
            		jsr.put("message" , "데이터 조회 실패"); 
            		return jsr;
            	}
            	
            	jsr.put("data_board_code", code_list);
            	int totCnt = jsr.getInt("total");
            	jsr.put("page_navi", Sql.pageTab(p_start, totCnt, Sql.page_navi_how_many, Sql.page_navi_more_many, Sql.page_navi_limit, "fList") );

            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); // 실패
	   			 jsr.put("message" , e.toString()); // error message
	   			 e.printStackTrace();
            } finally {
            	dbFinal();
            }
        }
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
	@Path("law_view")
	public JSONObject get(
			@DefaultValue("0") @FormParam("p_no") int p_no,
			@DefaultValue("") @FormParam("s_code") String s_code,
			@DefaultValue("") @FormParam("s_subject") String s_subject,
			@DefaultValue("") @FormParam("s_context") String s_context
	) 	throws Exception {
        
        JSONObject jsr = new JSONObject();
        JSONArray jso = new JSONArray();
        
        if ( loginInfo.loginYn.equals("") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "접근권한이 없습니다."); // error message
        } else {
        	try {
            	dbInit();
            	DmsBoardLawDAO bbs_dao = new DmsBoardLawDAO();
            	jsr = bbs_dao.getBoardLawDetail(p_no);
            	jso = (JSONArray) bbs_dao.getBoardLawNextList(p_no, s_code, s_subject, s_context);
            	
            	bbs_dao.setReadCountUpdate(p_no);
            	
            	if(jsr == null) {
            		jsr.put("return" , "500"); // 실패, 
            		jsr.put("message" , "데이터 조회 실패"); 
            		return jsr;
            	}
            	jsr.put("next_data",jso);
            	jsr.put("return" , "200"); // 실패, 
        		jsr.put("message" , "조회되었습니다");
            	
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); // 실패
	   			 jsr.put("message" , e.toString()); // error message
	   			 e.printStackTrace();
            } finally {
            	dbFinal();
            }
        }
		return jsr;
	}

	
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("law_modify")
	public JSONObject getModify(
			@DefaultValue("0") @FormParam("p_no") int p_no
	) 	throws Exception {
        
        JSONObject jsr = new JSONObject();
        JSONArray jso = new JSONArray();
        
        if ( loginInfo.loginYn.equals("") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "접근권한이 없습니다."); // error message
        } else {
        	try {
            	dbInit();
            	DmsBoardLawDAO bbs_dao = new DmsBoardLawDAO();
            	jsr = bbs_dao.getBoardLawDetail(p_no);
            	
            	DmsBoardCodeDAO code_dao = new DmsBoardCodeDAO();
            	JSONObject code_list = code_dao.getBoardCodeList("30");
            	
            	if(jsr == null) {
            		jsr.put("return" , "500"); // 실패, 
            		jsr.put("message" , "데이터 조회 실패"); 
            		return jsr;
            	}
            	jsr.put("data_board_code", code_list);
            	jsr.put("return" , "200"); // 실패, 
        		jsr.put("message" , "조회되었습니다");
            	
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); // 실패
	   			 jsr.put("message" , e.toString()); // error message
	   			 e.printStackTrace();
            } finally {
            	dbFinal();
            }
        }
		return jsr;
	}
	
	/**
	 * 파일 다운로드
	 * @param no
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("text/html")
	@Path("law_download")
	public Response download(@FormParam("p_no") int no ) throws Exception {
		String displayName = "";
		String realName = "";
		ResponseBuilder response = null;
		JSONObject jsr = new JSONObject();
		
		try {
			dbInit();
			DmsBoardLawDAO bbs_dao = new DmsBoardLawDAO();
			JSONObject jso = (JSONObject) bbs_dao.getAttFile(no);
			realName = jso.getString("real_att_file");
			displayName = jso.getString("display_att_file");
			displayName = displayName.replaceAll("\\s", "_");
		} catch ( SQLException e) {
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
	
	/**
	 * 공지사항 코드 조회
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("law_code")
	public JSONObject getCode() 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "접근권한이 없습니다."); // error message
        } else {
            try {
            	dbInit();
            	DmsBoardCodeDAO code_dao = new DmsBoardCodeDAO();
            	JSONObject code_list = code_dao.getBoardCodeList("30");
            	
            	if(code_list == null) {
            		jsr.put("return" , "500"); // 실패, 
            		jsr.put("message" , "데이터 조회 실패"); 
            		return jsr;
            	}
           		jsr.put("data_board_code", code_list);
           		jsr.put("return" , "200"); // 성공
           		jsr.put("message" , "조회되었습니다."); // error message
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 jsr.put("return" , "500"); // 실패
	   			 jsr.put("message" , e.toString()); // error message
	   			 e.printStackTrace();
            } finally {
            	dbFinal();
            }
        }
		return jsr;
	}	
	
	
	/**
	 * 게시판 등록
	 * @param req
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("text/html")
	@Path("law_write")
	public String write(@Context HttpServletRequest req) throws Exception {
		JSONObject jso = new JSONObject();
		JSONObject jsr = new JSONObject();
		 try {
			 
			if (ServletFileUpload.isMultipartContent(req)) {
				dbInit();	
				FileItemFactory factory = new DiskFileItemFactory();
				ServletFileUpload upload = new ServletFileUpload(factory);

				List<FileItem> items = upload.parseRequest(req);

				if (items != null) {
					String display_att_file = "";
					String real_att_file = "";
                        
					for (FileItem item : items) {
						if (item.isFormField()) {
							String fElementName = item.getFieldName();
							String value = item.getString("UTF-8");
							System.out.println("Got a form field: " + fElementName  + " " +value);
							jso.put(fElementName, value);
    					} 
					}
    				
					for (FileItem item : items) {
						if (!item.isFormField()) {
							String fElementName = item.getFieldName();								
							System.out.println("Got a form field: " + fElementName );
							if ( "att_file".equals(fElementName) ) {
								display_att_file = processFileName(item.getName());
								String extraName = Util.getExtraName(display_att_file);
								real_att_file    = Util.getDateFormatString("yyyyMMddHHmmssS") + (extraName.equals("")?"":"."+extraName);
								jso.put("display_att_file", display_att_file);
								jso.put("real_att_file", real_att_file);
								try {
									item.write(new File(UPLOAD_PATH + File.separator + real_att_file));
								} catch (Exception e) {
									e.printStackTrace();
								}
							}
						}
					}
					
					DmsBoardLawDAO bbs_dao = new DmsBoardLawDAO();
					if(!bbs_dao.insertBoardLaw(jso)) {
						jsr.put("return" , "500"); // 실패
						jsr.put("message" , "입력중 에러가 발생하였습니다."); // error message
						return jsr.toString();
					}
					jsr.put("return" , "200"); // 성공
                    jsr.put("message" , "저장되었습니다."); // error message
	             }
			} else {
				throw new Exception("올바르지 않은 접근입니다.");
			}			 
		 } catch (Exception e) {
			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
			 jsr.put("return" , "500"); // 실패
			 jsr.put("message" , e.toString()); // error message
			 e.printStackTrace();
		 } finally {
			 jsr.put("mode" , "I"); // 입력			 
			 dbFinal();
		 }
		return jsr.toString();
	}
	
	private String processFileName(String fileNameInput) {
		String fileNameOutput = null;
		fileNameOutput = fileNameInput.substring(
				fileNameInput.lastIndexOf("\\") + 1, fileNameInput.length());
		return fileNameOutput;
	}

	@POST
	@Produces("text/html")
	@Path("law_update")
	public String update(@Context HttpServletRequest req) throws Exception {
		JSONObject jso = new JSONObject();
		JSONObject jsr = new JSONObject();
		 try {
			 
			if (ServletFileUpload.isMultipartContent(req)) {
				dbInit();	
				FileItemFactory factory = new DiskFileItemFactory();
				ServletFileUpload upload = new ServletFileUpload(factory);

				List<FileItem> items = upload.parseRequest(req);
				
				if(items != null) {
					int p_no = 0;
					String delete_yn_att_file = "";
					for (FileItem item : items) {
						if (item.isFormField()) {
							String fElementName = item.getFieldName();
							String value = item.getString("UTF-8");
							Log.debug("-----> fElementName:"+fElementName+",  value:" + value);
							
							if ( "p_no".equals(fElementName) ) {
								p_no = Integer.parseInt(value);
								jso.put("no", p_no);
							} else if ( "delete_yn_att_file".equals(fElementName) ) {
								 delete_yn_att_file = value;
							} else {
								 jso.put(fElementName, value);
							}
						}
					}
					
					DmsBoardLawDAO bbs_dao = new DmsBoardLawDAO();
					JSONObject jsa = (JSONObject) bbs_dao.getAttFile(p_no);
					String real_att_file = jsa.getString("real_att_file");
					String display_att_file = jsa.getString("display_att_file");
					Log.debug("====> real_att_file : " + real_att_file);
					Log.debug("====> display_att_file : " + display_att_file);
					jso.put("display_att_file", display_att_file);
					jso.put("real_att_file", real_att_file);

					if(delete_yn_att_file.equals("Y") && !"".equals(real_att_file)) {
						String attFile = UPLOAD_PATH + File.separator + real_att_file;
						Log.debug("====> attFile:"+attFile);
						Log.debug("====> 기존 첨부 파일 삭제");
						if ( Util.isFileExists (attFile) ) Util.fileDelete (attFile);
						jso.put("display_att_file", "");
						jso.put("real_att_file", "");
					}
					
					for (FileItem item : items) {
						if (!item.isFormField()) {
							String fElementName = item.getFieldName();
							if ( "att_file".equals(fElementName) ) {
								if(item.getSize() > 0) {
									if(!"".equals(real_att_file)) {
										String attFile = UPLOAD_PATH + File.separator + real_att_file;
										Log.debug("====> attFile:"+attFile);
										Log.debug("====> 기존 첨부 파일 삭제2");
										if ( Util.isFileExists (attFile) ) Util.fileDelete (attFile);
									}
									
									display_att_file = processFileName(item.getName());
									String extraName = Util.getExtraName(display_att_file);
									real_att_file    = Util.getDateFormatString("yyyyMMddHHmmssS") + (extraName.equals("")?"":"."+extraName);
									jso.put("display_att_file", display_att_file);
									jso.put("real_att_file", real_att_file);
									Log.debug("====> 파일 첨부");
									try {
										item.write(new File(UPLOAD_PATH + File.separator + real_att_file));
									} catch (Exception e) {
										e.printStackTrace();
									}
								} 
							}
						}
					}
				}
				
				DmsBoardLawDAO bbs_dao = new DmsBoardLawDAO();
				if(!bbs_dao.updateBoardLaw(jso)) {
					jsr.put("return" , "500"); // 실패
					jsr.put("message" , "입력중 에러가 발생하였습니다."); // error message
					return jsr.toString();
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
			 jsr.put("mode" , "I"); // 입력			 
			 dbFinal();
		 }
		return jsr.toString();
	}
	
	@POST
	@Produces("text/html")
	@Path("law_delete")
	public String delete(@DefaultValue("0") @FormParam("p_no") int p_no) throws Exception {
		JSONObject jsr = new JSONObject();
		 try {
			 dbInit();	
			 DmsBoardLawDAO bbs_dao = new DmsBoardLawDAO();
             Log.debug("====> p_no : " + p_no);           
			 if(!bbs_dao.deleteBoardLaw(p_no)) {
				 jsr.put("return" , "500"); // 실패
				 jsr.put("message" , "삭제중 에러가 발생하였습니다."); // error message
				 return jsr.toString();
			 }
			 jsr.put("return" , "200"); // 성공
			 jsr.put("message" , "삭제 되었습니다."); // error message
		 } catch (Exception e) {
			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
			 jsr.put("return" , "500"); // 실패
			 jsr.put("message" , e.toString()); // error message
			 e.printStackTrace();
		 } finally {
			 dbFinal();
		 }
		return jsr.toString();
	}

}