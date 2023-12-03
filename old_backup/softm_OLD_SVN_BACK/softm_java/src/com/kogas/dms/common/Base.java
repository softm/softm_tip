package com.kogas.dms.common;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import javax.naming.InitialContext;
import javax.naming.NamingException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import javax.sql.DataSource;
import javax.ws.rs.GET;
import javax.ws.rs.Path; 
import javax.ws.rs.Produces;
import javax.ws.rs.WebApplicationException;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.Response;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;

import com.kogas.dms.bean.LoginBean;

// POJO, no interface no extends

//Sets the path to base URL + /hello

@Path("/aa")
@SuppressWarnings("unused")
public class Base {
	protected HttpSession session = null; // Session
    protected PreparedStatement   pstmt = null;  // Statement
    protected Statement           stmt  = null;  // Statement
    protected ResultSet           rs    = null;  // ResultSet
    
    @Context
	protected HttpServletRequest request;
    @Context
    protected HttpServletResponse response;
    
    protected Logger Log = Util.logger;
    public LoginBean loginInfo = null;
    
    public Base (@Context HttpServletRequest req, @Context HttpServletResponse res) throws Exception {
        if ( session == null || session.isNew() )
        {
            session = req.getSession(true); // 새로운 Session을 얻음
        } else {
            session = req.getSession(false); // 기존 Session을 얻음
        }
    	this.loginInfo = getLoginInfor();
//    	this.loginInfo.loginYn = "Y";
//    	this.loginInfo.empNm = "사용자";
//    	this.loginInfo.empNo = "1";
        Print_HTTP_Infor (req) ;    	
    }

    protected LoginBean getLoginInfor() {
        LoginBean info = new LoginBean();
        info.empNo        = StringUtils.defaultString((String)session.getAttribute("EMP_NO"          ),""); // 사용자 아이디
        info.empNm        = StringUtils.defaultString((String)session.getAttribute("EMP_NM"          ),""); // 사용자 이름
        info.authDivide   = StringUtils.defaultString((String)session.getAttribute("AUTH_DIVIDE"     ),""); // 권한
        info.loginYn      = StringUtils.defaultString((String)session.getAttribute("LOGIN_YN"        ),"N"); // 로그인 구분
        info.adminYn      = StringUtils.defaultString((String)session.getAttribute("ADMIN_YN"        ),"N"); // 관리자 구분
        return info;
    }
    
    public String getSession ( String nm ) {
    	return StringUtils.defaultString((String)session.getAttribute(nm),"");            
    }
    
    public void setSession ( String nm, String value  ) {
    	if ( value != null && !value.equals("") )
    	{
    		session.setAttribute( nm, value );
    	}
    }
    
	protected void dbInit() throws NamingException{
		DBUtil.init();
    }

	protected void dbFinal() {
        try {
			DBUtil.end();
            if ( this.rs   != null ) { this.rs.close();   }   // ResultSet의  소멸
            if ( this.pstmt!= null ) { this.pstmt.close(); }   // Statement의  소멸
            if ( this.stmt != null ) { this.stmt.close(); }   // Statement의  소멸
            
        } catch (SQLException ex) {
            Util.logger.fatal(Base.class.getName());
        }
    }

    // System에 Server Session의 정보를 출력합니다.
	protected void Print_HTTP_Infor ( HttpServletRequest req ) {
/*      
        Util.logger.info( "\n= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = \n" +
        "= Method             : "  + req.getMethod             () + "\n" +
        "= 접근 IP             : "  + req.getRemoteAddr         () + "\n" +
        "= Read Page          : "  + req.getRequestURI         () + "\n" +
        "= QueryString        : "  + req.getQueryString        () + "\n" +
        "= RequestedSessionId : "  + req.getRequestedSessionId () + "\n" +
        "= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = " );
*/    }
	
    /*@GET
    @Produces("text/html")
    public void init(@Context HttpServletRequest req, @Context HttpServletResponse res) throws Exception {
    	res.sendRedirect("/");
    	//System.out.println("SSSSSSSSSSSSSSSSSSSSSS");
    	//return Response.status(Response.Status.BAD_REQUEST).build();     	
    }*/
    
    @GET
    @Produces("text/html")
    public Response init(@Context HttpServletRequest req, @Context HttpServletResponse res) throws Exception {
    	//res.sendRedirect("/");
    	//System.out.println("SSSSSSSSSSSSSSSSSSSSSS");
    	//return Response.status(Response.Status.NOT_FOUND).build();
    	throw new WebApplicationException(Response.Status.UNAUTHORIZED);	
    }
}