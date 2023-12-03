package com.have.service;
import java.io.File;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.ws.rs.Consumes;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.FormParam;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.Context;

import org.apache.commons.lang.StringUtils;
import org.codehaus.jettison.json.JSONObject;

import com.have.common.Base;
import com.have.common.Util;
import com.have.var.TABLE;

/**
 * <pre>
 *
 * Write  Date    : 2005-07-24
 * Update Date    : 2005-07-24
 * </pre>
 * @version  text : V1.0
 * @author   text : 김지훈
*/
@Path("/member")
public class Member extends Base {
    public Member (@Context HttpServletRequest req, @Context HttpServletResponse res) throws Exception {
		super(req, res);
    }

    @POST
    @Produces("text/html")
    @Path("login")
    public String login(@DefaultValue("") @QueryParam("p_user_id") String p_user_id,
                        @DefaultValue("") @QueryParam("p_passwd" ) String p_passwd  ) throws Exception {
        //@DefaultValue("search")
        //p_mode +
        Util.logger.info( "p_user_id / p_passwd " + p_user_id + " / " + p_passwd + "\n");
        String _rtn = "";
        if ( p_user_id.equals("") )  {
            _rtn = "ERROR|사용자아이디가 없습니다.";
        } else if ( p_passwd.equals("")  ) {
            _rtn = "ERROR|비밀번호가 없습니다.";
        } else {
            Connection          conn  = null;  // DataBase연결을 위한 Connection객체의 인스턴스
            PreparedStatement   pstmt = null;  // Statement  인스턴스
            Statement           stmt  = null;  // Statement  인스턴스
            ResultSet           rs    = null;  // ResultSet  인스턴스
            try {
                conn = getConnection();
                StringBuffer sql = new StringBuffer();
                sql.append(" SELECT  ");
                sql.append(" COUNT(*)");
                sql.append(" FROM " + TABLE.MEMBER);
                sql.append(" WHERE MEM_ID   =?");
                sql.append(" AND   PASSWD   =?");

                pstmt =conn.prepareStatement(sql.toString());
                pstmt.setString(1, p_user_id);
                pstmt.setString(2, p_passwd  );
                rs = pstmt.executeQuery();
                int cnt = 0;
                if ( rs.next() ) cnt = rs.getInt(1);
                sql = new StringBuffer();
                if ( cnt > 0) {
                    sql.append(" SELECT * ");
                    sql.append(" FROM " + TABLE.MEMBER);
                    sql.append(" WHERE MEM_ID ='"+ p_user_id + "'");
                    stmt = conn.createStatement();
                    rs  = stmt.executeQuery( sql.toString() );
                    if ( rs.next() ) {
                        if ( Util.fixNull(rs.getString("MEM_STATE") ).equals("0") ) {
                            setSession ( "user_id"      , Util.fixNull(rs.getString("MEM_ID"    ) ));
                            setSession ( "user_name"    , Util.fixNull(rs.getString("MEM_NAME"  ) ));
                            setSession ( "user_level"   , Util.fixNull(rs.getString("MEM_GB" ) ));
                            setSession ( "e_mail"       , Util.fixNull(rs.getString("EMAIL"     ) ));
                            setSession ( "login_yn"     , "Y"                                      );
                           _rtn = "SUCCESS|로그인에 성공하였습니다.";
                        } else {
                           _rtn = "ERROR|서비스가 불가능한 회원입니다.";
                        }
                    } else {}
                } else {
                    _rtn = "ERROR|로그인정보가 틀립니다.";
                }
            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
                try {
                    if ( conn != null ) { conn.close(); }   // Connection의 소멸
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
                conn = getConnection();
                StringBuffer sql = new StringBuffer();
                sql.append(" UPDATE " + TABLE.MEMBER );
                sql.append(" SET STATE = 'D' ");
                sql.append(" WHERE USER_ID = ?");
                pstmt =conn.prepareStatement(sql.toString());
                pstmt.setString(1, p_user_id);
                pstmt.executeUpdate();

            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
                try {
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
                conn = getConnection();
                StringBuffer sql = new StringBuffer();
                sql.append(" SELECT  ");
                sql.append(" COUNT(*)");
                sql.append(" FROM " + TABLE.MEMBER);
                sql.append(" WHERE MEM_ID = ?");

                pstmt =conn.prepareStatement(sql.toString());
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
                    if ( conn != null ) { conn.close(); }   // Connection의 소멸
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
  //@Consumes("multipart/form-data")
    @Produces("text/plain")
    //@Consumes("application/x-www-form-urlencoded")
    //@Multipart(value = "root", type = "application/octet-stream")
    public String write(@Context HttpServletRequest req, @Context HttpServletResponse res,
                           @FormParam("p_user_id") String p_user_id,@FormParam("file_image") File file
        //MultivaluedMap<String, String> formData
    ) throws Exception {
    	String p_mode  = StringUtils.defaultString(req.getParameter("p_mode"));
    	String user_id = StringUtils.defaultString(req.getParameter("user_id"));
    	if ( !p_mode.equals("") ) {
    		
    	}
    	Util.logger.info("user_id: " + user_id);
        return "SUCCESS|입력";
    }
    
    //@Consumes(MediaType.MULTIPART_FORM_DATA)
    @POST
    @Path("register")
    @Consumes("multipart/form-data")
    @Produces("text/plain")
    //@Consumes("application/x-www-form-urlencoded")
    //@Multipart(value = "root", type = "application/octet-stream")
    public String register(@Context HttpServletRequest req, @Context HttpServletResponse res,
                           @FormParam("p_user_id") String p_user_id,@FormParam("file_image") File file


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
    

    @POST
    @Produces("text/html")
    @Path("conversion_check")
    public String checkConversionInfor(@DefaultValue("") @QueryParam("p_user_name") String p_user_name,
                        @DefaultValue("") @QueryParam("p_jumin" ) String p_jumin  ) throws Exception {
        //@DefaultValue("search")
        //p_mode +
        Util.logger.info( "p_user_name / p_jumin " + p_user_name + " / " + p_jumin + "\n");
        String _rtn = "";
        if ( p_user_name.equals("") )  {
            _rtn = "ERROR|사용자이름이 없습니다.";
        } else if ( p_jumin.equals("")  ) {
            _rtn = "ERROR|주민번호가 없습니다.";
        } else {
            Connection          conn  = null;  // DataBase연결을 위한 Connection객체의 인스턴스
            PreparedStatement   pstmt = null;  // Statement  인스턴스
            Statement           stmt  = null;  // Statement  인스턴스
            ResultSet           rs    = null;  // ResultSet  인스턴스
            try {
                conn = getConnection();
                StringBuffer sql = new StringBuffer();
                sql.append(" SELECT  ");
                sql.append(" COUNT(*)");
                sql.append(" FROM " + TABLE.MEMBER);
                sql.append(" WHERE MEM_NAME =?");
                sql.append(" AND   JUMIN    =?");

                pstmt =conn.prepareStatement(sql.toString());
                pstmt.setString(1, p_user_name);
                pstmt.setString(2, p_jumin    );
                rs = pstmt.executeQuery();
                int cnt = 0;
                if ( rs.next() ) cnt = rs.getInt(1);
                sql = new StringBuffer();
                if ( cnt > 0) {
                    setSession ( "conversion_check", "Y");
                    setSession ( "conversion_name" , p_user_name);
                    setSession ( "conversion_jumin", p_jumin);
                   _rtn = "SUCCESS|전환 회원정보가 존재합니다.";
                } else {
                    setSession ( "conversion_01", "N");
                    _rtn = "ERROR|전환 회원정보가 없습니다.";
                }
            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
                try {
                    if ( conn != null ) { conn.close(); }   // Connection의 소멸
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
    
    /**
     * 회원정보  - 조회
     * @param page 회원번호(세션의값)
     * @return  조회데이터
     */
    @GET
    @Produces("application/json")
    @Path("get")
    public JSONObject get(
    		@QueryParam("mem_id") String mem_id
    ) throws Exception{
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            try {
                getConnection();
                jsr.put("return", "1"); // 실행
                StringBuffer sql = new StringBuffer();
                sql.append(" SELECT ")
                   .append(" MEM_ID       , ")
                   .append(" MEM_NAME     , ")
                   .append(" PASSWD       , ")
                   .append(" JUMIN        , ")
                   .append(" ZIPCODE      , ")
                   .append(" ADDR         , ")
                   .append(" ADDR_DETAIL  , ")
                   .append(" TEL          , ")
                   .append(" HP           , ")
                   .append(" EMAIL        , ")
                   .append(" BIRTH_GB     , ")
                   .append(" BIRTH        , ")
                   .append(" RECV_EMAIL_FG, ")
                   .append(" SCHOOL_NAME  , ")
                   .append(" SCHOOL_GRADE , ")
                   .append(" MEM_GB       , ")
                   .append(" MEM_STATE    , ")
                   .append(" AUTH_GB      , ")
                   .append(" PAR_ID       , ")
                   .append(" OUT_DATE     , ")
                   .append(" date_format(MOD_DATE,'%Y-%m-%d') MOD_DATE, ")
                   .append(" date_format(REG_DATE,'%Y-%m-%d') REG_DATE  ")
                   .append(" FROM " + TABLE.MEMBER)
                   .append(" WHERE MEM_ID = ? ")
                ;
                
                pstmt = conn.prepareStatement(sql.toString());
                pstmt.setString(1, loginInfo.memGb.equals("0")?mem_id:loginInfo.memId );

                JSONObject jso = new JSONObject();
                rs  = pstmt.executeQuery();
                if ( rs.next() ) {
                    jso.put("mem_id"                   , StringUtils.defaultString(rs.getString("MEM_ID"                   )));
                    jso.put("mem_name"                 , StringUtils.defaultString(rs.getString("MEM_NAME"                 )));
                    jso.put("passwd"                   , StringUtils.defaultString(rs.getString("PASSWD"                   )));
                    jso.put("jumin"                    , StringUtils.defaultString(rs.getString("JUMIN"                    )));
                    jso.put("zipcode"                  , StringUtils.defaultString(rs.getString("ZIPCODE"                  )));
                    jso.put("addr"                     , StringUtils.defaultString(rs.getString("ADDR"                     )));
                    jso.put("addr_detail"              , StringUtils.defaultString(rs.getString("ADDR_DETAIL"              )));
                    jso.put("tel"                      , StringUtils.defaultString(rs.getString("TEL"                      )));
                    jso.put("hp"                       , StringUtils.defaultString(rs.getString("HP"                       )));
                    jso.put("email"                    , StringUtils.defaultString(rs.getString("EMAIL"                    )));
                    jso.put("birth_gb"                 , StringUtils.defaultString(rs.getString("BIRTH_GB"                 )));
                    jso.put("birth"                    , StringUtils.defaultString(rs.getString("BIRTH"                    )));
                    jso.put("recv_email_fg"            , StringUtils.defaultString(rs.getString("RECV_EMAIL_FG"            )));
                    jso.put("school_name"              , StringUtils.defaultString(rs.getString("SCHOOL_NAME"              )));
                    jso.put("school_grade"             , StringUtils.defaultString(rs.getString("SCHOOL_GRADE"             )));
                    jso.put("mem_gb"                   , StringUtils.defaultString(rs.getString("MEM_GB"                   )));
                    jso.put("mem_state"                , StringUtils.defaultString(rs.getString("MEM_STATE"                )));
                    jso.put("auth_gb"                  , StringUtils.defaultString(rs.getString("AUTH_GB"                  )));
                    jso.put("par_id"                   , StringUtils.defaultString(rs.getString("PAR_ID"                   )));
                    jso.put("out_date"                 , StringUtils.defaultString(rs.getString("OUT_DATE"                 )));
                    jsr.put("data",jso);
                }
            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
                releaseConnection();
            }
        }
        return jsr;
    }
}