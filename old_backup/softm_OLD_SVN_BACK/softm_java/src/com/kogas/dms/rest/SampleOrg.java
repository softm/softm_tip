package com.kogas.dms.rest;
import javax.ws.rs.GET;
import javax.ws.rs.Produces;
import javax.ws.rs.Path;
import javax.ws.rs.core.Context;
//import javax.ws.rs.DefaultValue;
import javax.ws.rs.QueryParam;

import java.sql.Connection;
import java.sql.SQLException;
import javax.sql.DataSource;
//import java.util.logging.Logger;
import org.apache.log4j.Logger;

import javax.naming.InitialContext;
import javax.naming.NamingException;
import javax.servlet.http.*;

import java.util.HashMap;
import java.util.Map;
import javax.ws.rs.Consumes;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.PathParam;
import javax.ws.rs.core.Response;
import org.codehaus.jettison.json.JSONException;
import org.codehaus.jettison.json.JSONObject;
// The Java class will be hosted at the URI path "/helloworld"

@Path("/sample1")
public class SampleOrg {
    public static Logger logger;
    static {
        logger = Logger.getLogger("TestLog");
    }
    @SuppressWarnings("unused")
	private Member LoginInfo = null;
/**/
    @SuppressWarnings("unused")
	private Connection getConnection() throws NamingException{
        Connection con = null;
        try {
            InitialContext ic = new InitialContext();
            DataSource ds = (DataSource) ic.lookup("java:comp/env/jdbc/ipac");
            con = ds.getConnection();
        } catch (SQLException ex) {
            logger.fatal(SampleOrg.class.getName());
        }
        return con;
    }

    public SampleOrg(@Context HttpServletRequest req, @Context HttpServletResponse res) throws Exception{
        LoginInfo = new Member(req,res);
        System.out.print("test");
        //Map< String, String > pathMap = new HashMap< String, String >();
    }

    // The Java method will process HTTP GET requests
    // The Java method will produce content identified by the MIME Media
    // type "text/plain"
    //@GET

    @DefaultValue("L") @QueryParam("p_mode") String p_mode1;
    @GET
    @Produces("text/plan")
    public String getPlan() {
        //@DefaultValue("search")
        //p_mode +
        return p_mode1 + " / Hello World!";
    }

    @DefaultValue("L") @QueryParam("p_mode") String p_mode2;
    @GET
    @Produces("text/html")
    public String getHtml() {
        //@DefaultValue("search")
        //p_mode +
        return p_mode2 + " / Hello World!";
    }

    @GET
    //@Produces("text/plain")
    @Produces("application/json")
    @Consumes("text/plain")

    public JSONObject getJson() {
        JSONObject myObject = new JSONObject();
        try {
          myObject.put("name", "Agamemnon");
          myObject.put("age", 32);
        } catch (JSONException ex) {
            //LOGGER.log(Level.SEVERE, "Error ...", ex);
        }
        return myObject;
    }

/*
 Requesting http://localhost:8080/services/location/3, will return �쏬ocation: id=3��
Requesting http://localhost:8080/services/location/3/format/json, will return �� �쁫ocation��: { �쁦d��: ����} }��
 */
@GET
@Produces({"application/xml", "application/json", "plain/text"})
@Path("/location/{locationId}{path:.*}")
public Response getLocation(
  @PathParam("locationId") int locationId,
  @PathParam("path") String path) {
    logger.info(path);
 Map< String, String> params = parsePath(path);
 String format = params.get("format");
 if ("xml".equals(format)) {
  String xml = "<location></location><id></id>" + locationId + "";
  return Response.status(200).type("application/xml").entity(xml).build();
 } else if ("json".equals(format)) {
  String json = "{ 'location' : { 'id' : '" + locationId + "' } }";
  return Response.status(200).type("application/json").entity(json).build();
 } else {
  String text = "Location: id=" + locationId;
  return Response.status(200).type("text/plain").entity(text).build();
 }
}
    @Override
    protected void finalize() throws Throwable {
        super.finalize();
    }

private Map< String, String > parsePath(String path) {
 if (path.startsWith("/")) {
  path = path.substring(1);
 }
 String[] pathParts = path.split("/");
 Map< String, String > pathMap = new HashMap< String, String >();
 for (int i=0; i < pathParts.length/2; i++) {
  String key = pathParts[2*i];
  String value = pathParts[2*i+1];
  pathMap.put(key, value);
 }
 return pathMap;
}
/*
Requesting http://localhost:8080/services/user/3, will return �쏯o format specified. No encoding specified��
Requesting http://localhost:8080/services/user/3/format/pdf/encoding/utf8, will return �쏤ormat=pdf Encoding=utf8��
Requesting http://localhost:8080/services/user/3/encoding/utf8, will return �쏯o format specified. Encoding=utf8��
 */
 @GET
 @Path("/user/{id}{format:(/format/[^/]+?)?}{encoding:(/encoding/[^/]+?)?}")
 public Response getUser(
   @PathParam("id") int id,
   @PathParam("format") String format,
   @PathParam("encoding") String encoding) {
  String responseText = "";

 if (format.equals("")) {
   // Optional parameter "format" not specified
   responseText += "No format specified.";
  } else {
   // Optional parameter "format" has looks like "/format/pdf" -> get it's value only
   format = format.split("/")[2];
   responseText += "Format=" + format;
  }

 if (encoding.equals("")) {
   // Optional parameter "encoding" not specified
   responseText += " No encoding specified";
  } else {
   // Optional parameter "encoding" has looks like "/encoding/utf8" -> get it's value only
   encoding = encoding.split("/")[2];
   responseText += " Encoding=" + encoding;
  }

 return Response.status(200).type("text/plain").entity(responseText).build();
 }
}
