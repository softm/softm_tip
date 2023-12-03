package com.kogas.dms.bean;

import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement
public class LoginBean {
      public String empNo            ; // 사용자 아이디          
      public String empNm            ; // 사용자 이름            
      public String authDivide       ; // 권한
      
      public String loginYn            ; // 로그인여부
      public String adminYn            ; // 관리자여부
      
      public LoginBean() {} // JAXB needs this

      public LoginBean(String empNo, String empNm, String authDivide) {
         this.empNo = empNo;
         this.empNm = empNm;
         this.authDivide = authDivide;
         this.loginYn = "N";
         this.adminYn = "N";
      }
}
