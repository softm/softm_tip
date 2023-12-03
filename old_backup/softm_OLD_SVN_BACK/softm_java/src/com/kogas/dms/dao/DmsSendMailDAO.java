package com.kogas.dms.dao;

import java.sql.SQLException;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;

public class DmsSendMailDAO extends BaseDAO{

	public DmsSendMailDAO() throws Exception {
		super();
	}
	
	/**
	 * getMeetingNoticInfo
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONObject getMeetingNoticInfo(int scheduleNo) throws Exception {
		JSONObject jsa = new JSONObject();
		
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("      A.BD_NO ").append("\n");
    		sql.append("     ,(SELECT GUBUN_NAME FROM DMS_BD_GUBUN_CODE ").append("\n");
    		sql.append("       WHERE GUBUN_CODE = A.GUBUN_CODE)                  AS GUBUN_NAME ").append("\n");
    		sql.append("     ,(SELECT CODE_NAME FROM DMS_BD_NAME_CODE ").append("\n");
    		sql.append("       WHERE NAME_CODE = A.NAME_CODE ").append("\n");
    		sql.append("       AND GUBUN_CODE = A.GUBUN_CODE)                    AS BD_NAME ").append("\n");
    		sql.append("     ,TO_CHAR(TO_DATE(A.BD_START_DAY,'YYYY-MM-DD') ").append("\n");
    		sql.append("             ,'YYYY-MM-DD')                              AS BD_START_DATE ").append("\n");
    		sql.append("     ,DECODE(TO_CHAR(TO_DATE(A.BD_START_DAY,'YYYY-MM-DD'),'D'), 1,'일', ").append("\n");
    		sql.append("             2,'월',3,'화',4,'수',5,'목',6,'금','토')    AS BD_START_DAY ").append("\n");
    		sql.append("     ,A.BD_TIME ").append("\n");
    		sql.append("     ,A.BD_PLACE ").append("\n");
    		sql.append("     ,TO_CHAR(SYSDATE, 'YYYY. MM. DD')                   AS CURR_DATE ").append("\n");
    		sql.append(" FROM DMS_BD_SCHEDULE A ").append("\n");
    		sql.append(" WHERE A.SCHEDULE_NO = ? ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
			pstmt.setInt(1,scheduleNo);
			rs  = pstmt.executeQuery();
			
            if ( rs.next() ) {
                
				jsa.put("bd_no",				rs.getInt("BD_NO" ));
				jsa.put("gubun_name",	StringUtils.defaultString(rs.getString("GUBUN_NAME" )));
				jsa.put("bd_name",			StringUtils.defaultString(rs.getString("BD_NAME" )));
				jsa.put("bd_start_date",	StringUtils.defaultString(rs.getString("BD_START_DATE" )));
				jsa.put("bd_start_day",	StringUtils.defaultString(rs.getString("BD_START_DAY" )));
				jsa.put("bd_time",			StringUtils.defaultString(rs.getString("BD_TIME" )));
				jsa.put("bd_place",			StringUtils.defaultString(rs.getString("BD_PLACE" )));
				jsa.put("curr_date",		StringUtils.defaultString(rs.getString("CURR_DATE" )));
                
            }
        } catch ( SQLException e) {
			 Log.error("개최공지 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
	/**
	 * getSendMailList
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray getSendMailList() throws Exception {
		JSONArray jsa = new JSONArray();
				
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT  DISTINCT ").append("\n");
    		sql.append("     TRIM(EMAIL)		AS EMAIL ").append("\n");
    		sql.append("    ,TRIM(BD_CODE)	AS BD_CODE ").append("\n");
    		sql.append(" FROM ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          EMAIL ").append("\n");
    		sql.append("         ,BD_CODE ").append("\n");
    		sql.append("     FROM DMS_MEMBER ").append("\n");
    		sql.append("     UNION ALL ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          A.EMAIL ").append("\n");
    		sql.append("         ,'10'               AS BD_CODE ").append("\n");
    		sql.append("     FROM ( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              * ").append("\n");
    		sql.append("         FROM ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  A.* ").append("\n");
    		sql.append("                 ,RANK() OVER (PARTITION BY A.PERNR ORDER BY A.I_EAI_DATE DESC)  AS RNK ").append("\n");
    		sql.append("             FROM ZHR0010S A ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("         WHERE RNK = 1 ").append("\n");
    		sql.append("         AND OTYPE <> 'D' ").append("\n");
    		sql.append("     ) A, ( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              * ").append("\n");
    		sql.append("         FROM ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  A.* ").append("\n");
    		sql.append("                 ,RANK() OVER (PARTITION BY A.OBJID ORDER BY A.I_EAI_DATE DESC)  AS RNK ").append("\n");
    		sql.append("             FROM ZHR0020S A ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("         WHERE RNK = 1 ").append("\n");
    		sql.append("         AND OTYPE <> 'D' ").append("\n");
    		sql.append("     ) B ").append("\n");
    		sql.append("     WHERE A.PLACE = 'P004' ").append("\n");
    		sql.append("     AND A.DUTIS = 'D004' ").append("\n");
    		sql.append("     AND A.GSBER = '1000' ").append("\n");
    		sql.append("     AND A.ORGEH = B.OBJID ").append("\n");
    		sql.append(" ) ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
			rs  = pstmt.executeQuery();
			
            while ( rs.next() ) {
            	
                JSONObject jso = new JSONObject();
                jso.put("bd_code",		StringUtils.defaultString(rs.getString("BD_CODE" )));
                jso.put("email",			StringUtils.defaultString(rs.getString("EMAIL" )));
                
                jsa.put(jso);
            }
        } catch ( SQLException e) {
			 Log.error("이사회 구성원 메일 주소 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
	/**
	 * getReturnMailInfo
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONObject getReturnMailInfo(int itemNo) throws Exception {
		JSONObject jsa = new JSONObject();
		
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("      A.ITEM_NAME ").append("\n");
    		sql.append("     ,B.BD_NO ").append("\n");
    		sql.append(" 	,(SELECT GUBUN_NAME FROM DMS_BD_GUBUN_CODE ").append("\n");
    		sql.append("       WHERE GUBUN_CODE = B.GUBUN_CODE)                  AS GUBUN_NAME ").append("\n");
    		sql.append("     ,(SELECT CODE_NAME FROM DMS_BD_NAME_CODE ").append("\n");
    		sql.append("       WHERE NAME_CODE = B.NAME_CODE ").append("\n");
    		sql.append("       AND GUBUN_CODE = B.GUBUN_CODE)                    AS BD_NAME ").append("\n");
    		sql.append("     ,REPLACE(C.ENAME,' ','')		AS ENAME ").append("\n");
    		sql.append("     ,TRIM(C.EMAIL)					AS EMAIL ").append("\n");
    		sql.append("     ,TRIM(D.STEXT)					AS STEXT ").append("\n");
    		sql.append(" FROM DMS_BD_ITEM A ").append("\n");
    		sql.append("     ,DMS_BD_SCHEDULE B ").append("\n");
    		sql.append("     ,( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              * ").append("\n");
    		sql.append("         FROM ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  A.* ").append("\n");
    		sql.append("                 ,RANK() OVER (PARTITION BY A.PERNR ORDER BY A.I_EAI_DATE DESC)  AS RNK ").append("\n");
    		sql.append("             FROM ZHR0010S A ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("         WHERE RNK = 1 ").append("\n");
    		sql.append("         AND OTYPE <> 'D' ").append("\n");
    		sql.append("     ) C, ( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              * ").append("\n");
    		sql.append("         FROM ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  A.* ").append("\n");
    		sql.append("                 ,RANK() OVER (PARTITION BY A.OBJID ORDER BY A.I_EAI_DATE DESC)  AS RNK ").append("\n");
    		sql.append("             FROM ZHR0020S A ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("         WHERE RNK = 1 ").append("\n");
    		sql.append("         AND OTYPE <> 'D' ").append("\n");
    		sql.append("     ) D ").append("\n");
    		sql.append(" WHERE A.ITEM_NO = ? ").append("\n");
    		sql.append(" AND B.SCHEDULE_NO = A.SCHEDULE_NO ").append("\n");
    		sql.append(" AND TRIM(C.PERNR) = A.CRE_USER ").append("\n");
    		sql.append(" AND TRIM(D.OBJID) = A.DEPT_CODE ").append("\n");
    		sql.append(" AND D.OBJID = C.ORGEH ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
			pstmt.setInt(1,itemNo);
			rs  = pstmt.executeQuery();
			
            if ( rs.next() ) {
            	
				jsa.put("bd_no",				rs.getInt("BD_NO" ));
				jsa.put("gubun_name",	StringUtils.defaultString(rs.getString("GUBUN_NAME" )));
				jsa.put("bd_name",			StringUtils.defaultString(rs.getString("BD_NAME" )));
				jsa.put("item_name",		StringUtils.defaultString(rs.getString("ITEM_NAME" )));
				jsa.put("ename",			StringUtils.defaultString(rs.getString("ENAME" )));
				jsa.put("email",				StringUtils.defaultString(rs.getString("EMAIL" )));
				jsa.put("stext",				StringUtils.defaultString(rs.getString("STEXT" )));
                
            }
        } catch ( SQLException e) {
			 Log.error("안건 정보 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
	/**
	 * getSendMailAddressList
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray getSendMailAddressList(String deptCd) throws Exception {
		JSONArray jsa = new JSONArray();
				
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("      TRIM(A.EMAIL)          AS EMAIL ").append("\n");
    		sql.append("     ,REPLACE(A.ENAME,' ','')          AS ENAME ").append("\n");
    		sql.append("     ,TRIM(A.PERNR)          AS PERNR ").append("\n");
    		sql.append("     ,TRIM(A.PLACE)          AS PLACE ").append("\n");
    		sql.append("     ,TRIM(A.PLACETX)       AS PLACETX ").append("\n");
    		sql.append("     ,TRIM(B.OBJID)          AS DEPT_CD ").append("\n");
    		sql.append("     ,TRIM(B.STEXT)          AS DEPT_NM ").append("\n");
    		sql.append(" FROM ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          EMAIL ").append("\n");
    		sql.append("         ,PERNR ").append("\n");
    		sql.append("         ,ENAME ").append("\n");
    		sql.append("         ,ORGEH ").append("\n");
    		sql.append("         ,PLACE ").append("\n");
    		sql.append("         ,PLACETX ").append("\n");
    		sql.append("     FROM ( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              A.* ").append("\n");
    		sql.append("             ,RANK() OVER (PARTITION BY A.PERNR ORDER BY A.I_EAI_DATE DESC)  AS RNK ").append("\n");
    		sql.append("         FROM ZHR0010S A ").append("\n");
    		sql.append("     ) ").append("\n");
    		sql.append("     WHERE RNK = 1 ").append("\n");
    		sql.append("     AND OTYPE <> 'D' ").append("\n");
    		sql.append("     AND DUTIS <> 'ZZ71' ").append("\n");
    		sql.append("     AND ORGEH = ? ").append("\n");
    		sql.append("     ORDER BY PLACE ").append("\n");
    		sql.append(" ) A, ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          OBJID ").append("\n");
    		sql.append("         ,STEXT ").append("\n");
    		sql.append("     FROM ( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              A.* ").append("\n");
    		sql.append("             ,RANK() OVER (PARTITION BY A.OBJID ORDER BY A.I_EAI_DATE DESC)  AS RNK ").append("\n");
    		sql.append("         FROM ZHR0020S A ").append("\n");
    		sql.append("     ) ").append("\n");
    		sql.append("     WHERE RNK = 1 ").append("\n");
    		sql.append("     AND OTYPE <> 'D' ").append("\n");
    		sql.append("     AND OBJID = ? ").append("\n");
    		sql.append(" ) B ").append("\n");
    		sql.append(" WHERE A.ORGEH = B.OBJID ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
			pstmt.setString(1,deptCd);
			pstmt.setString(2,deptCd);
			rs  = pstmt.executeQuery();
			
            while ( rs.next() ) {
            	
                JSONObject jso = new JSONObject();
                
                jso.put("email",		StringUtils.defaultString(rs.getString("EMAIL" )));
                jso.put("ename",	StringUtils.defaultString(rs.getString("ENAME" )));
                jso.put("pernr",		StringUtils.defaultString(rs.getString("PERNR" )));
                jso.put("dept_cd",	StringUtils.defaultString(rs.getString("DEPT_CD" )));
                jso.put("dept_nm",	StringUtils.defaultString(rs.getString("DEPT_NM" )));
                
                jsa.put(jso);
            }
        } catch ( SQLException e) {
			 Log.error("부서별 메일 주소 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
	/**
	 * getRequestInfo
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONObject getRequestInfo(int reqNo) throws Exception {
		JSONObject jsa = new JSONObject();
		
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("      A.REQ_SUBJECT ").append("\n");
    		sql.append("     ,TO_CHAR(TO_DATE(A.END_DATE,'YYYY-MM-DD'),'YYYY-MM-DD')     AS END_DATE ").append("\n");
    		sql.append("     ,NVL(B.ITEM_NAME,'기타')                                    AS ITEM_NAME ").append("\n");
    		sql.append("     ,C.KO_NAME ").append("\n");
    		sql.append("     ,D.EMAIL ").append("\n");
    		sql.append("     ,A.CHARGE_USER                                              AS CHARGE_USER_PERNR ").append("\n");
    		sql.append("     ,D.ENAME                                                    AS CHARGE_USER_NM ").append("\n");
    		sql.append("     ,E.OBJID                                                    AS CHARGE_DEPT_CD ").append("\n");
    		sql.append("     ,E.STEXT                                                    AS CHARGE_DEPT_NM ").append("\n");
    		sql.append(" FROM DMS_BD_REQUEST A ").append("\n");
    		sql.append("     ,DMS_BD_ITEM B ").append("\n");
    		sql.append("     ,DMS_MEMBER C ").append("\n");
    		sql.append("     ,( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              TRIM(EMAIL)    AS EMAIL ").append("\n");
    		sql.append("             ,TRIM(PERNR)    AS PERNR ").append("\n");
    		sql.append("             ,REPLACE(ENAME,' ','')    AS ENAME ").append("\n");
    		sql.append("             ,TRIM(ORGEH)    AS ORGEH ").append("\n");
    		sql.append("         FROM ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  A.* ").append("\n");
    		sql.append("                 ,RANK() OVER (PARTITION BY A.PERNR ORDER BY A.I_EAI_DATE DESC)  AS RNK ").append("\n");
    		sql.append("             FROM ZHR0010S A ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("         WHERE RNK = 1 ").append("\n");
    		sql.append("         AND OTYPE <> 'D' ").append("\n");
    		sql.append("     ) D, ( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              TRIM(OBJID)        AS OBJID ").append("\n");
    		sql.append("             ,TRIM(STEXT)        AS STEXT ").append("\n");
    		sql.append("         FROM ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  A.* ").append("\n");
    		sql.append("                 ,RANK() OVER (PARTITION BY A.OBJID ORDER BY A.I_EAI_DATE DESC)  AS RNK ").append("\n");
    		sql.append("             FROM ZHR0020S A ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("         WHERE RNK = 1 ").append("\n");
    		sql.append("         AND OTYPE <> 'D' ").append("\n");
    		sql.append("     ) E ").append("\n");
    		sql.append(" WHERE A.REQ_NO = ? ").append("\n");
    		sql.append(" AND B.ITEM_NO (+) = A.ITEM_NO ").append("\n");
    		sql.append(" AND C.MEMBER_NO = A.MEMBER_NO ").append("\n");
    		sql.append(" AND D.PERNR (+) = A.CHARGE_USER ").append("\n");
    		sql.append(" AND E.OBJID = A.DEPT_ID ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
			pstmt.setInt(1,reqNo);
			rs  = pstmt.executeQuery();
			
            if ( rs.next() ) {
            	
				jsa.put("req_subject",				StringUtils.defaultString(rs.getString("REQ_SUBJECT" )));
				jsa.put("end_date",					StringUtils.defaultString(rs.getString("END_DATE" )));
				jsa.put("item_name",				StringUtils.defaultString(rs.getString("ITEM_NAME" )));
				jsa.put("ko_name",					StringUtils.defaultString(rs.getString("KO_NAME" )));
				jsa.put("email",						StringUtils.defaultString(rs.getString("EMAIL" )));
				jsa.put("charge_user_pernr",	StringUtils.defaultString(rs.getString("CHARGE_USER_PERNR" )));
				jsa.put("charge_user_nm",		StringUtils.defaultString(rs.getString("CHARGE_USER_NM" )));
				jsa.put("charge_dept_cd",		StringUtils.defaultString(rs.getString("CHARGE_DEPT_CD" )));
				jsa.put("charge_dept_nm",		StringUtils.defaultString(rs.getString("CHARGE_DEPT_NM" )));
                
            }
        } catch ( SQLException e) {
			 Log.error("이사 요청자료 정보 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
	/**
	 * getPropelPresentInfo
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONObject getPropelPresentInfo(int propelNo) throws Exception {
		JSONObject jsa = new JSONObject();
		
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("      B.ITEM_NAME ").append("\n");
    		sql.append("     ,D.CODE_NAME ").append("\n");
    		sql.append("     ,E.DEPT_CODE                                            AS CHARGE_DEPT_CD ").append("\n");
    		sql.append("     ,E.DEPT_NAME                                            AS CHARGE_DEPT_NM ").append("\n");
    		sql.append("     ,TO_CHAR(TO_DATE(A.END_DATE,'YYYYMMDD'),'YYYY-MM-DD')   AS END_DATE ").append("\n");
    		sql.append("     ,F.CHARGE_USER_PERNR ").append("\n");
    		sql.append("     ,F.CHARGE_USER_NM ").append("\n");
    		sql.append("     ,F.EMAIL ").append("\n");
    		sql.append(" FROM DMS_PROPEL_PRESENT A ").append("\n");
    		sql.append("     ,DMS_BD_ITEM B ").append("\n");
    		sql.append("     ,DMS_BD_ITEM_RESULT C ").append("\n");
    		sql.append("     ,DMS_BD_ITEM_RESULT_CODE D ").append("\n");
    		sql.append("     ,( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              TRIM(OBJID)        AS DEPT_CODE ").append("\n");
    		sql.append("             ,TRIM(STEXT)        AS DEPT_NAME ").append("\n");
    		sql.append("         FROM ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  A.* ").append("\n");
    		sql.append("                 ,RANK() OVER (PARTITION BY A.OBJID ORDER BY A.I_EAI_DATE DESC)  AS RNK ").append("\n");
    		sql.append("             FROM ZHR0020S A ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("         WHERE RNK = 1 ").append("\n");
    		sql.append("         AND OTYPE <> 'D' ").append("\n");
    		sql.append("      ) E, ( ").append("\n");
    		sql.append("          SELECT ").append("\n");
    		sql.append("              TRIM(EMAIL)            AS EMAIL ").append("\n");
    		sql.append("             ,TRIM(PERNR)            AS CHARGE_USER_PERNR ").append("\n");
    		sql.append("             ,REPLACE(ENAME,' ','')            AS CHARGE_USER_NM ").append("\n");
    		sql.append("         FROM ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  A.* ").append("\n");
    		sql.append("                 ,RANK() OVER (PARTITION BY A.PERNR ORDER BY A.I_EAI_DATE DESC)  AS RNK ").append("\n");
    		sql.append("             FROM ZHR0010S A ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("         WHERE RNK = 1 ").append("\n");
    		sql.append("         AND OTYPE <> 'D' ").append("\n");
    		sql.append("         AND DUTIS <> 'ZZ71' ").append("\n");
    		sql.append("     ) F ").append("\n");
    		sql.append(" WHERE A.PROPEL_NO = ? ").append("\n");
    		sql.append(" AND B.ITEM_NO = A.ITEM_NO ").append("\n");
    		sql.append(" AND C.ITEM_NO = B.ITEM_NO ").append("\n");
    		sql.append(" AND D.CODE = C.CODE ").append("\n");
    		sql.append(" AND E.DEPT_CODE = B.DEPT_CODE ").append("\n");
    		sql.append(" AND F.CHARGE_USER_PERNR = B.CRE_USER ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
			pstmt.setInt(1,propelNo);
			rs  = pstmt.executeQuery();
			
            if ( rs.next() ) {
            	
				jsa.put("item_name",				StringUtils.defaultString(rs.getString("ITEM_NAME" )));
				jsa.put("code_name",				StringUtils.defaultString(rs.getString("CODE_NAME" )));
				jsa.put("charge_dept_cd",		StringUtils.defaultString(rs.getString("CHARGE_DEPT_CD" )));
				jsa.put("charge_dept_nm",		StringUtils.defaultString(rs.getString("CHARGE_DEPT_NM" )));
				jsa.put("end_date",					StringUtils.defaultString(rs.getString("END_DATE" )));
				jsa.put("charge_user_pernr",	StringUtils.defaultString(rs.getString("CHARGE_USER_PERNR" )));
				jsa.put("charge_user_nm",		StringUtils.defaultString(rs.getString("CHARGE_USER_NM" )));
				jsa.put("email",						StringUtils.defaultString(rs.getString("EMAIL" )));
                
            }
        } catch ( SQLException e) {
			 Log.error("추진현황 정보 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
	/**
	 * getItemInfoList
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray getItemInfoList(int scheduleNo) throws Exception {
		JSONArray jsa = new JSONArray();
				
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("      COL ").append("\n");
    		sql.append("     ,ITEM_DEVISION ").append("\n");
    		sql.append("     ,ITEM_NAME ").append("\n");
    		sql.append(" FROM DMS_BD_ITEM ").append("\n");
    		sql.append(" WHERE SCHEDULE_NO = ? ").append("\n");
    		sql.append(" ORDER BY COL ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());
			
			pstmt.setInt(1,scheduleNo);
			rs  = pstmt.executeQuery();
			
            while ( rs.next() ) {
            	
                JSONObject jso = new JSONObject();
                
                jso.put("col",					rs.getInt("COL" ));
                jso.put("item_devision",	StringUtils.defaultString(rs.getString("ITEM_DEVISION" )));
                jso.put("item_name",		StringUtils.defaultString(rs.getString("ITEM_NAME" )));
                
                jsa.put(jso);
            }
        } catch ( SQLException e) {
			 Log.error("이사회 구성원 메일 주소 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
	/**
	 * getItemResultInfo
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONObject getItemResultInfo(int itemNo) throws Exception {
		JSONObject jsa = new JSONObject();
		
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
            sql.append("      A.COL ").append("\n");
            sql.append("     ,A.ITEM_NAME ").append("\n");
            sql.append("     ,B.REAL_ATT_FILE ").append("\n");
            sql.append("     ,B.DISPLAY_ATT_FILE ").append("\n");
            sql.append("     ,(SELECT CODE_NAME FROM DMS_BD_ITEM_RESULT_CODE WHERE CODE = B.CODE)        AS ITEM_RESULT ").append("\n");
            sql.append("     ,C.BD_NO ").append("\n");
            sql.append("     ,(SELECT GUBUN_NAME FROM DMS_BD_GUBUN_CODE WHERE GUBUN_CODE = C.GUBUN_CODE) AS GUBUN_NAME ").append("\n");
            sql.append("     ,(SELECT CODE_NAME FROM DMS_BD_NAME_CODE WHERE NAME_CODE = C.NAME_CODE)     AS BD_NAME ").append("\n");
            sql.append("     ,D.EMAIL ").append("\n");
            sql.append("     ,D.KO_NAME ").append("\n");
            sql.append("     ,E.REAL_PROCEED_ATT_FILE ").append("\n");
            sql.append("     ,E.DISPLAY_PROCEED_ATT_FILE ").append("\n");
            sql.append(" FROM DMS_BD_ITEM A ").append("\n");
            sql.append("     ,DMS_BD_ITEM_RESULT B ").append("\n");
            sql.append("     ,DMS_BD_SCHEDULE C ").append("\n");
            sql.append("     ,( ").append("\n");
            sql.append("         SELECT ").append("\n");
            sql.append("              TRIM(PERNR)            AS CRE_USER ").append("\n");
            sql.append("             ,TRIM(EMAIL)            AS EMAIL ").append("\n");
            sql.append("             ,REPLACE(ENAME,' ','')  AS KO_NAME ").append("\n");
            sql.append("         FROM ( ").append("\n");
            sql.append("             SELECT ").append("\n");
            sql.append("                  A.* ").append("\n");
            sql.append("                 ,RANK() OVER (PARTITION BY A.PERNR ORDER BY A.I_EAI_DATE)   AS RNK ").append("\n");
            sql.append("             FROM ZHR0010S A ").append("\n");
            sql.append("         ) ").append("\n");
            sql.append("         WHERE RNK = 1 ").append("\n");
            sql.append("         AND OTYPE <> 'D' ").append("\n");
            sql.append("      ) D ").append("\n");
            sql.append("     ,DMS_BD_PROCEEDINGS E ").append("\n");
            sql.append(" WHERE A.ITEM_NO = ? ").append("\n");
            sql.append(" AND B.ITEM_NO = A.ITEM_NO ").append("\n");
            sql.append(" AND C.SCHEDULE_NO = A.SCHEDULE_NO ").append("\n");
            sql.append(" AND D.CRE_USER = A.CRE_USER ").append("\n");
            sql.append(" AND E.SCHEDULE_NO = A.SCHEDULE_NO ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
			pstmt.setInt(1,itemNo);
			rs  = pstmt.executeQuery();
			
            if ( rs.next() ) {
            	
				jsa.put("col",									rs.getInt("COL" ));
				jsa.put("item_name",						StringUtils.defaultString(rs.getString("ITEM_NAME" )));
				jsa.put("real_att_file",						StringUtils.defaultString(rs.getString("REAL_ATT_FILE" )));
				jsa.put("display_att_file",					StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE" )));
				jsa.put("item_result",						StringUtils.defaultString(rs.getString("ITEM_RESULT" )));
				jsa.put("bd_no",								rs.getInt("BD_NO" ));
				jsa.put("gubun_name",					StringUtils.defaultString(rs.getString("GUBUN_NAME" )));
				jsa.put("bd_name",							StringUtils.defaultString(rs.getString("BD_NAME" )));
				jsa.put("email",								StringUtils.defaultString(rs.getString("EMAIL" )));
				jsa.put("ko_name",							StringUtils.defaultString(rs.getString("KO_NAME" )));
				jsa.put("real_proceed_att_file",		StringUtils.defaultString(rs.getString("REAL_PROCEED_ATT_FILE" )));
				jsa.put("display_proceed_att_file",	StringUtils.defaultString(rs.getString("DISPLAY_PROCEED_ATT_FILE" )));
                
            }
        } catch ( SQLException e) {
			 Log.error("의결결과 정보 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
}