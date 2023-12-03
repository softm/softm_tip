/**
 * 게시판
 * @version : 1.0
 * @author  : kim ji hun (softm@nate.com)
 */
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
import com.kogas.dms.dao.DmsCommonDAO;
import com.kogas.dms.var.TABLE;

// POJO, no interface no extends

//Sets the path to base URL + /hello

@Path("sample/notice")
public class Sample extends Base {
	public Sample(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
	}
	
	private final String UPLOAD_PATH = "D:\\WEB_APP\\eclipse_workspace\\work\\upload";
	
	/**
	 * 게시판 - 조회
	 * @param p_start 시작 위치
	 * @return 조회데이터
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("list")
	public JSONObject list(
			@DefaultValue("0") @FormParam("p_start") int p_start,
			@DefaultValue("") @FormParam("s_code") String s_code,
			@DefaultValue("") @FormParam("s_subject") String s_subject
	) 	throws Exception {
        int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;
        
        Log.debug("p_start : "  + p_start);
        Log.debug("s_code  : "  + s_code );
         
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
            try {
            	dbInit();
                JSONArray jsa = new JSONArray();
                StringBuffer sql = new StringBuffer();
/*
                sql.append(" SELECT  ")
                   .append(" COUNT(*)")
                   .append(" FROM " + TABLE.TBL_DMS_BOARD_NOTICE)
                ;

                int cnt = Sql.getCount(sql.toString(), this.conn);

                jsr.put("count" , cnt); // 자료수
*/
                int totCnt = -1;
                sql.setLength(0);
                sql.append(
                " SELECT "
                        + " * "
                        + " FROM ("
                        + "     SELECT"
                        + "         A.*,"
                        + "         ROWNUM AS RNUM,"
                        + "         COUNT(*) OVER() AS TOTCNT FROM"
                        + "     ("
                        + "         SELECT"
                        + "             NO        ,"
                        + "             CODE      ,"
                        + "             SUBJECT   ,"
                        + "             CONTEXT   ,"
                        + "             WRITER    ,"
                        + "             TO_CHAR(TO_DATE(WRITE_DATE,'YYYYMMDDHH24MISS'),'YYYY-MM-DD') WRITE_DATE,"
                        + "             READ_COUNT,"
                        + "             REAL_ATT_FILE,   "
                        + "             DISPLAY_ATT_FILE   "
                        + "         FROM " + TABLE.TBL_DMS_BOARD_NOTICE + " a "
                        + "         WHERE 0 = 0"
                        + (s_code.equals("")?"":" AND CODE = '" + s_code + "'")
                        + (s_subject.equals("")?"":" AND SUBJECT LIKE '" + s_subject + "%'")
                        + "         ORDER BY NO DESC"
                        + "     ) A"
                        + " ) WHERE RNUM > ? AND RNUM <= ?"
                );
                Log.debug(sql.toString());
                pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
                pstmt.setInt(1, p_start - 1);
                pstmt.setInt(2, p_start - 1 + p_page_many);

