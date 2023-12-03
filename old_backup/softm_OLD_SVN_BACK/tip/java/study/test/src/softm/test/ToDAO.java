package softm.test;

import java.io.File;
import java.io.StringWriter;
import java.sql.SQLException;
import java.util.HashMap;
import java.util.List;
import java.util.Properties;

import org.apache.velocity.Template;
import org.apache.velocity.VelocityContext;
import org.apache.velocity.app.VelocityEngine;

import softm.util.JDBCSupport;
import softm.util.Util;

import com.ibatis.sqlmap.client.SqlMapClient;

public class ToDAO {
	final static String SAVE_DIRECTORY_NAME = "make_dao";
	
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws SQLException {
		
		String tableName = "TB_S07_020APRV020";
		String className = Util.toHungarian(tableName);
		String templatePath = "softm/template/sample_dao.vm";
		
//		SqlMapClient sourceClient = JDBCSupport.getSqlMapSourceInstance();
		SqlMapClient sourceClient = JDBCSupport.getSqlMapLocalInstance();
		
		HashMap<String, String> params = new HashMap<String, String>(); 
		params.put("value", tableName);
		List<HashMap<String, Object>> columnNameList = sourceClient.queryForList("Common.get_column_info",params);

		HashMap<String, String> params1 = new HashMap<String, String>(); 
		params1.put("value", tableName);
		List<HashMap<String, Object>> pkColumnList = sourceClient.queryForList("Common.get_column_info",params1);
		
		Properties p = new Properties();
		p.put("input.encoding" , "UTF-8");
		p.put("output.encoding", "UTF-8");
		p.put("resource.loader", "class");
		p.put("class.resource.loader.class", "org.apache.velocity.runtime.resource.loader.ClasspathResourceLoader");
		
		// first, get and initialize an engine
		VelocityEngine ve = new VelocityEngine();
		ve.init(p);
		
		// add that list to a VelocityContext
		VelocityContext context = new VelocityContext();
		
		context.put("tableName", tableName);
		context.put("className", className+"DAO");
		context.put("columnNameList", columnNameList);
		context.put("pkColumnList"  , pkColumnList  );
		// get the Template
		Template t = ve.getTemplate(templatePath);

		// now render the template into a Writer, here a StringWriter
		StringWriter writer = new StringWriter();
		t.merge(context, writer);
		String path = System.getProperty("user.dir");
		String savePath = path + File.separator + SAVE_DIRECTORY_NAME;
		
		if ( !Util.isDirectory(savePath) ) Util.makeDir(savePath);
//		Util.fileWrite(savePath + File.separator + Util.toHungarian(tableName) , writer.toString());
		System.out.println(writer.toString());
	}
	
}
