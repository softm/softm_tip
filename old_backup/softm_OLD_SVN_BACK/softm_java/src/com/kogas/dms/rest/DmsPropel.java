/**
 * 안건등록
 * @version : 1.0
 * @author  : kim ji hun (softm@nate.com)
 */
package com.kogas.dms.rest;

import java.io.File;
import java.io.FileOutputStream;
import java.sql.SQLException;
import java.util.ArrayList;
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
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import javax.ws.rs.core.Response.ResponseBuilder;

import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.FileItemFactory;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;
import org.apache.commons.lang3.StringUtils;
import org.apache.poi.hssf.usermodel.HSSFCellStyle;
import org.apache.poi.hssf.usermodel.HSSFRow;
import org.apache.poi.hssf.usermodel.HSSFWorkbook;
import org.apache.poi.hssf.util.HSSFColor;
import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.ss.usermodel.Header;
import org.apache.poi.ss.usermodel.Row;
import org.apache.poi.ss.usermodel.Sheet;
import org.apache.poi.ss.usermodel.Workbook;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.Base;
import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;
import com.kogas.dms.dao.DmsBdGubunCodeDAO;
import com.kogas.dms.dao.DmsBdItemCodeDAO;
import com.kogas.dms.dao.DmsBdItemDAO;
import com.kogas.dms.dao.DmsBdItemResultCodeDAO;
import com.kogas.dms.dao.DmsBdNameCodeDAO;
import com.kogas.dms.dao.DmsBdRequestDAO;
import com.kogas.dms.dao.DmsBdScheduleDAO;
import com.kogas.dms.var.Constant;
import com.kogas.dms.var.UPLOAD;

@Path("dms_biz/bd_request2")
public class DmsPropel extends Base {
	public DmsPropel(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
	}
	
