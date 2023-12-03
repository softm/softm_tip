package rara.task;

import java.io.*;
import java.sql.SQLException;

import javax.sql.DataSource;

import org.apache.commons.dbcp.BasicDataSource;
import org.apache.commons.dbutils.QueryRunner;

import rara.util.JDBCSupport;

import com.ibatis.sqlmap.client.SqlMapClient;

public class BulkCopy {

	/** Simple test harness. 
	 * @throws SQLException */
	public static void main(String... aArguments) throws IOException, SQLException {
		
		File testFile = new File("D:/workspace2/Data/src/rara/bulk/init.sql");
		
		// DataSource
//		BasicDataSource dataSource = new BasicDataSource();
//		dataSource.setDriverClassName("oracle.jdbc.driver.OracleDriver");
//		dataSource.setUrl("jdbc:oracle:thin:@localhost:1521:XE");
//		dataSource.setUsername("POUSER");
//		dataSource.setPassword("qwer1234");
		
		SqlMapClient targetClient = JDBCSupport.getSqlMapTargetInstance();
		DataSource dataSource =targetClient.getDataSource();
		
		QueryRunner run = new QueryRunner(dataSource);
		
		try {
			// use buffering, reading one line at a time
			// FileReader always assumes default encoding is OK!
			BufferedReader input = new BufferedReader(new FileReader(testFile));
			try {
				String sql = null; // not declared within while loop
				/*
				 * readLine is a bit quirky : it returns the content of a line
				 * MINUS the newline. it returns null only for the END of the
				 * stream. it returns an empty String if two newlines appear in
				 * a row.
				 */
				while ((sql = input.readLine()) != null) {
					if(sql.indexOf("INSERT INTO")>=0 || sql.indexOf("DELETE")>=0){
						run.update(sql.replaceAll(";", ""));
						System.out.println(sql);
					}
				}
			} finally {
				input.close();
			}
		} catch (IOException ex) {
			ex.printStackTrace();
		}

	}

}
