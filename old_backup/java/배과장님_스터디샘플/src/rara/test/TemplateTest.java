package rara.test;

import java.io.StringWriter;
import java.sql.SQLException;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Properties;

import org.apache.velocity.Template;
import org.apache.velocity.VelocityContext;
import org.apache.velocity.app.VelocityEngine;

import rara.util.JDBCSupport;

import com.ibatis.sqlmap.client.SqlMapClient;

public class TemplateTest {
	
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws SQLException {
		
		String tableName = "TB_S07_020WEEK010";
		String templatePath = "rara/template/sqlmap.vm";
		
		SqlMapClient sourceClient = JDBCSupport.getSqlMapSourceInstance();
		List<HashMap<String, Object>> columnNameList = sourceClient.queryForList("Common.findColumnInfo",tableName);
		
		Properties p = new Properties();
		p.put("input.encoding", "UTF-8");
		p.put("output.encoding", "UTF-8");
		p.put("resource.loader", "class");
		p.put("class.resource.loader.class", "org.apache.velocity.runtime.resource.loader.ClasspathResourceLoader");
		
		// first, get and initialize an engine
		VelocityEngine ve = new VelocityEngine();
		ve.init(p);
		
		// add that list to a VelocityContext
		VelocityContext context = new VelocityContext();
		
		context.put("tableName", tableName);
		context.put("columnNameList", columnNameList);
		
		// get the Template
		Template t = ve.getTemplate(templatePath);

		// now render the template into a Writer, here a StringWriter
		StringWriter writer = new StringWriter();
		t.merge(context, writer);
		 
		System.out.println(writer.toString());
	}
	
}