	/**
	 * 추진현황
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("search_list")
	public JSONObject searchList(
			@DefaultValue("0") @FormParam("p_start") int p_start,
			@DefaultValue("") @FormParam("s_wriet_date_frm") String s_wriet_date_frm,
			@DefaultValue("") @FormParam("s_wriet_date_to") String s_wriet_date_to,
			@DefaultValue("") @FormParam("s_charge_user") String s_charge_user,
			@DefaultValue("") @FormParam("s_title") String s_title,
			@DefaultValue("") @FormParam("s_status") String s_status,
			@DefaultValue("") @FormParam("s_req_gubun") String s_req_gubun,
			@DefaultValue("") @FormParam("s_dept_id") String s_dept_id
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdRequestDAO dao = new DmsBdRequestDAO();
				 jsr = dao.searchList(p_start,
						 s_wriet_date_frm.replaceAll("-", ""),
						 s_wriet_date_to.replaceAll("-", ""),
						 s_charge_user ,
						 s_title       ,
						 s_status      ,
						 s_req_gubun   ,
						 s_dept_id     ,  
						 true
				 );
				 jsr.put("data_status"   ,  Constant.DMS_BD_REQUEST_STATUS   );
				 jsr.put("data_req_gubun",  Constant.DMS_BD_REQUEST_REQ_GUBUN);
				 
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
	 * 추진현황 엑셀 - 미완성
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("text/html")
	@Path("search_list_excel")
	public Response searchListExcel(
		@DefaultValue("0") @FormParam("p_start") int p_start,
		@DefaultValue("") @FormParam("s_wriet_date_frm") String s_wriet_date_frm,
		@DefaultValue("") @FormParam("s_wriet_date_to") String s_wriet_date_to,
		@DefaultValue("") @FormParam("s_charge_user") String s_charge_user,
		@DefaultValue("") @FormParam("s_title") String s_title,
		@DefaultValue("") @FormParam("s_status") String s_status,
		@DefaultValue("") @FormParam("s_req_gubun") String s_req_gubun,
		@DefaultValue("") @FormParam("s_dept_id") String s_dept_id
	) 	throws Exception {
		ResponseBuilder response = null;
		if ( loginInfo.loginYn.equals("N") ) {
			response = Response.status(404);
        } else {
            try {
				 DBUtil.init();
				 DmsBdRequestDAO dao = new DmsBdRequestDAO();
				 JSONObject jsr = new JSONObject();
				 jsr = dao.searchList(p_start,
						 s_wriet_date_frm.replaceAll("-", ""),
						 s_wriet_date_to.replaceAll("-", ""),
						 s_charge_user ,
						 s_title       ,
						 s_status      ,
						 s_req_gubun   ,
						 s_dept_id     ,  
						 true
				 );
					JSONArray jsa = (JSONArray) jsr.get("data");
					
					Workbook wb = new HSSFWorkbook();
					Sheet sheet = wb.createSheet("sheet1");
					ArrayList<String> Header = new ArrayList<String>(); //헤더생성
					Header.add("답변유형");       
					Header.add("이사명");     
					Header.add("제목");   
					Header.add("등록일");     
					Header.add("제출마감일");   
					Header.add("작성자");   
					Header.add("담당부서");	
					Header.add("처리상태");	
					//header style
				   HSSFCellStyle Hstyle = (HSSFCellStyle) wb.createCellStyle();
				   Hstyle.setFillForegroundColor(HSSFColor.GREY_25_PERCENT.index); //헤더 배경색
				   Hstyle.setFillPattern(HSSFCellStyle.SOLID_FOREGROUND); //채움
				   Hstyle.setBorderBottom(HSSFCellStyle.BORDER_THIN);
				   Hstyle.setBottomBorderColor(HSSFColor.BLACK.index);
				   Hstyle.setBorderLeft(HSSFCellStyle.BORDER_THIN);
				   Hstyle.setBottomBorderColor(HSSFColor.BLACK.index);
				   Hstyle.setBorderRight(HSSFCellStyle.BORDER_THIN);
				   Hstyle.setBottomBorderColor(HSSFColor.BLACK.index);
				   Hstyle.setBorderTop(HSSFCellStyle.BORDER_THIN);
				   Hstyle.setBottomBorderColor(HSSFColor.BLACK.index);
				   HSSFRow thRow = (HSSFRow) sheet.createRow((short)0);
				   
					   //header 내용 및 style 적용
					   for(int k=0;k<Header.size();k++){
					       Cell headerCell = thRow.createCell(k);
					       headerCell.setCellValue(Header.get(k));
					       headerCell.setCellStyle(Hstyle);
					   }
					   //content style - 셀 라인 그리기

					   HSSFCellStyle Cstyle = (HSSFCellStyle) wb.createCellStyle();
					   Cstyle.setBorderBottom(HSSFCellStyle.BORDER_THIN);
					   Cstyle.setBottomBorderColor(HSSFColor.BLACK.index);
					   Cstyle.setBorderLeft(HSSFCellStyle.BORDER_THIN);
					   Cstyle.setBottomBorderColor(HSSFColor.BLACK.index);
					   Cstyle.setBorderRight(HSSFCellStyle.BORDER_THIN);
					   Cstyle.setBottomBorderColor(HSSFColor.BLACK.index);
					   Cstyle.setBorderTop(HSSFCellStyle.BORDER_THIN);
					   Cstyle.setBottomBorderColor(HSSFColor.BLACK.index);
					   
					for(int i=0;i<jsa.length();i++) {
						System.out.println(jsa);
						JSONObject row = (JSONObject) jsa.get(i);
						Row tdRow = sheet.createRow(i+1);
					   	for(int j=0; j<Header.size(); j++){
							Cell c = tdRow.createCell(j);
							String v = "";
					       	if(j==0) {
					       		String reqGubun = StringUtils.defaultString((String) row.get("req_gubun"), "");
					       		v = !reqGubun.equals("")?(String) Constant.DMS_BD_REQUEST_REQ_GUBUN.getString(reqGubun):"-";					       		
					       	} else if(j==1) {
					       		v = (String) row.get("ko_name");
					       	} else if(j==2) {
					       		v = (String) row.get("title");
					       	} else if(j==3) {
					       		String wDate = (String) row.get("wriet_date");
					       		v = wDate.substring(0,4) + "-" + wDate.substring(4,6) + "-" + wDate.substring(6,8);
					       	} else if(j==4) {
					       		String eDate = (String) row.get("end_date");
					       		v = eDate.substring(0,4) + "-" + eDate.substring(4,6) + "-" + eDate.substring(6,8);
					       	} else if(j==5) {
					       		v = (String) row.get("charge_user");
					       	} else if(j==6) {
					       		v = (String) row.get("dept_id");
					       	} else if(j==7) {
					       		String status = StringUtils.defaultString((String) row.get("status"), "");
					       		v = !status.equals("")?(String) Constant.DMS_BD_REQUEST_STATUS.getString(status):"-";					       		
					       	}
							c.setCellValue(v);
							c.setCellStyle(Cstyle);							
					   	}
					}
					String fileName = "의안정보_" + Util.getDateFormatString("yyyy-MM-dd_HH_mm_ss") + ".xls";
					FileOutputStream file = new FileOutputStream(UPLOAD.UPLOAD_TMP + File.separator + fileName);
					wb.write(file);
					file.close();
					response = Response.ok((Object) new File(UPLOAD.UPLOAD_TMP + File.separator + fileName));
					response.header("Content-Type","application/vnd.ms-excel");
					response.header("Content-Disposition","attachment; filename="+Util.getFileNameByBrowser(fileName, Util.getBrowser(request)));
					
            } catch ( SQLException e) {
	   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	   			 e.printStackTrace();
            } finally {
				 DBUtil.end();
            }
        }
		return response.build();	
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
			@DefaultValue("0") @FormParam("s_req_no") int s_req_no
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
				DBUtil.init();
				DmsBdRequestDAO dao = new DmsBdRequestDAO();
				JSONObject item = dao.view(s_req_no);
				jsr.put("data", item );
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
	 * 추진현황 작성 - 상세 조회
	 * @param p_no 게시물번호
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("get_detail")
	public JSONObject getDetail(
			@DefaultValue("0") @FormParam("s_req_no") int s_req_no
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
				DBUtil.init();
				DmsBdRequestDAO dao = new DmsBdRequestDAO();
				JSONObject item = dao.view(s_req_no);
				
				String reqGubun = StringUtils.defaultString(item.getString("req_gubun"),"");
				if ( !reqGubun.equals("") ) 
					item.put("req_gubun_name" , Constant.DMS_BD_REQUEST_REQ_GUBUN.getString(reqGubun));
				
				String status = StringUtils.defaultString(item.getString("status"),"");
				if ( !status.equals("") ) 
					item.put("status_name" , Constant.DMS_BD_REQUEST_STATUS.getString(status));
				
				jsr.put("data", item );
				// 안건자료
				DmsBdItemDAO daoBdItem = new DmsBdItemDAO();
				JSONObject bdItem = daoBdItem.view(Integer.valueOf((String)item.getString("item_no")));
				jsr.put("data_item", bdItem );
				
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
     * 저장 - 관리자(담당자)
     * @param req
     * @return
     * @throws Exception
     */
    @POST
    @Produces("text/html")
    @Path("write")
    public String write(@Context HttpServletRequest req) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.adminYn.equals("N") ) {
             jsr.put("return" , "404"); // 로그인되있지 않음
             jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            String p_mode   = "";
            try {
                DBUtil.init();
                if (ServletFileUpload.isMultipartContent(req)) {
                    int    p_req_no        = 0;
                    int    item_no         = 0;
                    String member_no       = loginInfo.empNo;
                    String wriet_date      = "";
                    String end_date        = "";
                    String dept_id         = "";
                    String req_context     = "";
                    String req_gubun       = "";
                    String charge_user     = loginInfo.empNm;
                    String ans_context     = "";
                    String status          = "";
                    String real_att_file   = "";
                    String display_att_file= "";
                    String title           = "";

                    boolean isupfile_att_file = false;
                    String delete_yn_att_file = "";
                    FileItemFactory factory = new DiskFileItemFactory();
                    ServletFileUpload upload = new ServletFileUpload(factory);
//                      upload.setHeaderEncoding("UTF-8");
                    List<FileItem> items = upload.parseRequest(req);
                    if (items != null) {
                        for (FileItem item : items) {
                            if (item.isFormField()) {
                                String fElementName = item.getFieldName();
                                String value = item.getString("UTF-8");
                                System.out.println("Got a form field: " + fElementName  + " " +value);
                                if      ( "p_mode".equals           (fElementName) ) p_mode             = value;
                                else if ( "p_req_no".equals         (fElementName) ) p_req_no           = Integer.parseInt(value);
                                else if ( "item_no".equals          (fElementName) ) item_no            = Integer.parseInt(value.equals("")?"0":value);
//                                else if ( "member_no".equals        (fElementName) ) member_no          = value;
                                else if ( "wriet_date".equals       (fElementName) ) wriet_date         = value.replaceAll("-", "");
                                else if ( "end_date".equals         (fElementName) ) end_date           = value.replaceAll("-", "");
                                else if ( "dept_id".equals          (fElementName) ) dept_id            = value;
                                else if ( "req_context".equals      (fElementName) ) req_context        = value;
                                else if ( "req_gubun".equals        (fElementName) ) req_gubun          = value;
//                                else if ( "charge_user".equals      (fElementName) ) charge_user        = value;
                                else if ( "ans_context".equals      (fElementName) ) ans_context        = value;
                                else if ( "status".equals           (fElementName) ) status             = p_mode.equals("I")?"0":value; // I : 요청대기(0)
                                else if ( "real_att_file".equals    (fElementName) ) real_att_file      = value;
                                else if ( "display_att_file".equals (fElementName) ) display_att_file   = value;
                                else if ( "title".equals            (fElementName) ) title              = value;
                            }
                        }

                        if ( item_no == 0 ) throw new Exception("정보가 부족합니다.");

/*                        for (FileItem item : items) {
                            if (!item.isFormField()) {
                                boolean isupdate_att_file = false;                            	
                                String fElementName = item.getFieldName();
                                System.out.println("Got a form field: " + fElementName );
                                if ( "att_file".equals(fElementName) ) {
                                    if ( item.getSize() > 0 ) isupfile_att_file = true;
                                    // 파일 삭제
                                    if ( p_mode.equals("U") ) {
                                        DmsBdItemDAO dao = new DmsBdItemDAO();
                                        JSONObject       vo  = new JSONObject();
                                        vo = dao.getFileInfo(item_no);
                                        real_att_file    = vo.getString("real_att_file");
                                        display_att_file = vo.getString("display_att_file");
                                    }

                                    if ( isupfile_att_file || delete_yn_att_file.equals("Y") ) {
                                        String attFile = UPLOAD.UPLOAD_BD_REQUEST + File.separator + real_att_file;
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
                                        real_att_file    = Util.rPadding(Util.getDateFormatString("yyyyMMddHHmmssS"), 17, "0") + (extraName.equals("")?"":"."+extraName);
                                        isupdate_att_file = true;
                                        try {
                                            item.write(new File(UPLOAD.UPLOAD_BD_REQUEST + File.separator + real_att_file));
                                        } catch (Exception e) {
                                            e.printStackTrace();
                                        }
                                    }
                                }
                            }
                        }
*/                    }
                    DmsBdRequestDAO  dao = new DmsBdRequestDAO();
                    JSONObject       vo  = new JSONObject();
//                       vo.put("BD_NO"       ,dao.getMaxBdNo(gubun_code,name_code));
                     vo.put("ITEM_NO"              ,item_no          );
                     vo.put("MEMBER_NO"            ,member_no        );
                     vo.put("WRIET_DATE"           ,wriet_date       );
                     vo.put("END_DATE"             ,end_date         );
                     vo.put("DEPT_ID"              ,dept_id          );
                     vo.put("REQ_CONTEXT"          ,req_context      );
                     vo.put("REQ_GUBUN"            ,req_gubun        );
                     vo.put("CHARGE_USER"          ,charge_user      );
                     vo.put("ANS_CONTEXT"          ,ans_context      );
                     vo.put("REAL_ATT_FILE"        ,real_att_file    );
                     vo.put("DISPLAY_ATT_FILE"     ,display_att_file );
                     vo.put("TITLE"                ,title            );
                     vo.put("REQ_NO"               ,p_req_no         ); // key

                     if ( p_mode.equals("I") ) {
                         vo.put("STATUS"               ,"0"); // 등록대기 : Constant.DMS_BD_REQUEST_STATUS                    	 
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
                            throw new Exception("수정중 에러가 발생하였습니다.");
                         }
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
	
	private String processFileName(String fileNameInput) {
		String fileNameOutput = null;
		fileNameOutput = fileNameInput.substring(
				fileNameInput.lastIndexOf("\\") + 1, fileNameInput.length());
		return fileNameOutput;
	}
	
	/**
	 * 삭제
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("text/html")
	@Consumes(MediaType.APPLICATION_FORM_URLENCODED)
	@Path("delete")
	public String delete(
			@FormParam("chk_item"  ) List<String> req_nos,
			@DefaultValue("0") @FormParam("p_req_no"  ) int p_req_no,
			@DefaultValue("") @FormParam("p_mode"  ) String p_mode
   ) throws Exception {
		JSONObject jsr = new JSONObject();
        if ( loginInfo.adminYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {		
			 try {
				 if ( p_mode.equals("") || p_req_no == 0 ) throw new Exception("정보가 부족합니다.");
				 DBUtil.init();
				 if ( p_mode.equals("M") ) {
					 String reqNos = StringUtils.join(req_nos.toArray(),"#"); 
					 System.out.println("reqNos : " + req_nos);
					 DmsBdRequestDAO dao = new DmsBdRequestDAO();
					 
					 DBUtil.getConnection().setAutoCommit(false);
	                 JSONArray jsa = dao.gets(reqNos);					 
					 if ( dao.deletes(reqNos) ) {
		                 jsr.put("return" , "200"); // 성공
		                 jsr.put("message" , "삭제되었습니다."); // error message
		                 for (int i = 0; i < jsa.length(); i++) {
		                	 JSONObject jso = jsa.getJSONObject(i);
                             String attFile = UPLOAD.UPLOAD_BD_REQUEST + File.separator + jso.getString("real_att_file");
                             if ( Util.isFileExists (attFile) ) Util.fileDelete (attFile);
                             Log.info("file Delete :" + attFile);
		                 }
		 			 } else {
		  				throw new Exception("삭제중 에러가 발생하였습니다."); 				 
					 }
				 } else {
					 DmsBdRequestDAO dao = new DmsBdRequestDAO();
					 
					 DBUtil.getConnection().setAutoCommit(false);
					 JSONObject jsoFile = dao.view(p_req_no);	
					 JSONObject       vo  = new JSONObject();
					 vo.put("REQ_NO"  ,p_req_no  );				 
					 if ( dao.delete(vo) ) {
		                 jsr.put("return" , "200"); // 성공
		                 jsr.put("message" , "삭제되었습니다."); // error message
                         String attFile = UPLOAD.UPLOAD_BD_REQUEST + File.separator + jsoFile.getString("real_att_file");
                         if ( Util.isFileExists (attFile) ) Util.fileDelete (attFile);
                         Log.info("file Delete :" + attFile);
		 			 } else {
		  				throw new Exception("삭제중 에러가 발생하였습니다."); 				 
					 }
				 }
			 } catch (Exception e) {
				 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
				 jsr.put("return" , "500"); // 실패
				 jsr.put("message" , e.toString()); // error message
				 e.printStackTrace();
				 DBUtil.getConnection().rollback();
			 } finally {
				 jsr.put("mode" , "D"); // 삭제
				 DBUtil.getConnection().commit();				 
				 DBUtil.end();
			 }
        }
		return jsr.toString();
	}
	/**
     * 수정 - 이사 - 요청자료 작성
     * @param req
     * @return
     * @throws Exception
     */
    @POST
    @Produces("text/html")
    @Path("update")
    public String update(@Context HttpServletRequest req) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
             jsr.put("return" , "404"); // 로그인되있지 않음
             jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            String p_mode   = "";
            try {
                DBUtil.init();
                if (ServletFileUpload.isMultipartContent(req)) {
                    int    p_req_no        = 0;
                    String req_gubun       = "";
                    String ans_context     = "";
                    String real_att_file   = "";
                    String display_att_file= "";

                    boolean isupfile_att_file = false;
                    String delete_yn_att_file = "";
                    FileItemFactory factory = new DiskFileItemFactory();
                    ServletFileUpload upload = new ServletFileUpload(factory);
//                      upload.setHeaderEncoding("UTF-8");
                    List<FileItem> items = upload.parseRequest(req);
                    if (items != null) {
                        for (FileItem item : items) {
                            if (item.isFormField()) {
                                String fElementName = item.getFieldName();
                                String value = item.getString("UTF-8");
                                System.out.println("Got a form field: " + fElementName  + " " +value);
                                if      ( "p_mode".equals           (fElementName) ) p_mode             = value;
                                else if ( "p_req_no".equals         (fElementName) ) p_req_no           = Integer.parseInt(value);
//                                else if ( "member_no".equals        (fElementName) ) member_no          = value;
                                else if ( "req_gubun".equals        (fElementName) ) req_gubun          = value;
//                                else if ( "charge_user".equals      (fElementName) ) charge_user        = value;
                                else if ( "ans_context".equals      (fElementName) ) ans_context        = value;
                                else if ( "real_att_file".equals    (fElementName) ) real_att_file      = value;
                                else if ( "display_att_file".equals (fElementName) ) display_att_file   = value;
                                else if ( "delete_yn_att_file".equals (fElementName) ) delete_yn_att_file = value;
                            }
                        }

                        if ( p_req_no == 0 ) throw new Exception("정보가 부족합니다.");

                        for (FileItem item : items) {
                            if (!item.isFormField()) {
                                boolean isupdate_att_file = false;                            	
                                String fElementName = item.getFieldName();
                                System.out.println("Got a form field: " + fElementName );
                                if ( "att_file".equals(fElementName) ) {
                                    if ( item.getSize() > 0 ) isupfile_att_file = true;
                                    // 파일 삭제
                                    if ( p_mode.equals("U") ) {
                                    	DmsBdRequestDAO dao = new DmsBdRequestDAO();
                                        JSONObject       vo  = new JSONObject();
                                        vo = dao.getFileInfo(p_req_no);
                                        real_att_file    = vo.getString("real_att_file");
                                        display_att_file = vo.getString("display_att_file");
                                    }

                                    if ( isupfile_att_file || delete_yn_att_file.equals("Y") ) {
                                        String attFile = UPLOAD.UPLOAD_BD_REQUEST + File.separator + real_att_file;
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
                                        real_att_file    = Util.rPadding(Util.getDateFormatString("yyyyMMddHHmmssS"), 17, "0") + (extraName.equals("")?"":"."+extraName);
                                        isupdate_att_file = true;
                                        try {
                                            item.write(new File(UPLOAD.UPLOAD_BD_REQUEST + File.separator + real_att_file));
                                        } catch (Exception e) {
                                            e.printStackTrace();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    DmsBdRequestDAO  dao = new DmsBdRequestDAO();
                    JSONObject       vo  = new JSONObject();
//                       vo.put("BD_NO"       ,dao.getMaxBdNo(gubun_code,name_code));
                     vo.put("REQ_GUBUN"            ,req_gubun        );
                     vo.put("ANS_CONTEXT"          ,ans_context      );
                     vo.put("REAL_ATT_FILE"        ,real_att_file    );
                     vo.put("DISPLAY_ATT_FILE"     ,display_att_file );
                     vo.put("REQ_NO"               ,p_req_no         ); // key

                     if ( dao.updateAnswer(vo) ) {
                         jsr.put("return" , "200"); // 성공
                         jsr.put("message" , "저장되었습니다."); // error message
                     } else {
                        throw new Exception("수정중 에러가 발생하였습니다.");
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
	 * 일괄 처리상태 수정
	 * @param p_schedule_no
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("text/html")
	@Consumes(MediaType.APPLICATION_FORM_URLENCODED)
	@Path("update_status")
	public String updateStatus(
			@DefaultValue("0") @FormParam("p_req_no"  ) String p_req_no,			
			@DefaultValue("") @FormParam("p_status"  ) String p_status,			
			@FormParam("chk_item"  ) List<String> item_no
			) throws Exception {
		JSONObject jsr = new JSONObject();
		if ( loginInfo.loginYn.equals("N") ) {
			jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "권한이 없습니다."); // error message
		} else {		
			try {
				if ( p_status.equals("") ) throw new Exception("정보가 부족합니다.");
				DBUtil.init();
				DmsBdRequestDAO dao = new DmsBdRequestDAO();
				DBUtil.getConnection().setAutoCommit(false);
				if ( dao.updateStatus(p_req_no,p_status) ) {
					jsr.put("return" , "200"); // 성공
					jsr.put("message" , "처리상태가 수정되었습니다."); // error message
				} else {
					throw new Exception("처리상태 수정중 에러가 발생하였습니다."); 				 
				}
			} catch (Exception e) {
				Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
				jsr.put("return" , "500"); // 실패
				jsr.put("message" , e.toString()); // error message
				e.printStackTrace();
				DBUtil.getConnection().rollback();
			} finally {
				jsr.put("mode" , "D"); // 삭제
				DBUtil.getConnection().commit();				 
				DBUtil.end();
			}
		}
		return jsr.toString();
	}

	/**
		 * 데이터 저장
		 * @param p_type
		 * @param p_item_no 게시물번호
		 * @return String
		 */
	    // @Consumes("application/x-www-form-urlencoded")
		@POST
		@Produces("text/html")
		// @Consumes(MediaType.MULTIPART_FORM_DATA)
		// @Produces("application/json")
		@Path("download")
	//		public Response download(@QueryParam("p_file") String fileName,@QueryParam("p_file_name") String realFName) throws Exception {
		public Response download(@FormParam("p_type") String type, @DefaultValue("0") @FormParam("p_req_no") int p_req_no ) throws Exception {
			type = StringUtils.defaultString(type,"");
			String displayName = "";
			String realName = "";
			
			ResponseBuilder response = null;
			if ( p_req_no == 0 ) {
				response = Response.status(404);
			} else {
				
	            try {
					DBUtil.init();
					DmsBdRequestDAO dao = new DmsBdRequestDAO();
					JSONObject jsr = dao.view(p_req_no);
	               
	                realName    = StringUtils.defaultString(jsr.getString("real_att_file"     ));
	                displayName = StringUtils.defaultString(jsr.getString("display_att_file"     ));
	                displayName = displayName.replaceAll("\\s", "_");
	            } catch ( SQLException e) {
		   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
		   			 e.printStackTrace();
	            } finally {
					DBUtil.end();
	                if ( !realName.equals("") && !displayName.equals("") ) {
	   	   			 	Util.logger.error("download - realName :" + realName + "<BR>");
	   	   			 	Util.logger.error("download - displayName :" + displayName + "<BR>");
		    			File file = new File(UPLOAD.UPLOAD_BD_REQUEST+ File.separator + realName);
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