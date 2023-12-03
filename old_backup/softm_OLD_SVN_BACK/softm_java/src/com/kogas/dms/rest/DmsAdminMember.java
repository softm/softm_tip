package com.kogas.dms.rest;

import java.io.File;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.ws.rs.Consumes;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.FormParam;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;

import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.FileItemFactory;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;
import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.Base;
import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;

import com.kogas.dms.dao.*;
import com.kogas.dms.var.UPLOAD;

@Path("admin/member")
public class DmsAdminMember extends Base {
    @Context
    private HttpServletRequest request;
    @Context
    private HttpServletResponse response;

	public DmsAdminMember(@Context HttpServletRequest req,
			@Context HttpServletResponse res) throws Exception {
		super(req, res);
	}

	private final String UPLOAD_PATH = UPLOAD.UPLOAD_ADMIN;
	
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("bd_list")
	public JSONObject bd_list() throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();

	        	DmsMemberDAO dao = new DmsMemberDAO();
	            JSONArray list1 = dao.getList("BD", "10");
	            JSONArray list2 = dao.getList("BD", "20");
	            
            	jsr.put("list1", list1);
	            jsr.put("list2", list2);
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
	@Path("group_list")
	public JSONObject group_list() throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();

	        	DmsMemberDAO dao = new DmsMemberDAO();
	            JSONArray list1 = dao.getList("GROUP", "1000");
	            JSONArray list2 = dao.getList("GROUP", "2000");
	            JSONArray list3 = dao.getList("GROUP", "3000");

            	jsr.put("list1", list1);
	            jsr.put("list2", list2);
                jsr.put("list3", list3);
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
	@Path("order_update")
	public JSONObject order_update(
			@FormParam("bd_class") String bd_class, 
			@FormParam("nos") List<String> nos,
			@FormParam("seqs") List<String> seqs ) throws Exception {
		JSONArray jsa = new JSONArray();
		JSONObject jsr = new JSONObject();
		
		try {
			dbInit();
			String arr_no = StringUtils.join(nos.toArray(),"#");
			String arr_seq = StringUtils.join(seqs.toArray(),"#");
			String[] token_no = arr_no.toString().split(",");
			String[] token_seq = arr_seq.toString().split(",");
			List<String> list_no = new ArrayList<String>();
			List<String> list_seq = new ArrayList<String>();
			
			for (int i = 0; i < token_no.length; i++) {
				String noStr =  token_no[i];
				list_no.add(noStr);
			}
			
			for (int i = 0; i < token_seq.length; i++) {
				String seqStr =  token_seq[i];
				list_seq.add(seqStr);
			}
			
			DmsMemberDAO dao = new DmsMemberDAO();
			for(int i=0;i < list_no.size();i++) {
				int no = Integer.parseInt(list_no.get(i));
				int seq = Integer.parseInt(list_seq.get(i));
				Log.debug(i + " : bd_class="+bd_class+", no=" + no + ", seq=" + seq);
				if(!dao.updateOrder(bd_class, no, seq)) {
					jsr.put("return" , "500"); // 실패
					jsr.put("message" , "입력중 에러가 발생하였습니다."); // error message
					return jsr;
				}
			}
			jsr.put("return" , "200"); // 성공
            jsr.put("message" , "저장되었습니다."); // error message
		} catch ( Exception e) {
			Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
			e.printStackTrace();
		} finally {
			dbFinal();
		}
		return jsr;	
	}
	
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("get_basic")
	public JSONObject get_basic(@DefaultValue("0") @FormParam("p_member_no") int p_member_no) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
        		
        		// 코드 조회
        		DmsBdCodeDAO daoBdCode = new DmsBdCodeDAO();
        		DmsBdGroupDAO daoGroupCode = new DmsBdGroupDAO();
        		DmsEmailGroupDAO daoEmailCode = new DmsEmailGroupDAO();
        		JSONObject bd_code_list =  daoBdCode.codeList();
        		JSONObject group_code_list = daoGroupCode.codeList();
        		JSONObject mail_code_list = daoEmailCode.codeList();
            	
	        	// 이사회원 조회
	        	DmsMemberDAO member_dao = new DmsMemberDAO();
	        	jsr = member_dao.getDetail(p_member_no);
	        	
