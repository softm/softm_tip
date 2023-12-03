package kr.co.loan;

import java.util.Enumeration;

import org.apache.catalina.servlet4preview.http.HttpServletRequest;
import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;

import kr.co.loan.dto.AmmemberInfo;

@Controller
@EnableAutoConfiguration
public class SampleController {

   @RequestMapping("/")
   @ResponseBody
   String home() {
       return "Hello World!";
   }

/*   @RequestMapping( { "/{path1}/{path2}/{jspName}" })
   public String main(Model model, @PathVariable String path1, @PathVariable String path2, @PathVariable String jspName) {
	   model.addAttribute("name", "softm /");
	   System.out.println("---------------------------- " + path1 + "/" + path2 + "/" + jspName);
	   return path1 + "/" + path2 + "/" + jspName;
   }*/


   @RequestMapping( { "/{path1}/{jspName}.do" })
   public String main2(Model model, @PathVariable String path1, @PathVariable String jspName
		   ,HttpServletRequest request
		   ) {
	   model.addAttribute("name", "softm /");
	   System.out.println("---------------------------- " + path1 + "/" + jspName);
//	   세션정보 입니다
//	   이름     : ${sessionScope.ss_user.member_nm}
//	   사번     : ${sessionScope.ss_user.member_no}
//	   주민번호 : ${sessionScope.ss_user.member_idno}
//	   mac_add  : ${sessionScope.ss_user.member_mac}
//	   역할코드 : ${sessionScope.ss_user.role_cd}
//	   역할코드명 : ${sessionScope.ss_user.role_nm}

		AmmemberInfo ammemberinfo = new AmmemberInfo();
		ammemberinfo.setMember_no("99901");
		ammemberinfo.setMember_nm("홍길동");
		ammemberinfo.setDept_nm("홍길동의부서명");

		request.getSession().setMaxInactiveInterval(120000000);
		request.getSession().setAttribute("ss_user", ammemberinfo);
	   return "/" + path1 + "/" + jspName;
   }

   @RequestMapping( { "/{jspName}.do" })
   public String home1(Model model, @PathVariable String jspName,HttpServletRequest request) {
	   model.addAttribute("name", "softm /");

	   Enumeration<String> params = request.getParameterNames();
	   System.out.println("---------------------------- " + "/" + jspName);
//	   while (params.hasMoreElements()){
//	       String name = (String)params.nextElement();
//		   model.addAttribute(name, request.getParameter(name));
//	   }

//	   세션정보 입니다
//	   이름 : ${sessionScope.ss_user.member_nm}
//	   사번 : ${sessionScope.ss_user.member_no}
//	   주민번호 : ${sessionScope.ss_user.member_idno}
//	   mac_add : ${sessionScope.ss_user.member_mac}
//	   역할코드 : ${sessionScope.ss_user.role_cd}
//	   역할코드명 : ${sessionScope.ss_user.role_nm}

		AmmemberInfo ammemberinfo = new AmmemberInfo();
		ammemberinfo.setMember_no("99901");
		ammemberinfo.setMember_nm("홍길동");
		ammemberinfo.setDept_nm("홍길동의부서명");

		request.getSession().setMaxInactiveInterval(120000000);
		request.getSession().setAttribute("ss_user", ammemberinfo);

	   return jspName;
   }

   @RequestMapping("/helloWorld")
   public ModelAndView viewHelloWorld( Model model) {
	   //return "Hello World!";
	   ModelAndView mv = new ModelAndView();
	   mv.setViewName("helloWorld");
	   model.addAttribute("name", "softm");
	   return mv;
   }
}