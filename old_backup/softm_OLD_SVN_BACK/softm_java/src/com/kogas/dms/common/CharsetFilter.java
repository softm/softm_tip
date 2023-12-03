package com.kogas.dms.common;

/**
 **************************************************************
 * @sourceName  : CharsetFilter.java
 * ------------------------------------------------------------
 * DESCRIPTION  : encoding Filter
 **************************************************************
 * DATE         AUTHOR    HISTORY
 * ------------------------------------------------------------
 *   
 **************************************************************
 */

import java.io.IOException;

import javax.servlet.Filter;
import javax.servlet.FilterChain;
import javax.servlet.FilterConfig;
import javax.servlet.ServletException;
import javax.servlet.ServletRequest;
import javax.servlet.ServletResponse;

public class CharsetFilter implements Filter {

    private String encoding;

    //@Override 
    public void init(FilterConfig config) throws ServletException {
       
        encoding = config.getInitParameter("requestEncoding");
        if (encoding == null) {
//            encoding = "UTF-8";
            encoding = "UTF-8";
        }
       
    }

    //@Override
    public void destroy() {
    }

    //@Override
    public void doFilter(ServletRequest req, ServletResponse res,
            FilterChain filterChain) throws IOException, ServletException {
       
    	req.setCharacterEncoding(encoding);
    	res.setCharacterEncoding(encoding);
              
        res.setContentType("text/html;charset="+encoding); // 5.0�̻� 
       
        filterChain.doFilter(req, res);
    }
}

