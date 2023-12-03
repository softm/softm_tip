package com.kogas.dms.dao;

import java.util.ArrayList;
import org.apache.log4j.Logger;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;

public class DmsBdAttendMemberDAO extends BaseDAO {

	public DmsBdAttendMemberDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	protected Logger Log = Util.logger; 

	public boolean writeAttendMember(int schedule_no, int member_no, String attend_yn, int comment_nember) {
		int result = 0;

		StringBuffer sqlDel = new StringBuffer();
		StringBuffer sqlIns = new StringBuffer();

		sqlDel.append("DELETE FROM DMS_BD_ATTEND_MEMBER WHERE SCHEDULE_NO = ? AND MEMBER_NO2 = ?");
		sqlIns.append("INSERT INTO DMS_BD_ATTEND_MEMBER ( ").append("\n");
		sqlIns.append("  SCHEDULE_NO,  MEMBER_NO2, ATTEND_YN, COMMENT_NUMBER )").append("\n");
		sqlIns.append(" VALUES (?, ?, ?, ?) ");
		
		try {
			Log.debug("DEL : " + sqlDel.toString());
			pstmt = DBUtil.getConnection().prepareStatement(sqlDel.toString());
			pstmt.setInt(1,schedule_no);
			pstmt.setInt(2,member_no);
			result = pstmt.executeUpdate();
			
			Log.debug("INS : " + sqlIns.toString());
			pstmt = DBUtil.getConnection().prepareStatement(sqlIns.toString());
			pstmt.setInt(1,schedule_no);
			pstmt.setInt(2,member_no);
			pstmt.setString(3,attend_yn);
			pstmt.setInt(4,comment_nember);
			result = pstmt.executeUpdate();

			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("writeAttendMember 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}
}