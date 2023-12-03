package com.kogas.dms.dao;

import java.io.File;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;
import com.kogas.dms.var.UPLOAD;

public class DmsMemberDAO extends BaseDAO {

	public DmsMemberDAO() throws Exception {
		super();
	}

	protected Logger Log = Util.logger;
	private final String UPLOAD_PATH = UPLOAD.UPLOAD_ADMIN;

	public JSONArray getMemberList(String bd_class, String code) throws Exception {
		JSONArray jsa = new JSONArray();

		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT MEMBER_NO ").append("\n");
		sql.append("       ,KO_NAME ").append("\n");
		sql.append("       ,BD_POSITION ").append("\n");
		sql.append("       ,GROUP_POSITION ").append("\n");
		sql.append("       ,MEMBER_PHOTO ").append("\n");
		sql.append("       ,TO_CHAR(TO_DATE(TENURE_START,'YYYYMMDD'),'YYYY.MM.DD') TENURE_START  ").append("\n");
		sql.append("       ,TO_CHAR(TO_DATE(TENURE_END,'YYYYMMDD'),'YYYY.MM.DD') TENURE_END      ").append("\n");
		sql.append("       ,BD_CODE BD_CODE                                                     ").append("\n");
		sql.append("       ,BD_CODE_ORDER                                          ").append("\n");
		sql.append("       ,GROUP_NO                                                    ").append("\n");
		sql.append("       ,GROUP_NO_ORDER                                        ").append("\n");
		sql.append("  FROM DMS_MEMBER                                   ").append("\n");
		if(bd_class.equals("GROUP")) {
			sql.append("     WHERE GROUP_NO = ?                                                   ").append("\n");
			sql.append(" ORDER BY GROUP_NO_ORDER                                                     ").append("\n");
		} else {
			sql.append("     WHERE BD_CODE = ?                                                    ").append("\n");
			sql.append(" ORDER BY BD_CODE_ORDER                                                    ").append("\n");
		}
		
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setString(1, code);
			rs = pstmt.executeQuery();
			
			while(rs.next()){
				JSONObject jso = new JSONObject();
				int member_no = rs.getInt("MEMBER_NO");
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));   
				jso.put("ko_name", StringUtils.defaultString(rs.getString("KO_NAME")));
				jso.put("bd_position", StringUtils.defaultString(rs.getString("BD_POSITION")));
				jso.put("member_photo", StringUtils.defaultString(rs.getString("MEMBER_PHOTO")));
				jso.put("group_position", StringUtils.defaultString(rs.getString("GROUP_POSITION")));
				jso.put("tenure_start", StringUtils.defaultString(rs.getString("TENURE_START")));
				jso.put("tenure_end", StringUtils.defaultString(rs.getString("TENURE_END")));
				jso.put("bd_code_order", StringUtils.defaultString(rs.getString("BD_CODE_ORDER")));
				jso.put("group_no_order", StringUtils.defaultString(rs.getString("GROUP_NO_ORDER")));
				
				DmsMemberAcademicDAO academic_dao = new DmsMemberAcademicDAO();
				JSONArray academic_list = academic_dao.getList(member_no);
				if(academic_list != null) jso.put("academic_list",academic_list);
				DmsMemberCareerDAO career_dao = new DmsMemberCareerDAO();
				JSONArray career_list = career_dao.getList(member_no);
				if(career_list != null) jso.put("career_list",career_list);
				
