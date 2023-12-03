package rara.test;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileOutputStream;
import java.io.FileWriter;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.sql.SQLException;
import java.util.HashMap;
import java.util.List;

import org.apache.poi.hssf.usermodel.HSSFWorkbook;
import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.ss.usermodel.Row;
import org.apache.poi.ss.usermodel.Sheet;
import org.apache.poi.ss.usermodel.Workbook;

import rara.util.JDBCSupport;

import com.ibatis.sqlmap.client.SqlMapClient;

public class FileTest {

	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws IOException, SQLException {
		
		System.out.println("========== Table ==========");
		
		SqlMapClient client = JDBCSupport.getSqlMapTargetInstance();
		List<HashMap<String, Object>> result = client.queryForList("Common.findColumnComments");
		
		String file = "D:/test.csv";
		BufferedWriter out = new BufferedWriter(new OutputStreamWriter(new FileOutputStream( new File(file) ),"MS949"));
	
		
		for(HashMap<String, Object> row : result){
			System.out.println(row);
			out.write((String)row.get("COLUMN_NAME")+","+(String)row.get("COMMENTS"));
			out.newLine();
		}
		
		
		out.close();
	}

}