	            if(jsr != null) {
	                jsr.put("bd_code_list", bd_code_list);
	        		jsr.put("group_code_list", group_code_list);
	        		jsr.put("mail_code_list", mail_code_list);
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
	@Path("get_academic")
	public JSONObject get_academic(@DefaultValue("0") @FormParam("p_member_no") int p_member_no) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
        		
        		// 코드 조회
        		DmsBdSchoolCodeDAO schoolCode = new DmsBdSchoolCodeDAO();
        		JSONObject school_code_list =  schoolCode.codeList();
            	
	        	// 이사회원 조회
	        	DmsMemberDAO member_dao = new DmsMemberDAO();
	        	jsr = member_dao.getDetail(p_member_no);
	        	
	            if(jsr != null) {
	            	DmsMemberAcademicDAO dao = new DmsMemberAcademicDAO();
	            	JSONArray jsa = dao.getList(p_member_no);
	            	jsr.put("list_data", jsa);
	                jsr.put("school_code_list", school_code_list);
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
	@Path("get_member")
	public JSONObject get_member(@DefaultValue("0") @FormParam("p_member_no") int p_member_no) throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
        		
        		// DAO 선언
        		DmsBdCodeDAO 			code_bd_dao 	= new DmsBdCodeDAO();
        		DmsBdGroupDAO 			code_group_dao 	= new DmsBdGroupDAO();
        		DmsEmailGroupDAO 		code_email_dao 	= new DmsEmailGroupDAO();
        		DmsBdSchoolCodeDAO 		code_school_dao = new DmsBdSchoolCodeDAO();
        		DmsMemberDAO			b_dao = new DmsMemberDAO();
        		DmsMemberAcademicDAO	a_dao = new DmsMemberAcademicDAO();
        		DmsMemberCareerDAO		c_dao = new DmsMemberCareerDAO();
        		DmsMemberRewardDAO		r_dao = new DmsMemberRewardDAO();
        		
          		// 코드 조회
        		JSONObject bd_code_list 	= code_bd_dao.codeList();
        		JSONObject group_code_list 	= code_group_dao.codeList();
        		JSONObject mail_code_list 	= code_email_dao.codeList();
        		JSONArray  school_code_list = code_school_dao.schoolCodeList();
            	
	        	// 이사회원 조회
        		JSONObject b_jso = b_dao.getDetail(p_member_no);
        		JSONArray  a_jsa = a_dao.getList(p_member_no);
        		JSONArray  c_jsa = c_dao.getList(p_member_no);
        		JSONArray  r_jsa = r_dao.getList(p_member_no);

        		jsr.put("data", b_jso);
        		jsr.put("academic_list", a_jsa);
        		jsr.put("career_list", c_jsa);
        		jsr.put("reward_list", r_jsa);
        		jsr.put("group_code_list", group_code_list);
        		jsr.put("mail_code_list", mail_code_list);
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
    					JSONObject b_jso = new JSONObject();
    					JSONArray a_jsa = new JSONArray();
    					JSONArray c_jsa = new JSONArray();
    					JSONArray r_jsa = new JSONArray();
    					String p_mode = "";
        				for (FileItem item : items) {
    						if (item.isFormField()) {
    							String fElementName = item.getFieldName();
    							String value = item.getString("UTF-8");
    							System.out.println("====> Got a form field: " + fElementName  + " " +value);
    							if(fElementName.equals("academic_arr")) {
    								String[] ar_arr = Util.split ( value, "|" );
    								for(int i = 0; i < ar_arr.length; i++) {
    									String tmpStr = ar_arr[i];
    									if(tmpStr.startsWith(",")) tmpStr = tmpStr.substring(1, tmpStr.length());
    									JSONObject jso = new JSONObject();
    									String[] a_arr = Util.split ( value, "," );
    									jso.put("academic_display_yn", a_arr[0]);
    									jso.put("school_start", a_arr[1]);
    									jso.put("school_end", a_arr[2]);
    									jso.put("school_name", a_arr[3]);
    									jso.put("school_department", a_arr[4]);
    									jso.put("school_location", a_arr[5]);
    									jso.put("school_code", a_arr[6]);
    									a_jsa.put(jso);
    								}
    								
    							}
    							if(fElementName.equals("career_arr")) {
    								String[] ar_arr = Util.split ( value, "|" );
    								for(int i = 0; i < ar_arr.length; i++) {
    									String tmpStr = ar_arr[i];
    									if(tmpStr.startsWith(",")) tmpStr = tmpStr.substring(1, tmpStr.length());
    									JSONObject jso = new JSONObject();
    									String[] a_arr = Util.split ( value, "," );
    									jso.put("career_display_yn", a_arr[0]);
    									jso.put("job_start", a_arr[1]);
    									jso.put("job_end", a_arr[2]);
    									jso.put("job_name", a_arr[3]);
    									jso.put("dept_name", a_arr[4]);
    									jso.put("position", a_arr[5]);
    									c_jsa.put(jso);
    								}
    								
    							}
    							if(fElementName.equals("reward_arr")) {
    								String[] ar_arr = Util.split ( value, "|" );
    								for(int i = 0; i < ar_arr.length; i++) {
    									String tmpStr = ar_arr[i];
    									if(tmpStr.startsWith(",")) tmpStr = tmpStr.substring(1, tmpStr.length());
    									JSONObject jso = new JSONObject();
    									String[] a_arr = Util.split ( value, "," );
    									jso.put("reward_division", a_arr[0]);
    									jso.put("reward_date", a_arr[1]);
    									jso.put("reward_context", a_arr[2]);
    									jso.put("reward_organ", a_arr[3]);
    									a_jsa.put(jso);
    								}
    							}
    							if(fElementName.equals("ch_name")) p_mode = value;
    							if(fElementName.equals("ch_name")) b_jso.put("ch_name",value);
    							if(fElementName.equals("en_name")) b_jso.put("en_name",value);
    							if(fElementName.equals("sco_no1")) b_jso.put("sco_no1",value);
    							if(fElementName.equals("sco_no2")) b_jso.put("sco_no2",value);
    							if(fElementName.equals("gender")) b_jso.put("gender",value);
    							if(fElementName.equals("place_birth")) b_jso.put("place_birth",value);
    							if(fElementName.equals("tenure_start")) b_jso.put("tenure_start",value);
    							if(fElementName.equals("tenure_end")) b_jso.put("tenure_end",value);
    							if(fElementName.equals("bd_code")) b_jso.put("bd_code",value);
    							if(fElementName.equals("bd_position")) b_jso.put("bd_position",value);
    							if(fElementName.equals("group_code")) b_jso.put("group_code",value);
    							if(fElementName.equals("group_position")) b_jso.put("group_position",value);
    							if(fElementName.equals("office_address")) b_jso.put("office_address",value);
    							if(fElementName.equals("office_phone1")) b_jso.put("office_phone1",value);
    							if(fElementName.equals("office_phone2")) b_jso.put("office_phone2",value);
    							if(fElementName.equals("office_phone3")) b_jso.put("office_phone3",value);
    							if(fElementName.equals("office_fax1")) b_jso.put("office_fax1",value);
    							if(fElementName.equals("office_fax2")) b_jso.put("office_fax2",value);
    							if(fElementName.equals("office_fax3")) b_jso.put("office_fax3",value);
    							if(fElementName.equals("textfield17")) b_jso.put("textfield17",value);
    							if(fElementName.equals("home_phone1")) b_jso.put("home_phone1",value);
    							if(fElementName.equals("home_phone2")) b_jso.put("home_phone2",value);
    							if(fElementName.equals("home_phone3")) b_jso.put("home_phone3",value);
    							if(fElementName.equals("cellphone1")) b_jso.put("cellphone1",value);
    							if(fElementName.equals("cellphone2")) b_jso.put("cellphone2",value);
    							if(fElementName.equals("cellphone2")) b_jso.put("cellphone2",value);
    							if(fElementName.equals("email1")) b_jso.put("email1",value);
    							if(fElementName.equals("email2")) b_jso.put("email2",value);
    							if(fElementName.equals("mail_code")) b_jso.put("mail_code",value);
        					} 
    					}
        				
    					for (FileItem item : items) {
    						if (!item.isFormField()) {
    							String fElementName = item.getFieldName();								
    							System.out.println("----> Got a form field: " + fElementName );
    							if ( "att_file".equals(fElementName) ) {
    								String att_file_name = processFileName(item.getName());
    								b_jso.put("member_photo", att_file_name);
   								try {
    									item.write(new File(UPLOAD_PATH + File.separator + att_file_name));
    								} catch (Exception e) {
    									e.printStackTrace();
    								}
    							}
    						}
    					}
    					DmsMemberDAO dao = new DmsMemberDAO();
    					if(!dao.writeMember(p_mode, b_jso, a_jsa, c_jsa, r_jsa)) {
    						jsr.put("return" , "500"); // 실패
    						jsr.put("message" , "입력중 에러가 발생하였습니다."); // error message
    						return jsr.toString();
    					}
    					
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
	
    private String processFileName(String fileNameInput) {
		String fileNameOutput = null;
		fileNameOutput = fileNameInput.substring(
				fileNameInput.lastIndexOf("\\") + 1, fileNameInput.length());
		return fileNameOutput;
	}
    
    
	@POST
	@Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
	@Path("member_code")
	public JSONObject get_code() throws Exception {
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
        	jsr.put("return" , "404"); // 로그인되있지 않음
			jsr.put("message" , "작성권한이 없습니다."); // error message
        } else {
        	try{
        		DBUtil.init();
        		
        		// 코드 조회
        		DmsBdCodeDAO daoBdCode = new DmsBdCodeDAO();
        		DmsBdGroupDAO daoGroupCode = new DmsBdGroupDAO();
        		DmsEmailGroupDAO daoEmailCode = new DmsEmailGroupDAO();
        		DmsBdSchoolCodeDAO daoSchoolCode = new DmsBdSchoolCodeDAO();
        		JSONObject bd_code_list =  daoBdCode.codeList();
        		JSONObject group_code_list = daoGroupCode.codeList();
        		JSONObject mail_code_list = daoEmailCode.codeList();
        		JSONArray school_code_list = daoSchoolCode.schoolCodeList();
            	
                jsr.put("bd_code_list", bd_code_list);
        		jsr.put("group_code_list", group_code_list);
        		jsr.put("mail_code_list", mail_code_list);
        		jsr.put("school_code_list", school_code_list);
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