				jsa.put(jso);
			}
			return jsa;
		} catch(Exception ex) {
			System.out.println("getMemberList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return null;
	}

	
	
	/**
	 * 이사회 구성원 리스트 가져오기
	 * @param gubun
	 * @param code
	 * @return
	 * @throws Exception
	 */
	public JSONArray getList(String bd_class, String code) throws Exception {
		JSONArray jsa = new JSONArray();

		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT A.MEMBER_NO MEMBER_NO                                                  ").append("\n");
		sql.append("       ,A.KO_NAME KO_NAME                                                      ").append("\n");
		sql.append("       ,A.BD_POSITION BD_POSITION                                              ").append("\n");
		sql.append("       ,A.GROUP_POSITION GROUP_POSITION                                        ").append("\n");
		sql.append("       ,TO_CHAR(TO_DATE(A.TENURE_START,'YYYYMMDD'),'YYYY.MM.DD') TENURE_START  ").append("\n");
		sql.append("       ,TO_CHAR(TO_DATE(A.TENURE_END,'YYYYMMDD'),'YYYY.MM.DD') TENURE_END      ").append("\n");
		sql.append("       ,B.SCHOOL_NAME SCHOOL_NAME                                              ").append("\n");
		sql.append("       ,B.SCHOOL_DEPARTMENT SCHOOL_DEPARTMENT                                  ").append("\n");
		sql.append("       ,A.BD_CODE BD_CODE                                                     ").append("\n");
		sql.append("       ,A.BD_CODE_ORDER BD_CODE_ORDER                                          ").append("\n");
		sql.append("       ,A.GROUP_NO GROUP_NO                                                    ").append("\n");
		sql.append("       ,A.GROUP_NO_ORDER GROUP_NO_ORDER                                        ").append("\n");
		sql.append("  FROM (                                                                       ").append("\n");
		sql.append(" 		SELECT X.*,                                                            ").append("\n");
		sql.append(" 		       (SELECT MAX(SEQ) KEEP(DENSE_RANK FIRST ORDER BY SEQ DESC)       ").append("\n");
		sql.append(" 		          FROM DMS_MEMBER_ACADEMIC WHERE MEMBER_NO = X.MEMBER_NO) SEQ  ").append("\n");
		sql.append(" 		 FROM DMS_MEMBER X                                                     ").append("\n");
		sql.append(" 		 ) A, DMS_MEMBER_ACADEMIC B                                            ").append("\n");
		sql.append("   WHERE A.SEQ = B.SEQ(+)                                                      ").append("\n");
		if(bd_class.equals("GROUP")) {
			sql.append("     AND A.GROUP_NO = ?                                                   ").append("\n");
			sql.append(" ORDER BY A.GROUP_NO_ORDER                                                     ").append("\n");
		} else {
			sql.append("     AND A.BD_CODE = ?                                                    ").append("\n");
			sql.append(" ORDER BY A.BD_CODE_ORDER                                                    ").append("\n");
		}
		
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setString(1, code);
			rs = pstmt.executeQuery();
			
			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));   
				jso.put("ko_name", StringUtils.defaultString(rs.getString("KO_NAME")));
				jso.put("bd_position", StringUtils.defaultString(rs.getString("BD_POSITION")));
				jso.put("group_position", StringUtils.defaultString(rs.getString("GROUP_POSITION")));
				jso.put("tenure_start", StringUtils.defaultString(rs.getString("TENURE_START")));
				jso.put("tenure_end", StringUtils.defaultString(rs.getString("TENURE_END")));
				jso.put("school_name", StringUtils.defaultString(rs.getString("SCHOOL_NAME")));
				jso.put("school_department", StringUtils.defaultString(rs.getString("SCHOOL_DEPARTMENT")));
				jso.put("bd_code", StringUtils.defaultString(rs.getString("BD_CODE")));
				jso.put("bd_code_order", StringUtils.defaultString(rs.getString("BD_CODE_ORDER")));
				jso.put("group_no", StringUtils.defaultString(rs.getString("GROUP_NO")));
				jso.put("group_no_order", StringUtils.defaultString(rs.getString("GROUP_NO_ORDER")));
				jsa.put(jso);
			}
			return jsa;
		} catch(Exception ex) {
			System.out.println("getMemberList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return null;
	}
	

	/**
	 * 이사회 구성원 상세 정보 가져오기
	 * @param member_no
	 * @return
	 * @throws Exception
	 */
	public JSONObject getDetail(int member_no) throws Exception {
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT MEMBER_NO ").append("\n");
		sql.append("       ,KO_NAME ").append("\n");
		sql.append("       ,CH_NAME ").append("\n");
		sql.append("       ,EN_NAME ").append("\n");
		sql.append("       ,SCO_NO1 ").append("\n");
		sql.append("       ,SCO_NO2 ").append("\n");
		sql.append("       ,GENDER ").append("\n");
		sql.append("       ,PLACE_BIRTH ").append("\n");
		sql.append("       ,TENURE_START ").append("\n");
		sql.append("       ,TENURE_END ").append("\n");
		sql.append("       ,MEMBER_PHOTO ").append("\n");
		sql.append("       ,BD_CODE ").append("\n");
		sql.append("       ,BD_CODE_ORDER ").append("\n");
		sql.append("       ,GROUP_NO ").append("\n");
		sql.append("       ,GROUP_NO_ORDER ").append("\n");
		sql.append("       ,OFFICE_ADDRESS ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(OFFICE_PHONE, '[^-]+', 1, 1) OFFICE_PHONE1 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(OFFICE_PHONE, '[^-]+', 1, 2) OFFICE_PHONE2 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(OFFICE_PHONE, '[^-]+', 1, 3) OFFICE_PHONE3 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(OFFICE_FAX, '[^-]+', 1, 1) OFFICE_FAX1 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(OFFICE_FAX, '[^-]+', 1, 2) OFFICE_FAX2 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(OFFICE_FAX, '[^-]+', 1, 3) OFFICE_FAX3 ").append("\n");
		sql.append("       ,HOME_ADDRESS ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(HOME_PHONE, '[^-]+', 1, 1) HOME_PHONE1 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(HOME_PHONE, '[^-]+', 1, 2) HOME_PHONE2 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(HOME_PHONE, '[^-]+', 1, 3) HOME_PHONE3 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(CELLPHONE, '[^-]+', 1, 1) CELLPHONE1 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(CELLPHONE, '[^-]+', 1, 2) CELLPHONE2 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(CELLPHONE, '[^-]+', 1, 3) CELLPHONE3 ").append("\n");
		sql.append("       ,EMAIL_CODE ").append("\n");
		sql.append("       ,EMAIL ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(EMAIL, '[^@]+', 1, 1) EMAIL1 ").append("\n");
		sql.append("       ,REGEXP_SUBSTR(EMAIL, '[^@]+', 1, 2) EMAIL2 ").append("\n");
		sql.append("       ,BD_POSITION ").append("\n");
		sql.append("       ,GROUP_POSITION ").append("\n");
		sql.append("  FROM DMS_MEMBER ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		Log.debug(sql.toString());
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1,member_no);
			rs = pstmt.executeQuery();

			if(rs.next()){
				jsr.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jsr.put("ko_name", StringUtils.defaultString(rs.getString("KO_NAME")));
				jsr.put("ch_name", StringUtils.defaultString(rs.getString("CH_NAME")));
				jsr.put("en_name", StringUtils.defaultString(rs.getString("EN_NAME")));
				jsr.put("sco_no1", StringUtils.defaultString(rs.getString("SCO_NO1")));
				jsr.put("sco_no2", StringUtils.defaultString(rs.getString("SCO_NO2")));
				jsr.put("gender", StringUtils.defaultString(rs.getString("GENDER")));
				jsr.put("place_birth", StringUtils.defaultString(rs.getString("PLACE_BIRTH")));
				jsr.put("tenure_start", StringUtils.defaultString(rs.getString("TENURE_START")));
				jsr.put("tenure_end", StringUtils.defaultString(rs.getString("TENURE_END")));
				String member_photo = StringUtils.defaultString(rs.getString("MEMBER_PHOTO"));
				jsr.put("member_photo", member_photo);
				String member_img = "<img src=\""+UPLOAD_PATH + File.separator + member_photo+"\">";
				jsr.put("member_img", member_img);
				jsr.put("bd_code", StringUtils.defaultString(rs.getString("BD_CODE")));
				jsr.put("bd_code_order", StringUtils.defaultString(rs.getString("BD_CODE_ORDER")));
				jsr.put("group_no", StringUtils.defaultString(rs.getString("GROUP_NO")));
				jsr.put("group_no_order", StringUtils.defaultString(rs.getString("GROUP_NO_ORDER")));
				jsr.put("office_address", StringUtils.defaultString(rs.getString("OFFICE_ADDRESS")));
				jsr.put("office_phone1", StringUtils.defaultString(rs.getString("OFFICE_PHONE1")));
				jsr.put("office_phone2", StringUtils.defaultString(rs.getString("OFFICE_PHONE2")));
				jsr.put("office_phone3", StringUtils.defaultString(rs.getString("OFFICE_PHONE3")));
				jsr.put("office_fax1", StringUtils.defaultString(rs.getString("OFFICE_FAX1")));
				jsr.put("office_fax2", StringUtils.defaultString(rs.getString("OFFICE_FAX2")));
				jsr.put("office_fax3", StringUtils.defaultString(rs.getString("OFFICE_FAX3")));
				jsr.put("home_address", StringUtils.defaultString(rs.getString("HOME_ADDRESS")));
				jsr.put("home_phone1", StringUtils.defaultString(rs.getString("HOME_PHONE1")));
				jsr.put("home_phone2", StringUtils.defaultString(rs.getString("HOME_PHONE2")));
				jsr.put("home_phone3", StringUtils.defaultString(rs.getString("HOME_PHONE3")));
				jsr.put("cellphone1", StringUtils.defaultString(rs.getString("CELLPHONE1")));
				jsr.put("cellphone2", StringUtils.defaultString(rs.getString("CELLPHONE2")));
				jsr.put("cellphone3", StringUtils.defaultString(rs.getString("CELLPHONE3")));
				jsr.put("email_code", StringUtils.defaultString(rs.getString("EMAIL_CODE")));
				jsr.put("email", StringUtils.defaultString(rs.getString("EMAIL")));
				jsr.put("email1", StringUtils.defaultString(rs.getString("EMAIL1")));
				jsr.put("email2", StringUtils.defaultString(rs.getString("EMAIL2")));
				jsr.put("bd_position", StringUtils.defaultString(rs.getString("BD_POSITION")));
				jsr.put("group_position", StringUtils.defaultString(rs.getString("GROUP_POSITION")));
			}

			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberDetail 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return null;
	}

	/**
	 * 이사회 구성원 순번
	 * @param gubun
	 * @param jsa
	 * @return
	 */
	public boolean updateOrder(String bd_class, int member_no, int seq) {
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_MEMBER ").append("\n");
		if(bd_class.equals("GROUP")) {
			sql.append(" SET GROUP_NO_ORDER = ? ").append("\n");
		} else {
			sql.append(" SET BD_CODE_ORDER = ? ").append("\n");
		}
		sql.append(" WHERE MEMBER_NO = ?  ").append("\n");
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			
			pstmt.setInt(1,seq);
			pstmt.setInt(2,member_no);
			result = pstmt.executeUpdate();

			if(result == 0) return false;
			
			return true;

		} catch(Exception ex) {
			System.out.println("updateMemberOrder 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}

	public boolean writeMember(String p_mode, JSONObject j_basic, 
			JSONArray j_academic, JSONArray j_career, JSONArray j_reward) {
		int member_no = 0;
		try {
			DmsMemberAcademicDAO a_dao = new DmsMemberAcademicDAO();
			DmsMemberCareerDAO c_dao = new DmsMemberCareerDAO();
			DmsMemberRewardDAO r_dao = new DmsMemberRewardDAO();
			if(p_mode.equals("I")) {
				// 기본정보 INSERT
				member_no = insertMember(j_basic);
				// 학력사항 INSERT
				a_dao.insertMemberAcademic(member_no, j_academic);
				// 경력사항 INSERT
				c_dao.insertMemberCareer(member_no, j_career);
				// 상벌사항 INSERT
				r_dao.insertMemberCareer(member_no, j_reward);
			} else {
				member_no = j_basic.getInt("member_no");
				// 기본정보 UPDATE
				updateMember(j_basic);
				// 학력사항 DELETE
				a_dao.deleteMemberAcademic(member_no);
				// 학력사항 INSERT
				a_dao.insertMemberAcademic(member_no, j_academic);
				// 경력사항 DELETE
				c_dao.deleteMemberCareer(member_no);
				// 경력사항 INSERT
				c_dao.insertMemberCareer(member_no, j_career);
				// 상벌사항 UPDATE
				r_dao.deleteMemberCareer(member_no);
				// 상벌사항 INSERT
				r_dao.insertMemberCareer(member_no, j_reward);
			}
		} catch(Exception ex) {
			System.out.println("writeMember 에러 : " + ex);
		} finally {
			releaseResource();
		}
		return false;
	}
	
	/**
	 * 이사회 구성원 입력
	 * @param jso
	 * @return
	 */
	public int insertMember(JSONObject jso) {
		int result = 0;
		int member_no = 0;

		StringBuffer sql = new StringBuffer();
		StringBuffer sel_sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_MEMBER(").append("\n");
		sql.append("        MEMBER_NO ,KO_NAME ,CH_NAME ,EN_NAME ").append("\n");
		sql.append("       ,SCO_NO1 ,SCO_NO2 ,GENDER ,PLACE_BIRTH ").append("\n");
		sql.append("       ,TENURE_START ,TENURE_END ,MEMBER_PHOTO ").append("\n");
		sql.append("       ,BD_CODE ,BD_CODE_ORDER ,GROUP_NO ,GROUP_NO_ORDER ").append("\n");
		sql.append("       ,OFFICE_ADDRESS ,OFFICE_PHONE ,OFFICE_FAX ").append("\n");
		sql.append("       ,HOME_ADDRESS ,HOME_PHONE ,CELLPHONE ").append("\n");
		sql.append("       ,EMAIL_CODE ,EMAIL ,BD_POSITION ,GROUP_POSITION ").append("\n");
		sql.append(" )  ").append("\n");
		sql.append(" VALUES (").append("\n");
		sql.append("         DMS_MEMBER_SEQ.NEXTVAL ").append("\n");
		sql.append("        ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ").append("\n");
		sql.append("        ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ").append("\n");
		sql.append("        ,? ,? ,? ,? ").append("\n");
		sql.append(" );  ").append("\n");

		sel_sql.append("SELECT DMS_MEMBER_SEQ.CURRVAL FROM DUAL");
		
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("ko_name"));
			pstmt.setString(2,jso.getString("ch_name"));
			pstmt.setString(3,jso.getString("en_name"));
			pstmt.setString(4,jso.getString("sco_no1"));
			pstmt.setString(5,jso.getString("sco_no2"));
			pstmt.setString(6,jso.getString("gender"));
			pstmt.setString(7,jso.getString("place_birth"));
			pstmt.setString(8,jso.getString("tenure_start"));
			pstmt.setString(9,jso.getString("tenure_end"));
			pstmt.setString(10,jso.getString("member_photo"));
			pstmt.setString(11,jso.getString("bd_code"));
			pstmt.setInt(12,jso.getInt("bd_code_order"));
			pstmt.setString(13,jso.getString("group_no"));
			pstmt.setInt(14,jso.getInt("group_no_order"));
			pstmt.setString(15,jso.getString("office_address"));
			pstmt.setString(16,jso.getString("office_phone"));
			pstmt.setString(17,jso.getString("office_fax"));
			pstmt.setString(18,jso.getString("home_address"));
			pstmt.setString(19,jso.getString("home_phone"));
			pstmt.setString(20,jso.getString("cellphone"));
			pstmt.setString(21,jso.getString("email_code"));
			pstmt.setString(22,jso.getString("email"));
			pstmt.setString(23,jso.getString("bd_position"));
			pstmt.setString(24,jso.getString("group_position"));
			result = pstmt.executeUpdate();
			pstmt = DBUtil.getConnection().prepareStatement(sel_sql.toString());
			rs = pstmt.executeQuery();
			if(rs.next()) member_no = rs.getInt(1);

			return member_no;

		} catch(Exception ex) {
			System.out.println("insertMember 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return member_no;
	}


	/**
	 * 이사회 구성원 삭제
	 * @param jso
	 * @return
	 * @throws Exception
	 */
	public boolean updateMember( JSONObject jso ) throws Exception {
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_MEMBER SET ").append("\n");
		sql.append("        KO_NAME = ? ").append("\n");
		sql.append("       ,CH_NAME = ? ").append("\n");
		sql.append("       ,EN_NAME = ? ").append("\n");
		sql.append("       ,SCO_NO1 = ? ").append("\n");
		sql.append("       ,SCO_NO2 = ? ").append("\n");
		sql.append("       ,GENDER = ? ").append("\n");
		sql.append("       ,PLACE_BIRTH = ? ").append("\n");
		sql.append("       ,TENURE_START = ? ").append("\n");
		sql.append("       ,TENURE_END = ? ").append("\n");
		sql.append("       ,MEMBER_PHOTO = ? ").append("\n");
		sql.append("       ,BD_CODE = ? ").append("\n");
		sql.append("       ,BD_CODE_ORDER = ? ").append("\n");
		sql.append("       ,GROUP_NO = ? ").append("\n");
		sql.append("       ,GROUP_NO_ORDER = ? ").append("\n");
		sql.append("       ,OFFICE_ADDRESS = ? ").append("\n");
		sql.append("       ,OFFICE_PHONE = ? ").append("\n");
		sql.append("       ,OFFICE_FAX = ? ").append("\n");
		sql.append("       ,HOME_ADDRESS = ? ").append("\n");
		sql.append("       ,HOME_PHONE = ? ").append("\n");
		sql.append("       ,CELLPHONE = ? ").append("\n");
		sql.append("       ,EMAIL_CODE = ? ").append("\n");
		sql.append("       ,EMAIL = ? ").append("\n");
		sql.append("       ,BD_POSITION = ? ").append("\n");
		sql.append("       ,GROUP_POSITION = ? ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("ko_name"));
			pstmt.setString(2,jso.getString("ch_name"));
			pstmt.setString(3,jso.getString("en_name"));
			pstmt.setString(4,jso.getString("sco_no1"));
			pstmt.setString(5,jso.getString("sco_no2"));
			pstmt.setString(6,jso.getString("gender"));
			pstmt.setString(7,jso.getString("place_birth"));
			pstmt.setString(8,jso.getString("tenure_start"));
			pstmt.setString(9,jso.getString("tenure_end"));
			pstmt.setString(10,jso.getString("member_photo"));
			pstmt.setString(11,jso.getString("bd_code"));
			pstmt.setInt(12,jso.getInt("bd_code_order"));
			pstmt.setString(13,jso.getString("group_no"));
			pstmt.setInt(14,jso.getInt("group_no_order"));
			pstmt.setString(15,jso.getString("office_address"));
			pstmt.setString(16,jso.getString("office_phone"));
			pstmt.setString(17,jso.getString("office_fax"));
			pstmt.setString(18,jso.getString("home_address"));
			pstmt.setString(19,jso.getString("home_phone"));
			pstmt.setString(20,jso.getString("cellphone"));
			pstmt.setString(21,jso.getString("email_code"));
			pstmt.setString(22,jso.getString("email"));
			pstmt.setString(23,jso.getString("bd_position"));
			pstmt.setString(24,jso.getString("group_position"));
			pstmt.setInt(25,jso.getInt("member_no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getMemberUpdate 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}


	public boolean deleteMember(int member_no) {
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_MEMBER ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1,member_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteMember 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}

}