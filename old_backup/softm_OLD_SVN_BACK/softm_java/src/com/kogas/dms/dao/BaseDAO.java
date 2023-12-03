package com.kogas.dms.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import javax.naming.InitialContext;
import javax.naming.NamingException;
import javax.sql.DataSource;

import org.apache.log4j.Logger;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;

public class BaseDAO {
    protected PreparedStatement   pstmt = null;  // Statement
    protected Statement           stmt  = null;  // Statement
    protected ResultSet           rs    = null;  // ResultSet
    
    protected Logger Log = Util.logger;
    protected static String PREFIX_SELECT_SQL = " SELECT "
								            + " * "
								            + " FROM ("
								            + "     SELECT"
								            + "         MM.*,"
								            + "         ROWNUM AS RNUM,"
								            + "         COUNT(*) OVER() AS TOTCNT FROM"
								            + "     (";
    
    protected static String SURFIX_SELECT_SQL =  "     ) MM"
            							    + " ) WHERE RNUM > ? AND RNUM <= ?";
    		
    public BaseDAO () throws Exception {
    }

	protected void releaseResource() {
        try {
            if ( this.rs   != null ) { this.rs.close();   }   // ResultSet의  소멸
            if ( this.pstmt!= null ) { this.pstmt.close();}   // PreparedStatement의  소멸
            if ( this.stmt != null ) { this.stmt.close(); }   // Statement의  소멸
            
        } catch (SQLException ex) {
            Util.logger.fatal(BaseDAO.class.getName());
        }
    }
}