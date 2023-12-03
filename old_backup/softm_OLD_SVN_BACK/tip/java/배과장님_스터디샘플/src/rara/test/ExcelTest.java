package rara.test;

import java.io.FileOutputStream;
import java.io.IOException;
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

public class ExcelTest {

	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws IOException, SQLException {
		
		System.out.println("========== Table ==========");
		
		SqlMapClient client = JDBCSupport.getSqlMapTargetInstance();
		List<HashMap<String, Object>> result = client.queryForList("Common.findColumnComments");
		
		Workbook wb = new HSSFWorkbook();
		Sheet sheet = wb.createSheet("sheet1");
		
		int r=0;
		
		for(HashMap<String, Object> row : result){
			System.out.println(row);
			Row headerRow = sheet.createRow(r);
			
			Cell cell1 = headerRow.createCell(0);
			cell1.setCellValue((String)row.get("COLUMN_NAME"));
			
			Cell cell2 = headerRow.createCell(1);
			cell2.setCellValue((String)row.get("COMMENTS"));
			
			r++;
		}
		
		
		String file = "D:/test.csv";
		FileOutputStream out = new FileOutputStream(file);
		wb.write(out);
		out.close();
	}

}
