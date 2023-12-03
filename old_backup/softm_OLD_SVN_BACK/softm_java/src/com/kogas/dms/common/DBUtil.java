package com.kogas.dms.common;

import java.sql.Connection;
import java.sql.SQLException;

import javax.naming.Context;
import javax.naming.InitialContext;
import javax.sql.DataSource;
/**
 * @author softmind
 */
public class DBUtil {
	private static ThreadLocal<Connection> connection = new ThreadLocal<Connection>();
	private static boolean initialized = false;
	
	public static void init() {
		DBUtil.initialized = true;
	}

	public static Connection getConnection()  {
		if (!initialized) throw new IllegalStateException("DBUtil is not initialized");
		DataSource ds = null;		
		try {
			if (connection.get() == null || connection.get().isClosed()) {
				String dsName = "java:comp/env/jdbc/kogasDB";
				Context init = new InitialContext();
				ds = (DataSource) init.lookup(dsName);
	            Util.logger.info("Connection Create!!");
				connection.set(ds.getConnection());	            
			} else {
	            Util.logger.info("Connection Get!!");
			}
		} catch (Exception e) {
			e.printStackTrace();
            Util.logger.fatal(e);
		}
		return connection.get();
	}
	
	public static void end() {
        try {
            if ( connection.get() != null ) { 
            	connection.get().close();
            	connection.remove();
	    		DBUtil.initialized = false;            	
	            Util.logger.info("Connection Closed!!");
            }
        } catch (Exception e) {
			e.printStackTrace();
            Util.logger.fatal(e);
        }
    }
}