                rs  = pstmt.executeQuery();
                while ( rs.next() ) {
                    JSONObject jso = new JSONObject();
                    jso.put("mode"      , "V");
                    jso.put("rnum"          , StringUtils.defaultString(rs.getString("RNUM"         )));
                    jso.put("no"            , StringUtils.defaultString(rs.getString("NO"           )));
                    jso.put("code"          , StringUtils.defaultString(rs.getString("CODE"         )));
                    jso.put("subject"       , StringUtils.defaultString(rs.getString("SUBJECT"      )));
                    jso.put("context"       , StringUtils.defaultString(rs.getString("CONTEXT"      )));
                    jso.put("writer"        , StringUtils.defaultString(rs.getString("WRITER"       )));
                    jso.put("write_date"    , StringUtils.defaultString(rs.getString("WRITE_DATE"   )));
                    jso.put("read_count"    , StringUtils.defaultString(rs.getString("READ_COUNT"   )));
                    jso.put("real_att_file"    , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"    )));
                    jso.put("display_att_file" , StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE" )));

                    if ( totCnt == -1 ) {
                        totCnt = rs.getInt("TOTCNT");
                        jsr.put("total", totCnt);
                    }
                    jsa.put(jso);
                }
                
                if ( totCnt == -1 ) {
                    totCnt = 0;
                    jsr.put("total", totCnt);
                }
                
                jsr.put("data", jsa); // data
                // 보드 타입 데이터.
                jsr.put("data_board_code", DmsCommonDAO.getBoardCode("10") );
                Log.info("totCnt : "  + totCnt);
	            // Page Navi
	            jsr.put("page_navi", Sql.pageTab(p_start, totCnt, Sql.page_navi_how_many, Sql.page_navi_more_many, Sql.page_navi_limit, "fList") );
	            
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
	 * 게시판 - 한건조회
	 * @param p_no 게시물번호
	 * @return 조회데이터
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("get")
	public JSONObject get(
			@DefaultValue("0") @FormParam("p_no") int p_no
	) 	throws Exception {
        Log.debug("p_no : "  + p_no);
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "접근권한이 없습니다."); // error message
        } else {
            try {
            	dbInit();
                StringBuffer sql = new StringBuffer();
                sql.setLength(0);
                sql.append(
                  " SELECT"
      	                + " a.NO         NO     ,"
      	                + " a.CODE       CODE   ,"
      	                + " b.CODE_NAME  CODE_NAME   ,"
      	                + " a.SUBJECT    SUBJECT,"
      	                + " a.CONTEXT    CONTEXT,"
      	                + " a.WRITER     WRITER ,"
      	                + " TO_CHAR(TO_DATE(a.WRITE_DATE,'YYYYMMDDHH24MISS'),'YYYY-MM-DD') WRITE_DATE,"
      	                + " a.READ_COUNT READ_COUNT,"
      	                + " a.REAL_ATT_FILE      REAL_ATT_FILE,   "
      	                + " a.DISPLAY_ATT_FILE   DISPLAY_ATT_FILE   "
    	                + " FROM " + TABLE.TBL_DMS_BOARD_NOTICE + " a "
    	                + " LEFT OUTER JOIN " + TABLE.TBL_DMS_BOARD_CODE + " b "
    	                + " ON a.CODE = b.CODE AND b.BOARD_TYPE = '10'"
    	                + " WHERE a.NO = ?"
                );
                Log.debug(sql.toString());
                pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
                pstmt.setInt(1, p_no);
                rs  = pstmt.executeQuery();
                JSONObject jso = new JSONObject();
                while ( rs.next() ) {
                    jso.put("mode"      , "V");
                    jso.put("no"            , StringUtils.defaultString(rs.getString("NO"           )));
                    jso.put("code"          , StringUtils.defaultString(rs.getString("CODE"         )));
                    jso.put("code_name"     , StringUtils.defaultString(rs.getString("CODE_NAME"    )));
                    jso.put("subject"       , StringUtils.defaultString(rs.getString("SUBJECT"      )));
                    jso.put("context"       , StringUtils.defaultString(rs.getString("CONTEXT"      )));
                    jso.put("writer"        , StringUtils.defaultString(rs.getString("WRITER"       )));
                    jso.put("write_date"    , StringUtils.defaultString(rs.getString("WRITE_DATE"   )));
                    jso.put("read_count"    , StringUtils.defaultString(rs.getString("READ_COUNT"   )));
                    jso.put("real_att_file"   , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"     )));
                    jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE"     )));
                }
                jsr.put("data", jso); // data
                
                jsr.put("data_board_code", DmsCommonDAO.getBoardCode("10") );
                
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
	 * 게시판 - 코드
	 * @param p_no 게시물번호
	 * @return 조회데이터
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("get_code")
	public JSONObject getCode(
			@DefaultValue("10") @FormParam("p_board_type") int p_no
	) 	throws Exception {
        Log.debug("p_no : "  + p_no);
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "접근권한이 없습니다."); // error message
        } else {
            try {
            	dbInit();
                jsr.put("data_board_code", DmsCommonDAO.getBoardCode("10") );
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
	 * 데이터 저장
	 * @param req
	 * @return String
	 */
	// @Consumes("application/x-www-form-urlencoded")
	@POST
	@Produces("text/html")
	// @Consumes(MediaType.MULTIPART_FORM_DATA)
	// @Produces("application/json")
	@Path("write")
	public String write(@Context HttpServletRequest req) throws Exception {
		JSONObject jsr = new JSONObject();
		Log.info("loginInfo.adminYn : " + loginInfo.adminYn);
		 try {
			 
			if (ServletFileUpload.isMultipartContent(req)) {
//				 if ( loginInfo.adminYn.equals("N") ) {
//					 jsr.put("return" , "404"); // 로그인되있지 않음
//					 jsr.put("message" , "작성권한이 없습니다."); // error message
//				 } else {
				dbInit();	
                StringBuffer sql = new StringBuffer();
					FileItemFactory factory = new DiskFileItemFactory();
					ServletFileUpload upload = new ServletFileUpload(factory);

//					upload.setHeaderEncoding("UTF-8");
					List<FileItem> items = upload.parseRequest(req);
					if (items != null) {
						// 디비필드 
                        String p_mode   = "";
                        int   p_no      = 0;
                        String code     = "";
                        String subject  = "";
                        String context  = "";
                        String writer   = loginInfo.empNm; // 로그인한 회원명
                        
                        boolean isupfile_att_file = false;
                        boolean isupdate_att_file = false;
                        String delete_yn_att_file = "";
                        String display_att_file = "";
                        String real_att_file = "";
                        
                        int sIdx = 1;
                        
    					for (FileItem item : items) {
    						if (item.isFormField()) {
    							String fElementName = item.getFieldName();
    							String value = item.getString("UTF-8");
								 System.out.println("Got a form field: " + fElementName  + " " +value);
								 if ( "p_mode".equals(fElementName) ) {
									 p_mode = value;
								 } else if ( "p_no".equals(fElementName) ) {
									 p_no = Integer.parseInt(value);
								 } else if ( "code".equals(fElementName) ) {
									 code = value;
								 } else if ( "subject".equals(fElementName) ) {
									 subject = value;
								 } else if ( "context".equals(fElementName) ) {
									 context = value;
								 } else if ( "writer".equals(fElementName) ) {
									 writer = value;
								 } else if ( "delete_yn_att_file".equals(fElementName) ) {
									 delete_yn_att_file = value;
								 }    							
    						}
    					} 
    					
    					for (FileItem item : items) {
							if (!item.isFormField()) {
  							    String fElementName = item.getFieldName();								
								 System.out.println("Got a form field: " + fElementName );
								if ( "att_file".equals(fElementName) ) {
									if ( item.getSize() > 0 ) isupfile_att_file = true;
									// 파일 삭제
									if ( p_mode.equals("U") ) {
						                sql.setLength(0);
						                sql.append(
						                  " SELECT"
						      	                + " a.REAL_ATT_FILE      REAL_ATT_FILE,   "
						      	                + " a.DISPLAY_ATT_FILE   DISPLAY_ATT_FILE   "
						    	                + " FROM " + TABLE.TBL_DMS_BOARD_NOTICE + " a "
						    	                + " WHERE a.NO = ?"
						                );
						                pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
						                pstmt.setInt(1, p_no);
						                rs  = pstmt.executeQuery();
						                while ( rs.next() ) {
						                    real_att_file    = StringUtils.defaultString(rs.getString("REAL_ATT_FILE"));
						                    display_att_file = StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE"));
						                }
									}
		                        	
									if ( isupfile_att_file || delete_yn_att_file.equals("Y") ) {
										String attFile = UPLOAD_PATH + File.separator + real_att_file;
										if ( Util.isFileExists (attFile) ) Util.fileDelete (attFile);
				                        Log.info("file Delete :" + attFile);
										display_att_file = "";				                        
										real_att_file    = "";
					                    isupdate_att_file = true;										
									}
									
			                        Log.info("file isupfile_att_file :" + isupfile_att_file);
									if ( isupfile_att_file ) {
										display_att_file = processFileName(item.getName());
										String extraName = Util.getExtraName(display_att_file);
										real_att_file    = Util.getDateFormatString("yyyyMMddHHmmssS") + (extraName.equals("")?"":"."+extraName);
					                    isupdate_att_file = true;										
										try {
											item.write(new File(UPLOAD_PATH + File.separator + real_att_file));
										} catch (Exception e) {
											e.printStackTrace();
										}
									}
								}
							}
						}
    					
		                sql.setLength(0);
                        if (p_mode.equals("I") ) {                        
	                        sql.append("INSERT INTO " + TABLE.TBL_DMS_BOARD_NOTICE + "(" )
	                            .append("NO        ,") // 
	                            .append("CODE      ,") // 1
	                            .append("SUBJECT   ,") // 2
	                            .append("CONTEXT   ,") // 3
	                            .append("WRITER    ,") // 4
	                            .append("WRITE_DATE,") // 
	                            .append("READ_COUNT,") // 
	                            .append("REAL_ATT_FILE   ") // 5
	                            .append("DISPLAY_ATT_FILE   ") // 6
	                            .append(" ) VALUES (")
	                            .append("DMS_BOARD_NOTICE_SEQ.NEXTVAL,")
	                            .append("?,") // 1
	                            .append("?,") // 2
	                            .append("?,") // 3
	                            .append("?,") // 4
	                            .append("TO_CHAR(SYSDATE,'YYYYMMDDHH24MISS'),")
	                            .append("0,")				 
	                            .append("?") // 5		 
	                            .append("?") // 6		 
	                            .append(")")
	                        ;
                        } else if (p_mode.equals("U") ) { 
	                        sql.append("UPDATE " + TABLE.TBL_DMS_BOARD_NOTICE + "" )
                            .append(" SET ") // 
                            .append(" CODE      =?,") // 1
                            .append(" SUBJECT   =?,") // 2
                            .append(" CONTEXT   =?,") // 3
                            .append(isupdate_att_file?" REAL_ATT_FILE  =?, ":"") // 4
                            .append(isupdate_att_file?" DISPLAY_ATT_FILE  =?, ":"") // 5
                            .append(" WRITER    =? ") // 6
                            .append(" WHERE NO = ?") // 7
                            ;	
                        }
                        Log.info("sql.toString():" + sql.toString());
                        
                         pstmt = DBUtil.getConnection().prepareStatement( sql.toString() );
                         if (p_mode.equals("I") ) {
                             pstmt.setString(sIdx++ , code     );
                             pstmt.setString(sIdx++ , subject  );
                             pstmt.setString(sIdx++ , context  );
                             pstmt.setString(sIdx++ , writer   );
                             pstmt.setString(sIdx++ , real_att_file );
                             pstmt.setString(sIdx++ , display_att_file );
                         } else if (p_mode.equals("U") ) { 
                             pstmt.setString(sIdx++ , code     );
                             pstmt.setString(sIdx++ , subject  );
                             pstmt.setString(sIdx++ , context  );
                             if ( isupdate_att_file ) {
	                             pstmt.setString(sIdx++ , real_att_file );
	                             pstmt.setString(sIdx++ , display_att_file );
                             }
                             pstmt.setString(sIdx++ , writer   );
                             pstmt.setInt   (sIdx++ , p_no     );
                         }
                         
             			 if( pstmt.executeUpdate() == 0 ) {
             				throw new Exception("입력중 에러가 발생하였습니다.");
             			 } else {
                             jsr.put("return" , "200"); // 성공
                             jsr.put("message" , "저장되었습니다."); // error message
             			 }
						 
					}
//	             }
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
	
	
	/**
	 * 데이터 저장
	 * @param p_type
	 * @param p_no 게시물번호
	 * @return String
	 */
    // @Consumes("application/x-www-form-urlencoded")
	@POST
	@Produces("text/html")
	// @Consumes(MediaType.MULTIPART_FORM_DATA)
	// @Produces("application/json")
	@Path("download")
//	public Response download(@QueryParam("p_file") String fileName,@QueryParam("p_file_name") String realFName) throws Exception {
	public Response download(@FormParam("p_type") String type, @FormParam("p_no") int no ) throws Exception {
		type = StringUtils.defaultString(type,"");
		String displayName = "";
		String realName = "";
		
		ResponseBuilder response = null;
		if ( type.equals("") ) {
			response = Response.status(404);
		} else {
			
            try {
            	dbInit();
                StringBuffer sql = new StringBuffer();
                sql.setLength(0);
                sql.append(
                  " SELECT"
      	                + " a.NO         NO     ,"
      	                + " a.REAL_ATT_FILE      REAL_ATT_FILE,   "
      	                + " a.DISPLAY_ATT_FILE   DISPLAY_ATT_FILE   "
    	                + " FROM " + TABLE.TBL_DMS_BOARD_NOTICE + " a "
    	                + " WHERE a.NO = ?"
                );
//                Log.debug(sql.toString());
                pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
                pstmt.setInt(1, no);
                rs  = pstmt.executeQuery();
                while ( rs.next() ) {
                    realName    = StringUtils.defaultString(rs.getString("REAL_ATT_FILE"     ));
                    displayName = StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE"     ));
                    displayName = displayName.replaceAll("\\s", "_");
                }
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
		}
		return response.build();	
	}	
}