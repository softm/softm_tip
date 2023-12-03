package com.kogas.dms.rest;
import java.io.File;
import java.net.URLDecoder;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import javax.ws.rs.Consumes;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.FormParam;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.Response;
import javax.ws.rs.core.Response.ResponseBuilder;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONException;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.Base;
import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Sql;
import com.kogas.dms.common.Util;
import com.kogas.dms.dao_basic.DmsCommonDAO;
import com.kogas.dms.var.TABLE;

/**
 * <pre>
 *
 * Write  Date    : 2005-07-24
 * Update Date    : 2005-07-24
 * </pre>
 * @version  text : V1.0
 * @author   text : 김지훈
*/

@Path("/common")
public class Common extends Base {
    private HttpSession session = null; // Session

    public Common (@Context HttpServletRequest req, @Context HttpServletResponse res) throws Exception {
		super(req, res);
    }

    // @Consumes("application/x-www-form-urlencoded")
	@POST
	@Produces("application/octet-stream")
	// @Consumes(MediaType.MULTIPART_FORM_DATA)
	// @Produces("application/json")
	@Path("download")
//	public Response download(@QueryParam("p_file") String fileName,@QueryParam("p_file_name") String realFName) throws Exception {
	public Response download(@FormParam("p_file") String fileName,@FormParam("p_file_name") String realFName) throws Exception {
		fileName = StringUtils.defaultString(fileName);
		realFName = StringUtils.defaultString(realFName);

		ResponseBuilder response;
		if ( fileName.equals("") || realFName.equals("") ) {
			response = Response.status(404);
		} else {
			File file = new File("D:\\WEB_APP\\eclipse_workspace\\work\\upload\\" + fileName);
			response = Response.ok((Object) file);
			response.header("Content-type","application/octet-stream;charset=UTF-8");
			response.header("Content-Disposition","attachment; filename="+URLDecoder.decode(realFName,"UTF-8"));
		}
		return response.build();	
	}
	
	// @Consumes("application/x-www-form-urlencoded")
	@POST
//	@Produces(MediaType.MEDIA_TYPE_WILDCARD)
	// @Consumes(MediaType.MULTIPART_FORM_DATA)
	// @Produces("application/json")
	@Path("save_download")
//	public Response saveDownload(@QueryParam("p_file") String realFName,@QueryParam("p_data") String data) throws Exception {
	public Response saveDownload(@FormParam("p_file") String realFName,@FormParam("p_data") String data) throws Exception {
		realFName = StringUtils.defaultString(realFName);
		data = StringUtils.defaultString(data);
		ResponseBuilder response;
		if ( realFName.equals("") || data.equals("") ) {
			response = Response.status(404);
		} else {
			response = Response.ok(
				"<html>" +
                "<head>" +
				"<META HTTP-EQUIVE='CONTENT-TYPE' CONTENT='TEXT/HTML; CHARSET=UTF-8'>" +
				"<body>" +
				 data +
				"</body>" +
				"</html>"
			);
//			response.header("Content-type","application/ms-excel;charset=EUC-KR");
//			response.header("Content-type","application/ms-excel;charset=KSC5601");
			response.header("Content-type","application/ms-excel;charset=UTF-8");
			response.header("Content-Disposition","attachment; filename="+Util.getFileNameByBrowser(realFName, Util.getBrowser(request)));
//			response.header("Content-Disposition","attachment; filename="+URLDecoder.decode(realFName,"KSC5601"));
//			response.header("Content-Disposition","attachment; filename="+realFName);
			Log.debug("Common - save_downloadx! : " + URLDecoder.decode(realFName,"UTF-8"));
		}
		return response.build();		
	}
	
