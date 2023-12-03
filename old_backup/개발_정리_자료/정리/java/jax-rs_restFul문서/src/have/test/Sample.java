package sample.test;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.ws.rs.Consumes;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.Response;

import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONException;
import org.codehaus.jettison.json.JSONObject;

import com.have.common.Util;
import com.have.datamodel.sample.SampleBean;
import com.have.datamodel.sample.SampleBeanArray;

// POJO, no interface no extends

//Sets the path to base URL + /hello

@Path("/sample/json")
public class Sample { 
	@GET
	@Produces("application/json")
    @Path("1")	
	public SampleBean getJson1() {
	  return new SampleBean("Agamemnon", 32);
	}
	
	@GET
	@Produces("application/json")
    @Path("2")
    // http://localhost:8080/hanlib/rest/sample/json/a
	public SampleBeanArray getJson2() {
		SampleBeanArray st = new SampleBeanArray();
		SampleBean b = new SampleBean("SATE", 32);
		st.getItem().add(b);
		st.getItem().add(b);
		st.getItem().add(b);
		st.getItem().add(b);
		st.getItem().add(b);
		st.getItem().add(b);
		return st;
	}
	
	@GET
	@Produces("application/json")
    @Path("3")
    // http://localhost:8080/hanlib/rest/sample/json/b
	public List<SampleBean> getJson3() {
		//SampleBeanArray st = new SampleBeanArray();
	    List<SampleBean> item = new ArrayList<SampleBean>();		
		SampleBean b = new SampleBean("SATE!!!!!!!!", 32);
		item.add(b);
		item.add(b);
		item.add(b);
		item.add(b);
		item.add(b);
		item.add(b);
		return item;
	}
	
	@GET
	@Produces("application/json")
    @Path("4")
    // http://localhost:8080/hanlib/rest/sample/json/b
	public JSONArray getJson4() throws JSONException {
        JSONArray jsa = new JSONArray();		
        JSONObject jso = new JSONObject();		
        jso.put("SATE1" , 32);
        jso.put("SATE2" , 32);
        jso.put("SATE3" , 32);
        jsa.put(jso);
        JSONObject jso2 = new JSONObject();		
        jso2.put("SATE1" , 32);
        jso2.put("SATE2" , 32);
        jso2.put("SATE3" , 32);
        jsa.put(jso2);
        return jsa;
	}
	
	@GET
	@Produces("application/json")
    @Path("5")
    // http://localhost:8080/hanlib/rest/sample/json/b
	public JSONArray getJson5() throws JSONException {
        JSONArray jsa = new JSONArray();		
        JSONObject jso = new JSONObject();		
        jso.put("SATE1" , 32);
        jso.put("SATE2" , 32);
        jso.put("SATE3" , 32);
        jsa.put(jso);
        JSONObject jso2 = new JSONObject();		
        jso2.put("SATE1" , 32);
        jso2.put("SATE2" , 32);
        jso2.put("SATE3" , 32);
        jsa.put(jso2);
        return jsa;
	}

	@GET
	@Produces("application/json")
    @Path("6")
    // http://localhost:8080/hanlib/rest/sample/json/b
	public List<SampleBean> getJson6() {
		//SampleBeanArray st = new SampleBeanArray();
	    List<SampleBean> item = new ArrayList<SampleBean>();		
		SampleBean b = new SampleBean("SATE!!!!!!!!", 32);
		item.add(b);
		item.add(b);
		item.add(b);
		item.add(b);
		item.add(b);
		item.add(b);
		return item;
	}

	
    @GET
    @Consumes("application/xml")
    @Path("7")
    public Response get(String content) {
        URI createdUri = null;
		try {
			createdUri = new URI("test.html");
		} catch (URISyntaxException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
        String createdContent = "<xml>aaaaaaaaa</xml>";
        return Response.ok("only xml").type("text/xml").build();
        //return Response.created(createdUri).entity(createdContent).build();
    }
    
    @GET
    @Consumes("application/json")
    @Path("8")
    public Response get1(String content) {
        URI createdUri = null;
		try {
			createdUri = new URI("test.html");
		} catch (URISyntaxException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
        String createdContent = "<xml>aaaaaaaaa</xml>";
        return Response.ok("only xml").type("text/json").build();
        //return Response.created(createdUri).entity(createdContent).build();
    }    
    

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
    Util.logger.info(path);
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