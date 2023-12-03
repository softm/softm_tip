package com.kogas.dms.common;

import java.io.File;
import java.util.ArrayList;

import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONException;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.dao.DmsSendMailDAO;

public class SendMail {
	private String sendMailAdd 	= "pjd1018@kogas.or.kr";									// 보내는 메일 주소(기획예산팀  박종덕 대리)
	private String receiveMailList = "choisj@kogas.or.kr,pjd1018@kogas.or.kr";		// 관리자 메일 주소(기획예산팀  최성재 과장, 박종덕 대리)
	//private DmsSendMailDAO dao = new DmsSendMailDAO();
	
	//개최공지 메일
	public void sendMailMeetingNotice(int scheduleNo) throws Exception{
		
		JSONObject jsr = new JSONObject();
		JSONArray jsa = new JSONArray();
		
		DmsSendMailDAO dao = new DmsSendMailDAO();
		
		jsr = dao.getMeetingNoticInfo(scheduleNo);
		jsa = dao.getSendMailList();									//상임이사 및 비상임이사 본사 본부장 메일 주소를 얻어 옴
		StringBuffer mailTo = new StringBuffer("");
		
		//경영위원회일 경우 상임이사와 본사 본부장만 보낼 메일 주소로 설정 함
		for(int i=0; i<jsa.length(); i++){
			JSONObject mailList = new JSONObject();
			mailList = jsa.getJSONObject(i);
			
			if("경영위원회".equals(jsr.getString("bd_name"))){
				if("10".equals(mailList.getString("bd_code")))
					mailTo.append(mailList.getString("email")).append(",");
			}else{
				mailTo.append(mailList.getString("email")).append(",");
			}
		}
		mailTo.substring(0, mailTo.length()-1);
		
		String mailContent = mailTemplateMeetingNotice(jsr);
		String mailSubject = "제" + jsr.getInt("bd_no") + "회 " + jsr.getString("gubun_name") + " " + jsr.getString("bd_name") + " 개최공지";
		
		MailUtil mail = new MailUtil();
		mail.send(sendMailAdd,"daekwonkim9@gmail.com,sucktolha@naver.com", mailSubject, mailContent);
//		mail.send(sendMailAdd,mailTo.toString(), mailSubject, mailContent);
	}
	