    @POST
    @Produces("application/json")
    @Path("post_search")
    public JSONArray postSearch(@DefaultValue("") @FormParam("p_dong") String p_dong) throws Exception {
        //@DefaultValue("search")
        //p_mode +
        JSONArray jsa = new JSONArray();
        Util.logger.info( "p_dong  " + p_dong + "\n");
        String _rtn = "";
        if ( p_dong.length() < 2  )  {
            _rtn = "ERROR|동을 정확히 입력해주세요.";
        } else {

            Connection          conn  = null;  // DataBase연결을 위한 Connection객체의 인스턴스
            PreparedStatement   pstmt = null;  // Statement  인스턴스
            Statement           stmt  = null;  // Statement  인스턴스
            ResultSet           rs    = null;  // ResultSet  인스턴스
            try {
                StringBuffer sql = new StringBuffer();
                sql.append(" SELECT  ");
                sql.append(" *");
                sql.append(" FROM " + TABLE.TBL_POST);
                sql.append(" WHERE  AREA3 LIKE ?");
                pstmt =DBUtil.getConnection().prepareStatement(sql.toString());
                pstmt.setString(1, "%" + p_dong + "%");
                rs = pstmt.executeQuery();
                while ( rs != null && rs.next() ) {
                    try {
                        JSONObject jso = new JSONObject();
                        jso.put("ZIPCODE" , Util.fixNull(rs.getString("ZIPCODE" )));
                        jso.put("AREA1"    , Util.fixNull(rs.getString("AREA1"    )));
                        jso.put("AREA2"    , Util.fixNull(rs.getString("AREA2"    )));
                        jso.put("AREA3"    , Util.fixNull(rs.getString("AREA3"    )));
                        jso.put("AREA4"    , Util.fixNull(rs.getString("AREA4"    )));
                        jsa.put(jso);
                    } catch (JSONException ex) {
                        Util.logger.info( "p_dong ex : " + ex + "\n");
                    }
                }
            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
                try {
                	dbFinal();
                    if ( rs   != null ) { rs.close();   }   // ResultSet의  소멸
                    if ( pstmt != null ) { pstmt.close(); }   // Statement의  소멸
                    if ( stmt != null ) { stmt.close(); }   // Statement의  소멸
                }
                catch ( SQLException e ) {
                    throw new SQLException ("Error Code : " + e.toString());
                }
            }
        }
        return jsa;
    }

    // Session 변수를 할당 합니다.
    public void setSession ( String nm, String value  ) {
        if ( value != null && !value.equals("") )
        {
            session.setAttribute( nm, value );
        }
    }

    @GET
    @Produces("text/html")
    @Path("logout")
    public String logout() throws Exception {
        session.invalidate ();                      // Session을 무효화 함.
        return "SUCCESS|로그아웃";
    }

    @POST
    @Produces("text/html")
    @Path("secession")
    public String secession(@DefaultValue("") @FormParam("p_user_id") String p_user_id) throws Exception {
        Util.logger.info( "secession ::> p_user_id : " + p_user_id + "\n");

        String     loginYn   = session.getAttribute("login_yn"  )==null?"N":(String)session.getAttribute("login_yn"  );
        String     userId    = session.getAttribute("user_id"   )==null?"" :(String)session.getAttribute("user_id"   );
        System.out.println("userId : " + userId + "<BR>");
        String _rtn = "";

        if (loginYn.equals("Y") && !userId.equals("") && userId.equals(p_user_id)) {
            Connection          conn  = null;  // DataBase연결을 위한 Connection객체의 인스턴스
            PreparedStatement   pstmt = null;  // Statement  인스턴스
            try {
                dbInit();
                StringBuffer sql = new StringBuffer();
                sql.append(" UPDATE " + TABLE.TBL_MEMBER );
                sql.append(" SET STATE = 'D' ");
                sql.append(" WHERE USER_ID = ?");
                pstmt =DBUtil.getConnection().prepareStatement(sql.toString());
                pstmt.setString(1, p_user_id);
                pstmt.executeUpdate();

            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
                try {
                	dbFinal();
                    if ( conn  != null ) { conn.close();  }   // Connection의 소멸
                    if ( pstmt != null ) { pstmt.close(); }   // Statement의  소멸
                }
                catch ( SQLException e ) {
                    throw new SQLException ("Error Code : " + e.toString());
                }
            }
             _rtn = "SUCCESS|탈퇴-" + p_user_id + "|";
        } else {
             _rtn = "ERROR|탈퇴-" + p_user_id + "|";
        }
        session.invalidate ();                      // Session을 무효화 함.
        return _rtn;
    }

    @POST
    @Produces("text/html")
    @Path("check_realname")
    public String checkRealName(@DefaultValue("") @FormParam("p_user_name") String p_user_name,
                                @DefaultValue("") @FormParam("p_number"   ) String p_number
                                ) throws Exception {
        return "SUCCESS|실명인증";
    }

