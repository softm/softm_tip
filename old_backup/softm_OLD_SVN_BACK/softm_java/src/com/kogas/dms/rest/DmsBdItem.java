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
import com.kogas.dms.dao.DmsBdScheduleDAO;
import com.kogas.dms.var.Constant;
import com.kogas.dms.var.UPLOAD;

@Path("dms_biz/bd_item")
public class DmsBdItem extends Base {
	public DmsBdItem(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
//		BD_ITEM_STATUS.put("1", "등록대기");
//		BD_ITEM_STATUS.put("2", "접수대기");
//		BD_ITEM_STATUS.put("3", "접수완료");
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
			@DefaultValue("0") @FormParam("s_schedule_no") int s_schedule_no
//			@DefaultValue("0") @FormParam("s_month") String s_month
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdItemDAO dao = new DmsBdItemDAO();
				 jsr.put("data", dao.schView(s_schedule_no));
				 
            	 DmsBdItemCodeDAO dao1 = new DmsBdItemCodeDAO();
				 jsr.put("data_item_devision", dao1.listCode("10")); // 구분
				 jsr.put("data_item_code2"   , dao1.listCode("20")); // 회의명
				 jsr.put("data_item_code3"   , dao1.listCode("30")); // 사업유형
				 jsr.put("data_item_code4"   , dao1.listCode("40")); // 사업상태
				 jsr.put("data_item_status"  , Constant.DMS_BD_ITEM_STATUS     ); // 상태
	                
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
	 * 의안정보
	 * @param s_year 년
	 * @param s_year 월
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("search_list")
	public JSONObject searchList(
			@DefaultValue("0") @FormParam("p_start") int p_start,
			@DefaultValue("") @FormParam("s_bd_start_day_frm") String s_bd_start_day_frm,
			@DefaultValue("") @FormParam("s_bd_start_day_to") String s_bd_start_day_to,
			@DefaultValue("") @FormParam("s_name_code") String s_name_code,
			@DefaultValue("") @FormParam("s_bd_no") String s_bd_no,
			@DefaultValue("") @FormParam("s_item_name") String s_item_name,
			@DefaultValue("") @FormParam("s_dept_code") String s_dept_code,
			@DefaultValue("") @FormParam("s_result_code") String s_result_code
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdItemDAO dao = new DmsBdItemDAO();
				 jsr = dao.searchList(p_start,
						 s_bd_start_day_frm.replaceAll("-", ""),
						 s_bd_start_day_to.replaceAll("-", ""), 
						 s_name_code,       
						 s_bd_no,           
						 s_item_name,       
						 s_dept_code,       
						 s_result_code,
						 true
				 );
				 
				 DmsBdNameCodeDAO dao2 = new DmsBdNameCodeDAO();
//				 jsr.put("data_name_code", dao2.listCode("ALL"));
				 jsr.put("data_name_code", dao2.listCode("'20','90'"));
				 
				 DmsBdItemResultCodeDAO dao3 = new DmsBdItemResultCodeDAO();
//				 jsr.put("data_name_code", dao2.listCode("ALL"));
				 jsr.put("data_result_code", dao3.listCode());
				 
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
	 * 의안정보
	 * @param s_year 년
	 * @param s_year 월
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("text/html")
	@Path("search_list_excel")
	public Response searchListExcel(
			@DefaultValue("0") @FormParam("p_start") int p_start,
			@DefaultValue("") @FormParam("s_bd_start_day_frm") String s_bd_start_day_frm,
			@DefaultValue("") @FormParam("s_bd_start_day_to") String s_bd_start_day_to,
			@DefaultValue("") @FormParam("s_name_code") String s_name_code,
			@DefaultValue("") @FormParam("s_bd_no") String s_bd_no,
			@DefaultValue("") @FormParam("s_item_name") String s_item_name,
			@DefaultValue("") @FormParam("s_dept_code") String s_dept_code,
			@DefaultValue("") @FormParam("s_result_code") String s_result_code
	) 	throws Exception {
		ResponseBuilder response = null;
		if ( loginInfo.loginYn.equals("N") ) {
			response = Response.status(404);
        } else {
            try {
				 DBUtil.init();
				 DmsBdItemDAO dao = new DmsBdItemDAO();
				 JSONObject jsr = new JSONObject();
				 
				 jsr = dao.searchList(p_start,
						 s_bd_start_day_frm.replaceAll("-", ""),
						 s_bd_start_day_to.replaceAll("-", ""), 
						 s_name_code,       
						 s_bd_no,           
						 s_item_name,       
						 s_dept_code,       
						 s_result_code,
						 false
				 );
					JSONArray jsa = (JSONArray) jsr.get("data");
					
					Workbook wb = new HSSFWorkbook();
					Sheet sheet = wb.createSheet("sheet1");
					ArrayList<String> Header = new ArrayList<String>(); //헤더생성
					Header.add("회차");       
					Header.add("제안일");     
					Header.add("의안번호");   
					Header.add("의안명");     
					Header.add("제안부서");   
					Header.add("의결결과");   
					Header.add("조회수");	
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
					   for(int k=0;k<7;k++){
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
					   	for(int j=0; j<7; j++){
							Cell c = tdRow.createCell(j);
							String v = "";
					       	if(j==0) {
					       		v = (String) row.get("bd_no");					       		
					       	} else if(j==1) {
					       		String bdSDay = (String) row.get("bd_start_day");
					       		v = bdSDay.substring(0,4) + "-" + bdSDay.substring(4,6) + "-" + bdSDay.substring(6,8);
					       	} else if(j==2) {
					       		v = (String) row.get("col");
					       	} else if(j==3) {
					       		v = (String) row.get("item_name");
					       	} else if(j==4) {
					       		v = (String) row.get("dept_code");
					       	} else if(j==5) {
					       		v = (String) row.get("result_name");
					       	} else if(j==6) {
					       		v = (String) row.get("read_count");
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
	public Response download(@FormParam("p_type") String type, @DefaultValue("0") @FormParam("p_item_no") int p_item_no ) throws Exception {
		type = StringUtils.defaultString(type,"");
		String displayName = "";
		String realName = "";
		
		ResponseBuilder response = null;
		if ( p_item_no == 0 ) {
			response = Response.status(404);
		} else {
			
            try {
				DBUtil.init();
				DmsBdItemDAO dao = new DmsBdItemDAO();
				JSONObject jsr = dao.view(p_item_no);
               
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
	    			File file = new File(UPLOAD.UPLOAD_BD_ITEM+ File.separator + realName);
	    			response = Response.ok((Object) file);
	    			response.header("Content-Disposition","attachment; filename="+Util.getFileNameByBrowser(displayName, Util.getBrowser(request)));
                } else {
        			response = Response.status(404);
                }
            }
		}
		return response.build();	
	}	
	/**
	 * 회의리스트
	 * @param s_year 년
	 * @param s_year 월
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("sch_list")
	public JSONObject schList(
			@DefaultValue("0") @FormParam("p_start") int p_start,
			@DefaultValue("0") @FormParam("p_how_many") int p_how_many
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
				 DBUtil.init();
				 DmsBdScheduleDAO dao = new DmsBdScheduleDAO();
				 jsr = dao.listPaging(p_start,p_how_many);
				 
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
			@DefaultValue("0") @FormParam("s_item_no") int s_item_no
	) 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            try {
				DBUtil.init();
				DmsBdItemDAO dao = new DmsBdItemDAO();
				String sesReadCount = getSession ( "bd_item_read_count" );
				Log.info("sesReadCount : " + sesReadCount);
				if ( sesReadCount.indexOf("#" + s_item_no + "#") == -1 ) {
					setSession ( "bd_item_read_count", sesReadCount + "#" + s_item_no + "#");
					dao.updateReadCount(s_item_no);					
				}
				
				JSONObject item = dao.view(s_item_no);
				DmsBdItemCodeDAO dao1 = new DmsBdItemCodeDAO();				 
				item.put("item_devision_name", dao1.getName("10",item.getString("item_devision")));
				item.put("item_code2_name", dao1.getName("20",item.getString("item_code2")));
				item.put("item_code3_name", dao1.getName("30",item.getString("item_code3")));
				item.put("item_code4_name", dao1.getName("40",item.getString("item_code4")));
				jsr.put("data", item );
				
				jsr.put("status_name"       , Constant.DMS_BD_ITEM_STATUS.getString(item.getString("status"))); // 처리상태명
				
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
	 * 수정데이터 조회
	 * @param s_item_no 번호
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("application/json")
	@Consumes("application/x-www-form-urlencoded")
	@Path("get_update")
	public JSONObject getUpdate(
			@DefaultValue("0") @FormParam("s_item_no") int s_item_no
	) 	throws Exception {
	    JSONObject jsr = new JSONObject();
	    if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
	    } else {
	        try {
				DBUtil.init();
				DmsBdItemDAO dao = new DmsBdItemDAO();
				JSONObject item = dao.view(s_item_no);
				jsr.put("data", item );	
				
	        	DmsBdItemCodeDAO dao1 = new DmsBdItemCodeDAO();
				jsr.put("data_item_devision", dao1.listCode("10")); // 구분
				jsr.put("data_item_code2"   , dao1.listCode("20")); // 회의명
				jsr.put("data_item_code3"   , dao1.listCode("30")); // 사업유형
				jsr.put("data_item_code4"   , dao1.listCode("40")); // 사업상태
				
				jsr.put("status_name"       , Constant.DMS_BD_ITEM_STATUS.getString(item.getString("status"))); // 처리상태명
				 
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
     * @param req
     * @return
     * @throws Exception
     */
    @POST
    @Produces("text/html")
    @Path("write")
    public String write(@Context HttpServletRequest req) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
             jsr.put("return" , "404"); // 로그인되있지 않음
             jsr.put("message" , "권한이 없습니다."); // error message
        } else {
            String p_mode   = "";
            try {
                DBUtil.init();
                if (ServletFileUpload.isMultipartContent(req)) {
                    int    p_item_no       = 0;
                    int    p_schedule_no   = 0;
                    int    col             = 0;
                    String item_devision   = "";
                    String item_code2      = "";
                    String item_code3      = "";
                    String item_code4      = "";
                    String item_name       = "";
                    String approval_request= "";
                    String dept_code       = "";
                    String coast_center    = "";
                    String funds_dept      = "";
                    String avaiable_budget = "";
                    String budget_amount   = "";
                    String reference       = "";
                    String is_result       = "";
                    String cre_user        = loginInfo.empNm;
                    String cre_date        = "";
                    String read_count      = "0";
                    String real_att_file   = "";
                    String display_att_file= "";
                    String status          = "1";

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
                                if      ( "p_mode".equals                       (fElementName) ) p_mode             = value;
                                else if ( "p_item_no".equals                    (fElementName) ) p_item_no          = Integer.parseInt(value);
                                else if ( "p_schedule_no".equals                (fElementName) ) p_schedule_no      = Integer.parseInt(value.equals("")?"0":value);
//                                else if ( "col".equals                          (fElementName) ) col                = value;
                                else if ( "item_devision".equals                (fElementName) ) item_devision      = value;
                                else if ( "item_code2".equals                   (fElementName) ) item_code2         = value;
                                else if ( "item_code3".equals                   (fElementName) ) item_code3         = value;
                                else if ( "item_code4".equals                   (fElementName) ) item_code4         = value;
                                else if ( "item_name".equals                    (fElementName) ) item_name          = value;
                                else if ( "approval_request".equals             (fElementName) ) approval_request   = value;
                                else if ( "dept_code".equals                    (fElementName) ) dept_code          = value;
                                else if ( "coast_center".equals                 (fElementName) ) coast_center       = value;
                                else if ( "funds_dept".equals                   (fElementName) ) funds_dept         = value;
                                else if ( "avaiable_budget".equals              (fElementName) ) avaiable_budget    = value;
                                else if ( "budget_amount".equals                (fElementName) ) budget_amount      = value;
                                else if ( "reference".equals                    (fElementName) ) reference          = value;
                                else if ( "is_result".equals                    (fElementName) ) is_result          = value;
                                else if ( "cre_user".equals                     (fElementName) ) cre_user           = value;
                                else if ( "cre_date".equals                     (fElementName) ) cre_date           = value;
                                else if ( "read_count".equals                   (fElementName) ) read_count         = value;
                                else if ( "real_att_file".equals                (fElementName) ) real_att_file      = value;
                                else if ( "display_att_file".equals             (fElementName) ) display_att_file   = value;
                                else if ( "status".equals                       (fElementName) ) status             = value;
                                else if ( "delete_yn_att_file".equals           (fElementName) ) delete_yn_att_file = value;
                            }
                        }

                        if ( item_devision.equals("") ) throw new Exception("정보가 부족합니다.");

                        for (FileItem item : items) {
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
                                        vo = dao.getFileInfo(p_item_no);
                                        real_att_file    = vo.getString("real_att_file");
                                        display_att_file = vo.getString("display_att_file");
                                    }

                                    if ( isupfile_att_file || delete_yn_att_file.equals("Y") ) {
                                        String attFile = UPLOAD.UPLOAD_BD_ITEM + File.separator + real_att_file;
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
                                            item.write(new File(UPLOAD.UPLOAD_BD_ITEM + File.separator + real_att_file));
                                        } catch (Exception e) {
                                            e.printStackTrace();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    DmsBdItemDAO dao = new DmsBdItemDAO();
                    JSONObject       vo  = new JSONObject();
//                       vo.put("BD_NO"       ,dao.getMaxBdNo(gubun_code,name_code));
                     vo.put("SCHEDULE_NO"     ,p_schedule_no   );
//                     vo.put("COL"             ,dao.getMaxCol() );
                     vo.put("COL"             ,0               );
                     vo.put("ITEM_DEVISION"   ,item_devision   );
                     vo.put("ITEM_CODE2"      ,item_code2      );
                     vo.put("ITEM_CODE3"      ,item_code3      );
                     vo.put("ITEM_CODE4"      ,item_code4      );
                     vo.put("ITEM_NAME"       ,item_name       );
                     vo.put("APPROVAL_REQUEST",approval_request);
                     vo.put("DEPT_CODE"       ,dept_code       );
                     vo.put("COAST_CENTER"    ,coast_center    );
                     vo.put("FUNDS_DEPT"      ,funds_dept      );
                     vo.put("AVAIABLE_BUDGET" ,avaiable_budget );
                     vo.put("BUDGET_AMOUNT"   ,budget_amount   );
                     vo.put("REFERENCE"       ,reference       );
                     vo.put("IS_RESULT"       ,is_result       );
                     vo.put("CRE_USER"        ,cre_user        );
                     vo.put("CRE_DATE"        ,cre_date        );
                     vo.put("READ_COUNT"      ,read_count      );
                     vo.put("REAL_ATT_FILE"   ,real_att_file   );
                     vo.put("DISPLAY_ATT_FILE",display_att_file);
                     vo.put("STATUS"          ,status          );
                     vo.put("ITEM_NO"         ,p_item_no       ); // key

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
	 * @param p_schedule_no
	 * @return
	 * @throws Exception
	 */
	@POST
	@Produces("text/html")
	@Consumes(MediaType.APPLICATION_FORM_URLENCODED)
	@Path("delete")
	public String delete(
			@FormParam("chk_item"  ) List<String> item_nos,
			@DefaultValue("0") @FormParam("p_item_no"  ) int p_item_no,
			@DefaultValue("") @FormParam("p_mode"  ) String p_mode
   ) throws Exception {
		JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "권한이 없습니다."); // error message
        } else {		
			 try {
				 if ( p_mode.equals("") ) throw new Exception("정보가 부족합니다.");
				 DBUtil.init();
				 if ( p_mode.equals("M") ) {
					 String itemNos = StringUtils.join(item_nos.toArray(),"#"); 
					 System.out.println("itemNos : " + itemNos);
					 DmsBdItemDAO dao = new DmsBdItemDAO();
					 
					 DBUtil.getConnection().setAutoCommit(false);
	                 JSONArray jsa = dao.gets(itemNos);					 
					 if ( dao.deletes(itemNos) ) {
		                 jsr.put("return" , "200"); // 성공
		                 jsr.put("message" , "삭제되었습니다."); // error message
		                 for (int i = 0; i < jsa.length(); i++) {
		                	 JSONObject jso = jsa.getJSONObject(i);
                             String attFile = UPLOAD.UPLOAD_BD_ITEM + File.separator + jso.getString("real_att_file");
                             if ( Util.isFileExists (attFile) ) Util.fileDelete (attFile);
                             Log.info("file Delete :" + attFile);
		                 }

		 			 } else {
		  				throw new Exception("삭제중 에러가 발생하였습니다."); 				 
					 }
				 } else {
					 DmsBdItemDAO dao = new DmsBdItemDAO();
					 
					 DBUtil.getConnection().setAutoCommit(false);
					 JSONObject jsoFile = dao.view(p_item_no);	
					 JSONObject       vo  = new JSONObject();
					 vo.put("ITEM_NO"  ,p_item_no  );				 
					 if ( dao.delete(vo) ) {
		                 jsr.put("return" , "200"); // 성공
		                 jsr.put("message" , "삭제되었습니다."); // error message
		                 
                         String attFile = UPLOAD.UPLOAD_BD_ITEM + File.separator + jsoFile.getString("real_att_file");
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
			@DefaultValue("0") @FormParam("p_status"  ) String p_status,			
			@DefaultValue("") @FormParam("p_return_reaseon"  ) String p_return_reaseon,			
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
				String itemNos = StringUtils.join(item_no.toArray(),"#"); 
				System.out.println("itemNos : " + itemNos);
				DmsBdItemDAO dao = new DmsBdItemDAO();
				
				DBUtil.getConnection().setAutoCommit(false);
				JSONArray jsa = dao.gets(itemNos);					 
				if ( dao.updateStatus(itemNos,p_status,p_return_reaseon) ) {
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
	 * 아이템구분코드
	 * @return 조회데이터
	 */
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("get_item_code")
	public JSONObject getItemCode() 	throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
			 jsr.put("return" , "404"); // 로그인되있지 않음
			 jsr.put("message" , "접근권한이 없습니다."); // error message
        } else {
            try {
            	dbInit();
            	DmsBdItemCodeDAO dao1 = new DmsBdItemCodeDAO();
				jsr.put("data_item_devision", dao1.listCode("10")); // 구분
				jsr.put("data_item_code2"   , dao1.listCode("20")); // 회의명
				jsr.put("data_item_code3"   , dao1.listCode("30")); // 사업유형
				jsr.put("data_item_code4"   , dao1.listCode("40")); // 사업상태
				 
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

}