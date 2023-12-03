package com.have.common;

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

import org.apache.commons.lang.StringUtils;

import com.have.datamodel.LoginBean;

// POJO, no interface no extends

//Sets the path to base URL + /hello

@Path("/aa")
@SuppressWarnings("unused")
public class Base {
	protected HttpSession session = null; // Session
	protected Connection          conn  = null;  // con
    protected PreparedStatement   pstmt = null;  // Statement
    protected Statement           stmt  = null;  // Statement
    protected ResultSet           rs    = null;  // ResultSet
    
    @Context
    protected HttpServletRequest request;
    @Context
    protected HttpServletResponse response;
    
    public LoginBean loginInfo = null;
    
    public Base (@Context HttpServletRequest req, @Context HttpServletResponse res) throws Exception {
        if ( session == null || session.isNew() )
        {
            session = req.getSession(true); // 새로운 Session을 얻음
        } else {
            session = req.getSession(false); // 기존 Session을 얻음
        }
    	this.loginInfo = getSession();
        //Print_HTTP_Infor (req) ;    	
    }

    protected LoginBean getSession() {
        LoginBean info = new LoginBean();
        info.memId        = StringUtils.defaultString((String)session.getAttribute("ss_mem_id"          ),""); // 사용자 아이디
        info.memName      = StringUtils.defaultString((String)session.getAttribute("ss_mem_name"        ),""); // 사용자 이름
        info.memGb        = StringUtils.defaultString((String)session.getAttribute("ss_mem_gb"          ),""); // 사용자 구분
        info.authGb       = StringUtils.defaultString((String)session.getAttribute("ss_auth_gb"         ),""); // 사용자 권한구분
        info.acId         = StringUtils.defaultString((String)session.getAttribute("ss_ac_id"           ),""); // 학원 아이디
        info.acName       = StringUtils.defaultString((String)session.getAttribute("ss_ac_name"         ),""); // 학원 이름
        info.acLogo       = StringUtils.defaultString((String)session.getAttribute("ss_ac_logo"         ),""); // 학원 로고
        info.acHomepage   = StringUtils.defaultString((String)session.getAttribute("ss_ac_homepage"     ),""); // 학원 홈페이지
        info.brchId       = StringUtils.defaultString((String)session.getAttribute("ss_brch_id"         ),""); // 지사 아이디
        info.brchName     = StringUtils.defaultString((String)session.getAttribute("ss_brch_name"       ),""); // 지사 이름
        info.solStep      = StringUtils.defaultString((String)session.getAttribute("ss_sol_step"        ),""); // 문제풀이단계
        info.dicGb        = StringUtils.defaultString((String)session.getAttribute("ss_dic_gb"          ),""); // 받아쓰기형태
        info.listenGb     = StringUtils.defaultString((String)session.getAttribute("ss_listen_gb"       ),""); // 듣기 형태
        info.enAnsGb      = StringUtils.defaultString((String)session.getAttribute("ss_en_ans_gb"       ),""); // 받아쓰기 정답 제공 유무
        info.koAnsGb      = StringUtils.defaultString((String)session.getAttribute("ss_ko_ans_gb"       ),""); // 한글 유무
        info.dicPassPoint = StringUtils.defaultString((String)session.getAttribute("ss_dic_pass_point"  ),""); // 합격률
        
        info.banId        = StringUtils.defaultString((String)session.getAttribute("ss_ban_id"  		),""); // 반아이디
        info.banName      = StringUtils.defaultString((String)session.getAttribute("ss_ban_name"  		),""); // 반명
        
        info.loginYn      = info.memId.equals("")?"N":"Y";
        info.adminYn      = info.memGb.equals("0")?"Y":"N";            
        return info;
    }

	protected Connection getConnection() throws NamingException{
        try {
         	//if ( conn == null ) {
	        	InitialContext ic = new InitialContext();
	            javax.naming.Context envContext = (javax.naming.Context)ic.lookup("java:/comp/env");
	            DataSource ds = (DataSource) envContext.lookup("jdbc/have");
	            conn = ds.getConnection();
	            //Util.logger.info("디비 연결됨 : " + this.conn.toString());
        	//} else {
	            //    Util.logger.fatal("this.conn.toString() : " + this.conn.toString());        	
	       //}
        } catch (SQLException ex) {
            Util.logger.fatal(Base.class.getName());
        }
        return conn;
    }

	protected Connection releaseConnection() throws NamingException{
        try {
            if ( this.conn != null ) { this.conn.close(); }   // Connection의 소멸
            if ( this.rs   != null ) { this.rs.close();   }   // ResultSet의  소멸
            if ( this.pstmt!= null ) { this.pstmt.close(); }   // Statement의  소멸
            if ( this.stmt != null ) { this.stmt.close(); }   // Statement의  소멸
            
        } catch (SQLException ex) {
            Util.logger.fatal(Base.class.getName());
        }
        return conn;
    }

    // System에 Server Session의 정보를 출력합니다.
	protected void Print_HTTP_Infor ( HttpServletRequest req ) {
/* */     
        Util.logger.info( "\n= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = \n" +
        "= Method             : "  + req.getMethod             () + "\n" +
        "= 접근 IP             : "  + req.getRemoteAddr         () + "\n" +
        "= Read Page          : "  + req.getRequestURI         () + "\n" +
        "= QueryString        : "  + req.getQueryString        () + "\n" +
        "= RequestedSessionId : "  + req.getRequestedSessionId () + "\n" +
        "= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = " );
    }
	
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