    @POST
    @Produces("text/html")
    @Path("dupcheck")
    public String dupcheck(@DefaultValue("") @FormParam("p_user_id") String p_user_id) throws Exception {
        //@DefaultValue("search")
        //p_mode +
        Util.logger.info( "p_user_id : " + p_user_id + "\n");
        String _rtn = "";
        if ( p_user_id.equals("") )  {
            _rtn = "ERROR|사용자아이디가 없습니다.";
        } else {
            Connection          conn  = null;  // DataBase연결을 위한 Connection객체의 인스턴스
            PreparedStatement   pstmt = null;  // Statement  인스턴스
            Statement           stmt  = null;  // Statement  인스턴스
            ResultSet           rs    = null;  // ResultSet  인스턴스
            try {
                dbInit();
                StringBuffer sql = new StringBuffer();
                sql.append(" SELECT  ");
                sql.append(" COUNT(*)");
                sql.append(" FROM " + TABLE.TBL_MEMBER);
                sql.append(" WHERE USER_ID  =?");

                pstmt =DBUtil.getConnection().prepareStatement(sql.toString());
                pstmt.setString(1, p_user_id);
                rs = pstmt.executeQuery();
                int cnt = 0;
                if ( rs.next() ) cnt = rs.getInt(1);
                sql = new StringBuffer();
                if ( cnt > 0) {
                    _rtn = "ERROR|중복된 아이디입니다.";
                } else {
                    _rtn = "SUCCESS|등록이 가능합니다.";
                }
            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
                try {
                	dbFinal();
                    if ( rs   != null ) { rs.close();   }   // ResultSet의  소멸
                    if ( pstmt != null ) { pstmt.close(); }   // Statement의  소멸
                    if ( stmt != null ) { stmt.close(); }   // Statement의  소멸
                }
                catch ( SQLException e ) {
                    throw new SQLException ("Error Code : " + e.toString());
                }
            }
        }
        return _rtn;
    }

    //@Consumes(MediaType.MULTIPART_FORM_DATA)
    @POST
    @Path("register")
    @Consumes("multipart/form-data")
    @Produces("text/plain")
    //@Consumes("application/x-www-form-urlencoded")
    //@Multipart(value = "root", type = "application/octet-stream")
    public String register(@Context HttpServletRequest req, @Context HttpServletResponse res


        //MultivaluedMap<String, String> formData
    ) throws Exception {
//        List<String> content = formData.get("p_user_id");

       // MultipartRequest multi=new MultipartRequest(req, Util.HOME_PATH + System.getProperty("file.separator") + "data", 1024 * 1024 * 1024, new DefaultFileRenamePolicy());
//String fileLocation = "/files/" + fcdsFile.getFileName();
//"?
//           File destFile = new File(file);
//        System.out.print("req p_user_id = " + req.getParameter("p_user_id") + "<BR>");
/*
        FileUploadMultipart multi = new FileUploadMultipart ( req,Util.HOME_PATH + System.getProperty("file.separator") + "data", 1024 * 1024 * 1024);
    multi.setParameter("file1_format", "date-format:yyyyMMddHHmmssS");
    multi.setParameter("file2_format", "date-format:yyyyMMddHHmmssS");
    multi.readRequest(); // 헤더 분석 실행
        java.util.Enumeration params = multi.getParameterNames();
        System.out.print("req p_user_id = " + req.getParameter("p_user_id") + "<BR>");
        System.out.print(" p_user_id = " + multi.getParameter("p_user_id") + "<BR>");
*/
/*
        while (params.hasMoreElements()) {
            String key   = (String)params.nextElement();
            String value = multi.getParameter(key);
            System.out.print(" key = " + key + " : " + multi.getParameter(key) + "<BR>");

            if (key.equals("name") ) {

            out.println(key + " Utility.getEucKrTo8859 = " + value + "<BR>");
            out.println(key + " Utility.getEucKrTo8859 = " + getParameter(String name) + "<BR>");
            out.println(key + " Utility.getEucKrTo8859 = " + Utility.toKo(multi.getParameter(key)) + "<BR>");
            out.println(key + " Utility.getEucKrTo8859 = " + Utility.toEucKr(multi.getParameter(key)) + "<BR>");
            out.println(key + " Utility.getEucKrTo8859 = " + Utility.to8859(multi.getParameter(key)) + "<BR>");
            out.println(key + " Utility.getEucKrTo8859 = " + Utility.getEucKrTo8859(multi.getParameter(key)) + "<BR>");
            out.println(key + " Utility.getEucKrTo8859 = " + Utility.getKSC5601To8859(multi.getParameter(key)) + "<BR>");
            out.println(key + " Utility.getEucKrTo8859 = " + Utility.get8859ToKSC5601(multi.getParameter(key)) + "<BR>");
            out.println(key + " Utility.getEucKrTo8859 = " + Utility.get8859ToEucKr(multi.getParameter(key)) + "<BR>");

            }
            //bdo_write.setValue (key, Util.fixNull(value));
        }
*/
        return "SUCCESS|실명인증";
    }

 /*
    @PUT
    public Response updateFoo(@Context Request request, Foo foo) {
        EntityTag tag = getCurrentTag();
        ResponseBuilder responseBuilder = request.evaluatePreconditions(tag);
        if (responseBuilder != null)
          return responseBuilder.build();
        else
          return doUpdate(foo);
    }
*/
}