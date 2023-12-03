package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;

public class DmsBoardNoticeDAO extends BaseDAO {

	public DmsBoardNoticeDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}


	protected Logger Log = Util.logger; 

	/**
	 * 게시판 리스트 구하기
	 * @param p_start
	 * @param p_page_many
	 * @param s_code
	 * @param s_subject
	 * @param s_context
	 * @return
	 * @throws Exception
	 */
	public JSONObject getBoardNoticeList ( 
			int p_start, int p_page_many, String s_code, String s_subject, String s_context) throws Exception {
		
        JSONObject jsr = new JSONObject();

		StringBuffer sql = new StringBuffer();
		int totCnt = -1;

		sql.append(" SELECT * ").append("\n");
		sql.append("   FROM ( ").append("\n");
		sql.append("         SELECT ROWNUM AS RNUM, LIST.* ").append("\n");
        sql.append("           FROM ( ").append("\n");
        sql.append("                 SELECT AA.*, COUNT(*) OVER() AS TOTCNT ").append("\n");
        sql.append("                   FROM ( ").append("\n");
        sql.append(" 	                     SELECT A.NO, A.CODE, A.CODE_NAME, A.SUBJECT, A.CONTEXT, A.WRITER, B.ENAME, ").append("\n");
        sql.append(" 		                        A.WRITE_DATE, A.READ_COUNT, A.REAL_ATT_FILE, A.DISPLAY_ATT_FILE ").append("\n");
        sql.append("                          FROM ( ").append("\n");
        sql.append("                                SELECT NO, A1.CODE, A2.CODE_NAME, SUBJECT, CONTEXT, WRITER, ").append("\n");
        sql.append(" 		                               TO_CHAR(TO_DATE(WRITE_DATE,'YYYYMMDDHH24MISS'),'YYYY-MM-DD') WRITE_DATE, ").append("\n");
        sql.append("                                       READ_COUNT, REAL_ATT_FILE, DISPLAY_ATT_FILE ").append("\n");
        sql.append("                                  FROM DMS_BOARD_NOTICE A1, DMS_BOARD_CODE A2").append("\n");
        sql.append("                                WHERE (A1.VIEW_END_DATE IS NULL OR A1.VIEW_END_DATE < TO_CHAR(SYSDATE,'YYYYMMDD')) ").append("\n");
		sql.append("                                  AND A1.CODE = A2.CODE ").append("\n");
        if(!s_code.equals("")) sql.append("           AND A1.CODE = '").append(s_code).append("' ").append("\n");
        if(!s_subject.equals("")) sql.append("        AND SUBJECT LIKE '%").append(s_subject).append("%' ").append("\n");
        if(!s_context.equals("")) sql.append("        AND CONTEXT LIKE '%").append(s_context).append("%' ").append("\n");
        sql.append("                                ) A ").append("\n");
        sql.append("                                LEFT OUTER JOIN ( ").append("\n");                 
        sql.append("                                SELECT TRIM(PERNR) PERNR, TRIM(ENAME) ENAME ").append("\n");
        sql.append("                                  FROM ZHR0010S X ").append("\n");
        sql.append("                                 WHERE ZDATE = (SELECT MAX(ZDATE) FROM ZHR0010S WHERE PERNR = X.PERNR) ").append("\n");
        sql.append("                                   AND I_EAI_DATE = (SELECT MAX(I_EAI_DATE) FROM ZHR0010S WHERE PERNR = X.PERNR) ").append("\n");
        sql.append("                                ) B ").append("\n"); 
        sql.append("                                ON A.WRITER = B.PERNR ").append("\n");
        sql.append(" 	                           ) AA ").append("\n");
        sql.append("                         ORDER BY NO DESC ").append("\n");
        sql.append("                ) LIST ").append("\n");
        sql.append("        ) ").append("\n");
        sql.append("  WHERE RNUM BETWEEN ? AND ? ").append("\n");
        
//        Log.info(sql.toString());
        
		try {
			JSONArray jsa = new JSONArray();
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1, p_start - 1);
            pstmt.setInt(2, p_start - 1 + p_page_many);
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
                jso.put("mode"      , "V");
                jso.put("no", StringUtils.defaultString(rs.getString("NO")));                             
                jso.put("code", StringUtils.defaultString(rs.getString("CODE")));
                jso.put("code_name", StringUtils.defaultString(rs.getString("CODE_NAME")));
                jso.put("subject", StringUtils.defaultString(rs.getString("SUBJECT")));                   
                jso.put("context", StringUtils.defaultString(rs.getString("CONTEXT")));                   
                jso.put("writer", StringUtils.defaultString(rs.getString("WRITER")));                     
                jso.put("ename", StringUtils.defaultString(rs.getString("ENAME")));                       
                jso.put("write_date", StringUtils.defaultString(rs.getString("WRITE_DATE")));             
                jso.put("read_count", StringUtils.defaultString(rs.getString("READ_COUNT")));             
                jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));       
                jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE"))); 


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
            
            jsr.put("return" , "200"); // 성공
            jsr.put("message" , "조회되었습니다."); // error message	
            return jsr;
		} catch(Exception ex) {
			 Util.logger.error("e.toString() : " + ex.toString()+ "<BR>");
   			 jsr.put("return" , "500"); // 실패
   			 jsr.put("message" , ex.toString()); // error message
   			 ex.printStackTrace();
		} finally {
			releaseResource();
		}

		return null;
	}

	public JSONArray getBoardNoticeTopList () throws Exception {
		
        JSONArray jsr = new JSONArray();

		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT * ").append("\n");
		sql.append("   FROM ( ").append("\n");
		sql.append("         SELECT ROWNUM AS RNUM, LIST.* ").append("\n");
        sql.append("           FROM ( ").append("\n");
        sql.append("                 SELECT AA.*, COUNT(*) OVER() AS TOTCNT ").append("\n");
        sql.append("                   FROM ( ").append("\n");
        sql.append(" 	                     SELECT A.NO, A.CODE, A.CODE_NAME, A.SUBJECT, A.CONTEXT, A.WRITER, B.ENAME, ").append("\n");
        sql.append(" 		                        A.WRITE_DATE, A.READ_COUNT, A.REAL_ATT_FILE, A.DISPLAY_ATT_FILE ").append("\n");
        sql.append("                          FROM ( ").append("\n");
        sql.append("                                SELECT NO, A1.CODE, A2.CODE_NAME, SUBJECT, CONTEXT, WRITER, ").append("\n");
        sql.append(" 		                               TO_CHAR(TO_DATE(WRITE_DATE,'YYYYMMDDHH24MISS'),'YYYY-MM-DD') WRITE_DATE, ").append("\n");
        sql.append("                                       READ_COUNT, REAL_ATT_FILE, DISPLAY_ATT_FILE ").append("\n");
        sql.append("                                  FROM DMS_BOARD_NOTICE A1, DMS_BOARD_CODE A2").append("\n");
        sql.append("                                WHERE A1.VIEW_END_DATE >= TO_CHAR(SYSDATE,'YYYYMMDD') ").append("\n");
		sql.append("                                  AND A1.CODE = A2.CODE ").append("\n");
        sql.append("                                ) A ").append("\n");
        sql.append("                                LEFT OUTER JOIN ( ").append("\n");                 
        sql.append("                                SELECT TRIM(PERNR) PERNR, TRIM(ENAME) ENAME ").append("\n");
        sql.append("                                  FROM ZHR0010S X ").append("\n");
        sql.append("                                 WHERE ZDATE = (SELECT MAX(ZDATE) FROM ZHR0010S WHERE PERNR = X.PERNR) ").append("\n");
        sql.append("                                   AND I_EAI_DATE = (SELECT MAX(I_EAI_DATE) FROM ZHR0010S WHERE PERNR = X.PERNR) ").append("\n");
        sql.append("                                ) B ").append("\n"); 
        sql.append("                                ON A.WRITER = B.PERNR ").append("\n");
        sql.append(" 	                           ) AA ").append("\n");
        sql.append("                         ORDER BY NO DESC ").append("\n");
        sql.append("                ) LIST ").append("\n");
        sql.append("        ) ").append("\n");
        
        Log.info(sql.toString());
        
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
                jso.put("mode"      , "V");
                jso.put("no", StringUtils.defaultString(rs.getString("NO")));                             
                jso.put("code", StringUtils.defaultString(rs.getString("CODE")));
                jso.put("code_name", StringUtils.defaultString(rs.getString("CODE_NAME")));
                jso.put("subject", StringUtils.defaultString(rs.getString("SUBJECT")));                   
                jso.put("context", StringUtils.defaultString(rs.getString("CONTEXT")));                   
                jso.put("writer", StringUtils.defaultString(rs.getString("WRITER")));                     
                jso.put("ename", StringUtils.defaultString(rs.getString("ENAME")));                       
                jso.put("write_date", StringUtils.defaultString(rs.getString("WRITE_DATE")));             
                jso.put("read_count", StringUtils.defaultString(rs.getString("READ_COUNT")));             
                jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));       
                jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE"))); 

                jsr.put(jso);
            }
            return jsr;
		} catch(Exception ex) {
			 Util.logger.error("e.toString() : " + ex.toString()+ "<BR>");
   			 ex.printStackTrace();
		} finally {
			releaseResource();
		}

		return null;
	}


	
	/**
	 * 게시물 상세 조회
	 * @param no
	 * @return
	 * @throws Exception
	 */
	public JSONObject getBoardNoticeDetail(int no) throws Exception {
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT NO ").append("\n");
		sql.append("       ,CODE ").append("\n");
		sql.append("       ,CODE_NAME ").append("\n");
		sql.append("       ,SUBJECT ").append("\n");
		sql.append("       ,CONTEXT ").append("\n");
		sql.append("       ,TO_CHAR(TO_DATE(WRITE_DATE,'YYYYMMDDHH24MISS'),'YYYY-MM-DD') WRITE_DATE ").append("\n");
		sql.append("       ,WRITER ").append("\n");
		sql.append("       ,ENAME ").append("\n");
		sql.append("       ,WRITE_DATE ").append("\n");
		sql.append("       ,READ_COUNT ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE  ").append("\n");
		sql.append("  FROM ( ").append("\n");
		sql.append("        SELECT NO ").append("\n");
		sql.append("              ,B.CODE CODE ").append("\n");
		sql.append("              ,B.CODE_NAME CODE_NAME ").append("\n");
		sql.append("              ,SUBJECT ").append("\n");
		sql.append("              ,CONTEXT ").append("\n");
		sql.append("              ,WRITER ").append("\n");
		sql.append("              ,WRITE_DATE ").append("\n");
		sql.append("              ,READ_COUNT ").append("\n");
		sql.append("              ,REAL_ATT_FILE ").append("\n");
		sql.append("              ,DISPLAY_ATT_FILE  ").append("\n");
		sql.append("         FROM DMS_BOARD_NOTICE A,  ").append("\n");
		sql.append("              DMS_BOARD_CODE B  ").append("\n");
		sql.append("        WHERE A.CODE = B.CODE ").append("\n");
		sql.append("          AND A.NO = ? ").append("\n");
		sql.append("        ) AA ").append("\n");
		sql.append("        LEFT OUTER JOIN (      ").append("\n");            
		sql.append("             SELECT TRIM(PERNR) PERNR, TRIM(ENAME) ENAME ").append("\n");
		sql.append("               FROM ZHR0010S X ").append("\n");
		sql.append("              WHERE ZDATE = (SELECT MAX(ZDATE) FROM ZHR0010S WHERE PERNR = X.PERNR) ").append("\n");
		sql.append("                AND I_EAI_DATE = (SELECT MAX(I_EAI_DATE) FROM ZHR0010S WHERE PERNR = X.PERNR) ").append("\n");
		sql.append("        ) BB ").append("\n");
		sql.append(" ON AA.WRITER = BB.PERNR ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1,no);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("no", StringUtils.defaultString(rs.getString("NO")));
				jso.put("code", StringUtils.defaultString(rs.getString("CODE")));
				jso.put("code_name", StringUtils.defaultString(rs.getString("CODE_NAME")));
				jso.put("subject", StringUtils.defaultString(rs.getString("SUBJECT")));
				jso.put("context", StringUtils.defaultString(rs.getString("CONTEXT")));
				jso.put("writer", StringUtils.defaultString(rs.getString("WRITER")));
				jso.put("ename", StringUtils.defaultString(rs.getString("ENAME")));
				jso.put("write_date", StringUtils.defaultString(rs.getString("WRITE_DATE")));
				jso.put("read_count", StringUtils.defaultString(rs.getString("READ_COUNT")));
				jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));
				jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBoardNoticeDetail 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return null;
	}


	/**
	 * 게시물 이전/다음 리스트 구하기
	 * @param no
	 * @param s_code
	 * @param s_subject
	 * @param s_context
	 * @return
	 * @throws Exception
	 */
	public JSONArray getBoardNoticeNextList ( 
			int no, String s_code, String s_subject, String s_context) throws Exception {
		
        JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT 1 NE, NO, SUBJECT ").append("\n");
        sql.append("   FROM DMS_BOARD_NOTICE  ").append("\n");
        sql.append("  WHERE NO IN ( ").append("\n");
        sql.append("               SELECT MAX(NO) FROM DMS_BOARD_NOTICE ").append("\n");
        sql.append("                WHERE NO < ? ").append("\n");
		sql.append("                  AND (VIEW_END_DATE IS NULL OR VIEW_END_DATE < TO_CHAR(SYSDATE,'YYYYMMDD')) ").append("\n");
        if(!s_code.equals("")) sql.append(" AND CODE = '").append(s_code).append("' ").append("\n");
        if(!s_subject.equals("")) sql.append(" AND SUBJECT LIKE '%").append(s_subject).append("%' ").append("\n");
        if(!s_context.equals("")) sql.append(" AND CONTEXT LIKE '%").append(s_context).append("%' ").append("\n");
        sql.append("              ) ").append("\n");
        sql.append("UNION ALL ").append("\n");
        sql.append(" SELECT 2 NE, NO, SUBJECT ").append("\n");
        sql.append("   FROM DMS_BOARD_NOTICE  ").append("\n");
        sql.append("  WHERE NO IN ( ").append("\n");
        sql.append("               SELECT MIN(NO) FROM DMS_BOARD_NOTICE ").append("\n");
        sql.append("                WHERE NO > ? ").append("\n");
		sql.append("                  AND (VIEW_END_DATE IS NULL OR VIEW_END_DATE < TO_CHAR(SYSDATE,'YYYYMMDD')) ").append("\n");
        if(!s_code.equals("")) sql.append(" AND CODE = '").append(s_code).append("' ").append("\n");
        if(!s_subject.equals("")) sql.append(" AND SUBJECT LIKE '%").append(s_subject).append("%' ").append("\n");
        if(!s_context.equals("")) sql.append(" AND CONTEXT LIKE '%").append(s_context).append("%' ").append("\n");
        sql.append("              ) ").append("\n");

        Log.info(sql.toString());
        
		try {
			JSONArray jsa = new JSONArray();
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1, no);
            pstmt.setInt(2, no);
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("ne", StringUtils.defaultString(rs.getString("NE")));
                jso.put("no", StringUtils.defaultString(rs.getString("NO")));                             
                jso.put("subject", StringUtils.defaultString(rs.getString("SUBJECT")));                   
                jsa.put(jso);
            }
            return jsa;
		} catch(Exception ex) {
			 Util.logger.error("e.toString() : " + ex.toString()+ "<BR>");
   			 jsr.put("return" , "500"); // 실패
   			 jsr.put("message" , ex.toString()); // error message
   			 ex.printStackTrace();
		} finally {
			releaseResource();
		}

		return null;
	}
	
	/**
	 * 게시물 등록
	 * @param jso
	 * @return
	 */
	public boolean insertBoardNotice(JSONObject jso) {
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BOARD_NOTICE(").append("\n");
		sql.append("        NO ").append("\n");
		sql.append("       ,CODE ").append("\n");
		sql.append("       ,SUBJECT ").append("\n");
		sql.append("       ,CONTEXT ").append("\n");
		sql.append("       ,WRITER ").append("\n");
		sql.append("       ,WRITE_DATE ").append("\n");
		sql.append("       ,READ_COUNT ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE ").append("\n");
		sql.append(" )  ").append("\n");
		sql.append(" VALUES (").append("\n");
		sql.append("         DMS_BOARD_NOTICE_SEQ.NEXTVAL ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,TO_CHAR(SYSDATE,'YYYYMMDDHH24MISS') ").append("\n");
		sql.append("        ,0 ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append(" )  ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			
			Log.info("s_code : " + jso.getString("s_code"));
			Log.info("subject : " + jso.getString("subject"));
			Log.info("context : " + jso.getString("context"));
			Log.info("writer : " + jso.getString("writer"));
			Log.info("real_att_file : " + jso.getString("real_att_file"));
			Log.info("display_att_file : " + jso.getString("display_att_file"));
			Log.info(sql.toString());
			
			pstmt.setString(1,jso.getString("s_code"));
			pstmt.setString(2,jso.getString("subject"));
			pstmt.setString(3,jso.getString("context"));
			pstmt.setString(4,jso.getString("writer"));
			pstmt.setString(5,jso.getString("real_att_file"));
			pstmt.setString(6,jso.getString("display_att_file"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBoardNotice 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}

	
	/**
	 * 게시물 수정
	 * @param jso
	 * @return
	 * @throws Exception
	 */
	public boolean updateBoardNotice( JSONObject jso ) throws Exception {
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BOARD_NOTICE SET ").append("\n");
		sql.append("        CODE = ? ").append("\n");
		sql.append("       ,SUBJECT = ? ").append("\n");
		sql.append("       ,CONTEXT = ? ").append("\n");
		sql.append("       ,WRITER = ? ").append("\n");
		sql.append("       ,REAL_ATT_FILE = ? ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE = ? ").append("\n");
		sql.append(" WHERE NO = ? ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("code"));
			pstmt.setString(2,jso.getString("subject"));
			pstmt.setString(3,jso.getString("context"));
			pstmt.setString(4,jso.getString("writer"));
			pstmt.setString(5,jso.getString("real_att_file"));
			pstmt.setString(6,jso.getString("display_att_file"));
			pstmt.setInt(7,jso.getInt("no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBoardNoticeUpdate 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}


	/**
	 * 게시물 삭제
	 * @param no
	 * @return
	 */
	public boolean deleteBoardNotice(int no) {
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BOARD_NOTICE ").append("\n");
		sql.append(" WHERE NO = ? ").append("\n");
		try {
			Log.debug("----> no : " + no);
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1,no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBoardNotice 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}
	
	/**
	 * 조회수 증가
	 * @param no
	 * @throws Exception
	 */
	public void setReadCountUpdate(int no) throws Exception {
		StringBuffer sql = new StringBuffer();
		sql.append(" UPDATE DMS_BOARD_NOTICE SET READ_COUNT = READ_COUNT+1 WHERE NO = ? ");
		try{
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1, no);
			pstmt.executeUpdate();
		}catch(Exception ex){
			System.out.println("setReadCountUpdate 에러 : "+ex);
		}
		finally{
			releaseResource();
		}
	}

	public JSONObject getAttFile(int no) throws Exception {
		JSONObject jso = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE  ").append("\n");
		sql.append("  FROM DMS_BOARD_NOTICE ").append("\n");
		sql.append(" WHERE NO = ? ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1,no);
			rs = pstmt.executeQuery();

			if(rs.next()){
				jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));
				jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
			}
			
			return jso;
		} catch(Exception ex) {
			System.out.println("getAttFile 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return null;
	}
}