	//개최공지 메일 Template
	public String mailTemplateMeetingNotice(JSONObject info){
		StringBuffer sb = new StringBuffer();
		
		try{
			sb.append(" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> ").append("\n");
			sb.append(" <html xmlns='http://www.w3.org/1999/xhtml'> ").append("\n");
			sb.append(" <head> ").append("\n");
			sb.append(" <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> ").append("\n");
			sb.append(" <title>이사회업무관리시스템</title> ").append("\n");
			sb.append(" </head> ").append("\n");
			sb.append(" <body> ").append("\n");
			sb.append(" <div style='width: 500px; border-style: solid; border-width: 1px; border-color: #BBB;'> ").append("\n");
			sb.append(" 	<table width='100%' border='0'> ").append("\n");
			sb.append(" 		<tr  height='24px'> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 			<td colspan='2'></td> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB; padding-right: 5px;'>▣</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr> ").append("\n");
			sb.append(" 			<td colspan='4' style='font-family: 맑은고딕; font-size: 18px; font-weight: bolder; text-align: center;'> ").append("\n");
			sb.append(" 				개최공지 ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr  height='20px'> ").append("\n");
			sb.append(" 			<td colspan='4'> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='30px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
			sb.append(" 				<p>제 "+info.getInt("bd_no") + "회 " + info.getString("gubun_name") + " " + info.getString("bd_name")+"를 "+info.getString("bd_start_date")+"("+info.getString("bd_start_day")+")에 개최할 예정입니다.</p> ").append("\n");
			sb.append(" 				<p>의결이 필요한 안건이 있으면 등록해 주시기 바랍니다.</p> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='30px;'> ").append("\n");
			sb.append(" 			<td colspan='4'> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
			sb.append(" 				제 "+info.getInt("bd_no") + "회 " + info.getString("gubun_name") + " " + info.getString("bd_name")).append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 개 &nbsp;최 일 : "+info.getString("bd_start_date")+"("+info.getString("bd_start_day")+") ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 개최시간 : "+info.getString("bd_time")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 개최장소 : "+info.getString("bd_place")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='24px'> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 			<td colspan='2'></td> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 	</table> ").append("\n");
			sb.append(" </div> ").append("\n");
			sb.append(" </body> ").append("\n");
			sb.append(" </html> ").append("\n");
		} catch (JSONException e) {
			e.printStackTrace();
		}
		return sb.toString();
	}
	
	//소집통보 메일
		public void sendMailConvocationNotification(int scheduleNo, String furtherInfo, String notice) throws Exception{
			
			JSONObject jsr = new JSONObject();
			JSONArray jsa = new JSONArray();
			JSONArray itemInfo = new JSONArray();
			
			DmsSendMailDAO dao = new DmsSendMailDAO();
			
			jsr = dao.getMeetingNoticInfo(scheduleNo);
			jsa = dao.getSendMailList();									//상임이사 및 비상임이사 본사 본부장 메일 주소를 얻어 옴
			itemInfo = dao.getItemInfoList(scheduleNo);
			StringBuffer mailTo = new StringBuffer("");
			
			//경영위원회일 경우 상임이사와 본사 본부장만 보낼 메일 주소로 설정 함
			for(int i=0; i<jsa.length(); i++){
				JSONObject mailList = new JSONObject();
				mailList = jsa.getJSONObject(i);
				
				if("경영위원회".equals(jsr.getString("bd_name"))){
					if("10".equals(mailList.getString("bd_code")))
						mailTo.append(mailList.getString("email")).append(",");
				}else{
					mailTo.append(mailList.getString("email")).append(",");
				}
			}
			mailTo.substring(0, mailTo.length()-1);
						
			String mailContent = mailTemplateConvocationNotification(jsr, itemInfo, furtherInfo, notice);
			String mailSubject = "제" + jsr.getInt("bd_no") + "회 " + jsr.getString("gubun_name") + " " + jsr.getString("bd_name") + " 소집통보";
			
			MailUtil mail = new MailUtil();
			mail.send(sendMailAdd,"daekwonkim9@gmail.com,sucktolha@naver.com", mailSubject, mailContent);
//			mail.send(sendMailAdd,mailTo.toString(), mailSubject, mailContent);
		}
		
		//소집통보 메일 Template
		public String mailTemplateConvocationNotification(JSONObject  scheduleInfo, JSONArray itemInfo, String furtherInfo, String notice){
			StringBuffer sb = new StringBuffer();
			String[] hanSeq = {"가","나", "다", "라", "마", "바", "사", "아", "자", "차", "카", "타", "파", "하"};
			try{
				sb.append(" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> ").append("\n");
				sb.append(" <html xmlns='http://www.w3.org/1999/xhtml'> ").append("\n");
				sb.append(" <head> ").append("\n");
				sb.append(" <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> ").append("\n");
				sb.append(" <title>이사회업무관리시스템</title> ").append("\n");
				sb.append(" </head> ").append("\n");
				sb.append(" <body> ").append("\n");
				sb.append(" <div style='width: 800px; border-style: solid; border-width: 1px;'> ").append("\n");
				sb.append(" 	<table width='100%' border='0'> ").append("\n");
				sb.append(" 		<tr  height='40px'> ").append("\n");
				sb.append(" 			<td colspan='3'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr> ").append("\n");
				sb.append(" 			<td colspan='3' style='text-align: center;'> ").append("\n");
				sb.append(" 				<span style='font-family: 맑은고딕; font-size: 25pt; font-weight: bolder;text-decoration: underline;'>이사회 소집 통지서</span> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr  height='40px'> ").append("\n");
				sb.append(" 			<td colspan='3'> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 15pt;font-weight: bolder;'>수  신 : 각 이사</td> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='20px;'> ").append("\n");
				sb.append(" 			<td colspan='3'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 14pt;'>제 "+scheduleInfo.getInt("bd_no")+"회 "+scheduleInfo.getString("gubun_name")+" "+scheduleInfo.getString("bd_name")+"를 다음과 같이 개최하오니 참석하여 주시기 바랍니다.</td> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='20px;'> ").append("\n");
				sb.append(" 			<td colspan='3'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 14pt;'><span style='font-weight: bolder;'>1. 일 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;시 : </span>"+scheduleInfo.getString("bd_start_date")+"("+scheduleInfo.getString("bd_start_day")+") "+scheduleInfo.getString("bd_time")+"</td> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 14pt;'><span style='font-weight: bolder;'>2.  장 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소 : </span>"+scheduleInfo.getString("bd_place")+"</td> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 14pt;'><span style='font-weight: bolder;'>3. 의결 및 보고사항</span></td> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				for(int i=0; i<itemInfo.length(); i++){
					if("1010".equals(itemInfo.getJSONObject(i).getString("item_devision"))){
						sb.append(" 		<tr height='30px;'> ").append("\n");
						sb.append(" 			<td width='15px'></td> ").append("\n");
						sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12pt;'> ").append("\n");
						sb.append(" 				&nbsp;&nbsp;&nbsp;<span style='font-weight: bolder;'>"+hanSeq[i]+". 제 "+((i<9)?"&nbsp;"+(i+1):(i+1))+"호 : "+itemInfo.getJSONObject(i).getString("item_name")+"</span> ").append("\n");
						sb.append(" 			<td> ").append("\n");
						sb.append(" 			<td width='15px'></td> ").append("\n");
						sb.append(" 		</tr> ").append("\n");
					}else{
						sb.append(" 		<tr height='30px;'> ").append("\n");
						sb.append(" 			<td width='15px'></td> ").append("\n");
						sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12pt;'> ").append("\n");
						sb.append(" 				&nbsp;&nbsp;&nbsp;"+hanSeq[i]+". 제 "+((i<9)?"&nbsp;"+(i+1):(i+1))+"호 : "+itemInfo.getJSONObject(i).getString("item_name")+" ").append("\n");
						sb.append(" 			<td> ").append("\n");
						sb.append(" 			<td width='15px'></td> ").append("\n");
						sb.append(" 		</tr> ").append("\n");
					}
				}
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 14pt;'><span style='font-weight: bolder;'>4. 기타사항</span></td> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12pt;'> ").append("\n");
				sb.append(" 				&nbsp;&nbsp;&nbsp;"+furtherInfo+" ").append("\n");
				sb.append(" 			<td> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td colspan='3'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 14pt;font-weight: bolder;'>※ <span style='text-decoration: underline;'>"+notice+" ").append("\n");
				sb.append(" </span></td> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td colspan='3'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 			<td align='right' style='font-family: 맑은고딕;font-size: 18pt;font-weight: bolder;'> ").append("\n");
				sb.append(" 				2010. 6. 23. &nbsp;&nbsp;&nbsp;&nbsp;</td> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='60px;' valign='middle'> ").append("\n");
				sb.append(" 			<td width='15px'></td> ").append("\n");
				sb.append(" 			<td align='right' style='font-family: 맑은고딕;font-size: 18pt;'> ").append("\n");
				sb.append(" 				한국가스공사 이사회 의장  ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='15px'> ").append("\n");
				sb.append(" 				<img src='http://localhost:7027/images/seal.jpg' style='position: relative; top: -12px;'/> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td colspan='3'> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 	</table> ").append("\n");
				sb.append(" </div> ").append("\n");
				sb.append(" </body> ").append("\n");
				sb.append(" </html> ").append("\n");
			} catch (JSONException e) {
				e.printStackTrace();
			}
			return sb.toString();
		}
	
	//안건 반려 메일
	public void sendMailReturn(int itemNo, String returnReason) throws Exception{
		
		JSONObject info = new JSONObject();
		DmsSendMailDAO dao = new DmsSendMailDAO();
		
		info = dao.getReturnMailInfo(itemNo);
		
		String mailContent = mailTemplateReturn(info, returnReason);
		String mailSubject = "제" + info.getInt("bd_no") + "회 " + info.getString("gubun_name") + " " + info.getString("bd_name") +  " '"+info.getString("item_name")+"' 안건 반려";
		
		MailUtil mail = new MailUtil();
		mail.send(sendMailAdd, "sucktolha@naver.com", mailSubject, mailContent);
//		mail.send(sendMailAdd, info.getEMAIL(), mailSubject, mailContent);
	}
	
	//안건 반려 메일 Template
	public String mailTemplateReturn(JSONObject info, String returnReason){
		StringBuffer sb = new StringBuffer();
		try {
			sb.append(" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> ").append("\n");
			sb.append(" <html xmlns='http://www.w3.org/1999/xhtml'> ").append("\n");
			sb.append(" <head> ").append("\n");
			sb.append(" <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> ").append("\n");
			sb.append(" <title>이사회업무관리시스템</title> ").append("\n");
			sb.append(" </head> ").append("\n");
			sb.append(" <body> ").append("\n");
			sb.append(" <div style='width: 500px; border-style: solid; border-width: 1px; border-color: #BBB;'> ").append("\n");
			sb.append(" 	<table width='100%' border='0'> ").append("\n");
			sb.append(" 		<tr  height='24px'> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 			<td colspan='2'></td> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB; padding-right: 5px;'>▣</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr> ").append("\n");
			sb.append(" 			<td colspan='4' style='font-family: 맑은고딕; font-size: 18px; font-weight: bolder; text-align: center;'> ").append("\n");
			sb.append(" 				안건 반려 ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr  height='20px'> ").append("\n");
			sb.append(" 			<td colspan='4'> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='30px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
			sb.append(" 				<p>제 "+ info.getInt("bd_no") + "회 " + info.getString("gubun_name") + " " + info.getString("bd_name") +  " '"+info.getString("item_name")+"' 안건을 아래과 같은 사유로 반려합니다.</p> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='30px;'> ").append("\n");
			sb.append(" 			<td colspan='4'> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
			sb.append(" 				제 "+info.getInt("bd_no") + "회 " + info.getString("gubun_name") + " " + info.getString("bd_name")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 의 &nbsp;안 명 : "+info.getString("item_name")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 담 &nbsp;당 자 : "+info.getString("ename")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 담당부서 : "+info.getString("stext")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 반려사유 ").append("\n");
			sb.append(" 				<div style='padding-left:15px;width:420px;'>: "+returnReason+"</div> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='24px'> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 			<td colspan='2'></td> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 	</table> ").append("\n");
			sb.append(" </div> ").append("\n");
			sb.append(" </body> ").append("\n");
			sb.append(" </html> ").append("\n");
		} catch (JSONException e) {
			e.printStackTrace();
		}
		return sb.toString();
	}
	
	//안건 제출 메일
	public void sendMailItemSubmission(int itemNo) throws Exception{
		
		JSONObject info = new JSONObject();
		
		DmsSendMailDAO dao = new DmsSendMailDAO();
		
		info = dao.getReturnMailInfo(itemNo);
		
		String mailContent = mailTemplateItemSubmission(info);
		String mailSubject = "제" + info.getInt("bd_no") + "회 " + info.getString("gubun_name") + " " + info.getString("bd_name") +  " '"+info.getString("item_name")+"' 안건 제출";
		
		MailUtil mail = new MailUtil();
		mail.send(sendMailAdd, "sucktolha@naver.com", mailSubject, mailContent);
//		mail.send(info.getEMAIL(), receiveMailList,mailSubject, mailContent);
	}
	
	//안건 제출 메일 Template
	public String mailTemplateItemSubmission(JSONObject info){
		StringBuffer sb = new StringBuffer();
		
		try{
			sb.append(" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> ").append("\n");
			sb.append(" <html xmlns='http://www.w3.org/1999/xhtml'> ").append("\n");
			sb.append(" <head> ").append("\n");
			sb.append(" <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> ").append("\n");
			sb.append(" <title>이사회업무관리시스템</title> ").append("\n");
			sb.append(" </head> ").append("\n");
			sb.append(" <body> ").append("\n");
			sb.append(" <div style='width: 500px; border-style: solid; border-width: 1px; border-color: #BBB;'> ").append("\n");
			sb.append(" 	<table width='100%' border='0'> ").append("\n");
			sb.append(" 		<tr  height='24px'> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 			<td colspan='2'></td> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB; padding-right: 5px;'>▣</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr> ").append("\n");
			sb.append(" 			<td colspan='4' style='font-family: 맑은고딕; font-size: 18px; font-weight: bolder; text-align: center;'> ").append("\n");
			sb.append(" 				안건 제출 ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr  height='20px'> ").append("\n");
			sb.append(" 			<td colspan='4'> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='30px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
			sb.append(" 				<p>제 "+info.getInt("bd_no") + "회 " + info.getString("gubun_name") + " " + info.getString("bd_name")+"에 아래과 같이 안건이 제출되었음을 알려 드립니다.</p> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='30px;'> ").append("\n");
			sb.append(" 			<td colspan='4'> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
			sb.append(" 				제 "+info.getInt("bd_no") + "회 " + info.getString("gubun_name") + " " + info.getString("bd_name")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 의 &nbsp;안 명 : "+info.getString("item_name")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 담 &nbsp;당 자 : "+info.getString("ename")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 담당부서 : "+info.getString("stext")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='24px'> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 			<td colspan='2'></td> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 	</table> ").append("\n");
			sb.append(" </div> ").append("\n");
			sb.append(" </body> ").append("\n");
			sb.append(" </html> ").append("\n");
		} catch (JSONException e) {
			e.printStackTrace();
		}
		
		return sb.toString();
	}
	
	//이사 요청자료 요청 메일
	public void sendMailDataRequest(int reqNo, String deptCd) throws Exception{
		
		JSONObject info = new JSONObject();
		JSONArray jsa = new JSONArray();
		
		DmsSendMailDAO dao = new DmsSendMailDAO();
		
		info = dao.getRequestInfo(reqNo);
		jsa = dao.getSendMailAddressList(deptCd);			//이사요청자료 요청할 부서원들의 메일 주소 정보를 가져옴
		StringBuffer mailTo = new StringBuffer("");
		
		//이사요청자료 요청할 부서원들의 메일 주소
		for(int i=0; i<jsa.length(); i++){
			JSONObject mailList = new JSONObject();
			mailList = jsa.getJSONObject(i);
			
			mailTo.append(mailList.getString("email")).append(",");
		}
		mailTo.substring(0, mailTo.length()-1);
		
		String mailContent = mailTemplateDataRequest(info);
		String mailSubject = info.getString("req_subject")+"' 요청자료 요청";
		
		MailUtil mail = new MailUtil();
		mail.send(sendMailAdd, "sucktolha@naver.com", mailSubject, mailContent);
//		mail.send(sendMailAdd, mailTo.toString(), mailSubject, mailContent);
	}
	
	//이사 요청자료 요청 메일 Template
	public String mailTemplateDataRequest(JSONObject info){
		StringBuffer sb = new StringBuffer();
		
		try{
			sb.append(" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> ").append("\n");
			sb.append(" <html xmlns='http://www.w3.org/1999/xhtml'> ").append("\n");
			sb.append(" <head> ").append("\n");
			sb.append(" <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> ").append("\n");
			sb.append(" <title>이사회업무관리시스템</title> ").append("\n");
			sb.append(" </head> ").append("\n");
			sb.append(" <body> ").append("\n");
			sb.append(" <div style='width: 500px; border-style: solid; border-width: 1px; border-color: #BBB;'> ").append("\n");
			sb.append(" 	<table width='100%' border='0'> ").append("\n");
			sb.append(" 		<tr  height='24px'> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 			<td colspan='2'></td> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB; padding-right: 5px;'>▣</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr> ").append("\n");
			sb.append(" 			<td colspan='4' style='font-family: 맑은고딕; font-size: 18px; font-weight: bolder; text-align: center;'> ").append("\n");
			sb.append(" 				요청자료 요청 ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr  height='20px'> ").append("\n");
			sb.append(" 			<td colspan='4'> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='30px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
			sb.append(" 				<p>"+info.getString("ko_name")+" 이사님께서 "+info.getString("req_subject")+"에 대해서 자료요청 하였습니다. 확인 후 작성해 주시기 바랍니다.</p> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='30px;'> ").append("\n");
			sb.append(" 			<td colspan='4'> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
			sb.append(" 				"+info.getString("req_subject")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 이 &nbsp;사 명 : "+info.getString("ko_name")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 관련안건 : "+info.getString("item_name")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 담당부서 : "+info.getString("charge_dept_nm")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 마 &nbsp;감 일 : "+info.getString("end_date")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='24px'> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 			<td colspan='2'></td> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 	</table> ").append("\n");
			sb.append(" </div> ").append("\n");
			sb.append(" </body> ").append("\n");
			sb.append(" </html> ").append("\n");
		} catch (JSONException e) {
			e.printStackTrace();
		}
			
		return sb.toString();
	}
	
	//이사 요청자료 제출 메일
	public void sendMailDataRequestSubmission(int reqNo) throws Exception{
			
		JSONObject info = new JSONObject();
		DmsSendMailDAO dao = new DmsSendMailDAO();
		
		info = dao.getRequestInfo(reqNo);
		
		String mailContent = mailTemplateDataRequestSubmission(info);
		String mailSubject = info.getString("req_subject")+"' 요청자료 작성완료";
		
		MailUtil mail = new MailUtil();
		mail.send(sendMailAdd, "sucktolha@naver.com", mailSubject, mailContent);
//		mail.send(info.getEMAIL(), receiveMailList,mailSubject, mailContent);
	}
		
	//이사 요청자료 제출 메일 Template
	public String mailTemplateDataRequestSubmission(JSONObject info){
		StringBuffer sb = new StringBuffer();
		
		try{
			sb.append(" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> ").append("\n");
			sb.append(" <html xmlns='http://www.w3.org/1999/xhtml'> ").append("\n");
			sb.append(" <head> ").append("\n");
			sb.append(" <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> ").append("\n");
			sb.append(" <title>이사회업무관리시스템</title> ").append("\n");
			sb.append(" </head> ").append("\n");
			sb.append(" <body> ").append("\n");
			sb.append(" <div style='width: 500px; border-style: solid; border-width: 1px; border-color: #BBB;'> ").append("\n");
			sb.append(" 	<table width='100%' border='0'> ").append("\n");
			sb.append(" 		<tr  height='24px'> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 			<td colspan='2'></td> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB; padding-right: 5px;'>▣</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr> ").append("\n");
			sb.append(" 			<td colspan='4' style='font-family: 맑은고딕; font-size: 18px; font-weight: bolder; text-align: center;'> ").append("\n");
			sb.append(" 				요청자료 제출 ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr  height='20px'> ").append("\n");
			sb.append(" 			<td colspan='4'> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='30px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
			sb.append(" 				<p>"+info.getString("ko_name")+" 이사님께서 "+info.getString("req_subject")+"에 대해서 요청하신 자료 작성하였습니다.</p> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='30px;'> ").append("\n");
			sb.append(" 			<td colspan='4'> ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
			sb.append(" 				"+info.getString("req_subject")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 이 &nbsp;사 명 : "+info.getString("ko_name")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 관련안건 : "+info.getString("item_name")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 담 &nbsp;당 자 : "+info.getString("charge_user_nm")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='18px;'> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 			<td width='3px'></td> ").append("\n");
			sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
			sb.append(" 				<span style='color:#6699FF'>◈</span> 담당부서 : "+info.getString("charge_dept_nm")+" ").append("\n");
			sb.append(" 			</td> ").append("\n");
			sb.append(" 			<td width='24px'></td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 		<tr height='24px'> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 			<td colspan='2'></td> ").append("\n");
			sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
			sb.append(" 		</tr> ").append("\n");
			sb.append(" 	</table> ").append("\n");
			sb.append(" </div> ").append("\n");
			sb.append(" </body> ").append("\n");
			sb.append(" </html> ").append("\n");
		} catch (JSONException e) {
			e.printStackTrace();
		}
		
		return sb.toString();
	}
	
	//추진현황 요청 메일
		public void sendMailPropelPresentRequest(int propelNo, String deptCd) throws Exception{
			
			JSONObject info = new JSONObject();
			JSONArray jsa = new JSONArray();
			DmsSendMailDAO dao = new DmsSendMailDAO();
			
			info = dao.getPropelPresentInfo(propelNo);
			jsa = dao.getSendMailAddressList(deptCd);			//이사요청자료 요청할 부서원들의 메일 주소 정보를 가져옴
			StringBuffer mailTo = new StringBuffer("");
			
			//이사요청자료 요청할 부서원들의 메일 주소
			for(int i=0; i<jsa.length(); i++){
				JSONObject mailList = new JSONObject();
				mailList = jsa.getJSONObject(i);
				
				mailTo.append(mailList.getString("email")).append(",");
			}
			mailTo.substring(0, mailTo.length()-1);
			
			String mailContent = mailTemplatePropelPresent(info);
			String mailSubject = info.getString("item_name")+"' 추진현황 작성 요청";
			
			MailUtil mail = new MailUtil();
			mail.send(sendMailAdd, "sucktolha@naver.com", mailSubject, mailContent);
//			mail.send(sendMailAdd, mailTo.toString(), mailSubject, mailContent);
		}
		
		//추진현황 요청 메일 Template
		public String mailTemplatePropelPresent(JSONObject info){
			StringBuffer sb = new StringBuffer();
			
			try{
				sb.append(" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> ").append("\n");
				sb.append(" <html xmlns='http://www.w3.org/1999/xhtml'> ").append("\n");
				sb.append(" <head> ").append("\n");
				sb.append(" <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> ").append("\n");
				sb.append(" <title>이사회업무관리시스템</title> ").append("\n");
				sb.append(" </head> ").append("\n");
				sb.append(" <body> ").append("\n");
				sb.append(" <div style='width: 500px; border-style: solid; border-width: 1px; border-color: #BBB;'> ").append("\n");
				sb.append(" 	<table width='100%' border='0'> ").append("\n");
				sb.append(" 		<tr  height='24px'> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
				sb.append(" 			<td colspan='2'></td> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB; padding-right: 5px;'>▣</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr> ").append("\n");
				sb.append(" 			<td colspan='4' style='font-family: 맑은고딕; font-size: 18px; font-weight: bolder; text-align: center;'> ").append("\n");
				sb.append(" 				추진현황 요청 ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr  height='20px'> ").append("\n");
				sb.append(" 			<td colspan='4'> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
				sb.append(" 				<p>'"+info.getString("item_name")+"' 안건에 대해서 추진현황을 작성해 주시기 바랍니다.</p> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td colspan='4'> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
				sb.append(" 				"+info.getString("item_name")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td width='3px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
				sb.append(" 				<span style='color:#6699FF'>◈</span> 의결결과 : "+info.getString("code_name")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td width='3px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
				sb.append(" 				<span style='color:#6699FF'>◈</span> 담당부서 : "+info.getString("charge_dept_nm")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td width='3px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
				sb.append(" 				<span style='color:#6699FF'>◈</span> 마 &nbsp;감 일 : "+info.getString("end_date")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='24px'> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
				sb.append(" 			<td colspan='2'></td> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 	</table> ").append("\n");
				sb.append(" </div> ").append("\n");
				sb.append(" </body> ").append("\n");
				sb.append(" </html> ").append("\n");
			} catch (JSONException e) {
				e.printStackTrace();
			}
			
			return sb.toString();
		}
		
		//추진현황 제출 메일
		public void sendMailPropelPresentSubmission(int propelNo) throws Exception{
				
			JSONObject info = new JSONObject();
			DmsSendMailDAO dao = new DmsSendMailDAO();
			
			info = dao.getPropelPresentInfo(propelNo);
			
			String mailContent = mailTemplatePropelPresentSubmission(info);
			String mailSubject = info.getString("item_name")+"' 추진현황 작성완료";
			
			MailUtil mail = new MailUtil();
			mail.send(sendMailAdd, "sucktolha@naver.com", mailSubject, mailContent);
//			mail.send(info.getEMAIL(), receiveMailList,mailSubject, mailContent);
		}
			
		//추진현황 제출 메일 Template
		public String mailTemplatePropelPresentSubmission(JSONObject info){
			StringBuffer sb = new StringBuffer();
			
			try{
				sb.append(" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> ").append("\n");
				sb.append(" <html xmlns='http://www.w3.org/1999/xhtml'> ").append("\n");
				sb.append(" <head> ").append("\n");
				sb.append(" <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> ").append("\n");
				sb.append(" <title>이사회업무관리시스템</title> ").append("\n");
				sb.append(" </head> ").append("\n");
				sb.append(" <body> ").append("\n");
				sb.append(" <div style='width: 500px; border-style: solid; border-width: 1px; border-color: #BBB;'> ").append("\n");
				sb.append(" 	<table width='100%' border='0'> ").append("\n");
				sb.append(" 		<tr  height='24px'> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
				sb.append(" 			<td colspan='2'></td> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB; padding-right: 5px;'>▣</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr> ").append("\n");
				sb.append(" 			<td colspan='4' style='font-family: 맑은고딕; font-size: 18px; font-weight: bolder; text-align: center;'> ").append("\n");
				sb.append(" 				추진현황 제출 ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr  height='20px'> ").append("\n");
				sb.append(" 			<td colspan='4'> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
				sb.append(" 				<p>'"+info.getString("item_name")+"' 안건에 대해서 추진현황을 작성하였습니다.</p> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td colspan='4'> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
				sb.append(" 				"+info.getString("item_name")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td width='3px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
				sb.append(" 				<span style='color:#6699FF'>◈</span> 의결결과 : "+info.getString("code_name")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td width='3px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
				sb.append(" 				<span style='color:#6699FF'>◈</span> 담 &nbsp;당 자 : "+info.getString("charge_user_nm")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td width='3px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
				sb.append(" 				<span style='color:#6699FF'>◈</span> 담당부서 : "+info.getString("charge_dept_nm")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='24px'> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
				sb.append(" 			<td colspan='2'></td> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 	</table> ").append("\n");
				sb.append(" </div> ").append("\n");
				sb.append(" </body> ").append("\n");
				sb.append(" </html> ").append("\n");
			} catch (JSONException e) {
				e.printStackTrace();
			}
			
			return sb.toString();
		}
		
		//의결결과 제출 메일
		public void sendMailItemResult(int itemNo) throws Exception{
				
			JSONObject info = new JSONObject();
			DmsSendMailDAO dao = new DmsSendMailDAO();
			
			info = dao.getItemResultInfo(itemNo);
			
			ArrayList<File> attFile = new ArrayList<File>();
			ArrayList<String> attFileNm = new ArrayList<String>();
			File dFile1 = new File("C:/KOGAS/dmsWeb/WebContent/upload/bd_decide/" + info.getString("real_att_file").substring(info.getString("real_att_file").lastIndexOf("/")));
			File pFile1 = new File("C:/KOGAS/dmsWeb/WebContent/upload/bd_porceedings/" + info.getString("real_proceed_att_file").substring(info.getString("real_proceed_att_file").lastIndexOf("/")));
			
			attFile.add(dFile1);
			attFile.add(pFile1);
			attFileNm.add(info.getString("display_att_file"));
			attFileNm.add(info.getString("display_proceed_att_file"));
			String mailContent = mailTemplateItemResult(info);
			String mailSubject = info.getString("item_name")+"' 의결결과 통보";
			
			MailUtil mail = new MailUtil();
			mail.send(sendMailAdd, "sucktolha@naver.com", mailSubject, mailContent, attFile, attFileNm);
//					mail.send(info.getEMAIL(), receiveMailList,mailSubject, mailContent);
		}
		
		//의결결과 제출 메일 Template
		public String mailTemplateItemResult(JSONObject info){
			StringBuffer sb = new StringBuffer();
			
			try{
				sb.append(" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> ").append("\n");
				sb.append(" <html xmlns='http://www.w3.org/1999/xhtml'> ").append("\n");
				sb.append(" <head> ").append("\n");
				sb.append(" <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> ").append("\n");
				sb.append(" <title>이사회업무관리시스템</title> ").append("\n");
				sb.append(" </head> ").append("\n");
				sb.append(" <body> ").append("\n");
				sb.append(" <div style='width: 500px; border-style: solid; border-width: 1px; border-color: #BBB;'> ").append("\n");
				sb.append(" 	<table width='100%' border='0'> ").append("\n");
				sb.append(" 		<tr  height='24px'> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
				sb.append(" 			<td colspan='2'></td> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB; padding-right: 5px;'>▣</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr> ").append("\n");
				sb.append(" 			<td colspan='4' style='font-family: 맑은고딕; font-size: 18px; font-weight: bolder; text-align: center;'> ").append("\n");
				sb.append(" 				의결결과 통보 ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr  height='20px'> ").append("\n");
				sb.append(" 			<td colspan='4'> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
				sb.append(" 				<p>제 "+ info.getInt("bd_no") + "회 " + info.getString("gubun_name") + " " + info.getString("bd_name") +  "에 부의한 아건이 아래와 같이 의결 되었음을 통보합니다.</p> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='30px;'> ").append("\n");
				sb.append(" 			<td colspan='4'> ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td colspan='2' style='font-family: 맑은고딕;font-size: 12px;font-weight: bolder;'> ").append("\n");
				sb.append(" 				제 "+ info.getInt("bd_no") + "회 " + info.getString("gubun_name") + " " + info.getString("bd_name")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td width='3px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
				sb.append(" 				<span style='color:#6699FF'>◈</span> 의안번호 : "+info.getInt("col")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td width='3px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
				sb.append(" 				<span style='color:#6699FF'>◈</span> 의 &nbsp;안 명 : "+info.getString("item_name")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='18px;'> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 			<td width='3px'></td> ").append("\n");
				sb.append(" 			<td style='font-family: 맑은고딕;font-size: 12px;'> ").append("\n");
				sb.append(" 				<span style='color:#6699FF'>◈</span> 의결결과 : "+info.getString("item_result")+" ").append("\n");
				sb.append(" 			</td> ").append("\n");
				sb.append(" 			<td width='24px'></td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 		<tr height='24px'> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
				sb.append(" 			<td colspan='2'></td> ").append("\n");
				sb.append(" 			<td align='center' width='24px' style='font-family: 맑은고딕; font-size: 12px; font-weight: bolder; color:#BBB'>▣</td> ").append("\n");
				sb.append(" 		</tr> ").append("\n");
				sb.append(" 	</table> ").append("\n");
				sb.append(" </div> ").append("\n");
				sb.append(" </body> ").append("\n");
				sb.append(" </html> ").append("\n");
			} catch (JSONException e) {
				e.printStackTrace();
			}
			
			return sb.toString();
		}
}
