package com.have.datamodel;

import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement
public class LoginBean {
/*
      public String memId          ; // MEM_ID
      public String memName        ; // MEM_NAME
      public String memGb          ; // MEM_GB
      public String authGb         ; // AUTH_GB
      public int    acId           ; // AC_ID
      public int    brchId         ; // BRCH_ID
      public String acName         ; // AC_NAME
      public String acJoinGb       ; // AC_JOIN_GB
      public String banDicGb       ; // BAN_DIC_GB
      public String banListenGb    ; // BAN_LISTEN_GB
      public String banEnAnsGb     ; // BAN_EN_ANS_GB
      public String banKoAnsGb     ; // BAN_KO_ANS_GB
      public String banDicPassPoint; // BAN_DIC_PASS_POINT
      public String joinGb         ; // JOIN_GB
*/
      public String memId              ; // 사용자 아이디          
      public String memName            ; // 사용자 이름            
      public String memGb              ; // 사용자 구분            
      public String authGb             ; // 사용자 권한구분        
      public String acId               ; // 학원 아이디            
      public String acName             ; // 학원 이름              
      public String acLogo             ; // 학원 로고              
      public String acHomepage         ; // 학원 홈페이지          
      public String brchId             ; // 지사 아이디            
      public String brchName           ; // 지사 이름              
      public String solStep            ; // 문제풀이단계           
      public String dicGb              ; // 받아쓰기형태           
      public String listenGb           ; // 듣기 형태              
      public String enAnsGb            ; // 받아쓰기 정답 제공 유무
      public String koAnsGb            ; // 한글 유무              
      public String dicPassPoint       ; // 합격률
      
      public String loginYn            ; // 로그인여부
      public String adminYn            ; // 관리자여부
      
      public String banId			   ; // 반아이디
      public String banName			   ; // 반명
      
      public LoginBean() {} // JAXB needs this

      public LoginBean(String memId, String memName, String memGb) {
         this.memId = memId;
         this.memName = memName;
         this.memGb = memGb;
      }
}
